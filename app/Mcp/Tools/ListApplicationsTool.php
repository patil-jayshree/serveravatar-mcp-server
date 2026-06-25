<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('List all applications (websites) on a server. Use this to view all websites or web applications hosted on a specific server.')]
class ListApplicationsTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        
        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;
        
        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) return $serverId;
        
        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications", $user);
        
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'server_id' => $schema->string()->description('The server ID'),
            'organization_id' => $schema->string()->description('The organization ID (required)'),
        ];
    }
}
