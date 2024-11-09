<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TokenValidationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/checkTokenIsValid', [TokenValidationController::class, "checkIfValid"]);
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::prefix("/profile")->group(function () {
        Route::get("/user", [ProfileController::class, 'getUserProfile']);
        Route::patch("update", [ProfileController::class, 'update']);
    });
});

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('forgotPassword', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');
Route::post('resetPassword', [NewPasswordController::class, 'store'])
    ->name('password.store');
