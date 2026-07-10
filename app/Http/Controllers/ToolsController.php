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

    /**
     * Fetch tools data via AJAX.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse JSON response with tools HTML
     */
    public function fetch(Request $request)
    {
        try {
            $user = $request->user();
            $perPage = 10;
            $page = $request->get('page', 1);
            $search = $request->get('q', '');
            $category = $request->get('category', '');

            $allTools = collect(config('mcp_tools.tools'))->map(function ($tool) {
                $classPath = $tool['class'];
                $segments = explode('\\', $classPath);
                $category = $segments[count($segments) - 2] ?? 'Other';
                
                $categoryDropdownMap = [
                    'ApplicationDomain' => 'Application Domain',
                    'ApplicationUser' => 'Application User',
                    'DatabaseUser' => 'Database User',
                ];
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
                    'category' => $categoryDropdownMap[$category] ?? $category,
                    'category_badge' => $categoryBadgeMap[$category] ?? $category,
                    'category_internal' => $category,
                ];
            });

            if (!empty($search)) {
                $searchLower = strtolower($search);
                $allTools = $allTools->filter(function ($tool) use ($searchLower) {
                    return str_contains(strtolower($tool['name']), $searchLower)
                        || str_contains(strtolower($tool['description']), $searchLower);
                });
            }

            if (!empty($category)) {
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
            
            if (!empty($search)) {
                $totalPages = 1;
                $page = 1;
                $tools = $allTools;
            } else {
                $totalPages = ceil($totalTools / $perPage);
                $offset = ($page - 1) * $perPage;
                $tools = array_slice($allTools, $offset, $perPage);
            }

            $categories = collect(config('mcp_tools.tools'))->map(function ($tool) {
                $classPath = $tool['class'];
                $segments = explode('\\', $classPath);
                return $segments[count($segments) - 2] ?? 'Other';
            })->unique()->sort()->values()->toArray();

            $html = '';
            if (count($tools) > 0) {
                foreach ($tools as $tool) {
                    $colorIndex = abs(crc32($tool['name'])) % 12;
                    $colors = ['#3b82f6', '#a855f7', '#22c55e', '#f59e0b', '#ef4444', '#0ea5e9', '#6366f1', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#06b6d4'];
                    $color = $colors[$colorIndex];
                    $r = hexdec(substr($color, 1, 2));
                    $g = hexdec(substr($color, 3, 2));
                    $b = hexdec(substr($color, 5, 2));
                    
                    $html .= '<div class="table-row">';
                    $html .= '<div class="tool-name-cell">';
                    $html .= '<span style="width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: rgba(' . $r . ', ' . $g . ', ' . $b . ', 0.15); color: ' . $color . ';"><i class="fas ' . e($tool['icon']) . '"></i></span>';
                    $html .= '<span class="tool-name-text">' . e(ucwords(str_replace('_', ' ', $tool['name']))) . '</span>';
                    $html .= '</div>';
                    $html .= '<div><span class="category-badge" style="display: inline-flex; align-items: center; gap: 4px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">' . e($tool['category_badge']) . '</span></div>';
                    $html .= '<div class="tool-desc-cell"><span title="' . e($tool['description']) . '">' . e($tool['description']) . '</span></div>';
                    $html .= '<div class="tool-status-cell"><span class="status-badge"><span class="status-dot"></span>' . e($tool['status']) . '</span></div>';
                    $html .= '</div>';
                }
            } else {
                $html .= '<div style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">';
                $html .= '<i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>';
                $html .= '<p style="font-size: 16px; font-weight: 500; margin-bottom: 0.5rem;">No tools found</p>';
                $html .= '<p style="font-size: 14px;">Try selecting a different category or clear the filter</p></div>';
            }

            $paginationHtml = '';
            if ($totalPages > 1) {
                $start = max(1, $page - 1);
                $end = min($totalPages, $start + 2);
                if ($end - $start < 2) { $start = max(1, $end - 2); }
                
                $paginationHtml .= '<div class="pagination-info">';
                $paginationHtml .= 'Showing ' . (($page - 1) * $perPage + 1) . ' to ' . min($page * $perPage, $totalTools) . ' of ' . $totalTools . ' tools';
                $paginationHtml .= '</div><div class="pagination-buttons">';
                if ($page > 1) {
                    $paginationHtml .= '<a href="javascript:void(0)" onclick="loadTools(' . ($page - 1) . ')" class="page-btn"><i class="fas fa-chevron-left"></i> Previous</a>';
                } else {
                    $paginationHtml .= '<span class="page-btn disabled"><i class="fas fa-chevron-left"></i> Previous</span>';
                }
                if ($start > 1) {
                    $paginationHtml .= '<a href="javascript:void(0)" onclick="loadTools(1)" class="page-btn">1</a>';
                    if ($start > 2) { $paginationHtml .= '<span style="padding: 0 4px; color: var(--text-muted);">...</span>'; }
                }
                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $page) {
                        $paginationHtml .= '<span class="page-btn active">' . $i . '</span>';
                    } else {
                        $paginationHtml .= '<a href="javascript:void(0)" onclick="loadTools(' . $i . ')" class="page-btn">' . $i . '</a>';
                    }
                }
                if ($end < $totalPages) {
                    if ($end < $totalPages - 1) { $paginationHtml .= '<span style="padding: 0 4px; color: var(--text-muted);">...</span>'; }
                    $paginationHtml .= '<a href="javascript:void(0)" onclick="loadTools(' . $totalPages . ')" class="page-btn">' . $totalPages . '</a>';
                }
                if ($page < $totalPages) {
                    $paginationHtml .= '<a href="javascript:void(0)" onclick="loadTools(' . ($page + 1) . ')" class="page-btn">Next <i class="fas fa-chevron-right"></i></a>';
                } else {
                    $paginationHtml .= '<span class="page-btn disabled">Next <i class="fas fa-chevron-right"></i></span>';
                }
                $paginationHtml .= '</div>';
            }

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $paginationHtml,
                'totalTools' => $totalTools,
                'totalPages' => $totalPages,
                'currentPage' => $page,
                'searchQuery' => $search,
                'selectedCategory' => $category,
                'categories' => $categories,
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Unable to load tools'], 500);
        }
    }
}
