<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

/**
 * Tools Controller
 *
 * Handles the display of available MCP tools and their documentation.
 */
class ToolsController extends Controller
{
    /**
     * Display a paginated list of all available MCP tools.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\View\View The tools view with paginated tool data
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $perPage = 10;
            $page = $request->get('page', 1);
            $search = $request->get('q', '');

            $allTools = collect(config('mcp_tools.tools'))->map(function ($tool) {
                return [
                    'name' => $tool['name'],
                    'description' => $tool['description'],
                    'usage' => $tool['usage'],
                    'status' => 'Enabled',
                    'icon' => $tool['icon'],
                ];
            });

            // Filter by search query
            if (!empty($search)) {
                $searchLower = strtolower($search);
                $allTools = $allTools->filter(function ($tool) use ($searchLower) {
                    return str_contains(strtolower($tool['name']), $searchLower)
                        || str_contains(strtolower($tool['description']), $searchLower);
                });
            }

            $allTools = $allTools->values()->toArray();
            $totalTools = count($allTools);
            
            // When searching, show all results on one page (no pagination)
            if (!empty($search)) {
                $totalPages = 1;
                $page = 1;
                $tools = $allTools;
            } else {
                $totalPages = ceil($totalTools / $perPage);
                $offset = ($page - 1) * $perPage;
                $tools = array_slice($allTools, $offset, $perPage);
            }

            return view('tools', [
                'user' => $user,
                'tools' => $tools,
                'totalTools' => $totalTools,
                'totalPages' => $totalPages,
                'currentPage' => $page,
                'perPage' => $perPage,
                'searchQuery' => $search,
            ]);
        } catch (Exception $e) {
            return view('tools', [
                'user' => $request->user(),
                'tools' => [],
                'totalTools' => 0,
                'totalPages' => 0,
                'currentPage' => 1,
                'perPage' => 10,
                'searchQuery' => '',
            ])->with('error', 'Unable to load tools. Please try again.');
        }
    }
}
