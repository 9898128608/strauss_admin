<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Route::Group(['prefix' => 'account'], function () {

    Route::Group(['middleware' => 'guest'], function () {

        Route::get('account/login', [LoginController::class, 'index'])->name('account.login');
        Route::post('account/authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
    });

    Route::Group(['middleware' => 'auth'], function () {

        Route::get('account/dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
        Route::get('account/logout', [LoginController::class, 'logout'])->name('account.logout');

        Route::get('admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

        
// });
