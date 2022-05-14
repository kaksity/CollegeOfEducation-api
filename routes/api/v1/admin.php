<?php

use App\Http\Controllers\V1\Admin\{
    CertificateController,
    LgaController,
    MaritalStatusController,
    StateController
};

Route::apiResource('certificates',CertificateController::class);
Route::apiResource('marital-statuses',MaritalStatusController::class);
Route::apiResource('lgas',LgaController::class);
Route::apiResource('states',StateController::class);

Route::get('/test', function () {
    return response()->json(
    [
        'username' => 'kaksity',
        'email' => 'daudapona2@gmail.com'
    ]);
});