<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\Student\StudentController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::namespace('Api')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
    });


    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('index', [AuthController::class, 'index']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('/home',[ StudentController::class, 'index']);
        Route::post('/create',[ StudentController::class, 'create']);
        Route::patch('/edit/{id}',[ StudentController::class, 'edit']);
        Route::put('/update/{id}',[ StudentController::class, 'update']);
    });

 
    
   
});
