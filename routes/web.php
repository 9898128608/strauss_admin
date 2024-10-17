<?php
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::Group(['middleware' => 'web', 'prefix' => 'account'], function () {
    Route::get('login', [LoginController::class, 'index'])->name('account.login');
    Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
});

Route::Group(['middleware' => 'auth'], function () {

    Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');

    Route::Group(['middleware' => ['isSuperAdmin'], 'prefix' => 'superadmin'], function () {
        Route::get('dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');
    });
    
    Route::Group(['middleware' => ['isAdmin'], 'prefix' => 'admin'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });
    
    Route::Group(['middleware' => ['isUser'], 'prefix' => 'account'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
    });

});

 