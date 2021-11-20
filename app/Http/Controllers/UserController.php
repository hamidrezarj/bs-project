<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
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
        return view('user.ticket');
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
        
        return redirect()->route('index');
    }

    public function temp()
    {
        $user = User::where('id', 1)->first();
        return $user->created_at_fa;
    }
}
