<?php

use App\Http\Controllers\V1\Applicant\AuthController;
use App\Http\Controllers\V1\Applicant\Regular\ApplicantController;
use App\Http\Controllers\V1\Applicant\Regular\ApplicationPaymentController;
use App\Http\Controllers\V1\Applicant\Regular\ApplicationStatusController;
use App\Http\Controllers\V1\Applicant\Regular\CertificateController;
use App\Http\Controllers\V1\Applicant\Regular\ContactDataController;
use App\Http\Controllers\V1\Applicant\Regular\CourseController;
use App\Http\Controllers\V1\Applicant\Regular\CourseDataController;
use App\Http\Controllers\V1\Applicant\Regular\CourseGroupController;
use App\Http\Controllers\V1\Applicant\Regular\EducationalBackgroundDataController;
use App\Http\Controllers\V1\Applicant\Regular\EmploymentDataController;
use App\Http\Controllers\V1\Applicant\Regular\ExaminationDataController;
use App\Http\Controllers\V1\Applicant\Regular\LgaController;
use App\Http\Controllers\V1\Applicant\Regular\MaritalStatusController;
use App\Http\Controllers\V1\Applicant\Regular\PersonalDataController;
use App\Http\Controllers\V1\Applicant\Regular\StateController;
use App\Http\Controllers\V1\Applicant\Regular\ExtraCurricularActivityDataController;
use App\Http\Controllers\V1\Applicant\Regular\HeldReponsibilityController;
use App\Http\Controllers\V1\Applicant\Regular\PassportController;
use App\Http\Controllers\V1\Applicant\Regular\ExaminationCategoryController;
use App\Http\Controllers\V1\Applicant\Regular\ExaminationCenterDataController;
use App\Http\Controllers\V1\Applicant\Regular\ExaminationSubjectController;
use App\Http\Controllers\V1\Applicant\Regular\RequiredDocumentController;
use App\Http\Controllers\V1\Applicant\Regular\RequiredDocumentDataController;

    Route::group(['prefix' => 'regular/auth'],function(){
        Route::post('login',[AuthController::class,'login']);
        Route::post('register', [AuthController::class,'register']);
        Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    });
    
    Route::group(['prefix' => 'regular'], function() {
        Route::get('course-groups', [CourseGroupController::class, 'index']);
    });
    Route::group(['prefix' => 'regular', 'middleware' => ['auth:sanctum']], function() {
        Route::post('/application-payments/initialize', [ApplicationPaymentController::class, 'initiatePayment']);
    });

    Route::group(['prefix'=>'regular','middleware' => ['auth:sanctum', 'verify.nce.application.payment']], function(){
        Route::apiResource('personal-data',PersonalDataController::class);
        Route::apiResource('contact-data', ContactDataController::class);
        Route::apiResource('educational-background-data', EducationalBackgroundDataController::class);
        Route::apiResource('employment-data', EmploymentDataController::class);
        Route::apiResource('course-data',CourseDataController::class);
        Route::apiResource('extra-curricular-activity-data', ExtraCurricularActivityDataController::class);
        Route::apiResource('held-responsibility-data', HeldReponsibilityController::class);
        Route::apiResource('passport-data', PassportController::class);
        Route::apiResource('required-document-data', RequiredDocumentDataController::class);
        Route::apiResource('examination-data', ExaminationDataController::class);
        Route::apiResource('examination-center-data', ExaminationCenterDataController::class);
        Route::apiResource('application-statuses', ApplicationStatusController::class);
        Route::apiResource('applicant-profiles', ApplicantController::class);

        


        Route::get('marital-statuses', [MaritalStatusController::class, 'index']);
        Route::get('required-documents', [RequiredDocumentController::class, 'index']);
        Route::get('states', [StateController::class, 'index']);
        Route::get('lgas', [LgaController::class, 'index']);
        Route::get('certificates', [CertificateController::class, 'index']);
        Route::get('courses', [CourseController::class, 'index']);
        Route::get('examination-categories', [ExaminationCategoryController::class, 'index']);
        Route::get('examination-subjects', [ExaminationSubjectController::class, 'index']);
        
    });