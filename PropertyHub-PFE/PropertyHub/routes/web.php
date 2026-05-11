<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PropertyController;
use App\Http\Controllers\Frontend\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Agent\PropertyController as AgentPropertyController;
use App\Http\Controllers\Agent\AppointmentController as AgentAppointmentController;
use App\Http\Controllers\Agent\MessageController as AgentMessageController;

// ======================
// PUBLIC ROUTES
// ======================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::name('properties.')->group(function () {
    Route::get('/properties', [PropertyController::class, 'index'])->name('index');
    Route::get('/properties/search', [PropertyController::class, 'search'])->name('search');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('show');
});

Route::get('/compare', [PropertyController::class, 'compare'])->name('compare');
Route::get('/compare/clear', [PropertyController::class, 'compareClear'])->name('compare.clear');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public property appointment booking
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

// ======================
// PROTECTED ROUTES
// ======================
Route::middleware(['auth'])->group(function () {
    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('agent.dashboard');
    })->name('dashboard');

    // ======================
    // AGENT ROUTES
    // ======================
    Route::prefix('agent')->name('agent.')->group(function () {
        Route::get('/dashboard', [AgentPropertyController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/properties', [AgentPropertyController::class, 'index'])->name('properties.index');
        Route::get('/properties/create', [AgentPropertyController::class, 'create'])->name('properties.create');
        Route::post('/properties', [AgentPropertyController::class, 'store'])->name('properties.store');
        Route::get('/properties/{property}/edit', [AgentPropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{property}', [AgentPropertyController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}', [AgentPropertyController::class, 'destroy'])->name('properties.destroy');
        
        Route::get('/appointments', [AgentAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AgentAppointmentController::class, 'show'])->name('appointments.show');
        Route::post('/appointments/{appointment}/confirm', [AgentAppointmentController::class, 'confirm'])->name('appointments.confirm');
        Route::post('/appointments/{appointment}/cancel', [AgentAppointmentController::class, 'cancel'])->name('appointments.cancel');
        
        Route::get('/messages', [AgentMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{user}', [AgentMessageController::class, 'show'])->name('messages.show');
        Route::post('/messages', [AgentMessageController::class, 'store'])->name('messages.store');
    });

    // ======================
    // ADMIN ROUTES
    // ======================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});