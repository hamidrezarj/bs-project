<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TechnicalSupportController;
use App\Models\TicketAnswer;

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

Route::group(['middleware' => ['role:technical_support', 'expire_ticket:'. TicketAnswer::class]], function () {
    Route::get('', [TechnicalSupportController::class, 'index'])->name('support.index');
    Route::get('show_tickets', [TechnicalSupportController::class, 'showTickets'])->name('support.show_tickets');
    Route::get('ticket/{ticket}', [TechnicalSupportController::class, 'ticketDetails'])->name('support.ticket_details');                                                               
    Route::post('reply/ticket/{ticket}', [TechnicalSupportController::class, 'replyTicket'])->name('support.reply_ticket');

    Route::post('activate', [TechnicalSupportController::class, 'activate'])->name('support.activate');
    Route::post('deactivate', [TechnicalSupportController::class, 'deactivate'])->name('support.deactivate');
});
