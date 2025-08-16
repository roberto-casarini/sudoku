<?php

namespace App\Classes;

class SudokuCell
{
    private string $xCoordinate = '';

    private string $yCoordinate = '';

    private $value = null;

    private array $possibilities = [];

    private bool $setup = false;

    public function __construct($xCoordinate, $yCoordinate)
    {
        $this->xCoordinate = $xCoordinate;
        $this->yCoordinate = $yCoordinate;
    }

    public function getXCoordinate(): string
    {
        return $this->xCoordinate;
    }

    public function getYCoordinate(): string
    {
        return $this->yCoordinate;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getPossibilities(): array
    {
        return $this->possibilities;
    }

    public function getSetup(): bool
    {
        return $this->setup;
    }

    public function showPossibilities()
    {
        return count($this->possibilities) > 0;
    }

    public function setProps($value, $setup = false): void
    {
        if (is_array($value)) {
            $this->possibilities = $value;
            $this->value = null;
        } else {
            $this->possibilities = [];
            $this->value = $value;
        }
        $this->setup = $setup;
    }
}