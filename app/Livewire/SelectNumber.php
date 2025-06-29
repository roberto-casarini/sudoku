<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class SelectNumber extends Component
{
    public $cell = '';

    public function render()
    {
        return view('livewire.select-number');
    }

    #[On('setting-edit')]
    public function setCell($cell)
    {
        $this->cell = $cell;
    }

    public function sendValue($value, $isPossibility)
    {
        return $this->dispatch('cell.setvalue', cell: $this->cell, value: $value, possibility: $isPossibility);
    }
}
