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
    Route::get('ticket/{ticket}', [TechnicalSupportController::class, 'ticketDetails'])->name('support.ticket_details')
                                                                                       ->middleware('is_owner:'. TicketAnswer::class);
    Route::post('reply/ticket/{ticket}', [TechnicalSupportController::class, 'replyTicket'])->name('support.reply_ticket')
                                                                                            ->middleware('is_owner:'. TicketAnswer::class);
});

Route::post('activate', [TechnicalSupportController::class, 'activate'])->name('support.activate');
