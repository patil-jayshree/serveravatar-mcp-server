<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackMcpAnalytics
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Called after the response is sent — won't affect MCP response flow.
     */
    public function terminate(Request $request, Response $response): void
    {
        try {
            $user = auth()->guard('web')->user();
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
        } catch (\Exception $e) {
            // Silently ignore - analytics should never affect MCP flow
        }
    }
}
