<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active AI Clients - ServerAvatar MCP</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root, [data-theme="dark"] {
            --bg-primary: #0b0e14;
            --bg-secondary: #131722;
            --bg-card: #1a1e2a;
            --bg-card-hover: #222738;
            --bg-input: #131722;
            --bg-nav: rgba(11, 14, 20, 0.95);
            --text-primary: #ffffff;
            --text-secondary: #8b92a5;
            --text-muted: #5c6478;
            --border-color: rgba(255, 255, 255, 0.08);
            --border-color-hover: rgba(255, 255, 255, 0.15);
            --accent-primary: #7c5cfc;
            --accent-primary-hover: #9b7ffd;
            --accent-primary-muted: rgba(124, 92, 252, 0.15);
            --accent-success: #22c55e;
            --accent-success-muted: rgba(34, 197, 94, 0.15);
            --accent-danger: #ef4444;
            --accent-danger-muted: rgba(239, 68, 68, 0.15);
            --gradient-primary: linear-gradient(135deg, #7c5cfc 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.4);
            --radius-sm: 8px; --radius-md: 10px; --radius-lg: 14px;
            --transition-fast: 150ms ease; --transition-normal: 250ms ease;
        }
        [data-theme="light"] {
            --bg-primary: #f4f6f9;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-card-hover: #f8f9fb;
            --bg-input: #f4f6f9;
            --bg-nav: rgba(255, 255, 255, 0.95);
            --text-primary: #1a1e2a;
            --text-secondary: #5c6478;
            --text-muted: #8b92a5;
            --border-color: rgba(0, 0, 0, 0.08);
            --border-color-hover: rgba(0, 0, 0, 0.15);
            --accent-primary: #7c5cfc;
            --accent-primary-hover: #6b4ce0;
            --accent-primary-muted: rgba(124, 92, 252, 0.1);
            --accent-success: #16a34a;
            --accent-success-muted: rgba(22, 163, 74, 0.1);
            --accent-danger: #dc2626;
            --accent-danger-muted: rgba(220, 38, 38, 0.1);
            --gradient-primary: linear-gradient(135deg, #7c5cfc 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg-primary); color: var(--text-primary); line-height: 1.6; min-height: 100vh; transition: background var(--transition-normal), color var(--transition-normal); }
        
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
        .icon-light, .icon-dark { display: block; vertical-align: middle; }
        [data-theme="light"] .icon-light { display: block !important; }
        [data-theme="light"] .icon-dark { display: none !important; }
        [data-theme="dark"] .icon-light { display: none !important; }
        [data-theme="dark"] .icon-dark { display: block !important; }
        
        .profile-btn { display: flex; align-items: center; gap: 8px; padding: 6px 12px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); cursor: pointer; transition: all var(--transition-fast); font-size: 0.85rem; color: var(--text-primary); font-weight: 500; }
        .profile-btn:hover { border-color: var(--border-color-hover); }
        .profile-btn .avatar { width: 26px; height: 26px; border-radius: 50%; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: white; }
        .profile-dropdown { position: relative; }
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
        
        .main-content { padding-top: 60px; min-height: 100vh; width: 100%; box-sizing: border-box; position: relative; padding-bottom: 80px; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; text-decoration: none; margin-bottom: 1.25rem; padding: 8px 0; transition: color 0.2s ease; }
        .back-link:hover { color: var(--accent-primary); }
        
        .page-header { display: flex; flex-direction: column; align-items: flex-start; gap: 0.5rem; margin-bottom: 2rem; }
        .page-header-left { display: flex; align-items: center; gap: 1rem; }
        .page-title { font-size: 26px; font-weight: 700; display: flex; align-items: center; gap: 1rem; }
        [data-theme="light"] .page-title { color: #0F172A; }
        [data-theme="dark"] .page-title { color: #F8FAFC; }
        .page-title-icon { width: 52px; height: 52px; border-radius: var(--radius-md); background: rgba(139, 92, 246, 0.12); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0; }
        .page-title-wrap { display: flex; flex-direction: column; gap: 4px; }
        .page-title-text { display: flex; align-items: center; gap: 0.75rem; }
        .page-subtitle { font-size: 14px; color: var(--text-secondary); font-weight: 400; line-height: 22px; }
        .clients-count { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        
        .clients-table-wrap { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 0; overflow: hidden; }
        .clients-table { width: 100%; }
        .table-header { display: grid; grid-template-columns: 1fr 140px 180px 150px; padding: 0 1.5rem; background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); font-size: 12px; font-weight: 600; line-height: 16px; letter-spacing: 0.08em; text-transform: uppercase; gap: 3rem; box-sizing: border-box; }
        [data-theme="light"] .table-header { color: #64748B; }
        [data-theme="dark"] .table-header { color: #94A3B8; }
        .table-header > div { display: flex; align-items: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 12px 12px; justify-content: flex-start; }
        .table-header > div:first-child { padding-left: 1.5rem; }
        .table-header > div:last-child { text-align: left; padding-right: 1.5rem; }
        .table-body { display: flex; flex-direction: column; }
        .table-row { display: grid; grid-template-columns: 1fr 140px 180px 150px; padding: 0 1.5rem; border-bottom: 1px solid var(--border-color); align-items: center; transition: background 0.2s; gap: 3rem; box-sizing: border-box; }
        .table-row:hover { background: rgba(99, 102, 241, 0.05); }
        .table-row > div { overflow: hidden; padding: 16px 12px; }
        .table-row > div:first-child { padding-left: 1.5rem; }
        .table-row > div:last-child { text-align: left; padding-right: 1.5rem; }
        .table-row:last-child { border-bottom: none; }
        
        .client-info { display: flex; align-items: center; gap: 12px; }
        .client-icon { width: 40px; height: 40px; border-radius: 10px; background: var(--bg-tertiary); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
        .client-name { font-size: 15px; font-weight: 600; line-height: 22px; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        [data-theme="light"] .client-name { color: #0F172A; }
        [data-theme="dark"] .client-name { color: #F8FAFC; }
        .client-meta { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }
        
        .status-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-success-muted); color: var(--accent-success); padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; line-height: 18px; justify-content: center; white-space: nowrap; }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent-success); }
        
        .date-time { font-size: 14px; font-weight: 400; line-height: 22px; color: var(--text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        [data-theme="light"] .date-time { color: #475569; }
        [data-theme="dark"] .date-time { color: #CBD5E1; }
        .last-activity-text { text-align: left; }
        
        .empty-state { text-align: center; padding: 4rem 2rem; }
        .empty-icon { font-size: 4rem; margin-bottom: 1rem; }
        .empty-title { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; }
        .empty-desc { color: var(--text-secondary); font-size: 0.9rem; }
        
        .footer { text-align: center; padding: 1.25rem 2rem; color: var(--text-muted); font-size: 0.8rem; width: 100%; box-sizing: border-box; }
        .footer a { color: var(--accent-primary); text-decoration: none; font-weight: 600; }
        .footer a:hover { text-decoration: underline; }
        
        @media (max-width: 768px) {
            .navbar { padding: 0 1rem; }
            .container { padding: 1rem; }
            .table-header, .table-row { grid-template-columns: 1fr; gap: 0.5rem; }
            .table-header > div:last-child { text-align: left; }
            .table-row > div:last-child { text-align: left; }
        }
    </style>
</head>
<body>
        @include('components.navbar')

    <main class="main-content">
        <div class="container">
            <a href="/dashboard" class="back-link">← Back to Dashboard</a>
            
            <div class="page-header">
                <h1 class="page-title">
                    <span class="page-title-icon">🤖</span>
                    <span class="page-title-wrap">
                        <span class="page-title-text">Active AI Clients <span class="clients-count">{{ $connectedClients->count() }} Active {{ $connectedClients->count() == 1 ? 'Client' : 'Clients' }}</span></span>
                        <span class="page-subtitle">View AI clients currently connected to your ServerAvatar MCP server</span>
                    </span>
                </h1>
            </div>
            
            @if($connectedClients->count() > 0)
            <div class="clients-table-wrap">
                <div class="clients-table">
                    <div class="table-header">
                        <div>Client</div>
                        <div>Status</div>
                        <div>Connected</div>
                        <div>Last Activity</div>
                    </div>
                    <div class="table-body">
                        @foreach($connectedClients as $client)
                        <div class="table-row">
                            <div>
                                <div class="client-info">
                                    <div class="client-icon">
                                        @if(in_array($client->client_name, ['ChatGPT', 'OpenAI']))
                                            <img src="/images/clients/chatgpt-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" /><img src="/images/clients/chatgpt-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🤖';" />
                                        @elseif($client->client_name == 'Claude')
                                            <img src="/images/clients/claude.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🟣';" />
                                        @elseif($client->client_name == 'Cursor')
                                            <img src="/images/clients/cursor-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" /><img src="/images/clients/cursor-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='💚';" />
                                        @elseif($client->client_name == 'VS Code')
                                            <img src="/images/clients/vscode.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='💙';" />
                                        @elseif($client->client_name == 'Zed')
                                            <img src="/images/clients/zed.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='⚡';" />
                                        @elseif($client->client_name == 'Cline')
                                            <img src="/images/clients/cline-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" /><img src="/images/clients/cline-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🟢';" />
                                        @elseif($client->client_name == 'Continue')
                                            <img src="/images/clients/continue.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🔗';" />
                                        @elseif($client->client_name == 'Windsurf')
                                            <img src="/images/clients/windsurf-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" /><img src="/images/clients/windsurf-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🌊';" />
                                        @else
                                            <img src="/images/default-icon.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🌐';" />
                                        @endif
                                    </div>
                                    <div class="client-name">{{ $client->client_name }}</div>
                                </div>
                            </div>
                            <div>
                                <span class="status-badge">
                                    <span class="status-dot"></span>
                                    Active
                                </span>
                            </div>
                            <div class="date-time">{{ $client->created_at->format('M d, Y h:i A') }}</div>
                            <div class="date-time last-activity-text">{{ $client->last_activity_at->diffForHumans() }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="clients-table-wrap">
                <div class="empty-state">
                    <div class="empty-icon">🤖</div>
                    <div class="empty-title">No Active Clients</div>
                    <div class="empty-desc">Connect ServerAvatar MCP to any AI client to see them here.</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div style="position: absolute; left: 0; right: 0; bottom: 0; border-top: 1px solid var(--border-color);">
            <footer class="footer" style="width: 100%; padding: 1.25rem 2rem; box-sizing: border-box;">
                <p>© 2026 ServerAvatar MCP. Built with Laravel & MCP Protocol</p>
                <p style="margin-top: 4px;">Powered by <a href="https://serveravatar.com" target="_blank">ServerAvatar</a></p>
            </footer>
        </div>
    </main>
    
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
    </script>
</body>
</html>
