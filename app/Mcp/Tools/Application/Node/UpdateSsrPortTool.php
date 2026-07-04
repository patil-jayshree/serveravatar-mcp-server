<?php

namespace App\Mcp\Tools\Application\Node;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Update SSR port on a Node Stack server. Port must be available on the server.')]
class UpdateSsrPortTool extends Tool
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
            'port' => ['required', 'numeric', 'min:1', 'max:65535'],
        ]);

        $data = [
            'port' => $validated['port'],
        ];

        $result = $this->apiCall(
            "/organizations/$organizationId/servers/$serverId/applications/$applicationId/node-deployment/ssr-port",
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
            'port' => $schema->integer()->description('Port number (1-65535)')->required(),
        ];
    }
}
