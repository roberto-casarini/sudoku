<div x-data="selectNumberValues" class="w-max mt-6">
    <div class="p-3 bg-white">
        <div class="mb-4 flex flex-col">
            <button
                type="button"
                @click="setPossibility"
                :class="{
                    'bg-red-600': possibility,
                    'bg-green-600': !possibility
                }"
                class="w-full font-semibold text-white px-2 rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
                x-text="possibilityButtonText()"
                :disabled='disabled'
            >
            </button>
        </div>
        <div class="grid grid-cols-3 gap-2 w-max">
            @foreach (range(1, 9) as $i)
            <div
                @mouseover="hovering = '{{ $i }}'"
                @mouseout="hovering = ''"
                @click="selectValue({{ $i }})"
                :class="{ 
                    'bg-yellow-300 text-black cursor-pointer border-blue-300': isHovering({{ $i }}) && !disabled,
                    'bg-white text-black cursor-pointer border-blue-300': !isHovering({{ $i }}) && !isSelected({{ $i }}) && !disabled,
                    'bg-green-700 text-white cursor-pointer border-blue-300': isSelected({{ $i }}) && !disabled,      
                    'cursor-not-allowed text-gray-500 border-gray-500': disabled,       
                }"
                class="text-center h-12 w-12 text-3xl rounded-md border-1 transition duration-500 ease-in-out"
            >
                <div
                    class="mt-1"
                >
                    {{ $i }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('selectNumberValues', () => ({
        disabled: true,
        possibility: false,
        hovering: '',
        selectedValues: [],
        isHovering(value) {
            return parseInt(this.hovering) === parseInt(value);
        },
        possibilityButtonText() {
            return (this.possibility) ? 'Set Possibilities' : 'Set Value';
        },
        isSelected(value) 
        {
            return this.selectedValues.includes(value);
        },
        selectValue(value) {
            if (!this.isSelected(value)) {
                if (!this.possibility) {
                    this.selectedValues = [];
                }
                this.selectedValues.push(value);
            } else if (this.possibility) { // Toggle functionality only for multiple values selection
                this.selectedValues = this.selectedValues.filter((itemValue) => {
                    return itemValue !== value;
                });
            }
        },
        setPossibility() {
            this.possibility = !this.possibility;
            this.selectedValues = [];
        },
        sendValue() {
            //$wire.sendValues(this.selectedValues, this.multiple);
        }
    }));
</script>
@endscript