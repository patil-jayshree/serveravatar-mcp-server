<?php

namespace App\Mcp\Traits;

use Illuminate\Support\Facades\Http;

trait InteractsWithServerAvatarApi
{
    private function apiCall(string $endpoint, $user = null, array $body = null, string $method = 'GET'): array
    {
        $apiKey = $user->api_key;
        $baseUrl = config('services.serveravatar.api_url', 'https://api.serveravatar.com');

        try {
            $response = Http::withToken($apiKey, 'Bearer')
                ->withHeaders(['Accept' => 'application/json'])
                ->timeout(30)
                ->{strtolower($method)}($baseUrl . $endpoint, $body ?? []);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'error' => 'API request failed',
                'http_code' => $response->status(),
                'response' => $response->body(),
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

    private function getDefaultOrgId($user): ?string
    {
        $data = $this->apiCall('/organizations', $user);
        if (isset($data['organizations']) && count($data['organizations']) > 0) {
            return $data['organizations'][0]['id'] ?? null;
        }
        return null;
    }
}
