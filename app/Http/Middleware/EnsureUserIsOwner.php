<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketAnswer;

class EnsureUserIsOwner
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
        $id = last(request()->segments());        
        $ticket = Ticket::find($id);
    
        if($model == Ticket::class)
        {
            if($ticket->user->id != $request->user()->id)   
                abort(403);
        }
        elseif($model == TicketAnswer::class)
        {
            if($ticket->ticket_answer->technical_id != $request->user()->id)   
                abort(403);
        }

        return $next($request);
    }
}
