<?php

namespace App\Mcp\Tools\SSL;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Get complete details of an installed SSL certificate for an application. Returns certificate info including issuer, domains, issue/expiry dates, expiration status, validity period, and HTTPS force setting.')]
class GetSslCertificateTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;

        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) return $serverId;

        $applicationId = $this->getApplicationId($request);
        if ($applicationId instanceof Response) return $applicationId;

        $result = $this->apiCall(
            "/organizations/$organizationId/servers/$serverId/applications/$applicationId/ssl",
            $user
        );

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'server_id' => $schema->string()->description('Server ID')->required(),
            'application_id' => $schema->string()->description('Application ID')->required(),
        ];
    }
}
