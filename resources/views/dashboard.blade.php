<x-layouts.app :title="__('Dashboard')">
    <div class="container grid grid-flow-col auto-cols-max gap-4 w-full justify-center mx-auto">
        <div>
            <x-flash-message />
            <x-sudoku-board />
        </div>
        <div class="flex flex-col">
            <div class="w-max">
                <livewire:select-number />
                <livewire:setup-board />
            </div>
        </div>
    </div>
</x-layouts.app>
