<x-layouts.app :title="__('Dashboard')">
    <livewire:sudoku-board />
    {{-- @php
        $cell = ['xCoordinate' => 'A', 'yCoordinate' => 1];
    @endphp 
    <livewire:single-cell :cell="$cell" /> --}}
    {{-- @php
        $cell = ['xCoordinate' => 'A', 'yCoordinate' => 1];
    @endphp
    <livewire:select-number :cell="$cell" /> --}}
</x-layouts.app>
