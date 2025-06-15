<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Wireables\SingleCellProps;
use Livewire\Attributes\Computed;

class SingleCell extends Component
{
    public SingleCellProps $props;  

    public array $borders;

    public $presetting = true;

    public $numberSelectorVisible = false;

    public function mount(SingleCellProps $props, array $borders = [])
    {   
        $this->props = $props;
        $this->borders = $borders;
    }

    public function hasPossibility($value): bool
    {
        return in_array((int) $value, $this->props->possibilities);
    }

    public function hasBorder($value): bool
    {
        return in_array($value, $this->borders);
    }

    public function setCellValue($cell, $value)
    {
        dd($this->props->getCoordinate());
        if ($cell == $this->props->getCoordinate()) {
            $this->props->showPossibilities = false;
            $this->props->cellValue = $value;
            $this->showSelectNumber = false;
        }
    }

    public function setPossibilityValues($cell, $values)
    {
        if ($cell == $this->props->getCoordinate()) {
            $this->props->showPossibilities = true;
            $this->props->possibilities = array_map('intval', explode(",", $values));
            $this->showSelectNumber = false;
        }
    }

    public function render()
    {
        return view('livewire.single-cell');
    }

    #[Computed]
    public function showXLabel(): bool
    {
        return $this->props->yCoordinate == 1;
    }

    #[Computed]
    public function showYLabel(): bool
    {
        return $this->props->xCoordinate == 'A';
    }

    public function showNumberSelector()
    {
        $this->numberSelectorVisible = true;
    }
}
