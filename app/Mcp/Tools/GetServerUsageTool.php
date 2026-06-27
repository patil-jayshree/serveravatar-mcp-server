<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Get CPU, Memory, and Disk usage for a server')]
class GetServerUsageTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        
        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;
        
        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) return $serverId;
        
        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/usage", $user);
        
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
