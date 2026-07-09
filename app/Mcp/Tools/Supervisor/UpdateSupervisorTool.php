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
 * Update an existing supervisor.
 * 
 * @example updateSupervisor(organizationId: "227", serverId: "5432", applicationId: "123", supervisorId: "1", name: "EmailWorker", command: "php artisan queue:work --queue=high", autostart: true, autorestart: true, numprocs: 3, user: "appuser", logfile: "worker.log", loglevel: "debug")
 */
#[Description('Update an existing supervisor configuration. Change name, command, autostart, autorestart, number of processes, log level, and more. Requires organization_id, server_id, application_id, supervisor_id, and all other fields.')]
class UpdateSupervisorTool extends Tool
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
            'name' => ['required'],
            'command' => ['required'],
            'autostart' => ['required', 'boolean'],
            'autorestart' => ['required', 'boolean'],
            'numprocs' => ['required', 'integer', 'min:1'],
            'user' => ['required'],
            'logfile' => ['required'],
            'loglevel' => ['required', Rule::in(['critical', 'error', 'warn', 'info', 'debug', 'trace', 'blather'])],
            'extra_config' => ['nullable'],
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

        $body = [
            'name' => $validated['name'],
            'command' => $validated['command'],
            'autostart' => $validated['autostart'],
            'autorestart' => $validated['autorestart'],
            'numprocs' => $validated['numprocs'],
            'user' => $validated['user'],
            'logfile' => $validated['logfile'],
            'loglevel' => $validated['loglevel'],
        ];

        if (!empty($validated['extra_config'])) {
            $body['extra_config'] = $validated['extra_config'];
        }

        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications/$applicationId/supervisors/$supervisorId", $user, $body, 'PUT');

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'supervisor_id' => $schema->string()->description('The supervisor ID to update')->required(),
            'name' => $schema->string()->description('Name of the supervisor')->required(),
            'command' => $schema->string()->description('The command to run (e.g., php artisan queue:work)')->required(),
            'autostart' => $schema->boolean()->description('Whether to start automatically (true/false)')->required(),
            'autorestart' => $schema->boolean()->description('Whether to restart automatically on failure (true/false)')->required(),
            'numprocs' => $schema->integer()->description('Number of processes to run (minimum 1)')->required(),
            'user' => $schema->string()->description('Application user username')->required(),
            'logfile' => $schema->string()->description('Log file name')->required(),
            'loglevel' => $schema->string()->enum(['critical', 'error', 'warn', 'info', 'debug', 'trace', 'blather'])->description('Log level')->required(),
            'extra_config' => $schema->string()->description('Extra configuration (optional) - e.g., stopwaitsecs, startsecs'),
        ];
    }
}
