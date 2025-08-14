<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Session;

class SudokuBoard extends Component
{
    public $cells = [];
    public $disabled = true;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $game = Session::get('game');
        $this->cells = $game['cells'];
        $this->disabled = $game['disabled'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sudoku-board');
    }
}
