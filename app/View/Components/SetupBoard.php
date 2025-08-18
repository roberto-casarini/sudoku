<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SetupBoard extends Component
{
    const BEGINNING_STATE = 'beginning';
    const SETUP_STATE = 'setup';
    const PLAYING_STATE = 'playing';
    const PAUSED_STATE = 'paused';
    const END_STATE = 'end';

    public $currentState = self::BEGINNING_STATE;

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.setup-board');
    }
}
