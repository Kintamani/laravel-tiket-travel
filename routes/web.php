<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// auth
Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
});
Route::post('logged-in', [AuthController::class, 'authenticate']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    // home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // schedules
    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('/schedules', SchedulesController::class);
    });

    // tickets
    Route::prefix('tickets')->group(function () {
        Route::group(['middleware' => ['role:admin']], function () {
            Route::get('report', [TicketsController::class, 'report'])->name('tickets.report');
        });
        Route::group(['middleware' => ['role:penumpang']], function () {
            Route::get('history', [TicketsController::class, 'history'])->name('tickets.history');
            Route::get('available', [TicketsController::class, 'available'])->name('tickets.available');
            Route::post('check', [TicketsController::class, 'check'])->name('tickets.check');
            Route::post('payment', [TicketsController::class, 'payment'])->name('tickets.payment');
            Route::post('find/history', [TicketsController::class, 'findHistory'])->name('tickets.history.find');
            Route::get('invoice/{id}', [TicketsController::class, 'invoice'])->name('tickets.invoice');
        });
    });
    
});