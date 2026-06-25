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
        $page = $request->get('page', 1);
        
        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;
        
        $data = $this->apiCall("/organizations/$organizationId/servers?page=$page", $user);
        
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'page' => $schema->integer()->description('Page number')->default(1),
            'organization_id' => $schema->string()->description('The organization ID (required)'),
        ];
    }
}
