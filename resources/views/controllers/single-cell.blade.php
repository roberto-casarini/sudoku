@props(['coord'])

<div x-data="singleCell('{{ $coord }}')" class="relative size-fit">
    <template x-if="showXLabel()">
        <div 
            class="absolute -top-7 w-12 text-center text-xl text-gray-700"
            :style="xOffset"
            x-text="xCoordinate"
        >
        </div>
    </template>

    <template x-if="showYLabel()">
        <div 
            class="absolute h-12 -left-5 my-3 text-xl text-gray-700"
            :style="yOffset"
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
        :style="offset"
        @click="selectCell"
    >
        <template x-if="showPossibilities()">
            <div 
                class="h-full w-full text-xs text-center grid grid-cols-3"
            >
                <template x-for="i in 9">
                    <div 
                        :class="{
                            'invisible': !hasPossibility(i),
                        }"
                        style="position: relative; top: -2px; left: -2px;"
                        x-text="i"
                    >
                    </div>
                </template>
            </div>
        </template>
        <template x-if="!showPossibilities()">
            <div
                class="text-4xl text-center my-1"
                :class="{
                    'text-red-600': !setup
                }"
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
            borders: [],
            disabled: true,
            settingMode: true,
            get cell() {
                return Alpine.store('game').getCell(this.coord);
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
            get possibilities() {
                return (this.cell) ? this.cell.possibilities : [];
            },
            get setup() {
                return (this.cell) ? this.cell.setup : false;
            },
            get edit() {
                const store = Alpine.store('game');
                if (['setup', 'playing'].includes(store.game_status)) {
                    return store.cell_selected === this.coord;
                }
                return false;
            },
            get xOffset() {
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
                return 'left: -' + res + 'px;';
            },
            get yOffset() {
                return 'top: -' + (parseInt(this.yCoordinate) - 1) + 'px;';
            }, 
            get offset() {
                return this.yOffset + ' ' + this.xOffset;
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
                // Reset borders array first
                this.borders = [];
                
                // Only set borders if we have valid coordinates
                if (!this.xCoordinate || !this.yCoordinate) {
                    return;
                }
                
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
            selectCell() {
                if (!this.disabled) {
                    let value = this.value;
                    let possibilities = Alpine.raw(this.possibilities);
                    if (Array.isArray(possibilities) && (possibilities.length > 0)) {
                        value = possibilities;
                    }
                    Alpine.store('game').selectCell(this.coord, value);
                }
            },  
            init() {
                const obj = this;
                
                // Set borders immediately if cell exists
                if (obj.cell) {
                    obj.setBorders();
                }
                
                // Watch for cell changes (when cells are loaded)
                this.$watch('cell', function () {
                    if (obj.cell) {
                        obj.setBorders();
                    }
                });
                
                // Also watch for cells array changes (when startGame loads cells)
                this.$watch('$store.game.cells', function () {
                    if (obj.cell) {
                        obj.setBorders();
                    }
                });
                
                this.$watch('$store.game.game_status', function (value) {
                    switch(value) {
                        case 'beginning':
                            obj.edit = false;
                            obj.disabled = true;
                            obj.settingMode = false;
                            break;
                        case 'setup':
                            obj.disabled = false;
                            obj.settingMode = true;
                            break;
                        case 'playing':
                            obj.disabled = false;
                            if (obj.value == '') {
                                obj.settingMode = false;
                            }
                            obj.edit = false;
                            break;
                        case 'end':
                            obj.edit = false;
                            obj.disabled = true;
                            break;
                    }
                });
            }
        }));
    });
</script>