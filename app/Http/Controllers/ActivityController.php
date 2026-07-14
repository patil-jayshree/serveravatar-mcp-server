<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Exception;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $perPage = 10;
            $page = $request->get('page', 1);

            $query = Activity::where('user_id', $user->id)->orderBy('created_at', 'desc');
            
            // Filters
            $searchQuery = $request->get('search', '');
            $timeFilter = $request->get('time', '');
            $eventFilter = $request->get('event', '');
            $clientFilter = $request->get('client', '');
            
            if ($searchQuery) {
                $query->where(function($q) use ($searchQuery) {
                    $q->where('description', 'like', '%' . $searchQuery . '%')
                      ->orWhere('client_name', 'like', '%' . $searchQuery . '%')
                      ->orWhere('ip_address', 'like', '%' . $searchQuery . '%');
                });
            }
            
            if ($eventFilter) {
                $query->where('type', $eventFilter);
            }
            
            if ($clientFilter) {
                $query->where('client_name', $clientFilter);
            }
            
            if ($timeFilter) {
                switch ($timeFilter) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case '7days':
                        $query->where('created_at', '>=', now()->subDays(7));
                        break;
                    case '30days':
                        $query->where('created_at', '>=', now()->subDays(30));
                        break;
                    case '90days':
                        $query->where('created_at', '>=', now()->subDays(90));
                        break;
                }
            }
            
            $totalActivities = $query->count();
            $totalPages = ceil($totalActivities / $perPage);
            $offset = ($page - 1) * $perPage;
            $activities = $query->skip($offset)->take($perPage)->get();
            
            // Get unique clients for filter
            $clients = Activity::where('user_id', $user->id)
                ->whereNotNull('client_name')
                ->distinct()
                ->pluck('client_name');
            
            return view('activity', [
                'user' => $user,
                'activities' => $activities,
                'totalActivities' => $totalActivities,
                'totalPages' => $totalPages,
                'currentPage' => (int) $page,
                'perPage' => $perPage,
                'searchQuery' => $searchQuery,
                'timeFilter' => $timeFilter,
                'eventFilter' => $eventFilter,
                'clientFilter' => $clientFilter,
                'clients' => $clients,
            ]);
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to load activities. Please try again.');
        }
    }

    public function fetch(Request $request)
    {
        try {
            $user = $request->user();
            $perPage = 10;
            $page = $request->get('page', 1);

            $query = Activity::where('user_id', $user->id)->orderBy('created_at', 'desc');
            
            // Filters
            $searchQuery = $request->get('search', '');
            $timeFilter = $request->get('time', '');
            $eventFilter = $request->get('event', '');
            $clientFilter = $request->get('client', '');
            
            if ($searchQuery) {
                $query->where(function($q) use ($searchQuery) {
                    $q->where('description', 'like', '%' . $searchQuery . '%')
                      ->orWhere('client_name', 'like', '%' . $searchQuery . '%')
                      ->orWhere('ip_address', 'like', '%' . $searchQuery . '%');
                });
            }
            
            if ($eventFilter) {
                $query->where('type', $eventFilter);
            }
            
            if ($clientFilter) {
                $query->where('client_name', $clientFilter);
            }
            
            if ($timeFilter) {
                switch ($timeFilter) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case '7days':
                        $query->where('created_at', '>=', now()->subDays(7));
                        break;
                    case '30days':
                        $query->where('created_at', '>=', now()->subDays(30));
                        break;
                    case '90days':
                        $query->where('created_at', '>=', now()->subDays(90));
                        break;
                }
            }
            
            $totalActivities = $query->count();
            $totalPages = ceil($totalActivities / $perPage);
            $offset = ($page - 1) * $perPage;
            $activities = $query->skip($offset)->take($perPage)->get();

            $html = '';
            foreach ($activities as $activity) {
                $metadata = $activity->metadata ?? [];
                $hasPayload = !empty($metadata['arguments']) || !empty($metadata['response']);
                $clientInitials = $this->getClientInitials($activity->client_name);
                $clientColor = $this->getClientColor($activity->client_name);
                
                $html .= '<tr data-id="' . $activity->id . '" data-activity=\'' . json_encode([
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'type_label' => $activity->typeLabel,
                    'color' => $activity->color,
                    'icon' => $activity->icon,
                    'client_name' => $activity->client_name,
                    'client_initials' => $clientInitials,
                    'client_color' => $clientColor,
                    'client_logo' => $this->getClientLogo($activity->client_name),
                    'client_type' => $this->getClientType($activity->client_name),
                    'ip_address' => $activity->ip_address,
                    'time_ago' => $activity->created_at->diffForHumans(),
                    'metadata' => $metadata,
                ]) . '\'>';
                
                // Event column
                $html .= '<td>';
                $html .= '<div class="event-cell">';
                $html .= '<div class="event-icon" style="background: rgba(139, 92, 246, 0.1);">';
                $html .= $activity->icon;
                $html .= '</div>';
                $html .= '<div class="event-info">';
                $html .= '<span class="event-desc">' . e($activity->description) . '</span>';
                                $html .= '<span class="event-badge badge-' . $activity->color . '">' . e($activity->typeLabel) . '</span>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</td>';
                
                // Client column
                $html .= '<td>';
                $html .= '<div class="client-cell">';
                $logo = $this->getClientLogo($activity->client_name);
                if ($logo) {
                    $html .= '<div class="client-avatar"><img src="' . $logo['light'] . '" alt="" width="28" height="28" class="icon-light"><img src="' . $logo['dark'] . '" alt="" width="28" height="28" class="icon-dark"></div>';
                } else {
                    // Set background based on activity type for api_key_updated and profile_updated
                    $bgColor = $clientColor;
                    if ($activity->type === 'api_key_updated') {
                        $bgColor = 'rgba(245, 158, 11, 0.2)';
                    } elseif ($activity->type === 'profile_updated') {
                        $bgColor = 'rgba(6, 182, 212, 0.2)';
                    }
                    $html .= '<div class="client-avatar" style="background: ' . $bgColor . ';">' . $clientInitials . '</div>';
                }
                $html .= '<div>';
                $html .= '<div class="client-name">' . e($activity->client_name ?? 'System') . '</div>';
                $html .= '<div class="client-type">' . $this->getClientType($activity->client_name) . '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</td>';
                
                // Time column
                $html .= '<td>';
                $html .= '<div class="time-cell">';
                $html .= '<span class="time-relative">' . $activity->created_at->diffForHumans() . '</span>';
                $html .= '<span class="time-absolute">' . $activity->created_at->format('M d, Y') . ' • ' . $activity->created_at->format('h:i A') . '</span>';
                $html .= '</div>';
                $html .= '</td>';
                
                // Actions column
                $html .= '<td>';
                if ($hasPayload) {
                    $html .= '<button class="view-btn" onclick="openEventPanel(' . $activity->id . ')"><i class="fas fa-eye"></i> View</button>';
                } else {
                    $html .= '<span class="no-actions">—</span>';
                }
                $html .= '</td>';
                
                $html .= '</tr>';
            }

            if ($activities->isEmpty()) {
                $html .= '<tr><td colspan="4"><div class="activity-empty"><i class="fas fa-clock"></i><p>No activity recorded yet.</p></div></td></tr>';
            }

            return response()->json([
                'success' => true,
                'html' => $html,
                'totalActivities' => $totalActivities,
                'totalPages' => $totalPages,
                'currentPage' => (int) $page,
            ]);
        } catch (Exception $e) {
            \Log::error('Activity fetch error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'Unable to load activities: ' . $e->getMessage(),
            ]);
        }
    }
    
    private function getClientInitials($name)
    {
        if (!$name) return 'SA';
        $name = strtolower($name);
        if (strpos($name, 'chatgpt') !== false) return 'CG';
        if (strpos($name, 'claude') !== false) return 'CL';
        if (strpos($name, 'cursor') !== false) return 'CU';
        if (strpos($name, 'vscode') !== false) return 'VS';
        if (strpos($name, 'windsurf') !== false) return 'WS';
        if (strpos($name, 'perplexity') !== false) return 'PP';
        if (strpos($name, 'zed') !== false) return 'ZD';
        if (strpos($name, 'continue') !== false) return 'CT';
        if (strpos($name, 'gemini') !== false) return 'GM';
        if (strpos($name, 'mcp client') !== false) return 'MC';
        return strtoupper(substr($name, 0, 2));
    }
    
    private function getClientColor($name)
    {
        if (!$name) return '#8b5cf6';
        $name = strtolower($name);
        if (strpos($name, 'chatgpt') !== false) return '#10a37f';
        if (strpos($name, 'claude') !== false) return '#d97706';
        if (strpos($name, 'cursor') !== false) return '#22c55e';
        if (strpos($name, 'vscode') !== false) return '#007acc';
        if (strpos($name, 'windsurf') !== false) return '#6b7280';
        if (strpos($name, 'perplexity') !== false) return '#6366f1';
        if (strpos($name, 'zed') !== false) return '#22c55e';
        if (strpos($name, 'continue') !== false) return '#8b5cf6';
        if (strpos($name, 'gemini') !== false) return '#f59e0b';
        if (strpos($name, 'mcp client') !== false) return '#06b6d4';
        return '#8b5cf6';
    }
    
    private function getClientLogo($name)
    {
        if (!$name) return null;
        $name = strtolower($name);
        if (strpos($name, 'chatgpt') !== false) {
            return ['light' => '/images/clients/chatgpt-light.png', 'dark' => '/images/clients/chatgpt-dark.png'];
        }
        if (strpos($name, 'claude') !== false) {
            return ['light' => '/images/clients/claude.png', 'dark' => '/images/clients/claude.png'];
        }
        if (strpos($name, 'cursor') !== false) {
            return ['light' => '/images/clients/cursor-light.png', 'dark' => '/images/clients/cursor-dark.png'];
        }
        if (strpos($name, 'vscode') !== false) {
            return ['light' => '/images/clients/vscode.png', 'dark' => '/images/clients/vscode.png'];
        }
        if (strpos($name, 'windsurf') !== false) {
            return ['light' => '/images/clients/windsurf-light.png', 'dark' => '/images/clients/windsurf-dark.png'];
        }
        if (strpos($name, 'perplexity') !== false) {
            return ['light' => '/images/clients/perplexity-light.png', 'dark' => '/images/clients/perplexity-dark.png'];
        }
        if (strpos($name, 'zed') !== false) {
            return ['light' => '/images/clients/zed.png', 'dark' => '/images/clients/zed.png'];
        }
        if (strpos($name, 'continue') !== false) {
            return ['light' => '/images/clients/continue.png', 'dark' => '/images/clients/continue.png'];
        }
        if (strpos($name, 'gemini') !== false) {
            return ['light' => '/images/clients/gemini.png', 'dark' => '/images/clients/gemini.png'];
        }
        return null;
    }
    
    private function getClientType($name)
    {
        if (!$name) return 'AI Client';
        $name = strtolower($name);
        if (strpos($name, 'chatgpt') !== false) return 'AI Clients';
        if (strpos($name, 'claude') !== false) return 'AI Clients';
        if (strpos($name, 'cursor') !== false) return 'AI IDE';
        if (strpos($name, 'vscode') !== false) return 'IDE';
        if (strpos($name, 'windsurf') !== false) return 'AI IDE';
        if (strpos($name, 'perplexity') !== false) return 'AI Clients';
        if (strpos($name, 'zed') !== false) return 'IDE';
        if (strpos($name, 'continue') !== false) return 'IDE Extension';
        if (strpos($name, 'gemini') !== false) return 'AI Clients';
        if (strpos($name, 'mcp client') !== false) return 'Web Application';
        return 'AI Client';
    }
}
