<?php

namespace App\Services;

use App\Models\McpConnection;
use Illuminate\Support\Facades\Request;
use App\Providers\AppServiceProvider;

class McpConnectionTracker
{
    public static function trackActivity($user, string $clientName = null): void
    {
        if (!$clientName) {
            $clientName = self::detectClient(Request::userAgent());
        }

        // Store the authenticated user for this request (used by SessionInitialized event)
        self::$currentUser = $user;

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
        if (str_contains($userAgent, 'copilot')) return 'VS Code';
        if (str_contains($userAgent, 'github')) return 'VS Code';
        if (str_contains($userAgent, 'microsoft')) return 'VS Code';
        if (str_contains($userAgent, 'visual studio')) return 'VS Code';

        return 'MCP Client';
    }

    /**
     * Get the current authenticated user (set during trackActivity)
     */
    public static function getCurrentUser()
    {
        return self::$currentUser;
    }

    private static $currentUser = null;

    public static function getConnectedClients($user)
    {
        return McpConnection::where('user_id', $user->id)
            ->where('last_activity_at', '>', now()->subMinutes(15))
            ->orderBy('last_activity_at', 'desc')
            ->get();
    }

    public static function recordRequest($user, string $clientName = null, bool $success = true, int $responseTimeMs = 0): void
    {
        if (!$clientName) {
            $clientName = self::detectClient(Request::userAgent());
        }

        $connection = McpConnection::where('user_id', $user->id)
            ->where('client_name', $clientName)
            ->first();

        if (!$connection) {
            $connection = McpConnection::create([
                'user_id' => $user->id,
                'client_name' => $clientName,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'last_activity_at' => now(),
            ]);
        }

        $connection->increment('request_count');

        if ($success) {
            $connection->increment('success_count');
        } else {
            $connection->increment('error_count');
        }

        if ($responseTimeMs > 0) {
            $connection->increment('total_response_time_ms', $responseTimeMs);
        }

        if (!$connection->first_request_at) {
            $connection->first_request_at = now();
        }
        $connection->last_request_at = now();
        $connection->save();
    }

    public static function recordToolCall($user, string $clientName = null, ?string $toolName = null): void
    {
        if (!$clientName) {
            $clientName = self::detectClient(Request::userAgent());
        }

        $connection = McpConnection::where('user_id', $user->id)
            ->where('client_name', $clientName)
            ->first();

        if (!$connection) {
            $connection = McpConnection::create([
                'user_id' => $user->id,
                'client_name' => $clientName,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'last_activity_at' => now(),
            ]);
        }

        $connection->increment('tool_call_count');
    }

    public static function getAnalytics($user, string $period = 'all')
    {
        $query = McpConnection::where('user_id', $user->id);

        if ($period === 'today') {
            $query->whereDate('last_request_at', today());
        } elseif ($period === '7days') {
            $query->where('last_request_at', '>=', now()->subDays(7));
        }

        $connections = $query->get();

        $totalRequests = $connections->sum('request_count');
        $totalToolCalls = $connections->sum('tool_call_count');
        $successCount = $connections->sum('success_count');
        $errorCount = $connections->sum('error_count');
        $totalResponseTime = $connections->sum('total_response_time_ms');

        $successRate = ($totalRequests > 0)
            ? round(($successCount / $totalRequests) * 100, 1)
            : 100.0;

        $avgResponseTime = ($totalRequests > 0)
            ? round($totalResponseTime / $totalRequests)
            : 0;

        return [
            'total_requests' => $totalRequests,
            'tools_executed' => $totalToolCalls,
            'active_clients' => $connections->where('last_activity_at', '>', now()->subMinutes(15))->count(),
            'success_rate' => $successRate,
            'avg_response_time_ms' => $avgResponseTime,
            'total_errors' => $errorCount,
            'period' => $period,
        ];
    }

    public static function getSparklineData($user, string $metric = 'requests', int $days = 7): array
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $count = 0;

            $connections = McpConnection::where('user_id', $user->id)
                ->whereDate('last_request_at', $date)
                ->get();

            switch ($metric) {
                case 'requests':
                    $count = $connections->sum('request_count');
                    break;
                case 'tools':
                    $count = $connections->sum('tool_call_count');
                    break;
                case 'clients':
                    $count = $connections->where('last_activity_at', '>', now()->subMinutes(15))->count();
                    break;
                case 'errors':
                    $count = $connections->sum('error_count');
                    break;
            }

            $data[] = $count;
        }

        return $data;
    }
}
