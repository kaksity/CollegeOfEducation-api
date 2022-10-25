<?php

namespace App\Providers;

use App\Services\Implementations\AcademicSessionServiceImplementation;
use App\Services\Implementations\CertificateServiceImplementation;
use App\Services\Implementations\CourseServiceImplementation;
use App\Services\Implementations\CourseSubjectServiceImplementation;
use App\Services\Implementations\ExaminationCategoryServiceImplementation;
use App\Services\Implementations\ExaminationSubjectServiceImplementation;
use App\Services\Implementations\LgaServiceImplementation;
use App\Services\Implementations\MaritalStatusImplementation;
use App\Services\Implementations\RequiredDocumentServiceImplementation;
use App\Services\Implementations\StateServiceImplementation;
use App\Services\Interfaces\AcademicSessionServiceInterface;
use App\Services\Interfaces\CertificateServiceInterface;
use App\Services\Interfaces\CourseServiceInterface;
use App\Services\Interfaces\CourseSubjectServiceInterface;
use App\Services\Interfaces\ExaminationCategoryServiceInterface;
use App\Services\Interfaces\ExaminationSubjectServiceInterface;
use App\Services\Interfaces\LgaServiceInterface;
use App\Services\Interfaces\MaritalStatusInterface;
use App\Services\Interfaces\RequiredDocumentServiceInterface;
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
        App::bind(CourseServiceInterface::class, CourseServiceImplementation::class);
        App::bind(CourseSubjectServiceInterface::class, CourseSubjectServiceImplementation::class);
        App::bind(RequiredDocumentServiceInterface::class, RequiredDocumentServiceImplementation::class);
        App::bind(ExaminationCategoryServiceInterface::class, ExaminationCategoryServiceImplementation::class);
        App::bind(ExaminationSubjectServiceInterface::class, ExaminationSubjectServiceImplementation::class);
        App::bind(AcademicSessionServiceInterface::class, AcademicSessionServiceImplementation::class);
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
