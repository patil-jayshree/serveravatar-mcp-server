<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Http;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Remove a server from ServerAvatar. Use delete_from_provider=true to also delete from the cloud provider.')]
class DeleteServerTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $organizationId = $this->getOrganizationId($request);
        if ($organizationId instanceof Response) return $organizationId;

        $serverId = $this->getServerId($request);
        if ($serverId instanceof Response) return $serverId;

        $deleteFromProvider = $request->get('delete_from_provider', false);

        $apiKey = $user->api_key;
        $baseUrl = config('services.serveravatar.api_url', 'https://api.serveravatar.com');
        $endpoint = "/organizations/$organizationId/servers/$serverId";

        if ($deleteFromProvider) {
            $endpoint .= '?deleteFromProvider=1';
        }

        try {
            $response = Http::withToken($apiKey, 'Bearer')
                ->withHeaders(['Accept' => 'application/json'])
                ->timeout(30)
                ->delete($baseUrl . $endpoint);

            if ($response->successful()) {
                $data = $response->json();
            } else {
                $data = [
                    'error' => 'API request failed',
                    'http_code' => $response->status(),
                    'body' => $response->body(),
                ];
            }
        } catch (\Exception $e) {
            $data = [
                'error' => 'HTTP request failed',
                'exception' => $e->getMessage(),
            ];
        }

        return Response::text(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'server_id' => $schema->string()->description('Server ID')->required(),
            'delete_from_provider' => $schema->boolean()->description('Set true to also delete server from cloud provider (AWS, DO, Vultr, etc.)')->default(false),
        ];
    }
}
