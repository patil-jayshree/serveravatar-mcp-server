<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorize Application - ServerAvatar MCP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --bg-primary: #0a0a0f;
            --bg-secondary: #12121a;
            --bg-tertiary: #1a1a25;
            --bg-card: #15151f;
            --bg-card-hover: #1c1c28;
            --bg-input: #1a1a25;
            --text-primary: #ffffff;
            --text-secondary: #a0a0b0;
            --text-muted: #6b6b7b;
            --border-color: rgba(255, 255, 255, 0.08);
            --border-color-hover: rgba(255, 255, 255, 0.15);
            --accent-primary: #6366f1;
            --accent-primary-hover: #818cf8;
            --accent-primary-muted: rgba(99, 102, 241, 0.15);
            --accent-success: #22c55e;
            --accent-success-muted: rgba(34, 197, 94, 0.15);
            --accent-danger: #ef4444;
            --accent-danger-muted: rgba(239, 68, 68, 0.15);
            --gradient-primary: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            --gradient-success: linear-gradient(135deg, #059669 0%, #22c55e 100%);
            --gradient-danger: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.5);
            --shadow-glow: 0 0 40px rgba(99, 102, 241, 0.15);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --transition-fast: 150ms ease;
            --transition-normal: 250ms ease;
        }
        [data-theme="light"] {
            --bg-primary: #f8fafc;
            --bg-secondary: #f1f5f9;
            --bg-tertiary: #e2e8f0;
            --bg-card: #ffffff;
            --bg-card-hover: #f8fafc;
            --bg-input: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border-color: rgba(0, 0, 0, 0.08);
            --border-color-hover: rgba(0, 0, 0, 0.15);
            --accent-primary: #4f46e5;
            --accent-primary-hover: #6366f1;
            --accent-primary-muted: rgba(79, 70, 229, 0.1);
            --accent-success: #16a34a;
            --accent-success-muted: rgba(22, 163, 74, 0.1);
            --accent-danger: #dc2626;
            --accent-danger-muted: rgba(220, 38, 38, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 0 40px rgba(79, 70, 229, 0.1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; -webkit-font-smoothing: antialiased; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            transition: background var(--transition-normal), color var(--transition-normal);
        }
        .theme-toggle-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 200;
            width: 48px;
            height: 28px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            cursor: pointer;
            transition: all var(--transition-normal);
        }
        .theme-toggle-fixed::before {
            content: '🌙';
            position: absolute;
            left: 4px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--bg-tertiary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all var(--transition-normal);
        }
        [data-theme="light"] .theme-toggle-fixed::before {
            content: '☀️';
            left: calc(100% - 24px);
        }
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        .auth-page::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 20%, var(--accent-primary-muted) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(139, 92, 246, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }
        .auth-wrapper {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }
        .auth-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
        }
        .auth-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-logo-wrap {
            width: 64px;
            height: 64px;
            background: var(--gradient-primary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3);
            position: relative;
        }
        .auth-logo-wrap::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: calc(var(--radius-lg) + 2px);
            background: var(--gradient-primary);
            opacity: 0.3;
            filter: blur(12px);
            z-index: -1;
        }
        .auth-logo-icon {
            font-size: 28px;
            color: white;
        }
        .auth-mcp-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-primary-muted);
            color: var(--accent-primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }
        .auth-title {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }
        .auth-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }
        .client-info {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
        }
        .client-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .client-name .app-icon {
            width: 32px;
            height: 32px;
            background: var(--gradient-primary);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .client-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        .permissions-section {
            margin-bottom: 1.5rem;
        }
        .permissions-label {
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
            color: var(--text-primary);
        }
        .scope-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .scope {
            background: var(--accent-primary-muted);
            color: var(--accent-primary);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            font-family: 'SF Mono', Monaco, 'Courier New', monospace;
            border: 1px solid rgba(99, 102, 241, 0.3);
        }
        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 2rem;
        }
        .btn {
            flex: 1;
            padding: 14px 24px;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.95rem;
            font-family: inherit;
            cursor: pointer;
            transition: all var(--transition-fast);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-approve {
            background: var(--gradient-success);
            color: white;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }
        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
        }
        .btn-deny {
            background: var(--gradient-danger);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        .btn-deny:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        .footer-note {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-muted);
            font-size: 0.8rem;
        }
        .footer-note a {
            color: var(--accent-primary);
            text-decoration: none;
            font-weight: 500;
        }
        .footer-note a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <button class="theme-toggle-fixed" onclick="toggleTheme()" title="Toggle theme"></button>

    <div class="auth-page">
        <div class="auth-wrapper">
            <div class="auth-card">
                <div class="auth-brand">
                    <div class="auth-logo-wrap">
                        <span class="auth-logo-icon"><i class="fas fa-bolt" style="color: #fbbf24;"></i></span>
                    </div>
                    <div class="auth-mcp-badge">ServerAvatar MCP Server</div>
                    <h1 class="auth-title">Authorize Application</h1>
                    <p class="auth-subtitle">Review access permissions</p>
                </div>

                <div class="client-info">
                    <div class="client-name">
                        <span class="app-icon">{!! \App\Helpers\ClientLogoHelper::getLogoHtml($client->name) !!}</span>
                        {{ $client->name }}
                    </div>
                    <p class="client-description">This application is requesting access to your account.</p>
                </div>

                @if(count($scopes) > 0)
                <div class="permissions-section">
                    <div class="permissions-label">Requested permissions:</div>
                    <div class="scope-list">
                        @foreach($scopes as $scope)
                            <span class="scope">{{ $scope->id }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ url('/oauth/authorize') }}">
                    @csrf
                    <input type="hidden" name="auth_token" value="{{ $authToken }}">
                    <input type="hidden" name="approve" value="1">
                    <div class="buttons">
                        <button type="submit" class="btn btn-approve"><i class="fas fa-check" style="margin-right: 6px;"></i>Authorize</button>
                        <button type="button" class="btn btn-deny" onclick="document.getElementById('deny-form').submit();"><i class="fas fa-times" style="margin-right: 6px;"></i>Deny</button>
                    </div>
                </form>

                <form id="deny-form" method="POST" action="{{ url('/oauth/authorize') }}" style="display:none;">
                    @csrf
                    <input type="hidden" name="auth_token" value="{{ $authToken }}">
                    <input type="hidden" name="deny" value="1">
                </form>

                <p class="footer-note">
                    By authorizing, you grant <strong>{{ $client->name }}</strong> access to your ServerAvatar MCP account.
                </p>
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
    </script>
</body>
</html>
