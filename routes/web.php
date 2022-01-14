<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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

Route::middleware('auth')->get('/', function () {
    $role = Auth::user()->roles()->first();
    switch ($role->name) {
        case 'user':
            $path = '/user';
            break;
        case 'technical_support':
            $path = '/support';
            break;
        case 'admin':
            $path = '/admin';
            break;
        default:
            $path = '/';
    }

    return redirect($path);
});

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::middleware('auth')->group(function () {
    Route::get('show', [BaseController::class, 'show'])->name('show');
    Route::post('password/reset', [BaseController::class, 'resetPassword'])->name('password.reset');
    Route::post('profile/update', [BaseController::class, 'updateProfile'])->name('profile.update');
});

Route::get('info', function () {
    return Auth::user();
});

Route::get('csrf', function () {
    return csrf_token();
});

Route::get('login-dev', function () {
    Auth::loginUsingId(5);
    return Auth::user();
});

Route::get('temp', function () {
    dd(getActiveSupports());
});

Route::get('clear_cache', function(){
    Illuminate\Support\Facades\Cache::flush();
});

Route::get('import', function(){
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    // dd(storage_path());
    $filePath = storage_path(). '/Courses4001.xlsx';

    $spreadsheet = $reader->load($filePath);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    for ($i = 1; $i < count($sheetData); $i++) { 
        $row = $sheetData[$i];
        Illuminate\Support\Facades\DB::table('courses')->insert([
            'code' => $row[0],
            'name' => $row[1]
        ]);

    }
    return 'pk';
});

Route::get('test', function(){
    return App\Models\Course::count();
});