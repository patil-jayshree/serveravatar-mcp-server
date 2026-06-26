<?php

namespace App\Mcp\Tools;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Create a new application on a server. Framework types: custom, wordpress, prestashop, joomla, moodle, nextcloud, statamic, akaunting, mautic, phpmyadmin, craftcms.\n\nQUICK REFERENCE:\n- custom: needs php_version only\n- wordpress: needs title, username, password, install_litespeed_cache_plugin, database_name\n- prestashop: needs firstname, lastname, cms_password, cms_database_name\n- moodle: needs fullname, shortname, summary, moodle_username, moodle_password, moodle_database_name\n- joomla: needs NOTHING extra beyond core fields\n- nextcloud: needs nc_username, nc_password, nc_database_name\n- statamic: needs statamic_email, statamic_password, statamic_webroot\n- akaunting: needs akaunting_password\n- mautic: needs mautic_firstname, mautic_lastname, mautic_title, mautic_username, mautic_password, mautic_database_name, mailer_name, mailer_host, mailer_port, mailer_username\n- phpmyadmin: needs NOTHING extra beyond core fields\n- craftcms: needs craft_email, craft_password')]
class CreateApplicationTool extends Tool
{
    use InteractsWithServerAvatarApi;

    private const FRAMEWORKS = ['custom', 'wordpress', 'statamic', 'nextcloud', 'phpmyadmin', 'mautic', 'moodle', 'joomla', 'prestashop', 'akaunting', 'craftcms'];

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            // Always required
            'server_id' => ['required'],
            'organization_id' => ['required'],
            'name' => ['required'],
            'method' => ['required', Rule::in(['custom', 'one_click'])],
            'framework' => ['required', Rule::in(self::FRAMEWORKS)],
            'php_version' => ['required'],
            'temp_domain' => ['required', 'boolean'],
            'www' => ['required', 'boolean'],
            'systemUser' => ['required', Rule::in(['new', 'existing'])],

            // Required when temp_domain=true
            'temp_sub_domain_name' => ['required_if:temp_domain,true'],
            // Required when temp_domain=false
            'hostname' => ['required_if:temp_domain,false'],
            // Required when systemUser=existing
            'systemUserId' => ['required_if:systemUser,existing'],
            // Required when systemUser=new
            'systemUserInfo' => ['required_if:systemUser,new'],
            'systemUserInfo.username' => ['required_if:systemUser,new'],
            'systemUserInfo.password' => ['required_if:systemUser,new', 'min:6'],

            // Optional common
            'webroot' => [],
            'database_server' => [],

            // =============================================
            // WORDPRESS
            // =============================================
            'title' => ['required_if:framework,wordpress'],
            'username' => ['required_if:framework,wordpress'],
            'password' => ['required_if:framework,wordpress'],
            'email' => ['email'],
            'site_language' => [],
            'timezone' => [],
            'install_litespeed_cache_plugin' => ['required_if:framework,wordpress', 'boolean'],
            'db_prefix' => [],
            'wordpress_blueprint_id' => [],
            'database_name' => ['required_if:framework,wordpress'],

            // =============================================
            // PRESTASHOP
            // =============================================
            'firstname' => ['required_if:framework,prestashop'],
            'lastname' => ['required_if:framework,prestashop'],
            'cms_password' => ['required_if:framework,prestashop'],
            'cms_database_name' => ['required_if:framework,prestashop'],

            // =============================================
            // JOOMLA (only core fields + php_version)
            // =============================================

            // =============================================
            // MOODLE
            // =============================================
            'fullname' => ['required_if:framework,moodle'],
            'shortname' => ['required_if:framework,moodle'],
            'summary' => ['required_if:framework,moodle'],
            'moodle_username' => ['required_if:framework,moodle'],
            'moodle_password' => ['required_if:framework,moodle'],
            'moodle_database_name' => ['required_if:framework,moodle'],

            // =============================================
            // NEXTCLOUD
            // =============================================
            'nc_username' => ['required_if:framework,nextcloud'],
            'nc_password' => ['required_if:framework,nextcloud'],
            'nc_database_name' => ['required_if:framework,nextcloud'],

            // =============================================
            // STATAMIC
            // =============================================
            'statamic_email' => ['required_if:framework,statamic', 'email'],
            'statamic_password' => ['required_if:framework,statamic'],
            'statamic_webroot' => ['required_if:framework,statamic'],

            // =============================================
            // MAUTIC
            // =============================================
            'mautic_firstname' => ['required_if:framework,mautic'],
            'mautic_lastname' => ['required_if:framework,mautic'],
            'mautic_title' => ['required_if:framework,mautic'],
            'mautic_username' => ['required_if:framework,mautic'],
            'mautic_password' => ['required_if:framework,mautic'],
            'mautic_database_name' => ['required_if:framework,mautic'],
            'mailer_name' => ['required_if:framework,mautic'],
            'mailer_host' => ['required_if:framework,mautic'],
            'mailer_port' => ['required_if:framework,mautic'],
            'mailer_username' => ['required_if:framework,mautic'],
            'mailer_email' => ['email'],
            'mailer_password' => [],

            // =============================================
            // AKAUNTING
            // =============================================
            'akaunting_password' => ['required_if:framework,akaunting'],

            // =============================================
            // CRAFT CMS
            // =============================================
            'craft_email' => ['required_if:framework,craftcms', 'email'],
            'craft_password' => ['required_if:framework,craftcms'],

            // =============================================
            // PHPMYADMIN (only core fields + php_version)
            // =============================================
        ], [
            'server_id.required' => 'server_id is required.',
            'organization_id.required' => 'organization_id is required.',
            'name.required' => 'name is required.',
            'framework.required' => 'framework is required.',
            'framework.in' => 'Invalid framework. Use: custom, wordpress, prestashop, joomla, moodle, nextcloud, statamic, akaunting, mautic, phpmyadmin.',
            'method.required' => 'method is required. Use "custom" for PHP apps, "one_click" for CMS apps.',
            'method.in' => 'Invalid method. Use "custom" or "one_click".',
            'php_version.required' => 'php_version is required.',
            'temp_domain.required' => 'temp_domain is required. Use true for ServerAvatar subdomain, false for custom domain.',
            'www.required' => 'www is required. Use true or false.',
            'systemUser.required' => 'systemUser is required. Use "new" or "existing".',
            'systemUser.in' => 'Invalid systemUser. Use "new" or "existing".',
            'temp_sub_domain_name.required_if' => 'temp_sub_domain_name is required when temp_domain is true.',
            'hostname.required_if' => 'hostname is required when temp_domain is false.',
            'systemUserId.required_if' => 'systemUserId is required when systemUser is "existing".',
            'systemUserInfo.required_if' => 'systemUserInfo with username and password is required when systemUser is "new".',
            'systemUserInfo.password.min' => 'systemUserInfo.password must be at least 6 characters.',
            
            // Framework-specific messages
            'title.required_if' => 'title is required for WordPress.',
            'username.required_if' => 'username is required for WordPress.',
            'password.required_if' => 'password is required for WordPress.',
            'install_litespeed_cache_plugin.required_if' => 'install_litespeed_cache_plugin is required for WordPress.',
            'database_name.required_if' => 'database_name is required for WordPress.',
            
            'firstname.required_if' => 'firstname is required for PrestaShop.',
            'lastname.required_if' => 'lastname is required for PrestaShop.',
            'cms_password.required_if' => 'password is required for PrestaShop.',
            'cms_database_name.required_if' => 'database_name is required for PrestaShop.',
            
            'fullname.required_if' => 'fullname is required for Moodle.',
            'shortname.required_if' => 'shortname is required for Moodle.',
            'summary.required_if' => 'summary is required for Moodle.',
            'moodle_username.required_if' => 'username is required for Moodle.',
            'moodle_password.required_if' => 'password is required for Moodle.',
            'moodle_database_name.required_if' => 'database_name is required for Moodle.',
            
            'nc_username.required_if' => 'username is required for Nextcloud.',
            'nc_password.required_if' => 'password is required for Nextcloud.',
            'nc_database_name.required_if' => 'database_name is required for Nextcloud.',
            
            'statamic_email.required_if' => 'email is required for Statamic.',
            'statamic_password.required_if' => 'password is required for Statamic.',
            'statamic_webroot.required_if' => 'webroot is required for Statamic.',
            
            'mautic_firstname.required_if' => 'firstname is required for Mautic.',
            'mautic_lastname.required_if' => 'lastname is required for Mautic.',
            'mautic_title.required_if' => 'title is required for Mautic.',
            'mautic_username.required_if' => 'username is required for Mautic.',
            'mautic_password.required_if' => 'password is required for Mautic.',
            'mautic_database_name.required_if' => 'database_name is required for Mautic.',
            'mailer_name.required_if' => 'mailer_name is required for Mautic.',
            'mailer_host.required_if' => 'mailer_host is required for Mautic.',
            'mailer_port.required_if' => 'mailer_port is required for Mautic.',
            'mailer_username.required_if' => 'mailer_username is required for Mautic.',
            
            'akaunting_password.required_if' => 'password is required for Akaunting.',
            'craft_email.required_if' => 'email is required for Craft CMS.',
            'craft_password.required_if' => 'password is required for Craft CMS.',
        ]);

        $serverId = $validated['server_id'];
        $organizationId = $validated['organization_id'];
        $framework = $validated['framework'];

        // Build base payload
        $data = [
            'name' => $validated['name'],
            'method' => $validated['method'],
            'framework' => $framework,
            'temp_domain' => $validated['temp_domain'],
            'www' => $validated['www'],
            'systemUser' => $validated['systemUser'],
        ];

        // Domain
        if ($validated['temp_domain']) {
            $data['temp_sub_domain_name'] = $validated['temp_sub_domain_name'];
        } else {
            $data['hostname'] = $validated['hostname'];
        }

        // System user
        if ($validated['systemUser'] === 'existing') {
            $data['systemUserId'] = $validated['systemUserId'];
        } else {
            $data['systemUserInfo'] = [
                'username' => $validated['systemUserInfo']['username'],
                'password' => $validated['systemUserInfo']['password'],
            ];
        }

        // Optional common
        if (!empty($validated['webroot'])) {
            $data['webroot'] = $validated['webroot'];
        }
        if (!empty($validated['database_server'])) {
            $data['database_server'] = $validated['database_server'];
        }

        // Framework-specific
        switch ($framework) {
            case 'custom':
                $data['php_version'] = $validated['php_version'];
                break;

            case 'wordpress':
                $data['php_version'] = $validated['php_version'];
                $data['title'] = $validated['title'];
                $data['username'] = $validated['username'];
                $data['password'] = $validated['password'];
                if (!empty($validated['email'])) $data['email'] = $validated['email'];
                if (!empty($validated['site_language'])) $data['site_language'] = $validated['site_language'];
                if (!empty($validated['timezone'])) $data['timezone'] = $validated['timezone'];
                $data['install_litespeed_cache_plugin'] = $validated['install_litespeed_cache_plugin'];
                if (!empty($validated['db_prefix'])) $data['db_prefix'] = $validated['db_prefix'];
                if (!empty($validated['wordpress_blueprint_id'])) $data['wordpress_blueprint_id'] = $validated['wordpress_blueprint_id'];
                $data['database_name'] = $validated['database_name'];
                break;

            case 'prestashop':
                $data['php_version'] = $validated['php_version'];
                $data['firstname'] = $validated['firstname'];
                $data['lastname'] = $validated['lastname'];
                $data['password'] = $validated['cms_password'];
                if (!empty($validated['email'])) $data['email'] = $validated['email'];
                $data['database_name'] = $validated['cms_database_name'];
                break;

            case 'joomla':
                $data['php_version'] = $validated['php_version'];
                break;

            case 'moodle':
                $data['php_version'] = $validated['php_version'];
                $data['fullname'] = $validated['fullname'];
                $data['shortname'] = $validated['shortname'];
                $data['summary'] = $validated['summary'];
                $data['username'] = $validated['moodle_username'];
                $data['password'] = $validated['moodle_password'];
                if (!empty($validated['email'])) $data['email'] = $validated['email'];
                if (!empty($validated['support_email'])) $data['support_email'] = $validated['support_email'];
                $data['database_name'] = $validated['moodle_database_name'];
                break;

            case 'nextcloud':
                $data['php_version'] = $validated['php_version'];
                $data['username'] = $validated['nc_username'];
                $data['password'] = $validated['nc_password'];
                if (!empty($validated['email'])) $data['email'] = $validated['email'];
                if (!empty($validated['database_server'])) $data['database_server'] = $validated['database_server'];
                if (!empty($validated['nc_database_name'])) $data['database_name'] = $validated['nc_database_name'];
                break;

            case 'statamic':
                $data['php_version'] = $validated['php_version'];
                $data['email'] = $validated['statamic_email'];
                $data['password'] = $validated['statamic_password'];
                $data['webroot'] = $validated['statamic_webroot'];
                break;

            case 'akaunting':
                $data['php_version'] = $validated['php_version'];
                $data['password'] = $validated['akaunting_password'];
                if (!empty($validated['email'])) $data['email'] = $validated['email'];
                break;

            case 'mautic':
                $data['php_version'] = $validated['php_version'];
                $data['firstname'] = $validated['mautic_firstname'];
                $data['lastname'] = $validated['mautic_lastname'];
                $data['title'] = $validated['mautic_title'];
                $data['username'] = $validated['mautic_username'];
                $data['password'] = $validated['mautic_password'];
                if (!empty($validated['email'])) $data['email'] = $validated['email'];
                $data['mailer_name'] = $validated['mailer_name'];
                if (!empty($validated['mailer_email'])) $data['mailer_email'] = $validated['mailer_email'];
                $data['mailer_host'] = $validated['mailer_host'];
                $data['mailer_port'] = $validated['mailer_port'];
                $data['mailer_username'] = $validated['mailer_username'];
                if (!empty($validated['mailer_password'])) $data['mailer_password'] = $validated['mailer_password'];
                $data['database_name'] = $validated['mautic_database_name'];
                break;

            case 'craftcms':
                $data['php_version'] = $validated['php_version'];
                $data['email'] = $validated['craft_email'];
                $data['password'] = $validated['craft_password'];
                break;

            case 'phpmyadmin':
                $data['php_version'] = $validated['php_version'];
                break;
        }

        $result = $this->apiCall("/organizations/$organizationId/servers/$serverId/applications", $user, $data, 'POST');

        return Response::text(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            // =============================================
            // CORE - Required for ALL frameworks
            // =============================================
            'server_id' => $schema->string()->description('Server ID (required)'),
            'organization_id' => $schema->string()->description('Organization ID (required)'),
            'name' => $schema->string()->description('Application name (required)'),
            'method' => $schema->string()->description('Method: "custom" for PHP, "one_click" for CMS (required)'),
            'framework' => $schema->string()->description('Application type (required):\n- custom: PHP apps (method=custom)\n- wordpress: WordPress sites (method=one_click)\n- prestashop: PrestaShop stores (method=one_click)\n- joomla: Joomla sites (method=one_click) - NO extra fields needed\n- moodle: Moodle LMS (method=one_click)\n- nextcloud: Nextcloud cloud (method=one_click)\n- statamic: Statamic CMS (method=one_click)\n- akaunting: Akaunting accounting (method=one_click)\n- mautic: Mautic CRM (method=one_click)\n- phpmyadmin: PhpMyAdmin (method=one_click) - NO extra fields needed\n- craftcms: Craft CMS (method=one_click)'),
            'php_version' => $schema->string()->description('PHP version (required)'),
            'temp_domain' => $schema->boolean()->description('Use ServerAvatar subdomain? true/false (required)'),
            'www' => $schema->boolean()->description('Add www prefix? true/false (required)'),
            'systemUser' => $schema->string()->description('"new" or "existing" (required)'),
            'temp_sub_domain_name' => $schema->string()->description('Subdomain name (required if temp_domain=true)'),
            'hostname' => $schema->string()->description('Custom domain (required if temp_domain=false)'),
            'systemUserId' => $schema->integer()->description('Existing user ID (required if systemUser=existing)'),
            'systemUserInfo' => $schema->object([
                'username' => $schema->string()->description('System user username (required if systemUser=new)'),
                'password' => $schema->string()->description('System user password min 6 chars (required if systemUser=new)'),
            ]),
            'webroot' => $schema->string()->description('Webroot path'),
            'database_server' => $schema->integer()->description('Remote DB server ID'),

            // =============================================
            // WORDPRESS
            // =============================================
            'title' => $schema->string()->description('[WordPress] Site title (required)'),
            'username' => $schema->string()->description('[WordPress] Admin username (required)'),
            'password' => $schema->string()->description('[WordPress] Admin password (required)'),
            'email' => $schema->string()->description('[WordPress] Admin email'),
            'site_language' => $schema->string()->description('[WordPress] Language code e.g. en_US'),
            'timezone' => $schema->string()->description('[WordPress] Timezone e.g. UTC'),
            'install_litespeed_cache_plugin' => $schema->boolean()->description('[WordPress] Install LiteSpeed Cache? true/false (required)'),
            'db_prefix' => $schema->string()->description('[WordPress] Database prefix'),
            'wordpress_blueprint_id' => $schema->integer()->description('[WordPress] Blueprint ID'),
            'database_name' => $schema->string()->description('[WordPress] Database name (required)'),

            // =============================================
            // PRESTASHOP
            // =============================================
            'firstname' => $schema->string()->description('[PrestaShop] Admin first name (required)'),
            'lastname' => $schema->string()->description('[PrestaShop] Admin last name (required)'),
            'cms_password' => $schema->string()->description('[PrestaShop] Admin password (required)'),
            'cms_database_name' => $schema->string()->description('[PrestaShop] Database name (required)'),

            // =============================================
            // JOOMLA
            // =============================================
            // Only core + php_version required

            // =============================================
            // MOODLE
            // =============================================
            'fullname' => $schema->string()->description('[Moodle] Full site name (required)'),
            'shortname' => $schema->string()->description('[Moodle] Short name (required)'),
            'summary' => $schema->string()->description('[Moodle] Site description (required)'),
            'moodle_username' => $schema->string()->description('[Moodle] Admin username (required)'),
            'moodle_password' => $schema->string()->description('[Moodle] Admin password (required)'),
            'moodle_database_name' => $schema->string()->description('[Moodle] Database name (required)'),

            // =============================================
            // NEXTCLOUD
            // =============================================
            'nc_username' => $schema->string()->description('[Nextcloud] Admin username (required)'),
            'nc_password' => $schema->string()->description('[Nextcloud] Admin password (required)'),
            'nc_database_name' => $schema->string()->description('[Nextcloud] Database name (required)'),

            // =============================================
            // STATAMIC
            // =============================================
            'statamic_email' => $schema->string()->description('[Statamic] Admin email (required)'),
            'statamic_password' => $schema->string()->description('[Statamic] Admin password (required)'),
            'statamic_webroot' => $schema->string()->description('[Statamic] Webroot path e.g. /public (required)'),

            // =============================================
            // MAUTIC
            // =============================================
            'mautic_firstname' => $schema->string()->description('[Mautic] Admin first name (required)'),
            'mautic_lastname' => $schema->string()->description('[Mautic] Admin last name (required)'),
            'mautic_title' => $schema->string()->description('[Mautic] Site title (required)'),
            'mautic_username' => $schema->string()->description('[Mautic] Admin username (required)'),
            'mautic_password' => $schema->string()->description('[Mautic] Admin password min 8 chars (required)'),
            'mautic_database_name' => $schema->string()->description('[Mautic] Database name (required)'),
            'mailer_name' => $schema->string()->description('[Mautic] Mailer sender name (required)'),
            'mailer_host' => $schema->string()->description('[Mautic] Mailer SMTP host (required)'),
            'mailer_port' => $schema->integer()->description('[Mautic] Mailer port 587/465 (required)'),
            'mailer_username' => $schema->string()->description('[Mautic] Mailer username (required)'),
            'mailer_email' => $schema->string()->description('[Mautic] Mailer email'),
            'mailer_password' => $schema->string()->description('[Mautic] Mailer password'),

            // =============================================
            // AKAUNTING
            // =============================================
            'akaunting_password' => $schema->string()->description('[Akaunting] Admin password (required)'),

            // =============================================
            // CRAFT CMS
            // =============================================
            'craft_email' => $schema->string()->description('[Craft CMS] Admin email (required)'),
            'craft_password' => $schema->string()->description('[Craft CMS] Admin password (required)'),

            // =============================================
            // PHPMYADMIN
            // =============================================
            // Only core + php_version required
        ];
    }
}
