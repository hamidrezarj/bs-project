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
Route::middleware(['role:user'])->group(function () {
    Route::get('', [UserController::class, 'index'])->name('user.index')->middleware('expire_ticket:'. Ticket::class);
    Route::get('show', [UserController::class, 'show'])->name('user.show');
    Route::get('show_tickets', [UserController::class, 'showTickets'])->name('user.show_tickets');


    Route::get('ticket', [UserController::class, 'showTicketForm'])->name('ticket_form')->middleware('is_in_operating_hours:'. Ticket::class);
    Route::get('ticket/{ticket}', [UserController::class, 'showTicketDetails'])->name('ticket.details')
                                                                               ->middleware(['is_owner:'. Ticket::class,
                                                                                             'expire_ticket:'. Ticket::class]);
    Route::post('ticket/create', [UserController::class, 'creatTicket'])->name('create_ticket')->middleware('is_in_operating_hours:'. Ticket::class);
    Route::post('ticket/vote/{ticket}', [UserController::class, 'vote'])->name('ticket.vote');

    Route::get('datatable', [UserController::class, 'dataTable']);
});

