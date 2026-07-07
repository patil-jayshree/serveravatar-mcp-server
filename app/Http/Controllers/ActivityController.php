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
            $activities = Activity::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(25);

            return view('activity', [
                'user' => $user,
                'activities' => $activities,
            ]);
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to load activities. Please try again.');
        }
    }
}
