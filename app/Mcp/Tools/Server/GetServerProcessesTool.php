<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Get list of running processes on a server.
 * Shows PID, user, CPU%, memory usage, and command.
 */
#[Description('Get list of running processes on a server. Shows PID, user, CPU percentage, memory usage, and command for each process. Use this to monitor server resource usage.')]
class GetServerProcessesTool extends Tool
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

        $endpoint = "/organizations/$organizationId/servers/$serverId/processes";
        $data = $this->apiCall($endpoint, $user);

        if (isset($data['processes'])) {
            // Format processes for readability
            $formatted = [];
            foreach ($data['processes'] as $process) {
                $formatted[] = [
                    'pid' => $process['pid'] ?? 'N/A',
                    'user' => $process['user'] ?? 'N/A',
                    'cpu_percent' => $process['cpu_percent'] ?? 0,
                    'memory_mb' => $process['memory_mb'] ?? 0,
                    'command' => isset($process['command']) ? substr($process['command'], 0, 80) : 'N/A',
                ];
            }
            $data['processes'] = $formatted;
            $data['total_count'] = $data['count'] ?? count($formatted);
            unset($data['filters']);
        }

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'min_cpu' => $schema->number()->description('Filter processes with CPU usage above this percentage'),
            'min_memory' => $schema->number()->description('Filter processes with memory usage above this percentage (in MB)'),
        ];
    }
}
