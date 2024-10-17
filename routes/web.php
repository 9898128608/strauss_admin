<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web', 'prefix' => 'account'], function () {
    Route::get('login', [LoginController::class, 'index'])->name('account.login');
    Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');

    Route::group(['prefix' => 'superadmin', 'middleware' => 'isSuperAdmin'], function () {
        Route::get('dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

    Route::group(['prefix' => 'account', 'middleware' => 'isUser'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
    });
});
