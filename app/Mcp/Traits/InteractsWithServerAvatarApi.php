<?php

namespace App\Mcp\Traits;

use Illuminate\Support\Facades\Http;

trait InteractsWithServerAvatarApi
{
    private function apiCall(string $endpoint, string $apiKey, array $body = null, string $method = 'GET'): array
    {
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
}
