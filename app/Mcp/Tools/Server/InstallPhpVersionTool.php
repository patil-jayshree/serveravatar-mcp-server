<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Install a specific PHP version on the server.
 * Available versions: 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4, 8.5
 */
#[Description('Install a specific PHP version on the server. Available versions: 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4, 8.5. Use listServers first to check which versions are already installed.')]
class InstallPhpVersionTool extends Tool
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

        $version = $request->get('version');
        if (!$version) {
            return Response::error('version is required. Examples: 7.4, 8.2, 8.3');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/services/install-php-version";
        $data = $this->apiCall($endpoint, $user, [
            'service' => $version,
        ], 'PATCH');

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'version' => $schema->string()->description('PHP version to install: 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4, 8.5')->required(),
        ];
    }
}
