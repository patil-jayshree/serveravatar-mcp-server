<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityLogger;
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
            $totalActivities = $query->count();
            $totalPages = ceil($totalActivities / $perPage);
            $offset = ($page - 1) * $perPage;
            $activities = $query->skip($offset)->take($perPage)->get();

            return view('activity', [
                'user' => $user,
                'activities' => $activities,
                'totalActivities' => $totalActivities,
                'totalPages' => $totalPages,
                'currentPage' => (int) $page,
                'perPage' => $perPage,
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
            $totalActivities = $query->count();
            $totalPages = ceil($totalActivities / $perPage);
            $offset = ($page - 1) * $perPage;
            $activities = $query->skip($offset)->take($perPage)->get();

            $html = '';
            foreach ($activities as $activity) {
                $html .= '<div class="activity-tr">';
                $html .= '<div class="activity-td" style="flex: 1;">';
                $html .= '<div style="display: flex; align-items: center; gap: 0.5rem;">';
                $html .= '<span style="font-size: 1.1rem;">' . $activity->icon . '</span>';
                $html .= '<span class="activity-type-badge badge-' . $activity->badge . '">' . ucfirst(str_replace('_', ' ', $activity->type)) . '</span>';
                $html .= '</div></div>';
                $html .= '<div class="activity-td" style="flex: 1;"><span class="activity-desc">' . $activity->description . '</span></div>';
                $html .= '<div class="activity-td" style="flex: 1;"><span class="activity-client">' . ($activity->client_name ?? '—') . '</span></div>';
                $html .= '<div class="activity-td" style="flex: 1;"><span class="activity-ip">' . ($activity->ip_address ?? '—') . '</span></div>';
                $html .= '<div class="activity-td" style="flex: 1;"><span class="activity-time">' . $activity->created_at->format('M d, Y') . '<br><span style="color: var(--text-muted); font-size: 12px;">' . $activity->created_at->format('h:i A') . '</span></span></div>';
                $html .= '</div>';
            }

            $pagination = '';
            if ($totalPages > 1) {
                $pagination .= '<div class="pagination-info">';
                $pagination .= 'Showing ' . (($page - 1) * $perPage + 1) . ' to ' . min($page * $perPage, $totalActivities) . ' of ' . $totalActivities . ' activities';
                $pagination .= '</div><div class="pagination-buttons">';
                
                if ($page > 1) {
                    $pagination .= '<a href="javascript:void(0)" onclick="loadActivities(' . ($page - 1) . ')" class="page-btn"><i class="fas fa-chevron-left"></i> Previous</a>';
                } else {
                    $pagination .= '<span class="page-btn disabled"><i class="fas fa-chevron-left"></i> Previous</span>';
                }
                
                $start = max(1, $page - 1);
                $end = min($totalPages, $start + 2);
                if ($end - $start < 2) { $start = max(1, $end - 2); }
                
                if ($start > 1) {
                    $pagination .= '<a href="javascript:void(0)" onclick="loadActivities(1)" class="page-btn">1</a>';
                    if ($start > 2) $pagination .= '<span style="padding: 0 4px; color: var(--text-muted);">...</span>';
                }
                
                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $page) {
                        $pagination .= '<span class="page-btn active">' . $i . '</span>';
                    } else {
                        $pagination .= '<a href="javascript:void(0)" onclick="loadActivities(' . $i . ')" class="page-btn">' . $i . '</a>';
                    }
                }
                
                if ($end < $totalPages) {
                    if ($end < $totalPages - 1) $pagination .= '<span style="padding: 0 4px; color: var(--text-muted);">...</span>';
                    $pagination .= '<a href="javascript:void(0)" onclick="loadActivities(' . $totalPages . ')" class="page-btn">' . $totalPages . '</a>';
                }
                
                if ($page < $totalPages) {
                    $pagination .= '<a href="javascript:void(0)" onclick="loadActivities(' . ($page + 1) . ')" class="page-btn">Next <i class="fas fa-chevron-right"></i></a>';
                } else {
                    $pagination .= '<span class="page-btn disabled">Next <i class="fas fa-chevron-right"></i></span>';
                }
                
                $pagination .= '</div>';
            }

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination,
                'totalActivities' => $totalActivities,
                'totalPages' => $totalPages,
                'currentPage' => (int) $page,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to load activities.',
            ]);
        }
    }
}
