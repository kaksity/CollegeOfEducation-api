<?php

use App\Http\Controllers\V1\Applicant\AuthController;
use App\Http\Controllers\V1\Applicant\Nce\ApplicantController;
use App\Http\Controllers\V1\Applicant\Nce\ApplicationStatusController;
use App\Http\Controllers\V1\Applicant\Nce\CertificateController;
use App\Http\Controllers\V1\Applicant\Nce\ContactDataController;
use App\Http\Controllers\V1\Applicant\Nce\CourseController;
use App\Http\Controllers\V1\Applicant\Nce\CourseDataController;
use App\Http\Controllers\V1\Applicant\Nce\EducationalBackgroundDataController;
use App\Http\Controllers\V1\Applicant\Nce\EmploymentDataController;
use App\Http\Controllers\V1\Applicant\Nce\ExaminationDataController;
use App\Http\Controllers\V1\Applicant\Nce\LgaController;
use App\Http\Controllers\V1\Applicant\Nce\MaritalStatusController;
use App\Http\Controllers\V1\Applicant\Nce\PersonalDataController;
use App\Http\Controllers\V1\Applicant\Nce\StateController;
use App\Http\Controllers\V1\Applicant\Nce\ExtraCurricularActivityDataController;
use App\Http\Controllers\V1\Applicant\Nce\HeldReponsibilityController;
use App\Http\Controllers\V1\Applicant\Nce\PassportController;
use App\Http\Controllers\V1\Applicant\Nce\ExaminationCategoryController;
use App\Http\Controllers\V1\Applicant\Nce\ExaminationCenterDataController;
use App\Http\Controllers\V1\Applicant\Nce\ExaminationSubjectController;

    Route::group(['prefix' => 'nce/auth'],function(){
        Route::post('login',[AuthController::class,'login']);
        Route::post('register', [AuthController::class,'register']);
        Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    });
    //, 'verify.application.payment'
    Route::group(['prefix'=>'nce','middleware' => ['auth:sanctum']], function(){
        Route::apiResource('personal-data',PersonalDataController::class);
        Route::apiResource('contact-data', ContactDataController::class);
        Route::apiResource('educational-background-data', EducationalBackgroundDataController::class);
        Route::apiResource('employment-data', EmploymentDataController::class);
        Route::apiResource('course-data',CourseDataController::class);
        Route::apiResource('extra-curricular-activity-data', ExtraCurricularActivityDataController::class);
        Route::apiResource('held-responsibility-data', HeldReponsibilityController::class);
        Route::apiResource('passport-data', PassportController::class);
        Route::apiResource('examination-data', ExaminationDataController::class);
        Route::apiResource('examination-center-data', ExaminationCenterDataController::class);
        Route::apiResource('application-statuses', ApplicationStatusController::class);
        Route::apiResource('applicant-profiles', ApplicantController::class);

        Route::get('marital-statuses', [MaritalStatusController::class, 'index']);
        Route::get('states', [StateController::class, 'index']);
        Route::get('lgas', [LgaController::class, 'index']);
        Route::get('certificates', [CertificateController::class, 'index']);
        Route::get('courses', [CourseController::class, 'index']);
        Route::get('examination-categories', [ExaminationCategoryController::class, 'index']);
        Route::get('examination-subjects', [ExaminationSubjectController::class, 'index']);
    });