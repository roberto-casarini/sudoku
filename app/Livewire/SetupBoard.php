<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class SetupBoard extends Component
{
    const BEGINNING_STATE = 0;
    const SETUP_STATE = 1;
    const GAMING_STATE = 2;
    const PAUSED_STATE = 3;
    const END_STATE = 4;

    public $startStopText = "Start";

    public $currentState = self::BEGINNING_STATE;

    public function setup()
    {
        $this->setCurrentState(self::SETUP_STATE);
    }

    public function play()
    {
        $this->setCurrentState(self::GAMING_STATE);
    }

    public function pause()
    {
        if ($this->currentState == self::PAUSED_STATE) { 
            $this->setCurrentState(self::GAMING_STATE);
        } else {
            $this->setCurrentState(self::PAUSED_STATE);
        }
    }

    public function restart()
    {
        $this->setCurrentState(self::GAMING_STATE);
    }

    public function stop()
    {
        $this->setCurrentState(self::END_STATE);
    }

    public function resetGame()
    {
        $this->setCurrentState(self::BEGINNING_STATE);
    }

    private function setCurrentState($state)
    {
        $this->currentState = $state;
        $this->dispatch('set-gaming-state', state: $state);
    }

    public function render()
    {
        return view('livewire.setup-board');
    }

    public function isSetupDisabled() 
    {
        return $this->currentState != self::BEGINNING_STATE;
    }

        
    public function isStartDisabled() 
    {
        return $this->currentState != self::SETUP_STATE;
    }

    public function isStopDisabled() 
    {
        return in_array($this->currentState, [self::BEGINNING_STATE, self::SETUP_STATE, self::END_STATE]);
    }
        
    public function isPauseDisabled() 
    {
        return !in_array($this->currentState, [self::GAMING_STATE, self::PAUSED_STATE]);
    }
        
    public function isResetDisabled() 
    {
        return $this->currentState != self::END_STATE;
    }

    #[Computed]
    public function pauseButtonText()
    {
        return ($this->currentState == self::PAUSED_STATE) ? "Restart" : "Pause";
    }
}
