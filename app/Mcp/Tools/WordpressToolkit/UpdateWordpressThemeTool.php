<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Update a specific WordPress theme.
 */
#[Description('Update a specific WordPress theme to the latest version or a specific version. Use listWordpressThemes first to get theme names. Requires WordPress Toolkit add-on.')]
class UpdateWordpressThemeTool extends Tool
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

        $theme = $request->get('theme');
        if (!$theme) {
            return Response::error('theme is required. Theme name to update.');
        }

        $data = ['theme' => $theme];

        if ($request->has('version') && $request->get('version') !== null && $request->get('version') !== '') {
            $data['version'] = $request->get('version');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/themes/update";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'theme' => $schema->string()->description('Theme name to update')->required(),
            'version' => $schema->string()->description('Specific version to install (optional, omit for latest)'),
        ];
    }
}
