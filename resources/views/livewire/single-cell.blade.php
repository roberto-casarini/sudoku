<div class="relative size-fit" x-on:value_selected="handleValueSelected" x-on:possibilities_selected="handlePossibilitiesSelected">
    @if($this->showXLabel)
        <div class="w-14 text-center text-xl text-gray-700">{{ $cell['xCoordinate'] }}</div>
    @endif

    @if($this->showYLabel)
        <div class="absolute h-14 -left-4 my-4 text-xl text-gray-700">{{ $cell['yCoordinate'] }}</div>
    @endif

    <div @class([
        'w-14 h-14 border-r-1 border-b-1 border-gray-300',
        '!border-l-2 !border-l-gray-600' => $this->hasBorder('left'),
        '!border-t-2 !border-t-gray-600' => $this->hasBorder('top'),
        '!border-r-2 !border-r-gray-600' => $this->hasBorder('right'),
        '!border-b-2 !border-b-gray-600' => $this->hasBorder('bottom'),
    ]) wire:click="setEdit" >
        @if($showPossibilities)
            <div class="h-full w-full text-xs text-center grid grid-cols-3">
                @foreach (range(1, 9) as $i)
                    <div @class([
                        'invisible' => !$this->hasPossibility($i),
                    ])>{{ $i }}</div>
                @endforeach
            </div>
        @else
            <div @class([
                'text-5xl align-middle text-center',
                'text-red-600' => !$preSetting
            ])>
                {{ $cellValue }}
            </div>
        @endif
    </div>

    @if($edit)
    <?php
        $cell = $this->cellToText;
    ?>
    <div x-cloak class="absolute -top-5 -left-5 z-10" x-transition.opacity.duration.500ms>
        <livewire:select-number :multiple=$showPossibilities :cell=$cell />
    </div>
    @endif
</div>
