<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransactionController;

/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/clients',ClientController::class);
    Route::get('/clients/{clientid}/getTransactions', [TransactionController::class, 'getTransactions'])->name('getTransactions');


    // Route::resource('users', UserController::class);
    Route::resource('/transaction', TransactionController::class);
});
