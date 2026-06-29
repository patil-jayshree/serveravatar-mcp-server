<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Update PHP configuration for application.')]
class UpdatePhpSettingsTool extends Tool
{
    use InteractsWithServerAvatarApi;

    private const PHP_VERSIONS = ['7.2', '7.3', '7.4', '8.0', '8.1', '8.2', '8.3', '8.4', '8.5'];
    private const PM_TYPES = ['ondemand', 'static', 'dynamic'];

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $organizationId = $request->get('organization_id');
        $serverId = $request->get('server_id');
        $applicationId = $request->get('application_id');

        if (!$organizationId || !$serverId || !$applicationId) {
            return Response::error('organization_id, server_id, and application_id are required.');
        }

        // Fetch current application details to get PHP settings
        $appDetails = $this->apiCall(
            "/organizations/$organizationId/servers/$serverId/applications/$applicationId",
            $user
        );

        if (isset($appDetails['error'])) {
            return Response::error('Failed to fetch application details: ' . $appDetails['error']);
        }

        // Extract current PHP settings from application details
        $current = $appDetails['application'] ?? $appDetails;

        // Build update data with provided values overriding current values
        $updateData = [
            'php_version' => $request->get('php_version') ?? $current['php_version'] ?? null,
            'disabled_functions' => $request->get('disable_functions') ?? $current['disabled_functions'] ?? '',
            'max_execution_time' => (int) ($request->get('max_execution_time') ?? $current['max_execution_time'] ?? 300),
            'max_input_time' => (int) ($request->get('max_input_time') ?? $current['max_input_time'] ?? 60),
            'max_input_vars' => (int) ($request->get('max_input_vars') ?? $current['max_input_vars'] ?? 1000),
            'memory_limit' => $request->get('memory_limit') ?? $current['memory_limit'] ?? '256M',
            'post_max_size' => $request->get('post_max_size') ?? $current['post_max_size'] ?? '64M',
            'upload_max_filesize' => $request->get('upload_max_filesize') ?? $current['upload_max_filesize'] ?? '32M',
            'open_basedir' => $request->get('open_basedir') ?? $current['open_basedir'] ?? null,
            'auto_prepend_file' => $request->get('auto_prepend_file') ?? $current['auto_prepend_file'] ?? null,
            'php_timezone' => $request->get('php_timezone') ?? $current['php_timezone'] ?? null,
            'pm_type' => $request->get('pm_type') ?? $current['pm_type'] ?? 'ondemand',
            'pm_max_children' => (int) ($request->get('pm_max_children') ?? $current['pm_max_children'] ?? 10),
            'pm_max_requests' => (int) ($request->get('pm_max_requests') ?? $current['pm_max_requests'] ?? 500),
            'pm_max_spare_servers' => (int) ($current['pm_max_spare_servers'] ?? 2),
            'pm_min_spare_servers' => (int) ($current['pm_min_spare_servers'] ?? 1),
            'pm_process_idle_timeout' => (int) ($request->get('pm_process_idle_timeout') ?? $current['pm_process_idle_timeout'] ?? 10),
            'pm_start_servers' => (int) ($current['pm_start_servers'] ?? 2),
            'pm_max_spawn_rate' => (int) ($current['pm_max_spawn_rate'] ?? 1),
        ];

        // Remove null values
        $updateData = array_filter($updateData, fn ($value) => $value !== null);

        // Make sure disabled_functions is not empty
        if (empty($updateData['disabled_functions'])) {
            $updateData['disabled_functions'] = '';
        }

        // Validate PHP version if provided
        $phpVersion = $updateData['php_version'];
        if ($phpVersion && !in_array($phpVersion, self::PHP_VERSIONS)) {
            return Response::error('Invalid php_version. Use: ' . implode(', ', self::PHP_VERSIONS));
        }

        // Validate PM type if provided
        $pmType = $updateData['pm_type'];
        if ($pmType && !in_array($pmType, self::PM_TYPES)) {
            return Response::error('Invalid pm_type. Use: ' . implode(', ', self::PM_TYPES));
        }

        // Make sure numeric fields are integers
        $numericFields = ['max_execution_time', 'max_input_time', 'max_input_vars', 'pm_max_children', 'pm_max_requests', 'pm_max_spare_servers', 'pm_min_spare_servers', 'pm_process_idle_timeout', 'pm_start_servers', 'pm_max_spawn_rate'];
        foreach ($numericFields as $field) {
            if (isset($updateData[$field])) {
                $updateData[$field] = (int) $updateData[$field];
            }
        }

        // Send update to API
        $data = $this->apiCall(
            "/organizations/$organizationId/servers/$serverId/applications/$applicationId/php-settings",
            $user,
            $updateData,
            'PATCH'
        );

        if (isset($data['error'])) {
            return Response::error('API error: ' . $data['error']);
        }

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'php_version' => $schema->string()->description('PHP version e.g., 8.2'),
            'disable_functions' => $schema->string()->description('Disabled PHP functions (comma-separated)'),
            'memory_limit' => $schema->string()->description('Memory limit e.g., 256M'),
            'max_execution_time' => $schema->integer()->description('Max execution time in seconds'),
            'max_input_time' => $schema->integer()->description('Max input time in seconds'),
            'max_input_vars' => $schema->integer()->description('Max input variables'),
            'post_max_size' => $schema->string()->description('Post max size e.g., 64M'),
            'upload_max_filesize' => $schema->string()->description('Upload max filesize e.g., 32M'),
            'open_basedir' => $schema->string()->description('Open basedir path'),
            'auto_prepend_file' => $schema->string()->description('Auto prepend file path'),
            'php_timezone' => $schema->string()->description('PHP timezone e.g., UTC'),
            'pm_type' => $schema->string()->description('Process manager type: ondemand, static, dynamic'),
            'pm_max_children' => $schema->integer()->description('PM max children'),
            'pm_max_requests' => $schema->integer()->description('PM max requests'),
            'pm_max_spare_servers' => $schema->integer()->description('PM max spare servers'),
            'pm_min_spare_servers' => $schema->integer()->description('PM min spare servers'),
            'pm_process_idle_timeout' => $schema->integer()->description('PM process idle timeout'),
            'pm_start_servers' => $schema->integer()->description('PM start servers'),
            'pm_max_spawn_rate' => $schema->integer()->description('PM max spawn rate'),
        ];
    }

    public function outputSchema(JsonSchema $schema): array
    {
        return [
            'message' => $schema->string()->description('Result message'),
            'data' => $schema->object([])->description('Response data'),
        ];
    }
}
