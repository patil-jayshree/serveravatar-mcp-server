<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Get regions for a connected cloud server provider. Use cloud_server_provider_id from list-cloud-server-providers tool. For Lightsail providers, also fetches availability zones.')]
class ListCloudProviderRegionsTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;

        $cloudServerProviderId = $request->get('cloud_server_provider_id');
        if (!$cloudServerProviderId) {
            return Response::error('cloud_server_provider_id is required.');
        }

        // Fetch regions
        $endpoint = "/organizations/$organizationId/cloud-server-providers/$cloudServerProviderId/regions";
        $data = $this->apiCall($endpoint, $user);

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'cloud_server_provider_id' => $schema->integer()->description('Cloud server provider ID (from list-cloud-server-providers)')->required(),
        ];
    }
}
