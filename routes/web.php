<?php

use App\Http\Controllers\CaseDiaryController;
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

// Route group with auth middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [CaseDiaryController::class, 'index'])->name('home');

    Route::prefix('courts')->group(function () {
        Route::get('/', [CourtsController::class, 'index'])->name('courts.index');
        Route::get('/get', [CourtsController::class, 'get'])->name('courts.get');
        Route::post('/store', [CourtsController::class, 'store'])->name('courts.store');
        Route::put('/{court}', [CourtsController::class, 'update'])->name('courts.update');
        Route::delete('/{court}', [CourtsController::class, 'destroy'])->name('courts.destroy');
        Route::get('/all', [CourtsController::class, 'getAllCourts'])->name('courts.all');
    });

    Route::prefix('case-diaries')->group(function () {
        Route::get('/', [CaseDiaryController::class, 'index'])->name('case-diaries.index');
        Route::get('/get', [CaseDiaryController::class, 'getCaseDiaries'])->name('case-diaries.get');
        Route::post('/store', [CaseDiaryController::class, 'store'])->name('case-diaries.store');
        Route::put('/update/{id}', [CaseDiaryController::class, 'update'])->name('case-diaries.update');
        Route::get('/show/{id}', [CaseDiaryController::class, 'show'])->name('case-diaries.show');
        Route::delete('/delete/{id}', [CaseDiaryController::class, 'destroy'])->name('case-diaries.delete');
    });
});
