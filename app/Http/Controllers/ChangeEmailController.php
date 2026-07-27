<?php

namespace App\Http\Controllers;

use App\Mail\ChangeEmailMail;
use App\Models\EmailChangeToken;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ChangeEmailController extends Controller
{
    /**
     * Request email change - sends verification to new email
     */
    public function requestChange(Request $request): JsonResponse
    {
        $request->validate([
            'new_email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string',
        ]);

        $user = $request->user();

        // Verify current password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 422);
        }

        // Check if new email is same as current
        if ($request->new_email === $user->email) {
            return response()->json(['error' => 'New email is the same as your current email'], 422);
        }

        // Delete any existing tokens for this user
        EmailChangeToken::where('user_id', $user->id)->delete();

        // Generate token
        $token = Str::random(64);

        // Store token
        EmailChangeToken::create([
            'user_id' => $user->id,
            'new_email' => $request->new_email,
            'token' => $token,
            'expires_at' => Carbon::now()->addHour(),
        ]);

        // Send verification email
        Mail::to($request->new_email)->send(new ChangeEmailMail($user, $request->new_email, $token));

        // Log activity
        ActivityLogger::log(
            $user,
            'email_change_requested',
            'Email change requested.',
            ['new_email' => $request->new_email, 'badge' => 'Requested']
        );

        return response()->json(['message' => 'Verification email sent to your new email address']);
    }

    /**
     * Confirm email change via token (from email link)
     */
    public function confirmChange(string $token): \Illuminate\Http\RedirectResponse
    {
        $emailToken = EmailChangeToken::where('token', $token)->first();

        if (!$emailToken || $emailToken->expires_at < Carbon::now()) {
            return redirect()->route('account')->with('error', 'Invalid or expired email change link');
        }

        $user = $emailToken->user;
        $oldEmail = $user->email;
        $newEmail = $emailToken->new_email;

        DB::transaction(function () use ($user, $newEmail, $emailToken) {
            $user->email = $newEmail;
            $user->save();
            $emailToken->delete();
        });

        // Send notification to old email (optional)
        if ($oldEmail) {
            // You could send a "your email changed" notification here
        }

        // Log activity
        ActivityLogger::log(
            $user,
            'email_updated',
            'Email verify and changed successfully.',
            ['old_email' => $oldEmail, 'new_email' => $newEmail, 'badge' => 'Verified']
        );

        return redirect()->route('account')->with([
            'email_updated' => true,
            'old_email' => $oldEmail,
            'new_email' => $newEmail,
            'updated_at' => Carbon::now($user->timezone ?? 'UTC')->format('F d, Y h:i A')
        ]);
    }

    /**
     * Cancel pending email change
     */
    public function cancelChange(Request $request): JsonResponse
    {
        $user = $request->user();
        $deleted = EmailChangeToken::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Email change cancelled']);
    }
}
