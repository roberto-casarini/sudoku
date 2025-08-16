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
                :disabled="disabled"
                x-text="possibilityButtonText"
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
            disabled_possibilities: true,
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
                this.selectedValues = [];
            }
        }));
    });
</script>