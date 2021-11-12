<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketAnswer;

class BaseController extends Controller
{
    public function index(Request $request)
    {
        return view('index', ['name' => 'Hamidreza']);
    }

    public function temp(Request $request)
    {
        $ticket_answer = TicketAnswer::find(1);
        $ticket = Ticket::find(1);
        $ticket->ticket_answers()->save($ticket_answer);
        $ticket->status = 'answered';
        $ticket->save();
        // $ticket_answer->save();

        return $ticket_answer;
    }
}
