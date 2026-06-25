@component('mail::layout')

    {{-- Header --}}
    @slot('header')
        <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td style="background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%); padding: 25px 30px; text-align: center;">
                    <span style="font-size: 28px; margin-right: 10px;">⚡</span>
                    <span style="font-size: 22px; font-weight: 800; color: white;">ServerAvatar</span>
                    <span style="display: inline-block; background: rgba(255,255,255,0.2); color: white; padding: 2px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; vertical-align: middle; margin-left: 8px;">MCP</span>
                </td>
            </tr>
        </table>
    @endslot

    # Password Reset Request

    Hi **{{ $name }}**,

    We received a request to reset the password for your **ServerAvatar MCP** account.

    To reset your password, please click the button below:

    <table role="presentation" align="center" width="100%" cellpadding="0" cellspacing="0" style="margin: 30px auto; text-align: center;">
        <tr>
            <td align="center" style="border-radius: 6px;">
                <a href="{{ $url }}" style="display: inline-block; background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%); color: #ffffff; font-weight: 600; text-decoration: none; padding: 14px 28px; border-radius: 6px; font-size: 16px; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);">
                    Reset Password
                </a>
            </td>
        </tr>
    </table>

    Or copy and paste this link into your browser:<br>
    <span style="color: #6366f1; word-break: break-all;">{{ $url }}</span>

    ---

    **⚠️ Security Notice:** This password reset link will expire in **60 minutes**. If you didn't request a password reset, please ignore this email. Your password will remain unchanged.

    Thanks,<br>
    **ServerAvatar MCP**

    @slot('footer')
        @component('mail::footer')
            <p style="font-size: 11px; color: #94a3b8; margin: 0;">© {{ date('Y') }} ServerAvatar. All rights reserved.</p>
        @endcomponent
    @endslot

@endcomponent
