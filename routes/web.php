<?php

use App\Http\Controllers\Auth\{LoginController, RegisterController, ForgotPasswordController, ResetPasswordController};
use App\Http\Controllers\{DashboardController, ToolsController, ClientsController,ProfileController};
use Illuminate\Support\Facades\Route;

// Landing page - show welcome for guests, dashboard for authenticated
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'showRegisterForm')->name('register');
        Route::post('register', 'register');
    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forgot-password', 'showForgotPasswordForm')->name('password.request');
        Route::post('forgot-password', 'sendResetLink')->name('password.email');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('reset-password', 'reset')->name('password.update');
    });
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Dashboard / Main pages
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboard');
        Route::get('integrations', 'integrations')->name('integrations');
        Route::get('mcp-server', 'mcpServer')->name('mcp-server');
        Route::post('dashboard/api-key', 'saveApiKey')->name('dashboard.api-key');
    });

    Route::controller(ToolsController::class)->group(function () {
        Route::get('tools', 'index')->name('tools');
    });

    Route::controller(ClientsController::class)->group(function () {
        Route::get('clients', 'index')->name('clients');
    });

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Account Pages
    Route::prefix('account')
        ->controller(ProfileController::class)
        ->group(function () {
            Route::get('/', 'show')->name('account');
            Route::get('/password', 'password')->name('account.password');
            Route::get('/api', 'api')->name('account.api');
        });

    // Profile / Account API
    Route::prefix('api')
        ->name('api.')
        ->controller(ProfileController::class)
        ->group(function () {
            Route::get('/profile', 'getProfile')->name('profile');
            Route::patch('/profile', 'updateProfile')->name('profile.update');
            Route::patch('/profile/password', 'updatePassword')->name('profile.password');
            Route::delete('/account', 'deleteAccount')->name('account.delete');
        });
});

