<?php

namespace App\Mcp\Tools\Application\Node;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Retrieve PM2 log for a specific SSR Node application on a Node Stack server. Parameters: file (error/out), selectTailLines (optional), numberOfTailLines (optional, min 1).')]
class GetPm2LogTool extends Tool
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

        $validated = $request->validate([
            'file' => ['required', Rule::in(['error', 'out'])],
            'selectTailLines' => ['boolean'],
            'numberOfTailLines' => ['required_if:selectTailLines,true', 'integer', 'min:1'],
        ]);

        $queryParams = [
            'file' => $validated['file'],
        ];

        if (!empty($validated['selectTailLines'])) {
            $queryParams['selectTailLines'] = 'true';
            $queryParams['numberOfTailLines'] = $validated['numberOfTailLines'];
        }

        $data = [
            'file' => $validated['file'],
        ];

        if (!empty($validated['selectTailLines'])) {
            $data['selectTailLines'] = true;
            $data['numberOfTailLines'] = $validated['numberOfTailLines'];
        }

        $result = $this->apiCall(
            "/organizations/$organizationId/servers/$serverId/applications/$applicationId/node-deployment/pm2-log",
            $user,
            $data,
            'POST'
        );

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'server_id' => $schema->string()->description('Server ID')->required(),
            'application_id' => $schema->string()->description('Application ID')->required(),
            'file' => $schema->string()->description('Log file name: error or out')->required(),
            'selectTailLines' => $schema->boolean()->description('Whether to select tail lines (optional)'),
            'numberOfTailLines' => $schema->integer()->description('Number of tail lines to retrieve (required if selectTailLines is true, min 1)'),
        ];
    }
}
