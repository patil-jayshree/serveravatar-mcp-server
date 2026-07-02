<?php

namespace App\Mcp\Tools\DatabaseUser;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('List all database users for a specific database on a server. Requires organization_id, server_id, and database_id.')]
class ListDatabaseUsersTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            'organization_id' => ['required'],
            'server_id' => ['required'],
            'database_id' => ['required'],
        ]);

        $organizationId = $validated['organization_id'];
        $serverId = $validated['server_id'];
        $databaseId = $validated['database_id'];

        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/databases/$databaseId/database-users?pagination=1", $user);

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'database_id' => $schema->string()->description('The database ID')->required(),
        ];
    }
}
