<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Traits\FlashMessageTrait;

class SelectNumber extends Component
{
    use FlashMessageTrait;

    public $cell = '';

    public $disabled = true;

    public $disabled_possibilities = true;

    public $showPossibilities = false;

    public $hovering = '';

    public $selectedValues = [];

    public function setCellValue($value) 
    {
        if ($this->cell == '') {
            $this->sendMessage('warning', 'Attenzione!', 'Devi selezionare una cella per inserire un numero!');
        } else {
            if (!$this->isSelected($value)) {
                if (!$this->showPossibilities) {
                    $this->selectedValues = [];
                }
                $this->selectedValues[] = $value;
            } else if (!$this->showPossibilities && $this->isSelected($value)) {
                $this->selectedValues = [];
            } else if ($this->showPossibilities) { // Toggle functionality only for multiple values selection
                $this->selectedValues = array_filter($this->selectedValues, function($itemValue) use($value) {
                    return $itemValue != $value;
                });
            }
            $this->dispatchCellValues($this->cell, $this->selectedValues, $this->showPossibilities);
        }
    }

    public function dispatchCellValues($cell, $values, $showPossibilities)
    {
        $this->dispatch('set_cell_values', cell: $cell, values: $values, showPossibilities: $showPossibilities);
    }

    public function setPossibilities() 
    {
        $this->showPossibilities = !$this->showPossibilities;
        $this->selectedValues = [];
    }

    #[On('cell_selected')]
    public function cellSelected($cell, $cellValue, $possibilities) 
    {
        $this->cell = $cell;
        if (count($possibilities) > 0) {
            $this->selectedValues = $possibilities;
            $this->showPossibilities = true;
        } else {
            $this->selectedValues = [$cellValue];
            $this->showPossibilities = false;
        }
        //$this->resetSelect();
    }

    private function resetSelect() 
    {
        $this->showPossibilities = false;
        $this->selectedValues = [];
        $this->hovering = '';
    }

    #[On('set_gaming_state')]
    public function setGamingState($state)
    {
        switch($state) {
            case 'setup':
                $this->disabled = false;
                $this->disabled_possibilities = true;
                break;
            case 'playing':
                $this->disabled = false;
                $this->disabled_possibilities = false;
                $this->cell = '';
                $this->resetSelect();
                break;
        }
    }

    public function isHovering($value) 
    {
        return (int) $this->hovering == (int) $value;
    }

    public function setHovering($value = '')
    {
        $this->hovering = $value;
    }

    public function possibilityButtonText() 
    {
        return $this->showPossibilities ? 'Set Value' : 'Set Possibilities';
    }

    public function isSelected($value) 
    {
        return in_array($value, $this->selectedValues);
    }

    public function render()
    {
        return view('livewire.select-number');
    }
}
