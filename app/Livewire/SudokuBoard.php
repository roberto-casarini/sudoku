<?php

namespace App\Livewire;

use App\Classes\SudokuBL;
use App\Classes\SudokuCell;
use Livewire\Component;
use Livewire\Attributes\Computed;

/**
 * Component for rendering the complete Sudoku board.
 * 
 * Displays all 81 cells in a 9x9 grid, integrating with SudokuBL
 * for game state management.
 */
class SudokuBoard extends Component
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
     * Get all cells from the game board.
     * 
     * @return array<SudokuCell> Array of all cells in the board
     */
    #[Computed]
    public function cells(): array
    {
        return $this->getGame()->getBoard()->getAllCells();
    }

    /**
     * Render the component view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.sudoku-board', [
            'cells' => $this->cells,
        ]);
    }
}
