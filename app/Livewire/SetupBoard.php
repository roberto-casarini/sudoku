<?php

namespace App\Livewire;

use App\Classes\SudokuBL;
use App\Classes\SudokuDTO;
use Livewire\Component;
use Livewire\Attributes\Computed;

/**
 * Component for managing game state transitions (setup, play, pause, reset).
 * 
 * Provides controls for changing the game state and integrates with
 * SudokuBL to persist state changes.
 */
class SetupBoard extends Component
{
    /** @var SudokuBL|null The game business logic instance */
    protected ?SudokuBL $game = null;

    /**
     * Initialize the component with the game instance.
     * 
     * @param SudokuBL $game The game business logic instance
     * @return void
     */
    public function mount(SudokuBL $game): void
    {
        $this->game = $game;
    }

    /**
     * Get the game instance, initializing it if needed.
     * 
     * @return SudokuBL The game business logic instance
     */
    protected function getGame(): SudokuBL
    {
        if ($this->game === null) {
            $this->game = app(SudokuBL::class);
        }
        return $this->game;
    }

    /**
     * Get the current game state.
     * 
     * @return string The current game state
     */
    #[Computed]
    public function currentState(): string
    {
        return $this->getGame()->getStatus();
    }

    /**
     * Set game state to setup mode.
     * 
     * @return void
     */
    public function setup(): void
    {
        $this->setCurrentState(SudokuDTO::SETUP_STATE);
    }

    /**
     * Set game state to playing mode.
     * 
     * @return void
     */
    public function play(): void
    {
        $this->setCurrentState(SudokuDTO::PLAYING_STATE);
    }

    /**
     * Toggle between playing and paused states.
     * 
     * @return void
     */
    public function pause(): void
    {
        $state = $this->currentState === SudokuDTO::PAUSED_STATE
            ? SudokuDTO::PLAYING_STATE
            : SudokuDTO::PAUSED_STATE;

        $this->setCurrentState($state);
    }

    /**
     * Restart the game (set to playing state).
     * 
     * @return void
     */
    public function restart(): void
    {
        $this->setCurrentState(SudokuDTO::PLAYING_STATE);
    }

    /**
     * Stop the game (set to end state).
     * 
     * @return void
     */
    public function stop(): void
    {
        $this->setCurrentState(SudokuDTO::END_STATE);
    }

    /**
     * Reset the game to beginning state.
     * 
     * @return void
     */
    public function resetGame(): void
    {
        $this->getGame()->reset();
        $this->setCurrentState(SudokuDTO::BEGINNING_STATE);
    }

    /**
     * Set the current game state and dispatch event.
     * 
     * @param string $state The new game state
     * @return void
     */
    private function setCurrentState(string $state): void
    {
        $this->getGame()->setStatus($state);
        $this->dispatch('set_gaming_state', state: $state);
    }

    /**
     * Check if setup button is disabled.
     * 
     * @return bool True if disabled
     */
    #[Computed]
    public function isSetupDisabled(): bool
    {
        return $this->currentState !== SudokuDTO::BEGINNING_STATE;
    }

    /**
     * Check if start/play button is disabled.
     * 
     * @return bool True if disabled
     */
    #[Computed]
    public function isStartDisabled(): bool
    {
        return $this->currentState !== SudokuDTO::SETUP_STATE;
    }

    /**
     * Check if stop button is disabled.
     * 
     * @return bool True if disabled
     */
    #[Computed]
    public function isStopDisabled(): bool
    {
        return in_array($this->currentState, [
            SudokuDTO::BEGINNING_STATE,
            SudokuDTO::SETUP_STATE,
            SudokuDTO::END_STATE
        ], true);
    }

    /**
     * Check if pause button is disabled.
     * 
     * @return bool True if disabled
     */
    #[Computed]
    public function isPauseDisabled(): bool
    {
        return !in_array($this->currentState, [
            SudokuDTO::PLAYING_STATE,
            SudokuDTO::PAUSED_STATE
        ], true);
    }

    /**
     * Check if reset button is disabled.
     * 
     * @return bool True if disabled
     */
    #[Computed]
    public function isResetDisabled(): bool
    {
        return $this->currentState !== SudokuDTO::END_STATE;
    }

    /**
     * Get the text for the pause/restart button.
     * 
     * @return string The button text
     */
    #[Computed]
    public function pauseButtonText(): string
    {
        return $this->currentState === SudokuDTO::PAUSED_STATE ? "Restart" : "Pause";
    }

    /**
     * Render the component view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.setup-board');
    }
}
