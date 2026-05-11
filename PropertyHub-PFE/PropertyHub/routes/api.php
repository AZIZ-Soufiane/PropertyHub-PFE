<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);

    // Properties
    Route::apiResource('properties', PropertyController::class);
    Route::get('/properties/{property}/details', [PropertyController::class, 'getDetails']);
    Route::get('/properties/search', [PropertyController::class, 'search']);
    Route::post('/properties/{property}/favorite', [PropertyController::class, 'addFavorite']);
    Route::delete('/properties/{property}/favorite', [PropertyController::class, 'removeFavorite']);
    Route::get('/favorites', [PropertyController::class, 'getFavorites']);
    Route::get('/properties/agent/{agentId}', [PropertyController::class, 'getByAgent']);

    // Appointments
    Route::apiResource('appointments', AppointmentController::class);
    Route::get('/appointments/agent/{agentId}/slots', [AppointmentController::class, 'getAvailableSlots']);
    Route::post('/appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule']);
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel']);
    Route::post('/appointments/{appointment}/complete', [AppointmentController::class, 'complete']);

    // Messages
    Route::apiResource('messages', MessageController::class);
    Route::get('/messages/conversations', [MessageController::class, 'getConversations']);
    Route::get('/messages/conversation/{userId}', [MessageController::class, 'getConversation']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::delete('/messages/{message}', [MessageController::class, 'destroy']);
    Route::get('/messages/inbox', [MessageController::class, 'getInbox']);
    Route::get('/messages/sent', [MessageController::class, 'getSentMessages']);

    // Users
    Route::get('/users/{userId}', [UserController::class, 'show']);
    Route::post('/users/profile', [UserController::class, 'updateProfile']);
    Route::get('/users/agents', [UserController::class, 'getAgents']);

    // Dashboard Stats
    Route::get('/dashboard/stats', [PropertyController::class, 'getStatistics']);
});

// Public routes (no authentication required)
Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/{property}', [PropertyController::class, 'show']);
Route::get('/properties/search', [PropertyController::class, 'search']);
Route::get('/agents', [UserController::class, 'getAgents']);
