<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class SingleCell extends Component
{
    // stato
    public array $possibilities = [];

    public $xCoordinate = '';

    public $yCoordinate = '';

    public $cellValue = '';


    // prop. visuali
    public $showPossibilities = false;

    public function mount($cell)
    {
        if (!key_exists('xCoordinate', $cell) || !key_exists('yCoordinate', $cell)) {
            throw new Exception('Invalid Cell');
        }

        $this->xCoordinate = $cell['xCoordinate'];
        $this->yCoordinate = $cell['yCoordinate'];
    }

    public function hasPossibility($value): bool
    {
        return in_array((int) $value, $this->possibilities);
    }

    #[Computed]
    public function cellToText()
    {
        return $this->xCoordinate . $this->yCoordinate;
    }

    #[On('set_cell_values')]
    public function setCellValues($cell, $values, $showPossibilities)
    {
        if ($cell == $this->cellToText()) {
            if (!$showPossibilities) {
                $this->showPossibilities = false;
                $this->cellValue = (count($values) > 0) ? $values[0] : '';
            } else {
                $this->showPossibilities = true;
                $this->possibilities = $values;
            }
        }
    }

    public function isPopulated() {
        return (($this->cellValue != '') || (count($this->possibilities) > 0)); 
    }

    public function render()
    {
        return view('livewire.single-cell');
    }
}
