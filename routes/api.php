<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;

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

//ADMIN
Route::prefix('admin')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'scope.admin'])->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::put('user/update', [ AuthController::class, 'update']);
        Route::put('user/password', [ AuthController::class, 'updatePassword']);

        Route::get('enrollment', [EnrollmentController::class, 'index']);
        Route::post('enrollment', [EnrollmentController::class, 'store']);
        Route::get('enrollment/show/{enrollment}', [EnrollmentController::class, 'show']);
        Route::put('enrollment/update/{enrollment}', [EnrollmentController::class, 'update'])->name('update');
        Route::delete('enrollment/destroy/{enrollment}', [EnrollmentController::class, 'destroy']);
        Route::get('enrollment/list', [EnrollmentController::class, 'getEnrollmentPerPage']);
        Route::get('enrollment/events', [EnrollmentController::class, 'getEvents']);
        Route::get('enrollment/filter', [EnrollmentController::class, 'filter']);
        Route::get('enrollment/clientenrollments', [EnrollmentController::class, 'getEventsByEmail']);
    });
});

