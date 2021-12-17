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
Route::middleware(['role:user'])->group(function(){
    Route::get('', [UserController::class, 'index'])->name('user_index');

    Route::get('ticket', [UserController::class, 'showTicketForm'])->name('ticket_form');
    Route::get('ticket/{ticket}', [UserController::class, 'showTicketDetails'])->name('ticket.details')
                                                                               ->middleware('is_owner:'. \App\Models\Ticket::class);
    Route::post('ticket/create', [UserController::class, 'creatTicket'])->name('create_ticket');
    Route::post('ticket/vote/{ticket}', [UserController::class, 'vote'])->name('ticket.vote');
});

