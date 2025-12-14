@php
    $implementation = config('sudoku.implementation', 'controllers');
@endphp

<x-layouts.app :title="__('Dashboard')">
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
