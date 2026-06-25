<table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto;">
    <tr>
        <td style="background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%); padding: 30px; text-align: center;">
            <table role="presentation" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                <tr>
                    <td style="padding-right: 12px;">
                        <span style="font-size: 32px;">⚡</span>
                    </td>
                    <td style="text-align: left;">
                        <span style="font-size: 24px; font-weight: 800; color: white;">ServerAvatar</span>
                        <span style="display: inline-block; background: rgba(255,255,255,0.2); color: white; padding: 2px 10px; border-radius: 10px; font-size: 12px; font-weight: 700; vertical-align: middle; margin-left: 8px;">MCP</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

# Password Reset Request

Hi **{{ $name }}**,

We received a request to reset the password for your **ServerAvatar MCP** account.

To reset your password, please click the button below:

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Reset Password
@endcomponent

Or copy and paste this link into your browser:

{{ $url }}

**⚠️ Security Notice:** This password reset link will expire in **60 minutes**. If you didn't request a password reset, please ignore this email. Your password will remain unchanged.

---
**ServerAvatar MCP**  
© {{ date('Y') }} ServerAvatar. All rights reserved.
