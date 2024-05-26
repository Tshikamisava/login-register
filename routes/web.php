<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginRegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [LoginRegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginRegisterController::class, 'register'])->name('store');
Route::get('/login', [LoginRegisterController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'authenticate'])->name('authenticate');
Route::get('/dashboard', [LoginRegisterController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
