<?php

namespace App\Livewire;

use Livewire\Component;

class Setup extends Component
{
    public bool $settingUp = false;
    public string $title = 'Setup Board';

    public function render()
    {
        return view('livewire.setup');
    }

    public function toggleBtn()
    {
        $this->settingUp = !$this->settingUp;
        $this->title = ($this->settingUp) ? 'Setting up Board' : 'Setup Board';
        $this->dispatch('cells.setup', value: $this->settingUp);
    }
}
