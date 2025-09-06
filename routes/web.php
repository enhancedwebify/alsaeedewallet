<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperuserController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContributionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserDashboardController;


Route::get('/terms-as-images', [App\Http\Controllers\DocumentsController::class, 'showTermsAsImages'])->name('terms.images');
// This route will show the full page with the embedded PDF

Route::get('/terms', function () {
    return view('terms');
})->name('terms.page');

Route::get('/terms-and-conditions', [App\Http\Controllers\DocumentsController::class, 'showTerms'])->name('terms.show');

// Superuser login routes
// Route::get('/superuser/login', [SuperuserController::class, 'showLoginForm'])->name('superuser.login');
// Route::post('/superuser/login', [SuperuserController::class, 'login']);

// Superuser protected routes
Route::middleware(['auth', IsAdmin::class])->prefix('superuser')->group(function () {
    Route::get('/dashboard', [SuperuserController::class, 'dashboard'])->name('superuser.dashboard');
    Route::post('/approve/{user}', [SuperuserController::class, 'approveUser'])->name('superuser.approve');
    Route::post('/logout', [SuperuserController::class, 'logout'])->name('superuser.logout');
});

// USER ROUTES
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::post('/new_loan', [UserDashboardController::class, 'store'])->name('newLoan');
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    // Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
    // Dummy routes for the sidebar links
    Route::get('/profile', function () {
        return view('profile'); // Assuming you will create a profile view
    })->name('profile');

    Route::get('/loans', function () {
        return view('loans'); // A page for loan details
    })->name('loans.index');

    Route::get('/transactions', function () {
        return view('transactions'); // A page for all transactions
    })->name('transactions.index');

    // Route to store the new contribution
    Route::post('/contributions', [ContributionController::class, 'store'])->name('contributions.store');
    // ... inside the user route group ...
    Route::get('/contributions', [UserDashboardController::class, 'contributions'])->name('contributions');
    // ... inside the user route group ...
    Route::post('/contributions/tier-request', [ContributionController::class, 'storeTierRequest'])->name('newTierRequest');

    Route::get('/loans/request', [UserDashboardController::class, 'showLoanRequestForm'])->name('loans.request');

    // Route to handle loan request submission
    Route::post('/loans/store', [UserDashboardController::class, 'storeLoanRequest'])->name('loans.store');
});

// ADMIN | SUPERUSER ROUTES
Route::get('/login', [SuperuserController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [SuperuserController::class, 'login']);
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route to show the form for adding a contribution
    Route::get('/contributions/create', [ContributionController::class, 'create'])->name('contributions.create');
    // Pending Approvals Routes
    Route::get('/approvals/pending', [DashboardController::class, 'pendingApprovals'])->name('approvals.pending');
    Route::post('/approvals/process/{id}', [DashboardController::class, 'processApproval'])->name('approvals.process');
    Route::get('/approvals/{id}', [DashboardController::class, 'showApproval'])->name('approvals.show');
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
    // User Management Routes
    Route::resource('users', UserController::class);

    // Contribution Management Routes
    Route::resource('contributions', ContributionController::class);

    // Loan Management Routes
    Route::resource('loans', LoanController::class);

    // Reports Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Settings Route
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');

    // Show the form for uploading bank statements
    Route::get('/contributions/upload', [ContributionController::class, 'showUploadForms'])->name('contributions.uploads');

    // Process the uploaded bank statement
    Route::post('/contributions/import', [ContributionController::class, 'import'])->name('contributions.import');
});


Route::post('/user/login', [LoginController::class, 'user_login'])->name('user.login');
Route::get('/user/login', [LoginController::class, 'login_page'])->name('user.login.page');
// Route::get('/login', [LoginController::class, 'create'])->name('login');
// Route::post('/login', [LoginController::class, 'store']);
Route::get('/register', [RegistrationController::class, 'create'])->name('show.register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register');
Route::get('/', function () {
    return view('index');
});
// Route::get('/login', function () {
//     return view('login');
// });

