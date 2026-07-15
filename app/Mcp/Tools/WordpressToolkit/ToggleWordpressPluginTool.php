<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Toggle WordPress plugin activation status.
 */
#[Description('Activate or deactivate a WordPress plugin. Use listWordpressPlugins first to get plugin names. Requires WordPress Toolkit add-on.')]
class ToggleWordpressPluginTool extends Tool
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

        $plugin = $request->get('plugin');
        if (!$plugin) {
            return Response::error('plugin is required. Plugin name.');
        }

        $action = $request->get('action');
        if (!$action || !in_array($action, ['activate', 'deactivate'])) {
            return Response::error('action is required. Must be "activate" or "deactivate".');
        }

        $data = [
            'plugin' => $plugin,
            'action' => $action,
        ];

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/plugins/toggle";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'plugin' => $schema->string()->description('Plugin name')->required(),
            'action' => $schema->string()->description('Action: "activate" or "deactivate"')->required(),
        ];
    }
}
