<?php

namespace App\Livewire;

use Livewire\Component;

class SelectNumber extends Component
{
    //public $multiple;

    //public $selectedValues = [];

    //public $hovering = '';

    public $cell = '';

    public function mount($cell)
    {
        $this->cell = $cell;
    }

    public function render()
    {
        return view('livewire.select-number');
    }

    /*public function isSelected($value) 
    {
        return in_array($value, $this->selectedValues);
    }

    public function selectValue($value) 
    {
        if (!$this->isSelected($value)) {
            if (!$this->multiple) {
                $this->selectedValues = [];
            }
            $this->selectedValues[] = $value;
        } else if ($this->multiple) { // Toggle functionality only for multiple values selection
            $this->selectedValues = array_filter($this->selectedValues, function ($itemValue) use($value) {
                return $itemValue != $value;
            });
        }
    }*/

    /*public function setHovering($value)
    {
        $this->hovering = $value;
    }

    public function unsetHovering()
    {
        $this->hovering = '';
    }

    public function isHovering($value)
    {
        return $this->hovering == $value;
    }*/

    public function closeEdit()
    {
        return $this->dispatch('closeEdit', cell: $this->cell );
    }

    public function sendValues($values, $isMultiple)
    {
        return $this->dispatch('cell.setvalues', cell: $this->cell, values: $values, multiple: $isMultiple);
    }
}
