<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('performance_report/support/{support}', [App\Http\Controllers\AdminController::class, 'getPerformanceReport'])->name('admin.performance_report');
    Route::get('response_rate_report/support/{support}', [App\Http\Controllers\AdminController::class, 'getResponseRateReport'])->name('admin.response_rate_report');
});
