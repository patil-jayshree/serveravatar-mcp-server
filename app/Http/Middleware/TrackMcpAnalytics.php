<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackMcpAnalytics
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->attributes->set('_mcp_request_start', microtime(true));
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return;
            }

            $body = $request->all();

            if (!isset($body['method']) || $body['method'] !== 'tools/call') {
                return;
            }

            $statusCode = $response->getStatusCode();
            $success = in_array($statusCode, [200, 201, 204]);

            $startTime = $request->attributes->get('_mcp_request_start', microtime(true));
            $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);

            $clientName = \App\Services\McpConnectionTracker::detectClient($request->userAgent());

            if (isset($body[0]) && is_array($body[0])) {
                foreach ($body as $rpcRequest) {
                    if (isset($rpcRequest['method']) && $rpcRequest['method'] === 'tools/call') {
                        $toolName = $rpcRequest['params']['name'] ?? 'unknown';
                        \App\Services\McpConnectionTracker::recordRequest($user, $clientName, $success, $responseTimeMs);
                        \App\Services\McpConnectionTracker::recordToolCall($user, $clientName);
                        \App\Services\ActivityLogger::toolExecuted($user, $toolName, $clientName, $success);
                    }
                }
            } else {
                $toolName = $body['params']['name'] ?? 'unknown';
                \App\Services\McpConnectionTracker::recordRequest($user, $clientName, $success, $responseTimeMs);
                \App\Services\McpConnectionTracker::recordToolCall($user, $clientName);
                \App\Services\ActivityLogger::toolExecuted($user, $toolName, $clientName, $success);
            }
        } catch (\Throwable $e) {
            // Silently ignore - analytics must never affect MCP flow
        }
    }
}
