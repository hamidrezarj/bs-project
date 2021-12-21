<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SupportsExport;
use App\Exports\TicketAnswersExport;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return Auth::user();
    }

    public function getReport(Request $request, User $support)
    {
        if($support->roles()->first()->name != 'technical_support')
        {
            return response()->json([
                'status' => 403,
                'message' => 'access to the requested resource is forbidden',
            ], 403);
        }

        $fileName = $support->full_name. '.xlsx';

        return Excel::download(new SupportsExport($support->id), $fileName);
    }
}
