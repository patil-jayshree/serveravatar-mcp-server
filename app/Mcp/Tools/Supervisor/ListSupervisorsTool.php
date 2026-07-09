<?php

namespace App\Mcp\Tools\Supervisor;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * List all supervisors for an application.
 * 
 * @example listSupervisors(organizationId: "227", serverId: "5432", applicationId: "123")
 */
#[Description('List all supervisors for an application. Shows process manager details like name, user, command, autostart, autorestart, numprocs, logfile, and loglevel. Use this to view all supervised processes for queue workers or background tasks. Requires organization_id, server_id, and application_id.')]
class ListSupervisorsTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            'organization_id' => ['required'],
            'server_id' => ['required'],
            'application_id' => ['required'],
        ]);

        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) {
            return $organizationId;
        }

        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) {
            return $serverId;
        }

        $applicationId = $validated['application_id'];

        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications/$applicationId/supervisors", $user);

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
        ];
    }
}
