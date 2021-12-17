<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
});

Route::get('reload-captcha', [UserController::class, 'reloadCaptcha']);

Route::get('temp', [UserController::class, 'temp']);

Route::get('info', function () {
    return Auth::user();
});

Route::get('csrf', function () {
    return csrf_token();
});

Route::get('login-dev', function () {
    Auth::loginUsingId(2);
});

// Route::get('login-self', [BaseController::class, 'login']);
// Route::get('register-self', [BaseController::class, 'register']);
