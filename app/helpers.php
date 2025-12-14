<?php

use App\Classes\SudokuCell;

if (!function_exists('getCellCoords')) {
    /**
     * Get cell coordinates from a cell array or object.
     * 
     * @param array<string, mixed>|SudokuCell|null $cell The cell data
     * @return string The cell coordinates in format "X-Y" (e.g., "A-1")
     */
    function getCellCoords($cell): string
    {
        if (is_null($cell)) {
            return '';
        }

        if (is_object($cell) && $cell instanceof SudokuCell) {
            return $cell->xCoordinate . '-' . $cell->yCoordinate;
        }

        if (is_array($cell) && isset($cell['xCoordinate']) && isset($cell['yCoordinate'])) {
            return $cell['xCoordinate'] . '-' . $cell['yCoordinate'];
        }

        return '';
    }
}

if (!function_exists('getCellValue')) {
    /**
     * Get cell value or possibilities from a cell array or object.
     * 
     * @param array<string, mixed>|SudokuCell|null $cell The cell data
     * @return array<int>|int|null The cell value or possibilities
     */
    function getCellValue($cell): array|int|null
    {
        if (is_null($cell)) {
            return null;
        }

        if (is_object($cell) && $cell instanceof SudokuCell) {
            return count($cell->possibilities) > 0 ? $cell->possibilities : $cell->value;
        }

        if (is_array($cell)) {
            if (isset($cell['possibilities']) && count($cell['possibilities']) > 0) {
                return $cell['possibilities'];
            }
            return $cell['value'] ?? null;
        }

        return null;
    }
}

if (!function_exists('sudoku_implementation')) {
    /**
     * Get the current Sudoku implementation.
     * 
     * @return string The current implementation ('livewire' or 'controllers')
     */
    function sudoku_implementation(): string
    {
        return config('sudoku.implementation', 'controllers');
    }
}

if (!function_exists('is_livewire_implementation')) {
    /**
     * Check if Livewire implementation is active.
     * 
     * @return bool True if Livewire implementation is active
     */
    function is_livewire_implementation(): bool
    {
        return sudoku_implementation() === 'livewire';
    }
}

if (!function_exists('is_controllers_implementation')) {
    /**
     * Check if MVC + Alpine.js implementation is active.
     * 
     * @return bool True if MVC + Alpine.js implementation is active
     */
    function is_controllers_implementation(): bool
    {
        return sudoku_implementation() === 'controllers';
    }
}
