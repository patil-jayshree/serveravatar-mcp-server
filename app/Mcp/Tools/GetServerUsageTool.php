<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Get CPU, Memory, and Disk usage for a server')]
class GetServerUsageTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        
        
        $apiKey = $user->api_key;
        $apiKey = $user->api_key;
        $serverId = $request->get('server_id');
        $organizationId = $request->get('organization_id');
        
        if (!$serverId) {
            return Response::error('server_id is required.');
        }
        
        // If organization_id not provided, get the default/first organization
        if (!$organizationId) {
            $orgId = $this->getDefaultOrgId($apiKey);
            if (!$orgId) {
                return Response::error('No organizations found for this account.');
            }
            $organizationId = $orgId;
        }
        
        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/usage", $apiKey);
        
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'server_id' => $schema->string()->description('The server ID'),
            'organization_id' => $schema->string()->description('The organization ID (optional - uses first org if not provided)'),
        ];
    }
    
    private function getDefaultOrgId(string $apiKey): ?string
    {
        $data = $this->apiCall('/organizations', $apiKey);
        if (isset($data['organizations']) && count($data['organizations']) > 0) {
            return $data['organizations'][0]['id'] ?? null;
        }
        return null;
    }
}
