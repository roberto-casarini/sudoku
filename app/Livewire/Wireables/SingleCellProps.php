<?php

namespace App\Livewire\Wireables;

use Livewire\Wireable;

class SingleCellProps implements Wireable
{
    public $showPossibilities = false;

    public array $possibilities = [];

    public $xCoordinate = '';

    public $yCoordinate = '';

    public $cellValue = '';

    public bool $preSetted = true;

    public array $borders = [];


    public function toLivewire(): array
    {
        return [
            'showPossibilities' => $this->showPossibilities,
            'possibilities' => $this->possibilities,
            'cellValue' => $this->cellValue,
            'preSetted' => $this->preSetted,
            'xCoordinate' => $this->xCoordinate,
            'yCoordinate' => $this->yCoordinate,
            'borders' => $this->borders,
        ];
    }

    public static function fromLivewire($value): static
    {
        $showPossibilities = $value['showPossibilities'];
        $possibilities = $value['possibilities'];
        $cellValue = $value['cellValue'];
        $preSetted = $value['preSetted'];
        $xCoordinate = $value['xCoordinate'];
        $yCoordinate = $value['yCoordinate'];
        $borders = $value['borders'];
        return new static($showPossibilities, $possibilities, $cellValue, $preSetted, $xCoordinate, $yCoordinate, $borders);
    }

    /*public function getCoordinate()
    {
        return $this->xCoordinate . $this->yCoordinate;
    }*/
}