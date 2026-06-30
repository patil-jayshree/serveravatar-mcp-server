<?php

namespace App\Mcp\Tools\Server;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Create a new server. Two types: Direct (with root password) and Provider (AWS, DigitalOcean, Vultr, Linode, Hetzner). Use provider parameter to switch between them.

DIRECT: Set provider=null or omit. Required: name, web_server, database_type, nodejs, root_password_available=true, ip, ssh_port, root_password.

PROVIDER: Set provider to lightsail, linode, hetzner, vultr, or digitalocean. Required: name, provider, cloud_server_provider_id, version, region, size_slug, ssh_key, web_server, database_type, nodejs.

WEB_SERVER values: apache2, nginx, openlitespeed, mern
DATABASE_TYPE values: mysql, mariadb, mongodb
PROVIDER values: lightsail, linode, hetzner, vultr, digitalocean')]
class CreateServerTool extends Tool
{
    use InteractsWithServerAvatarApi;

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            'organization_id' => ['required'],
            'name' => ['required'],
            'web_server' => ['required', Rule::in(['apache2', 'nginx', 'openlitespeed', 'mern'])],
            'database_type' => ['required', Rule::in(['mysql', 'mariadb', 'mongodb'])],
            'nodejs' => ['required', 'boolean'],
            'provider' => ['nullable', Rule::in(['lightsail', 'linode', 'hetzner', 'vultr', 'digitalocean'])],
            
            // Direct installation
            'root_password_available' => ['required_without:provider', 'boolean'],
            'ip' => ['required_if:root_password_available,true'],
            'ssh_port' => ['numeric'],
            'root_password' => ['required_if:root_password_available,true'],
            'force_cleanup' => ['boolean'],
            
            // Provider
            'cloud_server_provider_id' => ['required_if:provider,lightsail,linode,hetzner,vultr,digitalocean'],
            'version' => ['required_if:provider,lightsail,linode,hetzner,vultr,digitalocean'],
            'region' => ['required_if:provider,lightsail,linode,hetzner,vultr,digitalocean'],
            'size_slug' => ['required_if:provider,lightsail,linode,hetzner,vultr,digitalocean'],
            'ssh_key' => ['required_if:provider,lightsail,linode,hetzner,vultr,digitalocean', 'boolean'],
            'availability_zone' => ['required_if:provider,lightsail'],
            'public_key' => ['required_if:ssh_key,true'],
            'yarn' => ['boolean'],
            'linode_root_password' => [],
        ]);

        $organizationId = $validated['organization_id'];

        $data = [
            'name' => $validated['name'],
            'web_server' => $validated['web_server'],
            'database_type' => $validated['database_type'],
            'nodejs' => $validated['nodejs'],
        ];

        $provider = $validated['provider'] ?? null;

        if (!$provider) {
            // Direct installation
            $data['root_password_available'] = $validated['root_password_available'];
            if (!empty($validated['ip'])) $data['ip'] = $validated['ip'];
            if (!empty($validated['ssh_port'])) $data['ssh_port'] = (int) $validated['ssh_port'];
            if (!empty($validated['root_password'])) $data['root_password'] = $validated['root_password'];
            if (!empty($validated['force_cleanup'])) $data['force_cleanup'] = $validated['force_cleanup'];
        } else {
            // Provider installation
            $data['provider'] = $provider;
            $data['cloud_server_provider_id'] = $validated['cloud_server_provider_id'];
            $data['version'] = $validated['version'];
            $data['region'] = $validated['region'];
            $data['sizeSlug'] = $validated['size_slug'];
            $data['ssh_key'] = $validated['ssh_key'];

            if (!empty($validated['availability_zone'])) {
                $data['availabilityZone'] = $validated['availability_zone'];
            }
            if (!empty($validated['public_key'])) {
                $data['public_key'] = $validated['public_key'];
            }
            if (!empty($validated['yarn'])) {
                $data['yarn'] = $validated['yarn'];
            }
            if (!empty($validated['linode_root_password'])) {
                $data['linode_root_password'] = $validated['linode_root_password'];
            }
        }

        $result = $this->apiCall("/organizations/$organizationId/servers", $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'name' => $schema->string()->description('Server name')->required(),
            'web_server' => $schema->string()->description('Web server: apache2, nginx, openlitespeed, mern')->required(),
            'database_type' => $schema->string()->description('Database type: mysql, mariadb, mongodb')->required(),
            'nodejs' => $schema->boolean()->description('Install Node.js?')->required(),
            'provider' => $schema->string()->description('Provider: lightsail, linode, hetzner, vultr, digitalocean. Omit for direct installation'),

            // Direct installation fields
            'root_password_available' => $schema->boolean()->description('[DIRECT] Set true if you have root and password'),
            'ip' => $schema->string()->description('[DIRECT] Server IP address (required for direct)'),
            'ssh_port' => $schema->integer()->description('[DIRECT] SSH port number'),
            'root_password' => $schema->string()->description('[DIRECT] Root password'),
            'force_cleanup' => $schema->boolean()->description('[DIRECT] Set true for clean up'),

            // Provider fields
            'cloud_server_provider_id' => $schema->integer()->description('[PROVIDER] Cloud provider account ID'),
            'version' => $schema->string()->description('[PROVIDER] OS version: 20, 22, 24'),
            'region' => $schema->string()->description('[PROVIDER] Region slug'),
            'size_slug' => $schema->string()->description('[PROVIDER] Size slug (numeric for Hetzner)'),
            'ssh_key' => $schema->boolean()->description('[PROVIDER] Set true if using your own SSH key'),
            'availability_zone' => $schema->string()->description('[PROVIDER:LIGHTSAIL] Availability zone'),
            'public_key' => $schema->string()->description('[PROVIDER] SSH public key content (required if ssh_key=true)'),
            'yarn' => $schema->boolean()->description('[PROVIDER:MERN] Install Yarn?'),
            'linode_root_password' => $schema->string()->description('[PROVIDER:LINODE] Root password (must have uppercase, lowercase, number, special char)'),
        ];
    }
}
