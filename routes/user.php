<?php

use Illuminate\Support\Facades\Route;
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
Route::group(['middleware' => ['role:user']], function(){
    Route::get('', [App\Http\Controllers\UserController::class, 'index'])->name('user_index');
    Route::get('ticket', [App\Http\Controllers\UserController::class, 'showTicketForm'])->name('ticket_form');
    Route::get('ticket/{ticket}', [UserController::class, 'showTicketDetails'])->name('ticket_details')->middleware('ticket');
    Route::post('create/ticket', [App\Http\Controllers\UserController::class, 'creatTicket'])->name('create_ticket');
});

