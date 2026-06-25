<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        return view('profile');
    }

    /**
     * Get the current user's profile data.
     *
     * Returns basic profile information for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse User profile data (id, name, email)
     */
    public function getProfile()
    {
        $user = auth()->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /**
     * Update the user's profile name only.
     *
     * A simplified endpoint for updating just the display name.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse Success message
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        auth()->user()->update($validated);

        return response()->json(['success' => true, 'message' => 'Profile updated successfully!']);
    }

    /**
     * Update the user's password.
     *
     * Requires the current password for verification before setting a new one.
     * New password must be at least 8 characters and contain:
     * - At least one uppercase letter
     * - At least one lowercase letter
     * - At least one number
     * - At least one special character (@$!%*?&)
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse Success message or error
     */
    public function updatePassword(Request $request)
    {
        // First validate current_password exists
        $request->validate([
            'current_password' => 'required|string',
        ]);

        $user = auth()->user();

        // Check current password FIRST
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'error' => 'Current password is incorrect'
            ], 422);
        }

        // Only if current password is correct, validate new password requirements
        $validated = $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',      // uppercase letter
                'regex:/[a-z]/',      // lowercase letter
                'regex:/[0-9]/',      // number
                'regex:/[@$!%*?&]/',  // special character
            ],
        ], [
            'password.regex:/[A-Z]/' => 'Password must contain at least one uppercase letter',
            'password.regex:/[a-z]/' => 'Password must contain at least one lowercase letter',
            'password.regex:/[0-9]/' => 'Password must contain at least one number',
            'password.regex:/[@$!%*?&]/' => 'Password must contain at least one special character (@$!%*?&)',
        ]);

        $user->update(['password' => Hash::make($validated['password'])]);

        return response()->json(['success' => true, 'message' => 'Password updated successfully!']);
    }

    /**
     * Delete the user's account.
     *
     * Permanently deletes the authenticated user's account and all associated data.
     * This action cannot be undone.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\JsonResponse Success message
     */
    public function deleteAccount(Request $request)
    {
        $user = auth()->user();
        $user->delete();

        return response()->json(['success' => true, 'message' => 'Account deleted successfully!']);
    }

    /**
     * Display the password change page.
     *
     * @return \Illuminate\View\View The password change view
     */
    public function password()
    {
        return view('profile.password');
    }

    /**
     * Display the API settings page.
     *
     * Shows the user's API token management interface where they can
     * create and revoke personal access tokens for MCP clients.
     *
     * @return \Illuminate\View\View The API settings view with user data
     */
    public function api()
    {
        $user = auth()->user();
        return view('profile.api', compact('user'));
    }
}
