<?php

namespace App\Mcp\Tools\ApplicationDomain;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Delete an application domain.
 * 
 * @example deleteDomain(organizationId: "227", serverId: "5432", applicationId: "123", domainId: "456")
 */
#[Description('Delete an application domain. Note: Primary domain cannot be deleted. Use this to remove unwanted or unused domains from your application. Requires organization_id, server_id, application_id, and domain_id.')]
class DeleteDomainTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) {
            return $organizationId;
        }

        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) {
            return $serverId;
        }

        $applicationId = $this->getApplicationId($request);
        if ($applicationId instanceof Response) {
            return $applicationId;
        }

        $domainId = $request->get('domain_id');
        if (!$domainId) {
            return Response::error('domain_id is required. Please provide the domain ID to delete.');
        }

        $data = $this->apiCall(
            "/organizations/{$organizationId}/servers/{$serverId}/applications/{$applicationId}/application-domains/{$domainId}",
            $user,
            null,
            'DELETE'
        );

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'domain_id' => $schema->string()->description('The domain ID to delete')->required(),
        ];
    }
}
