<?php

namespace App\Providers;

use App\Services\Implementations\MaritalStatusImplementation;
use App\Services\Interfaces\MaritalStatusInterface;
use Illuminate\Support\Facades\App;
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
        //
        App::bind(MaritalStatusInterface::class, MaritalStatusImplementation::class);
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
