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

        $result = Ticket::where('status_id', 1)
                    ->where('expire_date', '<', $now)
                    ->update([
                        'status' => 'failed',
                        'status_id' => 4
                    ]);

        return $next($request);
    }
}
