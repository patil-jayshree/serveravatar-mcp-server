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
        $authHeader = $request->header('Authorization');
        
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $bearerToken = trim(substr($authHeader, 7));
        
        try {
            $tokenId = null;
            $parts = explode('.', $bearerToken);
            
            if (count($parts) === 3) {
                $payload = json_decode($this->base64url_decode($parts[1]), true);
                if (!$payload || !isset($payload['jti'])) {
                    return response()->json(['error' => 'Invalid token payload'], 401);
                }
                $tokenId = $payload['jti'];
                
                if (isset($payload['exp']) && $payload['exp'] < time()) {
                    return response()->json(['error' => 'Token has expired'], 401);
                }
            } else {
                $tokenId = $bearerToken;
            }
            
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
            
            $user = $accessToken->user;
            if ($user) {
                auth()->guard('web')->setUser($user);
                
                if (!$user->hasApiKey()) {
                    return response()->json(['error' => 'ServerAvatar API key not configured. Please add it in your dashboard.'], 403);
                }
                
                // Track MCP connection and log activity for new connections only
                try {
                    $clientName = \App\Services\McpConnectionTracker::detectClient($request->userAgent());
                    $isNewConnection = !\App\Models\McpConnection::where('user_id', $user->id)
                        ->where('client_name', $clientName)
                        ->exists();

                    \App\Services\McpConnectionTracker::trackActivity($user, $clientName);

                    if ($isNewConnection) {
                        \App\Services\ActivityLogger::clientConnected($user, $clientName);
                    }
                } catch (\Exception $e) {
                    // Silently ignore tracking errors - don't affect MCP flow
                }
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized', 'message' => $e->getMessage()], 401);
        }

        return $next($request);
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
