<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TesOrder;
use App\Models\TesPackage;
use Inertia\Inertia;

class TesOrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['package_id' => 'required|exists:tes_packages,id']);

        $order = TesOrder::create([
            'user_id' => auth()->id(),
            'package_id' => $request->package_id,
            'status' => 'pending',
        ]);

        // Jika kamu ingin langsung menandai start:
        // $order->update(['status' => 'started']);

        // Redirect ke halaman form tes (Inertia)
        return redirect()->route('personal.formTes', $order->id);
    }

    public function form($orderId)
    {
        $order = TesOrder::with('package')->findOrFail($orderId);

        // pastikan user hanya mengakses order miliknya
        if ($order->user_id !== auth()->id()) abort(403);

        return Inertia::render('Personal/FormTes', [
            'order' => $order,
            'package' => $order->package,
        ]);
    }

    // Simpan hasil tes
    public function submitResults(Request $request, $orderId)
    {
        $order = TesOrder::findOrFail($orderId);
        if ($order->user_id !== auth()->id()) abort(403);

        $data = $request->validate([
            'result_json' => 'required|array',
            'notes' => 'nullable|string',
        ]);

        $order->result()->create([
            'user_id' => auth()->id(),
            'result_json' => $data['result_json'],
            'notes' => $data['notes'] ?? null,
        ]);

        $order->update(['status' => 'completed']);

        return redirect()->route('personal.hasilTes', $order->id);
    }
}
