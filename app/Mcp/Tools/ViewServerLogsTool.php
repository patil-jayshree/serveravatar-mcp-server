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
        $log = $request->get('log');
        $lines = $request->get('lines', 100);
        
        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;
        
        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) return $serverId;
        
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
            'organization_id' => $schema->string()->description('The organization ID (required)'),
            'log' => $schema->string()->description('Log file path (e.g., apache2/error.log). If not provided, returns list of available logs.'),
            'lines' => $schema->integer()->description('Number of log lines to fetch')->default(100),
        ];
    }
}
