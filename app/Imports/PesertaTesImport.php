<?php

namespace App\Imports;

use App\Models\PesertaTes;
use App\Models\Golongan;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PesertaTesImport
{
    protected $file;
    protected $golongan;

    public function __construct($file, Golongan $golongan)
    {
        $this->file     = $file;
        $this->golongan = $golongan;
    }

    /**
     * Proses file Excel dan simpan ke database.
     */
    public function import()
    {
        // Load excel menggunakan PhpSpreadsheet
        $spreadsheet = IOFactory::load($this->file);
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, true);

        foreach ($rows as $index => $row) {

            // Skip header
            if ($index == 1) continue;

            // Skip baris kosong
            if (empty($row['A']) && empty($row['C'])) {
                continue;
            }

            PesertaTes::create([
                'golongan_id'    => $this->golongan->id,
                'tipe_akun'      => 'personal',

                'nama_lengkap'   => $row['A'] ?? '',
                'nama_panggilan' => $row['B'] ?? null,
                'email'          => $row['C'] ?? null,
                'no_telp'        => $row['D'] ?? null,
                'negara'         => $row['E'] ?? null,
                'kota'           => $row['F'] ?? null,

                'jenis_kelamin'  => $row['G'] ?? null,
                'golongan_darah' => $row['H'] ?? null,
                'tanggal_lahir'  => $row['I'] ?? null,

                'status'         => 'belum',
            ]);
        }

        return true;
    }
}
