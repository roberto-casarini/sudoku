<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Traits\FlashMessageTrait;

class SelectNumber extends Component
{
    use FlashMessageTrait;

    public function render()
    {
        return view('livewire.select-number');
    }

    public function setCellValues($cell, $values, $showPossibilities)
    {
        $this->dispatch('set_cell_values', cell: $cell, values: $values, showPossibilities: $showPossibilities);
    }
}
