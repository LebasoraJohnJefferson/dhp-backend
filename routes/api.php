<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonnelController;
use Illuminate\Http\Request;
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
        Route::resource('/personnel',PersonnelController::class);
    });

    // Personnel routes and middleware where roles is being check if personnel
    Route::prefix('/personnel')->middleware(PersonnelMiddleware::class)->group(function () {
        Route::resource('/', PersonnelController::class)->only(['index']);
    });
});


