<div class="container grid grid-cols-9 size-fit gap-0">
    @foreach($cells as $index => $cell)
        <livewire:single-cell :key=$index :cell=$cell />
    @endforeach
</div>