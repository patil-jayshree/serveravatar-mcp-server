<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <script>
        (function() {
            var t = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - ServerAvatar MCP')</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/fontawesome.css">
    <style>
        :root, [data-theme="dark"] {
            --bg-primary: #0b1220;
            --bg-secondary: #111827;
            --bg-card: #111827;
            --bg-card-hover: #1e293b;
            --bg-input: #0b1220;
            --bg-nav: rgba(11, 18, 32, 0.95);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --text-muted: #5c6478;
            --section-title-color: #f8fafc;
            --step-title-color: #7C3AED;
            --border-color: #1e293b;
            --border-color-hover: rgba(255, 255, 255, 0.15);
            --accent-primary: #7c3aed;
            --accent-primary-hover: #6d28d9;
            --accent-primary-muted: rgba(124, 92, 252, 0.15);
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
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.3);
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
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --text-muted: #8b92a5;
            --section-title-color: #111827;
            --step-title-color: #7C3AED;
            --border-color: #e5e7eb;
            --border-color-hover: rgba(0, 0, 0, 0.15);
            --accent-primary: #7c3aed;
            --accent-primary-hover: #6d28d9;
            --accent-primary-muted: rgba(124, 58, 237, 0.1);
            --accent-success: #16a34a;
            --accent-success-muted: rgba(22, 163, 74, 0.1);
            --accent-warning: #f59e0b;
            --accent-warning-muted: rgba(245, 158, 11, 0.1);
            --accent-danger: #dc2626;
            --accent-danger-muted: rgba(220, 38, 38, 0.1);
            --accent-info: #2563eb;
            --accent-info-muted: rgba(37, 99, 235, 0.1);
            --gradient-primary: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg-primary); color: var(--text-primary); line-height: 1.6; min-height: 100vh; }
        .icon-light, .icon-dark { display: block; vertical-align: middle; }
        [data-theme="light"] .icon-light { display: block !important; }
        [data-theme="light"] .icon-dark { display: none !important; }
        [data-theme="dark"] .icon-light { display: none !important; }
        [data-theme="dark"] .icon-dark { display: block !important; }
        a { text-decoration: none; color: inherit; }

        /* Layout */
        .app-wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: var(--bg-secondary); border-right: 1px solid var(--border-color); position: fixed; top: 0; left: 0; height: 100vh; display: flex; flex-direction: column; z-index: 100; transition: transform 0.3s ease; }
        .sidebar-header { padding: 11px 1.25rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 0.75rem; height: 60px; box-sizing: border-box; }
        .sidebar-logo { width: 38px; height: 38px; background: var(--gradient-primary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .sidebar-brand { font-weight: 700; font-size: 1rem; color: var(--text-primary); }
        .sidebar-brand span { color: var(--accent-primary); }
        
        /* Sidebar Navigation */
        .sidebar-nav { flex: 1; padding: 1rem 0.75rem; overflow-y: auto; }
        .nav-section { margin-bottom: 1.5rem; }
        .nav-section-title { font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; padding: 0 0.75rem; margin-bottom: 0.5rem; }
        .nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.625rem 0.75rem; border-radius: var(--radius-sm); color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; transition: all var(--transition-fast); cursor: pointer; text-decoration: none; }
        .nav-link:hover { background: var(--bg-card-hover); color: var(--text-primary); }
        .nav-link.active { background: var(--accent-primary-muted); color: var(--accent-primary); }
        .nav-link i { width: 18px; text-align: center; font-size: 1rem; }
        
        /* Sidebar Footer */
        .sidebar-footer { padding: 1rem 1.25rem; border-top: 1px solid var(--border-color); }
        .user-card { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: var(--bg-card); border-radius: var(--radius-md); margin-bottom: 0.75rem; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700; color: white; flex-shrink: 0; }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-weight: 600; font-size: 0.875rem; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-email { font-size: 0.75rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .logout-btn { display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.625rem; background: transparent; border: 1px solid var(--border-color); border-radius: var(--radius-sm); color: var(--text-secondary); font-size: 0.8rem; font-weight: 500; cursor: pointer; transition: all var(--transition-fast); }
        .logout-btn:hover { background: var(--accent-danger-muted); border-color: var(--accent-danger); color: var(--accent-danger); }

        /* Main Content */
        .main-wrapper { flex: 1; margin-left: 260px; display: flex; flex-direction: column; min-height: 100vh; }
        
        /* Top Header */
        .top-header { position: fixed; top: 0; left: 260px; right: 0; height: 60px; background: var(--bg-nav); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 16px 1.5rem; z-index: 50; }
        .header-left { display: flex; align-items: center; gap: 1rem; }
        .hamburger { display: none; background: none; border: none; color: var(--text-primary); font-size: 1.25rem; cursor: pointer; padding: 0.5rem; }
        .page-breadcrumb { font-size: 0.875rem; color: var(--text-secondary); }
        .page-breadcrumb span { color: var(--text-primary); font-weight: 500; }
        .header-right { display: flex; align-items: center; gap: 0.75rem; }
        
        /* Theme Toggle */
        .theme-toggle { width: 48px; height: 26px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; cursor: pointer; position: relative; transition: all var(--transition-normal); }
        .theme-toggle::before { content: '🌙'; position: absolute; left: 3px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 50%; background: var(--bg-secondary); display: flex; align-items: center; justify-content: center; font-size: 11px; transition: all var(--transition-normal); }
        [data-theme="light"] .theme-toggle::before { content: '☀️'; left: calc(100% - 23px); }
        
        /* Profile Dropdown */
        .profile-dropdown { position: relative; }
        .profile-btn { display: flex; align-items: center; gap: 0.5rem; padding: 0.375rem 0.75rem 0.375rem 0.375rem; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; cursor: pointer; transition: all var(--transition-fast); font-size: 0.8rem; color: var(--text-primary); font-weight: 500; }
        .profile-btn:hover { border-color: var(--border-color-hover); }
        .profile-btn .avatar { width: 26px; height: 26px; border-radius: 50%; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: white; }
        .profile-menu { display: none; position: absolute; top: calc(100% + 8px); right: 0; min-width: 200px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); overflow: hidden; z-index: 100; }
        .profile-menu.show { display: block; }
        .profile-menu-item { display: flex; align-items: center; gap: 10px; padding: 0.625rem 1rem; color: var(--text-secondary); font-size: 0.85rem; text-decoration: none; transition: all var(--transition-fast); }
        .profile-menu-item:hover { background: var(--bg-card-hover); color: var(--text-primary); }
        .profile-menu-item.danger { color: var(--accent-danger); border: 1px solid var(--border-color); }
        .profile-menu-item.danger:hover { background: var(--accent-danger-muted); }
        .profile-menu-divider { height: 1px; background: var(--border-color); margin: 4px 0; }

        /* Page Content */
        .page-content { padding: 1.5rem; padding-top: 60px; flex: 1; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; }
        .page-header { margin-bottom: 1rem; }
        .page-title { font-size: 2rem; font-weight: 700; margin-bottom: 0.25rem; }
        .page-subtitle { font-size: 0.875rem; font-weight: 400; color: var(--text-secondary); }

        /* Cards */
        .card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem; margin-bottom: 0.5rem; }
        .card:hover { border-color: var(--border-color-hover); }

        /* Section Header */
        .section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 0.5rem; }
        .section-icon { width: 40px; height: 40px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .section-title { font-size: 1.1rem; font-weight: 600; color: var(--section-title-color); }
        .section-desc { color: var(--text-secondary); font-size: 0.875rem; margin-top: 0.25rem; }

        /* Grid */
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }

        /* Integration Grid */
        .integration-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 1rem; }
        .integration-card.simple { position: relative; display: flex; align-items: center; gap: 0.75rem; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; transition: all var(--transition-fast); }
        .integration-card.simple:hover { border-color: var(--border-color-hover); transform: translateY(-2px); }
        .badge-top-right { position: absolute; top: 8px; right: 8px; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; }
        .badge-popular { background: rgba(124, 92, 252, 0.2); color: #7c5cfb; border-radius: 999px; }
        .badge-success { background: rgba(16, 163, 127, 0.15); color: var(--accent-success); border-radius: 999px; }
        .integration-logo { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .integration-logo .icon-light, .integration-logo .icon-dark { width: 28px; height: 28px; object-fit: contain; }
        .integration-text { display: flex; flex-direction: column; gap: 0.15rem; flex: 1; min-width: 0; }
        .integration-name { font-weight: 600; font-size: 15px; color: var(--text-primary); }
        .integration-desc { font-weight: 400; color: var(--text-secondary); font-size: 13px; }
        .integration-card.more-card { border-style: dashed; border-color: var(--border-color-hover); background: transparent; }
        .integration-card.more-card:hover { background: var(--bg-card); }

        /* Tools Table */
        .tools-controls { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .search-box { position: relative; flex: 1; }
        .search-input { width: 100%; padding: 12px 16px 12px 44px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 0.9rem; transition: all 0.2s; }
        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus { outline: none; border-color: var(--accent-primary); }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1rem; }
        .tools-count-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-left: 12px; }
        .tools-table-wrap { overflow-x: auto; }
        .tools-table { background: var(--bg-card); border: 1px solid var(--border-color); width: 100%; min-width: 600px; }
        .table-header { display: grid; grid-template-columns: minmax(200px, 240px) minmax(120px, 140px) 1fr minmax(80px, 100px); padding: 6px 1rem; background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; gap: 1rem; }
        [data-theme="light"] .table-header { color: #64748B; }
        [data-theme="dark"] .table-header { color: #94A3B8; }
        .table-header > div { display: flex; align-items: center; overflow: hidden; padding: 12px 8px; }
        .table-header > div:last-child { justify-content: center; }
        .th-text { display: block; text-align: left; line-height: 1.4; }
        .th-text-center { display: block; text-align: center; line-height: 1.4; }
        .table-body { display: flex; flex-direction: column; }
        .table-row { display: grid; grid-template-columns: minmax(200px, 240px) minmax(120px, 140px) 1fr minmax(80px, 100px); padding: 0 1rem; border-bottom: 1px solid var(--border-color); align-items: center; transition: background 0.2s; gap: 1rem; }
        .table-row > div { display: flex; align-items: center; overflow: hidden; padding: 12px 8px; }
        .table-row > div:last-child { justify-content: center; }
        .table-row:last-child { border-bottom: none; }
        .table-row:hover { background: var(--bg-card-hover); }
        .tool-name-cell { display: flex; align-items: center; gap: 8px; width: 100%; min-width: 0; }
        .tool-name-text { font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        [data-theme="light"] .tool-name-text { color: #0F172A; }
        [data-theme="dark"] .tool-name-text { color: #F8FAFC; }
        .tool-desc-cell { min-width: 0; flex-basis: 0; flex-grow: 1; }
        .tool-desc-cell span { font-size: 13px; color: var(--text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
        .tool-status-cell { display: flex; align-items: center; justify-content: center; width: 100%; }
        .status-badge { display: inline-flex; align-items: center; gap: 4px; background: var(--accent-success-muted); color: var(--accent-success); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .status-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--accent-success); }
        .pagination { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; background: var(--bg-secondary); border-top: 1px solid var(--border-color); flex-wrap: wrap; gap: 1rem; }
        .pagination-info { font-size: 14px; font-weight: 500; color: var(--text-secondary); }
        .pagination-buttons { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .page-btn { padding: 8px 14px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-secondary); font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .page-btn:hover:not(.disabled) { background: var(--bg-card-hover); color: var(--text-primary); }
        .page-btn.disabled { opacity: 0.5; cursor: not-allowed; }
        .page-btn.active { background: var(--accent-primary); border-color: var(--accent-primary); color: white; font-weight: 600; }

        /* Clients Table */
        .section-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
        .section-header-left { display: flex; align-items: center; gap: 12px; }
        .view-all-link { font-size: 0.875rem; font-weight: 600; color: var(--accent-primary); text-decoration: none; display: flex; align-items: center; gap: 4px; }
        .view-all-link:hover { opacity: 0.8; }
        .clients-list-new { display: flex; flex-direction: column; }
        .client-row { display: grid; grid-template-columns: 48px 1fr auto auto; align-items: center; gap: 1rem; padding: 0.75rem 0.5rem; border-bottom: 1px solid var(--border-color); }
        .client-row:last-child { border-bottom: none; }
        .client-row:hover { background: var(--bg-card-hover); margin: 0 -0.5rem; padding-left: 0.5rem; padding-right: 0.5rem; border-radius: var(--radius-sm); }
        .client-col { display: flex; align-items: center; }
        .client-col-icon { width: 48px; height: 36px; display: flex; align-items: center; justify-content: center; }
        .client-col-icon img { border-radius: 6px; }
        .client-col-name { flex: 1; }
        .client-name { font-weight: 600; font-size: 14px; }
        [data-theme="light"] .client-name { color: #0F172A; }
        [data-theme="dark"] .client-name { color: #F8FAFC; }
        .client-col-status { min-width: 80px; justify-content: center; }
        .client-col-time { min-width: 100px; justify-content: flex-end; }
        .client-time { font-size: 13px; color: var(--text-muted); }
        .badge-active { background: rgba(34, 197, 94, 0.15); color: var(--accent-success); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .clients-footer { padding: 0.75rem 0.5rem; font-size: 13px; color: var(--text-muted); text-align: center; }
        .clients-empty { padding: 3rem 1rem; text-align: center; }
        .clients-empty-icon { margin-bottom: 1.5rem; display: flex; justify-content: center; }
        .clients-empty-title { font-size: 16px; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary); }
        .clients-empty-desc { font-size: 14px; color: var(--text-secondary); max-width: 400px; margin: 0 auto; line-height: 1.6; }

        /* Clients Table Format */
        .clients-table-header { display: flex; align-items: center; padding: 12px 1.5rem; background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); gap: 1rem; }
        .clients-th { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); display: flex; align-items: center; gap: 8px; }
        .count-badge { display: inline-flex; align-items: center; justify-content: center; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 600; }
        .active-clients-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-left: 12px; }
        .clients-table-body { display: flex; flex-direction: column; }
        .clients-tr { display: flex; align-items: center; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color); gap: 1rem; transition: background 0.15s; }
        .clients-tr:last-child { border-bottom: none; }
        .clients-tr:hover { background: var(--bg-card-hover); }
        .clients-td { display: flex; align-items: center; font-size: 14px; }
        .client-info { display: flex; align-items: center; gap: 12px; }
        .client-icon-wrap { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
        .client-icon-wrap img, .client-icon-wrap .client-icon-fallback { border-radius: 6px; }
        .client-icon-fallback { font-size: 20px; }
        .client-name { font-weight: 600; color: var(--text-primary); }
        .client-date { font-size: 13px; color: var(--text-primary); line-height: 1.4; }
        .client-activity { font-size: 13px; color: var(--text-secondary); }

        /* Settings Page */
        .settings-page { display: flex; gap: 2rem; padding-top: 1rem; }
        .settings-sidebar { width: 240px; flex-shrink: 0; }
        .settings-nav { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; }
        .settings-nav-item { display: flex; align-items: center; gap: 10px; padding: 0.875rem 1rem; color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s ease; border-left: 3px solid transparent; }
        .settings-nav-item:hover { background: var(--bg-card-hover); color: var(--text-primary); }
        .settings-nav-item.active { background: var(--accent-primary-muted); color: var(--accent-primary); border-left-color: var(--accent-primary); }
        .settings-content { flex: 1; min-width: 0; }
        .settings-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 1rem; }
        .settings-card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); }
        .settings-card-title { font-size: 1rem; font-weight: 600; color: var(--text-primary); }
        .settings-card-body { padding: 1.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group:last-child { margin-bottom: 0; }
        .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-input { width: 100%; padding: 0.75rem 1rem; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.9rem; color: var(--text-primary); transition: all 0.2s ease; box-sizing: border-box; }
        .form-input:focus { outline: none; border-color: var(--accent-primary); background: var(--bg-card); }
        .form-input::placeholder { color: var(--text-muted); }
        .settings-card-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; }
        .btn-primary { padding: 0.625rem 1.5rem; background: var(--accent-primary); color: white; border: none; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
        .btn-primary:hover { background: var(--accent-primary-hover); }
        .btn-danger { padding: 0.625rem 1.5rem; background: var(--accent-danger); color: white; border: 1px solid var(--accent-danger); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
        .btn-danger:hover { background: #dc2626; border-color: #dc2626; }
        .btn-secondary { padding: 0.625rem 1.25rem; background: transparent; color: var(--text-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
        .btn-secondary:hover { background: var(--bg-card-hover); color: var(--text-primary); }
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); align-items: center; justify-content: center; z-index: 9999; }
        .modal-content { }
        .api-modal { background: var(--bg-card); border: 1px solid rgba(124, 92, 252, 0.3); border-radius: 20px; width: 100%; max-width: 480px; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(124, 92, 252, 0.1); }
        .modal-header { display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); background: var(--bg-primary); border-radius: var(--radius-lg) var(--radius-lg) 0 0; }
        .modal-title-row { display: flex; align-items: center; gap: 0.625rem; }
        .modal-icon { width: 36px; height: 36px; border-radius: 50%; background: rgba(124, 92, 237, 0.1); display: flex; align-items: center; justify-content: center; }
        .modal-header h3 { margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-primary); }
        .modal-close { background: rgba(255,255,255,0.05); border: none; width: 28px; height: 28px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.8rem; }
        .modal-close:hover { background: rgba(255,255,255,0.1); color: var(--text-primary); }
        .modal-body { padding: 1.25rem 1.5rem; }
        .modal-intro { font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 1rem; line-height: 1.5; }
        .modal-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .input-password-wrap { position: relative; }
        .input-password-wrap input { width: 100%; padding: 0.75rem 3rem 0.75rem 1rem; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.9rem; color: var(--text-primary); box-sizing: border-box; }
        .input-password-wrap input:focus { outline: none; border-color: var(--accent-primary); }
        .toggle-password { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 4px; display: flex; align-items: center; }
        .toggle-password:hover { color: var(--text-primary); }
        .required-star { color: var(--accent-danger); }
        .security-tips { background: rgba(124, 92, 237, 0.05); border: 1px solid rgba(124, 92, 237, 0.15); border-radius: var(--radius-md); padding: 0.875rem 1rem; margin-top: 1rem; }
        .tips-title { font-size: 0.75rem; font-weight: 700; color: var(--accent-primary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; }
        .tips-list { margin: 0; padding-left: 1.25rem; }
        .tips-list li { font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.25rem; }
        .modal-footer { padding: 1rem 1.25rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem; }
        .btn-modal-cancel { padding: 0.625rem 1.25rem; background: transparent; border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-secondary); font-size: 0.875rem; font-weight: 600; cursor: pointer; }
        .btn-modal-cancel:hover { background: var(--bg-tertiary); color: var(--text-primary); }
        .btn-modal-save { padding: 0.625rem 1.5rem; background: var(--accent-primary); border: none; border-radius: 10px; color: white; font-size: 0.875rem; font-weight: 700; cursor: pointer; }
        .btn-modal-save:hover { background: var(--accent-primary-hover); }

        /* API Access */
        .api-access-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; }
        .api-access-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
        .api-access-title { font-size: 1rem; font-weight: 600; color: var(--text-primary); }
        .api-access-desc { font-size: 0.875rem; color: var(--text-secondary); }
        .api-key-row { display: flex; align-items: center; gap: 8px; width: 100%; }
        .api-key-box { position: relative; flex: 1; }
        .api-key-box input { width: 100%; padding: 10px 100px 10px 16px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-family: monospace; font-size: 0.85rem; letter-spacing: 1px; box-sizing: border-box; }
        .icon-btn { position: absolute; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 6px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
        .icon-btn:hover { color: var(--text-primary); }
        .eye-btn { right: 60px; }
        .copy-btn { right: 12px; }
        .copy-btn.copied { color: var(--accent-success); }
        .api-features { display: flex; gap: 1rem; padding: 1.5rem; }
        .api-feature { display: flex; align-items: flex-start; gap: 1rem; flex: 1; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem 1.5rem; }
        .api-feature-icon { width: 36px; height: 36px; border-radius: var(--radius-md); background: rgba(124, 58, 237, 0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .api-feature-content { display: flex; flex-direction: column; gap: 0.25rem; }
        .api-feature-title { font-size: 0.875rem; font-weight: 600; color: var(--text-primary); }
        .api-feature-desc { font-size: 0.8rem; color: var(--text-secondary); line-height: 1.4; }

        @media (max-width: 768px) {
            .settings-page { flex-direction: column; }
            .settings-sidebar { width: 100%; }
            .api-features { flex-direction: column; }
        }
        .refresh-btn { width: 36px; height: 36px; border-radius: var(--radius-md); background: transparent; border: 1px solid var(--border-color); color: var(--accent-primary); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; text-decoration: none; }
        .refresh-btn:hover { background: var(--accent-primary-muted); border-color: var(--accent-primary); }
        .clients-card { padding: 0; }
        .clients-header-row { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color); }

        /* Responsive */
        @media (max-width: 1200px) {
            .integration-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 900px) {
            .integration-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .top-header { left: 0; }
            .hamburger { display: block; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .integration-grid { grid-template-columns: 1fr; }
        }
        @yield('styles')
    </style>
</head>
<body@yield('body_attrs')>
    <div class="app-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">⚡</div>
                <div class="sidebar-brand">Server<span>Avatar</span></div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('integrations') }}" class="nav-link {{ request()->is('integrations') ? 'active' : '' }}">
                        <i class="fas fa-plug"></i>
                        <span>Integration</span>
                    </a>

                    <a href="{{ route('mcp-server') }}" class="nav-link {{ request()->is('mcp-server') ? 'active' : '' }}">
                        <i class="fas fa-server"></i>
                        <span>MCP Server</span>
                    </a>
                    <a href="{{ route('tools') }}" class="nav-link {{ request()->is('tools*') ? 'active' : '' }}">
                        <i class="fas fa-wrench"></i>
                        <span>Tools Library</span>
                    </a>
                    <a href="{{ route('clients') }}" class="nav-link {{ request()->is('clients') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Clients</span>
                    </a>

                    <a href="{{ route('activity') }}" class="nav-link {{ request()->is('activity') ? 'active' : '' }}">
                        <i class="fas fa-clock-rotate-left"></i>
                        <span>Activity</span>
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Account</div>
                    <a href="{{ route('account') }}" class="nav-link {{ request()->is('account*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Account Settings</span>
                    </a>
                </div>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-card">
                    <div class="user-avatar">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name ?? 'User' }}</div>
                        <div class="user-email" title="{{ Auth::user()->email ?? '' }}">{{ Auth::user()->email ?? '' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-wrapper">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <button class="hamburger" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-breadcrumb">
                        <span>@yield('breadcrumb', 'Dashboard')</span>
                    </div>
                </div>
                <div class="header-right">
                    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme"></button>
                    <div class="profile-dropdown">
                        <button class="profile-btn" onclick="toggleProfileMenu()">
                            <div class="avatar">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
                            <span>{{ Auth::user()->name ?? 'User' }}</span>
                            <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </button>
                        <div class="profile-menu" id="profileMenu">
                            <a href="/account" class="profile-menu-item">
                                <i class="fas fa-user-circle" style="color: var(--accent-primary);"></i>
                                <span>Account</span>
                            </a>
                            <div class="profile-menu-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="profile-menu-item danger" style="width: 100%;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        // Theme
        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        }
        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);

        // Sidebar toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        // Profile menu
        function toggleProfileMenu() {
            document.getElementById('profileMenu').classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown')) {
                document.getElementById('profileMenu').classList.remove('show');
            }
        });

        // Close sidebar on nav link click (mobile)
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    document.getElementById('sidebar').classList.remove('open');
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>