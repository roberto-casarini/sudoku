<?php

namespace App\Classes;

use Carbon\Carbon;

/**
 * Sudoku Data Transfer Object.
 * 
 * This class holds all the data for a Sudoku game session, including
 * the board state, game status, creation time, and action logs.
 */
class SudokuDTO
{
    /** @var string Initial state when game is first created */
    const BEGINNING_STATE = 'beginning';
    
    /** @var string State when user is setting up the initial puzzle */
    const SETUP_STATE = 'setup';
    
    /** @var string State when user is actively playing */
    const PLAYING_STATE = 'playing';
    
    /** @var string State when game is paused */
    const PAUSED_STATE = 'paused';
    
    /** @var string State when game is completed */
    const END_STATE = 'end';

    /** @var SudokuBoard|null The game board containing all cells */
    public SudokuBoard|null $board = null;
    
    /** @var string Current game status (one of the STATE constants) */
    public string $status = '';

    /** @var Carbon Timestamp when the game was created */
    public Carbon $createdAt;

    /** @var array<array<string, mixed>> Log of cell state changes for undo functionality */
    public array $logs = [];

    /**
     * Initialize a new Sudoku game with an empty board.
     */
    public function __construct()
    {
        $this->board = new SudokuBoard();
        $this->status = self::BEGINNING_STATE;
        $this->createdAt = Carbon::now();
        $this->logs = [];
    }

    /**
     * Set the game status with validation.
     * 
     * @param string $status The new status (must be one of the STATE constants)
     * @return void
     * @throws \Exception If the provided status is invalid
     */
    public function setStatus($status)
    {
        $states = [
            self::BEGINNING_STATE,
            self::SETUP_STATE,
            self::PLAYING_STATE,
            self::PAUSED_STATE,
            self::END_STATE
        ];
        
        if (!in_array($status, $states)) {
            throw new \Exception('Invalid state.');
        }

        $this->status = $status;
    }
}