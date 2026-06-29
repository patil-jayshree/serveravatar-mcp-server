<?php

namespace App\Mcp\Tools\Application;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Manage basic authentication for an application.
 * Supports three actions: get (retrieve), create, and disable.
 * 
 * @example manageBasicAuth(organizationId: "227", serverId: "5432", applicationId: "14000", action: "get")
 * @example manageBasicAuth(organizationId: "227", serverId: "5432", applicationId: "14000", action: "create", username: "admin", password: "secret123")
 * @example manageBasicAuth(organizationId: "227", serverId: "5432", applicationId: "14000", action: "disable")
 */
#[Description('Manage basic authentication for an application. Actions: "get" to retrieve current settings, "create" to enable with username/password, "disable" to remove basic auth. Requires organization_id, server_id, application_id, and action. For create action, also requires username and password.')]
class ManageBasicAuthTool extends Tool
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

        $applicationId = $request->get('application_id');
        if (!$applicationId) {
            return Response::error('application_id is required. Please provide the application ID.');
        }

        $action = $request->get('action');
        if (!$action || !in_array($action, ['get', 'create', 'disable'])) {
            return Response::error('action is required. Must be one of: get, create, disable.');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/basic-authentication";

        switch ($action) {
            case 'get':
                $data = $this->apiCall($endpoint, $user);
                break;

            case 'create':
                $username = $request->get('username');
                $password = $request->get('password');

                if (!$username || !$password) {
                    return Response::error('username and password are required for create action.');
                }

                $data = $this->apiCall($endpoint, $user, [
                    'username' => $username,
                    'password' => $password,
                ], 'POST');
                break;

            case 'disable':
                $data = $this->apiCall($endpoint, $user, [], 'DELETE');
                break;
        }

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'action' => $schema->string()->description('Action to perform: get, create, or disable')->required(),
            'username' => $schema->string()->description('Username for basic auth (required only for action=create)'),
            'password' => $schema->string()->description('Password for basic auth (required only for action=create)'),
        ];
    }
}
