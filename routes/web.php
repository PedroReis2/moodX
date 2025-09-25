<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SketchbookController;

Route::get('/', [UtilController::class, "welcome"])->name('welcome');

Route::fallback([UtilController::class, "fallback"]);

Route::get('/dashboard', [DashboardController::class, "dashboard"])->name('dashboard')->middleware('auth');


// sketchbooks
Route::get('/sketchbook/{id}', [SketchbookController::class, "sketchbookEntry"])->name('sketchbookEntry');//->middleware('auth');
Route::get('/sketchbook-shared/{id}', [SketchbookController::class, "sketchbookEntryShared"])->name('sketchbookEntryShared');//->middleware('auth');
Route::get('/sketchbook-gallery', [SketchbookController::class, "sketchbookGallery"])->name('sketchbookGallery');//->middleware('auth');
Route::get('/sketchbook-gallery-shared', [SketchbookController::class, "sketchbookGalleryShared"])->name('sketchbookGalleryShared');//->middleware('auth');


// comments
Route::post('/comments/{entry}', [CommentController::class, 'store'])->name('comments.store');


// user
Route::post('/store_user', [UserController::class, "storeuser"])->name('store_user');

Route::post('/profile/update', [UserController::class, 'updateProfile'])
    ->name('profile.update')
    ->middleware('auth');

Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.change');

Route::get('/change-password', function () {
    return view('profile.change-password');
})->name('change-password');


// Dashboard do formando sem projetos
// Route::get('/dashboard-empty', function () {
//     return view('dashboard.empty');
// })->name('dashboard.empty');

// Página de criação de novo projeto
Route::get('/create-project', function () {
    return "<h2>Formulário de criação de projeto</h2>";
})->name('create.project');

Route::get('/profile', function () {
    return view('profile.profile');
})->name('profile');

Route::get('/under-construction', function () {
    return view('fallback.under-construction');
})->name('under-construction');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');


// Rota para o My Creative Studio (formando)
Route::get('/studio', function () {
    return view('dashboard.creative-studio');
})->name('studio')->middleware(['auth', 'role:3']);


// Admin

Route::get('/dashboard-admin', function () {
    return view('dashboard.dashboard-admin');
})->name('dashboard.admin')->middleware('auth');


//IA
Route::post('/generate-image', [ImageGenerationController::class, 'generate'])->name('generate.image');

//underconstruction
Route::view('/under-construction', 'fallback.under-construction');
