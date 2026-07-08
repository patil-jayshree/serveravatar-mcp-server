<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        (function() {
            var t = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - ServerAvatar MCP</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0a0a0f; --bg-secondary: #12121a; --bg-tertiary: #1a1a25; --bg-card: #15151f;
            --bg-card-hover: #1c1c28; --bg-input: #1a1a25; --bg-nav: rgba(10, 10, 15, 0.85);
            --text-primary: #ffffff; --text-secondary: #a0a0b0; --text-muted: #6b6b7b; --text-inverse: #0a0a0f;
            --border-color: rgba(255, 255, 255, 0.08); --border-color-hover: rgba(255, 255, 255, 0.15);
            --border-color-active: rgba(99, 102, 241, 0.5);
            --accent-primary: #6366f1; --accent-primary-hover: #818cf8; --accent-primary-muted: rgba(99, 102, 241, 0.15);
            --accent-success: #22c55e; --accent-success-muted: rgba(34, 197, 94, 0.15);
            --accent-danger: #ef4444; --accent-danger-muted: rgba(239, 68, 68, 0.15);
            --gradient-primary: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.5); --shadow-glow: 0 0 40px rgba(99, 102, 241, 0.15);
            --radius-sm: 6px; --radius-md: 10px; --radius-lg: 16px; --radius-xl: 24px;
            --transition-fast: 150ms ease; --transition-normal: 250ms ease;
        }
        [data-theme="light"] {
            --bg-primary: #f8fafc; --bg-secondary: #f1f5f9; --bg-tertiary: #e2e8f0; --bg-card: #ffffff;
            --bg-card-hover: #f8fafc; --bg-input: #f1f5f9; --bg-nav: rgba(255, 255, 255, 0.9);
            --text-primary: #0f172a; --text-secondary: #475569; --text-muted: #94a3b8; --text-inverse: #ffffff;
            --border-color: rgba(0, 0, 0, 0.08); --border-color-hover: rgba(0, 0, 0, 0.15);
            --border-color-active: rgba(99, 102, 241, 0.5);
            --accent-primary: #4f46e5; --accent-primary-hover: #6366f1; --accent-primary-muted: rgba(79, 70, 229, 0.1);
            --accent-success: #16a34a; --accent-success-muted: rgba(22, 163, 74, 0.1);
            --accent-danger: #dc2626; --accent-danger-muted: rgba(220, 38, 38, 0.1);
            --gradient-primary: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1); --shadow-glow: 0 0 40px rgba(79, 70, 229, 0.1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg-primary); color: var(--text-primary); line-height: 1.6; min-height: 100vh; transition: background var(--transition-normal), color var(--transition-normal); }

        /* Theme Toggle */
        .theme-toggle-fixed { position: fixed; top: 20px; right: 20px; z-index: 200; width: 48px; height: 28px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; cursor: pointer; transition: all var(--transition-normal); }
        .theme-toggle-fixed::before { content: '🌙'; position: absolute; left: 4px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 50%; background: var(--bg-tertiary); display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all var(--transition-normal); }
        [data-theme="light"] .theme-toggle-fixed::before { content: '☀️'; left: calc(100% - 24px); }

        /* Toast */
        .toast { position: fixed; top: 90px; right: 20px; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 14px 20px; border-radius: 12px; display: none; align-items: center; gap: 12px; box-shadow: 0 8px 30px rgba(220, 38, 38, 0.4); z-index: 10000; max-width: 350px; }
        .toast.show { display: flex; animation: slideIn 0.3s ease; }
        .toast-icon { width: 28px; height: 28px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: bold; }
        .toast-message { font-size: 0.9rem; font-weight: 600; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* Page */
        .auth-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; position: relative; overflow: hidden; }
        .auth-page::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at 30% 20%, var(--accent-primary-muted) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(139, 92, 246, 0.08) 0%, transparent 50%); pointer-events: none; }

        /* Card */
        .auth-wrapper { width: 100%; max-width: 440px; position: relative; z-index: 1; }
        .auth-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 2.5rem; box-shadow: var(--shadow-lg); }

        /* Brand */
        .auth-brand { text-align: center; margin-bottom: 2rem; }
        .auth-logo-wrap { width: 72px; height: 72px; background: var(--gradient-primary); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3); position: relative; }
        .auth-logo-wrap::after { content: ''; position: absolute; inset: -2px; border-radius: calc(var(--radius-lg) + 2px); background: var(--gradient-primary); opacity: 0.3; filter: blur(12px); z-index: -1; }
        .auth-logo-icon { font-size: 32px; color: white; }
        .auth-mcp-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 0.75rem; }
        .auth-title { font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 0.5rem; }
        .auth-subtitle { color: var(--text-secondary); font-size: 0.95rem; }

        /* Success Alert */
        .alert-success { background: var(--accent-success-muted); color: var(--accent-success); border: 1px solid var(--accent-success); border-left: 4px solid var(--accent-success); border-radius: var(--radius-md); padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 12px; font-size: 0.9rem; }
        .alert-success .check-icon { width: 24px; height: 24px; background: var(--accent-success); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; }
        .alert-success .check-icon svg, .alert-success .check-icon i { width: 14px; height: 14px; font-size: 14px; color: white; }
        .alert-success-text { flex: 1; }
        .alert-success-title { font-weight: 600; margin-bottom: 4px; }
        .alert-success-desc { color: var(--text-secondary); font-size: 0.85rem; line-height: 1.5; }

        /* Form */
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-primary); }
        .form-label .required { color: #ef4444; margin-left: 2px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); display: flex; align-items: center; pointer-events: none; }
        .input-icon svg, .input-icon i { width: auto; height: auto; font-size: 14px; }
        .input-icon-right { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); display: flex; align-items: center; cursor: pointer; }
        .input-icon-right svg, .input-icon-right i { width: auto; height: auto; font-size: 15px; }
        .form-input { width: 100%; padding: 12px 44px; background: var(--bg-input); border: 1.5px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 0.95rem; font-family: inherit; transition: all var(--transition-fast); }
        [data-theme="light"] .form-input { border-color: #c4b5fd; }
        .form-input:focus { outline: none; border-color: var(--accent-primary); box-shadow: 0 0 0 3px var(--accent-primary-muted); }
        .form-input::placeholder { color: var(--text-muted); }
        .form-input.is-invalid { border-color: var(--accent-danger); }

        /* Error message */
        .error-text { color: var(--accent-danger); font-size: 0.8rem; margin-top: 0.4rem; display: block; }

        /* Primary Button */
        .btn-primary { background: var(--gradient-primary); color: white; border: none; padding: 14px 24px; border-radius: var(--radius-md); font-weight: 700; font-size: 0.95rem; width: 100%; cursor: pointer; transition: all var(--transition-fast); box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px; font-family: inherit; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* Footer Link */
        .auth-footer { text-align: center; margin-top: 1.5rem; color: var(--text-secondary); font-size: 0.9rem; }
        .auth-footer a { color: var(--accent-primary); text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }

        /* Password strength */
        .password-hint { display: flex; align-items: center; gap: 6px; color: var(--text-muted); font-size: 0.8rem; margin-top: 0.5rem; }
        .password-hint svg { width: 14px; height: 14px; }
    </style>
</head>
<body>
    <button class="theme-toggle-fixed" onclick="toggleTheme()" title="Toggle theme"></button>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <span class="toast-icon">✕</span>
        <span class="toast-message"></span>
    </div>

    <div class="auth-page">
        <div class="auth-wrapper">
            <div class="auth-card">
                <div class="auth-brand">
                    <div class="auth-logo-wrap">
                        <span class="auth-logo-icon">⚡</span>
                    </div>
                    <div class="auth-mcp-badge">ServerAvatar MCP Server</div>
                    <h1 class="auth-title">Reset Password</h1>
                    <p class="auth-subtitle">Enter your new password below.</p>
                </div>

                {{-- Success State --}}
                @if (session('status'))
                    <div class="alert-success">
                        <div class="check-icon">
                            <i class="fas fa-check" style="font-size: 24px;"></i>
                        </div>
                        <div class="alert-success-text">
                            <div class="alert-success-title">Password reset successfully!</div>
                            <div class="alert-success-desc">Your password has been updated. You can now login with your new password.</div>
                        </div>
                    </div>
                @endif

                {{-- Reset Form --}}
                <form method="post" action="{{ route('password.update') }}" id="resetForm">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <i class="fas fa-envelope" style="font-size: 14px;"></i>
                            </span>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input @error('email') is-invalid @enderror"
                                value="{{ $email ?? old('email', '') }}"
                                placeholder="you@example.com"
                                required
                                autofocus
                            >
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">New Password <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <i class="fas fa-lock" style="font-size: 14px;"></i>
                            </span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input @error('password') is-invalid @enderror"
                                placeholder="Min. 8 characters"
                                required
                            >
                            <span class="input-icon-right" onclick="togglePassword('password', this)" style="cursor: pointer;">
                                <i class="fas fa-eye eye-open" style="font-size: 15px;"></i>
                                <i class="fas fa-eye-slash eye-closed" style="font-size: 15px; display: none;"></i>
                            </span>
                        </div>
                        <div class="password-hint">
                            <i class="fas fa-info-circle" style="font-size: 16px;"></i>
                            Minimum 8 characters
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm Password <span class="required">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <i class="fas fa-lock" style="font-size: 14px;"></i>
                            </span>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-input @error('password_confirmation') is-invalid @enderror"
                                placeholder="Re-enter your password"
                                required
                            >
                            <span class="input-icon-right" onclick="togglePassword('password_confirmation', this)" style="cursor: pointer;">
                                <i class="fas fa-eye eye-open" style="font-size: 15px;"></i>
                                <i class="fas fa-eye-slash eye-closed" style="font-size: 15px; display: none;"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-key" style="font-size: 16px;"></i>
                        Reset Password
                    </button>
                </form>

                <div class="auth-footer">
                    Remember your password? <a href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const theme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved) {
                document.documentElement.setAttribute('data-theme', saved);
            }
        })();

        // Toast notification
        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.querySelector('.toast-message').textContent = message;
            toast.classList.add('show');
            setTimeout(function() {
                toast.classList.remove('show');
            }, 4000);
        }

        // Show error toast if there are validation errors (page load with errors)
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                showToast('{{ $errors->first() }}');
            });
        @endif

        // Toggle password visibility
        function togglePassword(inputId, iconEl) {
            const input = document.getElementById(inputId);
            const eyeOpen = iconEl.querySelector('.eye-open');
            const eyeClosed = iconEl.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }
    </script>
</body>
</html>