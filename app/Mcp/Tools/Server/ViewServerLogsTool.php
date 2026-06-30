<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('View server logs. If log is provided, fetches that log file. If log is omitted, returns list of available log files.')]
class ViewServerLogsTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        
        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;
        
        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) return $serverId;
        
        $log = $request->get('log');
        
        // If no log specified, return list of available log files
        if (!$log) {
            $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/logs", $user);
            return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        
        // Fetch specific log file
        $selectTailLines = $request->get('select_tail_lines', true);
        $numberOfTailLines = $request->get('number_of_tail_lines', 100);
        
        $data = $this->apiCall("/organizations/$organizationId/servers/$serverId/logs", $user, [
            'log' => $log,
            'selectTailLines' => $selectTailLines,
            'numberOfTailLines' => $numberOfTailLines,
        ]);
        
        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'log' => $schema->string()->description('Log file path e.g. apache2/error.log. If omitted, returns list of available log files.'),
            'select_tail_lines' => $schema->boolean()->description('Set true to fetch latest log lines. Default: true')->default(true),
            'number_of_tail_lines' => $schema->integer()->description('Number of log lines to fetch. Default: 100')->default(100),
        ];
    }
}
