<?php

namespace App\Services;

use App\Models\PesertaTes;
use App\Models\TraitKarakter;
use Carbon\Carbon;

class KarakterGenerator
{
    public function generateForPeserta(PesertaTes $peserta): void
    {
        $slugs = [];

        // 1. Contoh rule berdasarkan golongan darah
        switch (strtoupper((string) $peserta->golongan_darah)) {
            case 'A':
                $slugs[] = 'pemalu';
                $slugs[] = 'introvert';
                break;
            case 'B':
                $slugs[] = 'pemarah';
                $slugs[] = 'extrovert';
                break;
            case 'O':
                $slugs[] = 'extrovert';
                break;
            case 'AB':
                $slugs[] = 'introvert';
                $slugs[] = 'extrovert';
                break;
        }

        // 2. Contoh rule numerologi sederhana dari tanggal lahir
        if ($peserta->tanggal_lahir) {
            $lifePath = $this->hitungLifePath($peserta->tanggal_lahir);

            // ini cuma contoh mapping, silakan modif sesuai “ilmu”mu :)
            if (in_array($lifePath, [1, 8], true)) {
                $slugs[] = 'pemarah';
            }

            if (in_array($lifePath, [2, 7], true)) {
                $slugs[] = 'pemalu';
                $slugs[] = 'introvert';
            }

            if (in_array($lifePath, [3, 5], true)) {
                $slugs[] = 'extrovert';
            }
        }

        // 3. Contoh rule tambahan dari jenis kelamin (opsional)
        // if ($peserta->jenis_kelamin === 'P') { ... }

        // Hapus duplikat
        $slugs = array_values(array_unique($slugs));

        if (empty($slugs)) {
            // jika tidak ada yang cocok, bisa kasih default atau kosong
            return;
        }

        // Ambil id trait dari slug
        $traitIds = TraitKarakter::whereIn('slug', $slugs)->pluck('id')->toArray();

        if (!empty($traitIds)) {
            $peserta->traits()->sync($traitIds);
        }
    }

    /**
     * Hitung "life path number" sederhana dari tanggal lahir (YYYY-MM-DD)
     * contoh: 1990-01-23 -> 1+9+9+0+0+1+2+3 = 25 -> 2+5 = 7
     */
    protected function hitungLifePath(string $tanggal): int
    {
        try {
            $date = Carbon::parse($tanggal);
        } catch (\Exception $e) {
            return 0;
        }

        $digits = str_split($date->format('Ymd'));
        $sum = array_sum(array_map('intval', $digits));

        while ($sum > 9) {
            $sum = array_sum(str_split((string) $sum));
        }

        return $sum;
    }
}
