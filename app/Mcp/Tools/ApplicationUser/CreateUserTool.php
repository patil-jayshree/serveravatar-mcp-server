<?php

namespace App\Mcp\Tools\ApplicationUser;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Create a new application user for a server.
 */
#[Description('Create a new application user for a server. Required: username (alpha-numeric, min 5 chars), password (min 8 chars), password_confirmation. Optional: public_key.')]
class CreateUserTool extends Tool
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

        $username = $request->get('username');
        if (!$username) {
            return Response::error('username is required. Alpha-numeric string, minimum 5 characters.');
        }

        $password = $request->get('password');
        if (!$password) {
            return Response::error('password is required. Minimum 8 characters.');
        }

        $passwordConfirmation = $request->get('password_confirmation');
        if (!$passwordConfirmation) {
            return Response::error('password_confirmation is required and must match password.');
        }

        $data = [
            'username' => $username,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ];

        if ($request->has('public_key') && $request->get('public_key') !== null && $request->get('public_key') !== '') {
            $data['public_key'] = $request->get('public_key');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/system-users";
        $result = $this->apiCall($endpoint, $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'username' => $schema->string()->description('Alpha-numeric username (min 5 characters)')->required(),
            'password' => $schema->string()->description('Password (min 8 characters)')->required(),
            'password_confirmation' => $schema->string()->description('Confirm password (must match)')->required(),
            'public_key' => $schema->string()->description('SSH public key (optional)'),
        ];
    }
}
