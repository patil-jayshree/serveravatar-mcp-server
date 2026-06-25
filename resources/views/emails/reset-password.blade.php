@component('mail::layout')

    {{-- Header with Logo --}}
    @slot('header')
        <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td style="padding: 15px 0; text-align: center;">
                    <img src="https://mcp.178.105.137.4.nip.io/favicon.png" alt="Logo" style="width: 32px; height: 32px; border-radius: 6px; vertical-align: middle; margin-right: 8px;">
                    <span style="font-size: 18px; font-weight: 700; color: #7c3aed; vertical-align: middle;">ServerAvatar</span>
                    <span style="display: inline-block; background: rgba(99, 102, 241, 0.12); color: #6366f1; padding: 2px 7px; border-radius: 6px; font-size: 10px; font-weight: 700; vertical-align: middle; margin-left: 5px;">MCP</span>
                </td>
            </tr>
        </table>
    @endslot

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

    Thanks,
    **ServerAvatar MCP**

    @slot('footer')
        @component('mail::footer')
            <p style="font-size: 11px; color: #94a3b8; margin: 0;">© {{ date('Y') }} ServerAvatar. All rights reserved.</p>
        @endcomponent
    @endslot

@endcomponent
