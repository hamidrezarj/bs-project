<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ticket;
class TicketMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $id = last(request()->segments());
        $ticket = Ticket::find($id);

        if($ticket->user->id != $request->user()->id)   
            abort(403, 'Forbidden');
        return $next($request);
    }
}
