<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\McpConnectionTracker;
use App\Mcp\Servers\ServerAvatarServer;
use Exception;

/**
 * Dashboard Controller
 *
 * Handles the main dashboard page and API key management for the MCP server.
 * This is the primary controller for the ServerAvatar MCP web interface.
 */
class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\View\View The dashboard view with aggregated data
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $connectedClients = McpConnectionTracker::getConnectedClients($user);
            $lastLogin = $user->last_login_at
                ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans()
                : ($user->updated_at ? $user->updated_at->diffForHumans() : 'Unknown');
            $toolsCount = ServerAvatarServer::getToolsCount();

            // Fetch real-time analytics (last 7 days)
            $analytics = McpConnectionTracker::getAnalytics($user, '7days');
            $sparklineRequests = McpConnectionTracker::getSparklineData($user, 'requests', 7);
            $sparklineTools = McpConnectionTracker::getSparklineData($user, 'tools', 7);
            $sparklineClients = McpConnectionTracker::getSparklineData($user, 'clients', 7);

            return view('dashboard', [
                'user' => $user,
                'connectedClients' => $connectedClients,
                'lastLogin' => $lastLogin,
                'toolsCount' => $toolsCount,
                'analytics' => $analytics,
                'sparklineRequests' => $sparklineRequests,
                'sparklineTools' => $sparklineTools,
                'sparklineClients' => $sparklineClients,
            ]);
        } catch (Exception $e) {
            return view('dashboard', [
                'user' => $request->user(),
                'connectedClients' => collect(),
                'lastLogin' => 'Unknown',
                'toolsCount' => 0,
                'analytics' => [
                    'total_requests' => 0,
                    'tools_executed' => 0,
                    'active_clients' => 0,
                    'success_rate' => 100,
                    'avg_response_time_ms' => 0,
                ],
                'sparklineRequests' => array_fill(0, 7, 0),
                'sparklineTools' => array_fill(0, 7, 0),
                'sparklineClients' => array_fill(0, 7, 0),
            ])->with('error', 'Unable to load dashboard. Please try again.');
        }
    }

    /**
     * Save the user's ServerAvatar API key.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse Success message with 200 status
     */
    public function saveApiKey(Request $request)
    {
        try {
            $validated = $request->validate([
                'api_key' => 'required|string|min:10',
            ]);

            $user = $request->user();
            $user->api_key = $validated['api_key'];
            $user->api_key_updated_at = now();
            $user->save();

            return response()->json(['status' => 'API key saved successfully.']);
        } catch (Exception $e) {
            $statusCode = method_exists($e, 'status') ? $e->status() : 500;
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save API key. Please try again.',
            ], $statusCode);
        }
    }

    /**
     * Display the Integrations page.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function integrations(Request $request)
    {
        $user = $request->user();
        $connectedClients = McpConnectionTracker::getConnectedClients($user);
        
        return view('integrations', [
            'user' => $user,
            'connectedClients' => $connectedClients,
        ]);
    }

    /**
     * Display the MCP Server page.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function mcpServer(Request $request)
    {
        $user = $request->user();
        $connectedClients = McpConnectionTracker::getConnectedClients($user);
        $toolsCount = ServerAvatarServer::getToolsCount();
        
        return view('mcp-server', [
            'user' => $user,
            'connectedClients' => $connectedClients,
            'toolsCount' => $toolsCount,
        ]);
    }
}
