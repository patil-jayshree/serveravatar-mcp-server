<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ServerAvatar MCP</title>
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
        .auth-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; position: relative; overflow: hidden; }
        .auth-page::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at 30% 20%, var(--accent-primary-muted) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(139, 92, 246, 0.08) 0%, transparent 50%); pointer-events: none; }
        .auth-wrapper { width: 100%; max-width: 440px; position: relative; z-index: 1; }
        .auth-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 2.5rem; box-shadow: var(--shadow-lg); }
        .auth-brand { text-align: center; margin-bottom: 2rem; }
        .auth-logo-wrap { width: 72px; height: 72px; background: var(--gradient-primary); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3); position: relative; }
        .auth-logo-wrap::after { content: ''; position: absolute; inset: -2px; border-radius: calc(var(--radius-lg) + 2px); background: var(--gradient-primary); opacity: 0.3; filter: blur(12px); z-index: -1; }
        .auth-logo-icon { font-size: 32px; color: white; }
        .auth-mcp-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 0.75rem; }
        .auth-title { font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 0.5rem; }
        .auth-subtitle { color: var(--text-secondary); font-size: 0.95rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-primary); }
        .form-label .required { color: #ef4444; margin-left: 2px; }
        .form-input { width: 100%; padding: 12px 16px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 0.95rem; font-family: inherit; transition: all var(--transition-fast); }
        .form-input:focus { outline: none; border-color: var(--accent-primary); box-shadow: 0 0 0 3px var(--accent-primary-muted); }
        .form-input::placeholder { color: var(--text-muted); }
        .btn-primary { background: var(--gradient-primary); color: white; border: none; padding: 14px 24px; border-radius: var(--radius-md); font-weight: 700; font-size: 0.95rem; width: 100%; cursor: pointer; transition: all var(--transition-fast); box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4); }
        .auth-footer { text-align: center; margin-top: 1.5rem; color: var(--text-secondary); font-size: 0.9rem; }
        .auth-footer a { color: var(--accent-primary); text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }
        .alert { padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px; font-size: 0.9rem; }
        .alert-error { background: var(--accent-danger-muted); color: var(--accent-danger); border: 1px solid var(--accent-danger); }
        .alert-success { background: var(--accent-success-muted); color: var(--accent-success); border: 1px solid var(--accent-success); }
        .toast-container { position: fixed; top: 80px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
        .toast { padding: 14px 20px; border-radius: 10px; display: flex; align-items: center; gap: 10px; font-size: 0.9rem; font-weight: 500; box-shadow: 0 4px 20px rgba(0,0,0,0.15); animation: slideIn 0.3s ease forwards; min-width: 280px; max-width: 400px; }
        .toast-error { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .toast-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .toast-info { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .toast.hiding { animation: slideOut 0.3s ease forwards; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
        .form-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .remember-me { display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem; color: var(--text-secondary); }
        .remember-me input { width: 16px; height: 16px; accent-color: var(--accent-primary); }
        .forgot-link { font-size: 0.9rem; color: var(--accent-primary); text-decoration: none; font-weight: 500; }
        .forgot-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="auth-page">
        <div class="auth-wrapper">
            <div class="auth-card">
                <div class="auth-brand">
                    <div class="auth-logo-wrap">
                        <span class="auth-logo-icon">⚡</span>
                    </div>
                    <div class="auth-mcp-badge">ServerAvatar MCP Server</div>
                    <h1 class="auth-title">Welcome Back</h1>
                    <p class="auth-subtitle">Login to continue</p>
                </div>
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', '') }}" placeholder="you@example.com" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password <span class="required">*</span></label>
                        <div style="position: relative;">
                            <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required style="padding-right: 44px;">
                            <button type="button" onclick="toggleLoginPassword()" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 0; display: flex; align-items: center;">
                                <svg class="eye-icon-login" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg class="eye-off-icon-login" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-row">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" id="remember">
                            Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn-primary"><span>🔓</span> Login</button>
                </form>
                <div class="auth-footer">Don't have an account? <a href="{{ route('register') }}">Register</a></div>
            </div>
        </div>
    </div>
    <div class="toast-container" id="toast-container">
        @if ($errors->any())
        <div class="toast toast-error" id="toast-error">
            <span>⚠️</span>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif
        @if (session('status'))
        <div class="toast toast-success" id="toast-success">
            <span>✓</span>
            <span>{{ session('status') }}</span>
        </div>
        @endif
    </div>
    <script>
        function toggleLoginPassword() {
            var input = document.getElementById('password');
            var eyeIcon = document.querySelector('.eye-icon-login');
            var eyeOffIcon = document.querySelector('.eye-off-icon-login');
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                input.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        }
        // Auto-dismiss toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            var toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    toast.classList.add('hiding');
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
