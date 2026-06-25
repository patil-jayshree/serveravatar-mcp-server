<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

/**
 * Profile Controller
 *
 * Manages user profile operations including viewing, updating profile information,
 * changing passwords, and account deletion.
 */
class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     *
     * @return \Illuminate\View\View The profile view
     */
    public function show()
    {
        try {
            return view('profile');
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to load profile. Please try again.');
        }
    }

    /**
     * Get the current user's profile data.
     *
     * @return \Illuminate\Http\JsonResponse User profile data (id, name, email)
     */
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

    /**
     * Update the user's profile name only.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse Success message
     */
    public function updateProfile(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            auth()->user()->update($validated);

            return response()->json(['success' => true, 'message' => 'Profile updated successfully!']);
        } catch (Exception $e) {
            $statusCode = method_exists($e, 'status') ? $e->status() : 500;
            return response()->json([
                'success' => false,
                'error' => 'Failed to update profile. Please try again.',
            ], $statusCode);
        }
    }

    /**
     * Update the user's password.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse Success message or error
     */
    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required|string',
            ]);

            $user = auth()->user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Current password is incorrect',
                ], 422);
            }

            $validated = $request->validate([
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
            ]);

            $user->update(['password' => Hash::make($validated['password'])]);

            return response()->json(['success' => true, 'message' => 'Password updated successfully!']);
        } catch (Exception $e) {
            $statusCode = method_exists($e, 'status') ? $e->status() : 500;
            return response()->json([
                'success' => false,
                'error' => 'Failed to update password. Please try again.',
            ], $statusCode);
        }
    }

    /**
     * Delete the user's account.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse Success message
     */
    public function deleteAccount(Request $request)
    {
        try {
            $user = auth()->user();
            $user->delete();

            return response()->json(['success' => true, 'message' => 'Account deleted successfully!']);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to delete account. Please try again.',
            ], 500);
        }
    }

    /**
     * Display the password change page.
     *
     * @return \Illuminate\View\View The password change view
     */
    public function password()
    {
        try {
            return view('profile.password');
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to load password page. Please try again.');
        }
    }

    /**
     * Display the API settings page.
     *
     * @return \Illuminate\View\View The API settings view with user data
     */
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
