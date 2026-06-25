<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

/**
 * Register Controller
 *
 * Handles new user registration including displaying the registration form
 * and processing new user sign-ups.
 */
class RegisterController extends Controller
{
    /**
     * Display the registration page.
     *
     * @return \Illuminate\View\View The registration view
     */
    public function showRegisterForm()
    {
        try {
            return view('auth.register');
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Unable to load registration page. Please try again.');
        }
    }

    /**
     * Create a new user account.
     *
     * @param Request $request The incoming HTTP request
     * @return \Illuminate\Http\RedirectResponse Redirects to dashboard on success
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
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

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::login($user);
            return redirect('/dashboard');
        } catch (Exception $e) {
            return back()->withErrors([
                'email' => 'Registration failed. Please try again.',
            ])->onlyInput('name', 'email');
        }
    }
}
