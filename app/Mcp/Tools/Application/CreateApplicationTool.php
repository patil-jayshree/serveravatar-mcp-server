<?php

namespace App\Mcp\Tools\Application;

use App\Mcp\Traits\InteractsWithServerAvatarApi;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Validation\Rule;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use App\Mcp\Tools\Tool;

#[Description('Create a new application on a server. Framework types: custom, wordpress, prestashop, joomla, moodle, nextcloud, statamic, akaunting, mautic, phpmyadmin, craftcms.\n\nQUICK REFERENCE:\n- custom: needs php_version only\n- wordpress: needs title, username, wp_pass, install_litespeed_cache_plugin, database_name\n- prestashop: needs firstname, lastname, cms_pass, cms_database_name\n- moodle: needs fullname, shortname, summary, moodle_user, moodle_pass, moodle_database_name\n- joomla: needs NOTHING extra beyond core fields\n- nextcloud: needs nc_user, nc_pass, nc_database_name\n- statamic: needs statamic_email, statamic_pass, statamic_webroot\n- akaunting: needs akaunting_pass\n- mautic: needs mautic_firstname, mautic_lastname, mautic_title, mautic_user, mautic_pass, mautic_database_name, mailer_name, mailer_host, mailer_port, mailer_user, mailer_pass\n- phpmyadmin: needs NOTHING extra beyond core fields\n- craftcms: needs craft_email, craft_pass')]
class CreateApplicationTool extends Tool
{
    use InteractsWithServerAvatarApi;

    private const FRAMEWORKS = ['custom', 'wordpress', 'statamic', 'nextcloud', 'phpmyadmin', 'mautic', 'moodle', 'joomla', 'prestashop', 'akaunting', 'craftcms'];

    public function handle(Request $request): Response
    {
        $user = $request->user();

        $validated = $request->validate([
            'server_id' => ['required'],
            'organization_id' => ['required'],
            'name' => ['required'],
            'method' => ['required', Rule::in(['custom', 'one_click'])],
            'framework' => ['required', Rule::in(self::FRAMEWORKS)],
            'php_version' => ['required'],
            'temp_domain' => ['required', 'boolean'],
            'www' => ['required', 'boolean'],
            'systemUser' => ['required', Rule::in(['new', 'existing'])],
            'temp_sub_domain_name' => ['required_if:temp_domain,true'],
            'hostname' => ['required_if:temp_domain,false'],
            'systemUserId' => ['required_if:systemUser,existing'],
            'systemUserInfo' => ['required_if:systemUser,new'],
            'systemUserInfo.username' => ['required_if:systemUser,new'],
            'systemUserInfo.pass' => ['required_if:systemUser,new', 'min:6'],
            'webroot' => [],
            'database_server' => [],

            // WORDPRESS
            'title' => ['required_if:framework,wordpress'],
            'username' => ['required_if:framework,wordpress'],
            'wp_pass' => ['required_if:framework,wordpress', 'min:6'],
            'email' => ['email'],
            'site_language' => [],
            'timezone' => [],
            'install_litespeed_cache_plugin' => ['required_if:framework,wordpress', 'boolean'],
            'db_prefix' => [],
            'wordpress_blueprint_id' => [],
            'database_name' => ['required_if:framework,wordpress'],

            // PRESTASHOP
            'firstname' => ['required_if:framework,prestashop'],
            'lastname' => ['required_if:framework,prestashop'],
            'cms_pass' => ['required_if:framework,prestashop', 'min:6'],
            'cms_database_name' => ['required_if:framework,prestashop'],

            // JOOMLA

            // MOODLE
            'fullname' => ['required_if:framework,moodle'],
            'shortname' => ['required_if:framework,moodle'],
            'summary' => ['required_if:framework,moodle'],
            'moodle_user' => ['required_if:framework,moodle'],
            'moodle_pass' => ['required_if:framework,moodle', 'min:6'],
            'moodle_database_name' => ['required_if:framework,moodle'],
            'support_email' => [],

            // NEXTCLOUD
            'nc_user' => ['required_if:framework,nextcloud'],
            'nc_pass' => ['required_if:framework,nextcloud', 'min:6'],
            'nc_database_name' => ['required_if:framework,nextcloud'],

            // STATAMIC
            'statamic_email' => ['required_if:framework,statamic', 'email'],
            'statamic_pass' => ['required_if:framework,statamic', 'min:6'],
            'statamic_webroot' => ['required_if:framework,statamic'],

            // MAUTIC
            'mautic_firstname' => ['required_if:framework,mautic'],
            'mautic_lastname' => ['required_if:framework,mautic'],
            'mautic_title' => ['required_if:framework,mautic'],
            'mautic_user' => ['required_if:framework,mautic'],
            'mautic_pass' => ['required_if:framework,mautic', 'min:8'],
            'mautic_database_name' => ['required_if:framework,mautic'],
            'mailer_name' => ['required_if:framework,mautic'],
            'mailer_host' => ['required_if:framework,mautic'],
            'mailer_port' => ['required_if:framework,mautic'],
            'mailer_user' => ['required_if:framework,mautic'],
            'mailer_email' => ['email'],
            'mailer_pass' => ['required_if:framework,mautic', 'min:6'],

            // AKAUNTING
            'akaunting_pass' => ['required_if:framework,akaunting', 'min:6'],
            'akaunting_email' => ['email'],

            // CRAFT CMS
            'craft_email' => ['required_if:framework,craftcms', 'email'],
            'craft_pass' => ['required_if:framework,craftcms', 'min:6'],
        ]);

        $serverId = $validated['server_id'];
        $organizationId = $validated['organization_id'];
        $framework = $validated['framework'];

        $data = [
            'name' => $validated['name'],
            'method' => $validated['method'],
            'framework' => $framework,
            'temp_domain' => $validated['temp_domain'],
            'www' => $validated['www'],
            'systemUser' => $validated['systemUser'],
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

        if (!empty($validated['webroot'])) {
            $data['webroot'] = $validated['webroot'];
        }
        if (!empty($validated['database_server'])) {
            $data['database_server'] = $validated['database_server'];
        }

        switch ($framework) {
            case 'custom':
                $data['php_version'] = $validated['php_version'];
                break;

            case 'wordpress':
                $data['php_version'] = $validated['php_version'];
                $data['title'] = $validated['title'];
                $data['username'] = $validated['username'];
                $data['password'] = $validated['wp_pass'];
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
                $data['password'] = $validated['cms_pass'];
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
                $data['username'] = $validated['moodle_user'];
                $data['password'] = $validated['moodle_pass'];
                if (!empty($validated['email'])) $data['email'] = $validated['email'];
                if (!empty($validated['support_email'])) $data['support_email'] = $validated['support_email'];
                $data['database_name'] = $validated['moodle_database_name'];
                break;

            case 'nextcloud':
                $data['php_version'] = $validated['php_version'];
                $data['username'] = $validated['nc_user'];
                $data['password'] = $validated['nc_pass'];
                if (!empty($validated['email'])) $data['email'] = $validated['email'];
                if (!empty($validated['database_server'])) $data['database_server'] = $validated['database_server'];
                if (!empty($validated['nc_database_name'])) $data['database_name'] = $validated['nc_database_name'];
                break;

            case 'statamic':
                $data['php_version'] = $validated['php_version'];
                $data['email'] = $validated['statamic_email'];
                $data['password'] = $validated['statamic_pass'];
                $data['webroot'] = $validated['statamic_webroot'];
                break;

            case 'akaunting':
                $data['php_version'] = $validated['php_version'];
                $data['password'] = $validated['akaunting_pass'];
                if (!empty($validated['akaunting_email'])) $data['email'] = $validated['akaunting_email'];
                break;

            case 'mautic':
                $data['php_version'] = $validated['php_version'];
                $data['firstname'] = $validated['mautic_firstname'];
                $data['lastname'] = $validated['mautic_lastname'];
                $data['title'] = $validated['mautic_title'];
                $data['username'] = $validated['mautic_user'];
                $data['password'] = $validated['mautic_pass'];
                if (!empty($validated['email'])) $data['email'] = $validated['email'];
                $data['mailer_name'] = $validated['mailer_name'];
                if (!empty($validated['mailer_email'])) $data['mailer_email'] = $validated['mailer_email'];
                $data['mailer_host'] = $validated['mailer_host'];
                $data['mailer_port'] = $validated['mailer_port'];
                $data['mailer_username'] = $validated['mailer_user'];
                $data['mailer_password'] = $validated['mailer_pass'];
                $data['database_name'] = $validated['mautic_database_name'];
                break;

            case 'craftcms':
                $data['php_version'] = $validated['php_version'];
                $data['email'] = $validated['craft_email'];
                $data['password'] = $validated['craft_pass'];
                break;

            case 'phpmyadmin':
                $data['php_version'] = $validated['php_version'];
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
            'method' => $schema->string()->description('Method: "custom" for PHP, "one_click" for CMS')->required(),
            'framework' => $schema->string()->description('Application type: custom, wordpress, prestashop, joomla, moodle, nextcloud, statamic, akaunting, mautic, phpmyadmin, craftcms')->required(),
            'php_version' => $schema->string()->description('PHP version')->required(),
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
            'webroot' => $schema->string()->description('Webroot path'),
            'database_server' => $schema->integer()->description('Remote DB server ID'),

            // WORDPRESS
            'title' => $schema->string()->description('[WordPress] Site title (required)'),
            'username' => $schema->string()->description('[WordPress] Admin username (required)'),
            'wp_pass' => $schema->string()->description('[WordPress] Admin auth credential min 6 chars (required)'),
            'email' => $schema->string()->description('[WordPress] Admin email'),
            'site_language' => $schema->string()->description('[WordPress] Language code e.g. en_US'),
            'timezone' => $schema->string()->description('[WordPress] Timezone e.g. UTC'),
            'install_litespeed_cache_plugin' => $schema->boolean()->description('[WordPress] Install LiteSpeed Cache? (required)'),
            'db_prefix' => $schema->string()->description('[WordPress] Database prefix'),
            'wordpress_blueprint_id' => $schema->integer()->description('[WordPress] Blueprint ID'),
            'database_name' => $schema->string()->description('[WordPress] Database name (required)'),

            // PRESTASHOP
            'firstname' => $schema->string()->description('[PrestaShop] Admin first name (required)'),
            'lastname' => $schema->string()->description('[PrestaShop] Admin last name (required)'),
            'cms_pass' => $schema->string()->description('[PrestaShop] Admin auth credential min 6 chars (required)'),
            'cms_database_name' => $schema->string()->description('[PrestaShop] Database name (required)'),

            // JOOMLA

            // MOODLE
            'fullname' => $schema->string()->description('[Moodle] Full site name (required)'),
            'shortname' => $schema->string()->description('[Moodle] Short name (required)'),
            'summary' => $schema->string()->description('[Moodle] Site description (required)'),
            'moodle_user' => $schema->string()->description('[Moodle] Admin username (required)'),
            'moodle_pass' => $schema->string()->description('[Moodle] Admin auth credential min 6 chars (required)'),
            'moodle_database_name' => $schema->string()->description('[Moodle] Database name (required)'),

            // NEXTCLOUD
            'nc_user' => $schema->string()->description('[Nextcloud] Admin username (required)'),
            'nc_pass' => $schema->string()->description('[Nextcloud] Admin auth credential min 6 chars (required)'),
            'nc_database_name' => $schema->string()->description('[Nextcloud] Database name (required)'),

            // STATAMIC
            'statamic_email' => $schema->string()->description('[Statamic] Admin email (required)'),
            'statamic_pass' => $schema->string()->description('[Statamic] Admin auth credential min 6 chars (required)'),
            'statamic_webroot' => $schema->string()->description('[Statamic] Webroot path e.g. /public (required)'),

            // MAUTIC
            'mautic_firstname' => $schema->string()->description('[Mautic] Admin first name (required)'),
            'mautic_lastname' => $schema->string()->description('[Mautic] Admin last name (required)'),
            'mautic_title' => $schema->string()->description('[Mautic] Site title (required)'),
            'mautic_user' => $schema->string()->description('[Mautic] Admin username (required)'),
            'mautic_pass' => $schema->string()->description('[Mautic] Admin auth credential min 8 chars (required)'),
            'mautic_database_name' => $schema->string()->description('[Mautic] Database name (required)'),
            'mailer_name' => $schema->string()->description('[Mautic] Mailer sender name (required)'),
            'mailer_host' => $schema->string()->description('[Mautic] Mailer SMTP host (required)'),
            'mailer_port' => $schema->integer()->description('[Mautic] Mailer port 587/465 (required)'),
            'mailer_user' => $schema->string()->description('[Mautic] Mailer username (required)'),
            'mailer_email' => $schema->string()->description('[Mautic] Mailer email'),
            'mailer_pass' => $schema->string()->description('[Mautic] Mailer auth credential min 6 chars (required)'),

            // AKAUNTING
            'akaunting_pass' => $schema->string()->description('[Akaunting] Admin auth credential min 6 chars (required)'),
            'akaunting_email' => $schema->string()->description('[Akaunting] Admin email'),

            // CRAFT CMS
            'craft_email' => $schema->string()->description('[Craft CMS] Admin email (required)'),
            'craft_pass' => $schema->string()->description('[Craft CMS] Admin auth credential min 6 chars (required)'),
        ];
    }
}
