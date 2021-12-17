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
    // public function showRegisterForm()
    // {
    //     return view('register');
    // }

    // public function registerUser(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'first_name'    => 'required|alpha',
    //         'last_name'     => 'required|alpha',
    //         'email'         => 'required|email|unique:users',
    //         'national_code' => 'required|digits:10|unique:users',
    //         'student_id'    => 'digits_between:7,8|unique:users',
    //         'phone_number'  => 'required|unique:users|regex:/^(0){1}9\d{9}$/',
    //         'field'         => 'required',
    //         'faculty'       => 'required',
    //         'password'      => 'required|min:8|confirmed'
    //     ])->validate();
        
        
    //     $user = User::create($request->all());
        
    //     return redirect('index')->with('status', 'ثبت نام با موفقیت انجام شد!');
    // }

    // public function showLoginForm()
    // {
    //     return view('login');
    // }

    // public function loginUser(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'national_code' => 'required|digits:10',
    //         'password'      => 'required|min:8',
    //     ])->validate();

    //     $credentials = $request->only('national_code', 'password');
        
    //     if(Auth::attempt($credentials))
    //         return redirect()->intended('index');

    //     return redirect('login_form')->with('error', 'کد ملی یا رمز عبور اشتباه است.');
    // }

    // public function logout_user(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect('home');
    // }

    public function login()
    {
        return view('auth.login-selfdesign');
    }

    public function register()
    {
        return view('auth.register-selfdesign');
    }

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
