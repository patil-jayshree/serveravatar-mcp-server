@extends('layouts.app')

@section('title', 'Integrations - ServerAvatar MCP')
@section('breadcrumb', 'Integrations')

@section('styles')
.category-section { margin-bottom: 2rem; }
.category-header { display: flex; align-items: center; gap: 12px; margin-bottom: 1rem; }
.category-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(139, 92, 246, 0.12); display: flex; align-items: center; justify-content: center; }
.category-icon i { font-size: 0.9rem; color: var(--accent-primary); }
.category-title { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
.integration-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
.integration-card.simple { padding: 1.25rem; }
.badge-popular { background: rgba(251, 191, 36, 0.15); color: #d97706; }
.badge-popular i { margin-right: 4px; }

/* ========== RESPONSIVE STYLES ========== */

/* Mobile: 360px to 767px */
@media (max-width: 767px) {
    .page-header { margin-bottom: 1.5rem; }
    .page-title { font-size: 1.5rem !important; }
    .page-subtitle { font-size: 0.875rem !important; }
    
    .category-section { margin-bottom: 1.5rem; }
    .category-header { flex-direction: row; align-items: center; gap: 10px; margin-bottom: 0.75rem; }
    .category-title { font-size: 1rem; }
    
    .integration-grid { grid-template-columns: 1fr; gap: 0.75rem; }
    .integration-card.simple { padding: 1rem; }
    .integration-card .integration-logo { width: 36px; height: 36px; min-width: 36px; }
    .integration-card .integration-logo img { width: 24px !important; height: 24px !important; }
    .integration-name { font-size: 0.875rem; }
    .integration-desc { font-size: 0.75rem; }
    
    /* MCP Universal Banner */
    .mcp-universal-banner { flex-direction: column !important; padding: 1rem !important; text-align: center; gap: 12px !important; }
    .mcp-universal-banner > div:first-child { flex-direction: column !important; text-align: center !important; }
    .mcp-universal-banner .banner-btn { width: 100%; justify-content: center; }
}

/* Tablet: 768px to 834px */
@media (min-width: 768px) and (max-width: 834px) {
    .integration-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    .category-header { gap: 10px; }
    .category-title { font-size: 1rem; }
}

/* Laptop: 1024px to 1280px */
@media (min-width: 1024px) and (max-width: 1280px) {
    .integration-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    .integration-card.simple { padding: 1rem; }
}

/* Desktop: 1281px to 1439px */
@media (min-width: 1281px) and (max-width: 1439px) {
    .integration-grid { grid-template-columns: repeat(3, 1fr); gap: 1rem; }
}

/* Large Desktop: 1440px+ */
@media (min-width: 1440px) {
    .integration-grid { grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
}
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Integrations</h1>
    <p class="page-subtitle">Connect ServerAvatar MCP with any MCP-compatible AI client.</p>
</div>

<!-- Browser AI Clients -->
<div class="category-section">
    <div class="category-header">
        <div class="category-icon">
            <i class="fas fa-globe"></i>
        </div>
        <div>
            <h2 class="category-title">Browser AI Clients</h2>
            <p style="font-size: 0.85rem; color: var(--text-secondary); margin: 0;">Use popular AI assistants directly in your browser.</p>
        </div>
    </div>
    <div class="integration-grid">
        <!-- Claude -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Claude')->count() > 0)
            <span class="badge badge-success badge-top-right">✓ Connected</span>
            @else
            <span class="badge badge-popular badge-top-right"><i class="fas fa-magic-wand-sparkles"></i> Popular</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/claude.png" width="28" height="28" style="object-fit: contain; border-radius: 4px;" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-robot\'></i>'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Claude</span>
                <span class="integration-desc">Add in Claude Settings → Custom Connectors</span>
            </div>
        </div>
        <!-- ChatGPT -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'ChatGPT')->count() > 0)
            <span class="badge badge-success badge-top-right">✓ Connected</span>
            @else
            <span class="badge badge-popular badge-top-right"><i class="fas fa-magic-wand-sparkles"></i> Popular</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/chatgpt-light.png" class="icon-light" width="28" height="28" style="object-fit: contain;" /><img src="/images/clients/chatgpt-dark.png" class="icon-dark" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-robot\'></i>'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">ChatGPT</span>
                <span class="integration-desc">Connect via MCP in ChatGPT Settings</span>
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
                <span class="integration-desc">Connect via Perplexity API or Custom Connectors</span>
            </div>
        </div>
    </div>
    <!-- Limitation Warning for Browser AI Clients -->
    <div style="margin-top: 1rem; padding: 0.875rem 1rem; background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 10px;">
        <div style="display: flex; align-items: flex-start; gap: 10px;">
            <div style="width: 32px; height: 32px; min-width: 32px; background: rgba(245, 158, 11, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-shield-halved" style="color: #fbbf24; font-size: 0.9rem;"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-primary); margin-bottom: 3px;">OpenAI Safety Restriction</div>
                <p style="margin: 0; font-size: 0.75rem; color: var(--text-secondary); line-height: 1.5;">ChatGPT may block operations involving passwords, credentials, or sensitive data for security reasons. Use <strong>Claude</strong>, <strong>Cursor</strong> or <strong>any other AI client</strong> for full functionality.</p>
            </div>
        </div>
    </div>
</div>

<!-- IDE / Code Editors -->
<div class="category-section">
    <div class="category-header">
        <div class="category-icon">
            <i class="fas fa-code"></i>
        </div>
        <div>
            <h2 class="category-title">IDE / Code Editors</h2>
            <p style="font-size: 0.85rem; color: var(--text-secondary); margin: 0;">Connect MCP with your favourite development environment.</p>
        </div>
    </div>
    <div class="integration-grid">
        <!-- Cursor -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Cursor')->count() > 0)
            <span class="badge badge-success badge-top-right">✓ Connected</span>
            @else
            <span class="badge badge-popular badge-top-right"><i class="fas fa-magic-wand-sparkles"></i> Popular</span>
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
            @if($connectedClients->where('client_name', 'VS Code')->count() > 0 || $connectedClients->where('client_name', 'Visual Studio Code')->count() > 0)
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
    </div>
</div>

<!-- CLI / Desktop -->
<div class="category-section">
    <div class="category-header">
        <div class="category-icon">
            <i class="fas fa-terminal"></i>
        </div>
        <div>
            <h2 class="category-title">CLI / Desktop</h2>
            <p style="font-size: 0.85rem; color: var(--text-secondary); margin: 0;">Use MCP with powerful CLI and desktop AI tools.</p>
        </div>
    </div>
    <div class="integration-grid">
        <!-- Gemini CLI -->
        <div class="integration-card simple">
            @if($connectedClients->where('client_name', 'Gemini')->count() > 0)
            <span class="badge badge-success badge-top-right">✓ Connected</span>
            @endif
            <div class="integration-logo" style="background: rgba(139, 92, 246, 0.12);">
                <img src="/images/clients/gemini.png" width="28" height="28" style="object-fit: contain;" onerror="this.style.display='none';this.parentElement.innerHTML='🌟'" />
            </div>
            <div class="integration-text">
                <span class="integration-name">Gemini CLI</span>
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

<!-- MCP is Universal Banner -->
<div class="mcp-universal-banner" style="background: rgba(139, 92, 246, 0.08); border: 1px solid rgba(139, 92, 246, 0.2); border-radius: 12px; padding: 1rem 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
    <div style="display: flex; align-items: center; gap: 0.875rem;">
        <div style="width: 36px; height: 36px; min-width: 36px; background: rgba(139, 92, 246, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-star" style="color: var(--accent-primary); font-size: 0.9rem;"></i>
        </div>
        <div>
            <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: var(--text-primary);">MCP is Universal</h3>
            <p style="margin: 2px 0 0 0; font-size: 0.8rem; color: var(--text-secondary);">ServerAvatar MCP works with any AI client that supports the Model Context Protocol.</p>
        </div>
    </div>
    <a href="{{ route('guide') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: var(--accent-primary); border: none; border-radius: 8px; color: white; font-size: 0.85rem; font-weight: 600; text-decoration: none; white-space: nowrap;">
        <i class="fas fa-external-link-alt"></i>
        View Full Document
    </a>
</div>
@endsection
