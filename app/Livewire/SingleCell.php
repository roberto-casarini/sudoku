<?php

namespace App\Livewire;

use App\Classes\SudokuBL;
use App\Classes\SudokuCell;
use App\Classes\SudokuDTO;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

/**
 * Component representing a single cell in the Sudoku board.
 * 
 * Displays and manages interaction with individual Sudoku cells,
 * integrating with SudokuBL for state management.
 */
class SingleCell extends Component
{
    /** @var SudokuBL|null The game business logic instance */
    protected ?SudokuBL $game = null;

    /** @var string The cell coordinate (e.g., "A-1") */
    public string $coord;

    /** @var bool Whether this cell is currently in edit mode */
    public bool $edit = false;

    /** @var array<string>|null Border positions for visual styling (cached) */
    private ?array $borders = null;

    /**
     * Initialize the component with game instance and cell coordinate.
     * 
     * @param SudokuBL $game The game business logic instance
     * @param string $coord The cell coordinate (e.g., "A-1")
     * @return void
     */
    public function mount(SudokuBL $game, string $coord): void
    {
        $this->game = $game;
        $this->coord = $coord;
        $this->setBorders();
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
     * Get the cell instance from the game board.
     * 
     * @return SudokuCell|null The cell instance, or null if not found
     */
    #[Computed]
    public function cell(): ?SudokuCell
    {
        [$x, $y] = explode('-', $this->coord);
        return $this->getGame()->getBoard()->findCell($x, $y);
    }

    /**
     * Get the cell value.
     * 
     * @return int|null The cell value, or null if empty
     */
    #[Computed]
    public function cellValue(): ?int
    {
        return $this->cell()?->value;
    }

    /**
     * Get the cell possibilities.
     * 
     * @return array<int> Array of possible values
     */
    #[Computed]
    public function possibilities(): array
    {
        return $this->cell()?->possibilities ?? [];
    }

    /**
     * Check if the cell should show possibilities instead of value.
     * 
     * @return bool True if possibilities should be shown
     */
    #[Computed]
    public function showPossibilities(): bool
    {
        return count($this->possibilities) > 0;
    }

    /**
     * Check if the cell is disabled based on game state.
     * 
     * @return bool True if disabled
     */
    #[Computed]
    public function disabled(): bool
    {
        $status = $this->getGame()->getStatus();
        return in_array($status, [SudokuDTO::BEGINNING_STATE, SudokuDTO::END_STATE], true);
    }

    /**
     * Check if the cell is in setup mode.
     * 
     * @return bool True if in setup mode
     */
    #[Computed]
    public function settingMode(): bool
    {
        return $this->getGame()->getStatus() === SudokuDTO::SETUP_STATE;
    }

    /**
     * Check if this cell was set during setup (should be black, not red).
     * 
     * @return bool True if the cell value was set during setup
     */
    #[Computed]
    public function isSetupCell(): bool
    {
        return $this->cell()?->setup ?? false;
    }

    /**
     * Get the borders array, initializing it if needed.
     * 
     * @return array<string> Border positions for visual styling
     */
    private function getBorders(): array
    {
        if ($this->borders === null && isset($this->coord)) {
            $this->setBorders();
        }
        return $this->borders ?? [];
    }

    /**
     * Check if the cell has a border at the specified position.
     * 
     * @param string $value The border position (left, right, top, bottom)
     * @return bool True if the border exists
     */
    public function hasBorder(string $value): bool
    {
        return in_array($value, $this->getBorders(), true);
    }

    /**
     * Handle cell selection.
     * 
     * Dispatches an event when the cell is clicked and enabled.
     * 
     * @return void
     */
    public function selectCell(): void
    {
        if (!$this->disabled) {
            $this->edit = true;
            $this->dispatch('cell_selected', cell: $this->coord);
        }
    }

    /**
     * Check if a specific possibility value exists in the cell.
     * 
     * @param int $value The value to check
     * @return bool True if the possibility exists
     */
    public function hasPossibility(int $value): bool
    {
        return in_array($value, $this->possibilities, true);
    }

    /**
     * Get the X coordinate (column letter).
     * 
     * @return string The X coordinate (A-I)
     */
    #[Computed]
    public function xCoordinate(): string
    {
        [$x] = explode('-', $this->coord);
        return $x;
    }

    /**
     * Get the Y coordinate (row number).
     * 
     * @return string The Y coordinate (1-9)
     */
    #[Computed]
    public function yCoordinate(): string
    {
        [, $y] = explode('-', $this->coord);
        return $y;
    }

    /**
     * Check if X label should be shown (first row).
     * 
     * @return bool True if label should be shown
     */
    #[Computed]
    public function showXLabel(): bool
    {
        return $this->yCoordinate === '1';
    }

    /**
     * Check if Y label should be shown (first column).
     * 
     * @return bool True if label should be shown
     */
    #[Computed]
    public function showYLabel(): bool
    {
        return $this->xCoordinate === 'A';
    }

    /**
     * Get X offset for positioning.
     * 
     * @return string CSS style for X offset
     */
    #[Computed]
    public function xOffset(): string
    {
        $offset = match($this->xCoordinate) {
            'B' => 1,
            'C' => 2,
            'D' => 3,
            'E' => 4,
            'F' => 5,
            'G' => 6,
            'H' => 7,
            'I' => 8,
            default => 0,
        };
        
        return "left: -{$offset}px;";
    }

    /**
     * Get Y offset for positioning.
     * 
     * @return string CSS style for Y offset
     */
    #[Computed]
    public function yOffset(): string
    {
        $offset = (int)$this->yCoordinate - 1;
        return "top: -{$offset}px;";
    }

    /**
     * Get combined offset for positioning.
     * 
     * @return string CSS style for combined offset
     */
    #[Computed]
    public function offset(): string
    {
        return $this->yOffset . ' ' . $this->xOffset;
    }

    /**
     * Handle unselection when another cell is selected.
     * 
     * @param string $cell The coordinate of the newly selected cell
     * @return void
     */
    #[On('cell_selected')]
    public function unselectCell(string $cell): void
    {
        if ($cell !== $this->coord) {
            $this->edit = false;
        }
    }

    /**
     * Handle cell update event to refresh the component.
     * 
     * When a cell value is updated, this event is dispatched to force
     * the component to re-render and re-evaluate computed properties.
     * 
     * @param string $cell The coordinate of the updated cell
     * @return void
     */
    #[On('cell_updated')]
    public function refreshCell(string $cell): void
    {
        // When this cell is updated, force Livewire to re-render
        // by resetting a property that will cause computed properties to re-evaluate
        if ($cell === $this->coord) {
            // Reset borders cache to force re-evaluation of all computed properties
            $this->borders = null;
            // The event listener being called will trigger a re-render
            // and all computed properties will be re-evaluated with fresh game state
        }
    }

    /**
     * Handle game state changes.
     * 
     * Updates edit state based on game state transitions.
     * 
     * @param string $state The new game state
     * @return void
     */
    #[On('set_gaming_state')]
    public function setGamingState(string $state): void
    {
        if ($state === SudokuDTO::PLAYING_STATE) {
            $this->edit = false;
        } elseif (in_array($state, [SudokuDTO::BEGINNING_STATE, SudokuDTO::END_STATE], true)) {
            $this->edit = false;
        }
    }

    /**
     * Set cell values using business logic.
     * 
     * This method is called when values are set from the SelectNumber component.
     * 
     * @param string $cell The cell coordinate
     * @param array<int> $values The values to set
     * @param bool $showPossibilities Whether setting possibilities or value
     * @return void
     */
    #[On('set_cell_values')]
    public function setCellValues(string $cell, array $values, bool $showPossibilities): void
    {
        if ($cell !== $this->coord) {
            return;
        }

        [$x, $y] = explode('-', $cell);
        $gameStatus = $this->getGame()->getStatus();
        $isSetupMode = $gameStatus === SudokuDTO::SETUP_STATE;

        if ($showPossibilities) {
            // Toggle possibilities for each value
            foreach ($values as $value) {
                $this->getGame()->setCellValue($x, $y, (int)$value, true);
            }
        } else {
            // Set cell value (toggles if same value)
            $value = count($values) > 0 ? (int)$values[0] : null;
            $currentCell = $this->getGame()->getBoard()->findCell($x, $y);
            $newValue = ($currentCell && $currentCell->value === $value) ? null : $value;
            
            // Use setup method if in setup mode, otherwise use normal method
            if ($isSetupMode) {
                $this->getGame()->setCellValueSetup($x, $y, $newValue);
            } else {
                $this->getGame()->setCellValue($x, $y, $newValue, false);
            }
        }

        $this->edit = false;
    }

    /**
     * Initialize borders based on cell position.
     * 
     * @return void
     */
    private function setBorders(): void
    {
        $this->borders = [];
        $x = $this->xCoordinate;
        $y = $this->yCoordinate;

        // Left border (first column)
        if ($x === 'A') {
            $this->borders[] = 'left';
        }

        // Right borders (sector boundaries)
        if (in_array($x, ['C', 'F', 'I'], true)) {
            $this->borders[] = 'right';
        }

        // Top border (first row)
        if ($y === '1') {
            $this->borders[] = 'top';
        }

        // Bottom borders (sector boundaries)
        if (in_array($y, ['3', '6', '9'], true)) {
            $this->borders[] = 'bottom';
        }
    }

    /**
     * Render the component view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.single-cell');
    }
}
