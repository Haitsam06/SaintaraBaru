<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->guard('customer')->user()->id_customer;
        $customer = Customer::where('id_customer', $user)->first();

        $validated = $request->validate([
            'subject' => 'required|string',
            'category' => 'required|string',
            'description' => 'required|string',
        ]);

        $validated['customer_id'] = $customer->id_customer;
        try {
            SupportTicket::create($validated);

            return back()->with('success', 'Berhasil meminta bantuan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal meminta bantuan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
