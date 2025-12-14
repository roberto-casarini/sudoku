<?php

namespace App\Classes\Persistence;

use App\Classes\SudokuDTO;

/**
 * Interface for persisting Sudoku game state.
 * 
 * This interface defines the contract for storing and retrieving
 * Sudoku game data. Implementations can use different storage
 * mechanisms (session, database, cache, etc.).
 */
interface PersistenceInterface
{
    /**
     * Load the current game state from storage.
     * 
     * If no game exists in storage, a new game should be created and returned.
     * 
     * @return SudokuDTO The current game data, or a new game if none exists
     */
    public function loadGame(): SudokuDTO;

    /**
     * Save the game state to storage.
     * 
     * @param SudokuDTO $data The game data to save
     * @return void
     */
    public function saveGame(SudokuDTO $data): void;

    /**
     * Reset the game by creating a new game state.
     * 
     * Clears the current game and initializes a fresh game state.
     * 
     * @return SudokuDTO A new game instance
     */
    public function resetGame(): SudokuDTO;
}