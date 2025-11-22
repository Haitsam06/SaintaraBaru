<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan seeder yang benar
        $this->call([
            RolesSeeder::class,           // untuk tabel roles
            TestPackageSeeder::class,     // untuk paket tes (personal, tim, gift)
            TraitKarakterSeeder::class,   // untuk karakter (pemarah, pemalu, dst)
        ]);
    }
}
