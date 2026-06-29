<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\Server\{ListServersTool, GetServerTool, GetServerUsageTool, ViewServerLogsTool, GetServerProcessesTool, GetServerServicesTool, UpdateServerServiceTool, GetPhpFpmContentTool, InstallPhpVersionTool,};
use App\Mcp\Tools\Application\{ListApplicationsTool, ListOrganizationApplicationsTool, CreateApplicationTool, GetApplicationTool, DeleteApplicationTool, ToggleApplicationTool, UpdatePhpSettingsTool, ManageBasicAuthTool,};
use App\Mcp\Tools\Database\{ListDatabasesTool, GetDatabaseTool,};
use App\Mcp\Tools\Backup\ListBackupsTool;
use App\Mcp\Tools\Organization\ListOrganizationsTool;
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
    public int $defaultPaginationLength = 50;

    /**
     * The tools registered with this MCP server.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Tool>>
     */
    protected array $tools = [
        ListOrganizationsTool::class,
        ListServersTool::class,
        GetServerTool::class,
        GetServerUsageTool::class,
        ListApplicationsTool::class,
        ListOrganizationApplicationsTool::class,
        CreateApplicationTool::class,
        GetApplicationTool::class,
        DeleteApplicationTool::class,
        ListDatabasesTool::class,
        GetDatabaseTool::class,
        ViewServerLogsTool::class,
        GetServerProcessesTool::class,
        GetServerServicesTool::class,
        UpdateServerServiceTool::class,
        GetPhpFpmContentTool::class,
        InstallPhpVersionTool::class,
        ListBackupsTool::class,
        UpdatePhpSettingsTool::class,
        ToggleApplicationTool::class,
        ManageBasicAuthTool::class,
    ];

    /**
     * Get the count of registered tools.
     */
    public static function getToolsCount(): int
    {
        return count(config('mcp_tools.tools', []));
    }
}