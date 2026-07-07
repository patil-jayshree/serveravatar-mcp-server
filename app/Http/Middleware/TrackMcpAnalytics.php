<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackMcpAnalytics
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        try {
            // Use auth() helper which respects the default guard set by ValidateMcpToken
            $user = auth()->user();
            if (!$user) {
                return;
            }

            $statusCode = $response->getStatusCode();
            $success = in_array($statusCode, [200, 201, 204]);

            \App\Services\McpConnectionTracker::recordRequest(
                $user,
                \App\Services\McpConnectionTracker::detectClient($request->userAgent()),
                $success,
                0
            );
        } catch (\Throwable $e) {
            // Silently ignore - analytics must never affect MCP flow
        }
    }
}
