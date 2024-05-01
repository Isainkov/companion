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
    Route::resource('users', UserController::class)->except('show', 'index', 'store', 'destroy');
    Route::resource('pets', PetController::class);
    Route::put('/reviews/{user}', [ReviewController::class, 'storeReviewByUserId']);
});

Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/pet/listByIds', [PetController::class, 'getListByIds']);
Route::get('/reviews/{user}', [ReviewController::class, 'getReviewsByUserId']);
