<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Set WordPress cron mode.
 */
#[Description('Switch between WordPress built-in cron and server-side cron job. server_cron creates a cronjob running wp-cron.php every 5 minutes. Requires WordPress Toolkit add-on.')]
class SetWordpressCronModeTool extends Tool
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

        $mode = $request->get('mode');
        if (!$mode || !in_array($mode, ['wp_cron', 'server_cron'])) {
            return Response::error('mode is required. Must be "wp_cron" (use WordPress built-in) or "server_cron" (use server cronjob every 5 min).');
        }

        $data = ['mode' => $mode];

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/wp-cron/mode";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'mode' => $schema->string()->description('Cron mode: "wp_cron" for WordPress built-in, "server_cron" for server cronjob every 5 min')->required(),
        ];
    }
}
