@extends('layouts.app')

@section('title', 'MCP Server - ServerAvatar MCP')
@section('breadcrumb', 'MCP Server')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">MCP Server</h1>
    <p class="page-subtitle">Manage your MCP endpoint and connection details.</p>
</div>

<div style="display: flex; flex-direction: column; gap: 1.5rem;">

    <!-- Server Status Card -->
    <div class="card" style="padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 8px rgba(22, 163, 74, 0.5); flex-shrink: 0;"></span>
            <span style="font-size: 1rem; font-weight: 600; color: var(--text-primary);">Server Status: Online</span>
        </div>
        <p style="font-size: 0.875rem; color: var(--text-secondary); margin: 0; padding-left: 1.25rem;">Everything is running normally and ready to accept MCP client connections.</p>
    </div>

    <!-- MCP Server URL Card -->
    <div class="card" style="padding: 1.5rem;">
        <div class="section-header" style="margin-bottom: 1rem;">
            <div class="section-icon" style="background: rgba(59, 130, 246, 0.12);"><i class="fas fa-globe" style="color: var(--accent-primary);"></i></div>
            <div>
                <div class="section-title">MCP Server URL</div>
                <div class="section-desc">Use this endpoint to connect any MCP-compatible AI client</div>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="flex: 1; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 12px 16px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-link" style="color: var(--accent-primary);"></i>
                <span style="font-family: monospace; font-size: 14px; color: var(--text-primary);">https://mcp.178.105.137.4.nip.io/mcp/serveravatar</span>
            </div>
            <button onclick="copyMcpUrl(this)" id="copyUrlBtn" class="btn-card-action primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: var(--accent-primary); border: none; border-radius: var(--radius-md); color: white; font-weight: 600; cursor: pointer; white-space: nowrap; transition: background 0.2s, border 0.2s, color 0.2s;">
                <i class="fas fa-copy"></i> Copy URL
            </button>
        </div>
        <div style="margin-top: 0.75rem;">
            <a href="#" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; color: var(--accent-primary); text-decoration: none; font-weight: 500;">
                <i class="fas fa-book"></i> View Documentation
            </a>
        </div>
    </div>

    <!-- Endpoint Information -->
    <div class="card" style="padding: 1.5rem;">
        <div class="section-header" style="margin-bottom: 1rem;">
            <div class="section-icon" style="background: rgba(139, 92, 246, 0.12);"><i class="fas fa-info-circle" style="color: var(--accent-primary);"></i></div>
            <div>
                <div class="section-title">Endpoint Information</div>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">Transport</span>
                <span style="font-size: 0.9rem; color: var(--text-primary); font-weight: 500;">HTTP</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">Authentication</span>
                <span style="font-size: 0.9rem; color: var(--text-primary); font-weight: 500;">API Key</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">Available Tools</span>
                <span style="font-size: 0.9rem; color: var(--text-primary); font-weight: 500;">{{ $toolsCount }}</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">Status</span>
                <span style="font-size: 0.9rem; color: #16a34a; font-weight: 500;">Online</span>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="card" style="padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="section-icon" style="background: rgba(139, 92, 246, 0.12); width: 36px; height: 36px;"><i class="fas fa-circle-question" style="color: var(--accent-primary); font-size: 1rem;"></i></div>
            <div>
                <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-primary);">Need Help?</div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);">Check our documentation for setup guides and troubleshooting.</div>
            </div>
        </div>
        <a href="#" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--accent-primary); text-decoration: none; font-size: 0.8rem; font-weight: 600; white-space: nowrap;">
            <i class="fas fa-book"></i> Documentation
        </a>
    </div>

</div>
@endsection

@section('scripts')
<script>
function copyMcpUrl(btn) {
    navigator.clipboard.writeText('https://mcp.178.105.137.4.nip.io/mcp/serveravatar').then(function() {
        btn.innerHTML = '<i class="fas fa-check"></i> Copied';
        btn.style.background = '#16a34a';
        btn.style.border = 'none';
        btn.style.color = 'white';
        btn.style.cursor = 'default';
        setTimeout(function() {
            btn.innerHTML = '<i class="fas fa-copy"></i> Copy URL';
            btn.style.background = 'var(--accent-primary)';
            btn.style.border = 'none';
            btn.style.color = 'white';
            btn.style.cursor = '';
        }, 2000);
    });
}
</script>
@endsection
