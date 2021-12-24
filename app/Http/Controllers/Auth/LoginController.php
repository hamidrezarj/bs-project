<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo()
    {
        $role = Auth::user()->roles()->first();
        $redirect = '';

        switch ($role->name) {
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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function username()
    {
        return 'national_code';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|digits:10',
            'password' => 'required|string',
        ], [], [
            'national_code' => 'کد ملی'
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        $minutes = env('SESSION_LIFETIME', 480);
        $expire_at = Carbon::now()->add('minutes', $minutes);
        Cache::add('user-is-online-'. $user->id, true, $expire_at);

        if($user->roles()->first()->name == 'technical_support')
        {
            assignPendingTicketsToSupport($user);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        // clear cache
        Cache::forget('user-is-online-'. $user->id);

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
