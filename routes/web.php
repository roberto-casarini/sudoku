<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/start-game', [DashboardController::class, 'startGame']);
Route::post('/set-status', [DashboardController::class, 'setStatus']);
Route::post('/set-cell-value', [DashboardController::class, 'setCellValue']);
Route::post('/set-cell-value-setup', [DashboardController::class, 'setCellValueSetup']);
Route::post('/reset', [DashboardController::class, 'resetGame']);
Route::post('/back-one-move', [DashboardController::class, 'backOneMove']);