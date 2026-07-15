<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Toggle PHP execution in WordPress uploads directory.
 */
#[Description('Block or allow PHP execution in wp-content/uploads directory. Use enable to block PHP for security, disable to allow. Requires WordPress Toolkit add-on.')]
class ToggleWordpressPhpExecutionTool extends Tool
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

        $action = $request->get('action');
        if (!$action || !in_array($action, ['enable', 'disable'])) {
            return Response::error('action is required. Must be "enable" to block PHP in uploads or "disable" to allow.');
        }

        $data = ['action' => $action];

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/php-execution-upload-directory/toggle";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'action' => $schema->string()->description('Action: "enable" to block PHP in uploads, "disable" to allow')->required(),
        ];
    }
}
