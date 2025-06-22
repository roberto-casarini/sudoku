<x-layouts.app :title="__('Dashboard')">
    <!--<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>-->
    {{-- @livewire("single-cell", ["borders" => ["top"]]) --}}
    <livewire:sudoku-board />
    {{-- @php
        $cell = ['xCoordinate' => 'D', 'yCoordinate' => 4];
    @endphp 
    <livewire:single-cell :cell="$cell" /> --}}
    {{-- @php
        $cell = ['xCoordinate' => 'A', 'yCoordinate' => 1];
    @endphp
    <livewire:select-number :cell="$cell" /> --}}
</x-layouts.app>
