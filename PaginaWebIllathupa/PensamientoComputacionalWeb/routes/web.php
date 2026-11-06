<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UserController;

Route::get('/', fn () => auth()->check()
    ? redirect()->route('dashboard')
    : redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/actividades', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/actividades/{activity}', [ActivityController::class, 'show'])->name('activities.show');

    Route::middleware('role:investigadora')->group(function () {
        Route::get('/admin/actividades/crear', [ActivityController::class, 'create'])->name('activities.create');
        Route::post('/admin/actividades', [ActivityController::class, 'store'])->name('activities.store');
        Route::get('/admin/actividades/{activity}/editar', [ActivityController::class, 'edit'])->name('activities.edit');
        Route::put('/admin/actividades/{activity}', [ActivityController::class, 'update'])->name('activities.update');
        Route::delete('/admin/actividades/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
        Route::get('/admin/usuarios', [UserController::class, 'index'])->name('users.index');
        Route::post('/admin/usuarios', [UserController::class, 'store'])->name('users.store');
    });

    Route::middleware('role:estudiante')->group(function () {
        Route::post('/actividades/{activity}/resolver', [ExerciseController::class, 'submit'])->name('exercises.submit');
        Route::get('/mis-resultados', [ResultController::class, 'mine'])->name('results.mine');
    });

    Route::middleware('role:docente,investigadora')->group(function () {
        Route::get('/seguimiento', [ResultController::class, 'progress'])->name('results.progress');
    });
});
