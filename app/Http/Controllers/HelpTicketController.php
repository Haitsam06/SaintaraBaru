<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHelpTicketRequest;
use App\Services\HelpTicketService;
use Illuminate\Http\RedirectResponse;

class HelpTicketController extends Controller
{
    public function __construct(
        private HelpTicketService $service
    ) {}

    public function store(StoreHelpTicketRequest $request): RedirectResponse
    {
        $this->service->create(
            $request->validated(),
            $request->user()->id
        );

        return back()->with('success', 'Tiket bantuan terkirim.');
    }
}
