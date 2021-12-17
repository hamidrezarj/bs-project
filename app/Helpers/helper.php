<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use App\Models\User;

if (!function_exists('getRandomSupport')) {
    function getRandomSupport()
    {
        $supports = getActiveSupports();
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

            if(Cache::has('user-is-online-'. $support->id))
            {
                $result[] = $support->id;
            }
        }

        return $result;
    }
}
