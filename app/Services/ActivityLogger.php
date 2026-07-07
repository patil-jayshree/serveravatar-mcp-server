<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(
        $user,
        string $type,
        string $description,
        ?array $metadata = null,
        ?string $clientName = null
    ): Activity {
        if (!$clientName) {
            $clientName = McpConnectionTracker::detectClient(Request::userAgent());
        }

        return Activity::create([
            'user_id' => $user->id,
            'type' => $type,
            'description' => $description,
            'metadata' => $metadata,
            'client_name' => $clientName,
            'ip_address' => Request::ip(),
        ]);
    }

    public static function clientConnected($user, ?string $clientName = null): Activity
    {
        return self::log(
            $user,
            Activity::TYPE_CLIENT_CONNECTED,
            "{$clientName} connected",
            null,
            $clientName
        );
    }

    public static function toolExecuted($user, string $toolName, ?string $clientName = null, bool $success = true): Activity
    {
        return self::log(
            $user,
            Activity::TYPE_TOOL_EXECUTED,
            "Tool executed: {$toolName}",
            ['tool' => $toolName, 'success' => $success],
            $clientName
        );
    }

    public static function apiKeySaved($user): Activity
    {
        return self::log($user, Activity::TYPE_API_KEY_SAVED, 'API key saved');
    }

    public static function apiKeyDeleted($user): Activity
    {
        return self::log($user, Activity::TYPE_API_KEY_DELETED, 'API key deleted');
    }

    public static function settingsUpdated($user, string $setting): Activity
    {
        return self::log(
            $user,
            Activity::TYPE_SETTINGS_UPDATED,
            "Settings updated: {$setting}",
            ['setting' => $setting]
        );
    }

    public static function getRecent($user, int $limit = 10)
    {
        return Activity::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
