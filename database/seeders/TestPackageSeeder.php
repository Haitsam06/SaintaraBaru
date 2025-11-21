<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestPackage;

class TestPackageSeeder extends Seeder
{
    public function run(): void
    {
        TestPackage::updateOrCreate(
            ['slug' => 'tes-karakter-personal'],
            [
                'title'       => 'Tes Karakter Personal',
                'description' => 'Analisis mendalam 9 tipe karakter untuk individu.',
                'token_cost'  => 1,
                'type'        => 'personal',
            ]
        );

        TestPackage::updateOrCreate(
            ['slug' => 'tes-karakter-tim'],
            [
                'title'       => 'Tes Karakter Tim',
                'description' => 'Melihat dinamika tim dan peta karakter dalam 1 grup.',
                'token_cost'  => 5,
                'type'        => 'team',
            ]
        );

        TestPackage::updateOrCreate(
            ['slug' => 'tes-gift'],
            [
                'title'       => 'Tes Gift (Hadiah)',
                'description' => 'Membuat voucher tes yang bisa dibagikan sebagai hadiah.',
                'token_cost'  => 1,
                'type'        => 'gift',
            ]
        );
    }
}
