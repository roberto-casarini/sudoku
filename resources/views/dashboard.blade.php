<x-layouts.app :title="__('Dashboard')">
    <div class="container grid grid-flow-col auto-cols-max gap-4 w-full overflow-x-auto justify-center mx-auto">
    <!--<div class="container grid grid-cols-3 auto-cols-[minmax(auto,1fr)] gap-4 w-full">-->
    <!--<div class="container grid grid-cols-2 size-fit gap-4 w-full h-full">-->
        <div>
            <livewire:flash-message />
            <livewire:sudoku-board />
        </div>
        <div class="flex flex-col">
            <div class="w-max">
                <livewire:select-number />
                <livewire:setup-board />
            </div>
        </div>
    </div>
</x-layouts.app>
