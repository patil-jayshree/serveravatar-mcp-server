<?php

namespace App\Mcp\Tools\Database;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('List all databases in your ServerAvatar account')]
class ListDatabasesTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        $search = $request->get('search', '');
        
        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;
        
        $endpoint = "/organizations/$organizationId/databases";
        if ($search) {
            $endpoint .= '?search=' . urlencode($search);
        }
        
        $data = $this->apiCall($endpoint, $user);
        
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'search' => $schema->string()->description('Search term for filtering databases'),
        ];
    }
}
