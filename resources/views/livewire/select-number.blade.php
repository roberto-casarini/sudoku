<div x-data="selectNumberValues" class="w-max mt-6" @cell_selected.window="cellSelected">
    <div class="p-3 bg-white">
        <div class="mb-4 flex flex-col">
            <button
                type="button"
                @click="setPossibilities"
                :class="{
                    'bg-red-600': possibilities,
                    'bg-green-600': !possibilities
                }"
                class="w-full font-semibold text-white px-2 rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
                x-text="possibilityButtonText()"
                :disabled='disabled_possibilities'>
            </button>
        </div>
        <div class="grid grid-cols-3 gap-2 w-max">
            @foreach (range(1, 9) as $i)
            <div
                @mouseover="hovering = '{{ $i }}'"
                @mouseout="hovering = ''"
                @click="setCellValue({{ $i }})"
                :class="{ 
                    'bg-yellow-300 text-black cursor-pointer border-blue-300': isHovering({{ $i }}) && !disabled,
                    'bg-white text-black cursor-pointer border-blue-300': !isHovering({{ $i }}) && !isSelected({{ $i }}) && !disabled,
                    'bg-green-700 text-white cursor-pointer border-blue-300': isSelected({{ $i }}) && !disabled,      
                    'cursor-not-allowed text-gray-500 border-gray-500 bg-gray-200': disabled,       
                }"
                class="text-center h-12 w-12 text-3xl rounded-md border-1 transition duration-500 ease-in-out">
                <div
                    class="mt-1">
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
        cell: '',
        disabled: true,
        disabled_possibilities: true,
        possibilities: false,
        hovering: '',
        selectedValues: [],
        isHovering(value) {
            return parseInt(this.hovering) === parseInt(value);
        },
        possibilityButtonText() {
            return (this.possibilities) ? 'Set Value' : 'Set Possibilities';
        },
        isSelected(value) {
            return this.selectedValues.includes(value);
        },
        setCellValue(value) {
            if (this.cell === '') {
                $wire.sendMessage('warning', 'Attenzione!', 'Devi selezionare una cella per inserire un numero!');
            } else {
                if (!this.isSelected(value)) {
                    if (!this.possibilities) {
                        this.selectedValues = [];
                    }
                    this.selectedValues.push(value);
                } else if (this.possibilities) { // Toggle functionality only for multiple values selection
                    this.selectedValues = this.selectedValues.filter((itemValue) => {
                        return itemValue !== value;
                    });
                }
                $wire.setCellValues(this.cell, this.selectedValues, this.possibilities);
            }
        },
        setPossibilities() {
            this.possibilities = !this.possibilities;
            this.selectedValues = [];
        },
        cellSelected(event) {
            this.cell = event.detail.xCoord + event.detail.yCoord;
            this.possibilities = false;
            this.selectedValues = [];
            this.hovering = '';
        },
        init() {
            Livewire.on('gaming_state', (event) => {
                switch (event.state) {
                    case 'setup':
                        this.disabled = false;
                        this.disabled_possibilities = true;
                        break;
                    case 'playing':
                        this.disabled = false;
                        this.disabled_possibilities = false;
                        break;
                }
            });
        }
    }));
</script>
@endscript