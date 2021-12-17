<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $tickets = Auth()->user()->tickets()->orderBy('created_at', 'desc')->paginate(5)->withQueryString();
        return view('user.index', [
            'tickets' => $tickets,
            'user' => Auth::user(),
        ]);
    }

    public function show()
    {
        if (Auth::user()->cannot('show_profile')) {
            return response()->json([
                'status' => 403,
                'message' => 'access to the requested resource is forbidden'
            ], 403);
        }

        return response()->json([
            'status' => 200,
            'data' => Auth::user()
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

        ], [], [
            'course_name' => 'نام درس', 
            'course_id' => 'کد درس'
        ])->validate();

        $ticket = auth()->user()->tickets()->create($request->all());
        $ticket->status = 'open';
        $ticket->expire_date = Carbon::now()->addMinutes(5);
        $ticket->save();

        // assign ticket to a technical support.
        $ts_id = getRandomSupport();
        $technical_support = User::find($ts_id);
        $ticket_answer = $technical_support->ticket_answers()->create();
        $ticket->ticket_answer()->save($ticket_answer);
        
        return redirect()->route('user.index');
    }

    public function showTicketDetails(Request $request, Ticket $ticket)
    {
        return view('user.ticket', ['ticket' => $ticket]);
    }

    public function vote(Request $request, Ticket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'user_vote' => 'required',
        ], [
            'user_vote.required' => 'لطفا یکی از گزینه های نظرسنجی را انتخاب کنید.'
        ])->validate();

        $ticket_answer = $ticket->ticket_answer;
        $ticket_answer->user_vote = $request->user_vote;
        $ticket_answer->vote_date = Carbon::now()->toDateTimeString(); 
        $ticket_answer->save();

        $ticket->status = 'completed';
        $ticket->save();

        return redirect()->route('ticket.details', ['ticket' => $ticket])->with('status', 'نظرسنجی با موفقیت انجام شد.');
    }

    public function reloadCaptcha(Request $request)
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function temp()
    {
        return Auth::user()->roles()->first();
    }
}
