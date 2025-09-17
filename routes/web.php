<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SketchbookController;

Route::get('/', [UtilController::class, "welcome"])->name('welcome');

Route::fallback([UtilController::class, "fallback"]);

Route::get('/dashboard', [SketchbookController::class, "dashboard"])->name('dashboard')->middleware('auth');




// sketchbooks
Route::get('/sketchbook/{id}', [SketchbookController::class, "sketchbookEntry"])->name('sketchbookEntry');//->middleware('auth');
Route::get('/sketchbook-shared/{id}', [SketchbookController::class, "sketchbookEntryShared"])->name('sketchbookEntryShared');//->middleware('auth');
Route::get('/sketchbook-gallery', [SketchbookController::class, "sketchbookGallery"])->name('sketchbookGallery');//->middleware('auth');
Route::get('/sketchbook-gallery-shared', [SketchbookController::class, "sketchbookGalleryShared"])->name('sketchbookGalleryShared');//->middleware('auth');

// comments
Route::post('/comments/{entry}', [CommentController::class, 'store'])->name('comments.store');


// user
Route::post('/store_user', [UserController::class, "storeuser"])->name('store_user');



// Dashboard do formando sem projetos
Route::get('/dashboard-empty', function () {
    return view('dashboard.dash-formandos-empty');
})->name('dashboard.empty');

// Página de criação de novo projeto
Route::get('/create-project', function () {
    return "<h2>Formulário de criação de projeto</h2>";
})->name('create.project');


//extra
Route::get('/create-account', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/change-password', function () {
    return view('profile.change-password');
})->name('change-password');

Route::get('/profile', function () {
    return view('profile.profile');
})->name('profile');

Route::get('/under-construction', function () {
    return view('under-construction');
})->name('under-construction');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');
