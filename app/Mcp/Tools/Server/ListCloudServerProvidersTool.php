<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Get a list of connected cloud server provider accounts (AWS, DigitalOcean, Vultr, Linode, Hetzner, etc.)')]
class ListCloudServerProvidersTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;

        $provider = $request->get('provider');
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $endpoint = "/organizations/$organizationId/cloud-server-providers?pagination=1&page=$page";
        if ($provider) {
            $endpoint .= "&provider=" . urlencode($provider);
        }
        if ($search) {
            $endpoint .= "&search=" . urlencode($search);
        }

        $data = $this->apiCall($endpoint, $user);

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'provider' => $schema->string()->description('Filter by provider name (lightsail, linode, hetzner, vultr, digitalocean)'),
            'search' => $schema->string()->description('Search by email'),
            'page' => $schema->integer()->description('Page number')->default(1),
        ];
    }
}
