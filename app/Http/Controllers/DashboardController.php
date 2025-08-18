<?php

namespace App\Http\Controllers;

use App\Classes\SudokuBL;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function startGame()
    {
        $game = app()->make(SudokuBL::class);

        return [
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'message' => 'Status game retrieved',
            'request_status' => 'OK',
        ];
    }
}
