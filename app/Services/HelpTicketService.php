<?php

namespace App\Services;

use App\Models\HelpTicket;

class HelpTicketService
{
    public function __construct(
        private HelpTicket $helpTicket
    ) {}

    public function create(array $data, int $userId): HelpTicket
    {
        return $this->helpTicket->create([
            'user_id' => $userId,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status'  => 'open',
        ]);
    }
}
