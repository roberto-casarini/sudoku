<?php

namespace App\Classes;

use App\Classes\SudokuCell;

class SudokuBoard implements \Serializable
{
    private array $cells = [];

    public function __construct()
    {
        foreach(range(1, 9) as $y) {
            foreach(range(1, 9) as $x) {
                $this->cells[] = new SudokuCell($this->toLetter($x), $y);
            }
        }
    }

    private function toLetter($value): string
    {
        return match($value) {
            1 => "A",
            2 => "B",
            3 => "C",
            4 => "D",
            5 => "E", 
            6 => "F",
            7 => "G",
            8 => "H",
            9 => "I"
        };
    }

    public function getAllCells(): array
    {
        return $this->cells;
    }

    public function getColumnCells($xCoordinate): array
    {
        return array_filter($this->cells, function ($cell) use($xCoordinate) {
            return $cell->getXCoordinate() == $xCoordinate;
        });
    }

    public function getRowCells($yCoordinate)
    {
        return array_filter($this->cells, function ($cell) use($yCoordinate) {
            return $cell->getYCoordinate() == $yCoordinate;
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
            if (in_array($cell->getXCoordinate(), $filter["x"]) && in_array($cell->getYCoordinate(), $filter["y"])) {
                return $cell;
            }
        });
    }

    public function findCell($xCoordinate, $yCoordinate): SudokuCell|null
    {
        $res = array_values(array_filter($this->cells, function ($cell) use($xCoordinate, $yCoordinate) {
            return ($cell->getXCoordinate() == $xCoordinate) && ($cell->getYCoordinate() == $yCoordinate);
        }));
        return (count($res) > 0) ? $res[0] : null;
    }

    public function setCellValue($xCoordinate, $yCoordinate, $value, $setup = false): void
    {
        $cell = $this->findCell($xCoordinate, $yCoordinate);
        if (! is_object($cell)) {
            return;
        }
        $cell->setProps($value, $setup);
    }

    public static function toString(array $cells): string
    {
        $pieces = [];

        foreach($cells as $cell) {
            $pieces[] = $cell->getXCoordinate() . $cell->getYCoordinate();
        }
        
        return implode(", ", $pieces);
    }

    public function serialize()
    {
        return $this->cells;
    }

    public function unserialize(string $data): void
    {
        $this->cells = unserialize($data);
    }
}