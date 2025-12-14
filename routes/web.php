<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
| The routes are conditionally loaded based on the active implementation
| configured in config/sudoku.php
|
*/

$implementation = config('sudoku.implementation', 'controllers');

if ($implementation === 'livewire') {
    // Load Livewire routes
    require __DIR__.'/livewire.php';
} else {
    // Load MVC + Alpine.js routes
    require __DIR__.'/controllers.php';
}
