<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TechnicalSupportController;

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
    Route::get('', [App\Http\Controllers\TechnicalSupportController::class, 'index']);
});
