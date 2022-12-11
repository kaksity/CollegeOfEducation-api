<?php

use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\BuildingController;
use App\Http\Controllers\Web\Department\AgriculturalTechnologyController;
use App\Http\Controllers\Web\Department\AnimalHealthProductionController;
use App\Http\Controllers\Web\CoursesController;
use App\Http\Controllers\Web\Department\BasicScienceController;
use App\Http\Controllers\Web\Department\ConsultController;
use App\Http\Controllers\Web\Department\EntrepreneurshipCenterController;
use App\Http\Controllers\Web\Department\FarmController;
use App\Http\Controllers\Web\Department\ForestryTechnologyController;
use App\Http\Controllers\Web\Department\GeneralStudiesController;
use App\Http\Controllers\Web\Department\HomeRuralEconomicsController;
use App\Http\Controllers\Web\Department\IctController;

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PolicyController;
use App\Http\Controllers\Web\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);

Route::get('/courses', [CoursesController::class, 'index']);
Route::get('/department/entrepreneurship-center', [EntrepreneurshipCenterController::class, 'index']);
Route::get('/department/agt', [AgriculturalTechnologyController::class, 'index']);
Route::get('/department/ahp', [AnimalHealthProductionController::class, 'index']);
Route::get('/department/basic-science', [BasicScienceController::class, 'index']);
Route::get('/department/farm', [FarmController::class, 'index']);
Route::get('/department/ft', [ForestryTechnologyController::class, 'index']);
Route::get('/department/consult', [ConsultController::class, 'index']);
Route::get('/department/gst', [GeneralStudiesController::class, 'index']);
Route::get('/department/hre', [HomeRuralEconomicsController::class, 'index']);
Route::get('/department/ict', [IctController::class, 'index']);
Route::get('/policy/student-affairs-office', [PolicyController::class, 'studentAffairs']);
Route::get('/policy/admission-policy-and-fees', [PolicyController::class, 'admissionPolicy']);
Route::get('/staff', [StaffController::class, 'index']);
Route::get('/building', [BuildingController::class, 'index']);
