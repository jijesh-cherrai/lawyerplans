<?php

use App\Http\Controllers\CourtController;
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

Route::get('/courts', [CourtController::class, 'index'])->name('courts.index');
Route::get('/courts/get', [CourtController::class, 'getCourts'])->name('courts.get');
Route::post('/courts/store', [CourtController::class, 'store'])->name('courts.store');
Route::get('/courts/{court}/edit', [CourtController::class, 'edit'])->name('courts.edit');


