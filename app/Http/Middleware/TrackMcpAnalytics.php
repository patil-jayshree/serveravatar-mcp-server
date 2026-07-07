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
            $user = auth()->user();
            if (!$user) {
                return;
            }

            $body = $request->all();

            // tools/call is the actual tool execution - only count this
            // initialize, tools/list, ping etc. are protocol overhead, not user tool calls
            if (!isset($body['method']) || $body['method'] !== 'tools/call') {
                return;
            }

            $statusCode = $response->getStatusCode();
            $success = in_array($statusCode, [200, 201, 204]);
            $clientName = \App\Services\McpConnectionTracker::detectClient($request->userAgent());

            // Handle batch requests: multiple tools/call in one HTTP request
            if (isset($body[0]) && is_array($body[0])) {
                // Batch of JSON-RPC requests
                foreach ($body as $rpcRequest) {
                    if (isset($rpcRequest['method']) && $rpcRequest['method'] === 'tools/call') {
                        \App\Services\McpConnectionTracker::recordRequest($user, $clientName, $success, 0);
                        \App\Services\McpConnectionTracker::recordToolCall($user, $clientName);
                    }
                }
            } else {
                // Single tool call
                \App\Services\McpConnectionTracker::recordRequest($user, $clientName, $success, 0);
                \App\Services\McpConnectionTracker::recordToolCall($user, $clientName);
            }
        } catch (\Throwable $e) {
            // Silently ignore - analytics must never affect MCP flow
        }
    }
}
