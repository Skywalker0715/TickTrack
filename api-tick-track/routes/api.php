<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Dashboard statistics
    Route::get('/dashboard/statistics', [DashboardController::class, 'getStatistics']);
    // Ticket routes
    Route::get('/ticket', [TicketController::class, 'index']);
    Route::post('/ticket', [TicketController::class, 'store']);
    Route::get('/ticket/{code}', [TicketController::class, 'show']);
    Route::post('/ticket-reply/{code}', [TicketController::class, 'storeReply']);
    
});