@component('mail::message')
# Password Reset Request

Hi there,

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
@endcomponent
