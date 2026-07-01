<?php

namespace App\Mcp\Tools\Firewall;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Create a new firewall rule for a server.
 */
#[Description('Create a new firewall rule for a server. Params: start_port (required, 1-65534), end_port (optional, range), traffic (allow/deny), protocol (all/tcp/udp), ip (optional IPv4), description (optional).')]
class CreateFirewallRuleTool extends Tool
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

        $startPort = $request->get('start_port');
        if ($startPort === null || $startPort === '') {
            return Response::error('start_port is required. Port number between 1 to 65534.');
        }

        $traffic = $request->get('traffic');
        if (!$traffic) {
            return Response::error('traffic is required. Use "allow" or "deny".');
        }

        $protocol = $request->get('protocol');
        if (!$protocol) {
            return Response::error('protocol is required. Use "all", "tcp", or "udp".');
        }

        $validTraffic = ['allow', 'deny'];
        if (!in_array($traffic, $validTraffic)) {
            return Response::error('traffic must be either "allow" or "deny".');
        }

        $validProtocols = ['all', 'tcp', 'udp'];
        if (!in_array($protocol, $validProtocols)) {
            return Response::error('protocol must be one of: all, tcp, udp.');
        }

        $data = [
            'start_port' => $startPort,
            'traffic' => $traffic,
            'protocol' => $protocol,
        ];

        if ($request->has('end_port') && $request->get('end_port') !== null && $request->get('end_port') !== '') {
            $data['end_port'] = $request->get('end_port');
        }

        if ($request->has('ip') && $request->get('ip') !== null && $request->get('ip') !== '') {
            $data['ip'] = $request->get('ip');
        }

        if ($request->has('description') && $request->get('description') !== null && $request->get('description') !== '') {
            $data['description'] = $request->get('description');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/firewall-rules";
        $result = $this->apiCall($endpoint, $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'start_port' => $schema->number()->description('Start port (1-65534)')->required(),
            'end_port' => $schema->number()->description('End port for range (1-65534, optional)'),
            'traffic' => $schema->string()->description('Traffic type: "allow" or "deny"')->required(),
            'protocol' => $schema->string()->description('Protocol: "all", "tcp", or "udp"')->required(),
            'ip' => $schema->string()->description('IPv4 address (optional)'),
            'description' => $schema->string()->description('Brief description of the rule (optional)'),
        ];
    }
}
