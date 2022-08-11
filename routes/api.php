<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RequestpermitController;

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


//Unprotected route
Route::post('v1/login', [LoginController::class, 'login']);
Route::post('v1/register', [RegisterController::class, 'register']);


//Protected routes
Route::middleware('auth:api')->prefix('v1')->group(function() {
    Route::get('/request', function(Request $request){
        return $request->user();
    });

    //Route to show all users
    Route::get('/users', [UserController::class, 'index']);

    //Route to create a new user which will store in usermod table for permission 
    Route::post('/users/create', [UserController::class, 'store']);


});
