<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AppointmentController;

// Home redirect
Route::get('/', function () {
    return redirect()->route('welcome');
})->name('home');

// Welcome/Home page
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Public Property Routes
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/properties/agent/{agentId}', [PropertyController::class, 'byAgent'])->name('properties.by-agent');

// Public Appointment Routes
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/appointments/book', [AppointmentController::class, 'book'])->name('appointments.book');
Route::post('/appointments/slots', [AppointmentController::class, 'getSlots'])->name('appointments.slots');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/{appointmentId}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
Route::post('/appointments/{appointmentId}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
