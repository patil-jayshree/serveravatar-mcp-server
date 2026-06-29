<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Update (start, stop, restart, reload) a service on the server.
 * Services: apache2, nginx, mysql, mariadb, postfix, ssh, ufw, redis, php7.0-fpm to php8.5-fpm
 */
#[Description('Update a service on the server. Actions: start, stop, restart, reload. Services: apache2, nginx, mysql, mariadb, postfix, ssh, ufw, redis, php7.0-fpm to php8.5-fpm. Use getServerServices tool first to check service names and status.')]
class UpdateServerServiceTool extends Tool
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

        $service = $request->get('service');
        if (!$service) {
            return Response::error('service is required. Examples: apache2, nginx, mysql, php8.3-fpm, redis, postfix, ssh, ufw');
        }

        $action = $request->get('action');
        if (!$action || !in_array($action, ['start', 'stop', 'restart', 'reload'])) {
            return Response::error('action is required. Must be one of: start, stop, restart, reload');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/services";
        $data = $this->apiCall($endpoint, $user, [
            'service' => $service,
            'action' => $action,
        ], 'POST');

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'service' => $schema->string()->description('Service name: apache2, nginx, mysql, mariadb, postfix, ssh, ufw, redis, php7.0-fpm to php8.5-fpm')->required(),
            'action' => $schema->string()->description('Action: start, stop, restart, reload')->required(),
        ];
    }
}
