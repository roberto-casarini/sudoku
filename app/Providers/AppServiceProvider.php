<?php

namespace App\Providers;

use App\Classes\Persistence\PersistenceFake;
use Illuminate\Support\ServiceProvider;
use App\Classes\Persistence\PersistenceInterface;
use App\Classes\Persistence\PersistenceSession;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PersistenceInterface::class, PersistenceSession::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
