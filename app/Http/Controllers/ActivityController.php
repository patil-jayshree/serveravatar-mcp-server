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
}
