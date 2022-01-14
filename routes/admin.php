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
    Route::get('show_supports', [App\Http\Controllers\AdminController::class, 'showSupports'])->name('admin.show_supports');
    Route::post('support/create', [App\Http\Controllers\AdminController::class, 'createSupport'])->name('admin.support.create');
    Route::post('support/update/{support}', [App\Http\Controllers\AdminController::class, 'updateSupport'])->name('admin.support.update');
    Route::delete('support/delete/{support}', [App\Http\Controllers\AdminController::class, 'deleteSupport'])->name('admin.support.delete');

    Route::get('performance_report/support/{support}', [App\Http\Controllers\AdminController::class, 'getPerformanceReport'])->name('admin.performance_report');
    Route::get('response_rate_report/support/{support}', [App\Http\Controllers\AdminController::class, 'getResponseRateReport'])->name('admin.response_rate_report');
    Route::get('total_performance_report', [App\Http\Controllers\AdminController::class, 'getTotalPerformanceReport'])->name('admin.total_performance_report');
});
