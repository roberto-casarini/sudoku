<div class="container grid grid-cols-9 size-fit gap-0 relative top-10">
    @foreach($cells as $index => $cell)
        <x-single-cell :cell="$cell" :disabled="$disabled" :key="$index" />
    @endforeach
</div>