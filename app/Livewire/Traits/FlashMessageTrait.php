<?php

namespace App\Livewire\Traits;

trait FlashMessageTrait 
{
    public function sendMessage($type, $title, $message)
    {
        $this->dispatch('flash_message', type: $type, title: $title, message: $message);
    }
}