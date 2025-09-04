<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilController;

Route::get('/', [UtilController::class, "welcome"])->name('welcome');;

Route::fallback([UtilController::class, "fallback"]);

// dashboard admin
Route::get('/console', function () {
        return view('dashboard.console');
})->name('console')->middleware(['auth', 'role:1']);

// dashboard formador
Route::get('/hub', function () {
        return view('dashboard.hub');
})->name('hub')->middleware(['auth', 'role:2']);

// dashboard formando
Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
})->name('dashboard')->middleware(['auth', 'role:3']);
