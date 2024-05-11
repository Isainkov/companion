<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PetController;

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

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/authenticate', [AuthenticationController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout/user/{user}', [AuthenticationController::class, 'logout']);
});

Route::get('/pets/listByIds', [PetController::class, 'getListByIds']);
Route::get('/reviews/{user}', [ReviewController::class, 'getReviewsByUserId']);

Route::resource('reviews', ReviewController::class)->only(['store']);
Route::resource('users', UserController::class)->only(['show', 'update']);
Route::resource('pets', PetController::class);
