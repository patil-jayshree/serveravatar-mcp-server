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

        // Add user_agent to metadata if not already set
        if (!isset($metadata['user_agent'])) {
            $metadata['user_agent'] = Request::userAgent();
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
        $readable = preg_replace('/\b[Tt]ool\b/', '', $readable);
        $readable = preg_replace('/\s+/', ' ', $readable);
        $readable = trim($readable);
        
        // Map ambiguous terms to more specific ones based on context
        $replacements = [
            '/\bUser\b/i' => 'Application User',
            '/\bUsers\b/i' => 'Application Users',
            '/\bServer\b/' => 'Server',
            '/\bApplication\b/' => 'Application',
            '/\bDatabase\b/' => 'Database',
            '/\bFirewall\b/' => 'Firewall',
            '/\bSsl\b/i' => 'SSL',
            '/\bBackup\b/' => 'Backup',
            '/\bCronjob\b/' => 'Cronjob',
            '/\bSupervisor\b/' => 'Supervisor',
            '/\bOrganization\b/' => 'Organization',
        ];
        
        foreach ($replacements as $pattern => $replacement) {
            $readable = preg_replace($pattern, $replacement, $readable);
        }
        
        return $readable ?: $toolName;
    }
    
    public static function buildToolDescription(string $toolName, bool $success, ?string $errorMessage = null): string
    {
        // Split tool name into parts
        $parts = preg_split('/[_-]/', strtolower($toolName));
        
        // Remove 'tool' suffix if present
        $parts = array_filter($parts, fn($p) => $p !== 'tool');
        $parts = array_values($parts);
        
        if (empty($parts)) {
            return $success ? 'Operation completed successfully.' : 'Operation failed.';
        }
        
        $action = $parts[0] ?? '';
        $resourceParts = array_slice($parts, 1);
        
        // Map actions to past tense and failure forms
        $actionMap = [
            'create' => ['past' => 'created', 'fail' => 'create'],
            'list' => ['past' => 'retrieved', 'fail' => 'retrieve'],
            'get' => ['past' => 'retrieved', 'fail' => 'retrieve'],
            'delete' => ['past' => 'deleted', 'fail' => 'delete'],
            'update' => ['past' => 'updated', 'fail' => 'update'],
            'toggle' => ['past' => 'toggled', 'fail' => 'toggle'],
            'install' => ['past' => 'installed', 'fail' => 'install'],
            'uninstall' => ['past' => 'uninstalled', 'fail' => 'uninstall'],
            'set' => ['past' => 'set', 'fail' => 'set'],
            'remove' => ['past' => 'removed', 'fail' => 'remove'],
            'change' => ['past' => 'changed', 'fail' => 'change'],
            'enable' => ['past' => 'enabled', 'fail' => 'enable'],
            'disable' => ['past' => 'disabled', 'fail' => 'disable'],
            'force' => ['past' => 'forced', 'fail' => 'force'],
            'stop' => ['past' => 'stopped', 'fail' => 'stop'],
            'start' => ['past' => 'started', 'fail' => 'start'],
            'restart' => ['past' => 'restarted', 'fail' => 'restart'],
            'manage' => ['past' => 'managed', 'fail' => 'manage'],
            'save' => ['past' => 'saved', 'fail' => 'save'],
        ];
        
        // Check for special compound resources
        $resource = self::formatResourceName($resourceParts);
        
        // Determine action word
        if (isset($actionMap[$action])) {
            $wordInfo = $actionMap[$action];
            $actionPast = $wordInfo['past'];
            $actionFail = $wordInfo['fail'];
        } else {
            $actionPast = $action;
            $actionFail = $action;
        }
        
        // Build description
        if ($success) {
            $description = ucfirst($resource) . ' ' . $actionPast . ' successfully.';
        } else {
            // For failed, use lowercase resource (e.g., "Failed to create application")
            $resourceLower = strtolower($resource);
            $description = 'Failed to ' . $actionFail . ' ' . $resourceLower . '.';
        }
        
        return $description;
    }
    
    private static function formatResourceName(array $parts): string
    {
        if (empty($parts)) {
            return 'resource';
        }
        
        $resource = implode(' ', $parts);
        
        // Format specific resources
        $resourceMappings = [
            'application' => 'Application',
            'applications' => 'Applications',
            'user' => 'Application user',
            'users' => 'Application users',
            'server' => 'Server',
            'servers' => 'Servers',
            'database' => 'Database',
            'databases' => 'Databases',
            'domain' => 'Domain',
            'domains' => 'Domains',
            'firewall rule' => 'Firewall rule',
            'firewall rules' => 'Firewall rules',
            'ssl certificate' => 'SSL certificate',
            'cronjob' => 'Cronjob',
            'cronjobs' => 'Cronjobs',
            'backup' => 'Backup',
            'backups' => 'Backups',
            'supervisor' => 'Supervisor',
            'organization' => 'Organization',
            'organizations' => 'Organizations',
            'database user' => 'Database user',
            'database users' => 'Database users',
            'primary domain' => 'Application primary domain',
            'php settings' => 'PHP settings',
            'basic auth' => 'Basic auth',
        ];
        
        // Check exact match first
        if (isset($resourceMappings[$resource])) {
            return $resourceMappings[$resource];
        }
        
        // Check for WordPress/Laravel/etc application
        $frameworks = [
            'wordpress' => 'WordPress',
            'laravel' => 'Laravel',
            'nodejs' => 'Node.js',
            'node' => 'Node.js',
            'php' => 'PHP',
            'python' => 'Python',
            'static' => 'Static',
        ];
        foreach ($frameworks as $framework => $properName) {
            if (strpos($resource, $framework) !== false) {
                // Replace framework with proper casing
                $formatted = preg_replace('/' . $framework . '\s*/i', '', $resource);
                $formatted = trim($formatted);
                if (!empty($formatted) && $formatted !== 'application' && $formatted !== 'applications') {
                    return $properName . ' ' . self::formatResourceName([$formatted]);
                } elseif ($formatted === 'application' || $formatted === 'applications' || empty($formatted)) {
                    return $properName . ' application';
                }
                return $properName . ' ' . self::formatResourceName([$formatted]);
            }
        }
        
        // Map individual words
        $wordMappings = [
            'application' => 'Application',
            'applications' => 'Applications',
            'user' => 'Application user',
            'users' => 'Application users',
            'server' => 'Server',
            'servers' => 'Servers',
            'database' => 'Database',
            'databases' => 'Databases',
            'domain' => 'Domain',
            'domains' => 'Domains',
            'firewall' => 'Firewall',
            'rule' => 'rule',
            'rules' => 'rules',
            'ssl' => 'SSL',
            'certificate' => 'certificate',
            'cronjob' => 'Cronjob',
            'cronjobs' => 'Cronjobs',
            'backup' => 'Backup',
            'backups' => 'Backups',
            'supervisor' => 'Supervisor',
            'organization' => 'Organization',
            'organizations' => 'Organizations',
            'primary' => 'primary',
            'php' => 'PHP',
            'settings' => 'settings',
            'basic' => 'Basic',
            'auth' => 'auth',
            'root' => 'root',
            'access' => 'access',
            'ssh' => 'SSH',
            'redis' => 'Redis',
            'configuration' => 'configuration',
            'api' => 'API',
            'key' => 'key',
        ];
        
        $result = [];
        foreach ($parts as $part) {
            if (isset($wordMappings[$part])) {
                $result[] = $wordMappings[$part];
            } else {
                $result[] = ucfirst($part);
            }
        }
        
        return implode(' ', $result);
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

    public static function clientReconnected($user, ?string $clientName = null): ?Activity
    {
        $client = $clientName ?? McpConnectionTracker::detectClient(Request::userAgent());
        
        // Deduplication with Cache lock: prevent race conditions when multiple requests hit at once
        $cacheKey = 'mcp_reconnect:' . $user->id . ':' . $client;
        
        if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
            return null; // Skip duplicate within lock period
        }
        
        // Set cache lock for 30 seconds
        \Illuminate\Support\Facades\Cache::put($cacheKey, true, 30);
        
        return self::log(
            $user,
            Activity::TYPE_CLIENT_RECONNECTED,
            "Reconnected successfully via {$client}",
            null,
            $client
        );
    }

    public static function toolExecuted($user, string $toolName, ?string $clientName = null, bool $success = true, ?array $arguments = null, ?array $response = null, ?string $errorMessage = null): ?Activity
    {
        // Deduplication: Skip if same tool called within 2 seconds with same arguments
        $recentActivity = Activity::where('user_id', $user->id)
            ->where('type', Activity::TYPE_TOOL_EXECUTED)
            ->where('created_at', '>=', now()->subSeconds(2))
            ->first();
        
        if ($recentActivity) {
            $recentMeta = $recentActivity->metadata ?? [];
            $recentArgs = $recentMeta['arguments'] ?? null;
            if ($recentArgs === $arguments && ($recentMeta['tool'] ?? '') === $toolName) {
                return null; // Skip duplicate
            }
        }
        
        $client = $clientName ?? McpConnectionTracker::detectClient(Request::userAgent());
        
        // Build user-friendly description
        $description = self::buildToolDescription($toolName, $success, $errorMessage);
        
        $metadata = ['tool' => $toolName, 'success' => $success, 'user_agent' => Request::userAgent()];
        if ($arguments !== null) {
            $metadata['arguments'] = $arguments;
        }
        if ($response !== null) {
            $metadata['response'] = $response;
        }
        if ($errorMessage !== null) {
            $metadata['error_message'] = $errorMessage;
        }
        return self::log(
            $user,
            Activity::TYPE_TOOL_EXECUTED,
            $description,
            $metadata,
            $client
        );
    }

    public static function apiKeySaved($user): Activity
    {
        return self::log($user, Activity::TYPE_API_KEY_SAVED, 'ServerAvatar API key saved successfully.');
    }

    public static function apiKeyUpdated($user): Activity
    {
        return self::log($user, Activity::TYPE_API_KEY_UPDATED, 'ServerAvatar API key updated successfully.');
    }

    public static function apiKeyDeleted($user): Activity
    {
        return self::log($user, Activity::TYPE_API_KEY_DELETED, 'ServerAvatar API key removed.');
    }

    public static function profileUpdated($user): Activity
    {
        return self::log($user, Activity::TYPE_PROFILE_UPDATED, 'Profile updated successfully.');
    }

    public static function passwordChanged($user): Activity
    {
        return self::log($user, Activity::TYPE_PASSWORD_CHANGED, 'Password changed successfully.');
    }

    public static function accountDeleted($user): Activity
    {
        return self::log($user, Activity::TYPE_SETTINGS_UPDATED, 'Account deleted.');
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
