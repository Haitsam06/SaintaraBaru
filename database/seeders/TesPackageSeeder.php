<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TesPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\TesPackage::create([
            'name' => 'Dasar',
            'description' => 'Untuk individu yang ingin mengenal diri',
            'price' => 150000,
            'report_count' => 10,
            'features' => ['Laporan 10 Karakter','Analisis Karakter Alami']
        ]);

        \App\Models\TesPackage::create([
            'name' => 'Standar',
            'description' => 'Untuk individu yang ingin mengenal diri lebih lanjut',
            'price' => 150000,
            'report_count' => 20,
            'features' => ['Laporan 20 Karakter','Analisis Karakter Alami']
        ]);

        \App\Models\TesPackage::create([
            'name' => 'Premium',
            'description' => 'Untuk individu yang ingin tahu lebih dalam tentang diri sendiri',
            'price' => 150000,
            'report_count' => 35,
            'features' => ['Laporan 35+ Karakter','Analisis Karakter Alami']
        ]);
    }
}