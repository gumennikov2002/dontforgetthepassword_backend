<?php

namespace App\Providers;

use App\Contracts\DataServiceContract;
use App\Contracts\UserServiceContract;
use App\Services\LocalDataService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(DataServiceContract::class, LocalDataService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
