<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\DomainRepositoryInterface;
use App\Repositories\DomainRepository;
use App\Interfaces\CheckRepositoryInterface;
use App\Repositories\CheckRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DomainRepositoryInterface::class, DomainRepository::class);
        $this->app->bind(CheckRepositoryInterface::class, CheckRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
