<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Set the server restart schedule.
 * Options: daily, weekly, monthly, or specific_hour (with restart_hour 0-23 UTC).
 */
#[Description('Set the server restart schedule. Options: daily, weekly, monthly, or specific_hour (with restart_hour in UTC 0-23). Example: restart_schedule="daily" or restart_schedule="specific_hour" with restart_hour=3.')]
class SetServerRestartScheduleTool extends Tool
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

        $restartSchedule = $request->get('restart_schedule');
        $restartHour = $request->get('restart_hour');

        if ($restartHour !== null && ($restartHour < 0 || $restartHour > 23)) {
            return Response::error('restart_hour must be between 0 and 23 (UTC).');
        }

        $validSchedules = ['daily', 'weekly', 'monthly', 'specific_hour'];
        if ($restartSchedule !== null && !in_array($restartSchedule, $validSchedules)) {
            return Response::error('restart_schedule must be one of: daily, weekly, monthly, specific_hour.');
        }

        if ($restartSchedule === 'specific_hour' && $restartHour === null) {
            return Response::error('restart_hour is required when restart_schedule is specific_hour. Value 0-23 (UTC).');
        }

        $data = [];

        if ($restartSchedule !== null) {
            $data['restart_schedule'] = $restartSchedule;
        }

        if ($restartHour !== null) {
            $data['restart_hour'] = $restartHour;
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/restart-server";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'restart_schedule' => $schema->string()->description('Restart schedule type: daily, weekly, monthly, or specific_hour')->required(),
            'restart_hour' => $schema->number()->description('Hour in UTC (0-23). Required if restart_schedule is specific_hour.')->required(),
        ];
    }
}
