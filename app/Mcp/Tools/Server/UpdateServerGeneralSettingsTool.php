<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Update general settings of the server.
 * Settings: name, hostname, php_cli_version, ols_automatically_restart, timezone
 */
#[Description('Update general settings of the server. Settings: name (required), hostname (required), php_cli_version (optional), ols_automatically_restart (required), timezone (required). Example: name="myserver", hostname="myserver.com", timezone="UTC".')]
class UpdateServerGeneralSettingsTool extends Tool
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

        $name = $request->get('name');
        if (!$name) {
            return Response::error('name is required. The new name for the server.');
        }

        $hostname = $request->get('hostname');
        if (!$hostname) {
            return Response::error('hostname is required. The new hostname for the server.');
        }

        $timezone = $request->get('timezone');
        if (!$timezone) {
            return Response::error('timezone is required. Example: UTC, Asia/Kolkata.');
        }

        $data = [
            'name' => $name,
            'hostname' => $hostname,
            'timezone' => $timezone,
        ];

        // Optional fields
        if ($request->has('php_cli_version')) {
            $data['php_cli_version'] = $request->get('php_cli_version');
        }

        if ($request->has('ols_automatically_restart')) {
            $data['ols_automatically_restart'] = $request->get('ols_automatically_restart');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/settings/general";
        $result = $this->apiCall($endpoint, $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'name' => $schema->string()->description('New name for the server')->required(),
            'hostname' => $schema->string()->description('New hostname for the server')->required(),
            'timezone' => $schema->string()->description('Timezone (e.g., UTC, Asia/Kolkata)')->required(),
            'php_cli_version' => $schema->number()->description('PHP CLI version: 7.0 to 8.5'),
            'ols_automatically_restart' => $schema->boolean()->description('Auto restart OpenLiteSpeed (true/false)'),
        ];
    }
}
