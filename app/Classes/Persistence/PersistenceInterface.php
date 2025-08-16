<?php

namespace App\Classes\Persistence;

use App\Classes\SudokuDTO;

interface PersistenceInterface
{
    public function loadGame(): SudokuDTO;

    public function saveGame(SudokuDTO $data);

    public function resetGame(): SudokuDTO;
}