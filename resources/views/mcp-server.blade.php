@extends('layouts.app')

@section('title', 'MCP Server - ServerAvatar MCP')
@section('breadcrumb', 'MCP Server')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">MCP Server</h1>
    <p class="page-subtitle">Connect ServerAvatar MCP to any MCP-compatible AI client</p>
</div>

<!-- MCP Server URL Card -->
<div class="card">
    <div class="section-header">
        <div class="section-icon" style="background: rgba(59, 130, 246, 0.12);"><i class="fas fa-globe" style="color: var(--accent-info);"></i></div>
        <div>
            <div class="section-title">MCP Server URL</div>
            <div class="section-desc">Use this URL to connect ServerAvatar MCP to MCP-compatible clients</div>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 12px; margin-top: 1.25rem;">
        <div style="flex: 1; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 12px 16px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-link" style="color: var(--accent-info);"></i>
            <span style="font-family: monospace; font-size: 14px; color: var(--text-primary);">https://mcp.178.105.137.4.nip.io/mcp/serveravatar</span>
        </div>
        <button onclick="copyMcpUrl(this)" style="padding: 12px 20px; background: var(--accent-info); color: white; border: none; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; white-space: nowrap;">
            <i class="fas fa-copy"></i> Copy URL
        </button>
    </div>
    <div style="display: flex; align-items: center; gap: 1.5rem; margin-top: 1rem; padding: 12px 16px; background: rgba(59, 130, 246, 0.08); border-radius: var(--radius-md);">
        <span style="display: flex; align-items: center; gap: 6px;"><span style="width: 8px; height: 8px; border-radius: 50%; background: var(--accent-success);"></span> Server Online</span>
        <span style="display: flex; align-items: center; gap: 6px;"><i class="fas fa-wrench" style="color: var(--accent-primary);"></i> {{ $toolsCount }} Tools Available</span>
        <span style="display: flex; align-items: center; gap: 6px;"><i class="fas fa-users" style="color: var(--accent-primary);"></i> Compatible with MCP Clients</span>
    </div>
</div>
@endsection

@section('scripts')
<script>
function copyMcpUrl(btn) {
    navigator.clipboard.writeText('https://mcp.178.105.137.4.nip.io/mcp/serveravatar').then(function() {
        btn.innerHTML = '<i class="fas fa-check"></i> Copied';
        btn.style.background = 'var(--accent-success)';
        setTimeout(function() { btn.innerHTML = '<i class="fas fa-copy"></i> Copy URL'; btn.style.background = ''; }, 2000);
    });
}
</script>
@endsection