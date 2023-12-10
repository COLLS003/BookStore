<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

//public routes
Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login'])->name('login');
Route::get('/forbiden', [AuthController::class, 'forbiden'])->name('forbiden');

// Protected routes ..
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Protected routes go here

    //users endpoint
    Route::post('/users/logout', [AuthController::class, 'logout']);
});

