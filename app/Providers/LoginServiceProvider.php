<?php

namespace App\Providers;

use App\Service\Impl\LoginServiceImpl;
use App\Service\LoginService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        LoginService::class => LoginServiceImpl::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function provides()
    {
        return [LoginService::class];
    }
}
