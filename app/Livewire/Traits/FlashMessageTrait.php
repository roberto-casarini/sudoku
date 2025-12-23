<?php

namespace App\Livewire\Traits;

trait FlashMessageTrait
{
    /**
     * Send a flash message to the session.
     * 
     * @param string $type The message type (success, error, warning, info)
     * @param string $title The message title
     * @param string $message The message content
     * @return void
     */
    protected function sendMessage(string $type, string $title, string $message): void
    {
        session()->flash('flash_notifications', [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'timeout' => 3000
        ]);
    }
}

