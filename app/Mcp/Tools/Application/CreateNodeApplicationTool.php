<?php

namespace App\Mcp\Tools\Application;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Create a new Node.js one-click application on a server. Framework types: uptimekuma, nodered, n8n, nodebb.

REQUIREMENT: Server must be a MERN stack server (web_server = mern). This tool validates the server before creating the application.

QUICK REFERENCE:
- uptimekuma: no additional fields needed
- nodered: needs username, password
- n8n: needs username, password
- nodebb: needs username, password, email

Core fields:
- method is always "one_click" for these frameworks
- package_manager: npm or yarn (required)
- process_mode: fork or cluster (required)')]
class CreateNodeApplicationTool extends Tool
{
    use InteractsWithServerAvatarApi;

    private const FRAMEWORKS = ['uptimekuma', 'nodered', 'n8n', 'nodebb'];

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            'server_id' => ['required'],
            'organization_id' => ['required'],
            'name' => ['required'],
            'framework' => ['required', Rule::in(self::FRAMEWORKS)],
            'temp_domain' => ['required', 'boolean'],
            'www' => ['required', 'boolean'],
            'systemUser' => ['required', Rule::in(['new', 'existing'])],
            'temp_sub_domain_name' => ['required_if:temp_domain,true'],
            'hostname' => ['required_if:temp_domain,false'],
            'systemUserId' => ['required_if:systemUser,existing'],
            'systemUserInfo' => ['required_if:systemUser,new'],
            'systemUserInfo.username' => ['required_if:systemUser,new'],
            'systemUserInfo.pass' => ['required_if:systemUser,new', 'min:6'],
            'package_manager' => ['required', Rule::in(['npm', 'yarn'])],
            'process_mode' => ['required', Rule::in(['fork', 'cluster'])],

            // UPTIMEKUMA (no admin creds needed)
            // NODERED, N8N
            'username' => ['required_if:framework,nodered'],
            'password' => ['required_if:framework,nodered', 'min:6'],
            // N8N also uses username/password
            'n8n_username' => ['required_if:framework,n8n'],
            'n8n_password' => ['required_if:framework,n8n', 'min:6'],

            // NODEBB
            'nodebb_username' => ['required_if:framework,nodebb'],
            'nodebb_password' => ['required_if:framework,nodebb', 'min:6'],
            'nodebb_email' => ['required_if:framework,nodebb', 'email'],
        ]);

        $serverId = $validated['server_id'];
        $organizationId = $validated['organization_id'];
        $framework = $validated['framework'];

        // Validate server is MERN stack (Node.js capable)
        $serverResponse = $this->apiCall("/organizations/$organizationId/servers/$serverId", $user);
        if (isset($serverResponse['error'])) {
            return Response::text(json_encode($serverResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        // Handle various response structures
        $serverData = $serverResponse;
        if (isset($serverResponse['data'])) {
            $serverData = $serverResponse['data'];
        } elseif (isset($serverResponse['server'])) {
            $serverData = $serverResponse['server'];
        }

        $webServer = $serverData['web_server'] ?? $serverData['webserver'] ?? null;
        if ($webServer === null) {
            // Return debug info so we can see actual response structure
            return Response::text(json_encode([
                'error' => true,
                'debug' => 'Could not find web_server in response',
                'response_structure' => array_keys($serverResponse),
                'server_data_keys' => array_keys($serverData),
                'server_response' => $serverResponse,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        if ($webServer !== 'mern') {
            return Response::text(json_encode([
                'error' => true,
                'message' => 'This server does not support Node.js applications. Server must be a MERN stack server (web_server: mern). Current web_server: ' . ($webServer ?? 'unknown'),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        $data = [
            'name' => $validated['name'],
            'method' => 'one_click',
            'framework' => $framework,
            'temp_domain' => $validated['temp_domain'],
            'www' => $validated['www'],
            'systemUser' => $validated['systemUser'],
            'package_manager' => $validated['package_manager'],
            'process_mode' => $validated['process_mode'],
        ];

        if ($validated['temp_domain']) {
            $data['temp_sub_domain_name'] = $validated['temp_sub_domain_name'];
        } else {
            $data['hostname'] = $validated['hostname'];
        }

        if ($validated['systemUser'] === 'existing') {
            $data['systemUserId'] = $validated['systemUserId'];
        } else {
            $data['systemUserInfo'] = [
                'username' => $validated['systemUserInfo']['username'],
                'password' => $validated['systemUserInfo']['pass'],
            ];
        }

        switch ($framework) {
            case 'uptimekuma':
                // No additional fields needed
                break;

            case 'nodered':
                $data['username'] = $validated['username'];
                $data['password'] = $validated['password'];
                break;

            case 'n8n':
                $data['username'] = $validated['n8n_username'];
                $data['password'] = $validated['n8n_password'];
                break;

            case 'nodebb':
                $data['username'] = $validated['nodebb_username'];
                $data['password'] = $validated['nodebb_password'];
                $data['email'] = $validated['nodebb_email'];
                break;
        }

        $result = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications", $user, $data, 'POST');

        $sanitized = $result;

        if (isset($sanitized['error'])) {
            return Response::text(json_encode($sanitized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        return Response::text(json_encode($sanitized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'organization_id' => $schema->string()->description('Organization ID')->required(),
            'server_id' => $schema->string()->description('Server ID')->required(),
            'name' => $schema->string()->description('Application name')->required(),
            'framework' => $schema->string()->description('Application type: uptimekuma, nodered, n8n, nodebb')->required(),
            'temp_domain' => $schema->boolean()->description('Use ServerAvatar subdomain?')->required(),
            'www' => $schema->boolean()->description('Add www prefix?')->required(),
            'systemUser' => $schema->string()->description('"new" or "existing"')->required(),
            'temp_sub_domain_name' => $schema->string()->description('Subdomain name (required if temp_domain=true)'),
            'hostname' => $schema->string()->description('Custom domain (required if temp_domain=false)'),
            'systemUserId' => $schema->integer()->description('Existing user ID (required if systemUser=existing)'),
            'systemUserInfo' => $schema->object([
                'username' => $schema->string()->description('System user username (required if systemUser=new)'),
                'pass' => $schema->string()->description('System user auth credential min 6 chars (required if systemUser=new)'),
            ]),
            'package_manager' => $schema->string()->description('Package manager: npm or yarn')->required(),
            'process_mode' => $schema->string()->description('Process mode: fork or cluster')->required(),

            // NODERED
            'username' => $schema->string()->description('[Node-RED] Admin username (required)'),
            'password' => $schema->string()->description('[Node-RED] Admin password min 6 chars (required)'),

            // N8N
            'n8n_username' => $schema->string()->description('[N8N] Admin username (required)'),
            'n8n_password' => $schema->string()->description('[N8N] Admin password min 6 chars (required)'),

            // NODEBB
            'nodebb_username' => $schema->string()->description('[NodeBB] Admin username (required)'),
            'nodebb_password' => $schema->string()->description('[NodeBB] Admin password min 6 chars (required)'),
            'nodebb_email' => $schema->string()->description('[NodeBB] Admin email (required)'),
        ];
    }
}
