<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\McpConnectionTracker;
use App\Mcp\Servers\ServerAvatarServer;

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
    public function index(Request $request) {
        $user = $request->user();
        $connectedClients = McpConnectionTracker::getConnectedClients($user);
        $lastLogin = $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : ($user->updated_at ? $user->updated_at->diffForHumans() : 'Unknown');
        $toolsCount = ServerAvatarServer::getToolsCount();

        return view('dashboard', [
            'user' => $user,
            'connectedClients' => $connectedClients,
            'lastLogin' => $lastLogin,
            'toolsCount' => $toolsCount,
        ]);
    }

    /**
     * Save the user's ServerAvatar API key.
     *
     * This endpoint allows authenticated users to save their ServerAvatar API key
     * for use with the MCP server tools. The API key is stored securely in the
     * user's record and used for making API calls to ServerAvatar.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse Success message with 200 status
     */
    public function saveApiKey(Request $request) {
        $validated = $request->validate([
            'api_key' => 'required|string|min:10',
        ]);

        $user = $request->user();
        $user->api_key = $validated['api_key'];
        $user->api_key_updated_at = now();
        $user->save();

        return response()->json(['status' => 'API key saved successfully.']);
    }
}
