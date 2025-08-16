<?php

namespace App\Classes\Persistence;

use App\Classes\SudokuDTO;
use Illuminate\Support\Facades\Session;

class PersistenceSession implements PersistenceInterface
{    
    private string $sessionKey = 'game_storage';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->ensureSessionStarted();
    }

    private function ensureSessionStarted(): void 
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            throw new \RuntimeException('Session not active');
        }
    }
    
    public function loadGame(): SudokuDTO
    {
        $data = Session::get($this->sessionKey);
        if ($data instanceof SudokuDTO) {
            return $data;
        } else {
            $data = new SudokuDTO();
            Session::put($this->sessionKey, $data);
            return $data;
        }
    }

    public function saveGame(SudokuDTO $data)
    {
        Session::put($this->sessionKey, $data);
    }

    public function resetGame(): SudokuDTO
    {
        Session::forget($this->sessionKey);
        $data = new SudokuDTO();
        Session::put($this->sessionKey, $data);
        return $data;
    }
}