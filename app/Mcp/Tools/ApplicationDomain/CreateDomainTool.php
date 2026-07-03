<?php

namespace App\Mcp\Tools\ApplicationDomain;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Create a new application domain.
 * 
 * @example createApplicationDomain(organizationId: "227", serverId: "5432", applicationId: "123", domain: "example.com")
 */
#[Description('Create a new domain/subdomain for an application. Use this to add additional domains to your application. Requires organization_id, server_id, application_id, and domain name.')]
class CreateDomainTool extends Tool
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

        $domain = $request->get('domain');
        if (!$domain) {
            return Response::error('domain is required. Please provide the domain/subdomain you want to add.');
        }

        $body = ['domain' => $domain];
        $data = $this->apiCall(
            "/organizations/{$organizationId}/servers/{$serverId}/applications/{$applicationId}/application-domains",
            $user,
            $body,
            'POST'
        );

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'domain' => $schema->string()->description('The domain/subdomain to add (e.g., example.com)')->required(),
        ];
    }
}
