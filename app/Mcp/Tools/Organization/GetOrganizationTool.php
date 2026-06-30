<?php

namespace App\Mcp\Tools\Organization;

use App\Http\Response;
use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response as McpResponse;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Get details of a specific organization by its ID')]
class GetOrganizationTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): McpResponse
    {
        try {
            $organizationId = $request->get('organization_id');
            $user = $request->user();

            $response = $this->apiCall(
                endpoint: "/organizations/{$organizationId}",
                user: $user,
                method: 'GET'
            );

            if ($response instanceof Response) {
                return $response->toMcpResponse();
            }

            return McpResponse::text(json_encode([
                'organization' => $response['organization'] ?? $response,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        } catch (\Exception $e) {
            return McpResponse::text(json_encode([
                'error' => 'Failed to fetch organization: ' . $e->getMessage(),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Unique identifier of the organization to retrieve')->required(),
        ];
    }
}
