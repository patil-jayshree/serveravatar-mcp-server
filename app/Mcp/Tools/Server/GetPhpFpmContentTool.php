<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Get PHP-FPM configuration content for a specific PHP version.
 * Retrieves the PHP-FPM pool configuration (www.conf or similar).
 */
#[Description('Read PHP-FPM configuration file content for a specific PHP version. Returns the raw PHP-FPM pool configuration (www.conf). Service examples: php7.4-fpm, php8.2-fpm, php8.3-fpm.')]
class GetPhpFpmContentTool extends Tool
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

        $service = $request->get('service');
        if (!$service) {
            return Response::error('service is required. Examples: php7.4-fpm, php8.2-fpm, php8.3-fpm');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/services/php-fpm";
        $data = $this->apiCall($endpoint, $user, [
            'service' => $service,
        ], 'POST');

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'service' => $schema->string()->description('PHP-FPM service: php7.0-fpm to php8.5-fpm (e.g., php8.3-fpm)')->required(),
        ];
    }
}
