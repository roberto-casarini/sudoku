<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Session;

class SudokuBoard extends Component
{
    public $cells = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->cells = Session::get('game')['cells'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sudoku-board');
    }
}
