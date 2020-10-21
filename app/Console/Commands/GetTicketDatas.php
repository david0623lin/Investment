<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\ParserTicket;

class GetTicketDatas extends Command
{
    protected $signature = 'ticket:info {ticket_id?}';
    protected $description = 'Command description';

    public function handle()
    {
        $ticket_id = $this->argument('ticket_id');
        $result = ParserTicket::get($ticket_id);

    }
}
