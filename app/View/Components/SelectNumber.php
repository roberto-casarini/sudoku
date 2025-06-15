<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectNumber extends Component
{
    public $multiple;

    public $cell = '';

    /**
     * Create a new component instance.
     */
    public function __construct($cell, $multiple)
    {
        $this->cell = $cell;
        $this->multiple = $multiple;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-number');
    }
}
