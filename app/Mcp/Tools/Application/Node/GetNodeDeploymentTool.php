<?php

namespace App\Mcp\Tools\Application\Node;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Retrieve details for a Node.js application deployment on a Node Stack server. Returns deployment info including rendering type, build command, start command, port, environment variables, and Nginx config.')]
class GetNodeDeploymentTool extends Tool
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

        $result = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications/$applicationId/node-deployment", $user);

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'server_id' => $schema->string()->description('Server ID')->required(),
            'application_id' => $schema->string()->description('Application ID')->required(),
        ];
    }
}
