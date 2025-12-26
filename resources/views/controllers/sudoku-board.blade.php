<div x-data="sudokuBoard" class="container grid grid-cols-9 size-fit gap-0 relative top-10">
    @foreach($coords as $index => $coord)
        <x-single-cell :coord="$coord" :key="$index" />
    @endforeach
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sudokuBoard', () => ({
            disabled: true,
        
            /*processedCells() {
                return this.cells.map(cell => Alpine.raw(cell));
            },*/

            get cells() {
                return Alpine.store('game').cells;
            },
            
            init() {
                // Data is already loaded from server in app.js
                // No need to call startGame() on init anymore
                // startGame() can still be called manually if needed for refresh
            }
        }));
    });
</script>

