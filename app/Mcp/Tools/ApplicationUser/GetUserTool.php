<?php

namespace App\Mcp\Tools\ApplicationUser;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Get details of a specific application user.
 */
#[Description('Get details of a specific application user including username, password, public_key, group, ssh_access, and root_access.')]
class GetUserTool extends Tool
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

        $systemUserId = $request->get('system_user_id');
        if (!$systemUserId) {
            return Response::error('system_user_id is required. Use listUsers to get the user ID.');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/system-users/$systemUserId";
        $result = $this->apiCall($endpoint, $user, [], 'GET');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'system_user_id' => $schema->number()->description('The application user ID (from listUsers)')->required(),
        ];
    }
}
