<div class="container grid grid-cols-9 size-fit">
    @foreach($cells as $index => $cell)
        <livewire:single-cell :key=$index :props=$cell>
    @endforeach
</div>