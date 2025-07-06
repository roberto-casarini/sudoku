<div x-data="singleCell" x-init="xCoord = '{{ $xCoordinate }}', yCoord = '{{ $yCoordinate }}', setBorders()" @cell_selected.window="unselectCell" class="relative size-fit">
    <template x-if="showXLabel">
        <div 
            class="absolute -top-7 w-12 text-center text-xl text-gray-700"
            :style="getXOffset"
            x-text="xCoord"
        >
        </div>
    </template>

    <template x-if="showYLabel">
        <div 
            class="absolute h-12 -left-5 my-3 text-xl text-gray-700"
            :style="getYOffset"
            x-text="yCoord"
        >
        </div>
    </template>

    <div :class="{
        '!border-l-2 !border-l-gray-600': hasBorder('left'),
        '!border-l-1 !border-l-gray-300': !hasBorder('left'),
        '!border-t-2 !border-t-gray-600': hasBorder('top'),
        '!border-t-1 !border-t-gray-300': !hasBorder('top'),
        '!border-r-2 !border-r-gray-600': hasBorder('right'),
        '!border-r-1 !border-r-gray-300': !hasBorder('right'),
        '!border-b-2 !border-b-gray-600': hasBorder('bottom'),
        '!border-b-1 !border-b-gray-300': !hasBorder('bottom'),
        'bg-gray-200 cursor-not-allowed': disabled,
        'cursor-pointer': !disabled,
        'bg-yellow-300': edit
    }"
    class="w-12 h-12 relative"
    @click="selectCell"
    :style="getYOffset() + ' ' + getXOffset();"
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
            <div
                class="text-4xl text-center my-1"
                :class="{
                    'text-red-600': !settingMode
                }">
                {{ $cellValue }}
            </div>
        @endif
    </div>
</div>

@script
<script>
    Alpine.data('singleCell', () => ({
        xCoord: '',
        yCoord: '',
        borders: [],
        edit: false,
        disabled: true,
        settingMode: false,
        setBorders() {
            switch (this.xCoord) {
                case 'A':
                    this.borders.push('left');
                    break;
                case 'C':
                case 'F':
                case 'I':
                    this.borders.push('right');
                    break;
            }

            switch (this.yCoord) {
                case '1':
                    this.borders.push('top');
                    break;
                case '3':
                case '6':
                case '9':
                    this.borders.push('bottom');
                    break;
            }
        },
        hasBorder(value) {
            return this.borders.includes(value);
        },
        selectCell() {
            if (!this.disabled) {
                this.edit = true;
                $dispatch('cell_selected', { xCoord: this.xCoord, yCoord: this.yCoord });
            }
        },
        unselectCell(event) {
            if ((event.detail.xCoord !== this.xCoord) || (event.detail.yCoord !== this.yCoord)) {
                this.edit = false;
            }
        },
        showXLabel() {
            return this.yCoord === '1';
        },
        showYLabel() {
            return this.xCoord === 'A';
        },
        getXOffset() {
            let res = 0;
            switch(this.xCoord) {
                case 'B':
                    res = 1;
                    break;
                case 'C':
                    res = 2;
                    break;
                case 'D': 
                    res = 3;
                    break;
                case 'E': 
                    res = 4;
                    break;
                case 'F': 
                    res = 5;
                    break;
                case 'G': 
                    res = 6;
                    break;
                case 'H': 
                    res = 7;
                    break;
                case 'I': 
                    res = 8;
                    break;
                default: 
                    res = 0;
                    break;
            };
            return "left: -" + res + "px;";
        },
        getYOffset() {
            return "top: -" + this.yCoord - 1 + "px;";
        }, 
        getOffset() {
            return this.getYOffset() + ' ' + this.getXOffset();
        },
        init() {
            Livewire.on('gaming_state', (event) => {
                switch(event.state) {
                    case 'setup':
                        this.disabled = false;
                        this.settingMode = true;
                        break;
                    case 'playing':
                        this.disabled = false;
                        console.log($wire.xCoordinate, $wire.yCoordinate, $wire.cellValue);
                        if (!$wire.isPopulated()) {
                            this.settingMode = false;
                        }
                        break;
                }
            });
        }
    }));
</script>
@endscript