<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class FlashMessage extends Component
{
    public ?string $type = null;
    public ?string $title = null;
    public ?string $message = null;
    public int $timeout = 3000;
    public bool $show = false;

    /**
     * Listen for flash message events from other components.
     */
    #[On('flash-message')]
    public function handleFlashMessage(string $type, string $title, string $message, int $timeout = 3000): void
    {
        $this->type = $type;
        $this->title = $title;
        $this->message = $message;
        $this->timeout = $timeout;
        $this->show = true;
    }

    /**
     * Close the flash message.
     */
    public function close(): void
    {
        $this->show = false;
    }

    public function render()
    {
        return view('components.flash-message');
    }
}

