<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Get details of a specific application (website) including PHP settings, database info, domains, and more.')]
class GetApplicationTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        
        
        $apiKey = $user->api_key;
        $apiKey = $user->api_key;
        $serverId = $request->get('server_id');
        $applicationId = $request->get('application_id');
        $organizationId = $request->get('organization_id');
        
        if (!$serverId) {
            return Response::error('server_id is required. Please provide the server ID.');
        }
        
        if (!$applicationId) {
            return Response::error('application_id is required. Please provide the application ID.');
        }
        
        if (!$organizationId) {
            return Response::error('organization_id is required. Please provide your ServerAvatar organization ID.');
        }
        
        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications/$applicationId", $apiKey);
        
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'server_id' => $schema->string()->description('The server ID (required)'),
            'application_id' => $schema->string()->description('The application ID to retrieve details for (required)'),
            'organization_id' => $schema->string()->description('The organization ID (required)'),
        ];
    }
}
