<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Tools Controller
 *
 * Manages the display of available MCP tools in the ServerAvatar MCP server.
 * Provides a paginated list of all tools with their descriptions and usage examples.
 */
class ToolsController extends Controller
{
    /**
     * Display a paginated list of all available MCP tools.
     *
     * This method retrieves tools from the central configuration and returns
     * them in a paginated format for the tools library view.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\View\View The tools view with paginated tool data
     */
    public function index(Request $request) {
        $user = $request->user();
        $perPage = 10;
        $page = $request->get('page', 1);

        // Get tools from central config
        // Each tool contains: name, description, usage example, status, and icon
        $allTools = collect(config('mcp_tools.tools'))->map(function ($tool) {
            return [
                'name' => $tool['name'],
                'description' => $tool['description'],
                'usage' => $tool['usage'],
                'status' => 'Enabled',
                'icon' => $tool['icon'],
            ];
        })->toArray();

        $totalTools = count($allTools);
        $totalPages = ceil($totalTools / $perPage);
        $offset = ($page - 1) * $perPage;
        $tools = array_slice($allTools, $offset, $perPage);

        return view('tools', [
            'user' => $user,
            'tools' => $tools,
            'totalTools' => $totalTools,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'perPage' => $perPage,
        ]);
    }
}
