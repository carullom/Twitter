<?php

use App\Http\Controllers\TwitterController;
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

Route::post('/insert',[TwitterController::class,'insert']);
Route::get('/tweet',[TwitterController::class,'tweet']);
Route::post('/schedule',[TwitterController::class,'schedule']);
Route::get('/schedulepost',[TwitterController::class,'schedulePost']);
Route::get('/user',[TwitterController::class,'user']);
