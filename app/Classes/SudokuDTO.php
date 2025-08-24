<?php

namespace App\Classes;

use Carbon\Carbon;

/**
 * Sudoku Data Transfert Object
 */
class SudokuDTO
{
    const BEGINNING_STATE = 'beginning';
    const SETUP_STATE = 'setup';
    const PLAYING_STATE = 'playing';
    const PAUSED_STATE = 'paused';
    const END_STATE = 'end';

    public SudokuBoard|null $board = null;
    
    public string $status = '';

    public Carbon $createdAt;

    public array $logs = [];

    public function __construct()
    {
        $this->board = new SudokuBoard();
        $this->status = self::BEGINNING_STATE;
        $this->createdAt = Carbon::now();
        $this->logs = [];
    }

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