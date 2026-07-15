<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Install a WordPress plugin from WordPress.org.
 */
#[Description('Install a WordPress plugin from WordPress.org. Provide the plugin slug (e.g. "redis-cache"). Use listWordpressPlugins first to see installed plugins. Requires WordPress Toolkit add-on.')]
class InstallWordpressPluginTool extends Tool
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
            return Response::error('plugin is required. WordPress.org plugin slug (e.g. "redis-cache").');
        }

        $data = ['plugin' => $plugin];

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/plugins/install";
        $result = $this->apiCall($endpoint, $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'plugin' => $schema->string()->description('WordPress.org plugin slug (e.g. "redis-cache")')->required(),
        ];
    }
}
