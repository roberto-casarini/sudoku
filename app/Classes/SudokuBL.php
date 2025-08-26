<?php

namespace App\Classes;

use App\Classes\SudokuBoard;
use Carbon\Carbon;
use App\Classes\SudokuDTO;
use App\Classes\Persistence\PersistenceInterface;

class SudokuBL 
{
    private SudokuDTO|null $data;

    private $persistence;

    public function __construct(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;

        // retrieve from session if exists
        $this->data = $this->persistence->loadGame();
    }

    public function getBoard(): SudokuBoard
    {
        return $this->data->board;
    }

    public function getStatus(): string
    {
        return $this->data->status;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->data->createdAt;
    }

    public function getLogs(): array
    {
        return $this->data->logs;
    }

    public function setCellValue($xCoordinate, $yCoordinate, $value, $setPossibilities = false): array | int | null
    {
        $board = $this->getBoard();
        $cell = $board->findCell($xCoordinate, $yCoordinate);
        if (is_object($cell)) {
            $this->data->logs[] = [
                'xCoordinate' => $cell->xCoordinate,
                'yCoordinate' => $cell->yCoordinate,
                'value' => $cell->value,
                'possibilities' => $cell->possibilities,
                'setup' => false,
            ];
        }
        $res = $board->setCellValue($xCoordinate, $yCoordinate, $value, $setPossibilities);

        // save to session
        $this->persistence->saveGame($this->data);

        return $res;
    }

    public function setCellValueSetup($xCoordinate, $yCoordinate, $value): int | null
    {
        $board = $this->getBoard();

        $res = $board->setCellValueSetup($xCoordinate, $yCoordinate, $value);

        // save to session
        $this->persistence->saveGame($this->data);

        return $res;
    }

    public function back(): array | null
    {
        if (count($this->data->logs) <= 0) {
            return null;
        }

        $cell = array_pop($this->data->logs);
        if ($cell['setup'] == false) {
            $this->resetCellValue($cell);

            // save to session
            $this->persistence->saveGame($this->data);
            return $cell;
        }
        return null;
    }

    public function reset(): void
    {
        $this->data = $this->persistence->resetGame();
    }

    public function setStatus($status)
    {
        $this->data->setStatus($status);
        $this->persistence->saveGame($this->data);
    }

    private function resetCellValue(array $cell): array | int | null
    {
        $board = $this->getBoard();
        return $board->resetCellValue($cell['xCoordinate'], $cell['yCoordinate'], $cell['value'], $cell['possibilities']);
    }
}