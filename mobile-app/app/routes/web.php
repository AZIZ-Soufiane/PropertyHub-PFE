<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;

// Home redirect
Route::get('/', [PropertyController::class, 'home'])->name('home');

// Welcome/Home page
Route::get('/welcome', [PropertyController::class, 'home'])->name('welcome');

// Public Property Routes
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/properties/agent/{agentId}', [PropertyController::class, 'byAgent'])->name('properties.by-agent');

// Compare Routes
Route::get('/compare', [PropertyController::class, 'compare'])->name('compare');
Route::get('/compare/add', [PropertyController::class, 'addToCompare'])->name('compare.add');
Route::get('/compare/remove/{id}', [PropertyController::class, 'removeFromCompare'])->name('compare.remove');
Route::get('/compare/clear', [PropertyController::class, 'clearCompare'])->name('compare.clear');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Appointment Routes
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/appointments/book', [AppointmentController::class, 'book'])->name('appointments.book');
Route::post('/appointments/slots', [AppointmentController::class, 'getSlots'])->name('appointments.slots');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/{appointmentId}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
Route::post('/appointments/{appointmentId}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
