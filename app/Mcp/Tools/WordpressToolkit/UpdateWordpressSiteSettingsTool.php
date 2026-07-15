<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Update WordPress site settings.
 */
#[Description('Update WordPress general settings: language, timezone, date/time formats, permalink structure, search engine visibility, and memory limits. At least one setting required. Requires WordPress Toolkit add-on.')]
class UpdateWordpressSiteSettingsTool extends Tool
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

        $applicationId = $this->getApplicationId($request);
        if ($applicationId instanceof Response) {
            return $applicationId;
        }

        $data = [];

        // Required settings
        if ($request->has('site_language') && $request->get('site_language') !== null && $request->get('site_language') !== '') {
            $data['site_language'] = $request->get('site_language');
        }
        if ($request->has('timezone') && $request->get('timezone') !== null && $request->get('timezone') !== '') {
            $data['timezone'] = $request->get('timezone');
        }
        if ($request->has('date_format') && $request->get('date_format') !== null && $request->get('date_format') !== '') {
            $data['date_format'] = $request->get('date_format');
        }
        if ($request->has('time_format') && $request->get('time_format') !== null && $request->get('time_format') !== '') {
            $data['time_format'] = $request->get('time_format');
        }

        // Optional settings
        if ($request->has('permalink_structure') && $request->get('permalink_structure') !== null && $request->get('permalink_structure') !== '') {
            $data['permalink_structure'] = $request->get('permalink_structure');
        }
        if ($request->has('search_engine_visibility') && $request->get('search_engine_visibility') !== null && $request->get('search_engine_visibility') !== '') {
            $data['search_engine_visibility'] = $request->get('search_engine_visibility');
        }
        if ($request->has('wp_memory_limit') && $request->get('wp_memory_limit') !== null && $request->get('wp_memory_limit') !== '') {
            $data['wp_memory_limit'] = $request->get('wp_memory_limit');
        }
        if ($request->has('wp_max_memory_limit') && $request->get('wp_max_memory_limit') !== null && $request->get('wp_max_memory_limit') !== '') {
            $data['wp_max_memory_limit'] = $request->get('wp_max_memory_limit');
        }

        if (empty($data)) {
            return Response::error('At least one setting is required: site_language, timezone, date_format, time_format, permalink_structure, search_engine_visibility, wp_memory_limit, wp_max_memory_limit.');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/site-settings";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'site_language' => $schema->string()->description('WordPress locale (e.g. en_US)')->required(),
            'timezone' => $schema->string()->description('PHP timezone string (e.g. America/New_York)')->required(),
            'date_format' => $schema->string()->description('WordPress date format')->required(),
            'time_format' => $schema->string()->description('WordPress time format')->required(),
            'permalink_structure' => $schema->string()->description('Permalink structure (e.g. /%postname%/) (optional)'),
            'search_engine_visibility' => $schema->string()->description('"true" to discourage search engines, "false" to allow (optional)'),
            'wp_memory_limit' => $schema->string()->description('WordPress memory limit (e.g. 256M, 1G) (optional)'),
            'wp_max_memory_limit' => $schema->string()->description('WordPress max memory limit (e.g. 512M, 1G) (optional)'),
        ];
    }
}
