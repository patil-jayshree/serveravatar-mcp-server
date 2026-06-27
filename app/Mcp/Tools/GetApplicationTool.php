<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Get details of a specific application (website) including PHP settings, database info, domains, and more.')]
class GetApplicationTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        
        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;
        
        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) return $serverId;
        
        $applicationId = $request->get('application_id');
        if (!$applicationId) {
            return Response::error('application_id is required.');
        }
        
        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications/$applicationId", $user);
        
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'server_id' => $schema->string()->description('The server ID'),
            'application_id' => $schema->string()->description('The application ID to retrieve details for (required)'),
            'organization_id' => $schema->string()->description('The organization ID (required)'),
        ];
    }
}
