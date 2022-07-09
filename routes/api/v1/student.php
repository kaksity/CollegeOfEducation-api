<?php

use App\Http\Controllers\V1\Student\AuthController;
use App\Http\Controllers\V1\Student\Nce\ApplicationStatusController;
use App\Http\Controllers\V1\Student\Nce\CertificateController;
use App\Http\Controllers\V1\Student\Nce\ContactDataController;
use App\Http\Controllers\V1\Student\Nce\CourseController;
use App\Http\Controllers\V1\Student\Nce\CourseDataController;
use App\Http\Controllers\V1\Student\Nce\CourseSubjectController;
use App\Http\Controllers\V1\Student\Nce\EducationalBackgroundDataController;
use App\Http\Controllers\V1\Student\Nce\EmploymentDataController;
use App\Http\Controllers\V1\Student\Nce\ExaminationDataController;
use App\Http\Controllers\V1\Student\Nce\LgaController;
use App\Http\Controllers\V1\Student\Nce\MaritalStatusController;
use App\Http\Controllers\V1\Student\Nce\PersonalDataController;
use App\Http\Controllers\V1\Student\Nce\StateController;
use App\Http\Controllers\V1\Student\Nce\ExtraCurricularActivityDataController;
use App\Http\Controllers\V1\Student\Nce\HeldReponsibilityController;
use App\Http\Controllers\V1\Student\Nce\PassportController;
use App\Http\Controllers\V1\Student\Nce\ExaminationCategoryController;
use App\Http\Controllers\V1\Student\Nce\ExaminationSubjectController;
use App\Http\Controllers\V1\Student\Nce\RegisterCourseSubjectController;

    Route::group(['prefix' => 'nce/auth'],function(){
        Route::post('login',[AuthController::class,'login']);
        Route::post('register', [AuthController::class,'register']);
        Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    });
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
        Route::apiResource('application-statuses', ApplicationStatusController::class);
        Route::apiResource('registered-course-subjects', RegisterCourseSubjectController::class);

        Route::post('registered-course-subjects/autofill', [RegisterCourseSubjectController::class, 'autoFillCourses']);
        Route::get('marital-statuses', [MaritalStatusController::class, 'index']);
        Route::get('states', [StateController::class, 'index']);
        Route::get('lgas', [LgaController::class, 'index']);
        Route::get('certificates', [CertificateController::class, 'index']);
        Route::get('courses', [CourseController::class, 'index']);
        Route::get('examination-categories', [ExaminationCategoryController::class, 'index']);
        Route::get('examination-subjects', [ExaminationSubjectController::class, 'index']);

        Route::get('course-subjects', [CourseSubjectController::class, 'index']);
    });