<x-layouts.app :title="__('Dashboard')">
    {{-- <livewire:sudoku-board /> --}}
    {{-- @php
        $cell = ['xCoordinate' => 'A', 'yCoordinate' => 1];
    @endphp 
    <livewire:single-cell :cell="$cell" /> --}}
    {{-- @php
        $cell = ['xCoordinate' => 'A', 'yCoordinate' => 1];
    @endphp
    <livewire:select-number :cell="$cell" /> --}}
    {{-- <livewire:setup-board /> --}}
    <div class="container grid grid-cols-2 size-fit gap-4 w-full h-full">
        <div><livewire:sudoku-board /></div>
        <div class="flex flex-col">
            <div class="w-max">
                <livewire:select-number />
                <livewire:setup-board />
            </div>
        </div>
    </div>
</x-layouts.app>
