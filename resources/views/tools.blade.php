<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools Library - ServerAvatar MCP</title>
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
            --accent-warning: #f59e0b;
            --accent-warning-muted: rgba(245, 158, 11, 0.15);
            --accent-danger: #ef4444;
            --accent-danger-muted: rgba(239, 68, 68, 0.15);
            --accent-info: #3b82f6;
            --accent-info-muted: rgba(59, 130, 246, 0.15);
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
            --accent-warning: #d97706;
            --accent-warning-muted: rgba(217, 119, 6, 0.1);
            --accent-danger: #dc2626;
            --accent-danger-muted: rgba(220, 38, 38, 0.1);
            --accent-info: #2563eb;
            --accent-info-muted: rgba(37, 99, 235, 0.1);
            --gradient-primary: linear-gradient(135deg, #7c5cfc 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg-primary); color: var(--text-primary); line-height: 1.6; min-height: 100vh; transition: background var(--transition-normal), color var(--transition-normal); }
        
        .navbar { position: fixed; top: 0; left: 0; right: 0; height: 60px; background: var(--bg-nav); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-color); z-index: 1000; display: flex; align-items: center; padding: 0 2rem; }
        .nav-container { max-width: 1200px; width: 100%; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text-primary); }
        .nav-logo { width: 36px; height: 36px; background: var(--gradient-primary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .nav-title { font-weight: 700; font-size: 1.1rem; letter-spacing: -0.02em; }
        .nav-title span { color: var(--accent-primary); }
        .nav-right { display: flex; align-items: center; gap: 8px; }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        .nav-link { padding: 10px 18px; border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); font-weight: 500; font-size: 0.9rem; transition: all var(--transition-fast); }
        .nav-link:hover { color: var(--text-primary); background: var(--bg-tertiary); }
        .nav-link.active { color: var(--accent-primary); background: var(--accent-primary-muted); }
        .theme-toggle { width: 48px; height: 28px; background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 20px; cursor: pointer; position: relative; transition: all var(--transition-normal); }
        .theme-toggle::before { content: '🌙'; position: absolute; left: 4px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 50%; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all var(--transition-normal); }
        [data-theme="light"] .theme-toggle::before { content: '☀️'; left: calc(100% - 24px); }
        
        .main-content { padding-top: 60px; min-height: 100vh; width: 100%; box-sizing: border-box; position: relative; padding-bottom: 80px; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: var(--text-secondary); font-size: 14px; font-weight: 500; text-decoration: none; margin-bottom: 1.25rem; padding: 8px 0; transition: color 0.2s ease; }
        .back-link:hover { color: var(--accent-primary); }
        .page-header { display: flex; flex-direction: column; align-items: flex-start; gap: 0.5rem; margin-bottom: 2rem; }
        .page-title { font-size: 26px; font-weight: 700; display: flex; align-items: center; gap: 1rem; }
        [data-theme="light"] .page-title { color: #0F172A; }
        [data-theme="dark"] .page-title { color: #F8FAFC; }
        .page-title-icon { width: 52px; height: 52px; border-radius: var(--radius-md); background: rgba(139, 92, 246, 0.12); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0; }
        .page-title-wrap { display: flex; flex-direction: column; gap: 2px; }
        .page-title-text { display: flex; align-items: center; gap: 1rem; }
        .page-subtitle { font-size: 14px; color: var(--text-secondary); font-weight: 400; line-height: 22px; }
        .tools-count-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-left: 12px; }
        
        .tools-controls { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
        .search-box { flex: 1; position: relative; }
        .search-input { width: 100%; padding: 12px 16px 12px 44px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 0.9rem; transition: all 0.2s; }
        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus { outline: none; border-color: var(--accent-primary); background: var(--bg-secondary); }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1rem; }
        
        .tools-table-wrap { overflow-x: auto; border-radius: 0; }
        .tools-table { background: var(--bg-card); border: 1px solid var(--border-color); width: 100%; }
        .table-header { display: grid; grid-template-columns: 240px 1fr 100px; padding: 0 1.5rem; background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); font-size: 12px; font-weight: 600; line-height: 16px; letter-spacing: 0.08em; text-transform: uppercase; gap: 5.5rem; box-sizing: border-box; }
        [data-theme="light"] .table-header { color: #64748B; }
        [data-theme="dark"] .table-header { color: #94A3B8; }
        .table-header > div { display: flex; align-items: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 12px 4px; justify-content: flex-start; }
        .table-header > div:last-child { justify-content: center; }
        .th-text { display: block; text-align: left; line-height: 1.4; }
        .th-text-center { display: block; text-align: center; line-height: 1.4; }
        .header-status-cell { display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; }
        .table-body { display: flex; flex-direction: column; }
        .table-row { display: grid; grid-template-columns: 240px 1fr 100px; padding: 0 1.5rem; border-bottom: 1px solid var(--border-color); align-items: stretch; transition: background 0.2s; gap: 5rem; box-sizing: border-box; }
        .table-row > div { display: flex; align-items: center; overflow: visible; padding: 16px 12px; }
        .table-row > div:last-child { justify-content: center; }
        .table-row:last-child { border-bottom: none; }
        .table-row:hover { background: rgba(99, 102, 241, 0.05); }
        .tool-name-cell { display: flex; align-items: center; gap: 8px; width: 100%; height: 100%; min-width: 0; flex-shrink: 0; }
        .tool-name { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.85rem; color: var(--accent-primary); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .tool-name-icon { font-size: 1rem; flex-shrink: 0; }
        .tool-name-text { font-size: 15px; font-weight: 600; line-height: 22px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; min-width: 0; }
        [data-theme="light"] .tool-name-text { color: #0F172A; }
        [data-theme="dark"] .tool-name-text { color: #F8FAFC; }
        .tool-desc-cell { font-size: 14px; font-weight: 400; line-height: 22px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%; height: 100%; display: flex; align-items: center; }
        [data-theme="light"] .tool-desc-cell { color: #475569; }
        [data-theme="dark"] .tool-desc-cell { color: #CBD5E1; }
        
        .tool-status-cell { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; }
        .status-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-success-muted); color: var(--accent-success); padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; line-height: 18px; justify-content: center; white-space: nowrap; }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent-success); flex-shrink: 0; }
        
        /* Tooltip - Pure CSS */
        [data-tooltip] { position: relative; cursor: pointer; }
        .tooltip-box { position: fixed; background: var(--bg-secondary); border: 1px solid var(--border-color); color: var(--text-primary); padding: 10px 16px; border-radius: 4px; font-size: 0.85rem; max-width: 320px; min-width: 180px; white-space: normal; word-wrap: break-word; z-index: 99999; opacity: 0; visibility: hidden; transition: opacity 0.15s ease; box-shadow: 0 8px 24px rgba(0,0,0,0.4); line-height: 1.5; pointer-events: none; }
        
        /* Responsive Table */
        @media (max-width: 1024px) {
            .table-header { grid-template-columns: 200px 1fr 80px; gap: 5rem; }
            .table-row { grid-template-columns: 200px 1fr 80px; gap: 5rem; }
            .table-header > div, .table-row > div { padding: 14px 12px; }
            .tool-name { font-size: 0.8rem; }
            .tool-desc-cell { font-size: 0.8rem; }
            
        }
        
        @media (max-width: 768px) {
            .tools-table-wrap { overflow-x: auto; }
            .tools-table { min-width: 600px; }
            .table-header { grid-template-columns: 160px 1fr 70px; gap: 5rem; font-size: 0.7rem; }
            .table-row { grid-template-columns: 160px 1fr 70px; gap: 5rem; }
            .table-header > div, .table-row > div { padding: 12px 12px; }
            .tool-name { font-size: 0.75rem; }
            .tool-name-icon { font-size: 0.9rem; }
            .tool-desc-cell { font-size: 0.75rem; }
            
            .status-badge { font-size: 0.65rem; padding: 4px 8px; }
            .th-text, .th-text-center { font-size: 0.7rem; }
        }
        
        @media (max-width: 480px) {
            .tools-table-wrap { overflow-x: auto; }
            .tools-table { min-width: 450px; }
            .table-header { grid-template-columns: 120px 1fr 60px; gap: 5rem; }
            .table-row { grid-template-columns: 120px 1fr 60px; gap: 5rem; }
            .table-header > div, .table-row > div { padding: 6px 4px; }
            .tool-name { font-size: 0.7rem; }
            .tool-name-icon { font-size: 0.8rem; }
            .tool-desc-cell { font-size: 0.7rem; white-space: normal; line-height: 1.3; }
            
            .status-badge { font-size: 0.6rem; padding: 3px 6px; gap: 4px; }
        }
        
        .pagination { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; background: var(--bg-secondary); border-top: 1px solid var(--border-color); border-radius: 0 0 var(--radius-lg) var(--radius-lg); }
        .pagination-info { font-size: 14px; font-weight: 500; line-height: 20px; }
        [data-theme="light"] .pagination-info { color: #64748B; }
        [data-theme="dark"] .pagination-info { color: #94A3B8; }
        .pagination-buttons { display: flex; gap: 0.5rem; }
        .page-btn { padding: 8px 14px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-secondary); font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; }
        .page-btn:hover:not(:disabled) { background: var(--bg-card); color: var(--text-primary); border-color: var(--border-color-hover); }
        .page-btn:disabled, .page-btn.disabled { opacity: 0.5; cursor: not-allowed; pointer-events: none; }
        .page-btn.active { background: var(--accent-primary); border-color: var(--accent-primary); color: white; font-weight: 600; }
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
        .footer { text-align: center; padding: 1.25rem 2rem; color: var(--text-muted); font-size: 0.8rem; width: 100%; box-sizing: border-box; }
        .footer a { color: var(--accent-primary); text-decoration: none; font-weight: 600; }
        .footer a:hover { text-decoration: underline; }
        
        @media (max-width: 768px) {
            .navbar { padding: 0 1rem; }
            .nav-links { display: none; }
            .container { padding: 1rem; }
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
                    <span class="page-title-icon">🛠</span>
                    <span class="page-title-wrap">
                        <span class="page-title-text">Tools Library <span class="tools-count-badge">{{ $totalTools }} Tools</span></span>
                        <span class="page-subtitle">Browse all MCP tools available in your ServerAvatar account</span>
                    </span>
                </h1>
            </div>
            
            <div class="tools-controls">
                <div class="search-box" style="max-width: 400px;">
                    <span class="search-icon">🔍</span>
                    <input type="text" class="search-input" placeholder="Search tools..." id="searchInput">
                </div>
            </div>
            
            <div class="tools-table-wrap">
            <div class="tools-table">
                <div class="table-header">
                    <div><span class="th-text">Tool Name</span></div>
                    <div><span class="th-text">Description</span></div>
                    <div class="header-status-cell"><span class="th-text-center">Status</span></div>
                </div>
                <div class="table-body" id="toolsTableBody">
                    @foreach($tools as $tool)
                    <div class="table-row" data-name="{{ $tool['name'] }}" data-status="{{ $tool['status'] }}">
                        <div class="tool-name-cell">
                            <span class="tool-name-icon">{{ $tool['icon'] }}</span>
                            <span class="tool-name-text" data-tooltip="{{ Str::title(str_replace('_', ' ', $tool['name'])) }}">{{ Str::title(str_replace('_', ' ', $tool['name'])) }}</span>
                        </div>
                        <div class="tool-desc-cell"><span data-tooltip="{{ $tool['description'] }}">{{ $tool['description'] }}</span></div>
                        <div class="tool-status-cell">
                            <span class="status-badge">
                                <span class="status-dot"></span>
                                {{ $tool['status'] }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            </div>
            
            <div class="pagination">
                <div class="pagination-info">
                    Showing {{ ($currentPage - 1) * $perPage + 1 }} to {{ min($currentPage * $perPage, $totalTools) }} of {{ $totalTools }} tools
                </div>
                <div class="pagination-buttons">
                    @if($currentPage > 1)
                    <a href="{{ route('tools') }}?page={{ $currentPage - 1 }}" class="page-btn">← Previous</a>
                    @else
                    <span class="page-btn disabled">← Previous</span>
                    @endif
                    
                    @for($i = 1; $i <= $totalPages; $i++)
                        @if($i == $currentPage)
                        <span class="page-btn active">{{ $i }}</span>
                        @else
                        <a href="{{ route('tools') }}?page={{ $i }}" class="page-btn">{{ $i }}</a>
                        @endif
                    @endfor
                    
                    @if($currentPage < $totalPages)
                    <a href="{{ route('tools') }}?page={{ $currentPage + 1 }}" class="page-btn">Next →</a>
                    @else
                    <span class="page-btn disabled">Next →</span>
                    @endif
                </div>
            </div>
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
            if (menu) menu.classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            var dropdown = document.querySelector('.profile-dropdown');
            var menu = document.getElementById('profileMenu');
            if (dropdown && menu && !dropdown.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('.table-row');
                    
                    rows.forEach(row => {
                        const nameText = row.querySelector('.tool-name-text').textContent.toLowerCase();
                        const desc = row.querySelector('.tool-desc-cell').textContent.toLowerCase();
                        if (nameText.includes(query) || desc.includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
            
            // Tooltip functionality
            var tooltipEl = document.getElementById('tooltipBox');
            var tooltipItems = document.querySelectorAll('[data-tooltip]');
            
            tooltipItems.forEach(function(item) {
                item.addEventListener('mouseenter', function(e) {
                    var text = item.getAttribute('data-tooltip');
                    if (text) {
                        tooltipEl.textContent = text;
                        tooltipEl.style.opacity = '1';
                        tooltipEl.style.visibility = 'visible';
                    }
                });
                item.addEventListener('mousemove', function(e) {
                    tooltipEl.style.left = (e.clientX - 90) + 'px';
                    tooltipEl.style.top = (e.clientY - 60) + 'px';
                });
                item.addEventListener('mouseleave', function() {
                    tooltipEl.style.opacity = '0';
                    tooltipEl.style.visibility = 'hidden';
                });
            });
        });
    </script>
    <div id="tooltipBox" class="tooltip-box"></div>
</body>
</html>
