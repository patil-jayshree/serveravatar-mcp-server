@extends('layouts.app')

@section('title', 'Dashboard - ServerAvatar MCP')
@section('breadcrumb', 'Dashboard')

@section('extra_css')
<style>
/* =============================================
   DASHBOARD-UNIQUE STYLES
   (Shared layout provides base styles)
   ============================================= */

/* Quick Setup Step Cards (dark/light dynamic) */
[data-theme="dark"] .quick-setup-step-card { background: #2A1F45; border-color: #7E22CE; }
[data-theme="dark"] .quick-setup-step-card h3,
[data-theme="dark"] .quick-setup-step-card p { color: #F3E8FF; }
[data-theme="light"] .quick-setup-step-card { background: #F3EEFF; border-color: #D8B4FE; }
[data-theme="light"] .quick-setup-step-card h3,
[data-theme="light"] .quick-setup-step-card p { color: #7C3AED; }

/* MCP Status Card — extra overrides beyond layout card */
.mcp-status-card {
    background: linear-gradient(135deg, #1a1033 0%, #2d1f5c 100%);
    border: 1px solid #3d2d6b;
    border-radius: var(--radius-lg);
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}
.mcp-status-card::before {
    content: '';
    position: absolute;
    top: -30%;
    right: 8%;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.12) 0%, transparent 70%);
    pointer-events: none;
}
[data-theme="light"] .mcp-status-card {
    background: #ffffff;
    border: 1px solid #e0e7ff;
    box-shadow: 0 4px 20px rgba(99, 102, 241, 0.1);
}
[data-theme="light"] .mcp-status-card::before { display: none; }

.status-main-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: wrap;
}
.status-left { display: flex; align-items: center; gap: 1rem; }
.status-badge {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #16a34a 0%, #16a34a 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    font-weight: 700;
    box-shadow: 0 0 25px rgba(34, 197, 94, 0.5);
    flex-shrink: 0;
}
.status-info { display: flex; flex-direction: column; gap: 0.15rem; }
.status-above { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; }
[data-theme="dark"] .status-above { color: #64748b; }
[data-theme="light"] .status-above { color: #6b7280; }
.status-title { font-size: 20px; font-weight: 700; }
[data-theme="dark"] .status-title { color: #16a34a; }
[data-theme="light"] .status-title { color: #15803d; }
.status-subtitle { font-size: 12px; }
[data-theme="dark"] .status-subtitle { color: #94a3b8; }
[data-theme="light"] .status-subtitle { color: #374151; }

.status-metrics { display: flex; align-items: center; gap: 1.5rem; flex: 1; justify-content: center; flex-wrap: wrap; }
.metric-stack { display: flex; flex-direction: column; gap: 0.15rem; align-items: center; }
.metric-online { font-size: 18px; font-weight: 700; }
[data-theme="dark"] .metric-online { color: #16a34a; }
[data-theme="light"] .metric-online { color: #16a34a; }
.metric-inline { display: flex; align-items: center; gap: 0.4rem; white-space: nowrap; }
[data-theme="dark"] .inline-label { color: #94a3b8; }
[data-theme="light"] .inline-label { color: #374151; }
.metric-divider { width: 1px; height: 35px; }
[data-theme="dark"] .metric-divider { background: rgba(255,255,255,0.12); }
[data-theme="light"] .metric-divider { background: rgba(107,114,128,0.2); }
.metric-item { display: flex; flex-direction: column; align-items: center; gap: 0.2rem; }
.metric-item.centered { text-align: center; }
.metric-value { font-size: 20px; font-weight: 700; }
[data-theme="dark"] .metric-value { color: #f8fafc; }
[data-theme="light"] .metric-value { color: #111827; }
.metric-value.text-green { color: #16a34a; }
[data-theme="light"] .text-green { color: #15803d; }
.metric-label { font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }
[data-theme="dark"] .metric-label { color: #94a3b8; }
[data-theme="light"] .metric-label { color: #6b7280; }
.green-bullet {
    width: 7px; height: 7px; border-radius: 50%;
    background: #16a34a;
    box-shadow: 0 0 6px rgba(34, 197, 94, 0.8);
    flex-shrink: 0;
}
.green-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #16a34a;
    box-shadow: 0 0 6px rgba(34, 197, 94, 0.8);
    flex-shrink: 0;
}
.status-graphic { display: flex; align-items: flex-end; justify-content: flex-end; }
.server-illustration-img { width: 220px; height: auto; opacity: 0; transition: opacity 0.3s ease; }
[data-theme="light"] .server-illustration-img { filter: none; }

/* Info Cards Row */
.info-cards-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
.info-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    transition: all var(--transition-normal);
}
.info-card:hover { border-color: var(--border-color-hover); box-shadow: var(--shadow-md); }
.info-card-header { display: flex; align-items: center; gap: 0.75rem; }
.info-card-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
.info-card-icon.person-icon,
.info-card-icon.shield-icon,
.info-card-icon.key-icon { background: rgba(139, 92, 246, 0.12); }
[data-theme="light"] .info-card-icon.person-icon,
[data-theme="light"] .info-card-icon.shield-icon { background: rgba(124, 92, 252, 0.15); }
.info-card-icon i { color: var(--accent-primary); }
.info-card-label { font-size: 14px; font-weight: 600; color: var(--text-primary); }
.info-card-body { display: flex; flex-direction: column; gap: 0.2rem; }
.info-card-name { font-size: 18px; font-weight: 700; color: var(--text-primary); }
.info-card-email { font-size: 13px; font-weight: 400; color: var(--text-secondary); }
.info-card-status-main { font-size: 18px; font-weight: 700; }
.info-card-status-sub { font-size: 13px; font-weight: 400; color: var(--text-secondary); }
.info-card-time { font-size: 0.75rem; color: var(--text-muted); }
.btn-card-action {
    display: block;
    width: 100%;
    padding: 10px 16px;
    background: var(--accent-primary);
    color: white;
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all var(--transition-fast);
    margin-top: auto;
    border: none;
    cursor: pointer;
}
.btn-card-action:hover { background: var(--accent-primary-hover); transform: translateY(-1px); }
.btn-card-action.secondary {
    background: rgba(250, 204, 21, 0.15);
    color: #ca8a04;
    border: 1px solid rgba(250, 204, 21, 0.3);
}
.btn-card-action.secondary:hover { background: rgba(250, 204, 21, 0.25); }
[data-theme="light"] .btn-card-action.secondary {
    background: rgba(161, 98, 7, 0.1);
    color: #a16207;
    border-color: rgba(161, 98, 7, 0.2);
}

/* MCP URL Row */
.mcp-url-row { display: flex; align-items: center; gap: 12px; margin-top: 1rem; }
.mcp-url-box { flex: 1; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 10px 16px; display: flex; align-items: center; overflow: hidden; }
.mcp-url-display { display: flex; align-items: center; gap: 12px; flex: 1; overflow: hidden; }
.mcp-url-display svg { color: var(--accent-info); flex-shrink: 0; }
.mcp-url-text { font-family: 'JetBrains Mono', 'Menlo', 'Consolas', monospace; font-size: 14px; font-weight: 500; color: #cbd5e1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
[data-theme="light"] .mcp-url-text { color: #374151; }
.copy-url-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: var(--accent-info);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-fast);
    white-space: nowrap;
    flex-shrink: 0;
}
.copy-url-btn:hover { background: #2563eb; transform: translateY(-1px); }
.copy-url-btn.copied { background: var(--accent-success); }

/* MCP Status Bar */
.mcp-status-bar {
    display: flex;
    align-items: center;
    background: rgba(124, 92, 252, 0.08);
    border: 1px solid rgba(124, 92, 252, 0.15);
    border-radius: var(--radius-md);
    margin-top: 1rem;
    overflow: hidden;
}
.mcp-status-item { display: flex; align-items: center; gap: 8px; padding: 12px 16px; flex: 1; justify-content: center; }
.mcp-status-item:first-child { padding-left: 20px; }
.mcp-status-item:last-child { padding-right: 20px; }
.mcp-status-divider { width: 1px; height: 24px; background: rgba(124, 92, 252, 0.2); flex-shrink: 0; }
.mcp-status-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.mcp-status-dot.online { background: #16a34a; box-shadow: 0 0 8px rgba(34, 197, 94, 0.5); }
.mcp-status-icon { font-size: 1rem; }
.mcp-status-text { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }

/* Quick Actions Grid */
.quick-actions-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; }
.quick-action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    text-decoration: none;
    cursor: pointer;
    transition: all var(--transition-fast);
}
.quick-action-btn:hover { border-color: var(--accent-primary); background: var(--bg-card-hover); transform: translateY(-1px); }
.qa-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.qa-tools, .qa-key, .qa-clients { background: rgba(139, 92, 246, 0.12); color: var(--accent-primary); }
.qa-icon i { color: var(--accent-primary); }
.qa-label { font-size: 14px; font-weight: 600; color: var(--text-primary); white-space: nowrap; }

/* Two Column Grid */
.two-col-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem; }

/* Tools List */
.tools-list { display: flex; flex-direction: column; gap: 0.5rem; max-height: 400px; overflow-y: auto; }
.tool-item { display: flex; align-items: flex-start; gap: 12px; padding: 0.75rem; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); }
.tool-item-left { display: flex; align-items: center; gap: 0.5rem; flex: 1; }
.tool-name { font-weight: 600; font-size: 14px; font-family: 'JetBrains Mono', monospace; color: #a78bfa; margin-bottom: 2px; }
.tool-desc { color: var(--text-secondary); font-size: 0.75rem; line-height: 1.4; }
.tool-more { display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.75rem; font-size: 0.85rem; color: var(--accent-primary); font-weight: 500; }

/* Clients List */
.clients-list-new { display: flex; flex-direction: column; gap: 10px; }
.client-row {
    display: grid;
    grid-template-columns: 48px 1fr auto auto;
    align-items: center;
    padding: 0.75rem;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    gap: 0.5rem;
}
.client-row:hover { background: var(--bg-card-hover); }
.client-col { display: flex; align-items: center; }
.client-col-icon { width: 48px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.client-col-name { flex: 1; }
.client-col-status { min-width: 80px; justify-content: center; }
.client-col-time { min-width: 100px; justify-content: flex-end; }
.client-name { font-weight: 600; font-size: 14px; color: var(--text-primary); }
[data-theme="dark"] .client-name { color: #f8fafc; }
[data-theme="light"] .client-name { color: #0f172a; }
.client-icon-fallback { font-size: 1rem; }
.client-time { font-size: 13px; color: var(--text-muted); }
.badge-active {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(34, 197, 94, 0.15);
    color: #16a34a;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.clients-footer { margin-top: 0.75rem; font-size: 13px; color: var(--text-muted); text-align: center; }
.clients-empty { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem 1rem; }
.clients-empty-icon { margin-bottom: 1rem; display: flex; justify-content: center; }
.clients-empty-title { font-size: 16px; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary); }
.clients-empty-desc { font-size: 14px; color: var(--text-secondary); line-height: 1.6; max-width: 280px; }

/* Integration Grid */
.integration-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-top: 1rem; }
.integration-card.simple {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 1rem;
    transition: all var(--transition-fast);
}
.integration-card.simple:hover { border-color: var(--border-color-hover); transform: translateY(-2px); }
.badge-top-right { position: absolute; top: 8px; right: 8px; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; }
.badge-popular { background: rgba(124, 92, 252, 0.2); color: #7c5cfb; border-radius: 999px; }
.badge-success { background: rgba(16, 163, 127, 0.15); color: var(--accent-success); border-radius: 999px; }
.integration-logo { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.integration-logo .icon-light,
.integration-logo .icon-dark { width: 28px; height: 28px; object-fit: contain; }
.client-col-icon .icon-light,
.client-col-icon .icon-dark { width: 28px; height: 28px; object-fit: contain; flex-shrink: 0; }
.integration-text { display: flex; flex-direction: column; gap: 0.15rem; flex: 1; min-width: 0; }
.integration-name { font-weight: 600; font-size: 15px; color: var(--text-primary); }
.integration-desc { font-weight: 400; color: var(--text-secondary); font-size: 13px; }
.integration-card.more-card { border-style: dashed; border-color: var(--border-color-hover); background: transparent; }
.integration-card.more-card:hover { background: var(--bg-card); }
.integration-card.more-card .integration-logo { background: rgba(124, 92, 252, 0.08); }

/* Quick Setup Steps */
.quick-setup-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.quick-setup-step-wrap {
    background: #F3EEFF;
    border: 2px solid #D8B4FE;
    border-radius: 10px;
    padding: 1rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 120px;
    flex: 1;
    height: 140px;
    justify-content: center;
}
[data-theme="dark"] .quick-setup-step-wrap {
    background: #2A1F45;
    border-color: #7E22CE;
}
.step-number {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #7C3AED;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 0.75rem;
}
.step-content { width: 100%; flex: 1; display: flex; flex-direction: column; justify-content: center; }
.step-title { font-size: 15px; font-weight: 600; margin-bottom: 0.25rem; color: #7C3AED; }
.step-desc { font-size: 12px; font-weight: 400; color: #7C3AED; line-height: 1.4; opacity: 0.8; }
.step-arrow { color: #7C3AED; font-size: 1.5rem; flex-shrink: 0; }
[data-theme="dark"] .step-arrow { color: #a78bfa; }

/* Section Header Row (tools/clients cards) */
.section-header-row { position: relative; }
.section-header-left { display: flex; align-items: center; gap: 0.75rem; }
.section-header-left .section-icon { flex-shrink: 0; }
.section-header-left .section-title { white-space: nowrap; }
.view-all-link { position: absolute; right: 0; top: 50%; transform: translateY(-50%); font-size: 13px; font-weight: 500; color: #7c3aed; text-decoration: none; }
.view-all-link:hover { opacity: 0.8; }

/* Footer override */
.page-footer { display: none; }

/* Responsive overrides */
@media (max-width: 768px) {
    .info-cards-row { grid-template-columns: 1fr; }
    .two-col-grid { grid-template-columns: 1fr; }
    .quick-setup-steps { flex-direction: column; }
    .quick-setup-step-wrap { height: auto; min-width: 100%; }
    .step-arrow { display: none; }
    .status-main-row { flex-direction: column; align-items: flex-start; }
    .status-metrics { justify-content: flex-start; }
    .status-graphic { display: none; }
    .quick-actions-grid { grid-template-columns: 1fr; }
    .mcp-url-row { flex-direction: column; align-items: stretch; }
    .copy-url-btn { justify-content: center; }
}
@media (max-width: 1024px) {
    .info-cards-row { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Dashboard 👋</h1>
    <p class="page-subtitle">Manage your ServerAvatar MCP connection and integration</p>
</div>

<!-- Quick Setup Guide -->
<div class="quick-setup-section card">
    <div class="section-header" style="margin-bottom: 1.5rem;">
        <div class="section-icon" style="background: rgba(139, 92, 246, 0.12);">
            <i class="fas fa-rocket" style="color: var(--accent-primary);"></i>
        </div>
        <div>
            <div class="section-title">Quick Setup</div>
            <div class="section-desc">Connect ServerAvatar MCP with any MCP-compatible client in just a few steps.</div>
        </div>
    </div>
    <div class="quick-setup-steps">
        <div class="quick-setup-step-wrap">
            <div class="step-number">1</div>
            <div class="step-content">
                <h3 class="step-title">Add API Key</h3>
                <p class="step-desc">Connect your ServerAvatar account</p>
            </div>
        </div>
        <div class="step-arrow">→</div>
        <div class="quick-setup-step-wrap">
            <div class="step-number">2</div>
            <div class="step-content">
                <h3 class="step-title">Copy MCP URL</h3>
                <p class="step-desc">Get your MCP endpoint</p>
            </div>
        </div>
        <div class="step-arrow">→</div>
        <div class="quick-setup-step-wrap">
            <div class="step-number">3</div>
            <div class="step-content">
                <h3 class="step-title">Add to Client</h3>
                <p class="step-desc">Connect ChatGPT, Claude, Cursor & more</p>
            </div>
        </div>
        <div class="step-arrow">→</div>
        <div class="quick-setup-step-wrap">
            <div class="step-number">4</div>
            <div class="step-content">
                <h3 class="step-title">Authenticate</h3>
                <p class="step-desc">Verify your connection</p>
            </div>
        </div>
        <div class="step-arrow">→</div>
        <div class="quick-setup-step-wrap">
            <div class="step-number">5</div>
            <div class="step-content">
                <h3 class="step-title">Start Using</h3>
                <p class="step-desc">Access ServerAvatar tools</p>
            </div>
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
        <a href="{{ route('account') }}" class="btn-card-action">Manage Account</a>
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

<!-- MCP Server URL Card -->
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

<!-- Integrate Anywhere Card -->
<div class="card">
    <div class="section-header">
        <div class="section-icon" style="background: rgba(139, 92, 246, 0.12);"><i class="fas fa-plug" style="color: var(--accent-primary);"></i></div>
        <div>
            <div class="section-title">Integrate Anywhere</div>
            <div class="section-desc">Connect ServerAvatar MCP to any MCP-compatible AI client. A few popular ones are shown below.</div>
        </div>
    </div>
    <div class="integration-grid">
        <!-- ChatGPT -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'ChatGPT')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @else
                <span class="badge badge-popular badge-top-right"><i class="fas fa-magic-wand-sparkles" style="color: #fbbf24;"></i> Popular</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/chatgpt-light.png" class="icon-light" width="28" height="28" style="object-fit: contain;" />
                <img src="/images/clients/chatgpt-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='<i style=&quot;color:#7c3aed;font-size:20px;&quot; class=&quot;fas fa-robot&quot;></i>'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">ChatGPT</span>
                <span class="integration-desc">Connect via MCP in ChatGPT Settings</span>
            </div>
        </div>
        <!-- Claude -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Claude')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @else
                <span class="badge badge-popular badge-top-right"><i class="fas fa-magic-wand-sparkles" style="color: #fbbf24;"></i> Popular</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/claude.png" width="28" height="28" style="object-fit: contain; border-radius: 4px;" onerror="this.style.display='none';this.parentElement.innerHTML='🟣';" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Claude</span>
                <span class="integration-desc">Add to ~/.claude/mcp_servers.json</span>
            </div>
        </div>
        <!-- Cursor -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Cursor')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @else
                <span class="badge badge-popular badge-top-right"><i class="fas fa-magic-wand-sparkles" style="color: #fbbf24;"></i> Popular</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/cursor-light.png" class="icon-light" width="28" height="28" style="object-fit: contain;" />
                <img src="/images/clients/cursor-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='💚';" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Cursor</span>
                <span class="integration-desc">Add in Cursor Settings → MCP Servers</span>
            </div>
        </div>
        <!-- VS Code -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'VS Code')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/vscode.png" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='💙';" />
            </div>
            <div class="integration-text">
                <span class="integration-name">VS Code</span>
                <span class="integration-desc">Use MCP extension for VS Code</span>
            </div>
        </div>
        <!-- Windsurf -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Windsurf')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/windsurf-light.png" class="icon-light" width="28" height="28" style="object-fit: contain;" />
                <img src="/images/clients/windsurf-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🌊';" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Windsurf</span>
                <span class="integration-desc">Add in Windsurf Settings → MCP Servers</span>
            </div>
        </div>
        <!-- Zed -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Zed')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/zed.png" width="28" height="28" style="object-fit: contain; border-radius: 4px;" onerror="this.style.display='none';this.parentElement.innerHTML='<i style=&quot;color:#7c3aed;font-size:20px;&quot; class=&quot;fas fa-bolt&quot;></i>'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Zed</span>
                <span class="integration-desc">Add to Zed Settings → Extensions → MCP</span>
            </div>
        </div>
        <!-- Continue -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Continue')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/continue.png" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🔗';" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Continue</span>
                <span class="integration-desc">Add to ~/.continue/config.json</span>
            </div>
        </div>
        <!-- Cline -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Cline')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/cline-light.png" class="icon-light" width="28" height="28" style="object-fit: contain; border-radius: 4px;" />
                <img src="/images/clients/cline-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain; border-radius: 4px;" onerror="this.style.display='none';this.parentElement.innerHTML='<i style=&quot;color:#7c3aed;font-size:20px;&quot; class=&quot;fas fa-bolt&quot;></i>'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Cline</span>
                <span class="integration-desc">Configure in Cline Settings → MCP</span>
            </div>
        </div>
        <!-- Gemini -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Gemini')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/gemini.png" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🌟';" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Gemini</span>
                <span class="integration-desc">Use with Google AI Studio or Gemini API</span>
            </div>
        </div>
        <!-- LM Studio -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'LM Studio')->count() > 0)
                <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/lmstudio.webp" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='<i style=&quot;color:#7c3aed;font-size:20px;&quot; class=&quot;fas fa-laptop&quot;></i>'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">LM Studio</span>
                <span class="integration-desc">Connect via LM Studio → Developer → MCP</span>
            </div>
        </div>
        <!-- More Clients -->
        <div class="integration-card simple more-card">
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.08);">
                <span style="font-size: 1.5rem; color: #7c5cfb;">+</span>
            </div>
            <div class="integration-text">
                <span class="integration-name">More Clients</span>
                <span class="integration-desc">Works with many other MCP-compatible clients</span>
            </div>
        </div>
    </div>
</div>

<!-- Two Column Sections: Available Tools + Connected Clients -->
<div class="two-col-grid">
    <!-- Available Tools -->
    <div class="card" style="position: relative;">
        <div class="section-header-row">
            <div class="section-header-left">
                <div class="section-icon" style="background: rgba(139, 92, 246, 0.12);"><i class="fas fa-wrench" style="color: var(--accent-primary);"></i></div>
                <div>
                    <div class="section-title">Available Tools</div>
                    <div class="section-desc">MCP tools available for your AI clients</div>
                </div>
            </div>
            <a href="{{ route('tools') }}" class="view-all-link">View All <span style="color: #a99af7;">→</span></a>
        </div>
        <div class="tools-list">
            <div class="tool-item">
                <div class="tool-item-left">
                    <span class="status-dot"></span>
                    <span class="tool-name">List Organizations</span>
                </div>
                <span class="badge-active">Enabled</span>
            </div>
            <div class="tool-item">
                <div class="tool-item-left">
                    <span class="status-dot"></span>
                    <span class="tool-name">List Servers</span>
                </div>
                <span class="badge-active">Enabled</span>
            </div>
            <div class="tool-item">
                <div class="tool-item-left">
                    <span class="status-dot"></span>
                    <span class="tool-name">List Databases</span>
                </div>
                <span class="badge-active">Enabled</span>
            </div>
            <div class="tool-more">+ {{ $toolsCount - 3 }} more tools</div>
        </div>
    </div>

    <!-- Connected Clients -->
    <div class="card" style="position: relative;">
        <div class="section-header-row">
            <div class="section-header-left">
                <div class="section-icon" style="background: rgba(139, 92, 246, 0.12);"><i class="fas fa-users" style="color: var(--accent-primary);"></i></div>
                <div>
                    <div class="section-title">Connected Clients</div>
                    <div class="section-desc">AI clients currently connected</div>
                </div>
            </div>
            <a href="{{ route('clients') }}" class="view-all-link">View All <span style="color: #a99af7;">→</span></a>
        </div>
        @if($connectedClients->count() > 0)
            <div class="clients-list-new">
                @foreach($connectedClients as $client)
                    <div class="client-row">
                        <div class="client-col client-col-icon">
                            @if($client->client_name == "Claude" || $client->client_name == "Claude Desktop")
                                <img src="/images/clients/claude.png" width="28" height="28" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                                <span class="client-icon-fallback" style="display: none;">🟣</span>
                            @elseif($client->client_name == "Cursor")
                                <img src="/images/clients/cursor-light.png" class="icon-light" width="28" height="28" style="border-radius: 6px; object-fit: contain; display: none;" />
                                <img src="/images/clients/cursor-dark.png" class="icon-dark" width="28" height="28" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                                <span class="client-icon-fallback" style="display: none;">💚</span>
                            @elseif($client->client_name == "VS Code" || $client->client_name == "VSCode")
                                <img src="/images/clients/vscode.png" width="28" height="28" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                                <span class="client-icon-fallback" style="display: none;"><i class="fas fa-laptop"></i></span>
                            @else
                                <img src="/images/clients/chatgpt-light.png" class="icon-light" width="28" height="28" style="border-radius: 6px; object-fit: contain;" />
                                <img src="/images/clients/chatgpt-dark.png" class="icon-dark" width="28" height="28" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                                <span class="client-icon-fallback" style="display: none;">🤖</span>
                            @endif
                        </div>
                        <div class="client-col client-col-name">
                            <span class="client-name">{{ $client->client_name }}</span>
                        </div>
                        <div class="client-col client-col-status">
                            <span class="badge-active" style="display: flex; justify-content: center;">Active</span>
                        </div>
                        <div class="client-col client-col-time">
                            <span class="client-time">{{ $client->last_activity_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="clients-footer">+ More MCP-compatible clients</div>
        @else
            <div class="clients-empty">
                <div class="clients-empty-icon">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                        <circle cx="40" cy="40" r="36" fill="#F3F0FF"/>
                        <rect x="16" y="24" width="48" height="36" rx="4" fill="#E9D5FF" stroke="#7C3AED" stroke-width="1.5"/>
                        <rect x="20" y="28" width="40" height="28" rx="2" fill="#F8F4FF"/>
                        <circle cx="30" cy="40" r="6" fill="#7C3AED" opacity="0.3"/>
                        <circle cx="50" cy="40" r="6" fill="#7C3AED" opacity="0.3"/>
                        <path d="M26 50 C26 46 30 44 30 44 C30 44 34 46 34 50" stroke="#7C3AED" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M46 50 C46 46 50 44 50 44 C50 44 54 46 54 50" stroke="#7C3AED" stroke-width="1.5" stroke-linecap="round"/>
                        <circle cx="24" cy="18" r="2" fill="#7C3AED" opacity="0.4"/>
                        <circle cx="56" cy="20" r="1.5" fill="#7C3AED" opacity="0.3"/>
                        <circle cx="60" cy="16" r="1" fill="#7C3AED" opacity="0.2"/>
                    </svg>
                </div>
                <div class="clients-empty-title">No clients connected yet</div>
                <div class="clients-empty-desc">Connect an AI client to start using ServerAvatar MCP and manage your servers with AI.</div>
            </div>
        @endif
    </div>
</div>

<!-- API Key Modal -->
@include('components.api-key-modal', ['apiKey' => $user->api_key, 'hasApiKey' => $user->hasApiKey()])
@endsection

@section('scripts')
<script>
    // Set body data attributes for API key modal
    document.body.setAttribute('data-has-api-key', '{{ $user->hasApiKey() ? '1' : '0' }}');
    document.body.setAttribute('data-user-api-key', '{{ $user->api_key ?? '' }}');

    // Preload server illustration
    var serverImg = new Image();
    serverImg.src = '{{ asset('images/server-illustration.png') }}';
    serverImg.onload = function() {
        var img = document.querySelector('.server-illustration-img');
        if (img) img.style.opacity = '1';
    };

    // Copy MCP URL
    function copyMcpUrl(btn) {
        var url = 'https://mcp.178.105.137.4.nip.io/mcp/serveravatar';
        navigator.clipboard.writeText(url).then(function() {
            btn.classList.add('copied');
            btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg> Copied';
            setTimeout(function() {
                btn.classList.remove('copied');
                btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copy URL';
            }, 2000);
        });
    }
</script>
@endsection
