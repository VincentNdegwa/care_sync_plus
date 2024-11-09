<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TokenValidationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/check-valid-token', [TokenValidationController::class, "checkIfValid"]);
});

// Post("/api/register")
Route::post('register', [RegisteredUserController::class, 'store']);
// login user
Route::post('login', [AuthenticatedSessionController::class, 'store']);
