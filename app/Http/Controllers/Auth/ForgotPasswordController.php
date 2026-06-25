<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a password reset link to the given email.
     */
    public function sendResetLink(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput(['email' => $request->email]);
            }

            // Find user by email
            $user = User::where('email', $request->email)->first();

            // If user exists, send password reset email using our Mailable
            if ($user) {
                // Generate token
                $token = Password::getRepository()->create($user);

                // Send email using our ResetPasswordMail mailable
                Mail::to($user->email)->send(new ResetPasswordMail($user->name, $user->email, $token));
            }

            // Always redirect back with success, regardless of result
            // (Laravel security: don't reveal whether email exists)
            return redirect()->back()
                ->with('status', 'reset_link_sent')
                ->with('sent_email', $request->email);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['email' => 'Unable to send reset link. Please try again.'])
                ->withInput(['email' => $request->email]);
        }
    }
}
