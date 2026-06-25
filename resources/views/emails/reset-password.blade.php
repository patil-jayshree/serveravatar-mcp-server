<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Password Reset - ServerAvatar MCP</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f4f5;">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                <!-- Email Container -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <!-- Header with Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%); padding: 30px; text-align: center;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td style="padding-right: 12px; vertical-align: middle;">
                                        <span style="font-size: 32px;">⚡</span>
                                    </td>
                                    <td style="text-align: left; vertical-align: middle;">
                                        <span style="font-size: 24px; font-weight: 800; color: #ffffff;">ServerAvatar</span>
                                        <span style="display: inline-block; background: rgba(255,255,255,0.2); color: #ffffff; padding: 3px 10px; border-radius: 10px; font-size: 12px; font-weight: 700; vertical-align: middle; margin-left: 8px;">MCP</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Email Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <!-- Title -->
                            <h1 style="margin: 0 0 24px 0; font-size: 24px; font-weight: 700; color: #1a1a25; text-align: center;">
                                Password Reset Request
                            </h1>

                            <!-- Greeting -->
                            <p style="margin: 0 0 20px 0; font-size: 16px; color: #374151; line-height: 1.6;">
                                Hi <strong>{{ $name }}</strong>,
                            </p>

                            <!-- Message -->
                            <p style="margin: 0 0 24px 0; font-size: 16px; color: #374151; line-height: 1.6;">
                                We received a request to reset the password for your <strong style="color: #7c3aed;">ServerAvatar MCP</strong> account.
                            </p>

                            <!-- Button -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 32px 0;">
                                <tr>
                                    <td style="border-radius: 8px; background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);">
                                        <a href="{{ $url }}" target="_blank" rel="noopener" style="display: inline-block; padding: 16px 32px; font-size: 16px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 8px;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Fallback Link -->
                            <p style="margin: 24px 0 16px 0; font-size: 14px; color: #6b7280; text-align: center;">
                                Or copy and paste this link into your browser:
                            </p>
                            <p style="margin: 0 0 24px 0; font-size: 13px; color: #6366f1; word-break: break-all; text-align: center;">
                                {{ $url }}
                            </p>

                            <!-- Divider -->
                            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 32px 0;">

                            <!-- Security Notice -->
                            <div style="background: #fef2f2; border-left: 4px solid #ef4444; border-radius: 4px; padding: 16px; margin: 24px 0;">
                                <p style="margin: 0; font-size: 14px; color: #dc2626; line-height: 1.5;">
                                    <strong>⚠️ Security Notice:</strong> This password reset link will expire in <strong>60 minutes</strong>. If you didn't request a password reset, please ignore this email. Your password will remain unchanged.
                                </p>
                            </div>

                            <!-- Thanks -->
                            <p style="margin: 24px 0 0 0; font-size: 14px; color: #374151; line-height: 1.6;">
                                Thanks,<br>
                                <strong>ServerAvatar MCP</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                © {{ date('Y') }} ServerAvatar. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
