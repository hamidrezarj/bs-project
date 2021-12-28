<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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

    public function resetPassword(Request $request)
    {
        if (Auth::user()->cannot('update_profile')) {
            return response()->json([
                'status' => 403,
                'message' => 'access to the requested resource is forbidden'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|current_password',
            'new_password'   => 'required|min:8|confirmed',

        ], [], [
            'current_password' => 'رمز عبور فعلی',
            'new_password' => 'رمز عبور جدید'
        ])->validate();

        auth()->user()->update([
            'password' => $request->new_password
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'password updated successfully.'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if (Auth::user()->cannot('update_profile')) {
            return response()->json([
                'status' => 403,
                'message' => 'access to the requested resource is forbidden'
            ], 403);
        }

        Validator::make($request->all(), [
            'first_name'    => ['required', 'alpha', 'max:255'],
            'last_name'     => ['required', 'alpha', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255',
                                Rule::unique('users')->ignore($user),
                               ],
            'national_code' => ['required', 'digits:10',
                                Rule::unique('users')->ignore($user),
                               ],
            'student_id'    => ['nullable', 'digits_between:7,8',
                                Rule::unique('users')->ignore($user),
                               ],
            'phone_number'  => ['required', 'regex:/^(0){1}9\d{9}$/',
                                Rule::unique('users')->ignore($user),
                               ],
            'faculty'         => ['required'],
        ], [], [
            'national_code' => 'کد ملی',
            'student_id' => 'شماره دانشجویی',
            'phone_number' => 'شماره تلفن',
            'user_type' => 'نوع کاربر',
            'faculty' => 'دانشکده',
        ])->validate();

        $user->update($request->except('user_type'));

        return response()->json([
            'status' => 200,
            'message' => 'user updated successfully.'
        ]);
    }
}
