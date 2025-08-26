<?php

namespace App\Classes;

class SudokuCell
{
    public string $xCoordinate = '';

    public string $yCoordinate = '';

    public $value = null;

    public array $possibilities = [];

    public bool $setup = false;

    public function __construct($xCoordinate, $yCoordinate)
    {
        $this->xCoordinate = $xCoordinate;
        $this->yCoordinate = $yCoordinate;
    }

    public function showPossibilities()
    {
        return count($this->possibilities) > 0;
    }

    public function resetValue(int|null $value, array $possibilities = []): array | int | null
    {
        $this->possibilities = $possibilities;
        $this->value = $value;
        $this->setup = false;
        return (count($possibilities) > 0) ? $this->possibilities : $this->value;
    }

    public function setValue($value, $setPossibilities = false): array | int | null
    {
        $res = null;
        if ($setPossibilities) {
            if (in_array($value, $this->possibilities)) {
                if (($key = array_search($value, $this->possibilities)) !== false) {
                    unset($this->possibilities[$key]);
                    $this->possibilities = array_values($this->possibilities);
                }
            } else {
                $this->possibilities[] = $value;
            }
            $this->value = null;
            $res = $this->possibilities;
        } else {
            $this->possibilities = [];
            if ($this->value == $value) {
                $this->value = null;
            } else {
                $this->value = !is_null($value) ? (int) $value : null;
            }
            $res = $this->value;
        }
        $this->setup = false;
        return $res;
    }

    public function setValueSetup($value): int | null
    {
        if ($this->value == $value) {
            $this->value = null;
        } else {
            $this->value = $value;
        }
        $this->setup = true;
        return $this->value;
    }

    public function __serialize(): array
    {
        return [
            'xCoordinate' => $this->xCoordinate,
            'yCoordinate' => $this->yCoordinate,
            'value' => $this->value,
            'possibilities' => $this->possibilities,
            'setup' => $this->setup
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->xCoordinate = $data['xCoordinate'];
        $this->yCoordinate = $data['yCoordinate'];
        $this->value = $data['value'];
        $this->possibilities = $data['possibilities'];
        $this->setup = $data['setup'];
    }
}