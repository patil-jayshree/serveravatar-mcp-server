<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Get status of all services on a server.
 * Shows services like Apache, MySQL, PHP-FPM, Redis, etc.
 */
#[Description('Get status of all services running on a server. Shows service name, status (running/stopped), and resource usage (RAM and CPU). Common services: apache2, mysql, php-fpm, redis, nginx, postfix, ssh.')]
class GetServerServicesTool extends Tool
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

        $endpoint = "/organizations/$organizationId/servers/$serverId/services";
        $data = $this->apiCall($endpoint, $user);

        // Format for readability
        if (isset($data['services'])) {
            $formatted = [];
            foreach ($data['services'] as $service) {
                $formatted[] = [
                    'name' => $service['name'] ?? 'unknown',
                    'status' => ($service['status'] ?? false) ? 'running' : 'stopped',
                    'ram_mb' => $service['resourceUsage']['ram'] ?? 0,
                    'cpu_percent' => $service['resourceUsage']['cpu'] ?? 0,
                ];
            }
            $data['services'] = $formatted;
        }

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
        ];
    }
}
