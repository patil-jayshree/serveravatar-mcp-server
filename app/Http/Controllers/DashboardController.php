<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\McpConnectionTracker;
use App\Services\ActivityLogger;
use App\Mcp\Servers\ServerAvatarServer;
use Exception;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $connectedClients = McpConnectionTracker::getConnectedClients($user);
            $lastLogin = $user->last_login_at
                ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans()
                : ($user->updated_at ? $user->updated_at->diffForHumans() : 'Unknown');
            $toolsCount = ServerAvatarServer::getToolsCount();

            $analytics = McpConnectionTracker::getAnalytics($user, '7days');
            $sparklineRequests = McpConnectionTracker::getSparklineData($user, 'requests', 7);
            $sparklineTools = McpConnectionTracker::getSparklineData($user, 'tools', 7);
            $sparklineClients = McpConnectionTracker::getSparklineData($user, 'clients', 7);

            $recentActivities = ActivityLogger::getRecent($user, 5);
            $lastActivity = $recentActivities->first();
            $onboardingComplete = $user->hasApiKey();

            return view('dashboard', [
                'user' => $user,
                'connectedClients' => $connectedClients,
                'lastLogin' => $lastLogin,
                'toolsCount' => $toolsCount,
                'analytics' => $analytics,
                'sparklineRequests' => $sparklineRequests,
                'sparklineTools' => $sparklineTools,
                'sparklineClients' => $sparklineClients,
                'recentActivities' => $recentActivities,
                'lastActivity' => $lastActivity,
                'onboardingComplete' => $onboardingComplete,
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
                'recentActivities' => collect(),
            ])->with('error', 'Unable to load dashboard. Please try again.');
        }
    }

    public function saveApiKey(Request $request)
    {
        try {
            $validated = $request->validate([
                'api_key' => 'required|string|min:10',
            ]);

            $user = $request->user();
            $user->api_key = $validated['api_key'];
            $user->api_key_updated_at = now();
            if (!$user->api_key_created_at) {
                $user->api_key_created_at = now();
            }
            $isNew = !$user->getOriginal('api_key') || empty($user->getOriginal('api_key'));
            $user->save();

            if ($isNew) {
                ActivityLogger::apiKeySaved($user);
            } else {
                ActivityLogger::apiKeyUpdated($user);
            }

            return response()->json(['success' => true, 'message' => 'API key saved successfully.']);
        } catch (Exception $e) {
            $statusCode = method_exists($e, 'status') ? $e->status() : 500;
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save API key. Please try again.',
            ], $statusCode);
        }
    }

    public function deleteApiKey(Request $request)
    {
        try {
            $user = $request->user();
            $user->api_key = null;
            $user->api_key_updated_at = null;
            $user->save();

            ActivityLogger::apiKeyDeleted($user);

            return response()->json(['success' => true, 'message' => 'API key deleted successfully.']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete API key. Please try again.',
            ], 500);
        }
    }

    public function integrations(Request $request)
    {
        $user = $request->user();
        $connectedClients = McpConnectionTracker::getConnectedClients($user);
        
        return view('integrations', [
            'user' => $user,
            'connectedClients' => $connectedClients,
        ]);
    }

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
