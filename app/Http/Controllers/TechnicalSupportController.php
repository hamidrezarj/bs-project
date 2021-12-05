<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TechnicalSupportController extends Controller
{
    public function index()
    {
        $support = Auth::user();
        $assigned_tickets = DB::table('users')
                              ->join('ticket_answers', 'users.id', '=', 'ticket_answers.technical_id')
                              ->join('tickets', 'ticket_answers.ticket_id', '=', 'tickets.id')
                              ->select('tickets.*')
                              ->where('users.id', $support->id)->where('status', 'open')
                              ->paginate(5);

        return view('support.index', [
            'support' => $support,
            'tickets' => $assigned_tickets
        ]);
    }

    public function ticketDetails(Request $request, Ticket $ticket)
    {
        return view('support.ticket', [
            'ticket' => $ticket
        ]);
    }

    public function replyTicket(Request $request, Ticket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',

        ])->validate();
        
        dd($request);
    }
}
