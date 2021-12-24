<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketAnswer;
use Carbon\Carbon;

class BaseController extends Controller
{
    public function show()
    {
        if (Auth::user()->cannot('show_profile')) {
            return response()->json([
                'status' => 403,
                'message' => 'access to the requested resource is forbidden'
            ], 403);
        }

        return response()->json([
            'status' => 200,
            'data' => Auth::user()
        ]);
    }
}
