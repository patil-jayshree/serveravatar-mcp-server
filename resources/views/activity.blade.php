@extends('layouts.app')

@section('title', 'Activity - ServerAvatar MCP')
@section('breadcrumb', 'Activity')

@php
$csrf = csrf_token();
@endphp

@section('styles')
.activity-page { display: flex; flex-direction: column; gap: 1rem; }
.filter-bar { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; padding: 0; border-radius: 0; margin-bottom: 16px; }
.filter-search { flex: 1; min-width: 200px; position: relative; display: flex; align-items: center; }
.filter-search i:first-child { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 14px; pointer-events: none; z-index: 1; }
.filter-search input { width: 100%; padding: 10px 36px 10px 36px; background: #ffffff; border: 1px solid #e0e0e5; border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; transition: border-color 0.2s; }
.filter-search .clear-search { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 14px; cursor: pointer; display: none; z-index: 2; }
.filter-search .clear-search:hover { color: var(--accent-primary); }
.filter-search .clear-search.show { display: block; }
.filter-search input:focus { outline: none; border-color: var(--accent-primary); }
.filter-search input::placeholder { color: #9ca3af; }
.filter-select { position: relative; display: flex; align-items: center; gap: 8px; padding: 10px 32px 10px 12px; background: #ffffff; border: 1px solid #e0e0e5; border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; cursor: pointer; appearance: none; min-width: 140px; transition: border-color 0.2s, box-shadow 0.2s; }
.filter-select:hover { border-color: #c0c0c5; }
.filter-select i { color: #6b7280; font-size: 12px; }
.filter-select select { position: absolute; left: 0; top: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
.filter-clear { display: flex; align-items: center; gap: 6px; padding: 10px 16px; background: #ffffff; border: 1px solid #e0e0e5; border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; cursor: pointer; transition: all 0.2s; white-space: nowrap; }
.filter-clear:hover { border-color: var(--accent-primary); color: var(--accent-primary); }
.filter-clear i { color: #6b7280; transition: color 0.2s; }
.filter-clear:hover i { color: var(--accent-primary); }
.activity-table-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; }
.activity-table { width: 100%; border-collapse: collapse; }
.activity-table th { text-align: left; padding: 12px 16px; font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); }
.activity-table th:last-child { text-align: left; }
.activity-table td { padding: 14px 16px; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
.activity-table tr:last-child td { border-bottom: none; }
.activity-table tr:hover td { background: var(--bg-secondary); }
.event-cell { display: flex; align-items: center; gap: 12px; min-width: 0; }
.event-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.event-icon svg { width: 18px; height: 18px; }
.event-info { display: flex; flex-direction: column; gap: 4px; }
.event-desc { font-size: 0.875rem; font-weight: 600; color: var(--text-primary); }
.event-via { font-size: 0.75rem; color: var(--text-muted); }
.event-badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 0.6rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; white-space: nowrap; max-width: fit-content; }
.badge-info { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.badge-success { background: rgba(22, 163, 74, 0.12); color: #16a34a; }
.badge-warning { background: rgba(245, 158, 11, 0.12); color: #d97706; }
.badge-primary { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }
.badge-danger { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
.badge-cyan { background: rgba(6, 182, 212, 0.12); color: #06b6d4; }
.badge-secondary { background: rgba(148, 163, 184, 0.12); color: #64748b; }
.client-cell { display: flex; align-items: center; gap: 10px; }
.client-avatar { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0; }
.client-name { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); }
.client-type { font-size: 0.7rem; color: var(--text-muted); }
.time-cell { display: flex; flex-direction: column; gap: 4px; }
.time-relative { font-size: 0.85rem; font-weight: 500; color: var(--text-primary); }
.time-absolute { font-size: 0.7rem; color: var(--text-muted); }
.actions-cell { text-align: left; }
.view-btn { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: transparent; border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--accent-primary); font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.view-btn:hover { background: var(--accent-primary); border-color: var(--accent-primary); color: white; }
.no-actions { color: var(--text-muted); font-size: 0.85rem; }
.activity-loading { display: flex; align-items: center; justify-content: center; min-height: 200px; color: var(--text-secondary); }
.activity-loading i { font-size: 1.5rem; animation: spin 0.8s linear infinite; }
.activity-empty { text-align: center; padding: 4rem 2rem; color: var(--text-secondary); }
.activity-empty i { font-size: 3rem; color: var(--accent-primary); opacity: 0.5; margin-bottom: 1rem; }
.activity-empty p { font-size: 0.9rem; }

/* Slide-out Panel */
.panel-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 999; opacity: 0; visibility: hidden; transition: all 0.3s; }
.panel-overlay.active { opacity: 1; visibility: visible; }
.event-panel { position: fixed; top: 0; right: 0; width: 480px; max-width: 100%; height: 100%; background: var(--bg-card); box-shadow: -4px 0 20px rgba(0,0,0,0.15); z-index: 1000; transform: translateX(100%); transition: transform 0.3s ease; overflow-y: auto; }
.panel-overlay.active .event-panel { transform: translateX(0); }
.panel-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; background: var(--bg-card); }
.panel-title { display: flex; align-items: center; gap: 10px; font-size: 1rem; font-weight: 700; color: var(--text-primary); }
.panel-title i { color: var(--accent-primary); }
.panel-close { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: transparent; border: none; border-radius: 8px; color: var(--text-muted); cursor: pointer; font-size: 1.25rem; transition: all 0.2s; }
.panel-close:hover { background: var(--bg-secondary); color: var(--text-primary); }
.panel-body { padding: 20px; }
.panel-section { margin-bottom: 20px; }
.panel-section:last-child { margin-bottom: 0; }
.panel-section-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 10px; }
.panel-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.panel-info-item { display: flex; flex-direction: column; gap: 4px; }
.panel-info-label { font-size: 0.7rem; color: var(--text-muted); }
.panel-info-value { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 6px; }
.panel-info-value .client-badge { width: 20px; height: 20px; border-radius: 50%; font-size: 0.5rem; display: flex; align-items: center; justify-content: center; }
.payload-block { background: var(--bg-secondary); border-radius: 8px; padding: 12px; position: relative; }
.payload-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
.payload-title { font-size: 0.75rem; font-weight: 600; color: var(--text-primary); }
.payload-copy { display: flex; align-items: center; gap: 4px; padding: 4px 8px; background: transparent; border: none; border-radius: 4px; color: var(--text-muted); font-size: 0.7rem; cursor: pointer; transition: all 0.2s; }
.payload-copy:hover { background: var(--bg-card); color: var(--accent-primary); }
.payload-code { font-family: 'SF Mono', Monaco, monospace; font-size: 0.75rem; line-height: 1.6; color: var(--text-secondary); white-space: pre-wrap; word-break: break-all; max-height: 300px; overflow-y: auto; }
.payload-code .key { color: #8b5cf6; }
.payload-code .string { color: #16a34a; }
.payload-code .number { color: #f59e0b; }
.payload-code .bool { color: #3b82f6; }
.payload-code .null { color: #ef4444; }
.panel-footer { padding: 16px 20px; border-top: 1px solid var(--border-color); position: sticky; bottom: 0; background: var(--bg-card); }
.panel-close-btn { width: 100%; padding: 10px; background: transparent; border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.panel-close-btn:hover { background: var(--bg-secondary); }
.refresh-btn { width: 36px; height: 36px; border-radius: var(--radius-md); background: transparent; border: 1px solid var(--border-color); color: var(--accent-primary); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; text-decoration: none; }
.refresh-btn:hover { background: var(--accent-primary-muted); border-color: var(--accent-primary); }
.refresh-btn .fa-sync-alt { font-size: 14px; color: var(--accent-primary); }
.refresh-btn.loading .fa-sync-alt { animation: spin 0.6s linear infinite; }
.page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; }
.pagination-bar { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-top: 1px solid var(--border-color); background: var(--bg-secondary); }
.pagination-info { font-size: 0.8rem; color: var(--text-muted); }
.pagination-buttons { display: flex; align-items: center; gap: 4px; }
.page-btn { display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 8px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-sm); color: var(--text-secondary); font-size: 0.8rem; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.page-btn:hover:not(.disabled):not(.active) { border-color: var(--accent-primary); color: var(--accent-primary); }
.page-btn.active { background: var(--accent-primary); border-color: var(--accent-primary); color: white; font-weight: 600; }
.page-btn.disabled { opacity: 0.5; cursor: not-allowed; }
.page-btn i { font-size: 10px; }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Activity Log</h1>
        <p class="page-subtitle">Track all MCP events and account changes</p>
    </div>
    <button onclick="loadActivities(1)" class="refresh-btn" title="Refresh" id="refreshBtn">
        <i class="fas fa-sync-alt"></i>
    </button>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <div class="filter-search">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Search events, clients or IP..." value="{{ $searchQuery ?? '' }}" onkeyup="handleSearch(event)" oninput="toggleClearBtn()">
        <i class="fas fa-times clear-search" onclick="clearSearch()"></i>
    </div>
    <button type="button" onclick="handleSearchClick()" class="btn-card-action" style="display: inline-block; padding: 11px 16px; background: var(--accent-primary); color: white; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; border: none; cursor: pointer; white-space: nowrap; height: 44px;">
        Search
    </button>
    <div class="filter-select">
        <i class="fas fa-calendar"></i>
        <span id="timeFilterLabel">{{ $timeFilter ?? 'All Time' }}</span>
        <i class="fas fa-chevron-down" style="position: absolute; right: 10px; color: #6b7280; font-size: 10px; pointer-events: none;"></i>
        <select id="timeFilter" onchange="handleFilterChange()">
            <option value="" {{ $timeFilter == '' ? 'selected' : '' }}>All Time</option>
            <option value="today" {{ $timeFilter == 'today' ? 'selected' : '' }}>Today</option>
            <option value="7days" {{ $timeFilter == '7days' ? 'selected' : '' }}>Last 7 Days</option>
            <option value="30days" {{ $timeFilter == '30days' ? 'selected' : '' }}>Last 30 Days</option>
            <option value="90days" {{ $timeFilter == '90days' ? 'selected' : '' }}>Last 90 Days</option>
        </select>
    </div>
    <div class="filter-select">
        <i class="fas fa-filter"></i>
        <span id="eventFilterLabel">All Events</span>
        <i class="fas fa-chevron-down" style="position: absolute; right: 10px; color: #6b7280; font-size: 10px; pointer-events: none;"></i>
        <select id="eventFilter" onchange="handleFilterChange()">
            <option value="" {{ $eventFilter == '' ? 'selected' : '' }}>All Events</option>
            <option value="tool_executed" {{ $eventFilter == 'tool_executed' ? 'selected' : '' }}>Tool Executed</option>
            <option value="client_connected">Client Connected</option>
            <option value="client_disconnected">Client Disconnected</option>
            <option value="api_key_saved">API Key Saved</option>
            <option value="api_key_deleted">API Key Deleted</option>
            <option value="profile_updated">Profile Updated</option>
            <option value="password_changed">Password Changed</option>
        </select>
    </div>
    <div class="filter-select">
        <i class="fas fa-user"></i>
        <span id="clientFilterLabel">All Clients</span>
        <i class="fas fa-chevron-down" style="position: absolute; right: 10px; color: #6b7280; font-size: 10px; pointer-events: none;"></i>
        <select id="clientFilter" onchange="handleFilterChange()">
            <option value="" {{ $clientFilter == '' ? 'selected' : '' }}>All Clients</option>
            @if(isset($clients) && $clients->count() > 0)
                @foreach($clients as $client)
                    <option value="{{ $client }}">{{ $client }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="filter-select" onclick="clearFilters()" style="cursor: pointer;">
        <i class="fas fa-rotate-right"></i>
        <span id="clearFilterLabel">Clear Filters</span>
    </div>
</div>

<!-- Activity Table -->
<div class="activity-table-card">
    <table class="activity-table">
        <thead>
            <tr>
                <th>EVENT</th>
                <th>CLIENT</th>
                <th>TIME</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody id="activityTableBody">
            @if($activities->count() > 0)
            @foreach($activities as $activity)
            <tr data-id="{{ $activity->id }}" data-activity='@json($activity)'>
                <td>
                    <div class="event-cell">
                        <div class="event-icon" style="background: rgba(139, 92, 246, 0.1);">
                            {!! $activity->icon !!}
                        </div>
                        <div class="event-info">
                            <span class="event-desc">{{ $activity->description }}</span>
                            <span class="event-via">via {{ $activity->client_name ?? 'System' }}</span>
                            <span class="event-badge badge-{{ $activity->color }}">{{ $activity->typeLabel }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="client-cell">
                        @if($activity->client_logo)
                            <div class="client-avatar">
                                <img src="{{ $activity->client_logo['light'] }}" alt="" width="28" height="28" class="icon-light">
                                <img src="{{ $activity->client_logo['dark'] }}" alt="" width="28" height="28" class="icon-dark">
                            </div>
                        @else
                            <div class="client-avatar" style="background: {{ $activity->client_color ?? '#8b5cf6' }};">
                                {{ $activity->client_initials ?? 'SA' }}
                            </div>
                        @endif
                        <div>
                            <div class="client-name">{{ $activity->client_name ?? 'System' }}</div>
                            <div class="client-type">{{ $activity->client_type ?? 'AI Client' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="time-cell">
                        <span class="time-relative" data-time="{{ $activity->created_at->toISOString() }}">{{ $activity->created_at->diffForHumans() }}</span>
                        <span class="time-absolute">{{ $activity->created_at->format('M d, Y') }} • {{ $activity->created_at->format('h:i A') }}</span>
                    </div>
                </td>
                <td>
                    @if($activity->metadata && (isset($activity->metadata['arguments']) || isset($activity->metadata['response'])))
                        <button class="view-btn" onclick="openEventPanel({{ $activity->id }})">
                            <i class="fas fa-eye"></i> View
                        </button>
                    @else
                        <span class="no-actions">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4">
                    <div class="activity-empty">
                        <i class="fas fa-clock"></i>
                        <p>No activity recorded yet.</p>
                    </div>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    
    @if($totalPages > 1)
    <div class="pagination-bar">
        <div class="pagination-info">
            Showing {{ ($currentPage - 1) * $perPage + 1 }} to {{ min($currentPage * $perPage, $totalActivities) }} of {{ $totalActivities }} events
        </div>
        <div class="pagination-buttons" id="paginationButtons">
            @if($currentPage > 1)
                <a href="javascript:void(0)" onclick="loadActivities(1)" class="page-btn" title="First"><i class="fas fa-angle-double-left"></i></a>
                <a href="javascript:void(0)" onclick="loadActivities({{ $currentPage - 1 }})" class="page-btn" title="Previous"><i class="fas fa-chevron-left"></i></a>
            @endif
            
            @php
                $start = max(1, $currentPage - 1);
                $end = min($totalPages, $start + 2);
                if ($end - $start < 2) { $start = max(1, $end - 2); }
            @endphp
            
            @for($i = $start; $i <= $end; $i++)
                @if($i == $currentPage)
                    <span class="page-btn active">{{ $i }}</span>
                @else
                    <a href="javascript:void(0)" onclick="loadActivities({{ $i }})" class="page-btn">{{ $i }}</a>
                @endif
            @endfor
            
            @if($currentPage < $totalPages)
                <a href="javascript:void(0)" onclick="loadActivities({{ $currentPage + 1 }})" class="page-btn" title="Next"><i class="fas fa-chevron-right"></i></a>
                <a href="javascript:void(0)" onclick="loadActivities({{ $totalPages }})" class="page-btn" title="Last"><i class="fas fa-angle-double-right"></i></a>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Event Details Panel -->
<div class="panel-overlay" id="panelOverlay" onclick="closeEventPanel(event)">
    <div class="event-panel" onclick="event.stopPropagation()">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-screwdriver-wrench"></i>
                <span>Event Details</span>
            </div>
            <button class="panel-close" onclick="closeEventPanel()">&times;</button>
        </div>
        <div class="panel-body" id="panelBody">
            <!-- Dynamic content -->
        </div>
        <div class="panel-footer">
            <button class="panel-close-btn" onclick="closeEventPanel()">Close</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
var csrfToken = '{{ $csrf }}';
var currentPage = {{ $currentPage }};
var currentFilters = {
    search: '{{ $searchQuery ?? '' }}',
    time: '{{ $timeFilter ?? '' }}',
    event: '{{ $eventFilter ?? '' }}',
    client: '{{ $clientFilter ?? '' }}'
};

// Initialize filter labels on page load
document.addEventListener('DOMContentLoaded', function() {
    updateFilterLabels();
});

function loadActivities(page) {
    var tbody = document.getElementById('activityTableBody');
    var refreshBtn = document.getElementById('refreshBtn');
    
    tbody.innerHTML = '<tr><td colspan="4"><div class="activity-loading"><i class="fas fa-spinner"></i></div></td></tr>';
    if (refreshBtn) refreshBtn.classList.add('loading');
    
    var params = new URLSearchParams({ page: page });
    if (currentFilters.search) params.set('search', currentFilters.search);
    if (currentFilters.time) params.set('time', currentFilters.time);
    if (currentFilters.event) params.set('event', currentFilters.event);
    if (currentFilters.client) params.set('client', currentFilters.client);
    
    fetch('/activity/fetch?' + params.toString(), {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(function(r) { 
        if (!r.ok) {
            throw new Error('HTTP ' + r.status);
        }
        return r.json(); 
    })
    .then(function(data) {
        if (data.success) {
            tbody.innerHTML = data.html || '<tr><td colspan="4"><div class="activity-empty"><i class="fas fa-clock"></i><p>No activity recorded yet.</p></div></td></tr>';
            currentPage = data.currentPage;
            updatePagination(data);
        } else {
            tbody.innerHTML = '<tr><td colspan="4"><div class="activity-empty"><i class="fas fa-exclamation-triangle"></i><p>Error loading activities</p></div></td></tr>';
        }
        if (refreshBtn) refreshBtn.classList.remove('loading');
    })
    .catch(function(err) {
        console.error('Error:', err);
        tbody.innerHTML = '<tr><td colspan="4"><div class="activity-empty"><i class="fas fa-exclamation-triangle"></i><p>Error: ' + err.message + '</p></div></td></tr>';
        if (refreshBtn) refreshBtn.classList.remove('loading');
    });
}

function updatePagination(data) {
    var paginationBar = document.querySelector('.pagination-bar');
    if (!paginationBar) return;
    
    paginationBar.innerHTML = '<div class="pagination-info">Showing ' + ((data.currentPage - 1) * 10 + 1) + ' to ' + Math.min(data.currentPage * 10, data.totalActivities) + ' of ' + data.totalActivities + ' events</div>';
    
    var btns = '<div class="pagination-buttons">';
    if (data.currentPage > 1) {
        btns += '<a href="javascript:void(0)" onclick="loadActivities(1)" class="page-btn" title="First"><i class="fas fa-angle-double-left"></i></a>';
        btns += '<a href="javascript:void(0)" onclick="loadActivities(' + (data.currentPage - 1) + ')" class="page-btn" title="Previous"><i class="fas fa-chevron-left"></i></a>';
    }
    
    var start = Math.max(1, data.currentPage - 1);
    var end = Math.min(data.totalPages, start + 2);
    if (end - start < 2) start = Math.max(1, end - 2);
    
    for (var i = start; i <= end; i++) {
        if (i == data.currentPage) {
            btns += '<span class="page-btn active">' + i + '</span>';
        } else {
            btns += '<a href="javascript:void(0)" onclick="loadActivities(' + i + ')" class="page-btn">' + i + '</a>';
        }
    }
    
    if (data.currentPage < data.totalPages) {
        btns += '<a href="javascript:void(0)" onclick="loadActivities(' + (data.currentPage + 1) + ')" class="page-btn" title="Next"><i class="fas fa-chevron-right"></i></a>';
        btns += '<a href="javascript:void(0)" onclick="loadActivities(' + data.totalPages + ')" class="page-btn" title="Last"><i class="fas fa-angle-double-right"></i></a>';
    }
    btns += '</div>';
    paginationBar.innerHTML += btns;
}

function handleSearch(e) {
    if (e.key === 'Enter') {
        currentFilters.search = e.target.value;
        loadActivities(1);
    }
}

function handleSearchClick() {
    currentFilters.search = document.getElementById('searchInput').value;
    loadActivities(1);
}

function toggleClearBtn() {
    var input = document.getElementById('searchInput');
    var clearBtn = document.querySelector('.clear-search');
    if (input.value.length > 0) {
        clearBtn.classList.add('show');
    } else {
        clearBtn.classList.remove('show');
    }
}

function clearSearch() {
    document.getElementById('searchInput').value = '';
    currentFilters.search = '';
    document.querySelector('.clear-search').classList.remove('show');
    loadActivities(1);
}

// Initialize clear button on page load
document.addEventListener('DOMContentLoaded', function() {
    updateFilterLabels();
    toggleClearBtn();
});

function handleFilterChange() {
    currentFilters.time = document.getElementById('timeFilter').value;
    currentFilters.event = document.getElementById('eventFilter').value;
    currentFilters.client = document.getElementById('clientFilter').value;
    
    updateFilterLabels();
    loadActivities(1);
}

function updateFilterLabels() {
    var timeSel = document.getElementById('timeFilter');
    document.getElementById('timeFilterLabel').textContent = timeSel.options[timeSel.selectedIndex].textContent;
    
    var eventSel = document.getElementById('eventFilter');
    document.getElementById('eventFilterLabel').textContent = eventSel.options[eventSel.selectedIndex].textContent;
    
    var clientSel = document.getElementById('clientFilter');
    document.getElementById('clientFilterLabel').textContent = clientSel.options[clientSel.selectedIndex].textContent;
}

function clearFilters() {
    currentFilters = { search: '', time: '', event: '', client: '' };
    document.getElementById('searchInput').value = '';
    document.getElementById('timeFilter').value = '';
    document.getElementById('eventFilter').value = '';
    document.getElementById('clientFilter').value = '';
    document.getElementById('timeFilterLabel').textContent = 'All Time';
    document.getElementById('eventFilterLabel').textContent = 'All Events';
    document.getElementById('clientFilterLabel').textContent = 'All Clients';
    loadActivities(1);
}

function openEventPanel(id) {
    var row = document.querySelector('tr[data-id="' + id + '"]');
    if (!row) return;
    
    var activity = JSON.parse(row.dataset.activity);
    var metadata = activity.metadata || {};
    
    var panelBody = document.getElementById('panelBody');
    
    var html = '';
    
    // Status & Description
    html += '<div class="panel-section">';
    html += '<span class="event-badge badge-' + activity.color + '">' + activity.type_label + '</span>';
    html += '<div style="font-size: 0.9rem; font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">' + activity.description + '</div>';
    html += '</div>';
    
    // Info Grid
    html += '<div class="panel-section">';
    html += '<div class="panel-section-title">Information</div>';
    html += '<div class="panel-info-grid">';
    var logoHtml = activity.client_logo 
                    ? '<img src="' + activity.client_logo.light + '" alt="" width="16" height="16" class="icon-light" style="border-radius: 50%;"><img src="' + activity.client_logo.dark + '" alt="" width="16" height="16" class="icon-dark" style="border-radius: 50%;">'
                    : '<span class="client-badge" style="background:' + (activity.client_color || '#8b5cf6') + ';">' + (activity.client_initials || 'SA') + '</span>';
                html += '<div class="panel-info-item"><span class="panel-info-label">Client</span><span class="panel-info-value">' + logoHtml + ' ' + (activity.client_name || 'System') + '</span></div>';
    html += '<div class="panel-info-item"><span class="panel-info-label">IP Address</span><span class="panel-info-value">' + (activity.ip_address || '—') + '</span></div>';
    html += '<div class="panel-info-item"><span class="panel-info-label">Time</span><span class="panel-info-value">' + activity.time_ago + '</span></div>';
    html += '<div class="panel-info-item"><span class="panel-info-label">Event ID</span><span class="panel-info-value" style="font-family: monospace; font-size: 0.75rem;">' + id + '</span></div>';
    html += '</div>';
    html += '</div>';
    
    // Request Payload
    if (metadata.arguments) {
        html += '<div class="panel-section">';
        html += '<div class="panel-section-title">Request Payload</div>';
        html += '<div class="payload-block">';
        html += '<div class="payload-header">';
        html += '<span class="payload-title">Arguments</span>';
        html += '<button class="payload-copy" onclick="copyPayload(this)" data-payload=\'' + JSON.stringify(metadata.arguments) + '\'><i class="fas fa-copy"></i> Copy</button>';
        html += '</div>';
        html += '<pre class="payload-code">' + syntaxHighlight(JSON.stringify(metadata.arguments, null, 2)) + '</pre>';
        html += '</div>';
        html += '</div>';
    }
    
    // Response (if available)
    if (metadata.response) {
        html += '<div class="panel-section">';
        html += '<div class="panel-section-title">Response</div>';
        html += '<div class="payload-block">';
        html += '<div class="payload-header">';
        html += '<span class="payload-title">Result</span>';
        html += '<button class="payload-copy" onclick="copyPayload(this)" data-payload=\'' + JSON.stringify(metadata.response) + '\'><i class="fas fa-copy"></i> Copy</button>';
        html += '</div>';
        html += '<pre class="payload-code">' + syntaxHighlight(JSON.stringify(metadata.response, null, 2)) + '</pre>';
        html += '</div>';
        html += '</div>';
    }
    
    panelBody.innerHTML = html;
    document.getElementById('panelOverlay').classList.add('active');
}

function closeEventPanel(e) {
    if (e && e.target !== e.currentTarget) return;
    document.getElementById('panelOverlay').classList.remove('active');
}

function syntaxHighlight(json) {
    if (typeof json !== 'string') {
        json = JSON.stringify(json, null, 2);
    }
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
        var cls = 'number';
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'key';
            } else {
                cls = 'string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'bool';
        } else if (/null/.test(match)) {
            cls = 'null';
        }
        return '<span class="' + cls + '">' + match + '</span>';
    });
}

function copyPayload(btn) {
    var payload = btn.dataset.payload;
    navigator.clipboard.writeText(payload).then(function() {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied';
        setTimeout(function() { btn.innerHTML = original; }, 1500);
    });
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeEventPanel();
});
</script>
@endsection
