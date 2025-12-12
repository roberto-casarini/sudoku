<?php

namespace App\Http\Controllers;

use App\Classes\SudokuBL;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

/**
 * Controller for handling Sudoku game dashboard operations.
 * 
 * This controller manages HTTP requests related to the Sudoku game,
 * including starting games, setting cell values, managing game status,
 * and undo operations. All methods return JSON responses for AJAX requests.
 */
class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     * 
     * @return View The dashboard view
     */
    public function index(): View
    {
        return view('dashboard');
    }

    /**
     * Start or retrieve the current game state.
     * 
     * Returns the current board state and game status.
     * 
     * @return JsonResponse JSON response containing:
     *   - cells: array<SudokuCell> All cells in the board
     *   - game_status: string Current game status
     *   - message: string Success message
     *   - request_status: string 'OK'
     */
    public function startGame(): JsonResponse
    {
        $game = app()->make(SudokuBL::class);

        return response()->json([
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'message' => 'Game retrieved',
            'request_status' => 'OK',
        ]);
    }

    /**
     * Set the game status.
     * 
     * Valid statuses: 'beginning', 'setup', 'playing', 'paused', 'end'
     * 
     * @return JsonResponse JSON response containing:
     *   - cells: array<SudokuCell> All cells in the board
     *   - game_status: string Updated game status
     *   - message: string Success message
     *   - request_status: string 'OK'
     */
    public function setStatus(): JsonResponse
    {
        $status = request()->get('status');
        $game = app()->make(SudokuBL::class);
        $game->setStatus($status);

        return response()->json([
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'message' => 'Status game retrieved',
            'request_status' => 'OK',
        ]);
    }

    /**
     * Set a cell value or toggle a possibility during gameplay.
     * 
     * Expects request parameters:
     *   - coord: string Cell coordinates in format "X-Y" (e.g., "A-1")
     *   - value: int|null The value to set (1-9) or null
     *   - possibilities: bool If true, toggle value in possibilities list
     * 
     * @return JsonResponse JSON response containing:
     *   On success:
     *     - cells: array<SudokuCell> All cells in the board
     *     - game_status: string Current game status
     *     - cell: string The cell coordinates
     *     - cell_value: array<int>|int|null The updated cell value or possibilities
     *     - message: string Success message
     *     - request_status: string 'OK'
     *   On error:
     *     - error_title: string Error title
     *     - error_type: string Error type ('warning')
     *     - error_timeout: int Display timeout in milliseconds
     *     - message: string Error message
     *     - request_status: string 'ERROR'
     */
    public function setCellValue(): JsonResponse
    {
        $coord = request()->get('coord');
        $value = request()->get('value');
        $possibilities = request()->get('possibilities');

        if (!$coord) {
            return response()->json([
                'error_title' => 'Warning',
                'error_type' => 'warning',
                'error_timeout' => 5000,
                'message' => 'You must select a cell to enter a number!',
                'request_status' => 'ERROR',
            ]);        
        }

        $game = app()->make(SudokuBL::class);

        $coords = explode('-', $coord);
        if (count($coords) != 2) {
            return response()->json([
                'error_title' => 'Warning',
                'error_type' => 'warning',
                'error_timeout' => 5000,
                'message' => 'You must select a cell to enter a number!',
                'request_status' => 'ERROR',
            ]);  
        }

        $res = $game->setCellValue($coords[0], $coords[1], $value, $possibilities);

        return response()->json([
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'cell' => $coord,
            'cell_value' => $res,
            'message' => 'Cell set',
            'request_status' => 'OK',
        ]);
    }

    /**
     * Set a cell value during initial board setup.
     * 
     * Expects request parameters:
     *   - coord: string Cell coordinates in format "X-Y" (e.g., "A-1")
     *   - value: int|null The value to set (1-9) or null
     * 
     * @return JsonResponse JSON response containing:
     *   On success:
     *     - cells: array<SudokuCell> All cells in the board
     *     - game_status: string Current game status
     *     - cell: string The cell coordinates
     *     - cell_value: int|null The updated cell value
     *     - message: string Success message
     *     - request_status: string 'OK'
     *   On error:
     *     - error_title: string Error title
     *     - error_type: string Error type ('warning')
     *     - error_timeout: int Display timeout in milliseconds
     *     - message: string Error message
     *     - request_status: string 'ERROR'
     */
    public function setCellValueSetup(): JsonResponse
    {
        $coord = request()->get('coord');
        $value = request()->get('value');

        if (!$coord) {
            return response()->json([
                'error_title' => 'Warning',
                'error_type' => 'warning',
                'error_timeout' => 5000,
                'message' => 'You must select a cell to enter a number!',
                'request_status' => 'ERROR',
            ]);        
        }

        $game = app()->make(SudokuBL::class);

        $coords = explode('-', $coord);
        if (count($coords) != 2) {
            return response()->json([
                'error_title' => 'Warning',
                'error_type' => 'warning',
                'error_timeout' => 5000,
                'message' => 'You must select a cell to enter a number!',
                'request_status' => 'ERROR',
            ]);  
        }

        $res = $game->setCellValueSetup($coords[0], $coords[1], $value);

        return response()->json([
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'cell' => $coord,
            'cell_value' => $res,
            'message' => 'Cell set',
            'request_status' => 'OK',
        ]);
    }

    /**
     * Reset the game to a new state.
     * 
     * Clears the current game and initializes a new empty board.
     * 
     * @return JsonResponse JSON response containing:
     *   - cells: array<SudokuCell> All cells in the reset board
     *   - game_status: string Current game status
     *   - message: string Success message
     *   - request_status: string 'OK'
     */
    public function resetGame(): JsonResponse
    {
        $game = app()->make(SudokuBL::class);
        $game->reset();
        
        return response()->json([
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'message' => 'Game reset',
            'request_status' => 'OK',
        ]);
    }

    /**
     * Undo the last move.
     * 
     * Restores the previous cell state from the action log.
     * 
     * @return JsonResponse JSON response containing:
     *   - cells: array<SudokuCell> All cells in the board after undo
     *   - game_status: string Current game status
     *   - cell: string The cell coordinates that were restored (format: "X-Y")
     *   - cell_value: array<int>|int|null The restored cell value or possibilities
     *   - message: string Success message
     *   - request_status: string 'OK'
     */
    public function backOneMove(): JsonResponse
    {
        $game = app()->make(SudokuBL::class);
        $cell = $game->back();
        return response()->json([
            'cells' => $game->getBoard()->getAllCells(),
            'game_status' => $game->getStatus(),
            'cell' => getCellCoords($cell),
            'cell_value' => getCellValue($cell),
            'message' => 'Back one move',
            'request_status' => 'OK',
        ]);
    }
}
