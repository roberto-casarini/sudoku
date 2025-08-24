<?php

namespace App\Classes\Persistence;

use App\Classes\SudokuDTO;

class PersistenceFake implements PersistenceInterface
{    
    public function loadGame(): SudokuDTO
    {
        $data = new SudokuDTO();
        return $data;
    }

    public function saveGame(SudokuDTO $data)
    {

    }

    public function resetGame(): SudokuDTO
    {
        $data = new SudokuDTO();
        return $data;
    }
}