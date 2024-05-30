<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Contact\ContactFormController;


// Home Page Route
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/register', [LoginRegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginRegisterController::class, 'register'])->name('store');
Route::get('/login', [LoginRegisterController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'authenticate'])->name('authenticate');
Route::get('/dashboard', [LoginRegisterController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');

// Contact Form Routes
Route::get('/contact-form', [ContactFormController::class,'showContactForm'])->name('contact-form');
Route::post('/contact-form', [ContactFormController::class, 'submit'])->name('contact-form.submit');
Route::get('/test-page',[ContactFormController::class, 'showTestPage'])->name('test-page');