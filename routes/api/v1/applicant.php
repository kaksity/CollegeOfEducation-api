<?php

use App\Http\Controllers\V1\Applicant\AuthController;
use App\Http\Controllers\V1\Applicant\Diploma\ApplicantController;
use App\Http\Controllers\V1\Applicant\Diploma\ApplicationStatusController;
use App\Http\Controllers\V1\Applicant\Diploma\CertificateController;
use App\Http\Controllers\V1\Applicant\Diploma\ContactDataController;
use App\Http\Controllers\V1\Applicant\Diploma\CourseController;
use App\Http\Controllers\V1\Applicant\Diploma\CourseDataController;
use App\Http\Controllers\V1\Applicant\Diploma\EducationalBackgroundDataController;
use App\Http\Controllers\V1\Applicant\Diploma\EmploymentDataController;
use App\Http\Controllers\V1\Applicant\Diploma\ExaminationDataController;
use App\Http\Controllers\V1\Applicant\Diploma\LgaController;
use App\Http\Controllers\V1\Applicant\Diploma\MaritalStatusController;
use App\Http\Controllers\V1\Applicant\Diploma\PersonalDataController;
use App\Http\Controllers\V1\Applicant\Diploma\StateController;
use App\Http\Controllers\V1\Applicant\Diploma\ExtraCurricularActivityDataController;
use App\Http\Controllers\V1\Applicant\Diploma\HeldReponsibilityController;
use App\Http\Controllers\V1\Applicant\Diploma\PassportController;
use App\Http\Controllers\V1\Applicant\Diploma\ExaminationCategoryController;
use App\Http\Controllers\V1\Applicant\Diploma\ExaminationSubjectController;

    Route::group(['prefix' => 'auth'],function(){
        Route::post('login',[AuthController::class,'login']);
        Route::post('register', [AuthController::class,'register']);
        Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    });
    Route::group(['prefix'=>'diploma','middleware' => ['auth:sanctum']], function(){
        Route::apiResource('personal-data',PersonalDataController::class);
        Route::apiResource('contact-data', ContactDataController::class);
        Route::apiResource('educational-background-data', EducationalBackgroundDataController::class);
        Route::apiResource('employment-data', EmploymentDataController::class);
        Route::apiResource('course-data',CourseDataController::class);
        Route::apiResource('extra-curricular-activity-data', ExtraCurricularActivityDataController::class);
        Route::apiResource('held-responsibility-data', HeldReponsibilityController::class);
        Route::apiResource('passport-data', PassportController::class);
        Route::apiResource('examination-data', ExaminationDataController::class);
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