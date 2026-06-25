<?php

namespace App\Services;

use App\Models\McpConnection;
use Illuminate\Support\Facades\Request;

class McpConnectionTracker
{
    public static function trackActivity($user, string $clientName = null): void
    {
        if (!$clientName) {
            $clientName = self::detectClient(Request::userAgent());
        }

        McpConnection::updateOrCreate(
            [
                'user_id' => $user->id,
                'client_name' => $clientName,
            ],
            [
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'last_activity_at' => now(),
            ]
        );
    }

    public static function detectClient(?string $userAgent): string
    {
        if (!$userAgent) return 'Unknown';
        
        $userAgent = strtolower($userAgent);
        
        if (str_contains($userAgent, 'chatgpt')) return 'ChatGPT';
        if (str_contains($userAgent, 'claude')) return 'Claude';
        if (str_contains($userAgent, 'cursor')) return 'Cursor';
        if (str_contains($userAgent, 'windsurf')) return 'Windsurf';
        if (str_contains($userAgent, 'vscode')) return 'VS Code';
        if (str_contains($userAgent, 'zed')) return 'Zed';
        if (str_contains($userAgent, 'continue')) return 'Continue';
        if (str_contains($userAgent, 'cline')) return 'Cline';
        if (str_contains($userAgent, 'openai')) return 'ChatGPT';
        
        return 'MCP Client';
    }

    public static function getConnectedClients($user)
    {
        return McpConnection::where('user_id', $user->id)
            ->where('last_activity_at', '>', now()->subDays(7))
            ->orderBy('last_activity_at', 'desc')
            ->get();
    }

}
