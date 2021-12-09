<?php

use App\Models\User;
use Illuminate\Support\Arr;

if (!function_exists('random_ts_id')) {
    function random_ts_id()
    {
        $technical_ids = User::select('id')->where('user_type', 'technical_support')->get();

        foreach ($technical_ids as $ts) {
            $ids[] = $ts->id;
        }

        return Arr::random($ids);
    }
}
