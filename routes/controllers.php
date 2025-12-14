<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Controller Routes (MVC + Alpine.js)
|--------------------------------------------------------------------------
|
| These routes are used when the MVC + Alpine.js implementation is active.
| All game operations are handled via AJAX requests to these endpoints.
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Game API endpoints
Route::post('/start-game', [DashboardController::class, 'startGame']);
Route::post('/set-status', [DashboardController::class, 'setStatus']);
Route::post('/set-cell-value', [DashboardController::class, 'setCellValue']);
Route::post('/set-cell-value-setup', [DashboardController::class, 'setCellValueSetup']);
Route::post('/reset', [DashboardController::class, 'resetGame']);
Route::post('/back-one-move', [DashboardController::class, 'backOneMove']);
