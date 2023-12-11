<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

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
    //auther endpoints
    Route::post('authors/create', [AuthorController::class, 'store']);
    Route::get('authors/list', [AuthorController::class, 'index']);
    Route::put('authors/update/{id}', [AuthorController::class, 'update']);
    Route::get('authors/read/{id}', [AuthorController::class, 'show']);
    Route::delete('authors/delete/{id}', [AuthorController::class, 'destroy']);
    //books endpoint
    Route::post('books/create', [BookController::class, 'store']);
    Route::get('books/list', [BookController::class, 'index']);
    Route::put('books/update/{id}', [BookController::class, 'update']);
    Route::delete('books/delete/{id}', [BookController::class, 'destroy']);
    Route::get('books/read/{id}', [BookController::class, 'show']);
    // Route::apiResource('books',BookController::class);
});

