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
            $category = $request->get('category', '');

            $allTools = collect(config('mcp_tools.tools'))->map(function ($tool) {
                // Extract category from class path
                $classPath = $tool['class'];
                $segments = explode('\\', $classPath);
                $category = $segments[count($segments) - 2] ?? 'Other';
                
                // Map category to display name for dropdown (full names)
                $categoryDropdownMap = [
                    'ApplicationDomain' => 'Application Domain',
                    'ApplicationUser' => 'Application User',
                    'DatabaseUser' => 'Database User',
                ];
                // Map category to short name for table badge
                $categoryBadgeMap = [
                    'ApplicationDomain' => 'Domain',
                    'ApplicationUser' => 'App User',
                    'DatabaseUser' => 'DB User',
                ];
                
                return [
                    'name' => $tool['name'],
                    'description' => $tool['description'],
                    'usage' => $tool['usage'],
                    'status' => 'Enabled',
                    'icon' => $tool['icon'],
                    'category' => $categoryDropdownMap[$category] ?? $category, // Full name for dropdown/display
                    'category_badge' => $categoryBadgeMap[$category] ?? $category, // Short name for badge
                    'category_internal' => $category, // Store internal name for filtering
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

            // Filter by category
            if (!empty($category)) {
                // Map dropdown display name to internal category if needed
                $categoryDisplayToInternal = [
                    'Application Domain' => 'ApplicationDomain',
                    'Application User' => 'ApplicationUser',
                    'Database User' => 'DatabaseUser',
                ];
                $internalCategory = $categoryDisplayToInternal[$category] ?? $category;
                
                $allTools = $allTools->filter(function ($tool) use ($internalCategory) {
                    return $tool['category_internal'] === $internalCategory;
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

            // Get unique categories for filter
            $categories = collect(config('mcp_tools.tools'))->map(function ($tool) {
                $classPath = $tool['class'];
                $segments = explode('\\', $classPath);
                return $segments[count($segments) - 2] ?? 'Other';
            })->unique()->sort()->values()->toArray();

            return view('tools', [
                'user' => $user,
                'tools' => $tools,
                'totalTools' => $totalTools,
                'totalPages' => $totalPages,
                'currentPage' => $page,
                'perPage' => $perPage,
                'searchQuery' => $search,
                'selectedCategory' => $category,
                'categories' => $categories,
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
                'selectedCategory' => '',
                'categories' => [],
            ])->with('error', 'Unable to load tools. Please try again.');
        }
    }
}
