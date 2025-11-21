<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Models\VoucherBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstansiDashboardController extends Controller
{
    /**
     * Dashboard utama instansi
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan user punya instansi
        if (!$user->instansi_id) {
            abort(403, "Anda tidak memiliki instansi yang terhubung.");
        }

        $instansiId = $user->instansi_id;

        /* ============================
         *  SUMMARY DATA
         * ============================ */

        // Total peserta (berdasarkan email unik)
        $totalParticipants = TestResult::where('instansi_id', $instansiId)
            ->distinct('email')
            ->count('email');

        // Laporan terbaru (7 hari terakhir)
        $latestReports = TestResult::where('instansi_id', $instansiId)
            ->whereDate('tgl_tes', '>=', now()->subDays(7))
            ->count();

        /* ============================
         *  HASIL TES (tabel kiri)
         * ============================ */

        $hasilTes = TestResult::where('instansi_id', $instansiId)
            ->latest('tgl_tes')
            ->limit(10)
            ->get()
            ->map(function ($row, $index) {
                return [
                    'no' => $index + 1,
                    'nama' => $row->nama,
                    'devisi' => $row->devisi ?? '-',
                    'tgl' => $row->tgl_tes ? $row->tgl_tes->format('d/m/Y') : '-',
                    'email' => $row->email,
                ];
            })
            ->values();

        /* ============================
         *  VOUCHERS (tabel kanan)
         * ============================ */

        $vouchers = VoucherBatch::where('instansi_id', $instansiId)
            ->latest('tanggal')
            ->limit(10)
            ->get()
            ->map(function ($v) {
                return [
                    'kode' => $v->kode,
                    'tgl' => $v->tanggal ? $v->tanggal->format('d/m/Y') : '-',
                ];
            })
            ->values();

        /* ============================
         *  KIRIM KE FRONTEND INERTIA
         * ============================ */

        return inertia('Instansi/dashboard', [
            'summary' => [
                'total_participants' => $totalParticipants,
                'latest_reports' => $latestReports,
            ],
            'hasilTes' => $hasilTes,
            'vouchers' => $vouchers,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
