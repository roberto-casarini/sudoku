<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sudoku Implementation
    |--------------------------------------------------------------------------
    |
    | This configuration allows you to switch between different implementations
    | of the Sudoku game dashboard:
    |
    | - 'livewire': Uses Laravel Livewire components for full-stack reactivity
    | - 'controllers': Uses traditional MVC controllers with Alpine.js frontend
    |
    | You can change this value via the SUDOKU_IMPLEMENTATION environment variable.
    |
    */

    'implementation' => env('SUDOKU_IMPLEMENTATION', 'controllers'),

    /*
    |--------------------------------------------------------------------------
    | Implementation Details
    |--------------------------------------------------------------------------
    |
    | These settings define the paths and namespaces for each implementation.
    | Modify these only if you've customized the directory structure.
    |
    */

    'implementations' => [
        'livewire' => [
            'namespace' => 'App\\Livewire',
            'view_path' => 'livewire',
            'route_prefix' => 'livewire',
        ],
        'controllers' => [
            'namespace' => 'App\\View\\Components',
            'view_path' => 'components',
            'route_prefix' => 'api',
        ],
    ],
];
