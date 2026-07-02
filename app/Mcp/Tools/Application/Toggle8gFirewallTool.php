<?php

namespace App\Mcp\Tools\Application;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Enable or disable the 8G Firewall on a specific application. Requires organization_id, server_id, application_id, and enabled (true/false).')]
class Toggle8gFirewallTool extends Tool
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

        $applicationId = $request->get('application_id');
        if (!$applicationId) {
            return Response::error('application_id is required.');
        }

        $enabled = $request->get('enabled');
        if (!is_bool($enabled)) {
            return Response::error('enabled is required and must be a boolean (true or false).');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/firewall/8g/toggle";

        $data = $this->apiCall($endpoint, $user, [
            'enabled' => $enabled,
        ], 'POST');

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'server_id' => $schema->string()->description('Server ID')->required(),
            'application_id' => $schema->string()->description('Application ID')->required(),
            'enabled' => $schema->boolean()->description('true to enable 8G Firewall, false to disable')->required(),
        ];
    }
}
