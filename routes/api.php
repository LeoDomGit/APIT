<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoaiTKController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\QuanController;



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

Route::get('/themtk',[LoaiTKController::class,'themtk']);
Route::get('/allLTK',[LoaiTKController::class,'all']);
Route::post('/them',[LoaiTKController::class,'createthem']);

// ==============================================

Route::post('/addUser',[UserController::class,'create']);
Route::get('/allUser',[UserController::class,'all']);
// ==============================

Route::post('/addQuan',[QuanController::class,'create']);
Route::GET('/allQuan',[QuanController::class,'all']);
Route::post('/editQuan',[QuanController::class,'edit']);
Route::post('/deleteQuan',[QuanController::class,'destroy']);

