<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Academic\StudentGroupController;
use App\Http\Controllers\Academic\ProfessorController;
use App\Http\Controllers\Infrastructure\ClassroomController;
use App\Http\Controllers\Assignment\AssignmentController;
use App\Http\Controllers\Assignment\ConflictController;

// Rutas publicas
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de autenticacion
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Modulo 2: Administracion
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('reports', ReportController::class)->only(['index', 'show']);
        Route::resource('settings', SettingsController::class)->only(['index', 'update']);
    });

    // Modulo 3: Gestion Academica
    Route::middleware('role:coordinador')->prefix('academic')->name('academic.')->group(function () {
        Route::get('/dashboard', function () {
            return view('academic.dashboard');
        })->name('dashboard');
        Route::resource('student-groups', StudentGroupController::class);
        Route::resource('professors', ProfessorController::class);
    });

    // Modulo 4: Gestion de Infraestructura
    Route::middleware('role:coordinador_infraestructura')->prefix('infrastructure')->name('infrastructure.')->group(function () {
        Route::get('/dashboard', function () {
            return view('infrastructure.dashboard');
        })->name('dashboard');
        Route::resource('classrooms', ClassroomController::class);
    });

    // Modulo 5: Asignaciones
    Route::middleware('role:coordinador')->prefix('assignments')->name('assignments.')->group(function () {
        Route::get('/dashboard', function () {
            return view('assignments.dashboard');
        })->name('dashboard');
        Route::resource('assignments', AssignmentController::class);
        Route::post('/automatic', [AssignmentController::class, 'automatic'])->name('automatic');
        Route::get('/conflicts', [ConflictController::class, 'index'])->name('conflicts.index');
    });

    // Modulo 6: Horarios
    Route::prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/my-schedule', [AssignmentController::class, 'mySchedule'])->name('my-schedule');
        Route::get('/semester-schedule', [AssignmentController::class, 'semesterSchedule'])->name('semester-schedule');
    });

    // Modulo 8: Portal de Profesores
    Route::middleware('role:profesor')->prefix('professor')->name('professor.')->group(function () {
        Route::get('/dashboard', function () {
            return view('professor.dashboard');
        })->name('dashboard');
    });
});
