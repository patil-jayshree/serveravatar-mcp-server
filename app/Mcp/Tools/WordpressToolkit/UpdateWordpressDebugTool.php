<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Update WordPress debug setting.
 */
#[Description('Update a WordPress debug constant in wp-config.php. Settings: WP_DEBUG, WP_DEBUG_LOG, WP_DEBUG_DISPLAY. Use true/false for value. Requires WordPress Toolkit add-on.')]
class UpdateWordpressDebugTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) {
            return $organizationId;
        }

        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) {
            return $serverId;
        }

        $applicationId = $this->getApplicationId($request);
        if ($applicationId instanceof Response) {
            return $applicationId;
        }

        $setting = $request->get('setting');
        if (!$setting || !in_array($setting, ['WP_DEBUG', 'WP_DEBUG_LOG', 'WP_DEBUG_DISPLAY'])) {
            return Response::error('setting is required. Must be one of: WP_DEBUG, WP_DEBUG_LOG, WP_DEBUG_DISPLAY.');
        }

        $value = $request->get('value');
        if ($value === null || $value === '') {
            return Response::error('value is required. Use "true" to enable or "false" to disable.');
        }

        $data = [
            'setting' => $setting,
            'value' => $value,
        ];

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/debug/update";
        $result = $this->apiCall($endpoint, $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'setting' => $schema->string()->description('Debug setting: WP_DEBUG, WP_DEBUG_LOG, or WP_DEBUG_DISPLAY')->required(),
            'value' => $schema->string()->description('Value: "true" to enable, "false" to disable')->required(),
        ];
    }
}
