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
Route::middleware(['auth'])->group(function () {
    // Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
    // Dummy routes for the sidebar links
    Route::get('/profile', function () {
        return view('user.profile'); // Assuming you will create a profile view
    })->name('user.profile');

    Route::get('/contributions', function () {
        return view('user.contributions'); // A page for contributions history
    })->name('contributions.index');

    Route::get('/loans', function () {
        return view('user.loans'); // A page for loan details
    })->name('loans.index');

    Route::get('/transactions', function () {
        return view('user.transactions'); // A page for all transactions
    })->name('transactions.index');
});

Route::post('/user/login', [LoginController::class, 'user_login'])->name('user.login');
Route::get('/user/login', [LoginController::class, 'login_page'])->name('user.login.page');
Route::get('/user/dashboard', [LoginController::class, 'user_dashboard'])->name('user.dashboard');
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/register', [RegistrationController::class, 'create'])->name('show.register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register');
Route::get('/', function () {
    return view('index');
});
Route::get('/login', function () {
    return view('login');
});

