<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class InstansiAuthController extends Controller
{
    /**
     * Form register instansi.
     * (Kamu pakai halaman register.tsx yang sama, jadi cukup render login/register biasa.)
     */
    public function create()
    {
        return Inertia::render('auth/register');
    }

    /**
     * Proses register instansi.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'namaLengkap'           => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email|unique:instansis,email',
            'password'              => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',

            'noTelp'                => 'required|string|max:20',
            'negara'                => 'nullable|string|max:255',
            'kota'                  => 'nullable|string|max:255',
        ]);

        // Gabungkan negara + kota sebagai alamat sederhana
        $alamat = trim(($request->kota ?? '').' '.($request->negara ?? ''));

        // 1. Simpan instansi
        $instansi = Instansi::create([
            'nama_instansi' => $request->namaLengkap, // pakai nama lengkap sebagai nama instansi
            'no_instansi'   => null,
            'nama_owner'    => $request->namaLengkap,
            'email'         => $request->email,
            'no_telp'       => $request->noTelp,
            'website'       => null,
            'alamat'        => $alamat ?: '-',
        ]);

        // 2. Buat user instansi di tabel users
        $user = User::create([
            'name'        => $request->namaLengkap,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => 'instansi',
            'instansi_id' => $instansi->id_instansi,
        ]);

        // 3. Login otomatis
        Auth::login($user);

        // 4. Redirect ke dashboard instansi
        return redirect()->route('instansi.dashboard');
    }
}
