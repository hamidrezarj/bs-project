<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;

class TechnicalSupportController extends Controller
{
    public function index()
    {
        $support = Auth::user();
        $assigned_tickets = DB::table('tickets')
                              ->join('ticket_answers', 'tickets.id', '=', 'ticket_answers.ticket_id')
                              ->select('tickets.*')
                              ->where('ticket_answers.technical_id', $support->id)->where('status', 'open')
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
        
        $ticket_answer = $ticket->ticket_answer;
        $ticket_answer->description = $request->description;
        $ticket_answer->reply_date = Carbon::now()->toDateTimeString();
        $ticket_answer->save();

        $ticket->status = 'answered';
        $ticket->save();

        return redirect()->route('support.index');
        
    }
}
