<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketAnswer;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $tickets = Auth()->user()->tickets()->orderBy('created_at', 'desc')->paginate(5)->withQueryString();
        return view('user.index', [
            'tickets' => $tickets,
        ]);
    }

    public function showTicketForm()
    {
        return view('user.ticket_form');
    }
    
    public function creatTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_name' => 'required|string',
            'course_id'   => 'required|digits:9',
            'description' => 'required',

        ])->validate();

        $ticket = auth()->user()->tickets()->create($request->all());
        $ticket->status = 'open';
        $ticket->save();

        // assign ticket to a technical support.
        $ts_id = random_ts_id();
        $technical_support = User::find($ts_id);
        $ticket_answer = $technical_support->ticket_answers()->create();
        $ticket->ticket_answer()->save($ticket_answer);
        
        return redirect()->route('index');
    }

    public function showTicketDetails(Request $request, Ticket $ticket)
    {
        return view('user.ticket', ['ticket' => $ticket]);
    }

    public function temp()
    {
        return random_ts_id();
    }
}
