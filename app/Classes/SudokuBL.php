<?php

namespace App\Classes;

use App\Classes\SudokuBoard;
use Carbon\Carbon;
use App\Classes\SudokuDTO;
use App\Classes\Persistence\PersistenceInterface;

/**
 * Business Logic layer for Sudoku game operations.
 * 
 * This class handles game state management, persistence, and undo functionality.
 * It acts as a facade between the controllers and the game data model.
 */
class SudokuBL 
{
    /** @var SudokuDTO|null The current game data */
    private SudokuDTO|null $data;

    /** @var PersistenceInterface The persistence layer for saving/loading games */
    private PersistenceInterface $persistence;

    /**
     * Initialize the business logic layer with a persistence implementation.
     * 
     * @param PersistenceInterface $persistence The persistence layer to use
     */
    public function __construct(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;

        // retrieve from session if exists
        $this->data = $this->persistence->loadGame();
    }

    /**
     * Get the current game board.
     * 
     * @return SudokuBoard The current Sudoku board
     */
    public function getBoard(): SudokuBoard
    {
        return $this->data->board;
    }

    /**
     * Get the current game status.
     * 
     * @return string The current status (beginning, setup, playing, paused, end)
     */
    public function getStatus(): string
    {
        return $this->data->status;
    }

    /**
     * Get the game creation timestamp.
     * 
     * @return Carbon The timestamp when the game was created
     */
    public function getCreatedAt(): Carbon
    {
        return $this->data->createdAt;
    }

    /**
     * Get the game action logs (for undo functionality).
     * 
     * @return array<array<string, mixed>> Array of logged cell states
     */
    public function getLogs(): array
    {
        return $this->data->logs;
    }

    /**
     * Set a cell value or toggle a possibility, and save the game state.
     * 
     * This method logs the previous cell state before making changes,
     * allowing for undo functionality.
     * 
     * @param string $xCoordinate The column coordinate (A-I)
     * @param string|int $yCoordinate The row coordinate (1-9)
     * @param int|null $value The value to set (1-9) or null to clear
     * @param bool $setPossibilities If true, toggle the value in possibilities list instead of setting the cell value
     * @return array<int>|int|null Returns the updated possibilities array if $setPossibilities is true, otherwise returns the new cell value
     */
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

    /**
     * Set a cell value during initial board setup, and save the game state.
     * 
     * @param string $xCoordinate The column coordinate (A-I)
     * @param string|int $yCoordinate The row coordinate (1-9)
     * @param int|null $value The value to set (1-9) or null to clear
     * @return int|null The new cell value, or null if cleared
     */
    public function setCellValueSetup($xCoordinate, $yCoordinate, $value): int | null
    {
        $board = $this->getBoard();

        $res = $board->setCellValueSetup($xCoordinate, $yCoordinate, $value);

        // save to session
        $this->persistence->saveGame($this->data);

        return $res;
    }

    /**
     * Undo the last action (if available).
     * 
     * Restores the previous cell state from the logs and removes it from the log.
     * Only works for non-setup actions.
     * 
     * @return array<string, mixed>|null The restored cell state, or null if no undo available
     */
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

    /**
     * Reset the game to a new state.
     * 
     * @return void
     */
    public function reset(): void
    {
        $this->data = $this->persistence->resetGame();
    }

    /**
     * Set the game status and save the game state.
     * 
     * @param string $status The new status (beginning, setup, playing, paused, end)
     * @return void
     */
    public function setStatus($status)
    {
        $this->data->setStatus($status);
        $this->persistence->saveGame($this->data);
    }

    /**
     * Reset a cell to a previous state from the log.
     * 
     * @param array<string, mixed> $cell Cell data containing xCoordinate, yCoordinate, value, and possibilities
     * @return array<int>|int|null Returns possibilities if provided, otherwise returns the value
     */
    private function resetCellValue(array $cell): array | int | null
    {
        $board = $this->getBoard();
        return $board->resetCellValue($cell['xCoordinate'], $cell['yCoordinate'], $cell['value'], $cell['possibilities']);
    }
}