<?php

namespace App\Mcp\Tools\Cronjob;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Delete a cronjob from a server.
 */
#[Description('Delete a cronjob from a server. The automatic process will stop immediately once deleted. Requires cronjob ID (from listCronjobs).')]
class DeleteCronjobTool extends Tool
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

        $cronjobId = $request->get('cronjob_id');
        if (!$cronjobId) {
            return Response::error('cronjob_id is required. Use listCronjobs to get the cronjob ID.');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/cronjobs/$cronjobId";
        $result = $this->apiCall($endpoint, $user, [], 'DELETE');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'cronjob_id' => $schema->number()->description('The cronjob ID to delete (from listCronjobs)')->required(),
        ];
    }
}
