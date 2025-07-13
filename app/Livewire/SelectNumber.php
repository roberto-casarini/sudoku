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

    //public $hovering = '';

    public $selectedValues = [];

    public function setCellValue($value) 
    {
        if ($this->cell == '') {
            $this->sendMessage('warning', 'Attenzione!', 'Devi selezionare una cella per inserire un numero!');
        } else {

            // Se sono sul valore singolo 
            // resetto i valori selezionati
            // e imposto il singolo valore
            
            // Se sono sul valore singolo
            // e il valore selezionato è uguale a quello già presente resetto il valore

            // Se sono sul valore multiplo
            // inserisco il valore o lo resetto se già presente


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

    private function resetSelect() 
    {
        $this->showPossibilities = false;
        $this->selectedValues = [];
        //$this->hovering = '';
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

    /*public function isHovering($value) 
    {
        return (int) $this->hovering == (int) $value;
    }

    public function setHovering($value = '')
    {
        $this->hovering = $value;
    }*/

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
