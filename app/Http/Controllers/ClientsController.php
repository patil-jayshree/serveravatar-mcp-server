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

    /**
     * Fetch clients data via AJAX.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse JSON response with clients HTML
     */
    public function fetch(Request $request)
    {
        try {
            $user = $request->user();
            $connectedClients = McpConnectionTracker::getConnectedClients($user);

            $html = '';
            if ($connectedClients->count() > 0) {
                foreach ($connectedClients as $client) {
                    $html .= '<div class="clients-tr">';
                    $html .= '<div class="clients-td" style="flex: 2;">';
                    $html .= '<div style="display: flex; align-items: center; gap: 0.75rem;">';
                    $clientImages = [
                        'Claude' => '/images/clients/claude.png',
                        'Cursor' => '/images/clients/cursor-light.png',
                        'VS Code' => '/images/clients/vscode.png',
                        'ChatGPT' => '/images/clients/chatgpt-light.png',
                        'Windsurf' => '/images/clients/windsurf-light.png',
                        'Zed' => '/images/clients/zed.png',
                        'Continue' => '/images/clients/continue.png',
                    ];
                    $imgSrc = $clientImages[$client->client_name] ?? '/images/clients/default.png';
                    $html .= '<img src="' . e($imgSrc) . '" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';" />';
                    $html .= '<div>';
                    $html .= '<div style="font-weight: 600; font-size: 0.875rem; color: var(--text-primary);">' . e($client->client_name) . '</div>';
                    $html .= '<div style="font-size: 0.75rem; color: var(--text-secondary);">' . e($client->client_version ?? 'Unknown version') . '</div>';
                    $html .= '</div></div></div>';
                    
                    $statusClass = $client->is_active ? 'status-active' : 'status-inactive';
                    $statusText = $client->is_active ? 'Active' : 'Inactive';
                    $html .= '<div class="clients-td" style="flex: 1;"><span class="client-status ' . $statusClass . '">' . $statusText . '</span></div>';
                    
                    $connectedAt = $client->created_at ? $client->created_at->format('M d, Y') : '-';
                    $html .= '<div class="clients-td" style="flex: 1;"><span class="client-date">' . $connectedAt . '</span></div>';
                    
                    $lastActivity = $client->last_activity_at ? $client->last_activity_at->format('M d, Y') : '-';
                    $html .= '<div class="clients-td" style="flex: 1;"><span class="client-date">' . $lastActivity . '</span></div>';
                    
                    $html .= '</div>';
                }
            } else {
                $html .= '<div class="clients-empty" style="text-align: center; padding: 3rem; color: var(--text-secondary);">';
                $html .= '<div class="clients-empty-icon" style="margin-bottom: 1rem;">';
                $html .= '<svg width="80" height="80" viewBox="0 0 80 80" fill="none">';
                $html .= '<circle cx="40" cy="40" r="36" fill="#F3F0FF"/>';
                $html .= '<rect x="16" y="24" width="48" height="36" rx="4" fill="#E9D5FF" stroke="#7C3AED" stroke-width="1.5"/>';
                $html .= '<rect x="20" y="28" width="40" height="28" rx="2" fill="#F8F4FF"/>';
                $html .= '<circle cx="30" cy="40" r="6" fill="#7C3AED" opacity="0.3"/>';
                $html .= '<circle cx="50" cy="40" r="6" fill="#7C3AED" opacity="0.3"/>';
                $html .= '<path d="M26 50 C26 46 30 44 30 44 C30 44 34 46 34 50" stroke="#7C3AED" stroke-width="1.5" stroke-linecap="round"/>';
                $html .= '<path d="M46 50 C46 46 50 44 50 44 C50 44 54 46 54 50" stroke="#7C3AED" stroke-width="1.5" stroke-linecap="round"/>';
                $html .= '</svg></div>';
                $html .= '<div class="clients-empty-title">No clients connected yet</div>';
                $html .= '<div class="clients-empty-desc">Connect an AI client to start using ServerAvatar MCP.</div>';
                $html .= '</div>';
            }

            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $connectedClients->count(),
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Unable to load clients'], 500);
        }
    }
}
