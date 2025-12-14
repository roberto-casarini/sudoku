<?php

namespace App\Classes;

use App\Classes\SudokuCell;

/**
 * Represents a 9x9 Sudoku board containing 81 cells.
 * 
 * The board is organized in a grid where:
 * - X coordinates are letters A through I
 * - Y coordinates are numbers 1 through 9
 * - The board is divided into 9 sectors (3x3 blocks)
 */
class SudokuBoard
{
    /** @var array<SudokuCell> */
    private array $cells = [];

    /**
     * Initialize a new Sudoku board with 81 empty cells.
     */
    public function __construct()
    {
        foreach(range(1, 9) as $y) {
            foreach(range(1, 9) as $x) {
                $this->cells[] = new SudokuCell(\toLetter($x), $y);
            }
        }
    }

    /**
     * Get all cells in the board.
     * 
     * @return array<SudokuCell> Array of all 81 cells
     */
    public function getAllCells(): array
    {
        return $this->cells;
    }

    /**
     * Get all cells in a specific column.
     * 
     * @param string $xCoordinate The column coordinate (A-I)
     * @return array<SudokuCell> Array of cells in the specified column
     */
    public function getColumnCells($xCoordinate): array
    {
        return array_filter($this->cells, function ($cell) use($xCoordinate) {
            return $cell->xCoordinate == $xCoordinate;
        });
    }

    /**
     * Get all cells in a specific row.
     * 
     * @param string|int $yCoordinate The row coordinate (1-9)
     * @return array<SudokuCell> Array of cells in the specified row
     */
    public function getRowCells($yCoordinate)
    {
        return array_filter($this->cells, function ($cell) use($yCoordinate) {
            return $cell->yCoordinate == $yCoordinate;
        });
    }

    /**
     * Get all cells in a specific sector (3x3 block).
     * 
     * Sectors are numbered 1-9 from top-left to bottom-right:
     * 1 2 3
     * 4 5 6
     * 7 8 9
     * 
     * @param int $sector The sector number (1-9)
     * @return array<SudokuCell> Array of cells in the specified sector
     */
    public function getSectorCells($sector)
    {
        $filter = match($sector) {
            1 => ["x" => ["A", "B", "C"], "y" => [1, 2, 3]],
            2 => ["x" => ["D", "E", "F"], "y" => [1, 2, 3]],
            3 => ["x" => ["G", "H", "I"], "y" => [1, 2, 3]],
            4 => ["x" => ["A", "B", "C"], "y" => [4, 5, 6]],
            5 => ["x" => ["D", "E", "F"], "y" => [4, 5, 6]], 
            6 => ["x" => ["G", "H", "I"], "y" => [4, 5, 6]],
            7 => ["x" => ["A", "B", "C"], "y" => [7, 8, 9]],
            8 => ["x" => ["D", "E", "F"], "y" => [7, 8, 9]], 
            9 => ["x" => ["G", "H", "I"], "y" => [7, 8, 9]],
            default => ["x" => [], "y" => []]
        };

        return array_filter($this->cells, function ($cell) use($filter) {
            if (in_array($cell->xCoordinate, $filter["x"]) && in_array($cell->yCoordinate, $filter["y"])) {
                return $cell;
            }
        });
    }

    /**
     * Find a cell by its coordinates.
     * 
     * @param string $xCoordinate The column coordinate (A-I)
     * @param string|int $yCoordinate The row coordinate (1-9)
     * @return SudokuCell|null The cell if found, null otherwise
     */
    public function findCell($xCoordinate, $yCoordinate): SudokuCell|null
    {
        $res = array_values(array_filter($this->cells, function ($cell) use($xCoordinate, $yCoordinate) {
            return ($cell->xCoordinate == $xCoordinate) && ($cell->yCoordinate == $yCoordinate);
        }));
        return (count($res) > 0) ? $res[0] : null;
    }

    /**
     * Set a cell value or toggle a possibility.
     * 
     * @param string $xCoordinate The column coordinate (A-I)
     * @param string|int $yCoordinate The row coordinate (1-9)
     * @param int|null $value The value to set (1-9) or null to clear
     * @param bool $setPossibilities If true, toggle the value in possibilities list instead of setting the cell value
     * @return array<int>|int|null Returns the updated possibilities array if $setPossibilities is true, otherwise returns the new cell value
     */
    public function setCellValue($xCoordinate, $yCoordinate, $value, $setPossibilities = false): array | int | null
    {
        $cell = $this->findCell($xCoordinate, $yCoordinate);
        if (! is_object($cell)) {
            return null;
        }
        
        if ($setPossibilities) {
            return $cell->togglePossibility((int) $value);
        }
        
        return $cell->setValue($value !== null ? (int) $value : null);
    }

    /**
     * Set a cell value during initial board setup.
     * 
     * @param string $xCoordinate The column coordinate (A-I)
     * @param string|int $yCoordinate The row coordinate (1-9)
     * @param int|null $value The value to set (1-9) or null to clear
     * @return int|null The new cell value, or null if cleared
     */
    public function setCellValueSetup($xCoordinate, $yCoordinate, $value): int | null
    {
        $cell = $this->findCell($xCoordinate, $yCoordinate);
        if (! is_object($cell)) {
            return null;
        }
        return $cell->setValueSetup($value);
    }

    /**
     * Reset a cell to a specific value and possibilities.
     * 
     * @param string $xCoordinate The column coordinate (A-I)
     * @param string|int $yCoordinate The row coordinate (1-9)
     * @param int|null $value The value to set (1-9) or null
     * @param array<int> $possibilities Array of possible values
     * @return array<int>|int|null Returns possibilities if provided, otherwise returns the value
     */
    public function resetCellValue($xCoordinate, $yCoordinate, int|null $value, array $possibilities = []): array | int | null
    {
        $cell = $this->findCell($xCoordinate, $yCoordinate);
        if (! is_object($cell)) {
            return null;
        }
        $res = $cell->resetValue($value, $possibilities);
        //dd($res);
        return $res;
    }

    /**
     * Convert an array of cells to a comma-separated string of coordinates.
     * 
     * @param array<SudokuCell> $cells Array of cells to convert
     * @return string Comma-separated string of cell coordinates (e.g., "A1, B2, C3")
     */
    public static function toString(array $cells): string
    {
        $pieces = [];

        foreach($cells as $cell) {
            $pieces[] = $cell->xCoordinate . $cell->yCoordinate;
        }
        
        return implode(", ", $pieces);
    }

    /**
     * Serialize the board for storage.
     * 
     * @return array<SudokuCell> Array of cells
     */
    public function __serialize(): array
    {
        return $this->cells;
    }

    /**
     * Unserialize the board from storage.
     * 
     * @param array<SudokuCell> $data Array of cells
     * @return void
     */
    public function __unserialize($data): void
    {
        $this->cells = $data;
    }
}