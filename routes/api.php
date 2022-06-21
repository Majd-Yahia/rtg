<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\Psr7\Request;
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


Route::name('auth.')->prefix('auth')->group(function () {

    // public routes.
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    
    // protected routes.
    Route::group(['middleware' => ['auth:sanctum']] , function () {
        // Route::post('email/verification', [AuthController::class, 'verify_email'])->name('verify_email');
        Route::get('verify', [AuthController::class, 'verify'])->name('verify');
        Route::get('/logout', [AuthController::class, 'logout']);
    });
});


Route::name('profile.')->prefix('profile')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']] , function () {
        Route::post('/', [ProfileController::class, 'profile']);
        Route::get('/', [ProfileController::class, 'get_profile']);
    });
});