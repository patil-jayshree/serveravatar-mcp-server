<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\McpConnectionTracker;
use Exception;

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
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\View\View The clients view with connected client data
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $connectedClients = McpConnectionTracker::getConnectedClients($user);

            return view('clients', [
                'user' => $user,
                'connectedClients' => $connectedClients,
            ]);
        } catch (Exception $e) {
            return view('clients', [
                'user' => $request->user(),
                'connectedClients' => collect(),
            ])->with('error', 'Unable to load clients. Please try again.');
        }
    }
}
