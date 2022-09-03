<?php

use App\Http\Controllers\V1\Student\AuthController;
use App\Http\Controllers\V1\Student\Regular\ApplicationStatusController;
use App\Http\Controllers\V1\Student\Regular\CertificateController;
use App\Http\Controllers\V1\Student\Regular\ContactDataController;
use App\Http\Controllers\V1\Student\Regular\CourseController;
use App\Http\Controllers\V1\Student\Regular\CourseDataController;
use App\Http\Controllers\V1\Student\Regular\CourseSubjectController;
use App\Http\Controllers\V1\Student\Regular\EducationalBackgroundDataController;
use App\Http\Controllers\V1\Student\Regular\EmploymentDataController;
use App\Http\Controllers\V1\Student\Regular\ExaminationDataController;
use App\Http\Controllers\V1\Student\Regular\LgaController;
use App\Http\Controllers\V1\Student\Regular\MaritalStatusController;
use App\Http\Controllers\V1\Student\Regular\PersonalDataController;
use App\Http\Controllers\V1\Student\Regular\StateController;
use App\Http\Controllers\V1\Student\Regular\ExtraCurricularActivityDataController;
use App\Http\Controllers\V1\Student\Regular\HeldReponsibilityController;
use App\Http\Controllers\V1\Student\Regular\PassportController;
use App\Http\Controllers\V1\Student\Regular\ExaminationCategoryController;
use App\Http\Controllers\V1\Student\Regular\ExaminationCenterDataController;
use App\Http\Controllers\V1\Student\Regular\ExaminationSubjectController;
use App\Http\Controllers\V1\Student\Regular\RegisterCourseSubjectController;
use App\Http\Controllers\V1\Student\Regular\RegistrationPaymentController;
use App\Http\Controllers\V1\Student\Regular\RequiredDocumentDataController;

    Route::group(['prefix' => 'regular/auth'],function(){
        Route::post('login',[AuthController::class,'login']);
        Route::post('register', [AuthController::class,'register']);
        Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
        Route::post('forgot-password/request', [AuthController::class, 'requestPasswordVerification']);
        Route::post('forgot-password/verify', [AuthController::class, 'verifyPasswordVerificationCode']);
    });
    Route::group(['prefix' => 'regular', 'middleware' => ['auth:sanctum']], function() {
        Route::post('/registeration-payments/initialize', [RegistrationPaymentController::class, 'initiatePayment']);
        Route::post('/registeration-payments/card-pin', [RegistrationPaymentController::class, 'useCourseRegisterationPin']);
    });
    Route::group(['prefix'=>'regular','middleware' => ['auth:sanctum']], function(){
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
        
        Route::apiResource('required-document-data', RequiredDocumentDataController::class);
        Route::apiResource('examination-center-data', ExaminationCenterDataController::class);
        Route::group(['prefix' => 'registered-course-subjects', 'middleware' => ['verify.regular.registeration.payment', 'verify.regular.id.number','verify.regular.is.course.registered']], function() {
            Route::apiResource('/', RegisterCourseSubjectController::class);
            Route::post('/autofill', [RegisterCourseSubjectController::class, 'autoFillCourses']);
        });
        
        Route::get('marital-statuses', [MaritalStatusController::class, 'index']);
        Route::get('states', [StateController::class, 'index']);
        Route::get('lgas', [LgaController::class, 'index']);
        Route::get('certificates', [CertificateController::class, 'index']);
        Route::get('courses', [CourseController::class, 'index']);
        Route::get('examination-categories', [ExaminationCategoryController::class, 'index']);
        Route::get('examination-subjects', [ExaminationSubjectController::class, 'index']);

        Route::get('course-subjects', [CourseSubjectController::class, 'index']);
    });