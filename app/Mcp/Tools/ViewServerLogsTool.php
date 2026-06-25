<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('View server logs. Use server_id to specify which server.')]
class ViewServerLogsTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        $serverId = $request->get('server_id');
        $organizationId = $request->get('organization_id');
        $log = $request->get('log');
        $lines = $request->get('lines', 100);
        
        if (!$serverId) {
            return Response::error('server_id is required.');
        }
        
        if (!$organizationId) {
            $organizationId = $this->getDefaultOrgId($user);
            if (!$organizationId) {
                return Response::error('No organizations found for this account.');
            }
        }
        
        if ($log) {
            $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/logs", $user, [
                'log' => $log,
                'lines' => $lines
            ]);
            return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        
        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/logs", $user);
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'server_id' => $schema->string()->description('The server ID'),
            'organization_id' => $schema->string()->description('The organization ID (optional - uses first org if not provided)'),
            'log' => $schema->string()->description('Log file path (e.g., apache2/error.log). If not provided, returns list of available logs.'),
            'lines' => $schema->integer()->description('Number of log lines to fetch')->default(100),
        ];
    }
}
