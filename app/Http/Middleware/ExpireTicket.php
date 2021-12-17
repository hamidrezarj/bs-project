<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TicketAnswer;
use App\Models\Ticket;

use Carbon\Carbon;
use Closure;

class ExpireTicket
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $model)
    {
        $now = Carbon::now()->toDateTimeString();

        // if ($model == Ticket::class)
        // {
        $result = Ticket::where('status', 'open')
                    ->where('expire_date', '<', $now)
                    ->update([
                        'status' => 'failed'
                    ]);
        // }
        // elseif ($model == TicketAnswer::class)
        // {
        //     $result = Auth::user()->ticket_answers()
        //             ->join('tickets', 'ticket_answers.ticket_id', '=', 'tickets.id')
        //             ->where('tickets.status', 'open')
        //             ->whereRaw('TIMESTAMPDIFF(MINUTE, tickets.created_at , ?) > ?', [$now, 10])
        //             ->update([
        //                 'status' => 'failed'
        //             ]);
        // }

        
        return $next($request);
    }
}
