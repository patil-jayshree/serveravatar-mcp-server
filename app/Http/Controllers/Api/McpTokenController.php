<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\Passport;

class McpTokenController extends Controller
{
    public function __construct(
        private TokenRepository $tokenRepository
    ) {}

    /**
     * List all MCP tokens for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $tokens = $request->user()->tokens()
            ->where('name', 'like', 'mcp:%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($token) {
                return [
                    'id' => $token->id,
                    'name' => $token->name,
                    'created_at' => $token->created_at ? (is_string($token->created_at) ? \Carbon\Carbon::parse($token->created_at)->toIso8601String() : $token->created_at->toIso8601String()) : null,
                    'expires_at' => $token->expires_at ? (is_string($token->expires_at) ? \Carbon\Carbon::parse($token->expires_at)->toIso8601String() : $token->expires_at->toIso8601String()) : null,
                    'last_used_at' => $token->last_used_at ? (is_string($token->last_used_at) ? \Carbon\Carbon::parse($token->last_used_at)->toIso8601String() : $token->last_used_at->toIso8601String()) : null,
                ];
            });

        return response()->json(['tokens' => $tokens]);
    }

    /**
     * Create a new MCP token for IDE clients.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = $request->user();

        // Check if user has ServerAvatar API key configured
        if (!$user->hasApiKey()) {
            return response()->json([
                'error' => 'ServerAvatar API key not configured. Please add it in your dashboard.',
            ], 403);
        }

        // Create personal access token with MCP scope
        $token = $user->createToken(
            'mcp:' . $request->input('name'),
            ['mcp:use']
        );

        // Get the numeric token ID (this is what ValidateMcpToken middleware looks up)
        $tokenId = $token->token->getKey();

        // Log activity
        ActivityLogger::tokenCreated($user, $request->input('name'));

        return response()->json([
            'message' => 'Token created successfully',
            'token_id' => $tokenId,
            'token' => $token->plainTextToken, // Full format: "id|token" (for reference)
            'expires_at' => $token->token->expires_at?->toIso8601String(),
        ], 201);
    }

    /**
     * Revoke (delete) an MCP token.
     */
    public function destroy(Request $request, string $tokenId): JsonResponse
    {
        $user = $request->user();

        $token = $user->tokens()->find($tokenId);

        if (!$token) {
            return response()->json(['error' => 'Token not found'], 404);
        }

        // Delete the token (this table uses expires_at, not revoked column)
        $token->delete();

        // Log activity
        ActivityLogger::tokenRevoked($user, $token->name);

        return response()->json(['message' => 'Token revoked successfully']);
    }
}
