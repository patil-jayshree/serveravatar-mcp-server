<?php

namespace App\Mcp\Tools\Supervisor;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Get a specific supervisor by ID.
 * 
 * @example getSupervisor(organizationId: "227", serverId: "5432", applicationId: "123", supervisorId: "1")
 */
#[Description('Get details of a specific supervisor by its ID. Returns name, user, command, autostart, autorestart, numprocs, logfile, and loglevel. Requires organization_id, server_id, application_id, and supervisor_id.')]
class GetSupervisorTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            'organization_id' => ['required'],
            'server_id' => ['required'],
            'application_id' => ['required'],
            'supervisor_id' => ['required'],
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
        $supervisorId = $validated['supervisor_id'];

        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications/$applicationId/supervisors/$supervisorId", $user);

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'supervisor_id' => $schema->string()->description('The supervisor ID')->required(),
        ];
    }
}
