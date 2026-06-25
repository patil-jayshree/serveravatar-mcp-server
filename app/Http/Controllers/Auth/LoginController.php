<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Login Controller
 *
 * Handles user authentication including login (creating a session)
 * and logout (destroying the session).
 */
class LoginController extends Controller
{
    /**
     * Display the login page.
     *
     * @return \Illuminate\View\View The login view
     */
    public function showLoginForm() {
        return view('auth.login');
    }

    /**
     * Authenticate user and create a session.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\RedirectResponse Redirects to dashboard on success, back with errors on failure
     */
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();

            // Update last login timestamp
            $user = Auth::user();
            $user->last_login_at = now();
            $user->save();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out and destroy the session.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\RedirectResponse Redirects to home page
     */
    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
