<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Tools Library - ServerAvatar MCP</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/fontawesome.css">
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
        
        .tools-table-wrap { overflow-x: auto; border-radius: 0; -webkit-overflow-scrolling: touch; }
        .tools-table { background: var(--bg-card); border: 1px solid var(--border-color); width: 100%; min-width: 600px; }
        .table-header { display: grid; grid-template-columns: minmax(200px, 240px) minmax(100px, 120px) 1fr minmax(70px, 90px); padding: 6px 1rem; background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); font-size: 11px; font-weight: 600; line-height: 16px; letter-spacing: 0.05em; text-transform: uppercase; gap: 1rem; box-sizing: border-box; }
        [data-theme="light"] .table-header { color: #64748B; }
        [data-theme="dark"] .table-header { color: #94A3B8; }
        .table-header > div { display: flex; align-items: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 12px 8px; justify-content: flex-start; }
        .table-header > div:last-child { justify-content: center; }
        .th-text { display: block; text-align: left; line-height: 1.4; }
        .th-text-center { display: block; text-align: center; line-height: 1.4; }
        .header-status-cell { display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; }
        .table-body { display: flex; flex-direction: column; }
        .table-row { display: grid; grid-template-columns: minmax(140px, 180px) minmax(100px, 120px) 1fr minmax(70px, 90px); padding: 0 1rem; border-bottom: 1px solid var(--border-color); align-items: center; transition: background 0.2s; gap: 1rem; box-sizing: border-box; }
        .table-row > div { display: flex; align-items: center; overflow: hidden; padding: 12px 8px; }
        .table-row > div:last-child { justify-content: center; }
        .table-row:last-child { border-bottom: none; }
        .table-row:hover { background: rgba(99, 102, 241, 0.05); }
        .tool-name-cell { display: flex; align-items: center; gap: 8px; width: 100%; min-width: 0; flex-shrink: 0; }
        .tool-name { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.8rem; color: var(--accent-primary); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .tool-name-icon { font-size: 1rem; flex-shrink: 0; }
        .tool-name-text { font-size: 13px; font-weight: 600; line-height: 20px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; min-width: 0; }
        [data-theme="light"] .tool-name-text { color: #0F172A; }
        [data-theme="dark"] .tool-name-text { color: #F8FAFC; }
        .tool-desc-cell { min-width: 0; flex-basis: 0; flex-grow: 1; display: flex; align-items: center; }
        .tool-desc-cell span { font-size: 13px; font-weight: 400; line-height: 20px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-secondary); }
        [data-theme="light"] .tool-desc-cell span { color: #475569; }
        [data-theme="dark"] .tool-desc-cell span { color: #CBD5E1; }
        
        .tool-status-cell { display: flex; align-items: center; justify-content: center; width: 100%; }
        .status-badge { display: inline-flex; align-items: center; gap: 4px; background: var(--accent-success-muted); color: var(--accent-success); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; line-height: 16px; justify-content: center; white-space: nowrap; }
        .status-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--accent-success); flex-shrink: 0; }
        
        /* Tooltip - Pure CSS */
        [data-tooltip] { position: relative; cursor: pointer; }
        .tooltip-box { position: fixed; background: var(--bg-secondary); border: 1px solid var(--border-color); color: var(--text-primary); padding: 10px 16px; border-radius: 4px; font-size: 0.85rem; max-width: 320px; min-width: 180px; white-space: normal; word-wrap: break-word; z-index: 99999; opacity: 0; visibility: hidden; transition: opacity 0.15s ease; box-shadow: 0 8px 24px rgba(0,0,0,0.4); line-height: 1.5; pointer-events: none; }
        
        /* Responsive Table */
        @media (max-width: 1024px) {
            .table-header { grid-template-columns: minmax(160px, 200px) minmax(90px, 110px) 1fr 70px; gap: 1rem; font-size: 0.7rem; }
            .table-row { grid-template-columns: minmax(160px, 200px) minmax(90px, 110px) 1fr 70px; gap: 1rem; }
            .tool-name { font-size: 0.75rem; }
            .tool-desc-cell span { font-size: 0.75rem; }
            .status-badge { font-size: 0.65rem; padding: 3px 8px; }
        }
        
        @media (max-width: 768px) {
            .tools-table { min-width: 550px; }
            .table-header { grid-template-columns: minmax(140px, 180px) minmax(80px, 100px) 1fr 60px; gap: 0.75rem; font-size: 0.65rem; padding: 0 0.75rem; }
            .table-row { grid-template-columns: minmax(140px, 180px) minmax(80px, 100px) 1fr 60px; gap: 0.75rem; padding: 0 0.75rem; }
            .table-header > div, .table-row > div { padding: 10px 6px; }
            .tool-name { font-size: 0.7rem; }
            .tool-name-icon { font-size: 0.85rem; }
            .tool-name-text { font-size: 12px; }
            .tool-desc-cell span { font-size: 0.7rem; }
            .status-badge { font-size: 0.6rem; padding: 3px 6px; }
            .th-text, .th-text-center { font-size: 0.65rem; }
        }
        
        @media (max-width: 480px) {
            .tools-table { min-width: 450px; }
            .table-header { grid-template-columns: minmax(90px, 120px) minmax(70px, 90px) 1fr 50px; gap: 0.5rem; font-size: 0.6rem; padding: 0 0.5rem; }
            .table-row { grid-template-columns: minmax(90px, 120px) minmax(70px, 90px) 1fr 50px; gap: 0.5rem; padding: 0 0.5rem; }
            .table-header > div, .table-row > div { padding: 8px 4px; }
            .tool-name { font-size: 0.65rem; }
            .tool-name-icon { font-size: 0.75rem; }
            .tool-name-text { font-size: 11px; }
            .tool-desc-cell span { font-size: 0.65rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .status-badge { font-size: 0.55rem; padding: 2px 5px; gap: 3px; }
            .status-dot { width: 4px; height: 4px; }
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
                    <span class="page-title-icon"><i class="fas fa-wrench" style="color: var(--accent-primary);"></i></span>
                    <span class="page-title-wrap">
                        <span class="page-title-text">Tools Library <span class="tools-count-badge">{{ $totalTools }} Tools</span></span>
                        <span class="page-subtitle">Browse all MCP tools available in your ServerAvatar account</span>
                    </span>
                </h1>
            </div>
            
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <form method="GET" action="{{ route('tools') }}" id="searchForm" style="display: flex; align-items: center; gap: 0.5rem; flex: 1;">
                    <input type="hidden" name="category" value="{{ $selectedCategory ?? '' }}">
                    <input type="hidden" name="page" id="searchPage" value="1">
                    <div class="search-box" style="max-width: 320px; position: relative; flex: 1;">
                        <span class="search-icon">🔍</span>
                        <input type="text" name="q" class="search-input" placeholder="Search tools..." id="searchInput" value="{{ $searchQuery ?? '' }}" autocomplete="off" style="padding-right: 35px;">
                        @if(!empty($searchQuery))
                        <a href="{{ route('tools') }}" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 18px; text-decoration: none;">&times;</a>
                        @endif
                    </div>
                    <button type="submit" class="btn-card-action" style="display: inline-block; width: auto; padding: 11px 16px; background: var(--accent-primary); color: white; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none; text-align: center; transition: all var(--transition-fast); border: none; cursor: pointer; white-space: nowrap; height: 40px;">Search</button>
                </form>
                <form method="GET" action="{{ route('tools') }}" id="filterForm" style="display: flex; align-items: center; gap: 0.5rem;">
                    <div style="position: relative; display: flex; align-items: center;">
                        <i class="fas fa-filter" style="position: absolute; left: 12px; color: var(--accent-primary); font-size: 12px; z-index: 1;"></i>
                        <select name="category" onchange="document.getElementById('filterForm').submit();" autocomplete="off" style="padding: 11px 36px 11px 32px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 13px; font-weight: 500; cursor: pointer; appearance: none; -webkit-appearance: none; min-width: 140px; height: 44px;">
                            <option value="" {{ empty($selectedCategory) ? 'selected' : '' }}>All Categories</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ $selectedCategory === $cat ? 'selected' : '' }}>{{ ucwords(preg_replace('/(?<=[a-z])([A-Z])/', ' $1', $cat)) }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down" style="position: absolute; right: 10px; color: var(--text-muted); font-size: 10px; pointer-events: none;"></i>
                    </div>
                </form>
                <a href="{{ route('tools') }}" style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 10px 14px; border-radius: var(--radius-md); cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; height: 44px;" title="Refresh">
                    <i class="fas fa-sync-alt" style="color: var(--accent-primary);"></i>
                </a>
            </div>
            
            <div class="tools-table-wrap">
            <div class="tools-table">
                <div class="table-header" style="grid-template-columns: minmax(200px, 240px) minmax(100px, 120px) 1fr minmax(70px, 90px);">
                    <div><span class="th-text">Tool Name</span></div>
                    <div><span class="th-text">Category</span></div>
                    <div><span class="th-text">Description</span></div>
                    <div class="header-status-cell"><span class="th-text-center">Status</span></div>
                </div>
                <div class="table-body" id="toolsTableBody">
                    @foreach($tools as $tool)
                    <div class="table-row" data-name="{{ $tool['name'] }}" data-status="{{ $tool['status'] }}" style="grid-template-columns: minmax(200px, 240px) minmax(100px, 120px) 1fr minmax(70px, 90px);">
                        <div class="tool-name-cell">
                            @php
                            $colors = ['#3b82f6', '#a855f7', '#22c55e', '#f59e0b', '#ef4444', '#0ea5e9', '#6366f1', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#06b6d4'];
                            $colorIndex = abs(crc32($tool['name'])) % count($colors);
                            $color = $colors[$colorIndex];
                            $r = hexdec(substr($color, 1, 2));
                            $g = hexdec(substr($color, 3, 2));
                            $b = hexdec(substr($color, 5, 2));
                            @endphp
                            <span style="width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.15); color: {{ $color }};">{{ $tool['icon'] }}</span>
                            <span class="tool-name-text" data-tooltip="{{ Str::title(str_replace('_', ' ', $tool['name'])) }}">{{ Str::title(str_replace('_', ' ', $tool['name'])) }}</span>
                        </div>
                        <div>
                            <span class="category-badge" style="display: inline-flex; align-items: center; gap: 4px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">{{ ucwords(preg_replace('/(?<=[a-z])([A-Z])/', ' $1', $tool['category'])) }}</span>
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
            
            @if(empty($searchQuery) && $totalPages > 1)
            <div class="pagination" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; background: var(--bg-secondary); border-top: 1px solid var(--border-color); border-radius: 0 0 var(--radius-lg) var(--radius-lg);">
                <div class="pagination-info" style="font-size: 14px; font-weight: 500; color: var(--text-secondary);">
                    Showing {{ ($currentPage - 1) * $perPage + 1 }} to {{ min($currentPage * $perPage, $totalTools) }} of {{ $totalTools }} tools
                </div>
                <div class="pagination-buttons" style="display: flex; align-items: center; gap: 6px;">
                    @if($currentPage > 1)
                    <a href="{{ route('tools') }}?page={{ $currentPage - 1 }}&q={{ urlencode($searchQuery ?? '') }}&category={{ urlencode($selectedCategory ?? '') }}" class="page-btn" style="padding: 8px 14px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-secondary); font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fas fa-chevron-left" style="font-size: 12px;"></i> Previous
                    </a>
                    @else
                    <span class="page-btn disabled" style="padding: 8px 14px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-muted); font-size: 14px; font-weight: 500; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fas fa-chevron-left" style="font-size: 12px;"></i> Previous
                    </span>
                    @endif
                    
                    @php
                        $start = max(1, $currentPage - 1);
                        $end = min($totalPages, $start + 2);
                        if ($end - $start < 2) {
                            $start = max(1, $end - 2);
                        }
                        // Add ellipsis at start
                        $showStartEllipsis = $start > 2;
                        $showEndEllipsis = $end < $totalPages - 1;
                    @endphp
                    
                    @if($start > 1)
                        <a href="{{ route('tools') }}?page=1&q={{ urlencode($searchQuery ?? '') }}&category={{ urlencode($selectedCategory ?? '') }}" class="page-btn" style="min-width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; padding: 8px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-secondary); font-size: 14px; font-weight: 500; text-decoration: none;">1</a>
                        @if($start > 2)
                        <span style="padding: 0 4px; color: var(--text-muted);">...</span>
                        @endif
                    @endif
                    
                    @for($i = $start; $i <= $end; $i++)
                        @if($i == $currentPage)
                        <span class="page-btn active" style="min-width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; padding: 8px; background: var(--accent-primary); border: 1px solid var(--accent-primary); border-radius: var(--radius-md); color: white; font-size: 14px; font-weight: 600;">{{ $i }}</span>
                        @else
                        <a href="{{ route('tools') }}?page={{ $i }}&q={{ urlencode($searchQuery ?? '') }}&category={{ urlencode($selectedCategory ?? '') }}" class="page-btn" style="min-width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; padding: 8px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-secondary); font-size: 14px; font-weight: 500; text-decoration: none;">{{ $i }}</a>
                        @endif
                    @endfor
                    
                    @if($end < $totalPages)
                        @if($end < $totalPages - 1)
                        <span style="padding: 0 4px; color: var(--text-muted);">...</span>
                        @endif
                        <a href="{{ route('tools') }}?page={{ $totalPages }}&q={{ urlencode($searchQuery ?? '') }}&category={{ urlencode($selectedCategory ?? '') }}" class="page-btn" style="min-width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; padding: 8px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-secondary); font-size: 14px; font-weight: 500; text-decoration: none;">{{ $totalPages }}</a>
                    @endif
                    
                    @if($currentPage < $totalPages)
                    <a href="{{ route('tools') }}?page={{ $currentPage + 1 }}&q={{ urlencode($searchQuery ?? '') }}&category={{ urlencode($selectedCategory ?? '') }}" class="page-btn" style="padding: 8px 14px; background: var(--accent-primary); border: 1px solid var(--accent-primary); border-radius: var(--radius-md); color: white; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        Next <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                    </a>
                    @else
                    <span class="page-btn disabled" style="padding: 8px 14px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-muted); font-size: 14px; font-weight: 500; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px;">
                        Next <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                    </span>
                    @endif
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
            if (menu) menu.classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            var dropdown = document.querySelector('.profile-dropdown');
            var menu = document.getElementById('profileMenu');
            if (dropdown && menu && !dropdown.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
        
        function submitWithSearch(page) {
            var searchInput = document.getElementById('searchInput');
            var searchPage = document.getElementById('searchPage');
            var searchForm = document.getElementById('searchForm');
            if (searchInput && searchPage && searchForm) {
                searchPage.value = page;
                searchForm.submit();
            }
            return false;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // No live filtering - only filter when Search button is clicked
            
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
        
        // Reset filter form on page load to default "All Categories" only on hard refresh
        (function() {
            var url = new URL(window.location);
            var hasCategory = url.searchParams.has('category') && url.searchParams.get('category') !== '';
            
            if (hasCategory) {
                // Page has category param - check if it's a form submission or hard refresh
                var formSubmitted = sessionStorage.getItem('filter_submitted');
                
                if (!formSubmitted) {
                    // Hard refresh - clear category and reload
                    url.searchParams.delete('category');
                    url.searchParams.delete('page');
                    history.replaceState({}, '', url);
                    location.reload();
                    return;
                } else {
                    // Form was submitted - clear the flag but keep category
                    sessionStorage.removeItem('filter_submitted');
                }
            }
            
            // Normal load or form submission - reset dropdown UI to match URL
            var categorySelect = document.querySelector('select[name="category"]');
            var categoryInput = document.querySelector('input[name="category"]');
            if (categorySelect) categorySelect.value = url.searchParams.get('category') || '';
            if (categoryInput) categoryInput.value = url.searchParams.get('category') || '';
        })();
        
        // Mark filter as submitted when dropdown changes (before form submit)
        document.querySelectorAll('select[name="category"]').forEach(function(select) {
            select.addEventListener('change', function() {
                sessionStorage.setItem('filter_submitted', 'true');
                // Small delay to ensure sessionStorage is set before form submits
                var form = this.closest('form');
                var originalAction = form.action;
                // Let the form submit naturally
            });
        });
    </script>
    <div id="tooltipBox" class="tooltip-box"></div>
</body>
</html>
