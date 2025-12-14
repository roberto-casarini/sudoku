<?php

namespace App\Classes\Persistence;

use App\Classes\SudokuDTO;
use Illuminate\Support\Facades\Session;

/**
 * Session-based persistence implementation for Sudoku game state.
 * 
 * Stores game data in Laravel's session storage. The game state
 * persists across requests within the same session.
 */
class PersistenceSession implements PersistenceInterface
{    
    /** @var string The session key used to store game data */
    private const SESSION_KEY = 'sudoku_game';

    /**
     * Load the current game state from session.
     * 
     * If no game exists in session, creates and stores a new game.
     * 
     * @return SudokuDTO The current game data, or a new game if none exists
     */
    public function loadGame(): SudokuDTO
    {
        $data = Session::get(self::SESSION_KEY);
        
        if ($data instanceof SudokuDTO) {
            return $data;
        }
        
        // Create and store a new game if none exists
            $data = new SudokuDTO();
        $this->saveGame($data);
        
            return $data;
        }

    /**
     * Save the game state to session.
     * 
     * @param SudokuDTO $data The game data to save
     * @return void
     */
    public function saveGame(SudokuDTO $data): void
    {
        Session::put(self::SESSION_KEY, $data);
    }

    /**
     * Reset the game by clearing session and creating a new game state.
     * 
     * @return SudokuDTO A new game instance
     */
    public function resetGame(): SudokuDTO
    {
        Session::forget(self::SESSION_KEY);
        
        $data = new SudokuDTO();
        $this->saveGame($data);
        
        return $data;
    }
}