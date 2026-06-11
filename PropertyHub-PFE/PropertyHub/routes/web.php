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
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\LogController as AdminLogController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Buyer\DashboardController as BuyerDashboardController;
use App\Http\Controllers\Buyer\AppointmentController as BuyerAppointmentController;
use App\Http\Controllers\Buyer\MessageController as BuyerMessageController;
use App\Http\Controllers\Buyer\FavoriteController as BuyerFavoriteController;

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
Route::get('/appointments/available-slots', [AppointmentController::class, 'availableSlots'])->name('appointments.available-slots');

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
        if ($user->role === 'agent') {
            return redirect()->route('agent.dashboard');
        }
        if ($user->role === 'buyer') {
            return redirect()->route('buyer.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Notifications
    Route::post('/notifications/mark-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');


    // ======================
    // AGENT ROUTES
    // ======================
    Route::prefix('agent')->name('agent.')->middleware('role:agent')->group(function () {
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
    // BUYER ROUTES
    // ======================
    Route::prefix('buyer')->name('buyer.')->middleware('role:buyer')->group(function () {
        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');

        Route::get('/appointments', [BuyerAppointmentController::class, 'index'])->name('appointments.index');

        Route::get('/messages', [BuyerMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{user}', [BuyerMessageController::class, 'show'])->name('messages.show');
        Route::post('/messages', [BuyerMessageController::class, 'store'])->name('messages.store');

        Route::get('/favorites', [BuyerFavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favorites/{property}', [BuyerFavoriteController::class, 'toggle'])->name('favorites.toggle');
    });

    // ======================
    // ADMIN ROUTES
    // ======================
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/properties', [AdminPropertyController::class, 'index'])->name('properties.index');
        Route::post('/properties', [AdminPropertyController::class, 'store'])->name('properties.store');
        Route::get('/properties/{property}/edit', [AdminPropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{property}', [AdminPropertyController::class, 'update'])->name('properties.update');
        Route::post('/properties/{property}/approve', [AdminPropertyController::class, 'approve'])->name('properties.approve');
        Route::post('/properties/{property}/reject', [AdminPropertyController::class, 'reject'])->name('properties.reject');
        Route::post('/properties/{property}/sold', [AdminPropertyController::class, 'sold'])->name('properties.sold');
        Route::post('/properties/{property}/rented', [AdminPropertyController::class, 'rented'])->name('properties.rented');
        Route::delete('/properties/{property}', [AdminPropertyController::class, 'destroy'])->name('properties.destroy');

        Route::get('/logs', [AdminLogController::class, 'index'])->name('logs.index');

        Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
        Route::post('/appointments/{appointment}/confirm', [AdminAppointmentController::class, 'confirm'])->name('appointments.confirm');
        Route::post('/appointments/{appointment}/cancel', [AdminAppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::post('/appointments/{appointment}/complete', [AdminAppointmentController::class, 'complete'])->name('appointments.complete');

        Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{user}', [AdminMessageController::class, 'show'])->name('messages.show');
        Route::post('/messages', [AdminMessageController::class, 'store'])->name('messages.store');

        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    });
});