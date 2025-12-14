<?php

namespace App\Classes\Persistence;

use App\Classes\SudokuDTO;

/**
 * Fake/null persistence implementation for testing purposes.
 * 
 * This implementation does not actually persist data - it always
 * returns a new game instance. Useful for unit testing where
 * you don't want to interact with actual storage mechanisms.
 */
class PersistenceFake implements PersistenceInterface
{
    /**
     * Load a new game instance (no actual persistence).
     * 
     * Always returns a fresh game instance since no data is persisted.
     * 
     * @return SudokuDTO A new game instance
     */
    public function loadGame(): SudokuDTO
    {
        return new SudokuDTO();
    }

    /**
     * Save the game state (no-op in fake implementation).
     * 
     * This method does nothing since the fake implementation
     * doesn't actually persist data.
     * 
     * @param SudokuDTO $data The game data (ignored)
     * @return void
     */
    public function saveGame(SudokuDTO $data): void
    {
        // No-op: fake implementation doesn't persist data
    }

    /**
     * Reset the game by returning a new game instance.
     * 
     * @return SudokuDTO A new game instance
     */
    public function resetGame(): SudokuDTO
    {
        return new SudokuDTO();
    }
}