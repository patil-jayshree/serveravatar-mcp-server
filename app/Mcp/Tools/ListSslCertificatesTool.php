<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('List all SSL certificates in your ServerAvatar account')]
class ListSslCertificatesTool extends Tool
{
    use InteractsWithServerAvatarApi;
    
    public function handle(Request $request): Response
    {
        $user = $request->user();
        
        
        $apiKey = $user->api_key;
        $apiKey = $user->api_key;
        $organizationId = $request->get('organization_id');
        
        // If organization_id not provided, get from default org
        if (!$organizationId) {
            $organizationId = $this->getDefaultOrgId($apiKey);
            if (!$organizationId) {
                return Response::error('No organizations found for this account.');
            }
        }
        
        // Try to get SSL certificates from server applications
        $servers = $this->getServers($apiKey, $organizationId);
        $certificates = [];
        
        foreach ($servers as $server) {
            if (!isset($server['id'])) continue;
            
            // Check server's SSL certificates
            $data = $this->apiCall("/organizations/$organizationId/servers/" . $server['id'] . "/applications", $apiKey);
            if (isset($data['data']) && is_array($data['data'])) {
                foreach ($data['data'] as $app) {
                    if (isset($app['ssl']) && !empty($app['ssl'])) {
                        $certificates[] = [
                            'application_id' => $app['id'] ?? null,
                            'application_name' => $app['name'] ?? 'N/A',
                            'domain' => $app['primary_domain'] ?? 'N/A',
                            'ssl_enabled' => !empty($app['ssl']),
                            'wildcard' => $app['wildcard'] ?? false,
                        ];
                    }
                }
            }
        }
        
        if (empty($certificates)) {
            return Response::text(json_encode([
                'message' => 'No SSL-enabled applications found. SSL certificates are managed per application.',
                'ssl_enabled_applications' => $certificates
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        
        return Response::text(json_encode(['ssl_certificates' => $certificates], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID (optional - uses first org if not provided)'),
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
    
    private function getServers(string $apiKey, string $orgId): array
    {
        $data = $this->apiCall("/organizations/$orgId/servers", $apiKey);
        return $data['servers'] ?? [];
    }
}
