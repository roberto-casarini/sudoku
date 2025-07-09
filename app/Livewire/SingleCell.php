<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class SingleCell extends Component
{
    public array $possibilities = [];

    public $cell = '';

    public $cellValue = '';

    public $borders = [];

    public $edit = false;

    public $disabled = true;

    public $settingMode = false;

    public function mount($cell)
    {
        if (empty($cell)) {
            throw new Exception('Invalid Cell');
        }

        $this->cell = $cell;
        $this->setBorders();
    }

    #[Computed]
    public function getXCoord() 
    {
        return strlen($this->cell) == 2 ? substr($this->cell, 0, 1) : '';
    }
        
    #[Computed]
    public function getYCoord() 
    {
        return strlen($this->cell) == 2 ? substr($this->cell, 1, 1) : '';
    }

    public function hasBorder($value) 
    {
        return in_array($value, $this->borders);
    }

    #[Computed]
    public function showXLabel() 
    {
        return $this->getYCoord() == '1';
    }

    #[Computed]
    public function showYLabel() 
    {
        return $this->getXCoord() == 'A';
    }

    #[Computed]
    public function getXOffset() 
    {
        $res = 0;
        switch($this->getXCoord()) {
            case 'B':
                $res = 1;
                break;
            case 'C':
                $res = 2;
                break;
            case 'D': 
                $res = 3;
                break;
            case 'E': 
                $res = 4;
                break;
            case 'F': 
                $res = 5;
                break;
            case 'G': 
                $res = 6;
                break;
            case 'H': 
                $res = 7;
                break;
            case 'I': 
                $res = 8;
                break;
            default: 
                $res = 0;
                break;
        };
        return "left: -" . $res . "px;";
    }

    #[Computed]
    public function getYOffset() 
    {
        return "top: -" . ($this->getYCoord()) - 1 . "px;";
    }

    #[Computed]
    public function getOffset() 
    {
        return $this->getYOffset() . ' ' . $this->getXOffset();
    }

    #[Computed]
    public function showPossibilities()
    {
        return count($this->possibilities) > 0;
    }

    private function setBorders() 
    {
        switch ($this->getXCoord()) {
            case 'A':
                $this->borders[] = 'left';
                break;
            case 'C':
            case 'F':
            case 'I':
                $this->borders[] = 'right';
                break;
        }

        switch ($this->getYCoord()) {
            case '1':
                $this->borders[] = 'top';
                break;
            case '3':
            case '6':
            case '9':
                $this->borders[] = 'bottom';
                break;
        }
    }

    public function selectCell() 
    {
        if (!$this->disabled) {
            $this->dispatch('cell_selected', cell: $this->cell, cellValue: $this->cellValue, possibilities: $this->possibilities);
            $this->edit = true;
        }
    }

    #[On('cell_selected')]
    public function unselectCell($cell) 
    {
        if ($cell != $this->cell) {
            $this->edit = false;
        }
    }

    #[On('set_gaming_state')]
    public function setGamingState($state)
    {
        switch($state) {
            case 'setup':
                $this->disabled = false;
                $this->settingMode = true;
                break;
            case 'playing':
                $this->disabled = false;
                if ($this->cellValue == '') {
                    $this->settingMode = false;
                }
                $this->edit = false;
                break;
        }
    }

    public function hasPossibility($value): bool
    {
        return in_array((int) $value, $this->possibilities);
    }

    #[Computed]
    public function cellToText()
    {
        return $this->cell;
    }

    #[On('set_cell_values')]
    public function setCellValues($cell, $values, $showPossibilities)
    {
        if ($cell == $this->cellToText()) {
            if (!$showPossibilities) {
                $value = (count($values) > 0) ? $values[0] : '';
                $this->cellValue = ($this->cellValue != $value) ? $value : ''; // Set cell value or reset it
            } else {
                $this->possibilities = $values;
            }

            // Save to db
        }
    }

    public function isPopulated($cell) {
        if ($cell == $this->cell) {
            return (($this->cellValue != '') || (count($this->possibilities) > 0)); 
        }
        return true;
    }

    public function render()
    {
        return view('livewire.single-cell');
    }
}
