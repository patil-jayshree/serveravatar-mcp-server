<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('List all applications (websites) across all servers in an organization. Use this to view all websites hosted in your ServerAvatar organization.')]
class ListOrganizationApplicationsTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        
        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;
        
        $data = $this->apiCall("/organizations/$organizationId/applications", $user);
        
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
        ];
    }
}
