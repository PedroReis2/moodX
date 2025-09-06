<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SketchbookController;
use App\Http\Controllers\CommentController;

Route::get('/', [UtilController::class, "welcome"])->name('welcome');

Route::fallback([UtilController::class, "fallback"]);

Route::get('/dashboard', [DashboardController::class, "dashboard"])->name('dashboard')->middleware('auth');




// sketchbooks
Route::get('/sketchbook/{id}', [SketchbookController::class, "sketchbookEntry"])->name('sketchbookEntry');//->middleware('auth');
Route::get('/sketchbook-gallery', [SketchbookController::class, "sketchbookGallery"])->name('sketchbookGallery');//->middleware('auth');
//Route::get('/sketchbook/{id}', [SketchbookController::class, 'show'])->name('sketchbook.show');


Route::post('/comments/{entry}', [CommentController::class, 'store'])->name('comments.store');
