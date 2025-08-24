<div x-data="selectNumber" class="w-max mt-6">
    <div class="p-3 bg-white">
        <div class="mb-4 flex flex-col">
            <button
                type="button"
                class="w-full font-semibold text-white px-2 rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
                :class="{
                    'bg-red-600': showPossibilities,
                    'bg-green-600': !showPossibilities
                }"
                :disabled="disabledPossibilities"
                x-text="possibilityButtonText"
                @click="setPossibilitiesBtn"
            >
            </button>
        </div>
        <div class="grid grid-cols-3 gap-2 w-max">
            <template x-for="i in 9">
            <div
                class="text-center h-12 w-12 text-3xl rounded-md border-1 transition duration-500 ease-in-out"
                :class="{ 
                    'bg-white text-black cursor-pointer border-blue-300': !isSelected(i) && !disabled,
                    'bg-green-700 text-white cursor-pointer border-blue-300': isSelected(i) && !disabled,      
                    'cursor-not-allowed text-gray-500 border-gray-500 bg-gray-200': disabled,       
                }"
                >
                <div
                    class="mt-1"
                    x-text="i"
                    @click="setCellValue(i)"    
                >
                </div>
            </div>
            </template>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('selectNumber', () => ({
            cell: '',
            disabled: true,
            disabledPossibilities: true,
            showPossibilities: false,
            selectedValues: [],
            isSelected(value) {
                return this.selectedValues.includes(value);
            },
            possibilityButtonText() {
                return this.showPossibilities ? 'Set Value' : 'Set Possibilities';
            },
            resetSelect() {
                this.showPossibilities = false;
                this.setSelectedValues([]);
            },
            setCellValue(value) {
                const store = Alpine.store('game');
                if (store.game_status === 'setup') {
                    store.setCellValueSetup(this.cell, value);
                } else if (store.game_status === 'playing')  {
                    console.log(value);
                    store.setCellValue(this.cell, value, this.showPossibilities);
                }
            },
            setSelectedValues(value) {
                this.selectedValues = value;
            },
            setPossibilitiesBtn() {
                this.showPossibilities = !this.showPossibilities;
            },
            init() {
                const obj = this;
                this.$watch('$store.game.game_status', function (value) {
                    switch(value) {
                        case 'beginning':
                            obj.disabled = true;
                            obj.disabledPossibilities = true;
                            obj.showPossibilities = false;
                            obj.selectedValues = [];
                            obj.cell = '';
                            break;
                        case 'setup':
                            obj.disabled = false;
                            obj.disabledPossibilities = true;
                            break;
                        case 'playing':
                            obj.disabled = false;
                            obj.disabledPossibilities = false;
                            obj.cell = '';
                            obj.resetSelect();
                            break;
                        case 'end':
                            obj.disabled = true;
                            obj.disabledPossibilities = true;
                            break;    
                    }
                });

                this.$watch('$store.game.cell_selected', function (value) {
                    obj.cell = value;
                });
                this.$watch('$store.game.cell_selected_values', function (value) {
                    if (Array.isArray(value)) {
                        obj.setSelectedValues(value);
                        obj.showPossibilities = true;
                    } else {
                        obj.setSelectedValues([value]);
                        obj.showPossibilities = false;
                    }
                });
            }
        }));
    });
</script>