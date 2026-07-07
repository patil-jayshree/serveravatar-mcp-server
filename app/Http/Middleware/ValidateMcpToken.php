<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Token;
use Symfony\Component\HttpFoundation\Response;

class ValidateMcpToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $authHeader = $request->header('Authorization');
        
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $bearerToken = trim(substr($authHeader, 7));
        
        try {
            $tokenId = null;
            $parts = explode('.', $bearerToken);
            
            if (count($parts) === 3) {
                // It's a JWT — decode payload to get jti (token ID)
                $payload = json_decode($this->base64url_decode($parts[1]), true);
                if (!$payload || !isset($payload['jti'])) {
                    return response()->json(['error' => 'Invalid token payload'], 401);
                }
                $tokenId = $payload['jti'];
                
                // Check JWT expiry
                if (isset($payload['exp']) && $payload['exp'] < time()) {
                    return response()->json(['error' => 'Token has expired'], 401);
                }
            } else {
                // Raw token ID (hex string used as bearer token)
                $tokenId = $bearerToken;
            }
            
            // Look up token by ID
            $accessToken = Token::find($tokenId);
            
            if (!$accessToken) {
                return response()->json(['error' => 'Token not found', 'hint' => count($parts) === 3 ? 'jwt' : 'raw'], 401);
            }
            
            if ($accessToken->revoked) {
                return response()->json(['error' => 'Token has been revoked'], 401);
            }
            
            if ($accessToken->expires_at && $accessToken->expires_at->isPast()) {
                return response()->json(['error' => 'Token has expired'], 401);
            }
            
            // Set authenticated user
            $user = $accessToken->user;
            if ($user) {
                auth()->guard('web')->setUser($user);

                // Check if user has API key configured
                if (!$user->hasApiKey()) {
                    return response()->json(['error' => 'ServerAvatar API key not configured. Please add it in your dashboard.'], 403);
                }

                // Track MCP connection activity
                try {
                    \App\Services\McpConnectionTracker::trackActivity($user);
                } catch (\Exception $e) {
                    // Silently ignore tracking errors
                }
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized', 'message' => $e->getMessage()], 401);
        }

        $response = $next($request);

        // Record analytics after request completes
        $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
        $success = in_array($response->getStatusCode(), [200, 201]);

        if ($user ?? null) {
            try {
                $clientName = \App\Services\McpConnectionTracker::detectClient(Request::userAgent());
                \App\Services\McpConnectionTracker::recordRequest($user, $clientName, $success, $responseTimeMs);
            } catch (\Exception $e) {
                // Silently ignore
            }
        }

        return $response;
    }
    
    private function base64url_decode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
