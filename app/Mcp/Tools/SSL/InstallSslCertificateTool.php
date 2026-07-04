<?php

namespace App\Mcp\Tools\SSL;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description("Install SSL certificate on an application. Use ssl_type \"automatic\" for free Let's Encrypt cert, or \"custom\" for your own certificate. Updates SSL if adding new domain to existing cert.")]
class InstallSslCertificateTool extends Tool
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
            'ssl_type' => ['required', Rule::in(['automatic', 'custom'])],
            'ssl_certificate' => ['required_if:ssl_type,custom'],
            'private_key' => ['required_if:ssl_type,custom'],
            'chain_file' => ['nullable'],
            'force_https' => ['required', 'boolean'],
        ]);

        $data = [
            'ssl_type' => $validated['ssl_type'],
            'force_https' => $validated['force_https'],
        ];

        if ($validated['ssl_type'] === 'custom') {
            $data['ssl_certificate'] = $validated['ssl_certificate'];
            $data['private_key'] = $validated['private_key'];
            if (!empty($validated['chain_file'])) {
                $data['chain_file'] = $validated['chain_file'];
            }
        }

        $result = $this->apiCall(
            "/organizations/$organizationId/servers/$serverId/applications/$applicationId/ssl",
            $user,
            $data,
            'POST'
        );

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'server_id' => $schema->string()->description('Server ID')->required(),
            'application_id' => $schema->string()->description('Application ID')->required(),
            'ssl_type' => $schema->string()->description('SSL type: automatic (Let\'s Encrypt) or custom')->required(),
            'ssl_certificate' => $schema->string()->description('SSL certificate file contents (required for custom ssl_type)'),
            'private_key' => $schema->string()->description('Private key file contents (required for custom ssl_type)'),
            'chain_file' => $schema->string()->description('Chain file contents (optional for custom ssl_type)'),
            'force_https' => $schema->boolean()->description('Force HTTPS redirect')->required(),
        ];
    }
}
