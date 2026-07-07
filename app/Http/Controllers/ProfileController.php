<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\ActivityLogger;
use Exception;

class ProfileController extends Controller
{
    public function show()
    {
        try {
            return view('profile');
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to load profile. Please try again.');
        }
    }

    public function getProfile()
    {
        try {
            $user = auth()->user();
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Unable to fetch profile. Please try again.',
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $user = auth()->user();
            $user->update($validated);

            ActivityLogger::profileUpdated($user);

            return response()->json(['success' => true, 'message' => 'Profile updated successfully!']);
        } catch (Exception $e) {
            $statusCode = method_exists($e, 'status') ? $e->status() : 500;
            return response()->json([
                'success' => false,
                'error' => 'Failed to update profile. Please try again.',
            ], $statusCode);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['current_password' => ['Current password is incorrect']],
            ], 422);
        }

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
        ], [
            'password.regex:/[A-Z]/' => 'Password must contain at least one uppercase letter',
            'password.regex:/[a-z]/' => 'Password must contain at least one lowercase letter',
            'password.regex:/[0-9]/' => 'Password must contain at least one number',
            'password.regex:/[@$!%*?&]/' => 'Password must contain at least one special character (@$!%*?&)',
            'password.confirmed' => 'Password confirmation does not match',
        ]);

        try {
            $user->update(['password' => Hash::make($request->password)]);
            ActivityLogger::passwordChanged($user);
            return response()->json(['success' => true, 'message' => 'Password updated successfully!']);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to update password. Please try again.',
            ], 500);
        }
    }

    public function deleteAccount(Request $request)
    {
        try {
            $user = auth()->user();
            ActivityLogger::accountDeleted($user);
            $user->delete();

            return response()->json(['success' => true, 'message' => 'Account deleted successfully!']);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to delete account. Please try again.',
            ], 500);
        }
    }

    public function password()
    {
        try {
            return view('profile.password');
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to load password page. Please try again.');
        }
    }

    public function api()
    {
        try {
            $user = auth()->user();
            return view('profile.api', compact('user'));
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to load API settings. Please try again.');
        }
    }
}
