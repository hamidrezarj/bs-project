<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IsInOperatingHours
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
        $now = Carbon::now();
        $open = new Carbon('09:00:00');
        $end = new Carbon('23:59:00');

        if(!$now->between($open, $end, true)){
            return response()->json([
                'status' => 499,
                'message' => 'درخواست دریافت شده خارج از ساعت اداری می باشد.',
            ], 499);
        }
        
        return $next($request);
    }
}
