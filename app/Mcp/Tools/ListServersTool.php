<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('List all servers in your ServerAvatar account')]
class ListServersTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        
        
        $apiKey = $user->api_key;
        $apiKey = $user->api_key;
        $page = $request->get('page', 1);
        $organizationId = $request->get('organization_id');
        
        // If organization_id not provided, get from default org
        if (!$organizationId) {
            $organizationId = $this->getDefaultOrgId($apiKey);
            if (!$organizationId) {
                return Response::error('No organizations found for this account.');
            }
        }
        
        $data = $this->apiCall("/organizations/$organizationId/servers?page=$page", $apiKey);
        
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'page' => $schema->integer()->description('Page number')->default(1),
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
