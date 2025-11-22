<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TraitKarakter;

class TraitKarakterSeeder extends Seeder
{
    public function run(): void
    {
        $traits = [
            ['slug' => 'pemarah',   'nama' => 'Pemarah'],
            ['slug' => 'pemalu',    'nama' => 'Pemalu'],
            ['slug' => 'introvert', 'nama' => 'Introvert'],
            ['slug' => 'extrovert', 'nama' => 'Extrovert'],
        ];

        foreach ($traits as $trait) {
            TraitKarakter::updateOrCreate(
                ['slug' => $trait['slug']],
                ['nama' => $trait['nama']]
            );
        }
    }
}
