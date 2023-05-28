<?php

namespace App\Providers;

use App\Service\Contract\ShortLinkServiceContract;
use App\Service\Contract\UserServiceContract;
use App\Service\ShortLinkService;
use App\Service\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(ShortLinkServiceContract::class, ShortLinkService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
