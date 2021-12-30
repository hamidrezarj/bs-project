<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PerformanceSummaryExport;
use App\Exports\ResponseRateExport;
use App\Exports\TicketAnswersExport;
use App\Models\TicketAnswer;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return Auth::user();
    }

    public function getPerformanceReport(Request $request, User $support)
    {
        if ($support->roles()->first()->name != 'technical_support') {
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

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()
            ], 400);
        }
        
        $from_date = $request->from_date . " 00:00:00";
        $to_date = $request->to_date . " 23:59:59";

        $performanceMetric = TicketAnswer::where('technical_id', $support->id)
                                                ->whereNotNull('vote_id')
                                                ->selectRaw("sum(vote_id)/count(vote_id) as performance")
                                                ->first();

        $fileName = ' گزارش خلاصه عملکرد پشتیبان '.$support->full_name . '.xlsx';
        return Excel::download(new PerformanceSummaryExport($support->id, $from_date, $to_date, $support->full_name, $performanceMetric->performance), $fileName);
    }

    public function getResponseRateReport(Request $request, User $support)
    {
        if ($support->roles()->first()->name != 'technical_support') {
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

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()
            ], 400);
        }
        
        $from_date = $request->from_date . " 00:00:00";
        $to_date = $request->to_date . " 23:59:59";

        $responseRate = DB::select(DB::raw("SELECT concat(round(((t2.answered/t1.total) * 100 ),2), '%') as rate
                                            FROM
                                            (
                                                SELECT count(id) AS total
                                                FROM ticket_answers
                                                WHERE technical_id=$support->id
                                            )t1, (
                                                SELECT count(id) AS answered
                                                FROM ticket_answers
                                                WHERE technical_id=$support->id 
                                                AND description IS NOT NULL
                                            )t2"));

        $fileName = ' گزارش درصد پاسخگویی پشتیبان '.$support->full_name . '.xlsx';
        return Excel::download(new ResponseRateExport($support->id, $from_date, $to_date, $support->full_name, $responseRate[0]->rate), $fileName);
    }
}
