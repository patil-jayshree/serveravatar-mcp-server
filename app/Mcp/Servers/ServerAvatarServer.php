<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\ListOrganizationsTool;
use App\Mcp\Tools\ListServersTool;
use App\Mcp\Tools\GetServerTool;
use App\Mcp\Tools\GetServerUsageTool;
use App\Mcp\Tools\ListApplicationsTool;
use App\Mcp\Tools\ListOrganizationApplicationsTool;
use App\Mcp\Tools\CreateApplicationTool;
use App\Mcp\Tools\GetApplicationTool;
use App\Mcp\Tools\DeleteApplicationTool;
use App\Mcp\Tools\ListDatabasesTool;
use App\Mcp\Tools\GetDatabaseTool;
use App\Mcp\Tools\ViewServerLogsTool;
use App\Mcp\Tools\ListSslCertificatesTool;
use App\Mcp\Tools\ListBackupsTool;
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
        ListSslCertificatesTool::class,
        ListBackupsTool::class,
    ];

    /**
     * Get the count of registered tools.
     */
    public static function getToolsCount(): int
    {
        return count(config('mcp_tools.tools', []));
    }
}
