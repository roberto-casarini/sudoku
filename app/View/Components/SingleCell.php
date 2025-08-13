<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SingleCell extends Component
{
    public $cell = [];

    /**
     * Create a new component instance.
     */
    public function __construct($cell)
    {
        $this->cell = $cell;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.single-cell', ['cell' => $this->cell]);
    }
}
