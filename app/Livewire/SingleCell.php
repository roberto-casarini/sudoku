<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class SingleCell extends Component
{
    public $showPossibilities = false;

    public array $possibilities = [];

    public $cell = [
        'xCoordinate' => '',
        'yCoordinate' => '',
    ];

    public $cellValue = '';

    public $preSetting = false;

    public array $borders = [];

    public $edit = false;

    public function mount($cell)
    {
        $this->cell = $cell;
        if (!key_exists('xCoordinate', $cell) || !key_exists('yCoordinate', $cell)) {
            throw new Exception('Invalid Cell');
        }
        $this->setBorders();
    }

    public function hasPossibility($value): bool
    {
        return in_array((int) $value, $this->possibilities);
    }

    public function hasBorder($value): bool
    {
        return in_array($value, $this->borders);
    }

    public function hasNoBorder(): bool
    {
        return count($this->borders) == 0;
    }

    public function setEdit()
    {
        $this->edit = true;
        $this->dispatch('setting-edit', 
            cell: $this->cell
        );
    }

    #[On('setting-edit')]
    public function unsetEdit($cell)
    {
        if (($cell['xCoordinate'] != $this->cell['xCoordinate']) || ($cell['yCoordinate'] != $this->cell['yCoordinate'])) {
            $this->edit = false;
        }
    }

    #[Computed]
    public function getXOffset()
    {
        return match($this->cell['xCoordinate']) {
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
    }

    #[Computed]
    public function getYOffset()
    {
        return (int) $this->cell['yCoordinate'] - 1;
    }

    #[Computed]
    public function cellToText()
    {
        return $this->cell['xCoordinate'] . $this->cell['yCoordinate'];
    }

    #[On('cell.setvalues')]
    public function setCellValues($cell, $values, $multiple)
    {
        if ($cell == $this->cellToText()) {
            //if (count($values) > 0) {
                if (!$multiple) {
                    $this->showPossibilities = false;
                    $this->cellValue = (count($values) > 0) ? $values[0] : '';
                } else {
                    $this->showPossibilities = true;
                    $this->possibilities = $values;
                }
            //}
            $this->edit = false;
        }
    }

    #[On('cells.setup')]
    public function setSettingCell($value)
    {
        if ($this->cellValue == '') {
            $this->preSetting = $value;
        }
    }

    private function setBorders(): void
    {
        switch ($this->cell['xCoordinate']) {
            case 'A':
                $this->borders[] = 'left';
                break;
            case 'C':
            case 'F':
            case 'I':
                $this->borders[] = 'right';
                break;
        }

        switch ($this->cell['yCoordinate']) {
            case 1:
                $this->borders[] = 'top';
                break;
            case 3:
            case 6:
            case 9:
                $this->borders[] = 'bottom';
                break;
        }
    }

    public function render()
    {
        return view('livewire.single-cell');
    }

    #[Computed]
    public function showXLabel(): bool
    {
        return $this->cell['yCoordinate'] == 1;
    }

    #[Computed]
    public function showYLabel(): bool
    {
        return $this->cell['xCoordinate'] == 'A';
    }
}
