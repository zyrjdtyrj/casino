<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');


Route::get('/casino/bank', [\App\Http\Controllers\Casino\Game\CasinoController::class, 'bank'])
    ->name('casino.bank');

Route::get('/casino/slot', [\App\Http\Controllers\Casino\Game\SlotController::class, 'show'])
    ->middleware('auth')
    ->name('casino');

Route::post('/casino/slot', [\App\Http\Controllers\Casino\Game\SlotController::class, 'play'])
    ->middleware('auth');

Route::get('/casino/prizes', [\App\Http\Controllers\Casino\Game\PrizesController::class, 'prizes'])
    ->middleware('auth')
    ->name('casino.prizes');

Route::post('/casino/prizes', [\App\Http\Controllers\Casino\Game\PrizesController::class, 'prizeCancel'])
    ->middleware('auth');

// TODO: make authentication for admins
Route::get('/casino/admin', [\App\Http\Controllers\Casino\Admin\AdminController::class, 'prizesShow'])
    ->name('casino.admin');
Route::post('/casino/admin', [\App\Http\Controllers\Casino\Admin\AdminController::class, 'prizeAction']);


Auth::routes();


