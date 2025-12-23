<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\SudokuBoard;
use App\Livewire\SelectNumber;
use App\Livewire\SetupBoard;

/*
|--------------------------------------------------------------------------
| Livewire Routes
|--------------------------------------------------------------------------
|
| These routes are used when the Livewire implementation is active.
| Livewire components handle their own routing internally, but you can
| add custom routes here if needed.
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');
