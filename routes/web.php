<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
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

Auth::routes();

Route::get('/login', [App\Http\Controllers\HomeController::class, 'index'])->name('login');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [BaseController::class, 'index']);
Route::get('time', [BaseController::class, 'getTime']);
