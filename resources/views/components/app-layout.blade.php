<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ServerAvatar MCP')</title>
    <style>
        :root {
            --bg-primary: #0f0f14;
            --bg-secondary: #18181f;
            --bg-card: #1e1e26;
            --bg-card-hover: #262630;
            --bg-tertiary: #2a2a35;
            --bg-nav: rgba(30, 30, 38, 0.85);
            --text-primary: #f0f0f5;
            --text-secondary: #9898a4;
            --text-muted: #5a5a6e;
            --border-color: #2e2e3a;
            --border-color-hover: #3a3a48;
            --accent-primary: #7c5cfc;
            --accent-primary-hover: #9174fd;
            --accent-primary-muted: rgba(124, 92, 252, 0.15);
            --accent-success: #10b981;
            --accent-success-muted: rgba(16, 185, 129, 0.15);
            --accent-danger: #ef4444;
            --accent-danger-muted: rgba(239, 68, 68, 0.15);
            --gradient-primary: linear-gradient(135deg, #7c5cfc 0%, #a78bfa 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.4);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.5);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
        }
        [data-theme="light"] {
            --bg-primary: #f5f5f7;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-card-hover: #f8f8fa;
            --bg-tertiary: #ebebef;
            --bg-nav: rgba(255, 255, 255, 0.85);
            --text-primary: #1a1a2e;
            --text-secondary: #5a5a6e;
            --text-muted: #8a8a9e;
            --border-color: #e0e0e8;
            --border-color-hover: #c8c8d4;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: var(--bg-primary); color: var(--text-primary); min-height: 100vh; line-height: 1.6; }
        a { color: inherit; text-decoration: none; }
        button { font-family: inherit; }
        
        /* Navbar */
        .navbar { position: fixed; top: 0; left: 0; right: 0; height: 60px; background: var(--bg-nav); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-color); z-index: 1000; display: flex; align-items: center; padding: 0 2rem; }
        .nav-container { max-width: 1400px; width: 100%; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text-primary); }
        .nav-logo { width: 36px; height: 36px; background: var(--gradient-primary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .nav-title { font-weight: 700; font-size: 1rem; }
        .nav-title span { color: var(--accent-primary); }
        .nav-right { display: flex; align-items: center; gap: 12px; }
        .theme-toggle { width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border-color); background: var(--bg-card); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: all var(--transition-fast); }
        .theme-toggle:hover { border-color: var(--accent-primary); background: var(--accent-primary-muted); }
        
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
        .main-content { padding-top: 80px; min-height: 100vh; }
        .container { max-width: 1400px; margin: 0 auto; padding: 2rem; }
        .page-header { margin-bottom: 2rem; }
        .page-title { font-size: 1.75rem; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .page-title-icon { font-size: 1.5rem; }
        .page-subtitle { color: var(--text-secondary); margin-top: 0.5rem; }
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; text-decoration: none; margin-bottom: 1.25rem; padding: 8px 0; transition: color 0.2s ease; }
        .back-link:hover { color: var(--accent-primary); }
        
        /* Footer */
        .footer { text-align: center; padding: 1.25rem 2rem; color: var(--text-muted); font-size: 0.8rem; width: 100%; box-sizing: border-box; }
        .footer a { color: var(--accent-primary); text-decoration: none; font-weight: 600; }
        .footer a:hover { text-decoration: underline; }
        
        @media (max-width: 768px) {
            .navbar { padding: 0 1rem; }
            .container { padding: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('components.navbar')
    
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>
    
    @include('components.footer')
    
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
    </script>
    @stack('scripts')
</body>
</html>