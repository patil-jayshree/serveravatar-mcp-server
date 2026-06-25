<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Create a new application (website) on a server. Supports Custom PHP, WordPress, Statamic, Nextcloud, PHPMyAdmin, Mautic, Moodle, Joomla, Prestashop, and Akaunting applications.')]
class CreateApplicationTool extends Tool
{
    use InteractsWithServerAvatarApi;

    private const PHP_VERSIONS = ['7.2', '7.3', '7.4', '8.0', '8.1', '8.2', '8.3', '8.4', '8.5'];
    private const FRAMEWORKS = ['custom', 'wordpress', 'statamic', 'nextcloud', 'phpmyadmin', 'mautic', 'moodle', 'joomla', 'prestashop', 'akaunting'];
    private const METHODS = ['custom', 'one_click'];
    private const SYSTEM_USER_TYPES = ['new', 'existing'];

    public function handle(Request $request): Response
    {
        $user = $request->user();
        $apiKey = $user->api_key;

        // =============================================
        // LARAVEL VALIDATION - Throws ValidationException on failure
        // MCP server catches it and returns proper JSON-RPC error
        // =============================================
        $validated = $request->validate([
            // Required fields
            'server_id' => ['required', 'string'],
            'organization_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'php_version' => ['required_if:framework,custom', 'string', Rule::in(self::PHP_VERSIONS)],

            // Enumerations
            'method' => ['sometimes', 'string', Rule::in(self::METHODS)],
            'framework' => ['sometimes', 'string', Rule::in(self::FRAMEWORKS)],
            'system_user' => ['sometimes', 'string', Rule::in(self::SYSTEM_USER_TYPES)],

            // Booleans
            'temp_domain' => ['sometimes', 'boolean'],
            'www' => ['sometimes', 'boolean'],
            'install_litespeed_cache_plugin' => ['sometimes', 'boolean'],

            // Domain configuration
            'temp_sub_domain_name' => ['required_if:temp_domain,true', 'nullable', 'string', 'max:255'],
            'hostname' => ['required_if:temp_domain,false', 'nullable', 'string', 'max:255'],

            // System user
            'system_user_id' => ['required_if:system_user,existing', 'nullable', 'integer'],
            'system_user_username' => ['required_if:system_user,new', 'nullable', 'string', 'max:255'],
            'system_user_password' => ['required_if:system_user,new', 'nullable', 'string', 'min:6'],

            // Optional
            'webroot' => ['nullable', 'string', 'max:500'],
            'database_server' => ['nullable', 'integer'],
            'database_name' => ['nullable', 'string', 'max:255'],

            // WordPress specific
            'title' => ['nullable', 'string', 'max:255'],
            'wordpress_username' => ['nullable', 'string', 'max:255'],
            'wordpress_password' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'site_language' => ['nullable', 'string', 'max:10'],
            'timezone' => ['nullable', 'string', 'max:100'],
            'db_prefix' => ['nullable', 'string', 'max:255'],
            'wordpress_blueprint_id' => ['nullable', 'integer'],

            // CMS specific
            'firstname' => ['nullable', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string'],
            'fullname' => ['nullable', 'string', 'max:255'],
            'shortname' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'support_email' => ['nullable', 'email'],

            // Mautic specific
            'mailer_name' => ['nullable', 'string', 'max:255'],
            'mailer_email' => ['nullable', 'email'],
            'mailer_host' => ['nullable', 'string', 'max:255'],
            'mailer_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'mailer_username' => ['nullable', 'string', 'max:255'],
            'mailer_password' => ['nullable', 'string'],
        ], [
            // Custom error messages
            'server_id.required' => 'server_id is required. Please provide the server ID where you want to create the application.',
            'organization_id.required' => 'organization_id is required. Please provide your ServerAvatar organization ID.',
            'name.required' => 'name is required. Please provide an application name.',
            'php_version.required_if' => 'php_version is required for custom framework. Valid values: ' . implode(', ', self::PHP_VERSIONS),
            'php_version.in' => 'php_version must be one of: ' . implode(', ', self::PHP_VERSIONS),
            'framework.in' => 'framework must be one of: ' . implode(', ', self::FRAMEWORKS),
            'method.in' => 'method must be one of: ' . implode(', ', self::METHODS),
            'system_user.in' => 'system_user must be one of: ' . implode(', ', self::SYSTEM_USER_TYPES),
            'temp_sub_domain_name.required_if' => 'temp_sub_domain_name is required when using temporary domain (temp_domain=true).',
            'hostname.required_if' => 'hostname is required when not using temporary domain (temp_domain=false).',
            'system_user_id.required_if' => 'system_user_id is required when system_user is "existing".',
            'system_user_username.required_if' => 'system_user_username is required when system_user is "new".',
            'system_user_password.required_if' => 'system_user_password is required when system_user is "new".',
            'email.email' => 'email must be a valid email address.',
            'support_email.email' => 'support_email must be a valid email address.',
            'mailer_email.email' => 'mailer_email must be a valid email address.',
        ]);

        // Build request payload from validated data
        $serverId = $validated['server_id'];
        $organizationId = $validated['organization_id'];
        $framework = $validated['framework'] ?? 'custom';

        $data = [
            'name' => $validated['name'],
            'method' => $validated['method'] ?? 'custom',
            'framework' => $framework,
            'php_version' => $validated['php_version'] ?? null,
            'temp_domain' => $validated['temp_domain'] ?? true,
            'www' => $validated['www'] ?? false,
        ];

        // Domain configuration
        if ($validated['temp_domain'] ?? true) {
            $data['temp_sub_domain_name'] = $validated['temp_sub_domain_name'];
        } else {
            $data['hostname'] = $validated['hostname'];
        }

        // System user configuration - using camelCase as per API docs
        $systemUser = $validated['system_user'] ?? 'new';
        $data['systemUser'] = $systemUser;

        if ($systemUser === 'existing') {
            $data['systemUserId'] = $validated['system_user_id'];
        }

        // Always include systemUserInfo
        $data['systemUserInfo'] = [
            'username' => $validated['system_user_username'] ?? null,
            'password' => $validated['system_user_password'] ?? null,
        ];

        // Optional parameters
        if (isset($validated['webroot'])) {
            $data['webroot'] = $validated['webroot'];
        }

        if (isset($validated['database_server'])) {
            $data['database_server'] = $validated['database_server'];
        }

        if (isset($validated['database_name'])) {
            $data['database_name'] = $validated['database_name'];
        }

        // Framework-specific parameters
        if ($framework === 'wordpress') {
            if (isset($validated['title'])) $data['title'] = $validated['title'];
            if (isset($validated['wordpress_username'])) $data['username'] = $validated['wordpress_username'];
            if (isset($validated['wordpress_password'])) $data['password'] = $validated['wordpress_password'];
            if (isset($validated['email'])) $data['email'] = $validated['email'];
            if (isset($validated['site_language'])) $data['site_language'] = $validated['site_language'];
            if (isset($validated['timezone'])) $data['timezone'] = $validated['timezone'];
            if (isset($validated['install_litespeed_cache_plugin'])) {
                $data['install_litespeed_cache_plugin'] = $validated['install_litespeed_cache_plugin'];
            }
            if (isset($validated['db_prefix'])) $data['db_prefix'] = $validated['db_prefix'];
            if (isset($validated['wordpress_blueprint_id'])) $data['wordpress_blueprint_id'] = $validated['wordpress_blueprint_id'];
        }

        if (in_array($framework, ['mautic', 'moodle', 'joomla', 'prestashop', 'akaunting', 'statamic', 'nextcloud', 'phpmyadmin'])) {
            if (isset($validated['firstname'])) $data['firstname'] = $validated['firstname'];
            if (isset($validated['lastname'])) $data['lastname'] = $validated['lastname'];
            if (isset($validated['email'])) $data['email'] = $validated['email'];
        }

        if ($framework === 'mautic') {
            if (isset($validated['mailer_name'])) $data['mailer_name'] = $validated['mailer_name'];
            if (isset($validated['mailer_email'])) $data['mailer_email'] = $validated['mailer_email'];
            if (isset($validated['mailer_host'])) $data['mailer_host'] = $validated['mailer_host'];
            if (isset($validated['mailer_port'])) $data['mailer_port'] = $validated['mailer_port'];
            if (isset($validated['mailer_username'])) $data['mailer_username'] = $validated['mailer_username'];
            if (isset($validated['mailer_password'])) $data['mailer_password'] = $validated['mailer_password'];
        }

        if ($framework === 'statamic') {
            if (isset($validated['email'])) $data['email'] = $validated['email'];
            if (isset($validated['password'])) $data['password'] = $validated['password'];
            if (isset($validated['webroot'])) $data['webroot'] = $validated['webroot'];
        }

        if ($framework === 'nextcloud') {
            if (isset($validated['email'])) $data['email'] = $validated['email'];
            if (isset($validated['username'])) $data['username'] = $validated['username'];
            if (isset($validated['password'])) $data['password'] = $validated['password'];
            if (isset($validated['database_server'])) $data['database_server'] = $validated['database_server'];
            if (isset($validated['database_name'])) $data['database_name'] = $validated['database_name'];
        }

        if ($framework === 'moodle') {
            if (isset($validated['fullname'])) $data['fullname'] = $validated['fullname'];
            if (isset($validated['shortname'])) $data['shortname'] = $validated['shortname'];
            if (isset($validated['summary'])) $data['summary'] = $validated['summary'];
            if (isset($validated['support_email'])) $data['support_email'] = $validated['support_email'];
        }

        if ($framework === 'prestashop' || $framework === 'akaunting') {
            if (isset($validated['password'])) $data['password'] = $validated['password'];
        }

        // Make API call
        $result = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications", $apiKey, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'server_id' => $schema->string()->description('The server ID where to create the application (required)'),
            'organization_id' => $schema->string()->description('The organization ID (required)'),
            
            // Basic parameters
            'name' => $schema->string()->description('Application name (required)'),
            'method' => $schema->string()->description('Installation method: "custom" or "one_click" (default: custom)'),
            'framework' => $schema->string()->description('Framework type: custom, wordpress, statamic, nextcloud, phpmyadmin, mautic, moodle, joomla, prestashop, akaunting (default: custom)'),
            'php_version' => $schema->string()->description('PHP version: 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4, 8.5 (required for custom)'),
            
            // Domain configuration
            'temp_domain' => $schema->boolean()->description('Use ServerAvatar temporary domain? true/false (default: true)'),
            'temp_sub_domain_name' => $schema->string()->description('Subdomain name when using temp_domain=true'),
            'hostname' => $schema->string()->description('Custom hostname when temp_domain=false'),
            'www' => $schema->boolean()->description('Add www prefix to domain? true/false (default: false)'),
            
            // System user
            'system_user' => $schema->string()->description('System user type: "new" or "existing" (default: new)'),
            'system_user_id' => $schema->integer()->description('Existing system user ID (required if system_user=existing)'),
            'system_user_username' => $schema->string()->description('New system user username (required if system_user=new)'),
            'system_user_password' => $schema->string()->description('New system user password (required if system_user=new)'),
            
            // Optional
            'webroot' => $schema->string()->description('Custom webroot path if needed'),
            'database_server' => $schema->integer()->description('Remote database server ID'),
            'database_name' => $schema->string()->description('Database name'),
            
            // WordPress specific
            'title' => $schema->string()->description('[WordPress] Site title'),
            'wordpress_username' => $schema->string()->description('[WordPress] Admin username'),
            'wordpress_password' => $schema->string()->description('[WordPress] Admin password'),
            'email' => $schema->string()->description('[WordPress/others] Admin email'),
            'site_language' => $schema->string()->description('[WordPress] Site language'),
            'timezone' => $schema->string()->description('[WordPress] Site timezone'),
            'install_litespeed_cache_plugin' => $schema->boolean()->description('[WordPress] Install LiteSpeed Cache plugin?'),
            'db_prefix' => $schema->string()->description('[WordPress] Database prefix'),
            'wordpress_blueprint_id' => $schema->integer()->description('[WordPress] Blueprint ID to apply'),
            
            // CMS specific
            'firstname' => $schema->string()->description('[Mautic/Moodle/Joomla/Prestashop] First name'),
            'lastname' => $schema->string()->description('[Mautic/Moodle/Joomla/Prestashop] Last name'),
            'password' => $schema->string()->description('[CMS] Admin password'),
            'fullname' => $schema->string()->description('[Moodle] Full site name'),
            'shortname' => $schema->string()->description('[Moodle] Short name'),
            'summary' => $schema->string()->description('[Moodle] Site summary'),
            'support_email' => $schema->string()->description('[Moodle] Support email'),
            
            // Mautic specific
            'mailer_name' => $schema->string()->description('[Mautic] Mailer name'),
            'mailer_email' => $schema->string()->description('[Mautic] Mailer email'),
            'mailer_host' => $schema->string()->description('[Mautic] Mailer host'),
            'mailer_port' => $schema->integer()->description('[Mautic] Mailer port'),
            'mailer_username' => $schema->string()->description('[Mautic] Mailer username'),
            'mailer_password' => $schema->string()->description('[Mautic] Mailer password'),
        ];
    }
}
