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
Route::resource('courts', CourtController::class);
Route::get('/courts', [CourtController::class, 'index'])->name('courts.index');
Route::get('/courts/create', [CourtController::class, 'create'])->name('courts.create');
Route::post('/courts', [CourtController::class, 'store'])->name('courts.store');
Route::get('/courts/{court}/edit', [CourtController::class, 'edit'])->name('courts.edit');
Route::put('/courts/{court}', [CourtController::class, 'update'])->name('courts.update');
Route::delete('/courts/{court}', [CourtController::class, 'destroy'])->name('courts.destroy');

