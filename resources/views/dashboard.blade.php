<x-layouts.app :title="__('Dashboard')">
    <div class="container grid grid-flow-col auto-cols-max gap-4 w-full justify-center mx-auto">
        <div>
            <x-ajax-message />
            <x-sudoku-board />
        </div>
        <div class="flex flex-col">
            <div class="w-max">
                <x-select-number />
                <x-setup-board />
            </div>
        </div>
    </div>
</x-layouts.app>
