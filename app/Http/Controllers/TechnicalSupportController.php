<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class TechnicalSupportController extends Controller
{
    public function index()
    {

        $user_id = Auth::user()->id;

        $assigned_tickets = DB::table('users')
                              ->join('ticket_answers', 'users.id', '=', 'ticket_answers.technical_id')
                              ->join('tickets', 'ticket_answers.ticket_id', '=', 'tickets.id')
                              ->select('tickets.*')
                              ->where('users.id', $user_id)
                              ->paginate(5);

        return view('support.index', [
            'tickets' => $assigned_tickets
        ]);
    }
}
