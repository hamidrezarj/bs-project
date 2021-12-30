<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->get('/', function () {
    $role = Auth::user()->roles()->first();
    switch ($role->name) {
        case 'user':
            $path = '/user';
            break;
        case 'technical_support':
            $path = '/support';
            break;
        case 'admin':
            $path = '/admin';
            break;
        default:
            $path = '/';
    }

    return redirect($path);
});

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('show', [BaseController::class, 'show'])->name('show');
    Route::post('password/reset', [BaseController::class, 'resetPassword'])->name('password.reset');
    Route::post('profile/update', [BaseController::class, 'updateProfile'])->name('profile.update');
});

Route::get('reload-captcha', [UserController::class, 'reloadCaptcha']);

Route::get('info', function () {
    return Auth::user();
});

Route::get('csrf', function () {
    return csrf_token();
});

Route::get('login-dev', function () {
    Auth::loginUsingId(1);
    return Auth::user();
});

Route::get('temp', function () {
    dd(getActiveSupports());
});

Route::get('clear_cache', function () {
    Illuminate\Support\Facades\Cache::forget('user-is-online-'. 3);
});

Route::get('use', function () {
    // $user = App\Models\User::find(1);
    // $user->national_code = '1234567890';
    // $user->password = '12345678';
    // $user->save();
    $ticket = App\Models\Ticket::find(6);
    dd($ticket->ticket_answer->technical_support);
});
