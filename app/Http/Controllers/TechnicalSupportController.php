<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
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
        Gate::authorize('details', $ticket->ticket_answer);

        return view('support.ticket', [
            'ticket' => $ticket
        ]);
    }

    public function replyTicket(Request $request, Ticket $ticket)
    {
        Gate::authorize('replyTicket', $ticket->ticket_answer);

        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
        ])->validate();
        
        $ticket_answer = $ticket->ticket_answer;
        $ticket_answer->description = $request->description;
        $ticket_answer->reply_date = Carbon::now()->toDateTimeString();
        $ticket_answer->save();

        $ticket->status = 'answered';
        $ticket->status_id = 2;
        $ticket->save();

        return redirect()->route('support.index');
    }

    public function activate()
    {
        $minutes = env('SESSION_LIFETIME', 480);
        $expire_at = Carbon::now()->add('minutes', $minutes);
        Cache::add('user-is-online-'. Auth::user()->id, true, $expire_at);

        assignPendingTicketsToSupport(Auth::user());

        return redirect()->route('support.index');
    }

    public function deactivate()
    {
        Cache::forget('user-is-online-'. Auth::user()->id);
        return redirect()->route('support.index');
    }
}
