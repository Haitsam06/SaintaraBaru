<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Customer;

class ProfilePersonalController extends Controller
{
    public function index()
    {
        $user = auth()->guard('customer')->user()->id_customer;
        $customer = Customer::where('id_customer', $user)->first();
        return Inertia::render('Personal/Profile', [
            'customer' => $customer
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::guard('customer')->user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nama_panggilan' => 'nullable|string|max:50',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'negara' => 'nullable|string|max:50',
            'kota' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|string',
            'gol_darah' => 'nullable|string',
            'tgl_lahir' => 'nullable|date',
            'new_foto' => 'nullable|image|max:2048',
        ]);

        // Update data text
        $user->update($request->except('new_foto'));
        $userId = auth()->guard('customer')->user()->id_customer;
        $userData = Customer::where('id_customer', $userId)->first();
         if ($request->hasFile('new_foto')) {

            $file = $request->file('new_foto');
            $ext  = $file->getClientOriginalExtension();
            $filename = 'profile-' . date('Y-m-d') . '-' . time() . '.' . $ext;

            $file->storeAs('foto-customer', $filename, 'public');
            $user->foto = asset('storage/foto-customer/' . $filename);;
            $user->save();

            // HAPUS FOTO LAMA
            if ($userData && $userData->foto) {
                $oldFile = basename($userData->foto);
                $oldPath = storage_path('app/public/foto-customer/' . $oldFile);
                if (file_exists($oldPath)) unlink($oldPath);
            }
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
