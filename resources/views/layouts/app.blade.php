<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ServerAvatar MCP')</title>
    <script>!function(){const t=localStorage.getItem('theme');if(t)document.documentElement.setAttribute('data-theme',t);}();</script>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root, [data-theme="dark"] {
            --bg-primary: #0b1220;
            --bg-secondary: #111827;
            --bg-card: #111827;
            --bg-card-hover: #1e293b;
            --bg-input: #0b1220;
            --bg-nav: rgba(11, 18, 32, 0.95);
            --text-primary: #ffffff;
            --text-secondary: #8b92a5;
            --text-muted: #5c6478;
            --border-color: #1e293b;
            --border-color-hover: rgba(255, 255, 255, 0.15);
            --accent-primary: #7c3aed;
            --accent-primary-hover: #6d28d9;
            --accent-primary-muted: rgba(124, 58, 237, 0.15);
            --accent-success: #16a34a;
            --accent-success-muted: rgba(22, 163, 74, 0.15);
            --accent-warning: #f59e0b;
            --accent-warning-muted: rgba(245, 158, 11, 0.15);
            --accent-danger: #ef4444;
            --accent-danger-muted: rgba(239, 68, 68, 0.15);
            --accent-info: #3b82f6;
            --accent-info-muted: rgba(59, 130, 246, 0.15);
            --gradient-primary: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.4);
            --radius-sm: 8px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --transition-fast: 150ms ease;
            --transition-normal: 250ms ease;
        }
        [data-theme="light"] {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-card-hover: #f8f9fb;
            --bg-input: #f4f6f9;
            --bg-nav: rgba(248, 250, 252, 0.95);
            --text-primary: #1a1e2a;
            --text-secondary: #5c6478;
            --text-muted: #8b92a5;
            --border-color: #e5e7eb;
            --border-color-hover: rgba(0, 0, 0, 0.15);
            --accent-primary: #7c3aed;
            --accent-primary-hover: #6d28d9;
            --accent-primary-muted: rgba(124, 58, 237, 0.1);
            --accent-success: #16a34a;
            --accent-success-muted: rgba(22, 163, 74, 0.1);
            --accent-warning: #d97706;
            --accent-warning-muted: rgba(217, 119, 6, 0.1);
            --accent-danger: #dc2626;
            --accent-danger-muted: rgba(220, 38, 38, 0.1);
            --accent-info: #2563eb;
            --accent-info-muted: rgba(37, 99, 235, 0.1);
            --gradient-primary: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg-primary); color: var(--text-primary); line-height: 1.6; min-height: 100vh; }
        
        /* Navbar */
        .navbar { position: fixed; top: 0; left: 0; right: 0; height: 60px; background: var(--bg-nav); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-color); z-index: 1000; display: flex; align-items: center; padding: 0 2rem; }
        .nav-container { max-width: 1200px; width: 100%; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text-primary); }
        .nav-logo { width: 36px; height: 36px; background: var(--gradient-primary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .nav-title { font-weight: 700; font-size: 1.1rem; letter-spacing: -0.02em; }
        .nav-title span { color: var(--accent-primary); }
        .nav-right { display: flex; align-items: center; gap: 8px; }
        .theme-toggle { width: 48px; height: 28px; background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 20px; cursor: pointer; position: relative; transition: all var(--transition-normal); }
        .theme-toggle::before { content: '🌙'; position: absolute; left: 4px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 50%; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all var(--transition-normal); }
        [data-theme="light"] .theme-toggle::before { content: '☀️'; left: calc(100% - 24px); }
        
        /* Profile Dropdown */
        .profile-dropdown { position: relative; }
        .profile-btn { display: flex; align-items: center; gap: 8px; padding: 6px 12px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); cursor: pointer; transition: all var(--transition-fast); font-size: 0.85rem; color: var(--text-primary); font-weight: 500; }
        .profile-btn:hover { border-color: var(--border-color-hover); }
        .profile-btn .avatar { width: 26px; height: 26px; border-radius: 50%; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: white; }
        .profile-menu { display: none; position: absolute; top: calc(100% + 8px); right: 0; min-width: 200px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); overflow: hidden; z-index: 100; }
        .profile-menu.show { display: block; }
        .profile-menu-header { padding: 0.875rem 1rem; border-bottom: 1px solid var(--border-color); }
        .profile-menu-name { font-weight: 600; font-size: 0.875rem; }
        .profile-menu-email { display: inline-block; background: var(--accent-primary-muted); color: var(--accent-primary); font-size: 0.7rem; padding: 2px 8px; border-radius: 20px; margin-top: 4px; font-weight: 500; }
        .profile-menu-item { display: flex; align-items: center; gap: 10px; padding: 0.625rem 1rem; color: var(--text-secondary); font-size: 0.85rem; text-decoration: none; transition: all var(--transition-fast); cursor: pointer; border: none; background: none; width: 100%; text-align: left; font-family: inherit; }
        .profile-menu-item:hover { background: var(--bg-card-hover); color: var(--text-primary); }
        .profile-menu-item.danger { color: var(--accent-danger); }
        .profile-menu-item.danger:hover { background: var(--accent-danger-muted); }
        .profile-menu-divider { height: 1px; background: var(--border-color); margin: 4px 0; }
        
        /* Main Content */
        .main-content { padding-top: 60px; min-height: 100vh; width: 100%; box-sizing: border-box; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        
        /* Footer */
        .footer { text-align: center; padding: 1.25rem 2rem; font-size: 12px; font-weight: 400; color: #64748b; width: 100%; box-sizing: border-box; position: absolute; bottom: 0; left: 0; right: 0; }
        .footer a { color: #7c3aed; }
        [data-theme="light"] .footer { color: #9ca3af; }
        
        /* Modal Styles */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); align-items: center; justify-content: center; z-index: 9999; backdrop-filter: blur(4px); }
        .modal-overlay.show { display: flex; }
        .api-modal { background: var(--bg-card); border: 1px solid rgba(124, 92, 252, 0.3); border-radius: 20px; width: 100%; max-width: 480px; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(124, 92, 252, 0.1); }
        .modal-header { display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); background: var(--bg-primary); border-radius: var(--radius-lg) var(--radius-lg) 0 0; }
        .modal-title-row { display: flex; align-items: center; gap: 0.75rem; }
        .modal-icon { font-size: 1.5rem; }
        .modal-header h3 { margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-primary); }
        .modal-intro { font-size: 0.9rem; color: var(--text-secondary); margin: 0 0 0.75rem 0; line-height: 1.5; }
        .modal-close { background: rgba(255,255,255,0.05); border: none; width: 32px; height: 32px; border-radius: 8px; font-size: 1.2rem; color: var(--text-muted); cursor: pointer; padding: 0; line-height: 1; display: flex; align-items: center; justify-content: center; }
        .modal-close:hover { background: rgba(255,255,255,0.1); color: var(--text-primary); }
        .modal-body { padding: 1rem 2rem 1.25rem; }
        .modal-label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.75rem; }
        .modal-input { width: 100%; padding: 12px 16px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); font-size: 0.95rem; }
        .modal-input:focus { outline: none; border-color: var(--accent-primary); }
        .modal-footer { display: flex; gap: 1rem; padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); justify-content: flex-end; background: var(--bg-primary); border-radius: 0 0 var(--radius-lg) var(--radius-lg); }
        .btn-modal-cancel { padding: 12px 24px; background: transparent; border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-secondary); font-size: 0.9rem; font-weight: 600; cursor: pointer; }
        .btn-modal-cancel:hover { background: var(--bg-tertiary); color: var(--text-primary); }
        .btn-modal-save { padding: 12px 28px; background: var(--accent-primary); border: none; border-radius: 10px; color: white; font-size: 0.9rem; font-weight: 700; cursor: pointer; box-shadow: 0 4px 15px rgba(124, 92, 252, 0.3); }
        .btn-modal-save:hover { background: var(--accent-primary-hover); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(124, 92, 252, 0.4); }
        
        /* API Modal Styles */
        .api-modal { background: var(--bg-card); border: 1px solid rgba(124, 92, 252, 0.3); border-radius: 20px; width: 100%; max-width: 480px; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(124, 92, 252, 0.1); }
        .modal-content { }
        .required-star { color: #ef4444; margin-left: 2px; }
        .input-password-wrap { position: relative; display: flex; align-items: center; }
        .input-password-wrap input { width: 100%; padding: 14px 50px 14px 16px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 12px; color: var(--text-primary); font-size: 0.95rem; letter-spacing: 1px; }
        .input-password-wrap input:focus { outline: none; border-color: var(--accent-primary); box-shadow: 0 0 0 3px rgba(124, 92, 252, 0.15); }
        .toggle-password { position: absolute; right: 12px; background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 4px; display: flex; align-items: center; }
        .toggle-password:hover { color: var(--text-primary); }
        .security-tips { margin-top: 1.5rem; background: rgba(124, 92, 252, 0.08); border: 1px solid rgba(124, 92, 252, 0.15); border-radius: 12px; padding: 1rem 1.25rem; }
        .tips-title { font-size: 0.8rem; font-weight: 700; color: var(--accent-primary); margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .tips-list { margin: 0; padding-left: 1.25rem; }
        .tips-list li { font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.4rem; line-height: 1.4; }
        .tips-list li:last-child { margin-bottom: 0; }
        
        /* Toast */
        .toast { position: fixed; top: 5rem; right: 2rem; background: linear-gradient(135deg, #16a34a 0%, #16a34a 100%); color: white; padding: 14px 20px; border-radius: 12px; display: flex; align-items: center; gap: 12px; box-shadow: 0 8px 30px rgba(34, 197, 94, 0.4); z-index: 10000; max-width: 350px; opacity: 0; transform: translateY(-20px); transition: all 0.3s ease; pointer-events: none; }
        .toast.show { opacity: 1; transform: translateY(0); }
        .toast-icon { width: 28px; height: 28px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: bold; flex-shrink: 0; }
        .toast-message { font-size: 0.9rem; font-weight: 600; color: white; }
        
        /* Settings Page */
        .settings-page { display: flex; gap: 2rem; padding-top: 1rem; }
        .settings-sidebar { width: 240px; flex-shrink: 0; }
        .settings-nav { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; }
        .settings-nav-item { display: flex; align-items: center; gap: 10px; padding: 0.875rem 1rem; color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s ease; border-left: 3px solid transparent; }
        .settings-nav-item:hover { background: var(--bg-card-hover); color: var(--text-primary); }
        .settings-nav-item.active { background: var(--accent-primary-muted); color: var(--accent-primary); border-left-color: var(--accent-primary); }
        .settings-content { flex: 1; min-width: 0; }
        .settings-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 1.5rem; }
        .settings-card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; }
        .settings-card-title { font-size: 1rem; font-weight: 600; color: var(--text-primary); }
        .settings-card-body { padding: 1.5rem; }
        .btn-primary { padding: 0.625rem 1.5rem; background: var(--accent-primary); color: white; border: none; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-primary:hover { background: var(--accent-primary-hover); }
        .api-key-display { display: flex; align-items: center; gap: 12px; }
        .api-key-value { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.85rem; color: var(--text-secondary); background: var(--bg-primary); padding: 8px 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .btn-copy { padding: 8px 12px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-sm); cursor: pointer; color: var(--text-secondary); font-size: 0.85rem; transition: all 0.2s ease; }
        .btn-copy:hover { background: var(--bg-card-hover); color: var(--text-primary); }
        .input-hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/dashboard" class="nav-brand">
                <div class="nav-logo">⚡</div>
                <span class="nav-title">Server<span>Avatar</span> MCP</span>
            </a>
            <div class="nav-right">
                <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme"></button>
                @auth
                    <div class="profile-dropdown">
                        <button class="profile-btn" onclick="toggleProfileMenu()">
                            <span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                            <span>{{ auth()->user()->name ?? 'User' }}</span>
                            <span style="color:var(--text-muted);font-size:0.7rem;">▼</span>
                        </button>
                        <div class="profile-menu" id="profileMenu">
                            <div class="profile-menu-header">
                                <div class="profile-menu-name">{{ auth()->user()->name }}</div>
                                <div class="profile-menu-email">{{ auth()->user()->email }}</div>
                            </div>
                            @if(!request()->is('account') && !request()->is('account/password') && !request()->is('account/api'))
                            <a href="/account" class="profile-menu-item">👤 Profile</a>
                            <div class="profile-menu-divider"></div>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="profile-menu-item danger">🚪 Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
    
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>
    
    <footer class="footer">
        <p>© 2026 ServerAvatar MCP. Built with Laravel & MCP Protocol</p>
        <p style="margin-top: 4px;">Powered by <a href="https://serveravatar.com" target="_blank">ServerAvatar</a></p>
    </footer>
    
    <script>
        function setTheme(t) { document.documentElement.setAttribute('data-theme', t); localStorage.setItem('theme', t); }
        function toggleTheme() { setTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'); }
        (function() { const s = localStorage.getItem('theme'); if (s) setTheme(s); })();
        
        function toggleProfileMenu() { var menu = document.getElementById('profileMenu'); if (menu) menu.classList.toggle('show'); }
        document.addEventListener('click', function(e) {
            var dropdown = document.querySelector('.profile-dropdown');
            var menu = document.getElementById('profileMenu');
            if (dropdown && !dropdown.contains(e.target)) { menu.classList.remove('show'); }
        });
        
        // API Key Modal Functions
        function openApiKeyModal() {
            var modal = document.getElementById('apiKeyModal');
            var input = document.getElementById('apiKeyInput');
            if (modal && input) {
                modal.style.display = 'flex';
                input.focus();
            }
        }
        function closeApiKeyModal() { document.getElementById('apiKeyModal').style.display = 'none'; }
        function togglePasswordVisibility() {
            var input = document.getElementById('apiKeyInput');
            var eyeIcon = document.querySelector('.eye-icon');
            var eyeOffIcon = document.querySelector('.eye-off-icon');
            if (input.type === 'password') { input.type = 'text'; eyeIcon.style.display = 'none'; eyeOffIcon.style.display = 'block'; }
            else { input.type = 'password'; eyeIcon.style.display = 'block'; eyeOffIcon.style.display = 'none'; }
        }

        function showToast(msg) {
            var t = document.getElementById('toast');
            if (!t) { t = document.createElement('div'); t.id = 'toast'; t.className = 'toast'; document.body.appendChild(t); }
            t.innerHTML = '<span class="toast-icon">✓</span><span class="toast-message">' + msg + '</span>';
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3000);
        }
    </script>
    @yield('scripts')
</body>
</html>