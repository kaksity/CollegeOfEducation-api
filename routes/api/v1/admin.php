<?php
use App\Http\Controllers\V1\Admin\{AuthController, ApplicantController, DashboardController};
use App\Http\Controllers\V1\Admin\Bursary\AdmissionSetPaymentController;
use App\Http\Controllers\V1\Admin\Bursary\ApplicantProcessedPaymentController;
use App\Http\Controllers\V1\Admin\Bursary\ApplicantSetPaymentController;
use App\Http\Controllers\V1\Admin\Bursary\CourseRegisterationPinController;
use App\Http\Controllers\V1\Admin\GeneralSettings\{
    CertificateController,
    CourseController,
    CourseGroupController,
    CourseSubjectController,
    ExaminationCategoryController,
    ExaminationSubjectController,
    LgaController,
    MaritalStatusController,
    AcademicSessionController,
    RequiredDocumentController,
    StateController
};
use App\Http\Controllers\V1\Admin\Bursary\CoursePaymentController;
use App\Http\Controllers\V1\Admin\Bursary\RegisterationPaymentController;
use App\Http\Controllers\V1\Admin\ICT\UploadStudentController;
use App\Http\Controllers\V1\Admin\ICT\ReturningStudentController;
use App\Http\Controllers\V1\Admin\ICT\StudentsController;

Route::group(['prefix' => 'auth'],function(){
    Route::post('login',[AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    Route::post('forgot-password/request', [AuthController::class, 'requestPasswordVerification']);
    Route::post('forgot-password/verify', [AuthController::class, 'verifyPasswordVerificationCode']);
});

Route::group(['middleware' => ['auth:sanctum', 'verify.is.admin']], function() {
    Route::group(['prefix' => 'general-settings'], function() {
        Route::apiResource('certificates',CertificateController::class);
        Route::apiResource('required-documents',RequiredDocumentController::class);
        Route::apiResource('marital-statuses',MaritalStatusController::class);
        Route::apiResource('lgas',LgaController::class);
        Route::apiResource('states',StateController::class);
        Route::apiResource('courses', CourseController::class);
        Route::apiResource('examination-categories', ExaminationCategoryController::class);
        Route::apiResource('examination-subjects', ExaminationSubjectController::class);
        Route::apiResource('course-subjects', CourseSubjectController::class);
        Route::apiResource('academic-sessions', AcademicSessionController::class);
        Route::apiResource('course-groups', CourseGroupController::class);
    });

    Route::get('dashboard',[DashboardController::class, 'index']);

    Route::group(['prefix' => 'admission', 'middleware' => 'verify.is.admission.office'], function () {
        Route::group(['prefix' => 'regular'], function() {
            Route::apiResource('applicants', ApplicantController::class);
        });
    });
    Route::group(['prefix'=> 'bursary', 'middleware' => ['verify.is.bursary.office']], function () {
        Route::apiResource('course-payments', CoursePaymentController::class);
        Route::apiResource('registeration-payments', RegisterationPaymentController::class);
        Route::apiResource('applicant-set-payments', ApplicantSetPaymentController::class);
        Route::apiResource('admission-set-payments', AdmissionSetPaymentController::class);
        Route::apiResource('applicant-processed-payments', ApplicantProcessedPaymentController::class);
        Route::apiResource('course-registeration-pins', CourseRegisterationPinController::class);
    });

    Route::group(['prefix' => 'ict', 'middleware' => ['verify.is.ict.office']], function () {
        Route::apiResource('upload-students', UploadStudentController::class);
        Route::apiResource('returning-students', ReturningStudentController::class);
        Route::apiResource('students', StudentsController::class);
    });
});

Route::get('/test', function () {
    return response()->json(
    [
        'username' => 'kaksity',
        'email' => 'daudapona2@gmail.com'
    ]);
});
