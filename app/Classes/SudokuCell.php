<?php

namespace App\Classes;

/**
 * Represents a single cell in a Sudoku board.
 * 
 * A cell can have a value (1-9) or a list of possible values.
 * The setup flag indicates if the value was set during initial board setup.
 */
class SudokuCell
{
    public string $xCoordinate;
    public string $yCoordinate;
    public ?int $value = null;

    /** @var array<int> */
    public array $possibilities = [];

    public bool $setup = false;

    public function __construct(string $xCoordinate, string|int $yCoordinate)
    {
        $this->xCoordinate = $xCoordinate;
        $this->yCoordinate = (string) $yCoordinate;
    }

    /**
     * Check if the cell has any possible values.
     */
    public function hasPossibilities(): bool
    {
        return count($this->possibilities) > 0;
    }

    /**
     * Reset the cell value and possibilities.
     * 
     * @param int|null $value The new value (null to clear)
     * @param array<int> $possibilities The new list of possible values
     * @return array<int>|int|null Returns possibilities if provided, otherwise the value
     */
    public function resetValue(?int $value, array $possibilities = []): array|int|null
    {
        $this->possibilities = $possibilities;
        $this->value = $value;
        $this->setup = false;
        
        return count($possibilities) > 0 ? $this->possibilities : $this->value;
    }

    /**
     * Set the cell value (toggles if same value is set again).
     * 
     * @param int|null $value The value to set
     * @return int|null The new value (null if toggled off)
     */
    public function setValue(?int $value): ?int
    {
        $this->possibilities = [];
        $this->value = $this->toggleValue($value);
        $this->setup = false;
        
        return $this->value;
    }

    /**
     * Add or remove a value from the possibilities list.
     * 
     * @param int $value The value to toggle in possibilities
     * @return array<int> The updated possibilities list
     */
    public function togglePossibility(int $value): array
    {
        $key = array_search($value, $this->possibilities, true);
        
        if ($key !== false) {
                    unset($this->possibilities[$key]);
                    $this->possibilities = array_values($this->possibilities);
        } else {
            $this->possibilities[] = $value;
            sort($this->possibilities); // Keep possibilities sorted
        }
        
        $this->value = null;
        $this->setup = false;
        
        return $this->possibilities;
    }

    /**
     * Set the cell value during initial board setup.
     * 
     * @param int|null $value The value to set
     * @return int|null The new value (null if toggled off)
     */
    public function setValueSetup(?int $value): ?int
    {
        $this->value = $this->toggleValue($value);
        $this->setup = true;
        
        return $this->value;
    }

    /**
     * Toggle value: if the new value equals current, set to null; otherwise set to new value.
     * 
     * @param int|null $newValue The new value to set
     * @return int|null The resulting value
     */
    private function toggleValue(?int $newValue): ?int
    {
        if ($this->value === $newValue) {
            return null;
        }
        
        return $newValue;
    }

    public function __serialize(): array
    {
        return [
            'xCoordinate' => $this->xCoordinate,
            'yCoordinate' => $this->yCoordinate,
            'value' => $this->value,
            'possibilities' => $this->possibilities,
            'setup' => $this->setup
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->xCoordinate = $data['xCoordinate'];
        $this->yCoordinate = $data['yCoordinate'];
        $this->value = $data['value'];
        $this->possibilities = $data['possibilities'];
        $this->setup = $data['setup'];
    }
}