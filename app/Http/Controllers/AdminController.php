<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SupportsExport;
use App\Exports\TicketAnswersExport;
use App\Models\TicketAnswer;
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

        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date_format:Y-m-d',
            'to_date'   => 'required|date_format:Y-m-d',
        ], [], [
            'from_date' => 'از تاریخ',
            'to_date' => 'تا تاریخ'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 403,
                'message' => $validator->errors()
            ], 403);
        }
        
        $from_date = $request->from_date . " 00:00:00";
        $to_date = $request->to_date . " 23:59:59";

        $performanceMetric = TicketAnswer::where('technical_id', $support->id)
                                                ->whereNotNull('vote_id')
                                                ->selectRaw("sum(vote_id)/count(vote_id) as performance")
                                                ->first();

        // select sum(vote_id)/ count(vote_id) from ticket_answers where technical_id = 3


        // $calcPoints = DB::table('ticket_answers')->where('technical_id', $this->supportId)
        //                           ->selectRaw('1, 2, sum(user_vote)/count(user_vote)');


        $fileName = $support->full_name. '.xlsx';
        return Excel::download(new SupportsExport($support->id, $from_date, $to_date, $performanceMetric->performance), $fileName);
    }
}
