<?php

namespace App\Services;

use App\Models\TestResult;
use App\Models\VoucherBatch;

class DashboardService
{
    public function getInstansiDashboardData(int $instansiId): array
    {
        // total peserta: email unik per instansi
        $totalParticipants = TestResult::where('instansi_id', $instansiId)
            ->distinct('email')
            ->count('email');

        // hasil tes terbaru
        $latestResults = TestResult::where('instansi_id', $instansiId)
            ->latest('tgl_tes')
            ->limit(10)
            ->get()
            ->map(function (TestResult $r, int $index): array {
                return [
                    'no'     => $index + 1,
                    'nama'   => $r->nama,
                    'devisi' => $r->devisi,
                    'tgl'    => $r->tgl_tes?->format('d/m/Y') ?? '',
                    'email'  => $r->email,
                ];
            })
            ->values();

        // voucher batch terbaru
        $vouchers = VoucherBatch::where('instansi_id', $instansiId)
            ->latest('tanggal')
            ->limit(10)
            ->get()
            ->map(function (VoucherBatch $v): array {
                return [
                    'kode' => $v->kode,
                    'tgl'  => $v->tanggal?->format('d/m/Y') ?? '',
                ];
            })
            ->values();

        // laporan terbaru 7 hari terakhir
        $latestReportCount = TestResult::where('instansi_id', $instansiId)
            ->where('tgl_tes', '>=', now()->subDays(7))
            ->count();

        return [
            'summary' => [
                'total_participants' => $totalParticipants,
                'latest_reports'     => $latestReportCount,
            ],
            'hasilTes' => $latestResults,
            'vouchers' => $vouchers,
        ];
    }
}
