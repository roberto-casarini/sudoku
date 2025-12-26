<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\Persistence\PersistenceInterface;
use App\Classes\Persistence\PersistenceSession;
use App\Classes\SudokuBL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind persistence interface
        $this->app->singleton(PersistenceInterface::class, PersistenceSession::class);
        
        // Bind SudokuBL - NOT as singleton so each request gets fresh state from session
        $this->app->bind(SudokuBL::class, function ($app) {
            return new SudokuBL($app->make(PersistenceInterface::class));
        });    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
