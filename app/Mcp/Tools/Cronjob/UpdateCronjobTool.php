<?php

namespace App\Mcp\Tools\Cronjob;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Update an existing cronjob on a server.
 */
#[Description('Update an existing cronjob on a server. Required: command, schedule, system_user. For custom schedule: minute, hour, month, day_of_week, day_of_month.')]
class UpdateCronjobTool extends Tool
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

        $cronjobId = $request->get('cronjob_id');
        if (!$cronjobId) {
            return Response::error('cronjob_id is required. Use listCronjobs to get the cronjob ID.');
        }

        $command = $request->get('command');
        if (!$command) {
            return Response::error('command is required. The command to execute.');
        }

        $schedule = $request->get('schedule');
        if (!$schedule) {
            return Response::error('schedule is required. Use preset or "custom".');
        }

        $systemUser = $request->get('system_user');
        if (!$systemUser) {
            return Response::error('system_user is required. The application user for the cronjob.');
        }

        $data = [
            'command' => $command,
            'schedule' => $schedule,
            'system_user' => $systemUser,
        ];

        if ($schedule === 'custom') {
            if ($request->has('minute')) {
                $data['minute'] = $request->get('minute');
            }
            if ($request->has('hour')) {
                $data['hour'] = $request->get('hour');
            }
            if ($request->has('month')) {
                $data['month'] = $request->get('month');
            }
            if ($request->has('day_of_week')) {
                $data['day_of_week'] = $request->get('day_of_week');
            }
            if ($request->has('day_of_month')) {
                $data['day_of_month'] = $request->get('day_of_month');
            }
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/cronjobs/$cronjobId";
        $result = $this->apiCall($endpoint, $user, $data, 'PATCH');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'cronjob_id' => $schema->number()->description('The cronjob ID to update (from listCronjobs)')->required(),
            'command' => $schema->string()->description('The command to execute')->required(),
            'schedule' => $schema->string()->description('Schedule preset or "custom"')->required(),
            'system_user' => $schema->string()->description('The application user for the cronjob')->required(),
            'minute' => $schema->number()->description('Minute (0-59) - use if schedule is custom'),
            'hour' => $schema->number()->description('Hour (0-23) - use if schedule is custom'),
            'month' => $schema->number()->description('Month (1-12) - use if schedule is custom'),
            'day_of_week' => $schema->number()->description('Day of week (0-6) - use if schedule is custom'),
            'day_of_month' => $schema->number()->description('Day of month (1-31) - use if schedule is custom'),
        ];
    }
}
