<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\TicketAnswer;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Course;

use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function showTicketForm()
    {
        return view('user.ticket_form');
    }
    
    public function createTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'course_name' => 'required|string',
            'course_id'   => 'required|regex:/^[0-9]{7}_[0-9]{2}/',
            'description' => 'required',
        ], [], [
            // 'course_name' => 'نام درس',
            'course_id' => 'کد درس'
        ])->validate();

        $course = Course::where('code', $request->course_id)->first();
        if(is_null($course)){
            return response()->json([
                'errors' => [
                    'course_id' => [
                        0 => 'کد درس وارد شده نامعتبر است.'
                    ]
                ]
            ], 422);
        }

        $ticket = auth()->user()->tickets()->create([
            'course_id' => $course->code,
            'course_name' => $course->name,
            'description' => $request->description
        ]);

        $ticket->status = 'open';
        $ticket->status_id = 1;
        $ticket->expire_date = Carbon::now()->addMinutes(5);
        $ticket->save();

        // assign ticket to a technical support.
        $ts_id = getRandomSupport();
        
        // no active supports exist.
        if ($ts_id == 0) {
            $ticket_answer = TicketAnswer::create([
                'ticket_id' => $ticket->id,
                'technical_id' => $ts_id,
            ]);
        } else {
            $technical_support = User::find($ts_id);
            $ticket_answer = $technical_support->ticket_answers()->create();
        }

        $ticket->ticket_answer()->save($ticket_answer);

        return response()->json([
            'status' => 200,
            'message' => 'ticket created successfully.'
        ]);
    }

    public function deleteTicket(Request $request, Ticket $ticket)
    {
        Gate::authorize('delete', $ticket);

        if ($ticket->status == 'open') {
            $ticket->delete();
            return response()->json([
                'status' => 200,
                'message' => 'ticket deleted successfully.'
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'ticket cannot be deleted.'
        ], 400);
    }

    public function showTicketDetails(Request $request, Ticket $ticket)
    {
        Gate::authorize('details', $ticket);
        $data = TicketAnswer::join('users', 'ticket_answers.technical_id', 'users.id')
                            ->where('ticket_answers.ticket_id', $ticket->id)
                            ->selectRaw('ticket_answers.*, CONCAT(users.first_name, " ", users.last_name) as technical_full_name')
                            ->get();
                            
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function vote(Request $request, Ticket $ticket)
    {
        Gate::authorize('vote', $ticket);

        $validator = Validator::make($request->all(), [
            'vote' => 'required|in:1,2,3,4,5',
        ], [
            'vote.required' => 'لطفا یکی از گزینه های نظرسنجی را انتخاب کنید.'
        ], [
            'vote' => 'نظرسنجی'
        ])->validate();
    
        $ticket_answer = $ticket->ticket_answer;
        $ticket_answer->user_id= Auth::user()->id;
        $ticket_answer->vote_id = $request->vote;
        $ticket_answer->vote_date = Carbon::now()->toDateTimeString();
        $ticket_answer->save();

        $ticket->status = 'completed';
        $ticket->status_id = 3;
        $ticket->save();

        return response()->json([
            'status' => 200,
            'message' => 'نظرسنجی با موفقیت انجام شد.'
        ]);
    }

    public function reloadCaptcha(Request $request)
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function dataTable()
    {
        return view('user.datatable');
    }

    public function showTickets(Request $request)
    {
        $fields = ['tickets.id', 'tickets.course_name', 'tickets.course_id',
                   'tickets.description', 'tickets.status_id', 'tickets.expire_date', 'tickets.created_at', 'tickets.updated_at'];

        $query = Ticket::where('user_id', auth()->user()->id);

        $results = processDataTable($request, $model_fullname='', $fields, $query);
        return response()->json($results, $results['status']);
    }
}
