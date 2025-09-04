<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilController;

Route::get('/', [UtilController::class, "welcome"])->name('welcome');;


Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard')->middleware(['auth']);

Route::fallback([UtilController::class, "fallback"]);
