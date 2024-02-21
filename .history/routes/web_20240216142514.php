<?php

use App\Http\Controllers\CourtsController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/courts', [CourtsController::class, 'index'])->name('courts.index');
Route::get('/courts/get', [CourtsController::class, 'get'])->name('courts.get');
Route::post('/courts/store', [CourtsController::class, 'store'])->name('courts.store');
Route::put('/courts/{court}', [CourtsController::class, 'update'])->name('courts.update');
Route::delete('/courts/{court}', [CourtsController::class, 'destroy'])->name('courts.destroy');

