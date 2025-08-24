<?php

if (!function_exists('flash')) {
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
    function toLetter($xValue) {
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

if (!function_exists('cellRealValue')) {
    function cellRealValue($cell) {
        if (is_array($cell) && key_exists('value', $cell) && key_exists('possibilities', $cell)) {
            return (is_array($cell['possibilities']) && count($cell['possibilities']) > 0) ? $cell['possibilities'] : $cell['value'];
        }
        return null;
    }
}