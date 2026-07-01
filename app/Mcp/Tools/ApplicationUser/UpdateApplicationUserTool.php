<?php

namespace App\Mcp\Tools\ApplicationUser;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Update an application user (change password or update SSH key).
 */
#[Description('Update an application user. Use type="password" to change password (requires password + confirmation), or type="key" to update public_key.')]
class UpdateApplicationUserTool extends Tool
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

        $systemUserId = $request->get('system_user_id');
        if (!$systemUserId) {
            return Response::error('system_user_id is required. Use listApplicationUsers to get the user ID.');
        }

        $type = $request->get('type');
        if (!$type) {
            return Response::error('type is required. Use "password" or "key".');
        }

        if (!in_array($type, ['password', 'key'])) {
            return Response::error('type must be either "password" or "key".');
        }

        $data = [
            'type' => $type,
        ];

        if ($type === 'password') {
            $password = $request->get('password');
            if (!$password) {
                return Response::error('password is required when type is password. Minimum 8 characters.');
            }
            $passwordConfirmation = $request->get('password_confirmation');
            if (!$passwordConfirmation) {
                return Response::error('password_confirmation is required when type is password.');
            }
            $data['password'] = $password;
            $data['password_confirmation'] = $passwordConfirmation;
        }

        if ($type === 'key') {
            $publicKey = $request->get('public_key');
            if (!$publicKey) {
                return Response::error('public_key is required when type is key.');
            }
            $data['public_key'] = $publicKey;
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/system-users/$systemUserId";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'system_user_id' => $schema->number()->description('The application user ID (from listApplicationUsers)')->required(),
            'type' => $schema->string()->description('Type of update: "password" or "key"')->required(),
            'password' => $schema->string()->description('New password (min 8 chars) - required if type is password'),
            'password_confirmation' => $schema->string()->description('Confirm new password - required if type is password'),
            'public_key' => $schema->string()->description('SSH public key - required if type is key'),
        ];
    }
}
