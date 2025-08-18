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
            
            async init() {
                const game = Alpine.store('game');
                await game.startGame();

                //console.log(Alpine.raw(game.getCell('A-5')));
                //console.log(this.processedCells());
                //this.$watch('$store.game.cells', () => {});     
            }
        }));
    });
</script>

