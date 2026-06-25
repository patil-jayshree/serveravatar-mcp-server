@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <div style="text-align: center;">
                <div style="display: inline-flex; align-items: center; gap: 8px;">
                    <span style="font-size: 24px;">⚡</span>
                    <span style="font-weight: 800; font-size: 18px; color: #7c3aed;">ServerAvatar</span>
                    <span style="background: rgba(99, 102, 241, 0.15); color: #6366f1; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 700; letter-spacing: 0.05em;">MCP</span>
                </div>
            </div>
        @endcomponent
    @endslot

    {{-- Body --}}
    <div style="padding: 20px 0;">
        <h1 style="font-size: 24px; font-weight: 800; color: #1a1a25; margin: 0 0 16px 0; text-align: center;">
            Password Reset Request
        </h1>

        <p style="font-size: 16px; color: #475569; line-height: 1.6; margin: 0 0 16px 0; text-align: center;">
            Hi there,
        </p>

        <p style="font-size: 16px; color: #475569; line-height: 1.6; margin: 0 0 24px 0; text-align: center;">
            We received a request to reset the password for your <strong style="color: #7c3aed;">ServerAvatar MCP</strong> account associated with this email address.
        </p>

        <p style="font-size: 16px; color: #475569; line-height: 1.6; margin: 0 0 32px 0; text-align: center;">
            Click the button below to reset your password:
        </p>

        {{-- Reset Button --}}
        <div style="text-align: center; margin: 32px 0;">
            @component('mail::button', ['url' => $url, 'color' => 'primary'])
                Reset Password
            @endcomponent
        </div>

        <p style="font-size: 14px; color: #6b6b7b; line-height: 1.6; margin: 0 0 16px 0; text-align: center;">
            Or copy and paste this link into your browser:
        </p>

        <p style="font-size: 12px; color: #6366f1; word-break: break-all; margin: 0 0 24px 0; text-align: center;">
            {{ $url }}
        </p>

        <div style="background: rgba(239, 68, 68, 0.08); border-left: 4px solid #ef4444; border-radius: 6px; padding: 12px 16px; margin: 24px 0;">
            <p style="font-size: 13px; color: #dc2626; margin: 0; line-height: 1.5;">
                <strong>⚠️ Security Notice:</strong> This password reset link will expire in <strong>60 minutes</strong>. If you didn't request a password reset, please ignore this email. Your password will remain unchanged.
            </p>
        </div>
    </div>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <div style="text-align: center; padding-top: 20px; border-top: 1px solid rgba(0, 0, 0, 0.08);">
                <p style="font-size: 12px; color: #94a3b8; margin: 0 0 8px 0;">
                    This email was sent by <strong style="color: #7c3aed;">ServerAvatar MCP</strong>
                </p>
                <p style="font-size: 11px; color: #94a3b8; margin: 0;">
                    © {{ date('Y') }} ServerAvatar. All rights reserved.
                </p>
            </div>
        @endcomponent
    @endslot
@endcomponent
