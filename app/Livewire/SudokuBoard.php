<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Wireables\SingleCellProps;

class SudokuBoard extends Component
{
    public array $cells = [];

    public function mount()
    {
        foreach(range(1, 9) as $y) {
            foreach(range(1, 9) as $x) {
                $this->cells[] = $this->toLetter($x) . $y;
            }
        }
    }

    public function render()
    {
        return view('livewire.sudoku-board');
    }

    private function toLetter($value): string
    {
        return match($value) {
            1 => "A",
            2 => "B",
            3 => "C",
            4 => "D",
            5 => "E", 
            6 => "F",
            7 => "G",
            8 => "H",
            9 => "I"
        };
    }
}
