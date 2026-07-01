<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Update the tags for a server.
 * This replaces all existing tags with the provided tag names.
 */
#[Description('Update the tags for a server. This replaces all existing tags with the provided array of tag names (strings). Example: tags=["Production", "Backend", "Server1"].')]
class UpdateServerTagsTool extends Tool
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

        $tags = $request->get('tags');
        if (!is_array($tags)) {
            return Response::error('tags must be an array of tag names (strings). Example: ["Production", "Backend"].');
        }

        $data = [
            'tags' => $tags,
        ];

        $endpoint = "/organizations/$organizationId/servers/$serverId/tags";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'tags' => $schema->array([
                'items' => $schema->string()->description('Tag name'),
            ])->description('Array of tag names to assign to the server (replaces all existing tags). Example: ["Production", "Backend"]')->required(),
        ];
    }
}
