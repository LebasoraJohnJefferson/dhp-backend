<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LogsController;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ImportPersonnelContoller;
use App\Http\Controllers\Admin\PersonnelController;
use App\Http\Controllers\Admin\RecoverPersonnelContoller;
use App\Http\Controllers\Admin\AnalyticsFamiltyProfileController;
use App\Http\Controllers\Admin\EventInvatationController;
use App\Http\Controllers\Admin\BaranggayController;
use App\Http\Controllers\InfantController;
use App\Http\Controllers\Personnel\UserController;
use App\Http\Controllers\Personnel\FamilyProfileMemberController;
use App\Http\Controllers\Personnel\FamiltyProfileController;
use App\Http\Controllers\PreschoolController;
use App\Http\Controllers\PreschoolWithNutrionalStatus;
use App\Http\Controllers\PreschoolAtRiskController;
use App\Http\Controllers\PupolationBracketController;
use Illuminate\Http\Request;
use App\Http\Controllers\RecoverFilesController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PersonnelMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('/login',[AuthController::class,'login']);
Route::post('/forgotpassword',[AuthController::class, 'forgotpassword']);
Route::post('/resetpassword',[AuthController::class, 'resetpassword']);

// Route::post('/register',[AuthController::class,'register']);

Route::get('/file/download/{fileName}',[FileController::class,'download']);
//check credentials middleware
Route::middleware('auth:sanctum')->group(function () {


    Route::resource('/infant',InfantController::class);
    Route::resource('/recover_files',RecoverFilesController::class);

    Route::resource('/famityProfile',FamiltyProfileController::class)->only(['destroy','store','index','show','update']);
    Route::resource('/file',FileController::class);
    Route::resource('/famityProfileMembers',FamilyProfileMemberController::class)->only(['destroy','store','index','show','update']);
    Route::resource('/baranggay',BaranggayController::class)->only(['destroy','store','index','show']);
    Route::resource('/dashboard',DashboardContoller::class)->only(['index','show']);
    Route::resource('/preschool',PreschoolController::class);
    Route::resource('/preschoolWIthNutrionalStatus',PreschoolWithNutrionalStatus::class);
    Route::resource('/preschoolAtRisk',PreschoolAtRiskController::class);

    // Admin routes and middleware where roles is being check if admin
    Route::prefix('/admin')->middleware(AdminMiddleware::class)->group(function () {
        Route::patch('/personnel/status',[PersonnelController::class,'change_personnel_status']);
        Route::patch('/updateAdminInfo',[UserController::class,'updateAdminInfo']);
        Route::get('/PopulationBracket',[PupolationBracketController::class,'PopulationBracket']);
        Route::get('/profileFamiltyAnalytics',[AnalyticsFamiltyProfileController::class,'FPAnalyic']);
        Route::get('/profileInfantAnlytics/{year}',[AnalyticsFamiltyProfileController::class,'InfantAnalyic']);
        Route::get('/PreschoolWithNutritionalStatusAnlytics/{year}', [AnalyticsFamiltyProfileController::class, 'PreschoolWithNutritionalStatus']);
        Route::get('/AtRiskAnalytics/{year}', [AnalyticsFamiltyProfileController::class, 'AtRiskAnalytics']);
        Route::get('/BrgyPreschoolerAnalytic/{year}',[AnalyticsFamiltyProfileController::class,'BrgyPreschoolerAnalytic']);


        Route::get('/get_all_invited_province/{event_id}',[EventInvatationController::class,'invited_province']);
        Route::post('/saveImportedFCM/{FP_id}',[FamilyProfileMemberController::class,'saveImportedFCM']);
        Route::post('/saveImportedFamilyProfile',[FamiltyProfileController::class,'saveImportedFamilyProfile']);

        Route::resource('/logs',LogsController::class)->only(['index','show']);
        Route::resource('/profile', AdminController::class);
        Route::resource('/event',EventController::class);
        Route::resource('/recover_personnel',RecoverPersonnelContoller::class);
        Route::resource('/personnel',PersonnelController::class);
        Route::resource('/event_invitation',EventInvatationController::class);
        Route::resource('/personnel/importExcel',ImportPersonnelContoller::class)->only(['store']);
    });

    // Personnel routes and middleware where roles is being check if personnel
    Route::prefix('/personnel')->middleware(PersonnelMiddleware::class)->group(function () {
        Route::put('/basicInfo',[UserController::class,'BasicInfo']);
        Route::put('/moreInfo',[UserController::class,'MoreInfo']);
        Route::resource('/personnelEvent',EventController::class)->only(['index']);
        Route::resource('/', UserController::class)->only(['index']);
    });



});


