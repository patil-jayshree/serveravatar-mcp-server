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
                    $isActive = $client->last_activity_at && $client->last_activity_at->gt(now()->subMinutes(15));
                    $clientName = e($client->client_name);
                    
                    $html .= '<div class="clients-tr">';
                    $html .= '<div class="clients-td" style="flex: 2;">';
                    $html .= '<div class="client-info">';
                    $html .= '<div class="client-icon-wrap">';
                    
                    // Client icon with proper fallbacks
                    if ($client->client_name == "Claude" || $client->client_name == "Claude Desktop") {
                        $html .= '<img src="/images/clients/claude.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\'" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;"><i class="fas fa-robot"></i></span>';
                    } elseif ($client->client_name == "Cursor") {
                        $html .= '<img src="/images/clients/cursor-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';" />';
                        $html .= '<img src="/images/clients/cursor-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;">💚</span>';
                    } elseif ($client->client_name == "VS Code" || $client->client_name == "VSCode" || $client->client_name == "Visual Studio Code") {
                        $html .= '<img src="/images/clients/vscode.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\'" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;">💙</span>';
                    } elseif ($client->client_name == "ChatGPT") {
                        $html .= '<img src="/images/clients/chatgpt-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';" />';
                        $html .= '<img src="/images/clients/chatgpt-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;">🤖</span>';
                    } elseif ($client->client_name == "Windsurf") {
                        $html .= '<img src="/images/clients/windsurf-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';" />';
                        $html .= '<img src="/images/clients/windsurf-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;">🌊</span>';
                    } elseif ($client->client_name == "Zed") {
                        $html .= '<img src="/images/clients/zed.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\'" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;"><i class="fas fa-server"></i></span>';
                    } elseif ($client->client_name == "Continue") {
                        $html .= '<img src="/images/clients/continue.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\'" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;">🔗</span>';
                    } elseif ($client->client_name == "Cline") {
                        $html .= '<img src="/images/clients/cline-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';" />';
                        $html .= '<img src="/images/clients/cline-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;"><i class="fas fa-server"></i></span>';
                    } elseif ($client->client_name == "Gemini") {
                        $html .= '<img src="/images/clients/gemini.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\'" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;">🌟</span>';
                    } else {
                        $html .= '<img src="/images/clients/chatgpt-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';" />';
                        $html .= '<img src="/images/clients/chatgpt-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';" />';
                        $html .= '<span class="client-icon-fallback" style="display: none;"><i class="fas fa-laptop"></i></span>';
                    }
                    
                    $html .= '</div>';
                    $html .= '<span class="client-name">' . $clientName . '</span>';
                    $html .= '</div>';
                    $html .= '</div>';
                    
                    $html .= '<div class="clients-td" style="flex: 1;">';
                    if ($isActive) {
                        $html .= '<span class="badge badge-active">Active</span>';
                    } else {
                        $html .= '<span class="badge badge-inactive">Inactive</span>';
                    }
                    $html .= '</div>';
                    
                    $connectedAt = $client->created_at ? $client->created_at->format('M d, Y') : '-';
                    $connectedAtTime = $client->created_at ? $client->created_at->format('h:i A') : '';
                    $html .= '<div class="clients-td" style="flex: 1;">';
                    $html .= '<span class="client-date">' . $connectedAt . '<br><span style="color: var(--text-muted); font-size: 12px;">' . $connectedAtTime . '</span></span>';
                    $html .= '</div>';
                    
                    $lastActivity = $client->last_activity_at ? $client->last_activity_at->diffForHumans() : 'N/A';
                    $html .= '<div class="clients-td" style="flex: 1;">';
                    $html .= '<span class="client-activity">' . $lastActivity . '</span>';
                    $html .= '</div>';
                    
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
