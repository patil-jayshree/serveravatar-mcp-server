@extends('layouts.app')

@section('title', 'Clients - ServerAvatar MCP')
@section('breadcrumb', 'Clients')

@php
$csrf = csrf_token();
@endphp

@section('styles')
.clients-table-body { min-height: 100px; }
.clients-loading { display: flex; align-items: center; justify-content: center; min-height: 100px; color: var(--text-secondary); }
.clients-loading i { font-size: 1.5rem; animation: spin 0.8s linear infinite; }
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between;">
    <div>
        <h1 class="page-title">Connected Clients <span class="active-clients-badge" id="clientsCount">{{ $connectedClients->count() }} Active Clients</span></h1>
        <p class="page-subtitle">AI clients currently connected to your MCP server</p>
    </div>
    <button onclick="loadClients()" class="refresh-btn" title="Refresh">
        <i class="fas fa-sync-alt"></i>
    </button>
</div>

<!-- Clients Table -->
<div class="card" style="padding: 0; margin-bottom: 1rem;">
    <div class="clients-table-header">
        <div class="clients-th" style="flex: 2;">CLIENT</div>
        <div class="clients-th" style="flex: 1;">STATUS</div>
        <div class="clients-th" style="flex: 1;">CONNECTED AT</div>
        <div class="clients-th" style="flex: 1;">LAST ACTIVITY</div>
    </div>
    
    <div id="clientsTableBody" class="clients-table-body">
        @if($connectedClients->count() > 0)
        @foreach($connectedClients as $client)
        <div class="clients-tr">
            <div class="clients-td" style="flex: 2;">
                <div class="client-info">
                    <div class="client-icon-wrap">
                        @if($client->client_name == "Claude" || $client->client_name == "Claude Desktop")
                            <img src="/images/clients/claude.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;"><i class="fas fa-robot"></i></span>
                        @elseif($client->client_name == "Cursor")
                            <img src="/images/clients/cursor-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';" /><img src="/images/clients/cursor-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;">💚</span>
                        @elseif($client->client_name == "VS Code" || $client->client_name == "VSCode" || $client->client_name == "Visual Studio Code")
                            <img src="/images/clients/vscode.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;">💙</span>
                        @elseif($client->client_name == "ChatGPT")
                            <img src="/images/clients/chatgpt-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';" /><img src="/images/clients/chatgpt-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;">🤖</span>
                        @elseif($client->client_name == "Windsurf")
                            <img src="/images/clients/windsurf-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';" /><img src="/images/clients/windsurf-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;">🌊</span>
                        @elseif($client->client_name == "Zed")
                            <img src="/images/clients/zed.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;"><i class="fas fa-server"></i></span>
                        @elseif($client->client_name == "Continue")
                            <img src="/images/clients/continue.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;">🔗</span>
                        @elseif($client->client_name == "Cline")
                            <img src="/images/clients/cline-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';" /><img src="/images/clients/cline-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;"><i class="fas fa-server"></i></span>
                        @elseif($client->client_name == "Gemini")
                            <img src="/images/clients/gemini.png" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;">🌟</span>
                        @else
                            <img src="/images/clients/chatgpt-light.png" class="icon-light" width="32" height="32" style="border-radius: 6px; object-fit: contain;" /><img src="/images/clients/chatgpt-dark.png" class="icon-dark" width="32" height="32" style="border-radius: 6px; object-fit: contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                            <span class="client-icon-fallback" style="display: none;"><i class="fas fa-laptop"></i></span>
                        @endif
                    </div>
                    <span class="client-name">{{ $client->client_name }}</span>
                </div>
            </div>
            <div class="clients-td" style="flex: 1;">
                <span class="badge-active">Active</span>
            </div>
            <div class="clients-td" style="flex: 1;">
                <span class="client-date">{{ $client->created_at->format('M d, Y') }}<br><span style="color: var(--text-muted); font-size: 12px;">{{ $client->created_at->format('h:i A') }}</span></span>
            </div>
            <div class="clients-td" style="flex: 1;">
                <span class="client-activity">{{ $client->last_activity_at ? $client->last_activity_at->diffForHumans() : 'N/A' }}</span>
            </div>
        </div>
        @endforeach
        @else
        <div class="clients-empty" style="text-align: center; padding: 3rem; color: var(--text-secondary);">
            <div class="clients-empty-icon" style="margin-bottom: 1rem;">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                    <circle cx="40" cy="40" r="36" fill="#F3F0FF"/>
                    <rect x="16" y="24" width="48" height="36" rx="4" fill="#E9D5FF" stroke="#7C3AED" stroke-width="1.5"/>
                    <rect x="20" y="28" width="40" height="28" rx="2" fill="#F8F4FF"/>
                    <circle cx="30" cy="40" r="6" fill="#7C3AED" opacity="0.3"/>
                    <circle cx="50" cy="40" r="6" fill="#7C3AED" opacity="0.3"/>
                    <path d="M26 50 C26 46 30 44 30 44 C30 44 34 46 34 50" stroke="#7C3AED" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M46 50 C46 46 50 44 50 44 C50 44 54 46 54 50" stroke="#7C3AED" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="clients-empty-title">No clients connected yet</div>
            <div class="clients-empty-desc">Connect an AI client to start using ServerAvatar MCP.</div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
var csrfToken = '{{ $csrf }}';

function loadClients() {
    var tbody = document.getElementById('clientsTableBody');
    var countBadge = document.getElementById('clientsCount');
    var refreshBtn = document.querySelector('.refresh-btn');
    
    // Show loading
    tbody.innerHTML = '<div class="clients-loading"><i class="fas fa-spinner"></i></div>';
    
    // Add loading state to refresh button
    if (refreshBtn) {
        refreshBtn.classList.add('loading');
    }
    
    // Fetch data
    fetch('/clients/fetch', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            tbody.innerHTML = data.html;
            countBadge.textContent = data.count + ' Active Clients';
        } else {
            tbody.innerHTML = '<div class="clients-empty" style="text-align: center; padding: 3rem; color: var(--text-secondary);"><i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i><p>Error loading clients</p></div>';
        }
        
        // Remove loading state
        if (refreshBtn) {
            refreshBtn.classList.remove('loading');
        }
    })
    .catch(function(err) {
        console.error('Error:', err);
        tbody.innerHTML = '<div class="clients-empty" style="text-align: center; padding: 3rem; color: var(--text-secondary);"><i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i><p>Network error. Please try again.</p></div>';
        if (refreshBtn) {
            refreshBtn.classList.remove('loading');
        }
    });
}
</script>
@endsection
