<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use App\Http\Controllers\CreativeDnaController;
use App\Http\Controllers\MoodboardController;



// Raiz — redireciona conforme o estado do utilizador
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    $hasDna = \App\Models\CreativeDna::where('user_id', auth()->id())->exists();
    return redirect($hasDna ? '/moodboard' : '/creative-dna');
})->name('welcome');

Route::fallback([UtilController::class, "fallback"]);

// Creative DNA — página única por utilizador (redireciona para o Moodboard se já usado)
Route::get('/creative-dna', function () {
    if (\App\Models\CreativeDna::where('user_id', auth()->id())->exists()) {
        return redirect()->route('moodboard.index');
    }
    return view('creative-dna');
})->name('creative-dna')->middleware('auth');

Route::post('/creative-dna/upload', [CreativeDnaController::class, 'upload'])
    ->name('creative-dna.upload')->middleware('auth');

// Dashboards desativados — redirecionam para o Creative DNA
Route::redirect('/dashboard', '/creative-dna')->name('dashboard');

// Moodboard — projetos do utilizador (CRUD protegido)
Route::middleware('auth')->group(function () {
    Route::get('/moodboard', [MoodboardController::class, 'index'])->name('moodboard.index');
    Route::get('/moodboard/data', [MoodboardController::class, 'data'])->name('moodboard.data');
    Route::post('/moodboard', [MoodboardController::class, 'store'])->name('moodboard.store');
    Route::put('/moodboard/{moodboard}', [MoodboardController::class, 'update'])->name('moodboard.update');
    Route::delete('/moodboard', [MoodboardController::class, 'destroyAll'])->name('moodboard.deleteAll');
    Route::delete('/moodboard/{moodboard}', [MoodboardController::class, 'destroy'])->name('moodboard.destroy');
});


// user
Route::post('/store_user', [UserController::class, "storeUser"])->name('store_user');

Route::post('/store_user_by_admin', [UserController::class, "storeUserByAdmin"])->name('store_user_by_admin');

Route::put('/update_user_by_admin', [UserController::class, "updateUserByAdmin"])->name('update_user_by_admin');

Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

Route::get('/admin/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle.status');

Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.change');

Route::get('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('password.reset');

Route::get('/change-password', function () {
    return view('profile.change-password');
})->name('change-password');



Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {

    // Redireciona para a página de login com mensagem
    return redirect()->route('login')->with('message', 'Recover instructions sent to your email');
})->name('forgot-password.submit');



Route::get('/profile', function () {
    return view('profile.profile');
})->name('profile');

Route::get('/under-construction', function () {
    return view('fallback.under-construction');
})->name('under-construction');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');


// Admin (desativado — redireciona para o Creative DNA)
Route::redirect('/dashboard-admin', '/creative-dna')->name('dashboard.admin');

// Em construção
Route::view('/under-construction', 'fallback.under-construction');

