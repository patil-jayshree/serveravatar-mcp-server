<?php

namespace App\Mcp\Tools\SSL;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Update a custom SSL certificate for an application. Only available for custom SSL certificates. Requires ssl_certificate and private_key.')]
class UpdateSslCertificateTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;

        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) return $serverId;

        $applicationId = $this->getApplicationId($request);
        if ($applicationId instanceof Response) return $applicationId;

        $validated = $request->validate([
            'ssl_certificate' => ['required'],
            'private_key' => ['required'],
            'chain_file' => ['nullable'],
        ]);

        $data = [
            'ssl_certificate' => $validated['ssl_certificate'],
            'private_key' => $validated['private_key'],
        ];

        if (!empty($validated['chain_file'])) {
            $data['chain_file'] = $validated['chain_file'];
        }

        $result = $this->apiCall(
            "/organizations/$organizationId/servers/$serverId/applications/$applicationId/ssl",
            $user,
            $data,
            'PATCH'
        );

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'server_id' => $schema->string()->description('Server ID')->required(),
            'application_id' => $schema->string()->description('Application ID')->required(),
            'ssl_certificate' => $schema->string()->description('SSL certificate file contents')->required(),
            'private_key' => $schema->string()->description('Private key file contents')->required(),
            'chain_file' => $schema->string()->description('Chain file contents (optional)'),
        ];
    }
}
