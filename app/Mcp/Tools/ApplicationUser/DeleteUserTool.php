<?php

namespace App\Mcp\Tools\ApplicationUser;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Delete application users from a server.
 */
#[Description('Delete application users from a server. Requires array of application user IDs (from listUsers). Note: users with associated applications cannot be deleted.')]
class DeleteUserTool extends Tool
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

        $ids = $request->get('ids');
        if (!is_array($ids) || empty($ids)) {
            return Response::error('ids is required. Array of application user IDs to delete (from listUsers).');
        }

        $data = [
            'ids' => $ids,
        ];

        $endpoint = "/organizations/$organizationId/servers/$serverId/system-users/delete";
        $result = $this->apiCall($endpoint, $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'ids' => $schema->array([
                'items' => $schema->integer()->description('Application user ID'),
            ])->description('Array of application user IDs to delete (from listUsers)')->required(),
        ];
    }
}
