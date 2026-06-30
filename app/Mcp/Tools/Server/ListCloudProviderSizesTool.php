<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Get available server instance sizes for a cloud provider and region. Returns size options with RAM, CPU, disk, and pricing.')]
class ListCloudProviderSizesTool extends Tool
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

        $region = $request->get('region');
        if (!$region) {
            return Response::error('region is required.');
        }

        $endpoint = "/organizations/$organizationId/cloud-server-providers/$cloudServerProviderId/sizes?region=" . urlencode($region);

        $data = $this->apiCall($endpoint, $user);

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'cloud_server_provider_id' => $schema->integer()->description('Cloud server provider ID (from list-cloud-server-providers)')->required(),
            'region' => $schema->string()->description('Region slug (from list-cloud-provider-regions)')->required(),
        ];
    }
}
