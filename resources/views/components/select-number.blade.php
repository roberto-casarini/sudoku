<div 
    x-data="selectNumber" 
    class="grid grid-cols-3 w-max"             
    @click.outside="sendValues"
>
    @foreach (range(1, 9) as $i)
        <div 
            x-data="{ hovering: false }"
            :class="{
                'bg-yellow-300 text-black': hovering,
                'bg-white text-black': !hovering && !isSelected({{ $i }}),
                'bg-green-700 text-white': isSelected({{ $i }})    
            }"
            class="text-center align-middle h-8 w-8 cursor-pointer text-2xl border-1"
            @mouseover="hovering = true"
            @mouseout="hovering = false"
            @click="selectValue({{ $i }})"
            @dblclick="sendValues"
     >{{ $i }}</div>
    @endforeach
</div>

@script
<script>
    Alpine.data('selectNumber', () => ({
        isMultiple: @bool($multiple),
        cell: @json($cell),
        selectedValues: [],
        isSelected(value) {
            return this.selectedValues.includes(value);
        },
        selectValue(value) {
            if (!this.isSelected(value)) {
                if (!this.isMultiple) {
                    this.selectedValues = [];
                }
                this.selectedValues.push(value);
            } else if (this.isMultiple) { // Toggle functionality only for multiple values selection
                this.selectedValues = this.selectedValues.filter((itemValue) => {
                    return itemValue !== value;
                });
            }
        },
        sendValues() {
            if (this.isMultiple) {
                $dispatch('possibilities_selected', { cell: this.cell, values: this.selectedValues.join() })
            } else {
                let value = this.selectedValues[0];
                $dispatch('value_selected', { cell: this.cell, value: value })
            }
        }
    }));
</script>
@endscript
