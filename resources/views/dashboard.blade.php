<x-layouts.app :title="__('Dashboard')">
    <!--<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>-->
    {{-- @livewire("single-cell", ["borders" => ["top"]]) --}}
    <?php
        /*$props = new App\Livewire\Wireables\SingleCellProps();
        $props->xCoordinate = "B";
        $props->yCoordinate = 1;*/
    ?>
    <!--<livewire:single-cell :props=$props />-->
    <livewire:sudoku-board />
</x-layouts.app>
