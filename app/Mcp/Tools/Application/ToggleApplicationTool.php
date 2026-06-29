<?php

namespace App\Mcp\Tools\Application;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Toggle application (enable/disable) on a server.
 * 
 * @example toggleApplication(organizationId: "227", serverId: "5432", applicationId: "14000")
 */
#[Description('Enable or disable a specific application on a server. This toggles the application between enabled and disabled states. Requires organization_id, server_id, and application_id.')]
class ToggleApplicationTool extends Tool
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
            return Response::error('application_id is required. Please provide the application ID to toggle.');
        }

        $data = $this->apiCall(
            "/organizations/$organizationId/servers/$serverId/applications/$applicationId/toggle",
            $user
        );

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID to toggle')->required(),
        ];
    }
}
