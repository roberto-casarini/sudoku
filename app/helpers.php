<?php

/**
 * Helper functions for the Sudoku application.
 * 
 * This file contains utility functions used throughout the application
 * for flash notifications, coordinate conversions, and cell data extraction.
 */

if (!function_exists('flash')) {
    /**
     * Flash a notification message to the session.
     * 
     * Stores a flash notification in the session that will be displayed
     * on the next page load. The notification will automatically disappear
     * after the specified timeout.
     * 
     * @param string $message The notification message to display
     * @param string $type The notification type (e.g., 'success', 'error', 'warning', 'info')
     * @param string|null $title Optional title for the notification
     * @return void
     */
    function flash(string $message, string $type = 'success', ?string $title = null): void
    {
        $notification = session('flash_notifications', []);
        
        $notification = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'timeout' => 3000
        ];

        session()->flash('flash_notifications', $notification);
    }
}

if (!function_exists('toLetter')) {
    /**
     * Convert a numeric coordinate (1-9) to its corresponding letter (A-I).
     * 
     * Used to convert X coordinates from numeric format to letter format
     * for Sudoku cell identification.
     * 
     * @param int $xValue The numeric coordinate (1-9)
     * @return string The corresponding letter (A-I) or empty string if invalid
     */
    function toLetter(int $xValue): string
    {
        return match($xValue) {
            1 => "A",
            2 => "B",
            3 => "C",
            4 => "D",
            5 => "E", 
            6 => "F",
            7 => "G",
            8 => "H",
            9 => "I",
            default => "",
        };
    }
}

if (!function_exists('getCellValue')) {
    /**
     * Extract the value or possibilities from a cell data array.
     * 
     * Returns the possibilities array if it exists and has values,
     * otherwise returns the cell value. Used for displaying cell data
     * in responses.
     * 
     * @param array<string, mixed>|null $cell Cell data array containing 'value' and 'possibilities' keys
     * @return array<int>|int|null The cell possibilities array if available, otherwise the cell value, or null if invalid
     */
    function getCellValue($cell): array|int|null
    {
        if (is_array($cell) && key_exists('value', $cell) && key_exists('possibilities', $cell)) {
            return (is_array($cell['possibilities']) && count($cell['possibilities']) > 0) ? $cell['possibilities'] : $cell['value'];
        }
        return null;
    }
}

if (!function_exists('getCellCoords')) {
    /**
     * Extract and format cell coordinates from a cell data array.
     * 
     * Combines the X and Y coordinates into a formatted string
     * in the format "X-Y" (e.g., "A-1", "B-5").
     * 
     * @param array<string, mixed>|null $cell Cell data array containing 'xCoordinate' and 'yCoordinate' keys
     * @return string Formatted coordinates string (e.g., "A-1") or empty string if invalid
     */
    function getCellCoords($cell): string
    {
        if (is_array($cell) && isset($cell['xCoordinate']) && isset($cell['yCoordinate'])) {
            return $cell['xCoordinate'] . '-' . $cell['yCoordinate']; 
        }
        return '';
    }
}