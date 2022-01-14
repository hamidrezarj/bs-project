<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

use App\Exports\PerformanceSummaryExport;
use App\Exports\ResponseRateExport;
use App\Exports\TotalPerformanceExport;
use App\Models\TicketAnswer;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function showSupports(Request $request)
    {
        $fields = ['users.id', 'users.first_name', 'users.last_name', 'users.email',
                    'users.national_code', 'users.phone_number', 'users.faculty', 'users.created_at'];
        $query = User::where('user_type', 'technical_support');

        $results = processDataTable($request, $model_fullname='', $fields, $query);
        return response()->json($results, $results['status']);
    }

    public function createSupport(Request $request)
    {
        Validator::make($request->all(), [
            'first_name'    => ['required', 'alpha', 'max:255'],
            'last_name'     => ['required', 'alpha', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'national_code' => ['required', 'digits:10', 'unique:users'],
            'student_id'    => ['nullable', 'digits_between:7,8', 'unique:users'],
            'phone_number'  => ['required', 'unique:users', 'regex:/^(0){1}9\d{9}$/'],
            'faculty'         => ['required'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ], [], [
            'national_code' => 'کد ملی',
            'student_id' => 'شماره دانشجویی',
            'phone_number' => 'شماره تلفن',
            'faculty' => 'دانشکده',
        ])->validate();

        $user = User::create($request->all() + ['user_type' => 'technical_support']);
        $user->assignRole('technical_support');
        
        return response()->json([
            'status' => 200,
            'message' => 'support created successfully.'
        ]);
    }

    public function updateSupport(Request $request, User $support)
    {
        if (!$support->hasRole('technical_support')) {
            return response()->json([
                'status' => 403,
                'message' => 'access to the requested resource is forbidden'
            ], 403);
        }

        Validator::make($request->all(), [
            'first_name'    => ['required', 'alpha', 'max:255'],
            'last_name'     => ['required', 'alpha', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255',
                                Rule::unique('users')->ignore($support),
                               ],
            'national_code' => ['required', 'digits:10',
                                Rule::unique('users')->ignore($support),
                               ],
            'phone_number'  => ['required', 'regex:/^(0){1}9\d{9}$/',
                                Rule::unique('users')->ignore($support),
                               ],
            'faculty'         => ['required'],
        ], [], [
            'national_code' => 'کد ملی',
            'phone_number' => 'شماره تلفن',
            'faculty' => 'دانشکده',
        ])->validate();

        $support->update($request->except('user_type'));

        return response()->json([
            'status' => 200,
            'message' => 'support updated successfully.'
        ]);
    }

    public function deleteSupport(Request $request, User $support)
    {
        if (!$support->hasRole('technical_support')) {
            return response()->json([
                'status' => 403,
                'message' => 'access to the requested resource is forbidden'
            ], 403);
        }

        $support->delete();
        return response()->json([
            'status' => 200,
            'message' => 'support deleted successfully.'
        ]);
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
        ])->validate();
        
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
        ])->validate();
        
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

    public function getTotalPerformanceReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date_format:Y-m-d',
            'to_date'   => 'required|date_format:Y-m-d',
        ], [], [
            'from_date' => 'از تاریخ',
            'to_date' => 'تا تاریخ'
        ])->validate();

        $from_date = $request->from_date . " 00:00:00";
        $to_date = $request->to_date . " 23:59:59";
        $timeInterval = [$from_date, $to_date];
        
        $votesCnt = TicketAnswer::whereBetween('ticket_answers.created_at', $timeInterval)
                                ->groupBy('vote_id')
                                ->selectRaw('vote_id, count(*) as count')
                                ->get();
        
        $votes = [];
        foreach ($votesCnt as $key => $vote) {
            $votes[$key] = $vote->count;
        }

        $fileName = ' گزارش درصد پاسخگویی پشتیبانان '. '.xlsx';
        return Excel::download(new TotalPerformanceExport($from_date, $to_date, $votes), $fileName);
    }
}
