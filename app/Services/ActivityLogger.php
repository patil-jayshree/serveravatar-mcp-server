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

    public static function formatToolName(string $toolName): string
    {
        $readable = trim(preg_replace('/[_-]/', ' ', $toolName));
        $readable = preg_replace('/([a-z])([A-Z])/', '$1 $2', $readable);
        $readable = ucfirst(strtolower($readable));
        $readable = str_replace('tool', '', $readable);
        $readable = trim($readable);
        return $readable ?: $toolName;
    }

    public static function clientConnected($user, ?string $clientName = null): Activity
    {
        $client = $clientName ?? McpConnectionTracker::detectClient(Request::userAgent());
        return self::log(
            $user,
            Activity::TYPE_CLIENT_CONNECTED,
            "Connected successfully via {$client}",
            null,
            $client
        );
    }

    public static function toolExecuted($user, string $toolName, ?string $clientName = null, bool $success = true, ?array $arguments = null): Activity
    {
        $client = $clientName ?? McpConnectionTracker::detectClient(Request::userAgent());
        $status = $success ? 'executed successfully' : 'failed';
        $readableTool = self::formatToolName($toolName);
        $metadata = ['tool' => $toolName, 'success' => $success];
        if ($arguments !== null) {
            $metadata['arguments'] = $arguments;
        }
        return self::log(
            $user,
            Activity::TYPE_TOOL_EXECUTED,
            "{$readableTool} {$status} via {$client}",
            $metadata,
            $client
        );
    }

    public static function apiKeySaved($user): Activity
    {
        return self::log($user, Activity::TYPE_API_KEY_SAVED, 'ServerAvatar API key saved successfully');
    }

    public static function apiKeyUpdated($user): Activity
    {
        return self::log($user, Activity::TYPE_API_KEY_UPDATED, 'ServerAvatar API key updated successfully');
    }

    public static function apiKeyDeleted($user): Activity
    {
        return self::log($user, Activity::TYPE_API_KEY_DELETED, 'ServerAvatar API key removed');
    }

    public static function profileUpdated($user): Activity
    {
        return self::log($user, Activity::TYPE_PROFILE_UPDATED, 'Profile updated successfully');
    }

    public static function passwordChanged($user): Activity
    {
        return self::log($user, Activity::TYPE_PASSWORD_CHANGED, 'Password changed successfully');
    }

    public static function accountDeleted($user): Activity
    {
        return self::log($user, Activity::TYPE_SETTINGS_UPDATED, 'Account deleted');
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
