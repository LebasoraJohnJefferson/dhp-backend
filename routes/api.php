<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ImportPersonnelContoller;
use App\Http\Controllers\Admin\PersonnelController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\RecoverPersonnelContoller;
use App\Http\Controllers\Personnel\UserController;


use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
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
// Route::post('/register',[AuthController::class,'register']);

//check credentials middleware
Route::middleware('auth:sanctum')->group(function () {
    
    // Admin routes and middleware where roles is being check if admin
    Route::prefix('/admin')->middleware(AdminMiddleware::class)->group(function () {
        Route::resource('/profile', AdminController::class);
        Route::resource('/event',EventController::class);
        Route::resource('/recover_personnel',RecoverPersonnelContoller::class);
        Route::patch('/personnel/status',[PersonnelController::class,'change_personnel_status']);
        Route::resource('/personnel',PersonnelController::class);
        Route::resource('/dashboard',DashboardContoller::class);
        Route::resource('/personnel/importExcel',ImportPersonnelContoller::class)
            ->only(['store']);
    });

    // Personnel routes and middleware where roles is being check if personnel
    Route::prefix('/personnel')->middleware(PersonnelMiddleware::class)->group(function () {
        Route::resource('/province',ProvinceController::class);
        Route::resource('/', UserController::class)->only(['index']);
    });
});


