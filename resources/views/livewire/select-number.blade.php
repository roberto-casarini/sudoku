<div class="w-max mt-6">
    <div class="p-3 bg-white">
        <div class="mb-4 flex flex-col">
            <button
                type="button"
                wire:click="setPossibilities"
                @class([
                    'w-full font-semibold text-white px-2 rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed',
                    'bg-red-600' => $this->possibilities,
                    'bg-green-600' => !$this->possibilities
                ])
                @if ($this->disabled_possibilities) disabled="disabled" @endif>
                {{ $this->possibilityButtonText() }}
            </button>
        </div>
        <div class="grid grid-cols-3 gap-2 w-max">
            @foreach (range(1, 9) as $i)
            <div
                wire:mouseover="setHovering({{$i}})"
                wire:mouseout="setHovering()"
                wire:click="setCellValue({{$i}})"
                @class([ 
                    'text-center h-12 w-12 text-3xl rounded-md border-1 transition duration-500 ease-in-out',
                    'bg-yellow-300 text-black cursor-pointer border-blue-300' => $this->isHovering($i) && !$this->disabled,
                    'bg-white text-black cursor-pointer border-blue-300' => !$this->isHovering($i) && !$this->isSelected($i) && !$this->disabled,
                    'bg-green-700 text-white cursor-pointer border-blue-300' => $this->isSelected($i) && !$this->disabled,      
                    'cursor-not-allowed text-gray-500 border-gray-500 bg-gray-200' => $this->disabled,       
                ])
                >
                <div
                    class="mt-1">
                    {{ $i }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
