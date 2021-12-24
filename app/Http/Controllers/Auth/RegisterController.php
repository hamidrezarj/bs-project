<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public function redirectTo() {
        $role = Auth::user()->roles()->first();
        $redirect = '';

        switch($role->name)
        {
            case 'user':
                $redirect = '/user';
                break;
            case 'technical_support':
                $redirect = '/support';
                break;
            case 'admin':
                $redirect = '/admin';
                break;
            default:
                $redirect = '/';
        }

        return $redirect;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'    => ['required', 'alpha', 'max:255'],
            'last_name'     => ['required', 'alpha', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'national_code' => ['required', 'digits:10', 'unique:users'],
            'student_id'    => ['nullable', 'digits_between:7,8', 'unique:users'],
            'phone_number'  => ['required', 'unique:users', 'regex:/^(0){1}9\d{9}$/'],
            'faculty'         => ['required'],
            'user_type'     => ['required'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ], [], [
            'national_code' => 'کد ملی',
            'student_id' => 'شماره دانشجویی',
            'phone_number' => 'شماره تلفن',
            'user_type' => 'نوع کاربر',
            'faculty' => 'دانشکده',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create($data);

        if ($data['user_type'] == 'student' || $data['user_type'] == 'professor'  || $data['user_type'] == 'expert')
            $user->assignRole('user');
        elseif ($data['user_type'] == 'technical_support')
            $user->assignRole('technical_support');

        return $user;
    }
}
