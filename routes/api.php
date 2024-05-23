<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;

Route::post('register', [LoginRegisterController::class, 'store']);
Route::post('login', [LoginRegisterController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard', [LoginRegisterController::class, 'dashboard']);
    Route::post('logout', [LoginRegisterController::class, 'logout']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});
