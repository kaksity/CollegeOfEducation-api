<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/admin')->group(__DIR__.'/api/v1/admin.php');
Route::prefix('v1/applicant')->group(__DIR__.'/api/v1/applicant.php');
Route::prefix('v1/student')->group(__DIR__.'/api/v1/student.php');