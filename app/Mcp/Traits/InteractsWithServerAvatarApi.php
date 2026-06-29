<?php

namespace App\Mcp\Traits;

use Illuminate\Support\Facades\Http;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;

trait InteractsWithServerAvatarApi
{
    private function apiCall(string $endpoint, $user = null, array $body = null, string $method = 'GET', int $timeout = 300): array
    {
        $apiKey = $user->api_key;
        $baseUrl = config('services.serveravatar.api_url', 'https://api.serveravatar.com');

        try {
            $response = Http::withToken($apiKey, 'Bearer')
                ->withHeaders(['Accept' => 'application/json'])
                ->timeout($timeout)
                ->{strtolower($method)}($baseUrl . $endpoint, $body ?? []);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'error' => 'API request failed: ' . $response->body(),
                'http_code' => $response->status(),
                'endpoint' => $baseUrl . $endpoint
            ];
        } catch (\Exception $e) {
            return [
                'error' => 'HTTP request failed',
                'exception' => $e->getMessage(),
                'endpoint' => $baseUrl . $endpoint
            ];
        }
    }

    private function getOrganizationId(Request $request): string|Response
    {
        $orgId = $request->get('organization_id');
        if (!$orgId) {
            return Response::error('organization_id is required. Please provide your ServerAvatar organization ID.');
        }
        return $orgId;
    }

    private function getServerId(Request $request): string|Response
    {
        $serverId = $request->get('server_id');
        if (!$serverId) {
            return Response::error('server_id is required.');
        }
        return $serverId;
    }
}
