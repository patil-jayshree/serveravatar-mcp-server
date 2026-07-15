<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Enable Object Cache Pro for WordPress.
 */
#[Description('Enable Redis object caching with Object Cache Pro for WordPress. Requires a valid Object Cache Pro license key (max 500 characters). Redis must be installed on the server. Requires WordPress Toolkit add-on.')]
class EnableWordpressObjectCacheProTool extends Tool
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

        $licenseKey = $request->get('license_key');
        if (!$licenseKey) {
            return Response::error('license_key is required. Object Cache Pro license key from your account (max 500 characters).');
        }

        $data = ['license_key' => $licenseKey];

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/object-cache-pro/enable";
        $result = $this->apiCall($endpoint, $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'license_key' => $schema->string()->description('Object Cache Pro license key from your account (max 500 characters)')->required(),
        ];
    }
}
