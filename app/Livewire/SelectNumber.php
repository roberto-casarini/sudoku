<?php

namespace App\Livewire;

use App\Classes\SudokuBL;
use App\Classes\SudokuDTO;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Livewire\Traits\FlashMessageTrait;

/**
 * Component for selecting numbers and possibilities for Sudoku cells.
 * 
 * This component provides a UI for users to input values or toggle possibilities
 * for selected cells. It integrates with SudokuBL to manage game state.
 */
class SelectNumber extends Component
{
    use FlashMessageTrait;

    /** @var SudokuBL The game business logic instance */
    public SudokuBL $game;

    /** @var string The currently selected cell coordinate (e.g., "A-1") */
    public string $cell = '';

    /** @var bool Whether we're in possibilities mode */
    public bool $showPossibilities = false;

    /** @var array<int> Array of selected values for UI state */
    public array $selectedValues = [];

    /**
     * Initialize the component with the game instance.
     * 
     * @param SudokuBL $game The game business logic instance
     * @return void
     */
    public function mount(SudokuBL $game): void
    {
        $this->game = $game;
        $this->updateDisabledState();
    }

    /**
     * Set a cell value or toggle a possibility using business logic.
     * 
     * @param int $value The value to set or toggle (1-9)
     * @return void
     */
    public function setCellValue(int $value): void
    {
        if ($this->cell === '') {
            $this->sendMessage(
                'warning',
                'Attenzione!',
                'Devi selezionare una cella per inserire un numero!'
            );
            return;
        }

        [$x, $y] = explode('-', $this->cell);

        if ($this->showPossibilities) {
            // Toggle possibility using business logic
            $this->game->setCellValue($x, $y, $value, true);
        } else {
            // Set cell value using business logic
            // Toggle if same value (get current value first)
            $currentCell = $this->game->getBoard()->findCell($x, $y);
            $newValue = ($currentCell && $currentCell->value === $value) ? null : $value;
            $this->game->setCellValue($x, $y, $newValue, false);
        }

        // Update UI state from business logic
        $cellObj = $this->game->getBoard()->findCell($x, $y);
        if ($cellObj) {
            if ($this->showPossibilities) {
                $this->selectedValues = $cellObj->possibilities;
            } else {
                $this->selectedValues = $cellObj->value !== null ? [$cellObj->value] : [];
            }
        }
    }

    /**
     * Toggle between value mode and possibilities mode.
     * 
     * @return void
     */
    public function setPossibilities(): void
    {
        $this->showPossibilities = !$this->showPossibilities;
        
        // Values will update automatically via cellSelected when cell changes
    }


    /**
     * Get the text for the possibilities toggle button.
     * 
     * @return string The button text
     */
    #[Computed]
    public function possibilityButtonText(): string
    {
        return $this->showPossibilities ? 'Set Value' : 'Set Possibilities';
    }

    /**
     * Check if a value is currently selected.
     * 
     * @param int $value The value to check
     * @return bool True if the value is selected
     */
    public function isSelected(int $value): bool
    {
        return in_array($value, $this->selectedValues, true);
    }

    /**
     * Check if the component is disabled based on game state.
     * 
     * @return bool True if disabled
     */
    #[Computed]
    public function disabled(): bool
    {
        $status = $this->game->getStatus();
        return in_array($status, [SudokuDTO::BEGINNING_STATE, SudokuDTO::END_STATE], true);
    }

    /**
     * Check if possibilities mode is disabled based on game state.
     * 
     * @return bool True if possibilities are disabled
     */
    #[Computed]
    public function disabledPossibilities(): bool
    {
        $status = $this->game->getStatus();
        return $status === SudokuDTO::BEGINNING_STATE 
            || $status === SudokuDTO::SETUP_STATE 
            || $status === SudokuDTO::END_STATE;
    }

    /**
     * Handle when a cell is selected from the board.
     * 
     * Updates the component state to reflect the selected cell's current
     * value or possibilities from the business logic.
     * 
     * @param string $cell The cell coordinate
     * @return void
     */
    #[On('cell_selected')]
    public function cellSelected(string $cell): void
    {
        $this->cell = $cell;
        
        // Update selected values from the actual cell state in business logic
        if ($cell !== '') {
            [$x, $y] = explode('-', $cell);
            $cellObj = $this->game->getBoard()->findCell($x, $y);
            
            if ($cellObj) {
                if (count($cellObj->possibilities) > 0) {
                    $this->selectedValues = $cellObj->possibilities;
                    $this->showPossibilities = true;
                } else {
                    $this->selectedValues = $cellObj->value !== null ? [$cellObj->value] : [];
                    $this->showPossibilities = false;
                }
            } else {
                $this->selectedValues = [];
                $this->showPossibilities = false;
            }
        } else {
            $this->selectedValues = [];
            $this->showPossibilities = false;
        }
    }

    /**
     * Update component state based on game state changes.
     * 
     * @param string $state The new game state
     * @return void
     */
    #[On('set_gaming_state')]
    public function setGamingState(string $state): void
    {
        if ($state === SudokuDTO::PLAYING_STATE) {
            $this->cell = '';
            $this->showPossibilities = false;
            $this->selectedValues = [];
        } elseif (in_array($state, [SudokuDTO::BEGINNING_STATE, SudokuDTO::END_STATE], true)) {
            $this->cell = '';
            $this->showPossibilities = false;
            $this->selectedValues = [];
        }
    }

    /**
     * Render the component view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.select-number');
    }
}
