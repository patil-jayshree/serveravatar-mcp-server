<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Uninstall a WordPress plugin.
 */
#[Description('Uninstall a WordPress plugin. The plugin must be deactivated first. Use listWordpressPlugins to get plugin names, toggleWordpressPlugin to deactivate. Requires WordPress Toolkit add-on.')]
class UninstallWordpressPluginTool extends Tool
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
            return Response::error('plugin is required. Plugin name to uninstall.');
        }

        $data = ['plugin' => $plugin];

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/plugins/uninstall";
        $result = $this->apiCall($endpoint, $user, $data, 'DELETE');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'plugin' => $schema->string()->description('Plugin name to uninstall')->required(),
        ];
    }
}
