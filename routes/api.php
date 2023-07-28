<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('signup',[AuthController::class,'signup']);
Route::post('login', [AuthController::class,'login']);
Route::get('/companyUsers', [App\Http\Controllers\CompanyController::class,'index']);
Route::post('/save', [App\Http\Controllers\CompanyController::class,'store']);
Route::put('/update/{id}', [App\Http\Controllers\CompanyController::class,'update']);
Route::delete('/delete/{id}', [App\Http\Controllers\CompanyController::class,'destroy']);

Route::group([

    'middleware' => 'api'
], function ($router) {


    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');

});
