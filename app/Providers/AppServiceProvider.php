<?php

namespace App\Providers;

use App\Services\Implementations\Bursary\AdmissionPaymentServiceImplementation;
use App\Services\Implementations\Bursary\ApplicationPaymentServiceImplementation;
use App\Services\Implementations\Bursary\CoursePaymentServiceImplementation;
use App\Services\Implementations\Bursary\CourseRegistrationCardServiceImplementation;
use App\Services\Implementations\General\AuthenticationServiceImplementation;
use App\Services\Implementations\GeneralSettings\AcademicSessionServiceImplementation;
use App\Services\Implementations\GeneralSettings\CertificateServiceImplementation;
use App\Services\Implementations\GeneralSettings\CourseGroupServiceImplementation;
use App\Services\Implementations\GeneralSettings\CourseServiceImplementation;
use App\Services\Implementations\GeneralSettings\CourseSubjectServiceImplementation;
use App\Services\Implementations\GeneralSettings\ExaminationCategoryServiceImplementation;
use App\Services\Implementations\GeneralSettings\ExaminationSubjectServiceImplementation;
use App\Services\Implementations\GeneralSettings\LgaServiceImplementation;
use App\Services\Implementations\GeneralSettings\MaritalStatusImplementation;
use App\Services\Implementations\GeneralSettings\RequiredDocumentServiceImplementation;
use App\Services\Implementations\GeneralSettings\StateServiceImplementation;
use App\Services\Implementations\Students\StudentServiceImplementation;
use App\Services\Interfaces\Bursary\AdmissionPaymentServiceInterface;
use App\Services\Interfaces\Bursary\ApplicationPaymentServiceInterface;
use App\Services\Interfaces\Bursary\CoursePaymentServiceInterface;
use App\Services\Interfaces\Bursary\CourseRegistrationCardServiceInterface;
use App\Services\Interfaces\General\AuthenticationServiceInterface;
use App\Services\Interfaces\GeneralSettings\AcademicSessionServiceInterface;
use App\Services\Interfaces\GeneralSettings\CertificateServiceInterface;
use App\Services\Interfaces\GeneralSettings\CourseGroupServiceInterface;
use App\Services\Interfaces\GeneralSettings\CourseServiceInterface;
use App\Services\Interfaces\GeneralSettings\CourseSubjectServiceInterface;
use App\Services\Interfaces\GeneralSettings\ExaminationCategoryServiceInterface;
use App\Services\Interfaces\GeneralSettings\ExaminationSubjectServiceInterface;
use App\Services\Interfaces\GeneralSettings\LgaServiceInterface;
use App\Services\Interfaces\GeneralSettings\MaritalStatusInterface;
use App\Services\Interfaces\GeneralSettings\RequiredDocumentServiceInterface;
use App\Services\Interfaces\GeneralSettings\StateServiceInterface;
use App\Services\Interfaces\Students\StudentServiceInterface;

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
        App::bind(CourseGroupServiceInterface::class, CourseGroupServiceImplementation::class);
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

        App::bind(AuthenticationServiceInterface::class, AuthenticationServiceImplementation::class);
        App::bind(StudentServiceInterface::class, StudentServiceImplementation::class);
        App::bind(ApplicationPaymentServiceInterface::class, ApplicationPaymentServiceImplementation::class);
        App::bind(AdmissionPaymentServiceInterface::class, AdmissionPaymentServiceImplementation::class);
        App::bind(CoursePaymentServiceInterface::class, CoursePaymentServiceImplementation::class);
        App::bind(CourseRegistrationCardServiceInterface::class, CourseRegistrationCardServiceImplementation::class);
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
