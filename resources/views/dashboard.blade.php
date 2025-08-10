<x-layouts.app :title="__('Dashboard')">
    <div class="container grid grid-cols-2 size-fit gap-4 w-full h-full">
        <div>
            <livewire:database-connection />
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
