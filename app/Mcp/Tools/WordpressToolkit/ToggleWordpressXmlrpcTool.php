<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Toggle WordPress XML-RPC access.
 */
#[Description('Block or allow XML-RPC access (xmlrpc.php). Use enable to block XML-RPC for security, disable to allow it. Requires WordPress Toolkit add-on.')]
class ToggleWordpressXmlrpcTool extends Tool
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
            return Response::error('action is required. Must be "enable" to block XML-RPC or "disable" to allow.');
        }

        $data = ['action' => $action];

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/xmlrpc/toggle";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'action' => $schema->string()->description('Action: "enable" to block XML-RPC, "disable" to allow')->required(),
        ];
    }
}
