<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ImportPersonnelContoller;
use App\Http\Controllers\Admin\PersonnelController;
use App\Http\Controllers\Admin\RecoverPersonnelContoller;
use App\Http\Controllers\Admin\AnalyticsFamiltyProfileController;
use App\Http\Controllers\Admin\EventInvatationController;
use App\Http\Controllers\Personnel\ProvinceController;
use App\Http\Controllers\Personnel\UserController;
use App\Http\Controllers\Personnel\FamilyProfileChildController;


use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\Personnel\FamiltyProfileController;
use App\Http\Controllers\Personnel\BaranggayController;
use App\Http\Controllers\Personnel\CityController;
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

//check credentials middleware
Route::middleware('auth:sanctum')->group(function () {

    // Admin routes and middleware where roles is being check if admin
    Route::prefix('/admin')->middleware(AdminMiddleware::class)->group(function () {
        Route::patch('/personnel/status',[PersonnelController::class,'change_personnel_status']);
        Route::get('/profileFamiltyAnalytics',[AnalyticsFamiltyProfileController::class,'FPAnalyic'],);
        Route::get('get_all_invited_province/{event_id}',[EventInvatationController::class,'invited_province']);

        Route::resource('/logs',LogsController::class)->only(['index','show']); 
        Route::resource('/profile', AdminController::class);
        Route::resource('/event',EventController::class);
        Route::resource('/recover_personnel',RecoverPersonnelContoller::class);
        Route::resource('/personnel',PersonnelController::class);
        Route::resource('/dashboard',DashboardContoller::class);
        Route::resource('/event_invitation',EventInvatationController::class);
        Route::resource('/personnel/importExcel',ImportPersonnelContoller::class)
            ->only(['store']);   
    });

    // Personnel routes and middleware where roles is being check if personnel
    Route::prefix('/personnel')->middleware(PersonnelMiddleware::class)->group(function () {
        Route::resource('/province',ProvinceController::class)->only(['destroy','store','index','show']);
        Route::resource('/city',CityController::class)->only(['destroy','store','index','show']);
        Route::resource('/baranggay',BaranggayController::class)->only(['destroy','store','index','show']);
        Route::resource('/famityProfile',FamiltyProfileController::class)->only(['destroy','store','index','show']);
        Route::resource('/famityProfileChild',FamilyProfileChildController::class)->only(['destroy','store','index','show']);
        Route::resource('/', UserController::class)->only(['index'])->only(['index']);
        Route::resource('/dashboard',DashboardContoller::class)->only(['index']);
        Route::resource('/event',EventController::class)->only(['index']);
    });


});


