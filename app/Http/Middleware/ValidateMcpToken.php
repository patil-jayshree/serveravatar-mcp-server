<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;
use Symfony\Component\HttpFoundation\Response;

class ValidateMcpToken
{
    public function __construct(
        private TokenRepository $tokenRepository
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');
        
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $bearerToken = trim(substr($authHeader, 7));
        
        try {
            $tokenId = $this->extractTokenId($bearerToken);
            
            if (!$tokenId) {
                return response()->json(['error' => 'Invalid token format'], 401);
            }
            
            $accessToken = Token::find($tokenId);
            
            if (!$accessToken && strlen($tokenId) >= 32) {
                $accessToken = $this->tokenRepository->find($tokenId);
            }
            
            if (!$accessToken) {
                return response()->json(['error' => 'Token not found'], 401);
            }
            
            // Update last used timestamp
            $accessToken->last_used_at = now();
            $accessToken->save();
            
            if ($accessToken->revoked) {
                return response()->json(['error' => 'Token has been revoked'], 401);
            }
            
            if ($accessToken->expires_at && $accessToken->expires_at->isPast()) {
                return response()->json(['error' => 'Token has expired'], 401);
            }
            
            $scopes = $accessToken->scopes ?: [];
            if (!empty($scopes) && !in_array('mcp:use', $scopes) && !in_array('*', $scopes)) {
                return response()->json(['error' => 'Token does not have MCP access scope'], 403);
            }
            
            $user = $accessToken->user;
            if (!$user) {
                return response()->json(['error' => 'User not found for token'], 401);
            }
            
            if (!$user->hasApiKey()) {
                return response()->json(['error' => 'ServerAvatar API key not configured. Please add it in your dashboard.'], 403);
            }
            
            $request->setUserResolver(fn () => $user);
            auth()->guard('web')->setUser($user);
            
            // Track MCP connection
            try {
                $clientName = \App\Services\McpConnectionTracker::detectClient($request->userAgent());
                $isNewConnection = !\App\Models\McpConnection::where('user_id', $user->id)
                    ->where('client_name', $clientName)
                    ->exists();
                
                if ($isNewConnection) {
                    \App\Services\ActivityLogger::clientConnected($user, $clientName);
                }
                
                \App\Services\McpConnectionTracker::trackActivity($user, $clientName);
            } catch (\Exception $e) {
                // Silently ignore
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized', 'message' => $e->getMessage()], 401);
        }

        return $next($request);
    }
    
    private function extractTokenId(string $bearerToken): ?string
    {
        $parts = explode('.', $bearerToken);
        
        if (count($parts) === 3) {
            $payload = json_decode($this->base64url_decode($parts[1]), true);
            if (!$payload || !isset($payload['jti'])) {
                return null;
            }
            
            if (isset($payload['exp']) && $payload['exp'] < time()) {
                return null;
            }
            
            return $payload['jti'];
        }
        
        if (str_contains($bearerToken, '|')) {
            $idPart = explode('|', $bearerToken)[0];
            return $idPart ?: null;
        }
        
        return $bearerToken ?: null;
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
