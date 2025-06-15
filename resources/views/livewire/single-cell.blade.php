<div x-data="single_cell" class="relative size-fit" x-on:value_selected="handleValueSelected" x-on:possibilities_selected="handlePossibilitiesSelected">
    @if($this->showXLabel)
        <div class="w-14 text-center text-xl text-gray-700">{{ $props->xCoordinate }}</div>
    @endif

    @if($this->showYLabel)
        <div class="absolute h-14 -left-4 my-4 text-xl text-gray-700">{{ $props->yCoordinate }}</div>
    @endif

    <div @class([
        'w-14 h-14 border-1',
        'border-l-3 border-l-gray-400' => $this->hasBorder('left'),
        'border-t-3 border-t-gray-400' => $this->hasBorder('top'),
        'border-r-3 border-r-gray-400' => $this->hasBorder('right'),
        'border-b-3 border-b-gray-400' => $this->hasBorder('bottom'),
    ]) @click="edit = true" >
        @if($props->showPossibilities)
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
                'text-red-600' => !$presetting
            ])>
                {{ $props->cellValue }}
            </div>
        @endif
    </div>
    <?php
        $multiple = $props->showPossibilities;
        $cell = $props->xCoordinate . $props->yCoordinate;
    ?>

    <div x-show="edit" x-cloak class="absolute -top-5 -left-5 z-10" x-transition.opacity.duration.500ms>
        <x-select-number :cell=$cell :multiple=$multiple />
    </div>
</div>

@script
<script>
    Alpine.data('single_cell', () => ({
        @props([
            'multiple'
        ]) 
        edit: false,
        handleValueSelected(event) {
            $wire.setCellValue(event.detail.cell, event.detail.value);
            this.edit = false;
        },
        handlePossibilitiesSelected(event) {
            $wire.setPossibilityValues(event.detail.cell, event.detail.values);
            this.edit = false;
        }
    }));
</script>
@endscript