<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperuserController;
use App\Http\Middleware\IsAdmin;

Route::get('/terms-as-images', [App\Http\Controllers\DocumentsController::class, 'showTermsAsImages'])->name('terms.images');
// This route will show the full page with the embedded PDF
Route::get('/terms', function () {
    return view('terms');
})->name('terms.page');
Route::get('/terms-and-conditions', [App\Http\Controllers\DocumentsController::class, 'showTerms'])->name('terms.show');
// Superuser login routes
Route::get('/superuser/login', [SuperuserController::class, 'showLoginForm'])->name('superuser.login');
Route::post('/superuser/login', [SuperuserController::class, 'login']);

// Superuser protected routes
Route::middleware(['auth', IsAdmin::class])->prefix('superuser')->group(function () {
    Route::get('/dashboard', [SuperuserController::class, 'dashboard'])->name('superuser.dashboard');
    Route::post('/approve/{user}', [SuperuserController::class, 'approveUser'])->name('superuser.approve');
    Route::post('/logout', [SuperuserController::class, 'logout'])->name('superuser.logout');
});
Route::post('/user/login', [LoginController::class, 'user_login'])->name('user.login');
Route::get('/user/login', [LoginController::class, 'login_page'])->name('user.login.page');
Route::get('/user/dashboard', [LoginController::class, 'user_dashboard'])->name('user.dashboard');
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
// Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
Route::get('/register', [RegistrationController::class, 'create'])->name('show.register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register');
Route::get('/', function () {
    return view('index');
});
Route::get('/login', function () {
    return view('login');
});
