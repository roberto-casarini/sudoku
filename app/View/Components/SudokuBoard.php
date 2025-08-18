<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SudokuBoard extends Component
{
    public $coords = [];

    public function __construct() 
    {
        //Draws the sudoku board and cells
        foreach(range(1, 9) as $y) {
            foreach(range(1, 9) as $x) {
                $xValue = toLetter($x);
                $this->coords[] = $xValue . '-' . $y;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sudoku-board');
    }
}
