<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Get details of a specific database')]
class GetDatabaseTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        $databaseId = $request->get('database_id');
        $organizationId = $request->get('organization_id');
        
        if (!$databaseId) {
            return Response::error('database_id is required.');
        }
        
        if (!$organizationId) {
            $orgs = $this->apiCall('/organizations', $user);
            if (isset($orgs['organizations'])) {
                foreach ($orgs['organizations'] as $org) {
                    $result = $this->findDatabaseInOrg($org['id'], $databaseId, $user);
                    if ($result) {
                        return Response::text(json_encode(['database' => $result], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                    }
                }
            }
            return Response::error("Database with ID $databaseId not found.");
        }
        
        $result = $this->findDatabaseInOrg($organizationId, $databaseId, $user);
        if ($result) {
            return Response::text(json_encode(['database' => $result], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        
        return Response::error("Database with ID $databaseId not found in organization $organizationId.");
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'database_id' => $schema->string()->description('The database ID'),
            'organization_id' => $schema->string()->description('The organization ID (optional - searches all orgs if not provided)'),
        ];
    }
    
    private function findDatabaseInOrg(string $orgId, string $databaseId, $user): ?array
    {
        $data = $this->apiCall("/organizations/$orgId/databases", $user);
        if (isset($data['databases'])) {
            foreach ($data['databases'] as $db) {
                if ($db['id'] == $databaseId) {
                    return $db;
                }
            }
        }
        return null;
    }
}
