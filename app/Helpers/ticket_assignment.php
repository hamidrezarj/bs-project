<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use App\Models\TicketAnswer;
use App\Models\User;

if (!function_exists('getRandomSupport')) {
    function getRandomSupport()
    {
        $supports = getActiveSupports();

        if (count($supports) == 0) {
            return 0;
        }

        $rand_idx = mt_rand(0, count($supports) - 1);
        return $supports[$rand_idx];
    }
}

if (!function_exists('getActiveSupports')) {
    function getActiveSupports()
    {
        $supports = User::where('user_type', 'technical_support')->get();
        $result = [];

        foreach ($supports as $support) {
            if (Cache::has('user-is-online-'. $support->id)) {
                $result[] = $support->id;
            }
        }

        return $result;
    }
}

if (!function_exists('assignPendingTicketToSupport')) {
    function assignPendingTicketsToSupport(User $user)
    {
        
        $updated_rows = TicketAnswer::join('tickets', 'ticket_answers.ticket_id', '=', 'tickets.id')
                             ->where('status', 'open')
                             ->where('technical_id', 0)
                             ->update([
                                 'technical_id' => $user->id,
                             ]);
                             
        return $updated_rows;
    }
}
