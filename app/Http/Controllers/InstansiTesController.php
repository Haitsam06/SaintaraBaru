<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\TestPackage;
use App\Models\Golongan;
use App\Models\PesertaTes;
use App\Services\KarakterGenerator;

class InstansiTesController extends Controller
{
    /**
     * Service untuk generate trait karakter peserta.
     */
    protected KarakterGenerator $karakterGenerator;

    public function __construct(KarakterGenerator $karakterGenerator)
    {
        $this->karakterGenerator = $karakterGenerator;
    }

    /**
     * Halaman "Daftar Tes Karakter" untuk instansi.
     */
    public function index()
    {
        // Ambil paket tes dari DB
        $tests = TestPackage::select('id', 'slug', 'title', 'description', 'token_cost', 'type')->get();

        // Summary masih dummy (nanti bisa diambil dari token/transaksi beneran)
        $summary = [
            'token_tersisa'         => 150,
            'tes_selesai_bulan_ini' => 42,
        ];

        return Inertia::render('Instansi/DaftarTes', [
            'tests'   => $tests,
            'summary' => $summary,
        ]);
    }

    /**
     * Upload Excel + peserta manual, simpan ke peserta_tes,
     * dan generate karakter menggunakan KarakterGenerator.
     *
     * Excel:
     *  A: nama_lengkap
     *  B: nama_panggilan
     *  C: email
     *  D: no_telp
     *  E: negara
     *  F: kota
     *  G: jenis_kelamin  (boleh "L", "P", "Laki-laki", "Perempuan")
     *  H: golongan_darah
     *  I: tanggal_lahir
     *
     * Input manual:
     *  participants[0][full_name], nickname, email, phone, country, city, gender, blood_type
     */
    public function uploadExcel(Request $request)
    {
        $validated = $request->validate([
            'test_package_id'            => 'required|exists:test_packages,id',
            'nama_golongan'              => 'required|string|max:255',
            'file'                       => 'nullable|file|mimes:xlsx,xls',
            'participants'               => 'nullable|array',
            'participants.*.full_name'   => 'nullable|string|max:255',
            'participants.*.nickname'    => 'nullable|string|max:255',
            'participants.*.email'       => 'nullable|email',
            'participants.*.phone'       => 'nullable|string|max:50',
            'participants.*.country'     => 'nullable|string|max:100',
            'participants.*.city'        => 'nullable|string|max:100',
            'participants.*.gender'      => 'nullable|string|max:50',
            'participants.*.blood_type'  => 'nullable|string|max:5',
        ]);

        $hasFile       = $request->hasFile('file');
        $manualPeserta = $validated['participants'] ?? [];

        // Minimal harus ada salah satu: Excel atau manual
        if (! $hasFile && empty($manualPeserta)) {
            return back()
                ->withErrors([
                    'participants' => 'Isi minimal satu peserta manual atau upload file Excel.',
                ])
                ->withInput();
        }

        // Pastikan paket tes ada
        $testPackage = TestPackage::findOrFail($validated['test_package_id']);

        // Buat Golongan (batch) peserta
        $golongan = Golongan::create([
            'test_package_id' => $testPackage->id,
            'nama'            => $validated['nama_golongan'],
        ]);

        /*
         |-------------------------------------------------------------
         | 1. Peserta dari file Excel (jika ada)
         |-------------------------------------------------------------
         */
        if ($hasFile) {
            $path        = $request->file('file')->getRealPath();
            $spreadsheet = IOFactory::load($path);
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray(null, true, true, true);

            foreach ($rows as $index => $row) {
                // Baris pertama = header → skip
                if ($index === 1) {
                    continue;
                }

                // Skip baris kosong (tidak ada nama & email)
                if (empty($row['A']) && empty($row['C'])) {
                    continue;
                }

                // Normalisasi jenis kelamin dari Excel (L/P/Laki-laki/Perempuan)
                $gender = $this->normalizeGender($row['G'] ?? null);

                $peserta = PesertaTes::create([
                    'golongan_id'     => $golongan->id,
                    'test_package_id' => $testPackage->id,
                    'tipe_akun'       => 'personal',
                    'nama_lengkap'    => $row['A'] ?? '',
                    'nama_panggilan'  => $row['B'] ?? null,
                    'email'           => $row['C'] ?? null,
                    'no_telp'         => $row['D'] ?? null,
                    'negara'          => $row['E'] ?? null,
                    'kota'            => $row['F'] ?? null,
                    'devisi'          => $row['F'] ?? null,
                    'jenis_kelamin'   => $gender,
                    'golongan_darah'  => $row['H'] ?? null,
                    'tanggal_lahir'   => $row['I'] ?? null,
                    'status'          => 'belum',
                ]);

                $this->karakterGenerator->generateForPeserta($peserta);
            }
        }

        /*
         |-------------------------------------------------------------
         | 2. Peserta dari input manual (jika ada)
         |-------------------------------------------------------------
         */
        foreach ($manualPeserta as $mp) {
            // Skip jika baris benar-benar kosong
            if (empty($mp['full_name']) && empty($mp['email'])) {
                continue;
            }

            // Normalisasi jenis kelamin dari form (biasanya "L" / "P" setelah kita ubah frontend)
            $gender = $this->normalizeGender($mp['gender'] ?? null);

            $peserta = PesertaTes::create([
                'golongan_id'     => $golongan->id,
                'test_package_id' => $testPackage->id,
                'tipe_akun'       => 'personal',
                'nama_lengkap'    => $mp['full_name'] ?? '',
                'nama_panggilan'  => $mp['nickname'] ?? null,
                'email'           => $mp['email'] ?? null,
                'no_telp'         => $mp['phone'] ?? null,
                'negara'          => $mp['country'] ?? null,
                'kota'            => $mp['city'] ?? null,
                'devisi'          => $mp['city'] ?? null,
                'jenis_kelamin'   => $gender,
                'golongan_darah'  => $mp['blood_type'] ?? null,
                'tanggal_lahir'   => null, // bisa ditambah ke form manual kalau mau
                'status'          => 'belum',
            ]);

            $this->karakterGenerator->generateForPeserta($peserta);
        }

        return redirect()
            ->route('instansi.hasil')
            ->with('success', 'Peserta (Excel & manual) berhasil diproses dan hasil karakter dibuat.');
    }

    /**
     * Halaman "Hasil Tes" instansi.
     */
    public function hasil()
    {
        $peserta = PesertaTes::with(['golongan', 'traits'])
            ->latest()
            ->get();

        $results = $peserta->map(function ($p) {
            return [
                'id'       => $p->id,
                'nama'     => $p->nama_lengkap,
                'email'    => $p->email,
                'devisi'   => $p->devisi ?? $p->kota ?? '-',
                'tgl'      => optional($p->created_at)->format('d M Y'),
                // gabungkan semua trait karakter, misalnya: "Pemalu, Introvert"
                'karakter' => $p->traits->pluck('nama')->implode(', ') ?: '-',
            ];
        });

        return Inertia::render('Instansi/Hasil', [
            'results' => $results,
        ]);
    }

    /**
     * Normalisasi string jenis kelamin ke format yang disimpan di DB.
     *
     *  - "L", "l", "laki-laki", "male"  => "L"
     *  - "P", "p", "perempuan", "female" => "P"
     */
    protected function normalizeGender(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $g = strtolower(trim($value));

        if (in_array($g, ['l', 'laki-laki', 'male', 'pria'], true)) {
            return 'L';
        }

        if (in_array($g, ['p', 'perempuan', 'female', 'wanita'], true)) {
            return 'P';
        }

        return null; // jika tidak dikenali, simpan null
    }
}
