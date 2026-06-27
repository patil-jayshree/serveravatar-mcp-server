<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Update PHP settings for an application. Manage PHP version, directives (memory_limit, max_execution_time, etc.), and PHP-FPM process manager settings (pm_type, pm_max_children, etc.).\n\nPHP Version Examples: 7.4, 8.0, 8.1, 8.2, 8.3, 8.4, 8.5\nPHP-FPM pm_type: ondemand, static, dynamic\n\nNote: Conditional fields like pm_max_requests, pm_start_servers are only required based on pm_type value.')]
class UpdatePhpSettingsTool extends Tool
{
    use InteractsWithServerAvatarApi;

    private const PHP_VERSIONS = ['7.2', '7.3', '7.4', '8.0', '8.1', '8.2', '8.3', '8.4', '8.5'];
    private const PM_TYPES = ['ondemand', 'static', 'dynamic'];

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            // Always required
            'server_id' => ['required'],
            'organization_id' => ['required'],
            'application_id' => ['required'],

            // PHP Settings
            'php_version' => ['required', Rule::in(self::PHP_VERSIONS)],
            'disabled_functions' => ['required'],
            'max_execution_time' => ['required', 'numeric'],
            'max_input_time' => ['required', 'numeric'],
            'max_input_vars' => ['required', 'numeric'],
            'memory_limit' => ['required'],
            'post_max_size' => ['required'],
            'upload_max_filesize' => ['required'],

            // Optional PHP Settings
            'open_basedir' => [],
            'auto_prepend_file' => [],
            'php_timezone' => [],

            // PHP-FPM Settings (always required)
            'pm_type' => ['required', Rule::in(self::PM_TYPES)],
            'pm_max_children' => ['required', 'numeric'],

            // Conditional PHP-FPM fields based on pm_type
            'pm_max_requests' => ['required_unless:pm_type,static', 'numeric'],
            'pm_max_spare_servers' => ['required_if:pm_type,dynamic', 'numeric'],
            'pm_min_spare_servers' => ['required_if:pm_type,dynamic', 'numeric'],
            'pm_process_idle_timeout' => ['required_if:pm_type,ondemand', 'numeric'],
            'pm_start_servers' => ['required_if:pm_type,dynamic', 'numeric'],
            // pm_max_spawn_rate is only required when pm_type=dynamic AND php_version is 8.1+
            // Since Laravel can't do multi-field conditional, we use nullable + custom validation
            'pm_max_spawn_rate' => ['nullable', 'numeric'],
        ], [
            // Always required messages
            'server_id.required' => 'server_id is required.',
            'organization_id.required' => 'organization_id is required.',
            'application_id.required' => 'application_id is required.',
            'php_version.required' => 'php_version is required.',
            'php_version.in' => 'Invalid php_version. Use: 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4, or 8.5.',
            'disabled_functions.required' => 'disabled_functions is required.',
            'max_execution_time.required' => 'max_execution_time is required.',
            'max_execution_time.numeric' => 'max_execution_time must be numeric.',
            'max_input_time.required' => 'max_input_time is required.',
            'max_input_time.numeric' => 'max_input_time must be numeric.',
            'max_input_vars.required' => 'max_input_vars is required.',
            'max_input_vars.numeric' => 'max_input_vars must be numeric.',
            'memory_limit.required' => 'memory_limit is required.',
            'post_max_size.required' => 'post_max_size is required.',
            'upload_max_filesize.required' => 'upload_max_filesize is required.',

            // PHP-FPM messages
            'pm_type.required' => 'pm_type is required. Use: ondemand, static, or dynamic.',
            'pm_type.in' => 'Invalid pm_type. Use: ondemand, static, or dynamic.',
            'pm_max_children.required' => 'pm_max_children is required.',
            'pm_max_children.numeric' => 'pm_max_children must be numeric.',

            // Conditional PHP-FPM messages
            'pm_max_requests.required_if' => 'pm_max_requests is required when pm_type is ondemand or dynamic.',
            'pm_max_requests.numeric' => 'pm_max_requests must be numeric.',
            'pm_max_spare_servers.required_if' => 'pm_max_spare_servers is required when pm_type is dynamic.',
            'pm_max_spare_servers.numeric' => 'pm_max_spare_servers must be numeric.',
            'pm_min_spare_servers.required_if' => 'pm_min_spare_servers is required when pm_type is dynamic.',
            'pm_min_spare_servers.numeric' => 'pm_min_spare_servers must be numeric.',
            'pm_process_idle_timeout.required_if' => 'pm_process_idle_timeout is required when pm_type is ondemand.',
            'pm_process_idle_timeout.numeric' => 'pm_process_idle_timeout must be numeric.',
            'pm_start_servers.required_if' => 'pm_start_servers is required when pm_type is dynamic.',
            'pm_start_servers.numeric' => 'pm_start_servers must be numeric.',
            'pm_max_spawn_rate.required_if' => 'pm_max_spawn_rate is required when pm_type is dynamic and PHP version is 8.1 or higher.',
            'pm_max_spawn_rate.numeric' => 'pm_max_spawn_rate must be numeric.',
        ]);

        // Build API request body (only include non-null fields)
        $body = array_filter([
            'php_version' => $validated['php_version'],
            'open_basedir' => $validated['open_basedir'] ?? null,
            'disabled_functions' => $validated['disabled_functions'],
            'max_execution_time' => (int) $validated['max_execution_time'],
            'max_input_time' => (int) $validated['max_input_time'],
            'max_input_vars' => (int) $validated['max_input_vars'],
            'memory_limit' => $validated['memory_limit'],
            'post_max_size' => $validated['post_max_size'],
            'upload_max_filesize' => $validated['upload_max_filesize'],
            'auto_prepend_file' => $validated['auto_prepend_file'] ?? null,
            'php_timezone' => $validated['php_timezone'] ?? null,
            'pm_type' => $validated['pm_type'],
            'pm_max_children' => (int) $validated['pm_max_children'],
            'pm_max_requests' => isset($validated['pm_max_requests']) ? (int) $validated['pm_max_requests'] : null,
            'pm_max_spare_servers' => isset($validated['pm_max_spare_servers']) ? (int) $validated['pm_max_spare_servers'] : null,
            'pm_min_spare_servers' => isset($validated['pm_min_spare_servers']) ? (int) $validated['pm_min_spare_servers'] : null,
            'pm_process_idle_timeout' => isset($validated['pm_process_idle_timeout']) ? (int) $validated['pm_process_idle_timeout'] : null,
            'pm_start_servers' => isset($validated['pm_start_servers']) ? (int) $validated['pm_start_servers'] : null,
            'pm_max_spawn_rate' => isset($validated['pm_max_spawn_rate']) ? (int) $validated['pm_max_spawn_rate'] : null,
        ], fn ($value) => $value !== null);

        $organizationId = $validated['organization_id'];
        $serverId = $validated['server_id'];
        $applicationId = $validated['application_id'];

        $data = $this->apiCall(
            "/organizations/$organizationId/servers/$serverId/applications/$applicationId/php-settings",
            $user,
            $body,
            'PATCH'
        );

        if (isset($data['error'])) {
            return Response::error($data['error']);
        }

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            // Identity fields
            'server_id' => $schema->string()->description('The server ID (required)'),
            'organization_id' => $schema->string()->description('The organization ID (required)'),
            'application_id' => $schema->string()->description('The application ID to update PHP settings for (required)'),

            // PHP Version & Basic Settings
            'php_version' => $schema->string()->description('PHP version (required): 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4, or 8.5'),
            'disabled_functions' => $schema->string()->description('List of disabled PHP functions, comma-separated (required)'),
            'memory_limit' => $schema->string()->description('PHP memory_limit directive (required) e.g., 256M'),
            'max_execution_time' => $schema->integer()->description('max_execution_time in seconds (required)'),
            'max_input_time' => $schema->integer()->description('max_input_time in seconds (required)'),
            'max_input_vars' => $schema->integer()->description('max_input_vars count (required)'),
            'post_max_size' => $schema->string()->description('post_max_size directive (required) e.g., 64M'),
            'upload_max_filesize' => $schema->string()->description('upload_max_filesize directive (required) e.g., 32M'),

            // Optional PHP Settings
            'open_basedir' => $schema->string()->description('open_basedir path (optional)'),
            'auto_prepend_file' => $schema->string()->description('Auto prepend file path (optional)'),
            'php_timezone' => $schema->string()->description('PHP timezone (optional) e.g., UTC'),

            // PHP-FPM Settings (required)
            'pm_type' => $schema->string()->description('PHP-FPM process manager type (required): ondemand, static, or dynamic'),
            'pm_max_children' => $schema->integer()->description('pm_max_children directive (required)'),

            // Conditional PHP-FPM fields
            'pm_max_requests' => $schema->integer()->description('pm_max_requests: required if pm_type is ondemand or dynamic'),
            'pm_max_spare_servers' => $schema->integer()->description('pm_max_spare_servers: required if pm_type is dynamic'),
            'pm_min_spare_servers' => $schema->integer()->description('pm_min_spare_servers: required if pm_type is dynamic'),
            'pm_process_idle_timeout' => $schema->integer()->description('pm_process_idle_timeout: required if pm_type is ondemand'),
            'pm_start_servers' => $schema->integer()->description('pm_start_servers: required if pm_type is dynamic'),
            'pm_max_spawn_rate' => $schema->integer()->description('pm_max_spawn_rate: required if pm_type is dynamic AND PHP version 8.1+'),
        ];
    }

    public function outputSchema(JsonSchema $schema): array
    {
        return [
            'message' => $schema->string()->description('Success or error message'),
            'data' => $schema->object([])->description('Updated PHP settings data'),
        ];
    }
}
