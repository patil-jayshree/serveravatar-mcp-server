@extends('layouts.app')

@section('title', 'Integrations - ServerAvatar MCP')
@section('breadcrumb', 'Integrations')

@section('styles')
.section-label { font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem; }
.integration-grid { grid-template-columns: repeat(3, 1fr) !important; gap: 0.75rem; }
.integration-card.simple { padding: 1.25rem; }
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Integrations</h1>
    <p class="page-subtitle">Connect ServerAvatar MCP with any MCP-compatible AI client.</p>
</div>

<!-- Integrations Card -->
<div class="card" style="padding: 1.5rem;">
    <div class="section-label">Popular Clients</div>
    <div class="integration-grid">
        <!-- ChatGPT -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Claude')->count() > 0)
            <span class="badge badge-success badge-top-right">✓ Connected</span>
            @else
            <span class="badge badge-popular badge-top-right"><i class="fas fa-magic-wand-sparkles" style="color: #fbbf24;"></i> Popular</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/claude.png" width="28" height="28" style="object-fit: contain; border-radius: 4px;" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-robot\'></i>'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Claude</span>
                <span class="integration-desc">Add to ~/.claude/mcp_servers.json</span>
            </div>
        </div>
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'ChatGPT')->count() > 0)
            <span class="badge badge-success badge-top-right">✓ Connected</span>
            @else
            <span class="badge badge-popular badge-top-right"><i class="fas fa-magic-wand-sparkles" style="color: #fbbf24;"></i> Popular</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/chatgpt-light.png" class="icon-light" width="28" height="28" style="object-fit: contain;" /><img src="/images/clients/chatgpt-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-robot\'></i>'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">ChatGPT</span>
                <span class="integration-desc">Connect via MCP in ChatGPT Settings</span>
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
                <img src="/images/clients/cursor-light.png" class="icon-light" width="28" height="28" style="object-fit: contain;" /><img src="/images/clients/cursor-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='💚'" />
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
                <img src="/images/clients/vscode.png" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='💙'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">VS Code</span>
                <span class="integration-desc">Use MCP extension for VS Code</span>
            </div>
        </div>
        <!-- Perplexity -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Perplexity')->count() > 0)
            <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/perplexity-light.png" class="icon-light" /><img src="/images/clients/perplexity-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-brain\'></i>'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Perplexity</span>
                <span class="integration-desc">Connect via Perplexity API</span>
            </div>
        </div>
        <!-- Windsurf -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Windsurf')->count() > 0)
            <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/windsurf-light.png" class="icon-light" width="28" height="28" style="object-fit: contain;" /><img src="/images/clients/windsurf-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🌊'" />
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
                <img src="/images/clients/zed.png" width="28" height="28" style="object-fit: contain; border-radius: 4px;" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-bolt\'></i>'" />
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
                <img src="/images/clients/continue.png" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🔗'" />
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
                <img src="/images/clients/cline-light.png" class="icon-light" width="28" height="28" style="object-fit: contain; border-radius: 4px;" /><img src="/images/clients/cline-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain; border-radius: 4px;" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-bolt\'></i>'" />
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
                <img src="/images/clients/gemini.png" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🌟'" />
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
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <span style="font-size: 1.5rem; color: #7c5cfb;">+</span>
            </div>
            <div class="integration-text">
                <span class="integration-name">More Clients</span>
                <span class="integration-desc">Works with many other MCP-compatible clients</span>
            </div>
        </div>
    </div>
</div>
@endsection