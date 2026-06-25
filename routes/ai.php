<?php

use App\Mcp\Servers\ServerAvatarServer;
use Illuminate\Support\Facades\Route;
use Laravel\Mcp\Facades\Mcp;
use Laravel\Mcp\Server\Http\Controllers\OAuthRegisterController;
use Laravel\Passport\Passport;

// Register the ServerAvatar MCP web server with OAuth token validation
Mcp::web('/mcp/serveravatar', ServerAvatarServer::class)->middleware('validate_mcp_token');

// Register OAuth routes for MCP authentication
Mcp::oAuthRoutesFor('serveravatar', [
    Passport::class,
    'callback',
]);

// Register OAuth well-known endpoints for MCP clients (ChatGPT, etc.)
Route::get('/.well-known/oauth-protected-resource', fn () => response()->json([
    'resource' => config('app.url'),
    'authorization_servers' => [config('app.url')],
    'scopes_supported' => ['mcp:use'],
]))->name('mcp.oauth.protected-resource');

Route::get('/.well-known/oauth-authorization-server', fn () => response()->json([
    'issuer' => config('app.url'),
    'authorization_endpoint' => route('passport.authorizations.authorize'),
    'token_endpoint' => route('passport.token'),
    'registration_endpoint' => config('app.url') . '/oauth/register',
    'response_types_supported' => ['code'],
    'code_challenge_methods_supported' => ['S256'],
    'scopes_supported' => ['mcp:use'],
    'grant_types_supported' => ['authorization_code', 'refresh_token'],
]))->name('mcp.oauth.authorization-server');

// Register the OAuth dynamic client registration endpoint (required by MCP spec)
Route::post('/oauth/register', OAuthRegisterController::class)->name('mcp.oauth.register');
