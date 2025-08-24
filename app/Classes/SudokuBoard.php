<?php

namespace App\Classes;

use App\Classes\SudokuCell;

class SudokuBoard
{
    private array $cells = [];

    public function __construct()
    {
        foreach(range(1, 9) as $y) {
            foreach(range(1, 9) as $x) {
                $this->cells[] = new SudokuCell(toLetter($x), $y);
            }
        }
    }

    public function getAllCells(): array
    {
        return $this->cells;
    }

    public function getColumnCells($xCoordinate): array
    {
        return array_filter($this->cells, function ($cell) use($xCoordinate) {
            return $cell->xCoordinate == $xCoordinate;
        });
    }

    public function getRowCells($yCoordinate)
    {
        return array_filter($this->cells, function ($cell) use($yCoordinate) {
            return $cell->yCoordinate == $yCoordinate;
        });
    }

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

    public function findCell($xCoordinate, $yCoordinate): SudokuCell|null
    {
        $res = array_values(array_filter($this->cells, function ($cell) use($xCoordinate, $yCoordinate) {
            return ($cell->xCoordinate == $xCoordinate) && ($cell->yCoordinate == $yCoordinate);
        }));
        return (count($res) > 0) ? $res[0] : null;
    }

    public function setCellValue($xCoordinate, $yCoordinate, $value, $setPossibilities = false): array | int | null
    {
        $cell = $this->findCell($xCoordinate, $yCoordinate);
        if (! is_object($cell)) {
            return null;
        }
        return $cell->setValue($value, $setPossibilities);
    }

    public function setCellValueSetup($xCoordinate, $yCoordinate, $value): int | null
    {
        $cell = $this->findCell($xCoordinate, $yCoordinate);
        if (! is_object($cell)) {
            return null;
        }
        return $cell->setValueSetup($value);
    }

    public static function toString(array $cells): string
    {
        $pieces = [];

        foreach($cells as $cell) {
            $pieces[] = $cell->xCoordinate . $cell->yCoordinate;
        }
        
        return implode(", ", $pieces);
    }

    public function __serialize(): array
    {
        return $this->cells;
    }

    public function __unserialize($data): void
    {
        $this->cells = $data;
    }
}