@php
    $implementation = config('sudoku.implementation', 'controllers');
    $initialGameState = json_encode([
        'cells' => $initialCells ?? [],
        'game_status' => $initialGameStatus ?? 'beginning',
    ]);
@endphp

<x-layouts.app :title="__('Dashboard')">
    @if($implementation !== 'livewire')
        {{-- Initialize Alpine store with server-side data before Alpine components load --}}
        <script>
            window.__INITIAL_GAME_STATE__ = {!! $initialGameState !!};
        </script>
    @endif
    
    <div class="container grid grid-flow-col auto-cols-max gap-4 w-full justify-center mx-auto">
        @if($implementation === 'livewire')
            {{-- Livewire Implementation --}}
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
        @else
            {{-- MVC + Alpine.js Implementation --}}
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
        @endif
    </div>
</x-layouts.app>
