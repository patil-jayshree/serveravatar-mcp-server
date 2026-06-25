<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\McpConnectionTracker;

/**
 * Clients Controller
 *
 * Handles the display of AI clients currently connected to the ServerAvatar MCP server.
 * Shows real-time connection status and activity information for MCP clients.
 */
class ClientsController extends Controller
{
    /**
     * Display list of active AI clients connected to the MCP server.
     *
     * This method retrieves all currently connected MCP clients for the authenticated user.
     * Clients are tracked based on recent activity (within the last 30 minutes).
     * Each client record includes: name, icon, client type, and last activity timestamp.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\View\View The clients view with connected client data
     */
    public function index(Request $request) {
        $user = $request->user();
        $connectedClients = McpConnectionTracker::getConnectedClients($user);

        return view('clients', [
            'user' => $user,
            'connectedClients' => $connectedClients,
        ]);
    }
}
