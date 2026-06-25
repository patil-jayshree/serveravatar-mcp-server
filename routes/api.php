<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// API routes - add your routes here
// MCP Server is now handled by official Laravel MCP package at /mcp/serveravatar

Route::post('/logout', [LoginController::class, 'logout'])->name('api.logout');
