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
        
        // Pass user to terminate - auth might not be available there
        $user = auth()->guard('web')->user();
        if ($user) {
            $request->attributes->set('_mcp_user_object', $user);
            
            // Log client_connected only for NEW connections
            $clientName = \App\Services\McpConnectionTracker::detectClient($request->userAgent());
            $mcpConn = \App\Models\McpConnection::where('user_id', $user->id)
                ->where('client_name', $clientName)
                ->first();
            
            if (!$mcpConn) {
                \Illuminate\Support\Facades\Log::info('MCP_NEW_CLIENT: Logging client_connected for user_id=' . $user->id . ' client=' . $clientName);
                \App\Services\ActivityLogger::clientConnected($user, $clientName);
            }
        } else {
            \Illuminate\Support\Facades\Log::warning('MCP_NO_USER_IN_HANDLE: TrackMcpAnalytics');
        }
        
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        try {
            // Use user from handle() - don't rely on auth() in terminate
            $user = $request->attributes->get('_mcp_user_object');
            if (!$user) {
                return;
            }

            $body = $request->all();

            if (!isset($body['method']) || $body['method'] !== 'tools/call') {
                return;
            }

            $statusCode = $response->getStatusCode();
            $httpSuccess = in_array($statusCode, [200, 201, 204]);
            
            $startTime = $request->attributes->get('_mcp_request_start', microtime(true));
            $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);

            $clientName = \App\Services\McpConnectionTracker::detectClient($request->userAgent());

            // Capture response data and check for MCP errors
            $responseData = null;
            $mcpError = false;
            $errorMessage = null;
            $responseContent = $response->getContent();
            if ($responseContent) {
                $decoded = json_decode($responseContent, true);
                // Check for MCP error format: {"error": {"code": ..., "message": ...}}
                if (isset($decoded['error']) && isset($decoded['error']['message'])) {
                    $mcpError = true;
                    $errorMessage = $decoded['error']['message'];
                }
                // Extract response data for success case
                if (isset($decoded['result']['content'][0]['text'])) {
                    $responseText = $decoded['result']['content'][0]['text'];
                    $responseData = json_decode($responseText, true);
                    // Check if the inner response contains an error (API error inside result)
                    if (isset($responseData['error'])) {
                        $mcpError = true;
                        // Extract string error message from array/object
                        $errorData = $responseData['error'];
                        if (is_array($errorData)) {
                            // Try common error message fields
                            $errorMessage = $errorData['message'] ?? $errorData['error'] ?? $errorData['Message'] ?? json_encode($errorData);
                        } else {
                            $errorMessage = $errorData;
                        }
                    }
                }
            }
            
            $success = $httpSuccess && !$mcpError;

            if (isset($body[0]) && is_array($body[0])) {
                foreach ($body as $rpcRequest) {
                    if (isset($rpcRequest['method']) && $rpcRequest['method'] === 'tools/call') {
                        $toolName = $rpcRequest['params']['name'] ?? 'unknown';
                        $arguments = $rpcRequest['params']['arguments'] ?? null;
                        \App\Services\McpConnectionTracker::recordRequest($user, $clientName, $success, $responseTimeMs);
                        \App\Services\McpConnectionTracker::recordToolCall($user, $clientName);                    
                        \App\Services\ActivityLogger::toolExecuted($user, $toolName, $clientName, $success, $arguments, $responseData, $errorMessage);
                    }
                }
            } else {
                $toolName = $body['params']['name'] ?? 'unknown';
                $arguments = $body['params']['arguments'] ?? null;
                \App\Services\McpConnectionTracker::recordRequest($user, $clientName, $success, $responseTimeMs);
                \App\Services\McpConnectionTracker::recordToolCall($user, $clientName);
                \App\Services\ActivityLogger::toolExecuted($user, $toolName, $clientName, $success, $arguments, $responseData, $errorMessage);
            }
        } catch (\Throwable $e) {
            // Silently ignore - analytics must never affect MCP flow
        }
    }
}
