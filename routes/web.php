<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SketchbookController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CreativeDnaController;



// Raiz — página de boas-vindas removida (só front-end React)
Route::get('/', function () {
    return redirect(auth()->check() ? '/creative-dna' : '/login');
})->name('welcome');

Route::fallback([UtilController::class, "fallback"]);

// Creative DNA — página principal após o login (React)
Route::get('/creative-dna', function () {
    return view('creative-dna');
})->name('creative-dna')->middleware('auth');

Route::post('/creative-dna/upload', [CreativeDnaController::class, 'upload'])
    ->name('creative-dna.upload')->middleware('auth');

// Dashboards desativados — redirecionam para o Creative DNA
Route::redirect('/dashboard', '/creative-dna')->name('dashboard');


// sketchbooks
Route::get('/sketchbook/{id}', [SketchbookController::class, "sketchbookEntry"])->name('sketchbookEntry')->middleware('auth');
Route::get('/sketchbook-shared/{id}', [SketchbookController::class, "sketchbookEntryShared"])->name('sketchbookEntryShared')->middleware('auth');


// comments
Route::post('/comments/{entry}', [CommentController::class, 'store'])->name('comments.store');


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


// Admin (desativado — redireciona para o Creative DNA)
Route::redirect('/dashboard-admin', '/creative-dna')->name('dashboard.admin');


//IA
Route::post('/generate-image', [ImageGenerationController::class, 'generate'])->name('generate.image');

//underconstruction
Route::view('/under-construction', 'fallback.under-construction');







// Teste IA

Route::middleware(['auth'])->group(function () {
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/create', [ConversationController::class, 'create'])->name('conversations.create');
    Route::post('/conversations', [ConversationController::class, 'store'])->name('conversations.store');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');

    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
});


