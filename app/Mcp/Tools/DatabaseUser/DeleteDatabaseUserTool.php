<?php

namespace App\Mcp\Tools\DatabaseUser;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Delete database users from a specific database. Requires organization_id, server_id, database_id, and ids (array of database user IDs to delete). Warning: This action is irreversible.')]
class DeleteDatabaseUserTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            'organization_id' => ['required'],
            'server_id' => ['required'],
            'database_id' => ['required'],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer'],
        ]);

        $organizationId = $validated['organization_id'];
        $serverId = $validated['server_id'];
        $databaseId = $validated['database_id'];

        $data = [
            'ids' => $validated['ids'],
        ];

        $result = $this->apiCall("/organizations/$organizationId/servers/$serverId/databases/$databaseId/database-users/delete", $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'database_id' => $schema->string()->description('The database ID')->required(),
            'ids' => $schema->array($schema->integer())->description('Array of database user IDs to delete')->required(),
        ];
    }
}
