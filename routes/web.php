<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use App\Http\Controllers\CreativeDnaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MoodboardController;
use App\Http\Controllers\ClassesController;


// Raiz — redireciona conforme o estado do utilizador
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    // Se for admin, entra diretamente no dashboard próprio do admin.
    if (auth()->user()->role_id === \App\Models\Role::ADMIN_ID) {
        return redirect()->route('admin.dashboard');
    }

    // Se for professor, entra na página das turmas.
    if (auth()->user()->role_id === \App\Models\Role::FORMADOR_ID) {
        return redirect()->route('classes');
    }

    // Se for aluno, segue o fluxo normal do Creative DNA / Projects.
    $hasDna = \App\Models\CreativeDna::where('user_id', auth()->id())->exists();

    return redirect($hasDna ? '/projects' : '/creative-dna');
})->name('welcome');

Route::fallback([UtilController::class, "fallback"]);

// Creative DNA — página única por utilizador (redireciona para Projects se já usado)
Route::get('/creative-dna', function () {
    if (\App\Models\CreativeDna::where('user_id', auth()->id())->exists()) {
        return redirect()->route('projects.index');
    }
    return view('creative-dna');
})->name('creative-dna')->middleware('auth');

Route::post('/creative-dna/upload', [CreativeDnaController::class, 'upload'])
    ->name('creative-dna.upload')->middleware('auth');

Route::get('/creative-dna/data', [CreativeDnaController::class, 'data'])
    ->name('creative-dna.data')->middleware('auth');

// Página de consulta do Creative DNA já criado (não a de upload)
Route::get('creative-dna-view', function () {
    if (!\App\Models\CreativeDna::where('user_id', auth()->id())->exists()) {
        return redirect()->route('creative-dna');
    }
    return view('profile.creative-dna-view');
})->name('creative-dna.view')->middleware('auth');

// Dashboard genérico.
// Cada tipo de utilizador é enviado para a sua área certa.
Route::get('/dashboard', function () {
    return redirect()->route('welcome');
})->name('dashboard')->middleware('auth');

// Projects — projetos do utilizador (CRUD protegido)
Route::middleware('auth')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/data', [ProjectController::class, 'data'])->name('projects.data');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects', [ProjectController::class, 'destroyAll'])->name('projects.deleteAll');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});

// Moodboards e galeria usam dados do utilizador logado, por isso ficam protegidos por auth.
Route::middleware('auth')->group(function () {
    // Galeria pública dentro da app — mostra moodboards públicos, mas precisa do user para likes.
    Route::get('/gallery', [MoodboardController::class, 'gallery'])->name('gallery');
    Route::get('/gallery-data', [MoodboardController::class, 'galleryData'])->name('gallery.data');

    // Criação de moodboard.
    Route::get('/moodboard', [MoodboardController::class, 'index'])->name('moodboard.index');
    Route::get('/moodboard-select-data', [MoodboardController::class, 'selectData'])->name('moodboard.select-data');
    Route::post('/moodboard', [MoodboardController::class, 'store'])->name('moodboard.store');
    Route::patch('/moodboard/{moodboard}/toggle-public', [MoodboardController::class, 'togglePublic'])->name('moodboard.toggle-public');
    Route::post('/moodboard/{moodboard}/like', [MoodboardController::class, 'toggleLike'])->name('moodboard.like');
    Route::delete('/moodboard/{moodboard}', [MoodboardController::class, 'destroy'])->name('moodboard.destroy');

    // My Moodboards.
    Route::get('/my-moodboards', [MoodboardController::class, 'myMoodboards'])->name('my-moodboards');
    Route::get('/my-moodboards-data', [MoodboardController::class, 'data'])->name('my-moodboards.data');
});

// Classes (professor) — página das turmas e dos projetos dos alunos.
Route::middleware('auth')->group(function () {
    Route::get('/classes', [ClassesController::class, 'index'])->name('classes');
    Route::get('/classes/data', [ClassesController::class, 'data'])->name('classes.data');
    Route::post('/classes/projects/{project}/feedback', [ClassesController::class, 'storeFeedback'])->name('classes.projects.feedback');
});

// user
Route::post('/store_user', [UserController::class, "storeUser"])->name('store_user');

// Rotas antigas de gestão de users, agora protegidas para serem usadas só pelo admin.
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::post('/store_user_by_admin', [UserController::class, "storeUserByAdmin"])->name('store_user_by_admin');

    Route::put('/update_user_by_admin', [UserController::class, "updateUserByAdmin"])->name('update_user_by_admin');

    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle.status');

    Route::get('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('password.reset');
});

Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.change');

Route::get('/change-password', function () {
    return view('profile.change-password');
})->name('change-password');

Route::get('/profile', function () {
    return view('profile.profile');
})->name('profile');

Route::get('/under-construction', function () {
    return view('fallback.under-construction');
})->name('under-construction');




// Admin (desativado — redireciona para o Creative DNA)
//Route::redirect('/dashboard-admin', '/creative-dna')->name('dashboard.admin');
Route::redirect('/dashboard-admin', '/admin/dashboard')->name('dashboard.admin');

// Dashboard próprio do admin.
// Aqui o admin não vê Creative DNA nem projetos, apenas gestão de users e turmas.
Route::middleware(['auth', 'role:1'])->prefix('admin')->name('admin.')->group(function () {
    // Página principal do dashboard admin.
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Dados usados pelo React no dashboard admin.
    Route::get('/data', [AdminDashboardController::class, 'data'])->name('data');

    // Atualiza role de user e turma caso seja aluno.
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('users.update');

    // Atualiza as turmas atribuídas a um formador.
    Route::put('/formadores/{user}/turmas', [AdminDashboardController::class, 'updateFormadorTurmas'])->name('formadores.turmas.update');
});

// Em construção
Route::view('/under-construction', 'fallback.under-construction');
