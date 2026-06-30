<?php

namespace App\Mcp\Tools\Application;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Manage HTTP Basic Authentication for an application. Use action="get" to check current status, action="create" with username and auth_pass to enable, action="disable" to turn it off.')]
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
                if (!$username) {
                    return Response::error('username is required for create action.');
                }

                $password = $request->get('auth_pass');
                if (!$password) {
                    return Response::error('auth_pass is required for create action.');
                }

                $data = $this->apiCall($endpoint, $user, [
                    'username' => $username,
                    'password' => $password,
                ], 'POST');
                break;

            case 'disable':
                $currentAuth = $this->apiCall($endpoint, $user);

                if (empty($currentAuth['basicAuth']) || !isset($currentAuth['basicAuth']['id'])) {
                    return Response::error('No basic authentication found to disable.');
                }

                $basicAuthId = $currentAuth['basicAuth']['id'];
                $disableEndpoint = $endpoint . '/' . $basicAuthId;

                $data = $this->apiCall($disableEndpoint, $user, [
                    'enabled' => false,
                ], 'PATCH');
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
            'auth_pass' => $schema->string()->description('Auth credential for basic auth (required only for action=create)'),
        ];
    }
}
