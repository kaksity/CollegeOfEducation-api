<?php

use App\Http\Controllers\V1\Admin\{
    ApplicantController,
    AuthController,
    CertificateController,
    CourseController,
    CourseSubjectController,
    ExaminationCategoryController,
    ExaminationSubjectController,
    LgaController,
    MaritalStatusController,
    StateController
};

Route::group(['prefix' => 'auth'],function(){
    Route::post('login',[AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::apiResource('certificates',CertificateController::class);
    Route::apiResource('marital-statuses',MaritalStatusController::class);
    Route::apiResource('lgas',LgaController::class);
    Route::apiResource('states',StateController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('examination-categories', ExaminationCategoryController::class);
    Route::apiResource('examination-subjects', ExaminationSubjectController::class);
    Route::apiResource('course-subjects', CourseSubjectController::class);
    Route::group(['prefix' => 'nce'], function() {
        Route::apiResource('applicants', ApplicantController::class);
    });
});

Route::get('/test', function () {
    return response()->json(
    [
        'username' => 'kaksity',
        'email' => 'daudapona2@gmail.com'
    ]);
});