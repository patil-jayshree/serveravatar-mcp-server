<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Show the password reset form.
     */
    public function showResetForm(Request $request)
    {
        $token = $request->route('token');
        $email = $request->query('email');

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Handle password reset submission.
     */
    public function reset(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'email' => 'required|email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'not_regex:/\s/',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&]/',
                ],
            ], [
                'password.not_regex' => 'Password must not contain any spaces',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput(['email' => $request->email]);
            }

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->password = \Illuminate\Support\Facades\Hash::make($password);
                    $user->setRememberToken(Str::random(60));
                    $user->save();
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect()->route('login')->with('status', 'Your password has been updated successfully.');
            }

            return redirect()->back()
                ->withErrors(['email' => __($status)])
                ->withInput(['email' => $request->email]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['email' => 'Unable to reset password. Please try again.'])
                ->withInput(['email' => $request->email]);
        }
    }
}
