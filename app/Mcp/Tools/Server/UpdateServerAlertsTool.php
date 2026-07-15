<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Update server alerts configuration.
 */
#[Description('Update server alerts configuration including server load, memory usage, and disk usage thresholds. For Pro servers, also set server_load_five_minute and server_load_fifteen_minute.')]
class UpdateServerAlertsTool extends Tool
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

        $serverLoad = $request->get('server_load');
        if ($serverLoad === null || $serverLoad === '') {
            return Response::error('server_load is required. Numeric threshold for server load alert.');
        }

        $memoryUsage = $request->get('memory_usage');
        if ($memoryUsage === null || $memoryUsage === '') {
            return Response::error('memory_usage is required. Numeric threshold for memory usage alert (percentage).');
        }

        $diskUsage = $request->get('disk_usage');
        if ($diskUsage === null || $diskUsage === '') {
            return Response::error('disk_usage is required. Numeric threshold for disk usage alert (percentage).');
        }

        $data = [
            'server_load' => $serverLoad,
            'memory_usage' => $memoryUsage,
            'disk_usage' => $diskUsage,
        ];

        // Optional: Pro server additional thresholds
        if ($request->has('server_load_five_minute') && $request->get('server_load_five_minute') !== null && $request->get('server_load_five_minute') !== '') {
            $data['server_load_five_minute'] = $request->get('server_load_five_minute');
        }

        if ($request->has('server_load_fifteen_minute') && $request->get('server_load_fifteen_minute') !== null && $request->get('server_load_fifteen_minute') !== '') {
            $data['server_load_fifteen_minute'] = $request->get('server_load_fifteen_minute');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/alert";
        $result = $this->apiCall($endpoint, $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'server_load' => $schema->number()->description('Server load threshold for alert')->required(),
            'memory_usage' => $schema->number()->description('Memory usage threshold for alert (percentage)')->required(),
            'disk_usage' => $schema->number()->description('Disk usage threshold for alert (percentage)')->required(),
            'server_load_five_minute' => $schema->number()->description('5-minute load average threshold (required for Pro servers)'),
            'server_load_fifteen_minute' => $schema->number()->description('15-minute load average threshold (required for Pro servers)'),
        ];
    }
}
