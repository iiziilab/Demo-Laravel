<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SubjectController;


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
Route::post("login",[LoginController::class,'login'])->name('user.login');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:sanctum'], function(){ 
    Route::get("logout",[LoginController::class,'logout'])->name('user.logout');
    Route::post("addsubject",[SubjectController::class,'addSubject'])->name('user.addsubject');
    Route::get("usersubject",[SubjectController::class,'userSubject'])->name('user.subject');
});
Route::post("test",[LoginController::class,'test'])->name('user.test');
