@props(['coord'])

<div x-data="singleCell('{{ $coord }}')" class="relative size-fit">
    <template x-if="showXLabel()">
        <div 
            class="absolute -top-7 w-12 text-center text-xl text-gray-700"
            :style="getXOffset"
            x-text="xCoordinate"
        >
        </div>
    </template>

    <template x-if="showYLabel()">
        <div 
            class="absolute h-12 -left-5 my-3 text-xl text-gray-700"
            :style="getYOffset"
            x-text="yCoordinate"
        >
        </div>
    </template>

    <div
        class="w-12 h-12 relative" 
        :class="{
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
        :style="getOffset"
    >
        <template x-if="showPossibilities">
            <div class="h-full w-full text-xs text-center grid grid-cols-3">
                <template x-for="col in Array.from({length: 9}, (_, i) => i + 1)">
                    <div :class="{
                        'invisible': !hasPossibility(i),
                    }"
                    style="position: relative; top: -2px; left: -2px;"
                    x-text="i"
                    ></div>
                </template>
            </div>
        </template>
        <template x-if="!showPossibilities">
            <div
                class="text-4xl text-center my-1"
                x-text="value"
            >
            </div>
        </template>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('singleCell', (coord) => ({
            coord: coord,
            edit: false,
            borders: [],
            get cell() {
                return Alpine.raw(Alpine.store('game').getCell(this.coord));
            },
            get value() {
                return (this.cell) ? this.cell.value : '';
            },
            get xCoordinate() {
                return (this.cell) ? this.cell.xCoordinate : '';
            },
            get yCoordinate() {
                return (this.cell) ? this.cell.yCoordinate : '';
            },
            get disabled() {
                return true;
            },
            get possibilities() {
                return (this.cell) ? this.cell.possibilities : [];
            },
            showPossibilities() {
                return this.possibilities.length >  0;
            },
            hasPossibility(value) {
                return (this.possibilities.length > 0) ? this.possibilities.includes(value) : false;
            },
            hasBorder(value) {
                return this.borders.includes(value);
            },
            setBorders() { 
                switch (this.xCoordinate) {
                    case 'A':
                        this.borders.push('left');
                        break;
                    case 'C':
                    case 'F':
                    case 'I':
                        this.borders.push('right');
                        break;
                }

                switch (this.yCoordinate) {
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
            showXLabel() {
                return this.yCoordinate === '1';
            },
            showYLabel() {
                return this.xCoordinate === 'A';
            },
            getXOffset() {
                let res = 0;
                switch(this.xCoordinate) {
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
                }
                return res;
            },
            getYOffset() {
                return "top: -" + this.yCoordinate - 1 + "px;";
            }, 
            getOffset() {
                return this.getYOffset() + ' ' + this.getXOffset();
            },
            init() {
                const obj = this;
                this.$watch('cell', function () {
                    obj.setBorders();
                });
            }
        }));
    });
</script>