<?php

namespace App\Mcp\Tools\ApplicationDomain;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Change the primary domain of an application.
 * 
 * @example changePrimaryDomain(organizationId: "227", serverId: "5432", applicationId: "123", domainId: "456", isWordpressUrlUpdate: true)
 */
#[Description('Change the primary domain of an application. Use this to set a different domain as the main domain for your application. Requires organization_id, server_id, application_id, domain_id, and is_wordpress_url_update.')]
class ChangePrimaryDomainTool extends Tool
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
            return Response::error('domain_id is required. Please provide the domain ID to set as primary.');
        }

        $isWordpressUrlUpdate = $request->get('is_wordpress_url_update');
        if ($isWordpressUrlUpdate === null) {
            return Response::error('is_wordpress_url_update is required. Set to true if application is WordPress.');
        }

        $forceHttps = $request->get('force_https', false);

        $body = [
            'is_wordpress_url_update' => $isWordpressUrlUpdate,
            'forceHttps' => $forceHttps,
        ];

        $data = $this->apiCall(
            "/organizations/{$organizationId}/servers/{$serverId}/applications/{$applicationId}/application-domains/{$domainId}",
            $user,
            $body,
            'PATCH'
        );

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'domain_id' => $schema->string()->description('The domain ID to set as primary')->required(),
            'is_wordpress_url_update' => $schema->boolean()->description('Set to true if application is WordPress')->required(),
            'force_https' => $schema->boolean()->description('Force HTTPS for WordPress URL update'),
        ];
    }
}
