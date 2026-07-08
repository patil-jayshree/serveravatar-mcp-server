@extends('layouts.app')

@section('title', 'Dashboard - ServerAvatar MCP')

@section('body_attrs')
    data-has-api-key="{{ $user->hasApiKey() ? '1' : '0' }}"
    data-user-api-key="{{ $user->api_key ?? '' }}"
@endsection

@section('styles')
@parent
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
        }
        .icon-light, .icon-dark { display: block; vertical-align: middle; }
        [data-theme="light"] .icon-light { display: block !important; }
        [data-theme="light"] .icon-dark { display: none !important; }
        [data-theme="dark"] .icon-light { display: none !important; }
        [data-theme="dark"] .icon-dark { display: block !important; }
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
        .main-content { padding-top: 60px; min-height: 100vh; width: 100%; box-sizing: border-box; position: relative; padding-bottom: 80px; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }

        /* Page Header */
        .page-header { margin-bottom: 1.5rem; }
        .page-title { font-size: 2rem; font-weight: 700; margin-bottom: 0.25rem; }
        .page-subtitle { font-size: 0.875rem; font-weight: 400; color: var(--text-secondary); }


        /* Recent Activity Section */
        .activity-section { margin-bottom: 1.5rem; }
        .section-header-row { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; }
        .activity-count-badge { font-size: 0.75rem; font-weight: 600; padding: 2px 8px; border-radius: 20px; background: rgba(139, 92, 246, 0.15); color: var(--accent-primary); }
        .activity-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1rem; }
        .activity-list { display: flex; flex-direction: column; gap: 0; }
        .activity-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 0; border-bottom: 1px solid var(--border-color); }
        .activity-item:last-child { border-bottom: none; }
        .activity-icon { font-size: 1.1rem; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: var(--bg-secondary); border-radius: 8px; flex-shrink: 0; }
        .activity-content { flex: 1; min-width: 0; }
        .activity-description { font-size: 0.875rem; font-weight: 500; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .activity-meta { font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px; display: flex; align-items: center; gap: 0.25rem; }
        .activity-client { font-weight: 500; }
        .activity-sep { color: var(--text-secondary); }
        .activity-time { color: var(--text-secondary); }
        .activity-badge { font-size: 0.65rem; font-weight: 600; padding: 2px 8px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.03em; flex-shrink: 0; }
        .badge-success { background: rgba(22, 163, 74, 0.15); color: #16a34a; }
        .badge-info { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
        .badge-warning { background: rgba(245, 158, 11, 0.15); color: #d97706; }
        .badge-danger { background: rgba(220, 38, 38, 0.15); color: #dc2626; }
        .badge-secondary { background: rgba(148, 163, 184, 0.15); color: #64748b; }
        .activity-empty { text-align: center; padding: 2rem; color: var(--text-secondary); }
        .activity-empty p { font-size: 0.875rem; margin-top: 0.5rem; }

        /* Quick Setup Section */
        .quick-setup-section { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.5rem; }
        .quick-setup-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
        .quick-setup-steps { display: flex; align-items: center; justify-content: center; gap: 0.5rem; }

        /* Welcome Back Card */
        .welcome-back-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem 2rem; margin-bottom: 1.5rem; }
        .wb-top { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.25rem; }
        .wb-left { display: flex; align-items: center; gap: 0.75rem; }
        .wb-icon { width: 44px; height: 44px; border-radius: 12px; background: var(--accent-primary-muted); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .wb-text { display: flex; flex-direction: column; gap: 0.2rem; }
        .wb-greeting-line { display: flex; align-items: baseline; gap: 0.5rem; }
        .wb-greeting { font-size: 1.15rem; color: var(--text-primary); line-height: 1; }
        .wb-greeting-text { font-size: 1.15rem; font-weight: 700; color: var(--text-primary); }
        .wb-subtitle { font-size: 0.85rem; color: var(--text-secondary); display: flex; align-items: center; flex-wrap: wrap; gap: 0.5rem; line-height: 1.5; }
        .wb-online-badge { display: inline-flex; align-items: center; gap: 4px; background: rgba(22, 163, 74, 0.12); color: #16a34a; padding: 2px 8px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; white-space: nowrap; }
        .wb-actions { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
        .wb-action-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--accent-primary); font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; white-space: nowrap; }
        .wb-action-btn:hover { border-color: var(--accent-primary); background: var(--accent-primary-muted); transform: translateY(-1px); }
        .wb-action-btn.primary { background: var(--accent-primary); border-color: var(--accent-primary); color: white; }
        .wb-action-btn.primary:hover { background: var(--accent-primary-hover); border-color: var(--accent-primary-hover); color: white; }
        .wb-action-btn svg { flex-shrink: 0; }
        @media (max-width: 768px) { .wb-top { flex-direction: column; align-items: flex-start; gap: 0.75rem; } .wb-actions { width: 100%; } }
        @media (max-width: 480px) { .wb-actions { flex-direction: column; } .wb-action-btn { justify-content: center; width: 100%; } }

        /* Analytics Cards */
        .analytics-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
        .analytics-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem; display: flex; flex-direction: column; gap: 0.5rem; transition: all var(--transition-fast); }
        .analytics-card:hover { border-color: var(--border-color-hover); transform: translateY(-2px); }
        .analytics-card-label { font-size: 0.8rem; color: var(--text-secondary); font-weight: 500; }
        .analytics-card-value-row { display: flex; align-items: flex-end; justify-content: space-between; gap: 0.5rem; }
        .analytics-card-value { font-size: 1.75rem; font-weight: 700; color: var(--text-primary); line-height: 1; }
        .analytics-card-trend { display: inline-flex; align-items: center; gap: 2px; font-size: 0.75rem; font-weight: 600; padding: 2px 6px; border-radius: 20px; white-space: nowrap; margin-bottom: 2px; }
        .trend-up { background: rgba(22, 163, 74, 0.15); color: var(--accent-success); }
        .trend-down { background: rgba(220, 38, 38, 0.15); color: var(--accent-danger); }
        .trend-neutral { background: rgba(139, 92, 246, 0.15); color: var(--accent-primary); }
        .analytics-chart { height: 40px; margin-top: 0.25rem; }
        .analytics-chart svg { width: 100%; height: 100%; overflow: visible; }
        
        .step-number { width: 36px; height: 36px; border-radius: 50%; background: #7C3AED; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; margin-bottom: 0.75rem; }
        .step-content { width: 100%; flex: 1; display: flex; flex-direction: column; justify-content: center; }
        .step-title { font-size: 15px; font-weight: 600; margin-bottom: 0.25rem; color: #7C3AED; }
        .step-desc { font-size: 12px; font-weight: 400; color: #7C3AED; line-height: 1.4; opacity: 0.8; }
        .step-arrow { color: #7C3AED; font-size: 1.5rem; flex-shrink: 0; }

        /* MCP Status Card */
        .mcp-status-card { background: linear-gradient(135deg, #1a1033 0%, #2d1f5c 100%); border: 1px solid #3d2d6b; border-radius: var(--radius-lg); padding: 1.5rem 2rem; margin-bottom: 1.5rem; position: relative; overflow: hidden; }
        [data-theme="light"] .mcp-status-card { background: #ffffff; border: 1px solid #e0e7ff; box-shadow: 0 4px 20px rgba(99, 102, 241, 0.1); }
        .mcp-status-card::before { content: ''; position: absolute; top: -30%; right: 8%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(139, 92, 246, 0.12) 0%, transparent 70%); pointer-events: none; }
        [data-theme="light"] .mcp-status-card::before { display: none; }
        .status-main-row { display: flex; align-items: center; justify-content: space-between; gap: 2rem; }
        .status-left { display: flex; align-items: center; gap: 1rem; }
        .status-badge { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #16a34a 0%, #16a34a 100%); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; font-weight: 700; box-shadow: 0 0 25px rgba(34, 197, 94, 0.5); flex-shrink: 0; }
        .status-info { display: flex; flex-direction: column; gap: 0.15rem; }
        .status-above { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em; }
        .status-title { font-size: 20px; font-weight: 700; color: #16a34a; }
        .status-subtitle { font-size: 12px; font-weight: 400; color: #94a3b8; }
        .status-metrics { display: flex; align-items: center; gap: 1.5rem; flex: 1; justify-content: center; }
        .metric-item { text-align: center; display: flex; flex-direction: column; align-items: center; }
        .metric-value { font-size: 20px; font-weight: 700; color: #f8fafc; display: flex; align-items: center; gap: 0.3rem; white-space: nowrap; }
        .metric-value.text-green { color: #16a34a; }
        .green-dot { width: 8px; height: 8px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 6px rgba(34, 197, 94, 0.8); flex-shrink: 0; }
        .green-dot-sm { display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 5px rgba(34, 197, 94, 0.8); margin-right: 4px; vertical-align: middle; }
        .text-green { color: #16a34a; }
        .text-red { color: #ef4444; }
        .metric-label { font-size: 11px; font-weight: 500; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.2rem; }
        .metric-label-inline { font-size: 0.7rem; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 0.25rem; margin-top: 0.25rem; }
        .metric-item.single-line { display: flex; align-items: center; gap: 0.4rem; white-space: nowrap; }
        .metric-value-sm { font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.85); }
        .divider-dot { color: rgba(255,255,255,0.5); font-size: 0.85rem; }
        .metric-main { font-size: 1rem; font-weight: 700; color: #16a34a; }
        .metric-sub { font-size: 0.7rem; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 0.3rem; margin-top: 0.2rem; }
        .metric-item-stack { display: flex; flex-direction: column; gap: 0.15rem; }
        .metric-top { font-size: 0.95rem; font-weight: 700; color: #16a34a; }
        .metric-bottom { font-size: 0.65rem; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 0.25rem; }
        .green-dot-xs { display: inline-block; width: 5px; height: 5px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 4px rgba(34, 197, 94, 0.8); flex-shrink: 0; }
        .metric-item-block { display: flex; flex-direction: column; align-items: center; gap: 0.2rem; }
        .metric-main-text { font-size: 1rem; font-weight: 700; color: #16a34a; }
        .metric-sub-text { font-size: 0.65rem; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 0.3rem; }
        .green-dot-inline { width: 6px; height: 6px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 5px rgba(34, 197, 94, 0.8); flex-shrink: 0; }
        .metric-inline { display: flex; align-items: center; gap: 0.4rem; white-space: nowrap; }
        .green-bullet { width: 7px; height: 7px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 6px rgba(34, 197, 94, 0.8); flex-shrink: 0; }
        .inline-label { font-size: 14px; font-weight: 400; color: #94a3b8; }
        .inline-sep { font-size: 0.85rem; color: rgba(255,255,255,0.5); }
        .inline-value { font-size: 0.85rem; font-weight: 700; }
        .text-green { color: #16a34a; }
        .metric-stack { display: flex; flex-direction: column; gap: 0.15rem; align-items: center; }
        .metric-online { font-size: 18px; font-weight: 700; color: #16a34a; }
        [data-theme="light"] .metric-online { color: #16a34a; }
        [data-theme="light"] .status-above { color: #6b7280; }
        [data-theme="light"] .status-subtitle { color: #6b7280; }
        [data-theme="light"] .inline-label { color: #6b7280; }
        [data-theme="light"] .status-title { color: #16a34a; }
        [data-theme="light"] .status-subtitle { color: #374151; }
        [data-theme="light"] .inline-label { color: #374151; }
        [data-theme="light"] .metric-label { color: #6b7280; }
        [data-theme="light"] .metric-value { color: #111827; }
        [data-theme="light"] .metric-divider { background: rgba(107, 114, 128, 0.2); }
        [data-theme="light"] .green-bullet { background: #16a34a; box-shadow: 0 0 6px rgba(22, 163, 74, 0.6); }
        [data-theme="light"] .metric-bottom { color: #374151; }
        [data-theme="light"] .status-graphic { opacity: 1; }
        [data-theme="light"] .server-illustration-img { filter: none; }
        [data-theme="light"] .text-green { color: #15803d; }
        [data-theme="light"] .mcp-url-text { color: #374151; }
        [data-theme="light"] .tool-name { color: #7c3aed; }
        /* Info Cards Row */
        .info-cards-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
        .info-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem; display: flex; flex-direction: column; gap: 0.75rem; transition: all var(--transition-normal); }
        .info-card:hover { border-color: var(--border-color-hover); box-shadow: var(--shadow-md); }
        .info-card-header { display: flex; align-items: center; gap: 0.75rem; }
        .info-card-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
        .person-icon { background: rgba(139, 92, 246, 0.12); }
        .shield-icon { background: rgba(139, 92, 246, 0.12); }
        .key-icon { background: rgba(139, 92, 246, 0.12); }
        .info-card-label { font-size: 14px; font-weight: 600; color: var(--text-primary); }
        .info-card-body { display: flex; flex-direction: column; gap: 0.2rem; }
        .info-card-name { font-size: 18px; font-weight: 700; color: var(--text-primary); }
        .info-card-email { font-size: 13px; font-weight: 400; color: var(--text-secondary); }
        .info-card-status-main { font-size: 18px; font-weight: 700; }
        .info-card-status-sub { font-size: 13px; font-weight: 400; color: var(--text-secondary); }
        .info-card-time { font-size: 0.75rem; color: var(--text-muted); }
        .btn-card-action { display: block; width: 100%; padding: 10px 16px; background: var(--accent-primary); color: white; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none; text-align: center; transition: all var(--transition-fast); margin-top: auto; }
        .btn-card-action:hover { background: var(--accent-primary-hover); transform: translateY(-1px); }
        .btn-card-action.secondary { background: rgba(250, 204, 21, 0.15); color: #ca8a04; border: 1px solid rgba(250, 204, 21, 0.3); }
        .btn-card-action.secondary:hover { background: rgba(250, 204, 21, 0.25); }
        [data-theme="light"] .btn-card-action.secondary { background: rgba(161, 98, 7, 0.1); color: #a16207; border-color: rgba(161, 98, 7, 0.2); }
        [data-theme="light"] .info-card-icon.person-icon { background: rgba(124, 92, 252, 0.15); }
        [data-theme="light"] .info-card-icon.shield-icon { background: rgba(124, 92, 252, 0.15); }
        [data-theme="light"] .info-card-icon.key-icon { background: rgba(139, 92, 246, 0.12); }
        /* Modal */
        .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; backdrop-filter: blur(4px); }
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
        .modal-footer { display: flex; gap: 1rem; padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); justify-content: flex-end; background: var(--bg-primary); border-radius: 0 0 var(--radius-lg) var(--radius-lg); }
        .btn-modal-cancel { padding: 12px 24px; background: transparent; border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-secondary); font-size: 0.9rem; font-weight: 600; cursor: pointer; }
        .btn-modal-cancel:hover { background: var(--bg-tertiary); color: var(--text-primary); }
        .btn-modal-save { padding: 12px 28px; background: var(--accent-primary); border: none; border-radius: 10px; color: white; font-size: 0.9rem; font-weight: 700; cursor: pointer; box-shadow: 0 4px 15px rgba(124, 92, 252, 0.3); }
        .btn-modal-save:hover { background: var(--accent-primary-hover); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(124, 92, 252, 0.4); }
        /* Toast */
        .toast { position: fixed; top: 90px; right: 20px; background: linear-gradient(135deg, #16a34a 0%, #16a34a 100%); color: white; padding: 14px 20px; border-radius: 12px; display: none; align-items: center; gap: 12px; box-shadow: 0 8px 30px rgba(34, 197, 94, 0.4); z-index: 10000; max-width: 350px; }
        .toast.show { display: flex; animation: slideIn 0.3s ease; }
        .toast-icon { width: 28px; height: 28px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: bold; }
        .toast-message { font-size: 0.9rem; font-weight: 600; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .metric-inline.centered { justify-content: center; }
        .metric-item.centered { text-align: center; }
        .metric-divider { width: 1px; height: 35px; background: rgba(255,255,255,0.12); }
        .status-graphic { display: flex; align-items: flex-end; justify-content: flex-end; }
        .server-scene { position: relative; display: flex; align-items: flex-end; }
        .iso-servers { display: flex; flex-direction: column; gap: 0; }
        .iso-server { width: 80px; height: 45px; position: relative; margin-bottom: -5px; }
        .iso-top { position: absolute; top: 0; left: 10px; width: 60px; height: 12px; background: #4a4a5a; border-radius: 2px; transform: skewX(-45deg); z-index: 1; }
        .iso-body { position: absolute; bottom: 0; left: 0; width: 100%; height: 38px; display: flex; }
        .iso-front { flex: 1; background: #2d2d3a; border-radius: 0 0 0 4px; padding: 8px 12px; display: flex; flex-direction: column; justify-content: center; gap: 6px; border-left: 3px solid #1a1a24; border-bottom: 3px solid #1a1a24; }
        .iso-right { width: 15px; background: #22222d; border-radius: 0 4px 4px 0; border-right: 3px solid #1a1a24; border-bottom: 3px solid #1a1a24; }
        .iso-lights { display: flex; gap: 7px; }
        .light-green { width: 10px; height: 10px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 8px #16a34a, 0 0 15px rgba(34, 197, 94, 0.5); }
        .iso-panel { display: flex; flex-direction: column; gap: 3px; }
        .panel-line { width: 45px; height: 4px; background: rgba(255,255,255,0.08); border-radius: 1px; }
        .panel-line.short { width: 30px; }
        .iso-shield { position: absolute; right: -10px; bottom: 5px; z-index: 10; }
        .iso-shield.foreground { right: -15px; bottom: -5px; z-index: 10; }
        .shield-shape { width: 70px; height: 80px; background: linear-gradient(135deg, #16a34a 0%, #16a34a 100%); border-radius: 8px 8px 35px 35px; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 25px rgba(34, 197, 94, 0.5), inset 0 2px 10px rgba(255,255,255,0.2); position: relative; }
        .shield-shape::before { content: ''; position: absolute; inset: -8px; background: radial-gradient(ellipse at center, rgba(34, 197, 94, 0.25) 0%, transparent 70%); }
        .shield-inner { font-size: 2.5rem; color: white; font-weight: bold; }
        .server-illustration-img { width: 220px; height: auto; opacity: 0; transition: opacity 0.3s ease; }

        /* Cards */
        .card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem; margin-bottom: 1rem; }
        .card:hover { border-color: var(--border-color-hover); }

        /* Connection Status Grid */
        .status-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 1rem; }
        .status-item { background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; }
        .status-label { color: var(--text-muted); font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
        .status-value { font-weight: 600; font-size: 0.9rem; }
        .status-value small { display: block; color: var(--text-secondary); font-weight: 400; font-size: 0.8rem; margin-top: 2px; }

        /* Status Badges */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-success { background: var(--accent-success-muted); color: var(--accent-success); }
        .badge-warning { background: var(--accent-warning-muted); color: var(--accent-warning); }

        /* API Key Section */
        .api-key-header { display: flex; align-items: center; gap: 12px; margin-bottom: 0.75rem; }
        .api-key-icon { width: 40px; height: 40px; border-radius: var(--radius-sm); background: var(--accent-primary-muted); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        .api-key-title { font-size: 1rem; font-weight: 700; }
        .api-key-desc { color: var(--text-secondary); font-size: 0.8rem; margin-bottom: 1rem; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 18px; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer; transition: all var(--transition-fast); text-decoration: none; }
        .btn-primary { background: var(--accent-primary); color: white; }
        .btn-primary:hover { background: var(--accent-primary-hover); }
        .btn-ghost { background: transparent; color: var(--text-secondary); border: 1px solid var(--border-color); }
        .btn-ghost:hover { border-color: var(--border-color-hover); color: var(--text-primary); }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }

        /* MCP URL Box */
        .mcp-url-row { display: flex; align-items: center; gap: 12px; margin-top: 1rem; }
        .mcp-url-box { flex: 1; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 10px 16px; display: flex; align-items: center; overflow: hidden; }
        .mcp-url-display { display: flex; align-items: center; gap: 12px; flex: 1; overflow: hidden; }
        .mcp-url-display svg { color: var(--accent-info); flex-shrink: 0; }
        .mcp-url-text { font-family: 'JetBrains Mono', 'Menlo', 'Consolas', monospace; font-size: 14px; font-weight: 500; color: #cbd5e1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .copy-url-btn { display: flex; align-items: center; gap: 8px; padding: 12px 24px; background: var(--accent-info); color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all var(--transition-fast); white-space: nowrap; flex-shrink: 0; }
        .copy-url-btn:hover { background: #2563eb; transform: translateY(-1px); }
        .copy-url-btn.copied { background: var(--accent-success); }
        /* Quick Actions */
        .quick-actions-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; }
        .quick-action-btn { display: flex; align-items: center; justify-content: center; gap: 0.75rem; padding: 0.75rem 1rem; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 10px; text-decoration: none; cursor: pointer; transition: all var(--transition-fast); }
        .quick-action-btn:hover { border-color: var(--accent-primary); background: var(--bg-card-hover); transform: translateY(-1px); }
        .qa-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .qa-tools { background: rgba(139, 92, 246, 0.12); color: var(--accent-primary); }
        .qa-key { background: rgba(139, 92, 246, 0.12); color: var(--accent-primary); }
        .qa-clients { background: rgba(139, 92, 246, 0.12); color: var(--accent-primary); }
        .qa-label { font-size: 14px; font-weight: 600; color: var(--text-primary); white-space: nowrap; }

        /* MCP Meta Grid */
        .mcp-meta { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 1.25rem; }
        .mcp-meta-item { background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 0.875rem 1rem; }
        .mcp-meta-label { color: var(--text-muted); font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .mcp-meta-value { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); word-break: break-all; }

        /* MCP Status Bar */
        .mcp-status-bar { display: flex; align-items: center; background: rgba(124, 92, 252, 0.08); border: 1px solid rgba(124, 92, 252, 0.15); border-radius: var(--radius-md); margin-top: 1rem; overflow: hidden; }
        .mcp-status-item { display: flex; align-items: center; gap: 8px; padding: 12px 16px; flex: 1; justify-content: center; }
        .mcp-status-item:first-child { padding-left: 20px; }
        .mcp-status-item:last-child { padding-right: 20px; }
        .mcp-status-divider { width: 1px; height: 24px; background: rgba(124, 92, 252, 0.2); flex-shrink: 0; }
        .mcp-status-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .mcp-status-dot.online { background: #16a34a; box-shadow: 0 0 8px rgba(34, 197, 94, 0.5); }
        .mcp-status-icon { font-size: 1rem; }
        .mcp-status-text { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }

        /* API Key Section Box */
        .api-key-section-box { display: flex; align-items: center; justify-content: space-between; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 14px 16px; margin-top: 1rem; gap: 1rem; }
        .api-key-section-left { flex: 1; min-width: 0; }
        .api-key-section-label { font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 4px; }
        .api-key-section-value { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.85rem; color: var(--accent-primary); word-break: break-all; }
        .api-key-section-empty { font-size: 0.85rem; color: var(--text-secondary); }
        .api-key-section-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 0.8rem; font-weight: 600; color: var(--text-primary); text-decoration: none; transition: all var(--transition-fast); white-space: nowrap; }
        .api-key-section-btn:hover { border-color: var(--accent-primary); color: var(--accent-primary); }
        .api-key-section-actions { display: flex; justify-content: flex-end; margin-top: 1rem; }

        /* API Status Row */
        .api-status-row { display: flex; align-items: center; background: rgba(124, 92, 252, 0.04); border: 1px solid rgba(139, 92, 246, 0.12); border-radius: var(--radius-md); margin-top: 1rem; overflow: hidden; }
        .api-status-item { display: flex; align-items: center; gap: 12px; padding: 14px 16px; flex: 1; }
        .api-status-icon { width: 40px; height: 40px; background: rgba(139, 92, 246, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .api-status-content { display: flex; flex-direction: column; gap: 4px; }
        .api-status-label { font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.03em; }
        .api-status-value { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); }
        .api-status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .api-status-badge.badge-success { background: rgba(34, 197, 94, 0.12); color: #16a34a; }
        .api-status-badge.badge-warning { background: rgba(139, 92, 246, 0.12); color: #d97706; }
        .api-status-badge.badge-purple { background: rgba(139, 92, 246, 0.12); color: var(--accent-primary); }
        .api-status-divider { width: 1px; height: 40px; background: rgba(139, 92, 246, 0.12); flex-shrink: 0; }

        /* API Key Input Row */
        .api-key-input-row { display: flex; align-items: flex-end; gap: 12px; margin-top: 1rem; }
        .api-key-input-group { flex: 1; }
        .api-key-input-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px; }
        .api-key-input-wrapper { position: relative; display: flex; align-items: center; }
        .api-key-input { width: 100%; padding: 12px 44px 12px 16px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.9rem; color: var(--text-primary); font-family: monospace; }
        .api-key-input::placeholder { color: var(--text-muted); font-family: inherit; }
        .api-key-eye-btn { position: absolute; right: 12px; background: none; border: none; cursor: pointer; font-size: 1rem; opacity: 0.6; }
        .api-key-eye-btn:hover { opacity: 1; }
        .api-key-action-btn { padding: 12px 20px; border-radius: var(--radius-md); font-weight: 600; font-size: 0.85rem; white-space: nowrap; }

        /* API Info Callout */
        .api-info-callout { display: flex; align-items: flex-start; gap: 12px; background: rgba(124, 92, 252, 0.06); border: 1px solid rgba(124, 92, 252, 0.1); border-radius: var(--radius-md); padding: 14px 16px; margin-top: 1rem; }
        .api-info-icon { width: 28px; height: 28px; background: var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; color: white; flex-shrink: 0; font-style: normal; font-weight: 600; }
        .api-info-content { display: flex; flex-direction: column; gap: 4px; }
        .api-info-text { font-size: 0.85rem; color: var(--text-primary); }
        .api-info-subtext { font-size: 0.8rem; color: var(--text-secondary); }
        .no-api-key-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 1rem; margin-top: 1rem; }
        .no-api-key-card { padding: 1.25rem 1.5rem; background: rgba(124, 92, 252, 0.06); border: 1px solid rgba(124, 92, 252, 0.15); border-radius: var(--radius-md); }
        .no-api-key-left { display: flex; align-items: center; gap: 1rem; }
        .no-api-key-icon-circle { width: 40px; height: 40px; background: rgba(139, 92, 246, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .no-api-key-content { display: flex; flex-direction: column; gap: 8px; }
        .no-api-key-title { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); }
        .no-api-key-desc { font-size: 0.75rem; color: var(--text-secondary); line-height: 1.4; }
        .btn-add-api-key { background: var(--accent-primary); border: none; font-size: 0.8rem; padding: 10px 16px; border-radius: var(--radius-md); font-weight: 600; width: 100%; text-align: center; }
        .no-api-key-info { display: flex; flex-direction: row; align-items: flex-start; gap: 10px; padding: 1rem 1.25rem; background: rgba(124, 92, 252, 0.08); border: 1px solid rgba(124, 92, 252, 0.2); border-radius: var(--radius-md); }
        .no-api-key-info-icon { width: 24px; height: 24px; background: rgba(139, 92, 246, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: white; font-weight: 600; font-style: normal; flex-shrink: 0; }
        .no-api-key-info-content { display: flex; flex-direction: column; gap: 4px; }
        .no-api-key-info-text { font-size: 0.8rem; color: var(--text-primary); line-height: 1.5; }
        .no-api-key-info-subtext { font-size: 0.75rem; color: var(--text-secondary); line-height: 1.4; }
        .api-key-configured-row { display: flex; align-items: center; gap: 12px; margin-top: 1rem; }
        .api-key-input-group-new { display: flex; align-items: center; flex: 1; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden; }
        .api-key-input-new { flex: 1; padding: 10px 14px; font-size: 0.8rem; border: none; background: transparent; color: var(--text-primary); font-family: monospace; }
        .api-key-show-btn { display: flex; align-items: center; gap: 6px; padding: 10px 14px; background: var(--bg-primary); border: none; border-left: 1px solid var(--border-color); font-size: 0.75rem; color: var(--accent-primary); cursor: pointer; font-weight: 500; white-space: nowrap; }
        .api-key-show-btn:hover { background: var(--accent-primary-muted); }
        .api-key-update-btn { display: flex; align-items: center; gap: 8px; padding: 10px 18px; background: var(--accent-primary); border: none; border-radius: var(--radius-md); font-size: 0.8rem; color: white; cursor: pointer; font-weight: 600; white-space: nowrap; }
        .api-key-update-btn:hover { opacity: 0.9; }
        .api-key-last-used { display: flex; align-items: center; gap: 12px; margin-top: 1rem; padding: 1rem 1.25rem; background: rgba(124, 92, 252, 0.08); border: 1px solid rgba(124, 92, 252, 0.15); border-radius: var(--radius-md); }
        .api-key-last-icon { width: 40px; height: 40px; background: var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .api-key-last-text { display: flex; flex-direction: column; gap: 2px; }
        .api-key-last-main { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); }
        .api-key-last-sub { font-size: 0.75rem; color: var(--text-secondary); }

        /* Integration Grid */
        .section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 0.75rem; }
        .section-icon { width: 38px; height: 38px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .section-title { font-size: 18px; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; color: var(--section-title-color); }
        
        .section-header-row { position: relative; padding: 0; }
        .section-header-left { display: flex; align-items: center; gap: 0.75rem; }
        .section-header-left .section-icon { flex-shrink: 0; }
        .section-header-left .section-title { white-space: nowrap; }
        .section-header-row .btn { position: absolute; right: 0; top: 50%; transform: translateY(-50%); white-space: nowrap; }
        .view-all-link { position: absolute; right: 12px; top: 12px; font-size: 13px; font-weight: 500; color: #7c3aed; text-decoration: none; }
        .section-desc { color: var(--text-secondary); font-size: 13px; font-weight: 400; margin-bottom: 0.75rem; }
        .clients-list-new { display: flex; flex-direction: column; gap: 0.5rem; margin-top: 1rem; }
        
        .client-col-icon { width: 36px; height: 28px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .client-col-name { display: flex; align-items: center; }
        .client-col-status { display: flex; justify-content: center; align-items: center; width: 100%; }
        .client-col-time { display: flex; justify-content: flex-end; text-align: right; }
        .client-icon-fallback { font-size: 1rem; }
        .client-name { font-size: 0.85rem; font-weight: 500; color: var(--text-primary); white-space: nowrap; }
        .badge-active { display: inline-flex; align-items: center; justify-content: center; background: rgba(34, 197, 94, 0.15); color: #16a34a; padding: 3px 8px; border-radius: 999px; font-size: 11px; font-weight: 600; white-space: nowrap; height: 22px; }
        .client-time { font-size: 12px; font-weight: 400; color: #94a3b8; white-space: nowrap; }
        .clients-footer { margin-top: 0.75rem; font-size: 0.85rem; color: var(--accent-primary); padding: 0.5rem 0; }
        .clients-empty { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem 1rem; }
        .clients-empty-icon { margin-bottom: 1rem; }
        .clients-empty-title { font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; }
        .clients-empty-desc { font-size: 0.875rem; color: var(--text-secondary); line-height: 1.5; max-width: 280px; }
        .client-col-icon { width: 36px; height: 28px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .client-col-name { display: flex; align-items: center; }
        .client-col-status { display: flex; justify-content: center; align-items: center; width: 100%; }
        .client-col-time { display: flex; justify-content: flex-end; text-align: right; }
        .client-icon-fallback { font-size: 1rem; }
        .badge-active { display: inline-flex; align-items: center; justify-content: center; background: rgba(34, 197, 94, 0.15); color: #16a34a; padding: 3px 8px; border-radius: 999px; font-size: 11px; font-weight: 600; white-space: nowrap; height: 22px; }
        
        .integration-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-top: 1rem; }
        .integration-card.simple { position: relative; display: flex; align-items: center; gap: 0.75rem; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; transition: all var(--transition-fast); }
        .integration-card.simple:hover { border-color: var(--border-color-hover); transform: translateY(-2px); }
        .badge-top-right { position: absolute; top: 8px; right: 8px; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; }
        .badge-popular { background: rgba(124, 92, 252, 0.2); color: #7c5cfb; border-radius: 999px; }
        .badge-success { background: rgba(16, 163, 127, 0.15); color: var(--accent-success); border-radius: 999px; }
        .integration-logo { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .integration-logo .icon-light, .integration-logo .icon-dark { width: 28px; height: 28px; object-fit: contain; }
        .client-col-icon .icon-light, .client-col-icon .icon-dark { width: 28px; height: 28px; object-fit: contain; flex-shrink: 0; }
        .integration-text { display: flex; flex-direction: column; gap: 0.15rem; flex: 1; min-width: 0; }
        .integration-name { font-weight: 600; font-size: 15px; color: var(--text-primary); }
        .integration-desc { font-weight: 400; color: var(--text-secondary); font-size: 13px; }
        .integration-card.more-card { border-style: dashed; border-color: var(--border-color-hover); background: transparent; }
        .integration-card.more-card:hover { background: var(--bg-card); }
        .integration-card.more-card .integration-logo { background: rgba(124, 92, 252, 0.08); }

        .integration-copy.copied { color: var(--accent-success); }
        .integration-more { background: var(--accent-primary-muted); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem 1.5rem; display: flex; align-items: center; gap: 1.5rem; transition: all 0.25s ease; grid-column: 1 / -1; }

        /* MCP Info Box */
        .mcp-info-box { display: flex; align-items: center; gap: 1rem; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: var(--radius-md); padding: 1rem 1.25rem; grid-column: 1 / -1; }
        .mcp-info-icon { font-size: 1.5rem; flex-shrink: 0; }
        .mcp-info-content { flex: 1; min-width: 0; }
        .mcp-info-text { font-size: 0.85rem; color: var(--text-primary); line-height: 1.5; }
        .mcp-info-url { display: inline-block; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 2px 8px; font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.75rem; color: var(--accent-info); margin: 0 4px; }
        .mcp-info-copy-btn { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: var(--bg-card); border: 1px solid rgba(59, 130, 246, 0.4); border-radius: var(--radius-sm); color: var(--accent-info); font-size: 13px; font-weight: 600; cursor: pointer; transition: all var(--transition-fast); white-space: nowrap; flex-shrink: 0; }
        .mcp-info-copy-btn:hover { background: var(--accent-info-muted); border-color: var(--accent-info); }
        .mcp-info-copy-btn.copied { background: var(--accent-success-muted); color: var(--accent-success); border-color: var(--accent-success); }
        .integration-more:hover { border-color: var(--accent-primary); }
        .integration-more-icon { width: 44px; height: 44px; border-radius: 50%; background: var(--accent-primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .integration-more-title { font-weight: 700; font-size: 0.9rem; color: var(--text-primary); margin-bottom: 2px; }
        .integration-more-desc { color: var(--text-secondary); font-size: 0.75rem; }
        .integration-more-right { flex: 1; min-width: 0; padding-left: 1.5rem; border-left: 1px solid var(--border-color); display: flex; flex-direction: column; justify-content: center; }
        .integration-more-subtitle { color: var(--text-primary); font-size: 0.75rem; font-weight: 600; margin-bottom: 10px; }
        .integration-tags { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
        .integration-tag { display: inline-flex; align-items: center; gap: 4px; background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-secondary); padding: 4px 8px 4px 4px; border-radius: 20px; font-size: 0.7rem; font-weight: 500; }
        .integration-tag-icon { width: 16px; height: 16px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.7rem; }
        .integration-tag-more { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; background: var(--accent-primary); color: white; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }

        /* Tools Config */
        .config-list { display: flex; flex-direction: column; gap: 0.75rem; }
        .two-col-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem; }
        .tool-item { display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0.75rem; background: var(--bg-card); border-radius: var(--radius-sm); }
        .tool-item-left { display: flex; align-items: center; gap: 0.5rem; }
        .client-row { display: grid; grid-template-columns: 40px 1fr 100px 100px; align-items: center; padding: 0.75rem; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); gap: 0.5rem; min-height: 40px; }
        .client-icon-col { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; }
        .client-icon-fallback { font-size: 1rem; }
        .tool-name { font-family: monospace; font-size: 0.85rem; color: var(--text-primary); }
        .tool-more { display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.75rem; font-size: 0.85rem; color: var(--accent-primary); font-weight: 500; }
        .tool-count { font-size: 0.75rem; color: var(--text-muted); }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent-success); }
        .config-item { display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); gap: 1rem; }
        .config-item-left { display: flex; align-items: center; gap: 10px; }
        .config-icon { width: 32px; height: 32px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }
        .config-label { font-weight: 600; font-size: 0.85rem; }
        .config-value { font-size: 0.75rem; color: var(--text-muted); font-family: 'SF Mono', 'Fira Code', monospace; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 2000; align-items: center; justify-content: center; padding: 1rem; }
        .modal-overlay.show { display: flex; }
        .modal { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); width: 100%; max-width: 480px; padding: 1.5rem; }
        .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
        .modal-title { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
        .modal-close { width: 32px; height: 32px; border-radius: var(--radius-sm); background: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-secondary); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1rem; transition: all 0.2s; }
        .modal-close:hover { color: var(--text-primary); }
        .modal-body { margin-bottom: 1rem; }
        .modal-desc { color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1rem; line-height: 1.6; }
        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 6px; color: var(--text-secondary); }
        .form-input { width: 100%; padding: 10px 14px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-sm); color: var(--text-primary); font-size: 0.9rem; font-family: 'SF Mono', 'Fira Code', monospace; }
        .form-input:focus { outline: none; border-color: var(--accent-primary); }
        .form-hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; }
        .modal-footer { display: flex; gap: 8px; justify-content: flex-end; }

        /* Tools List */
        .tools-list { display: flex; flex-direction: column; gap: 0.5rem; max-height: 400px; overflow-y: auto; }
        .tool-item { display: flex; align-items: flex-start; gap: 12px; padding: 0.75rem; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); }
        .clients-list { display: flex; flex-direction: column; gap: 10px; }
        .client-name { font-size: 14px; font-weight: 600; color: var(--text-primary); }
        .tool-name { font-weight: 600; font-size: 14px; font-family: 'JetBrains Mono', monospace; color: #a78bfa; margin-bottom: 2px; }
        .tool-desc { color: var(--text-secondary); font-size: 0.75rem; line-height: 1.4; }

        @media (max-width: 768px) {
            .container { padding: 1rem; }
            .status-grid, .mcp-meta { grid-template-columns: 1fr; }
            .analytics-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .analytics-grid { grid-template-columns: 1fr; }
        }
            .integration-grid { grid-template-columns: 1fr; }
            .integration-more { flex-direction: column; align-items: flex-start; }
            .integration-more-right { padding-left: 0; border-left: none; padding-top: 1rem; border-top: 1px solid var(--border-color); width: 100%; }
        }
    </style>

@endsection

@section('content')
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Manage your ServerAvatar MCP connection and integration</p>
            </div>

            @if(!$onboardingComplete)
            <!-- Quick Setup Guide -->
            <div class="quick-setup-section">
                <div class="quick-setup-header">
                    <div class="section-icon" style="background: rgba(139, 92, 246, 0.12);"><i class="fas fa-rocket" style="color: var(--accent-primary);"></i></div>
                    <div>
                        <div class="section-title">Quick Setup</div>
                        <div class="section-desc">Connect ServerAvatar MCP with any MCP-compatible client in just a few steps.</div>
                    </div>
                </div>
                <div class="quick-setup-steps">
                    <div style="background:#F3EEFF;border:2px solid #D8B4FE;border-radius:10px;padding:1rem;text-align:center;display:flex;flex-direction:column;align-items:center;min-width:120px;flex:1;height:140px;" data-dt-bg="#2A1F45" data-dt-border="#7E22CE" data-dt-color="#F3E8FF">
                        <div style="width:36px;height:36px;border-radius:50%;background:#7C3AED;color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;margin-bottom:0.75rem;">1</div>
                        <div style="width:100%;flex:1;display:flex;flex-direction:column;justify-content:center;">
                            <h3 style="font-size:15px;font-weight:600;margin-bottom:0.25rem;color:#7C3AED;">Add API Key</h3>
                            <p style="font-size:12px;font-weight:400;color:#7C3AED;line-height:1.4;opacity:0.8;">Connect your ServerAvatar account</p>
                        </div>
                    </div>
                    <div style="color:#7C3AED;font-size:1.5rem;flex-shrink:0;">→</div>
                    <div style="background:#F3EEFF;border:2px solid #D8B4FE;border-radius:10px;padding:1rem;text-align:center;display:flex;flex-direction:column;align-items:center;min-width:120px;flex:1;height:140px;" data-dt-bg="#2A1F45" data-dt-border="#7E22CE" data-dt-color="#F3E8FF">
                        <div style="width:36px;height:36px;border-radius:50%;background:#7C3AED;color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;margin-bottom:0.75rem;">2</div>
                        <div style="width:100%;flex:1;display:flex;flex-direction:column;justify-content:center;">
                            <h3 style="font-size:15px;font-weight:600;margin-bottom:0.25rem;color:#7C3AED;">Copy MCP URL</h3>
                            <p style="font-size:12px;font-weight:400;color:#7C3AED;line-height:1.4;opacity:0.8;">Get your MCP endpoint</p>
                        </div>
                    </div>
                    <div style="color:#7C3AED;font-size:1.5rem;flex-shrink:0;">→</div>
                    <div style="background:#F3EEFF;border:2px solid #D8B4FE;border-radius:10px;padding:1rem;text-align:center;display:flex;flex-direction:column;align-items:center;min-width:120px;flex:1;height:140px;" data-dt-bg="#2A1F45" data-dt-border="#7E22CE" data-dt-color="#F3E8FF">
                        <div style="width:36px;height:36px;border-radius:50%;background:#7C3AED;color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;margin-bottom:0.75rem;">3</div>
                        <div style="width:100%;flex:1;display:flex;flex-direction:column;justify-content:center;">
                            <h3 style="font-size:15px;font-weight:600;margin-bottom:0.25rem;color:#7C3AED;">Add to Client</h3>
                            <p style="font-size:12px;font-weight:400;color:#7C3AED;line-height:1.4;opacity:0.8;">Connect ChatGPT, Claude, Cursor & more</p>
                        </div>
                    </div>
                    <div style="color:#7C3AED;font-size:1.5rem;flex-shrink:0;">→</div>
                    <div style="background:#F3EEFF;border:2px solid #D8B4FE;border-radius:10px;padding:1rem;text-align:center;display:flex;flex-direction:column;align-items:center;min-width:120px;flex:1;height:140px;" data-dt-bg="#2A1F45" data-dt-border="#7E22CE" data-dt-color="#F3E8FF">
                        <div style="width:36px;height:36px;border-radius:50%;background:#7C3AED;color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;margin-bottom:0.75rem;">4</div>
                        <div style="width:100%;flex:1;display:flex;flex-direction:column;justify-content:center;">
                            <h3 style="font-size:15px;font-weight:600;margin-bottom:0.25rem;color:#7C3AED;">Authenticate</h3>
                            <p style="font-size:12px;font-weight:400;color:#7C3AED;line-height:1.4;opacity:0.8;">Verify your connection</p>
                        </div>
                    </div>
                    <div style="color:#7C3AED;font-size:1.5rem;flex-shrink:0;">→</div>
                    <div style="background:#F3EEFF;border:2px solid #D8B4FE;border-radius:10px;padding:1rem;text-align:center;display:flex;flex-direction:column;align-items:center;min-width:120px;flex:1;height:140px;" data-dt-bg="#2A1F45" data-dt-border="#7E22CE" data-dt-color="#F3E8FF">
                        <div style="width:36px;height:36px;border-radius:50%;background:#7C3AED;color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;margin-bottom:0.75rem;">5</div>
                        <div style="width:100%;flex:1;display:flex;flex-direction:column;justify-content:center;">
                            <h3 style="font-size:15px;font-weight:600;margin-bottom:0.25rem;color:#7C3AED;">Start Using</h3>
                            <p style="font-size:12px;font-weight:400;color:#7C3AED;line-height:1.4;opacity:0.8;">Access ServerAvatar tools</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Welcome Back Card -->
            <div class="welcome-back-card">
                <div class="wb-top">
                    <div class="wb-left">
                        <div class="wb-text">
                            <div class="wb-greeting-line"><span class="wb-greeting">👋</span> <span class="wb-greeting-text">Welcome back, {{ $user->name }}</span></div>
                            <div class="wb-subtitle" style="padding-left: 1.75rem;">
                                Your ServerAvatar MCP is online and ready.
                                @if($connectedClients->count() > 0)
                                    You currently have {{ $connectedClients->count() }} connected AI client(s).
                                @else
                                    No AI client is currently connected. Connect ChatGPT, Claude, Cursor, or another MCP-compatible client to start using your tools.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wb-actions">
                    <a href="{{ route('clients') }}" class="wb-action-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Connect Client
                    </a>
                    <a href="{{ route('tools') }}" class="wb-action-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        View Tools
                    </a>
                    <button class="wb-action-btn" onclick="copyMcpUrlFromWelcome(this)">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        Copy MCP URL
                    </button>
                    <button class="wb-action-btn" onclick="openApiKeyModal()">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                        Update API Key
                    </button>
                </div>
            </div>
            @endif

                        <!-- Analytics Cards -->
            <div class="analytics-grid">
                @php
                    $chartW = 120; $chartH = 40;
                    function buildLinePath($data, $w, $h) {
                        if (empty($data)) return '';
                        $max = max($data); $min = min($data);
                        $range = $max - $min; if ($range == 0) $range = 1;
                        $pts = [];
                        foreach ($data as $i => $v) {
                            $x = $i * ($w / (count($data) - 1 ?: 1));
                            $y = $h - (($v - $min) / $range) * $h;
                            $pts[] = "$x,$y";
                        }
                        return 'M ' . implode(' L ', $pts);
                    }
                    $reqPath = buildLinePath($sparklineRequests, $chartW, $chartH);
                    $toolPath = buildLinePath($sparklineTools, $chartW, $chartH);
                    $clientPath = buildLinePath($sparklineClients, $chartW, $chartH);
                    $successLineY = 40 - ($analytics['success_rate'] / 100 * 40);
                    $responseLineY = max(5, 40 - ($analytics['avg_response_time_ms'] / 20));
                @endphp

                <!-- Total Requests -->
                <div class="analytics-card">
                    <div class="analytics-card-label">Total Requests</div>
                    <div class="analytics-card-value-row">
                        <div class="analytics-card-value">{{ number_format($analytics['total_requests']) }}</div>
                        <span class="analytics-card-trend trend-up"><i class="fas fa-arrow-up" style="font-size:0.6rem;"></i> 7d</span>
                    </div>
                    <div class="analytics-chart">
                        <svg viewBox="0 0 {{ $chartW }} {{ $chartH }}" preserveAspectRatio="none">
                            @if($reqPath)
                                <path d="{{ $reqPath }}" fill="none" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round"/>
                            @else
                                <line x1="0" y1="{{ $chartH }}" x2="{{ $chartW }}" y2="{{ $chartH }}" stroke="rgba(139,92,246,0.3)" stroke-width="1.5" stroke-dasharray="4,2"/>
                            @endif
                        </svg>
                    </div>
                </div>

                <!-- Tools Executed -->
                <div class="analytics-card">
                    <div class="analytics-card-label">Tools Executed</div>
                    <div class="analytics-card-value-row">
                        <div class="analytics-card-value">{{ number_format($analytics['tools_executed']) }}</div>
                        <span class="analytics-card-trend trend-up"><i class="fas fa-wrench" style="font-size:0.6rem;"></i> tools</span>
                    </div>
                    <div class="analytics-chart">
                        <svg viewBox="0 0 {{ $chartW }} {{ $chartH }}" preserveAspectRatio="none">
                            @if($toolPath)
                                <path d="{{ $toolPath }}" fill="none" stroke="#3b82f6" stroke-width="1.5" stroke-linecap="round"/>
                            @else
                                <line x1="0" y1="{{ $chartH }}" x2="{{ $chartW }}" y2="{{ $chartH }}" stroke="rgba(59,130,246,0.3)" stroke-width="1.5" stroke-dasharray="4,2"/>
                            @endif
                        </svg>
                    </div>
                </div>

                <!-- Active Clients -->
                <div class="analytics-card">
                    <div class="analytics-card-label">Active Clients</div>
                    <div class="analytics-card-value-row">
                        <div class="analytics-card-value">{{ $analytics['active_clients'] }}</div>
                        <span class="analytics-card-trend trend-up"><i class="fas fa-users" style="font-size:0.6rem;"></i> online</span>
                    </div>
                    <div class="analytics-chart">
                        <svg viewBox="0 0 {{ $chartW }} {{ $chartH }}" preserveAspectRatio="none">
                            @if($clientPath)
                                <path d="{{ $clientPath }}" fill="none" stroke="#06b6d4" stroke-width="1.5" stroke-linecap="round"/>
                            @else
                                <line x1="0" y1="{{ $chartH }}" x2="{{ $chartW }}" y2="{{ $chartH }}" stroke="rgba(6,182,212,0.3)" stroke-width="1.5" stroke-dasharray="4,2"/>
                            @endif
                        </svg>
                    </div>
                </div>

                <!-- Success Rate -->
                <div class="analytics-card">
                    <div class="analytics-card-label">Success Rate</div>
                    <div class="analytics-card-value-row">
                        <div class="analytics-card-value">{{ $analytics['success_rate'] }}%</div>
                        <span class="analytics-card-trend {{ $analytics['success_rate'] >= 99 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-{{ $analytics['success_rate'] >= 99 ? 'check' : 'exclamation' }}" style="font-size:0.6rem;"></i>
                        </span>
                    </div>
                    <div class="analytics-chart">
                        <svg viewBox="0 0 {{ $chartW }} {{ $chartH }}" preserveAspectRatio="none">
                            <line x1="0" y1="{{ $successLineY }}" x2="{{ $chartW }}" y2="{{ $successLineY }}" stroke="#16a34a" stroke-width="1.5" stroke-dasharray="4,2"/>
                            <circle cx="{{ $chartW }}" cy="{{ $successLineY }}" r="2.5" fill="#16a34a"/>
                        </svg>
                    </div>
                </div>

                <!-- Avg. Response Time -->
                <div class="analytics-card">
                    <div class="analytics-card-label">Avg. Response Time</div>
                    <div class="analytics-card-value-row">
                        <div class="analytics-card-value" style="font-size:1.5rem;">{{ $analytics['avg_response_time_ms'] }} <span style="font-size:0.8rem;font-weight:500;color:var(--text-secondary);">ms</span></div>
                        <span class="analytics-card-trend {{ $analytics['avg_response_time_ms'] < 500 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-bolt" style="font-size:0.6rem;"></i>
                        </span>
                    </div>
                    <div class="analytics-chart">
                        <svg viewBox="0 0 {{ $chartW }} {{ $chartH }}" preserveAspectRatio="none">
                            <line x1="0" y1="{{ $responseLineY }}" x2="{{ $chartW }}" y2="{{ $responseLineY }}" stroke="#f97316" stroke-width="1.5" stroke-dasharray="4,2"/>
                            <circle cx="{{ $chartW }}" cy="{{ $responseLineY }}" r="2.5" fill="#f97316"/>
                        </svg>
                    </div>
                </div>
            </div>


<!-- System Status Overview -->
            <div class="mcp-status-card">
                
                <div class="status-main-row">
                    <div class="status-left">
                        <div class="status-badge">✓</div>
                        <div class="status-info">
                            <div class="status-above">MCP Server Status</div>
                            <div class="status-title">All systems operational</div>
                            <div class="status-subtitle">Your MCP server is running smoothly and ready to accept connections</div>
                        </div>
                    </div>
                    <div class="status-metrics">
                        <div class="metric-stack">
                            <div class="metric-online">Online</div>
                            <div class="metric-inline centered">
                                <span class="green-bullet"></span>
                                <span class="inline-label">Server Status</span>
                            </div>
                        </div>
                        <div class="metric-divider"></div>
                        <div class="metric-item centered">
                            <div class="metric-value">{{ $toolsCount }}</div>
                            <div class="metric-label">Tools Enabled</div>
                        </div>
                        <div class="metric-divider"></div>
                        <div class="metric-item centered">
                            <div class="metric-value">{{ $connectedClients->count() }}</div>
                            <div class="metric-label">Active Clients</div>
                        </div>
                        <div class="metric-divider"></div>
                        <div class="metric-item">
                            @if($user->hasApiKey())
                            <div class="metric-value text-green">Configured</div>
                            @else
                            <div class="metric-value" style="color: #94a3b8;">Not Set</div>
                            @endif
                            <div class="metric-label">API Key</div>
                        </div>
                    </div>
                    <div class="status-graphic">
                        <img src="{{ asset('images/server-illustration.png') }}" alt="Server Status" class="server-illustration-img" loading="lazy">
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
<div class="activity-section">
    <div class="section-header-row" style="justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="section-title">Recent Activity</div>
            @if($recentActivities->count() > 0)
            <span class="activity-count-badge">{{ $recentActivities->count() }} events</span>
            @endif
        </div>
        <a href="{{ route("activity") }}" class="btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;">View All</a>
    </div>
    <div class="activity-card">
        @if($recentActivities->count() > 0)
        <div class="activity-list">
            @foreach($recentActivities as $activity)
            <div class="activity-item">
                <div class="activity-icon">{{ $activity->icon }}</div>
                <div class="activity-content">
                    <div class="activity-description">{{ $activity->description }}</div>
                    <div class="activity-meta">
                        @if($activity->client_name)
                        <span class="activity-client">{{ $activity->client_name }}</span>
                        <span class="activity-sep">·</span>
                        @endif
                        <span class="activity-time">{{ $activity->time_ago }}</span>
                    </div>
                </div>
                <span class="activity-badge badge-{{ $activity->badge }}">{{ $activity->badge }}</span>
            </div>
            @endforeach
        </div>
        @else
        <div class="activity-empty">
            <i class="fas fa-clock" style="font-size: 2rem; color: var(--text-secondary); margin-bottom: 0.5rem;"></i>
            <p>No activity yet. Connect an AI client to get started.</p>
        </div>
        @endif
    </div>
</div>


            <!-- Account Info Cards -->
            <div class="info-cards-row">
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon person-icon"><i class="fas fa-user" style="color: var(--accent-primary);"></i></div>
                        <div class="info-card-label">Account</div>
                    </div>
                    <div class="info-card-body">
                        <div class="info-card-name">{{ $user->name }}</div>
                        <div class="info-card-email">{{ $user->email }}</div>
                    </div>
                    <a href="/account" class="btn-card-action">Manage Account</a>
                </div>
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon shield-icon"><i class="fas fa-shield-halved" style="color: var(--accent-primary);"></i></div>
                        <div class="info-card-label">Authentication</div>
                    </div>
                    <div class="info-card-body">
                        <div class="info-card-status-main text-green">Logged In</div>
                        <div class="info-card-status-sub">Session Active</div>
                        <div class="info-card-time">Last login: {{ $lastLogin }}</div>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon key-icon"><i class="fas fa-key" style="color: var(--accent-primary);"></i></div>
                        <div class="info-card-label">ServerAvatar API Access</div>
                    </div>
                    <div class="info-card-body">
                        <div class="info-card-status-main text-green">{{ $user->hasApiKey() ? 'Configured' : 'Not Set' }}</div>
                        <div class="info-card-status-sub">{{ $user->hasApiKey() ? 'Full Access' : 'No Access' }}</div>
                    </div>
                    <button class="btn-card-action secondary" onclick="openApiKeyModal()">{{ $user->hasApiKey() ? 'Update' : 'Add' }} API Key</button>
                </div>
            </div>

            <!-- API Key Update Modal -->
            <div id="apiKeyModal" class="modal-overlay">
                <div class="modal-content api-modal">
                    <div class="modal-header">
                        <div class="modal-title-row">
                            <span class="modal-icon"><i class="fas fa-key" style="color: var(--accent-primary);"></i></span>
                            <h3>Update API Key</h3>
                        </div>
                        <button class="modal-close" onclick="closeApiKeyModal()">&times;</button>
                    </div>
                    <form id="apiKeyForm" onsubmit="saveApiKey(event)">
                        <div class="modal-body">
                            <p class="modal-intro">Enter your new ServerAvatar API key below.</p>
                            <label class="modal-label">New API Key <span class="required-star">*</span></label>
                            <div class="input-password-wrap">
                                <input type="password" id="apiKeyInput" name="api_key" placeholder="Enter your API key" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                                    <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                        <line x1="1" y1="1" x2="23" y2="23"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="security-tips">
                                <div class="tips-title">Security Best Practices</div>
                                <ul class="tips-list">
                                    <li>Never share your API key with anyone</li>
                                    <li>Store it securely in environment variables</li>
                                    <li>Rotate your key periodically</li>
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-modal-cancel" onclick="closeApiKeyModal()">Cancel</button>
                            <button type="submit" class="btn-modal-save">Save API Key</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Toast Notification -->
            <div id="toast" class="toast">
                <span class="toast-icon">✓</span>
                <span class="toast-message">API Key updated successfully!</span>
            </div>

            <div class="card">
                <div class="section-header">
                    <div class="section-icon" style="background: rgba(139, 92, 246, 0.12);"><i class="fas fa-globe" style="color: var(--accent-primary);"></i></div>
                    <div>
                        <div class="section-title">MCP Server URL</div>
                        <div class="section-desc">Use this URL to connect ServerAvatar MCP to any MCP-compatible clients</div>
                    </div>
                </div>
                <div class="mcp-url-row">
                    <div class="mcp-url-box">
                        <div class="mcp-url-display">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                            </svg>
                            <span class="mcp-url-text">https://mcp.178.105.137.4.nip.io/mcp/serveravatar</span>
                        </div>
                    </div>
                    <button class="copy-url-btn" onclick="copyMcpUrl(this)">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                        Copy URL
                    </button>
                </div>
                <div class="mcp-status-bar">
                    <div class="mcp-status-item">
                        <span class="mcp-status-dot online"></span>
                        <span class="mcp-status-text">Server Online</span>
                    </div>
                    <div class="mcp-status-divider"></div>
                    <div class="mcp-status-item">
                        <span class="mcp-status-icon"><i class="fas fa-wrench" style="color: var(--accent-primary);"></i></span>
                        <span class="mcp-status-text">{{ $toolsCount }} Tools Available</span>
                    </div>
                    <div class="mcp-status-divider"></div>
                    <div class="mcp-status-item">
                        <span class="mcp-status-icon"><i class="fas fa-users" style="color: var(--accent-primary);"></i></span>
                        <span class="mcp-status-text">Compatible with MCP Clients</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card">
                <div class="section-header">
                    <div class="section-icon" style="background: rgba(139, 92, 246, 0.12);"><i class="fas fa-bolt" style="color: var(--accent-primary);"></i></div>
                    <div>
                        <div class="section-title">Quick Actions</div>
                        <div class="section-desc">Manage your MCP server and integrations</div>
                    </div>
                </div>
                <div class="quick-actions-grid">
                    <a href="{{ route('tools') }}" class="quick-action-btn">
                        <div class="qa-icon qa-tools">
                            <i class="fas fa-wrench" style="color: var(--accent-primary);"></i>
                        </div>
                        <span class="qa-label">View Tools</span>
                    </a>
                    <button class="quick-action-btn" onclick="openApiKeyModal()">
                        <div class="qa-icon qa-key">
                            <i class="fas fa-key" style="color: var(--accent-primary);"></i>
                        </div>
                        <span class="qa-label">{{ $user->hasApiKey() ? 'Update API Key' : 'Add API Key' }}</span>
                    </button>
                    <a href="{{ route('clients') }}" class="quick-action-btn" style="text-decoration: none;">
                        <div class="qa-icon qa-clients">
                            <i class="fas fa-users" style="color: var(--accent-primary);"></i>
                        </div>
                        <span class="qa-label">Active AI Clients</span>
                    </a>
                </div>
            </div>

    </main>

    <!-- API Key Modal -->
    @include('components.api-key-modal', ['apiKey' => $user->api_key, 'hasApiKey' => $user->hasApiKey()])

    <!-- Tools Modal -->

    <!-- Toast -->
    <div class="toast" id="toast"></div>


@endsection

@section('scripts')
    <script>
        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const theme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            updateStepCards();
        }
        
        function updateStepCards() {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            document.querySelectorAll('[data-dt-bg]').forEach(function(card) {
                if (isDark) {
                    card.style.background = card.getAttribute('data-dt-bg');
                    card.style.borderColor = card.getAttribute('data-dt-border');
                    card.style.color = card.getAttribute('data-dt-color');
                    card.querySelectorAll('h3, p').forEach(function(el) {
                        el.style.color = card.getAttribute('data-dt-color');
                    });
                } else {
                    card.style.background = '#F3EEFF';
                    card.style.borderColor = '#D8B4FE';
                    card.style.color = '#7C3AED';
                    card.querySelectorAll('h3, p').forEach(function(el) {
                        el.style.color = '#7C3AED';
                    });
                }
            });
        }
        
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved) {
                document.documentElement.setAttribute('data-theme', saved);
            }
            updateStepCards();
        })();

        // Profile Menu
        function toggleProfileMenu() {
            document.getElementById('profileMenu').classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown')) {
                document.getElementById('profileMenu').classList.remove('show');
            }
        });

        // Copy Functions
        function copyMcpUrl(btn) {
            const url = 'https://mcp.178.105.137.4.nip.io/mcp/serveravatar';
            navigator.clipboard.writeText(url).then(function() {
                btn.classList.add('copied');
                btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg> Copied';
                setTimeout(function() {
                    btn.classList.remove('copied');
                    btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copy URL';
                }, 2000);
            });
        }

        function copyMcpUrlFromWelcome(btn) {
            const url = 'https://mcp.178.105.137.4.nip.io/mcp/serveravatar';
            navigator.clipboard.writeText(url).then(function() {
                const original = btn.innerHTML;
                btn.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg> Copied!';
                setTimeout(function() {
                    btn.innerHTML = original;
                }, 2000);
            });
        }

        // Preload server illustration
        var serverImg = new Image();
        serverImg.src = '{{ asset('images/server-illustration.png') }}';
        serverImg.onload = function() {
            document.querySelector('.server-illustration-img').style.opacity = '1';
        };

        // Close modal on overlay click
        
    </script>

@endsection