<div class="relative size-fit" x-on:value_selected="handleValueSelected" x-on:possibilities_selected="handlePossibilitiesSelected">
    @if($this->showXLabel)
        <div 
            class="absolute -top-7 w-12 text-center text-xl text-gray-700"
            style="left: -{{ $this->getXOffset() }}px;"
        >
            {{ $cell['xCoordinate'] }}
        </div>
    @endif

    @if($this->showYLabel)
        <div 
            class="absolute h-12 -left-5 my-3 text-xl text-gray-700"
            style="top: -{{ $this->getYOffset() }}px;"
        >
            {{ $cell['yCoordinate'] }}
        </div>
    @endif

    <div @class([
        'w-12 h-12 relative',
        '!border-l-2 !border-l-gray-600' => $this->hasBorder('left'),
        '!border-l-1 !border-l-gray-300' => !$this->hasBorder('left'),
        '!border-t-2 !border-t-gray-600' => $this->hasBorder('top'),
        '!border-t-1 !border-t-gray-300' => !$this->hasBorder('top'),
        '!border-r-2 !border-r-gray-600' => $this->hasBorder('right'),
        '!border-r-1 !border-r-gray-300' => !$this->hasBorder('right'),
        '!border-b-2 !border-b-gray-600' => $this->hasBorder('bottom'),
        '!border-b-1 !border-b-gray-300' => !$this->hasBorder('bottom'),
        'bg-yellow-300' => $this->edit,
    ]) wire:click="setEdit"
    style="top: -{{ $this->getYOffset() }}px; left: -{{ $this->getXOffset() }}px;"
    >
        @if($showPossibilities)
            <div class="h-full w-full text-xs text-center grid grid-cols-3">
                @foreach (range(1, 9) as $i)
                    <div @class([
                        'invisible' => !$this->hasPossibility($i),
                    ])
                    style="position: relative; top: -2px; left: -2px;"
                    >{{ $i }}</div>
                @endforeach
            </div>
        @else
            <div @class([
                'text-3xl text-center -my-1',
                'text-red-600' => !$preSetting
            ])>
                {{ $cellValue }}
            </div>
        @endif
    </div>
</div>
