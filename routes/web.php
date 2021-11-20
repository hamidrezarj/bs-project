<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\UserController;

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

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('index', [BaseController::class, 'index'])->name('index');

Route::middleware('auth')->group(function(){
});

// user-specific routes
Route::middleware('auth')->group(function(){
    Route::get('user', [App\Http\Controllers\UserController::class, 'index'])->name('index');
    Route::get('user/ticket', [App\Http\Controllers\UserController::class, 'showTicketForm'])->name('ticket_form');
    
    Route::post('user/create/ticket', [App\Http\Controllers\UserController::class, 'creatTicket'])->name('create_ticket');
});

Route::get('temp', [UserController::class, 'temp']);