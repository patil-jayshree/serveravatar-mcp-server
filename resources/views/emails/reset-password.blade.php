<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f4f5;">
    <table role="presentation" border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                <table role="presentation" border="0" width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 8px;">
                    <!-- Header with Logo -->
                    <tr>
                        <td style="padding: 30px; text-align: center; border-bottom: 1px solid #e5e7eb;">
                            <img src="https://mcp.178.105.137.4.nip.io/favicon.png" alt="Logo" style="width: 36px; height: 36px; border-radius: 6px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto;">
                            <div style="font-size: 18px; font-weight: 700; color: #7c3aed;">ServerAvatar <span style="font-size: 12px; color: #6366f1;">MCP</span></div>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h1 style="font-size: 20px; font-weight: 700; color: #18181b; margin: 0 0 20px 0;">Password Reset Request</h1>
                            <p style="font-size: 16px; color: #374151; margin: 0 0 16px 0;">Hi <strong>{{ $name }}</strong>,</p>
                            <p style="font-size: 16px; color: #374151; margin: 0 0 24px 0;">We received a request to reset the password for your <strong style="color: #7c3aed;">ServerAvatar MCP</strong> account.</p>
                            <p style="font-size: 16px; color: #374151; margin: 0 0 24px 0;">To reset your password, please click the button below:</p>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                <tr>
                                    <td style="border-radius: 6px; background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);">
                                        <a href="{{ $url }}" style="display: inline-block; padding: 14px 28px; font-size: 16px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 6px;">Reset Password</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size: 14px; color: #6b7280; margin: 24px 0 8px 0; text-align: center;">Or copy and paste this link:</p>
                            <p style="font-size: 13px; color: #6366f1; word-break: break-all; text-align: center;">{{ $url }}</p>
                            <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 12px 16px; margin: 24px 0; border-radius: 4px;">
                                <p style="font-size: 14px; color: #dc2626; margin: 0;"><strong>⚠️ Security Notice:</strong> This password reset link will expire in <strong>60 minutes</strong>. If you didn't request a password reset, please ignore this email.</p>
                            </div>
                            <p style="font-size: 14px; color: #374151; margin: 24px 0 0 0;">Thanks,<br><strong>ServerAvatar MCP</strong></p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 30px; background: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center;">
                            <p style="font-size: 12px; color: #9ca3af; margin: 0;">© {{ date('Y') }} ServerAvatar. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
