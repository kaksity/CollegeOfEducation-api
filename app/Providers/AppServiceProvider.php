<?php

namespace App\Providers;

use App\Services\Implementations\CertificateServiceImplementation;
use App\Services\Implementations\LgaServiceImplementation;
use App\Services\Implementations\MaritalStatusImplementation;
use App\Services\Implementations\StateServiceImplementation;
use App\Services\Interfaces\CertificateServiceInterface;
use App\Services\Interfaces\LgaServiceInterface;
use App\Services\Interfaces\MaritalStatusInterface;
use App\Services\Interfaces\StateServiceInterface;
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
        App::bind(CertificateServiceInterface::class, CertificateServiceImplementation::class);
        App::bind(StateServiceInterface::class, StateServiceImplementation::class);
        App::bind(LgaServiceInterface::class, LgaServiceImplementation::class);
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
