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