<?php

use App\Http\Controllers\FleetOwnerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;

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
Route::post('/register', [UserAuthController::class, 'register']);
Route::get('/getUser', [UserAuthController::class, 'getUser'])->middleware('auth:sanctum');
Route::post('/uploadProfilePicture',[UserAuthController::class,'uploadProfilePicture'])->middleware('auth:sanctum');
Route::post('/login',[UserAuthController::class,'login']);
Route::post('/createPost',[PostController::class,'create'])->middleware('auth:sanctum');
Route::post('/getAllFleetOwner',[FleetOwnerController::class,'getAllFleetOwner'])->middleware('auth:sanctum');
Route::post('/fleetOwner/addImage',[FleetOwnerController::class,'addImage'])->middleware('auth:sanctum');
Route::get('/fleetOwner/getAllImages',[FleetOwnerController::class,'getFleetOwnerImages'])->middleware('auth:sanctum');
Route::post('/driver/addImage',[DriverController::class,'addImage'])->middleware('auth:sanctum');
Route::get('/driver/getAllImages',[DriverController::class,'getDriverImages'])->middleware('auth:sanctum');
Route::post('/getAllDriver',[DriverController::class,'getAllDriver'])->middleware('auth:sanctum');
 