@component('mail::message')
# Verify Your New Email

Hi **{{ $user->name }}**,

We received a request to change the email address for your **ServerAvatar MCP** account to:

@component('mail::panel')
{{ $newEmail }}
@endcomponent

To confirm this email change, please click the button below:

@component('mail::button', ['url' => $confirmUrl, 'color' => 'primary'])
Confirm Email Change
@endcomponent

**&#9888; Security Notice:** This email verification link will expire in **60 minutes**. If you didn't request this email change, please ignore this email. Your email address will remain unchanged.

Thanks,
**ServerAvatar MCP**
@endcomponent
