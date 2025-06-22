<div x-data="selectNumberValues" class="border-1 border-gray-300 rounded-md w-max">
    <div class="p-3 bg-white">
        <div class="grid grid-cols-3 w-max">
            @foreach (range(1, 9) as $i)
            <div
                @mouseover="hovering = '{{ $i }}'"
                @mouseout="hovering = ''"
                @click="selectValue({{ $i }})"
                :class="{ 
                    'bg-yellow-300 text-black': isHovering({{ $i }}),
                    'bg-white text-black': !isHovering({{ $i }}) && !isSelected({{ $i }}),
                    'bg-green-700 text-white': isSelected({{ $i }})
                }"
                class="text-center align-middle h-8 w-8 cursor-pointer text-2xl border-1 border-blue-300"
                >
                {{ $i }}
            </div>
            @endforeach
        </div>
        <div class="mt-2 flex flex-col">
            <label for="showProps" class="text-xs flex items-center">
                Possibilities:
                <input id="showProps" type="checkbox" class="ml-2" @change="setMultiple" />
            </label>
            <button @click.prevent="sendValues" class="rounded-full bg-sky-500 text-white text-sm font-bold mt-1 border-1 border-sky-500 hover:bg-sky-700 hover:border-sky-700">Confirm</button>
            <button wire:click="closeEdit" class="rounded-full text-sm font-bold mt-1 border-1 border-gray-400 hover:bg-gray-300">Cancel</button>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('selectNumberValues', () => ({
        multiple: false,
        hovering: '',
        selectedValues: [],
        isHovering(value) {
            return parseInt(this.hovering) === parseInt(value);
        },
        isSelected(value) 
        {
            return this.selectedValues.includes(value);
        },
        selectValue(value) {
            if (!this.isSelected(value)) {
                if (!this.multiple) {
                    this.selectedValues = [];
                }
                this.selectedValues.push(value);
            } else if (this.multiple) { // Toggle functionality only for multiple values selection
                this.selectedValues = this.selectedValues.filter((itemValue) => {
                    return itemValue !== value;
                });
            }
        },
        setMultiple(event) {
            this.multiple = event.target.checked;
            this.selectedValues = [];
        },
        sendValues() {
            $wire.sendValues(this.selectedValues, this.multiple);
        }
    }));
</script>
@endscript