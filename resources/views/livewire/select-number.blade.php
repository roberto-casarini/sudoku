<div x-data="selectNumberValues" class="w-max">
    <div class="p-3 bg-white">
        <div class="grid grid-cols-3 gap-2 w-max">
            @foreach (range(1, 9) as $i)
            <div
                @mouseover="hovering = '{{ $i }}'"
                @mouseout="hovering = ''"
                @click="selectValue({{ $i }})"
                :class="{ 
                    'bg-yellow-300 text-black': isHovering({{ $i }}),
                    'bg-white text-black': !isHovering({{ $i }}) && !isSelected({{ $i }}),
                    'bg-green-700 text-white': isSelected({{ $i }}),             
                }"
                class="text-center h-12 w-12 cursor-pointer text-3xl rounded-md border-1 border-blue-300 transition duration-500 ease-in-out">
                <div class="mt-1">
                    {{ $i }}
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-2 flex flex-col">
            <button
                type="button"
                @click="setPossibility"
                :class="{
                    'bg-red-300': possibility,
                    'bg-green-300': !possibility
                }"
                class="w-full text-sm border border-gray-200 px-2 py-1 rounded-lg cursor-pointer transition duration-500 ease-in-out"
                x-text="possibilityButtonText()"
            >
            </button>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('selectNumberValues', () => ({
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