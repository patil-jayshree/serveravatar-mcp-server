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
        
        
        $apiKey = $user->api_key;
        $apiKey = $user->api_key;
        $serverId = $request->get('server_id');
        $organizationId = $request->get('organization_id');
        $log = $request->get('log');
        $lines = $request->get('lines', 100);
        
        if (!$serverId) {
            return Response::error('server_id is required.');
        }
        
        // If organization_id not provided, get from default org
        if (!$organizationId) {
            $organizationId = $this->getDefaultOrgId($apiKey);
            if (!$organizationId) {
                return Response::error('No organizations found for this account.');
            }
        }
        
        // If log name provided, fetch specific log content via POST
        if ($log) {
            $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/logs", $apiKey, [
                'log' => $log,
                'lines' => $lines
            ]);
            return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        
        // Otherwise, return list of available log files via GET
        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/logs", $apiKey);
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
    
    private function getDefaultOrgId(string $apiKey): ?string
    {
        $data = $this->apiCall('/organizations', $apiKey);
        if (isset($data['organizations']) && count($data['organizations']) > 0) {
            return $data['organizations'][0]['id'] ?? null;
        }
        return null;
    }
}
