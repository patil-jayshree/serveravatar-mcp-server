<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

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
    public function showLoginForm()
    {
        try {
            return view('auth.login');
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Unable to load login page. Please try again.');
        }
    }

    /**
     * Authenticate user and create a session.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\RedirectResponse Redirects to dashboard on success, back with errors on failure
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();

                $user = Auth::user();
                $user->last_login_at = now();
                $user->save();

                return redirect()->intended('/dashboard');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } catch (Exception $e) {
            return back()->withErrors([
                'email' => 'An error occurred during login. Please try again.',
            ])->onlyInput('email');
        }
    }

    /**
     * Log the user out and destroy the session.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\RedirectResponse Redirects to home page
     */
    public function logout(Request $request)
    {
        try {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        } catch (Exception $e) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }
}
