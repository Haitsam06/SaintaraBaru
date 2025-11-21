<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InstansiProfileController extends Controller
{
    // Tampilkan form profil instansi
    public function edit(Request $request): Response
    {
        // pastikan di User model ada relasi instansi()
        $instansi = $request->user()->instansi;

        return Inertia::render('Instansi/Profile', [
            'instansi' => $instansi,
        ]);
    }

    // Simpan perubahan profil instansi
    public function update(Request $request)
    {
        $instansi = $request->user()->instansi;

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'logo'    => ['nullable', 'image', 'max:2048'],
        ]);

        // mapping field form ke kolom tabel instansis
        $instansi->nama_instansi   = $validated['name'];
        $instansi->email           = $validated['email'] ?? null;
        $instansi->no_telp         = $validated['phone'] ?? null;
        $instansi->website         = $validated['website'] ?? null;
        $instansi->alamat_instansi = $validated['address'] ?? null;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $instansi->logo = $path;
        }

        $instansi->save();

        return back()->with('success', 'Profil instansi berhasil diperbarui.');
    }
}
