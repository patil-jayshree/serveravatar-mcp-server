<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Your New Email</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f9fafb; margin: 0; padding: 20px; }
        .container { max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #7c3aed, #5b21b6); padding: 32px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 1.5rem; margin: 0; }
        .body { padding: 32px; }
        .body p { color: #374151; line-height: 1.6; margin: 0 0 16px; }
        .email-box { background: #f3f4f6; border-radius: 8px; padding: 16px; text-align: center; font-weight: 600; color: #111827; margin: 20px 0; }
        .btn { display: inline-block; background: linear-gradient(135deg, #7c3aed, #5b21b6); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; text-align: center; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #9ca3af; font-size: 0.875rem; }
        .warning { background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 12px; font-size: 0.875rem; color: #92400e; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verify Your New Email</h1>
        </div>
        <div class="body">
            <p>Hello {{ $user->name }},</p>
            <p>You requested to change your email address to:</p>
            <div class="email-box">{{ $newEmail }}</div>
            <p>Click the button below to confirm this change:</p>
            <div style="text-align: center;">
                <a href="{{ $confirmUrl }}" class="btn">Confirm Email Change</a>
            </div>
            <p style="font-size: 0.875rem; color: #6b7280;">Or copy and paste this link into your browser:</p>
            <p style="font-size: 0.75rem; word-break: break-all; color: #9ca3af;">{{ $confirmUrl }}</p>
            <div class="warning">
                <strong>⚠️ Important:</strong> This link expires in 1 hour. If you didn't request this change, please ignore this email.
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} ServerAvatar MCP Server
        </div>
    </div>
</body>
</html>
