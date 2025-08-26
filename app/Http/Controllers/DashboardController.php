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
            'message' => 'Game retrieved',
            'request_status' => 'OK',
        ];
    }

    public function setStatus()
    {
        $status = request()->get('status');
        $game = app()->make(SudokuBL::class);
        $game->setStatus($status);

        return [
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'message' => 'Status game retrieved',
            'request_status' => 'OK',
        ];
    }

    public function setCellValue()
    {
        $coord = request()->get('coord');
        $value = request()->get('value');
        $possibilities = request()->get('possibilities');

        if (!$coord) {
            return [
                'error_title' => 'Warning',
                'error_type' => 'warning',
                'error_timeout' => 5000,
                'message' => 'You must select a cell to enter a number!',
                'request_status' => 'ERROR',
            ];        
        }

        $game = app()->make(SudokuBL::class);

        $coords = explode('-', $coord);
        if (count($coords) != 2) {
            return [
                'error_title' => 'Warning',
                'error_type' => 'warning',
                'error_timeout' => 5000,
                'message' => 'You must select a cell to enter a number!',
                'request_status' => 'ERROR',
            ];  
        }

        $res = $game->setCellValue($coords[0], $coords[1], $value, $possibilities);

        return [
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'cell' => $coord,
            'cell_value' => $res,
            'message' => 'Cell set',
            'request_status' => 'OK',
        ];
    }

    public function setCellValueSetup()
    {
        $coord = request()->get('coord');
        $value = request()->get('value');

        if (!$coord) {
            return [
                'error_title' => 'Warning',
                'error_type' => 'warning',
                'error_timeout' => 5000,
                'message' => 'You must select a cell to enter a number!',
                'request_status' => 'ERROR',
            ];        
        }

        $game = app()->make(SudokuBL::class);

        $coords = explode('-', $coord);
        if (count($coords) != 2) {
            return [
                'error_title' => 'Warning',
                'error_type' => 'warning',
                'error_timeout' => 5000,
                'message' => 'You must select a cell to enter a number!',
                'request_status' => 'ERROR',
            ];  
        }

        $res = $game->setCellValueSetup($coords[0], $coords[1], $value);

        return [
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'cell' => $coord,
            'cell_value' => $res,
            'message' => 'Cell set',
            'request_status' => 'OK',
        ];
    }

    public function resetGame()
    {
        $game = app()->make(SudokuBL::class);
        $game->reset();
        
        return [
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'message' => 'Game reset',
            'request_status' => 'OK',
        ];
    }

    public function backOneMove()
    {
        $game = app()->make(SudokuBL::class);
        $cell = $game->back();
        return [
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'cell' => getCellCoords($cell),
            'cell_value' => getCellValue($cell),
            'message' => 'Back one move',
            'request_status' => 'OK',
        ];
    }
}
