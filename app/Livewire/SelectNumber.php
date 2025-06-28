<?php

namespace App\Livewire;

use Livewire\Component;

class SelectNumber extends Component
{
    public $cell = '';

    public function mount($cell)
    {
        $this->cell = $cell;
    }

    public function render()
    {
        return view('livewire.select-number');
    }

    public function sendValues($values, $isMultiple)
    {
        return $this->dispatch('cell.setvalues', cell: $this->cell, values: $values, multiple: $isMultiple);
    }
}
