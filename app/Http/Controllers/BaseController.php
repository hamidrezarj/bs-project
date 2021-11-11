<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class BaseController extends Controller
{
    public function index(Request $request)
    {
        return view('index', ['name' => 'Hamidreza']);
    }

    public function getTime(Request $request)
    {
        $now = Carbon::now();
        echo($now);
    }
}
