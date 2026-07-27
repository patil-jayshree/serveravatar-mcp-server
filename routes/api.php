<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangeEmailController;

// API routes - add your routes here
// MCP Server is now handled by official Laravel MCP package at /mcp/serveravatar

Route::middleware(['auth', 'mcp_rate_limit:api'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('api.logout');

    // Email change
    Route::post('/email/change', [ChangeEmailController::class, 'requestChange'])->name('email.change.request');
    Route::delete('/email/change', [ChangeEmailController::class, 'cancelChange'])->name('email.change.cancel');
});
