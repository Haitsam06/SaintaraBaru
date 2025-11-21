<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

// IMPORT MODEL
use App\Models\TestPackage;
use App\Models\Golongan;

// IMPORT SERVICE & IMPORT-CLASS
use App\Services\KarakterGenerator;
use App\Imports\PesertaTesImport;

class TesController extends Controller
{
    public function index()
    {
        $tests = TestPackage::all();

        return Inertia::render('Instansi/Tes', [
            'tests' => $tests,
            'summary' => [
                'token_tersisa' => 150,
                'tes_selesai_bulan_ini' => 42,
            ],
        ]);
    }

    public function uploadExcel(Request $request, KarakterGenerator $karakterGenerator)
    {
        $request->validate([
            'test_package_id' => 'required|exists:test_packages,id',
            'nama_golongan'   => 'required|string|max:255',
            'file'            => 'required|file|mimes:xlsx,xls',
        ]);

        $testPackage = TestPackage::findOrFail($request->test_package_id);

        $golongan = Golongan::create([
            'test_package_id' => $testPackage->id,
            'nama'            => $request->nama_golongan,
        ]);

        Excel::import(new PesertaTesImport($golongan, $karakterGenerator), $request->file('file'));

        return redirect()->back()->with(
            'success',
            'Data peserta & hasil karakter berhasil di-generate dari biodata.'
        );
    }
}
