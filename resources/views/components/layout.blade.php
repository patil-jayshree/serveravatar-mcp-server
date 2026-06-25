<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'ServerAvatar MCP' ?></title>
    <link rel="icon" type="image/png" href="/favicon.png">
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
            --accent-warning: #f59e0b; --accent-warning-muted: rgba(245, 158, 11, 0.15);
            --accent-info: #3b82f6; --accent-info-muted: rgba(59, 130, 246, 0.15);
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
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
            --accent-warning: #d97706; --accent-warning-muted: rgba(217, 119, 6, 0.1);
            --accent-info: #2563eb; --accent-info-muted: rgba(37, 99, 235, 0.1);
            --gradient-primary: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1); --shadow-glow: 0 0 40px rgba(79, 70, 229, 0.1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg-primary); color: var(--text-primary); line-height: 1.6; min-height: 100vh; transition: background var(--transition-normal), color var(--transition-normal); }
        .navbar { position: fixed; top: 0; left: 0; right: 0; height: 70px; background: var(--bg-nav); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-color); z-index: 1000; display: flex; align-items: center; padding: 0 2rem; }
        .nav-container { max-width: 1200px; width: 100%; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-primary); }
        .nav-logo { width: 40px; height: 40px; background: var(--gradient-primary); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 18px; color: white; box-shadow: var(--shadow-glow); }
        .nav-title { font-weight: 700; font-size: 1.25rem; letter-spacing: -0.02em; }
        .nav-title span { color: var(--accent-primary); }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        .nav-link { padding: 10px 18px; border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); font-weight: 500; font-size: 0.9rem; transition: all var(--transition-fast); }
        .nav-link:hover { color: var(--text-primary); background: var(--bg-tertiary); }
        .nav-link.active { color: var(--accent-primary); background: var(--accent-primary-muted); }
        .theme-toggle { width: 48px; height: 28px; background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 20px; cursor: pointer; position: relative; transition: all var(--transition-normal); }
        .theme-toggle::before { content: '🌙'; position: absolute; left: 4px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 50%; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all var(--transition-normal); }
        [data-theme="light"] .theme-toggle::before { content: '☀️'; left: calc(100% - 24px); }
        .main-content { padding-top: 70px; min-height: 100vh; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .container.narrow { max-width: 800px; }
        .page-header { margin-bottom: 2.5rem; }
        .page-title { font-size: 2rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 0.5rem; }
        .page-subtitle { color: var(--text-secondary); font-size: 1rem; }
        .section-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.5rem; transition: all var(--transition-normal); }
        .section-card:hover { border-color: var(--border-color-hover); }
        .section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 1.25rem; }
        .section-icon { width: 44px; height: 44px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
        .section-icon.primary { background: var(--accent-primary-muted); }
        .section-icon.success { background: var(--accent-success-muted); }
        .section-icon.warning { background: var(--accent-warning-muted); }
        .section-icon.info { background: var(--accent-info-muted); }
        .section-title { font-size: 1.1rem; font-weight: 700; }
        .section-desc { color: var(--text-secondary); font-size: 0.875rem; margin-top: 2px; }
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
        .status-badge.connected, .status-badge.ready { background: var(--accent-success-muted); color: var(--accent-success); }
        .status-badge.connected::before, .status-badge.ready::before { background: var(--accent-success); box-shadow: 0 0 6px var(--accent-success); }
        .status-badge.disconnected { background: var(--accent-danger-muted); color: var(--accent-danger); }
        .status-badge.disconnected::before { background: var(--accent-danger); }
        .status-badge.pending { background: var(--accent-warning-muted); color: var(--accent-warning); }
        .status-badge.pending::before { background: var(--accent-warning); }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .info-item { background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; }
        .info-label { color: var(--text-muted); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .info-value { font-weight: 600; font-size: 0.95rem; word-break: break-all; }
        .info-value.muted { color: var(--text-muted); font-weight: 400; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 12px 20px; border-radius: var(--radius-md); font-weight: 600; font-size: 0.875rem; border: none; cursor: pointer; transition: all var(--transition-fast); text-decoration: none; white-space: nowrap; }
        .btn-primary { background: var(--gradient-primary); color: white; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25); }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35); }
        .btn-secondary { background: var(--bg-tertiary); color: var(--text-primary); border: 1px solid var(--border-color); }
        .btn-secondary:hover { background: var(--bg-card-hover); border-color: var(--border-color-hover); }
        .btn-sm { padding: 8px 14px; font-size: 0.8rem; }
        .mcp-url-box { background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 1rem; }
        .mcp-url { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.85rem; color: var(--accent-primary); word-break: break-all; }
        .copy-btn { background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 6px 12px; font-size: 0.8rem; color: var(--text-secondary); cursor: pointer; transition: all var(--transition-fast); flex-shrink: 0; }
        .copy-btn:hover { background: var(--accent-primary-muted); color: var(--accent-primary); border-color: var(--accent-primary); }
        .integration-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-top: 1rem; }
        .integration-card { background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; transition: all var(--transition-fast); display: flex; flex-direction: column; }
        .integration-card:hover { border-color: var(--border-color-hover); transform: translateY(-2px); }
        .integration-card-top { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 0.75rem; }
        .integration-card-header { display: flex; align-items: center; gap: 10px; min-width: 0; }
        .integration-logo { width: 36px; height: 36px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .integration-name { font-weight: 700; font-size: 0.95rem; color: var(--text-primary); }
        .integration-desc { color: var(--text-secondary); font-size: 0.8rem; line-height: 1.5; margin-bottom: 0.75rem; }
        .integration-code-wrap { position: relative; margin-bottom: 0.75rem; }
        .integration-code { background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 10px 38px 10px 12px; font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.75rem; color: var(--text-secondary); word-break: break-all; line-height: 1.5; }
        .integration-copy-btn { position: absolute; top: 6px; right: 6px; width: 28px; height: 28px; border-radius: 6px; background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.85rem; transition: all var(--transition-fast); }
        .integration-copy-btn:hover { color: var(--text-primary); border-color: var(--border-color-hover); }
        .integration-copy-btn.copied { color: var(--accent-success); border-color: var(--accent-success); }
        .integration-more { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem 1.75rem; display: flex; align-items: center; gap: 1.75rem; transition: all var(--transition-fast); grid-column: 1 / -1; }
        .integration-more:hover { border-color: var(--border-color-hover); }
        .integration-more-left { display: flex; align-items: center; gap: 1rem; flex: 0 0 auto; max-width: 280px; }
        .integration-more-icon { width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; font-weight: 300; line-height: 1; flex-shrink: 0; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35); }
        .integration-more-title { font-weight: 700; font-size: 0.95rem; color: var(--text-primary); margin-bottom: 3px; }
        .integration-more-desc { color: var(--text-secondary); font-size: 0.78rem; line-height: 1.45; }
        .integration-more-right { flex: 1; min-width: 0; padding-left: 1.75rem; border-left: 1px solid var(--border-color); }
        .integration-more-subtitle { color: var(--text-primary); font-size: 0.75rem; font-weight: 700; margin-bottom: 8px; }
        .integration-more-tags { display: flex; flex-wrap: nowrap; gap: 6px; overflow: hidden; }
        .integration-more-tag { display: inline-flex; align-items: center; gap: 6px; background: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-secondary); padding: 3px 10px 3px 3px; border-radius: 9999px; font-size: 0.72rem; font-weight: 500; flex-shrink: 0; }
        .integration-more-tag-icon { width: 18px; height: 18px; border-radius: 5px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; line-height: 0; }
        .integration-more-tag-icon svg { width: 18px; height: 18px; display: block; }
        .integration-more-tag-more { padding: 3px 12px; color: var(--text-muted); border-style: dashed; font-weight: 500; }
        .integration-footer { margin-top: 1rem; padding: 14px 18px; background: var(--accent-info-muted); border: 1px solid var(--accent-info); border-radius: var(--radius-md); display: flex; align-items: center; gap: 12px; font-size: 0.88rem; color: var(--text-secondary); }
        .integration-footer-icon { font-size: 1.15rem; flex-shrink: 0; }
        .integration-footer-text { flex: 1; }
        .integration-footer strong { color: var(--text-primary); font-weight: 600; }
        .integration-footer code { background: var(--bg-card); border: 1px solid var(--border-color); padding: 3px 8px; border-radius: 6px; font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.8rem; color: var(--accent-primary); }
        .integration-copy-url { padding: 8px 16px; border-radius: 8px; background: var(--bg-card); border: 1px solid var(--accent-info); color: var(--accent-info); font-size: 0.82rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all var(--transition-fast); flex-shrink: 0; }
        .integration-copy-url:hover { background: var(--accent-info); color: white; }
        .integration-copy-url.copied { background: var(--accent-success); color: white; border-color: var(--accent-success); }
        .config-list { display: flex; flex-direction: column; gap: 0.75rem; }
        .config-item { display: flex; align-items: center; justify-content: space-between; padding: 0.875rem 1rem; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); gap: 1rem; }
        .config-item-left { display: flex; align-items: center; gap: 12px; }
        .config-icon { width: 36px; height: 36px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
        .config-icon.green { background: var(--accent-success-muted); }
        .config-icon.blue { background: var(--accent-info-muted); }
        .config-icon.purple { background: var(--accent-primary-muted); }
        .config-icon.yellow { background: var(--accent-warning-muted); }
        .config-label { font-weight: 600; font-size: 0.875rem; }
        .config-value { font-size: 0.8rem; color: var(--text-muted); font-family: 'SF Mono', 'Fira Code', monospace; }
        .alert { padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px; font-size: 0.9rem; }
        .alert-success { background: var(--accent-success-muted); color: var(--accent-success); border: 1px solid var(--accent-success); }
        .alert-error { background: var(--accent-danger-muted); color: var(--accent-danger); border: 1px solid var(--accent-danger); }
        .footer { text-align: center; padding: 2rem; color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid var(--border-color); margin-top: 3rem; }
        .footer a { color: var(--accent-primary); text-decoration: none; font-weight: 600; }
        .footer a:hover { text-decoration: underline; }
        .profile-dropdown { position: relative; }
        .profile-btn { display: flex; align-items: center; gap: 8px; padding: 8px 14px; background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: var(--radius-md); cursor: pointer; transition: all var(--transition-fast); font-size: 0.875rem; color: var(--text-primary); font-weight: 500; }
        .profile-btn:hover { background: var(--bg-card-hover); border-color: var(--border-color-hover); }
        .profile-btn .avatar { width: 28px; height: 28px; border-radius: 50%; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; color: white; }
        .profile-menu { display: none; position: absolute; top: calc(100% + 8px); right: 0; min-width: 220px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); overflow: hidden; z-index: 100; }
        .profile-menu.show { display: block; }
        .profile-menu-header { padding: 1rem; border-bottom: 1px solid var(--border-color); }
        .profile-menu-name { font-weight: 600; font-size: 0.9rem; }
        .profile-menu-email { color: var(--text-muted); font-size: 0.8rem; margin-top: 2px; }
        .profile-menu-item { display: flex; align-items: center; gap: 10px; padding: 0.75rem 1rem; color: var(--text-secondary); font-size: 0.875rem; text-decoration: none; transition: all var(--transition-fast); }
        .profile-menu-item:hover { background: var(--bg-tertiary); color: var(--text-primary); }
        .profile-menu-item.danger { color: var(--accent-danger); }
        .profile-menu-item.danger:hover { background: var(--accent-danger-muted); }
        .profile-menu-divider { height: 1px; background: var(--border-color); margin: 4px 0; }
        .tabs { display: flex; gap: 8px; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; }
        .tab { padding: 10px 20px; border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); font-weight: 500; font-size: 0.9rem; transition: all var(--transition-fast); border: 1px solid transparent; }
        .tab:hover { color: var(--text-primary); background: var(--bg-tertiary); }
        .tab.active { color: var(--accent-primary); background: var(--accent-primary-muted); border-color: var(--border-color-active); }
        .card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.5rem; transition: all var(--transition-normal); }
        .card:hover { border-color: var(--border-color-hover); }
        .card-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 10px; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-primary); }
        .form-label .required { color: #ef4444; margin-left: 2px; }
        .form-input { width: 100%; padding: 12px 16px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 0.95rem; font-family: inherit; transition: all var(--transition-fast); }
        .form-input:focus { outline: none; border-color: var(--accent-primary); box-shadow: 0 0 0 3px var(--accent-primary-muted); }
        .form-input::placeholder { color: var(--text-muted); }
        .form-input:disabled { opacity: 0.6; cursor: not-allowed; }
        .form-hint { color: var(--text-muted); font-size: 0.8rem; margin-top: 4px; }
        @media (max-width: 768px) {
            .navbar { padding: 0 1rem; }
            .nav-links { display: none; }
            .container { padding: 1rem; }
            .page-title { font-size: 1.5rem; }
            .info-grid { grid-template-columns: 1fr; }
            .integration-grid { grid-template-columns: 1fr; }
            .integration-more { flex-direction: column; align-items: flex-start; gap: 1rem; padding: 1.25rem; }
            .integration-more-left { max-width: 100%; }
            .integration-more-right { max-width: 100%; width: 100%; padding-left: 0; border-left: none; padding-top: 1rem; border-top: 1px solid var(--border-color); }
            .integration-more-tags { flex-wrap: wrap; }
            .mcp-url-box { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ auth()->check() ? '/dashboard' : '/' }}" class="nav-brand">
                <div class="nav-logo">⚡</div>
                <span class="nav-title">Server<span>Avatar</span> MCP</span>
            </a>
            @if(auth()->check())
            <div class="nav-links">
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
            </div>
            @endif
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme"></button>
                @if(auth()->check())
                    @include('components.profile-dropdown')
                @endif
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container {{ (isset($narrow) && $narrow) ? 'narrow' : '' }}">
            @if(isset($slot))
                {{ $slot }}
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <p>© 2024 ServerAvatar MCP. Built with Laravel & MCP Protocol.</p>
        <p style="margin-top: 4px;">Powered by <a href="https://serveravatar.com" target="_blank">ServerAvatar</a></p>
    </footer>

    <script>
        function setTheme(t) { document.documentElement.setAttribute('data-theme', t); localStorage.setItem('theme', t); }
        function toggleTheme() { setTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'); }
        (function() { const s = localStorage.getItem('theme'); if (s) setTheme(s); })();
        function toggleProfileMenu() {
            var menu = document.getElementById('profileMenu');
            menu.classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            var dropdown = document.querySelector('.profile-dropdown');
            var menu = document.getElementById('profileMenu');
            if (dropdown && !dropdown.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
        function copyMcpUrl() {
            navigator.clipboard.writeText('{{ config('app.url') }}/mcp/serveravatar').then(function() {
                var btn = document.querySelector('.copy-btn');
                btn.textContent = '✓ Copied!';
                btn.style.color = 'var(--accent-success)';
                setTimeout(function() { btn.textContent = '📋 Copy'; btn.style.color = ''; }, 2000);
            });
        }
        document.querySelectorAll('.integration-copy-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var code = btn.parentElement.querySelector('.integration-code');
                if (!code) return;
                navigator.clipboard.writeText(code.textContent).then(function() {
                    btn.classList.add('copied');
                    btn.textContent = '✓';
                    setTimeout(function() { btn.classList.remove('copied'); btn.textContent = '📋'; }, 1500);
                });
            });
        });
        document.querySelectorAll('.integration-copy-url').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var url = btn.getAttribute('data-copy-url') || '{{ config('app.url') }}/mcp/serveravatar';
                navigator.clipboard.writeText(url).then(function() {
                    btn.classList.add('copied');
                    var orig = btn.textContent;
                    btn.textContent = '✓ Copied!';
                    setTimeout(function() { btn.classList.remove('copied'); btn.textContent = orig; }, 1500);
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
