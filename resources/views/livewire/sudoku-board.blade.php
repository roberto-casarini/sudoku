<div class="container grid grid-cols-9 size-fit gap-0 relative top-10">
    @foreach($cells as $index => $cell)
        <livewire:single-cell :coord="$cell->xCoordinate . '-' . $cell->yCoordinate" :key="$cell->xCoordinate . $cell->yCoordinate" />
    @endforeach
</div>