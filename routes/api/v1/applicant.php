<?php

use App\Http\Controllers\V1\Applicant\AuthController;
use App\Http\Controllers\V1\Applicant\Diploma\ContactDataController;
use App\Http\Controllers\V1\Applicant\Diploma\EducationalBackgroundDataController;
use App\Http\Controllers\V1\Applicant\Diploma\EmploymentDataController;
use App\Http\Controllers\V1\Applicant\Diploma\PersonalDataController;

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
    });