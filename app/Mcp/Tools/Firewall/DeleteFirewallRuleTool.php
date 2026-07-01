<?php

namespace App\Mcp\Tools\Firewall;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

/**
 * Delete a firewall rule from a server.
 */
#[Description('Delete a firewall rule from a server. Requires the firewall rule ID (obtained from listFirewallRules). Note: some system ports cannot be closed.')]
class DeleteFirewallRuleTool extends Tool
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

        $firewallRuleId = $request->get('firewall_rule_id');
        if (!$firewallRuleId) {
            return Response::error('firewall_rule_id is required. Use listFirewallRules to get the rule ID.');
        }

        $endpoint = "/organizations/$organizationId/servers/$serverId/firewall-rules/$firewallRuleId";
        $result = $this->apiCall($endpoint, $user, [], 'DELETE');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('The organization ID')->required(),
            'server_id' => $schema->string()->description('The server ID')->required(),
            'firewall_rule_id' => $schema->number()->description('The firewall rule ID to delete (from listFirewallRules)')->required(),
        ];
    }
}
