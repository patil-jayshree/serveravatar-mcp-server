<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\Database\{ListServerDatabasesTool, ListOrganizationDatabasesTool, CreateDatabaseTool, DeleteDatabaseTool};
use App\Mcp\Tools\DatabaseUser\{ListDatabaseUsersTool, CreateDatabaseUserTool, UpdateDatabaseUserTool, DeleteDatabaseUserTool};
use App\Mcp\Tools\Server\{CreateServerTool, ListCloudServerProvidersTool, ListCloudProviderRegionsTool, ListCloudProviderSizesTool, DeleteServerTool, ListServersTool, GetServerTool, GetServerUsageTool, ViewServerLogsTool, GetServerProcessesTool, GetServerServicesTool, UpdateServerServiceTool, GetPhpFpmContentTool, InstallPhpVersionTool, UpdateServerGeneralSettingsTool, RestartServerTool, GetServerSummaryTool, SetServerRestartScheduleTool, UpdateServerTagsTool, DeleteServerTagsTool};
use App\Mcp\Tools\Firewall\{ToggleServerFirewallTool, ListFirewallRulesTool, CreateFirewallRuleTool, DeleteFirewallRuleTool};
use App\Mcp\Tools\Cronjob\{CreateCronjobTool, ListCronjobsTool, GetCronjobTool, UpdateCronjobTool, ToggleCronjobTool, DeleteCronjobTool};
use App\Mcp\Tools\ApplicationUser\{ListUsersTool, CreateUserTool, GetUserTool, UpdateUserTool, DeleteUserTool, ToggleUserSshAccessTool, ToggleUserRootAccessTool, RemoveUserSshKeyTool};
use App\Mcp\Tools\Application\{ListApplicationsTool, ListOrganizationApplicationsTool, CreateApplicationTool, GetApplicationTool, DeleteApplicationTool, ToggleApplicationTool, UpdatePhpSettingsTool, ManageBasicAuthTool, Toggle8gFirewallTool};
use App\Mcp\Tools\Application\Node\{CreateNodeApplicationTool, GetNodeDeploymentTool, UpdateSsrPortTool, GetPm2DetailTool, GetPm2LogTool};
use App\Mcp\Tools\ApplicationDomain\{ListDomainsTool, CreateDomainTool, DeleteDomainTool, ChangePrimaryDomainTool, ToggleDomainTool};
use App\Mcp\Tools\SSL\{GetSslCertificateTool, InstallSslCertificateTool, UpdateSslCertificateTool, UninstallSslCertificateTool, ForceHttpsTool, StopForceHttpsTool};

use App\Mcp\Tools\Backup\ListBackupsTool;
use App\Mcp\Tools\Organization\{ListOrganizationsTool, CreateOrganizationTool, GetOrganizationTool};
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;
use Laravel\Mcp\Server;

#[Name('ServerAvatar MCP Server')]
#[Version('1.0.0')]
#[Instructions('This server provides tools for managing your ServerAvatar hosting account including servers, sites, databases, SSL certificates, and more.')]
class ServerAvatarServer extends Server
{
    /**
     * Default pagination length - show all tools on one page.
     */
    public int $maxPaginationLength = 200;
    public int $defaultPaginationLength = 200;

    /**
     * The tools registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Tool>>
     */
    protected array $tools = [
        ListOrganizationsTool::class,
        CreateOrganizationTool::class,
        GetOrganizationTool::class,
        ListServersTool::class,
        ListServerDatabasesTool::class,
        ListOrganizationDatabasesTool::class,
        CreateDatabaseTool::class,
        DeleteDatabaseTool::class,
        ListDatabaseUsersTool::class,
        CreateDatabaseUserTool::class,
        UpdateDatabaseUserTool::class,
        DeleteDatabaseUserTool::class,
        CreateServerTool::class,
        ListCloudServerProvidersTool::class,
        ListCloudProviderRegionsTool::class,
        ListCloudProviderSizesTool::class,
        DeleteServerTool::class,
        GetServerTool::class,
        GetServerUsageTool::class,
        ListApplicationsTool::class,
        ListOrganizationApplicationsTool::class,
        CreateApplicationTool::class,
        CreateNodeApplicationTool::class,
        GetApplicationTool::class,
        GetNodeDeploymentTool::class,
        UpdateSsrPortTool::class,
        GetPm2DetailTool::class,
        GetPm2LogTool::class,
        DeleteApplicationTool::class,
        Toggle8gFirewallTool::class,
        ListDomainsTool::class,
        CreateDomainTool::class,
        DeleteDomainTool::class,
        ChangePrimaryDomainTool::class,
        ToggleDomainTool::class,
        ViewServerLogsTool::class,
        GetServerProcessesTool::class,
        GetServerServicesTool::class,
        UpdateServerServiceTool::class,
        GetPhpFpmContentTool::class,
        InstallPhpVersionTool::class,
        UpdateServerGeneralSettingsTool::class,
        RestartServerTool::class,
        GetServerSummaryTool::class,
        SetServerRestartScheduleTool::class,
        UpdateServerTagsTool::class,
        DeleteServerTagsTool::class,
        ToggleServerFirewallTool::class,
        ListFirewallRulesTool::class,
        CreateFirewallRuleTool::class,
        DeleteFirewallRuleTool::class,
        CreateCronjobTool::class,
        ListCronjobsTool::class,
        GetCronjobTool::class,
        UpdateCronjobTool::class,
        ToggleCronjobTool::class,
        DeleteCronjobTool::class,
        ListUsersTool::class,
        CreateUserTool::class,
        GetUserTool::class,
        UpdateUserTool::class,
        DeleteUserTool::class,
        ToggleUserSshAccessTool::class,
        ToggleUserRootAccessTool::class,
        RemoveUserSshKeyTool::class,

        ListBackupsTool::class,
        UpdatePhpSettingsTool::class,
        ToggleApplicationTool::class,
        ManageBasicAuthTool::class,
        GetSslCertificateTool::class,
        InstallSslCertificateTool::class,
        UpdateSslCertificateTool::class,
        UninstallSslCertificateTool::class,
        ForceHttpsTool::class,
        StopForceHttpsTool::class,
    ];

    /**
     * Get the count of registered tools.
     */
    public static function getToolsCount(): int
    {
        return count(config('mcp_tools.tools', []));
    }

}