<?php

namespace App\Mcp\Tools\WordpressToolkit;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Run WordPress database search and replace.
 */
#[Description('Run a database-wide search and replace in WordPress. Useful after domain or URL changes. Use dry_run=true to preview changes without applying. Requires WordPress Toolkit add-on.')]
class WordpressSearchReplaceTool extends Tool
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

        $search = $request->get('search');
        if (!$search) {
            return Response::error('search is required. Text to find in the database.');
        }

        $replace = $request->get('replace');
        if ($replace === null || $replace === '') {
            return Response::error('replace is required. Replacement text.');
        }

        $data = [
            'search' => $search,
            'replace' => $replace,
        ];

        if ($request->has('dry_run') && $request->get('dry_run') !== null && $request->get('dry_run') !== '') {
            $data['dry_run'] = $request->get('dry_run');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/applications/$applicationId/wordpress-toolkit/search-replace";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'application_id' => $schema->string()->description('The application ID')->required(),
            'search' => $schema->string()->description('Text to find in the database')->required(),
            'replace' => $schema->string()->description('Replacement text')->required(),
            'dry_run' => $schema->string()->description('Set "true" to preview without applying, "false" to apply (optional)'),
        ];
    }
}
