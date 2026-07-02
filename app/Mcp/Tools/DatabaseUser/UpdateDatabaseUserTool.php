<?php

namespace App\Mcp\Tools\DatabaseUser;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Update an existing database user for a specific database. Requires organization_id, server_id, database_id, database_user_id, username, and password. Optional: connection_preference and hostname.')]
class UpdateDatabaseUserTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            'organization_id' => ['required'],
            'server_id' => ['required'],
            'database_id' => ['required'],
            'database_user_id' => ['required'],
            'username' => ['required', 'alpha_num', 'min:5'],
            'password' => ['required', 'string', 'min:8'],
            'connection_preference' => ['sometimes', 'in:localhost,everywhere,specific_ip_addresses'],
            'hostname' => ['array'],
            'hostname.*' => ['ip'],
        ]);

        $organizationId = $validated['organization_id'];
        $serverId = $validated['server_id'];
        $databaseId = $validated['database_id'];
        $databaseUserId = $validated['database_user_id'];

        $data = [
            'username' => $validated['username'],
            'password' => $validated['password'],
        ];

        if (!empty($validated['connection_preference'])) {
            $data['connection_preference'] = $validated['connection_preference'];
        }

        if (!empty($validated['hostname'])) {
            $data['hostname'] = $validated['hostname'];
        }

        $result = $this->apiCall("/organizations/$organizationId/servers/$serverId/databases/$databaseId/database-users/$databaseUserId", $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'database_id' => $schema->string()->description('The database ID')->required(),
            'database_user_id' => $schema->string()->description('The database user ID to update')->required(),
            'username' => $schema->string()->description('Database username (alpha-numeric, min 5 chars)')->required(),
            'password' => $schema->string()->description('Database password (min 8 chars)')->required(),
            'connection_preference' => $schema->string()->description('Connection preference: localhost, everywhere, or specific_ip_addresses'),
            'hostname' => $schema->array($schema->string())->description('Array of IPv4 addresses for remote access'),
        ];
    }
}
