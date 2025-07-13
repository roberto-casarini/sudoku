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

    public $selectedValues = [];

    public function setCellValue($value) 
    {
        if ($this->cell == '') {
            $this->sendMessage('warning', 'Attenzione!', 'Devi selezionare una cella per inserire un numero!');
        } else {
            if (!$this->showPossibilities) {
                $this->selectedValues = [];
                if (!$this->isSelected($value)) {
                    $this->selectedValues[] = $value;
                }
            } else { 
                if (!$this->isSelected($value)) {
                    $this->selectedValues[] = $value;
                } else {
                    $this->selectedValues = array_filter($this->selectedValues, function($itemValue) use($value) {
                        return $itemValue != $value;
                    });
                }
            }
            $this->dispatch('set_cell_values', cell: $this->cell, values: $this->selectedValues, showPossibilities: $this->showPossibilities);
        }
    }

    public function setPossibilities() 
    {
        $this->showPossibilities = !$this->showPossibilities;
        if ($this->cell != '') {
            $this->selectedValues = [];
        }
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
    }

    #[On('set_gaming_state')]
    public function setGamingState($state)
    {
        switch($state) {
            case 'beginning':
                $this->disabled = true;
                $this->disabled_possibilities = true;
                $this->showPossibilities = false;
                $this->selectedValues = [];
                $this->cell = '';
                break;
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
            case 'end':
                $this->disabled = true;
                $this->disabled_possibilities = true;
                break;    
        }
    }

    private function resetSelect() 
    {
        $this->showPossibilities = false;
        $this->selectedValues = [];
    }
}
