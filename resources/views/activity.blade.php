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
.filter-search input { width: 100%; padding: 10px 36px 10px 36px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; transition: border-color 0.2s; }
.filter-search .clear-search { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 14px; cursor: pointer; display: none; z-index: 2; }
.filter-search .clear-search:hover { color: var(--accent-primary); }
.filter-search .clear-search.show { display: block; }
.filter-search input:focus { outline: none; border-color: var(--accent-primary); }
.filter-search input::placeholder { color: #9ca3af; }
.filter-select { position: relative; display: flex; align-items: center; gap: 8px; padding: 10px 32px 10px 12px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; cursor: pointer; appearance: none; min-width: 140px; transition: border-color 0.2s, box-shadow 0.2s; }
.filter-select:hover { border-color: var(--border-color-hover); }
.filter-select i { color: var(--text-muted); font-size: 12px; }
.filter-select select { position: absolute; left: 0; top: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }

/* Custom Dropdown - replaces native select */
.filter-dropdown { position: absolute; top: calc(100% + 4px); left: 0; min-width: 100%; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; box-shadow: var(--shadow-lg); z-index: 1000; opacity: 0; visibility: hidden; transform: translateY(-8px); transition: all 0.2s ease; max-height: 280px; overflow-y: auto; }
.filter-dropdown.active { opacity: 1; visibility: visible; transform: translateY(0); }
.filter-dropdown-item { padding: 10px 14px; font-size: 0.85rem; color: var(--text-primary); cursor: pointer; transition: background 0.15s; white-space: nowrap; }
.filter-dropdown-item:hover { background: var(--bg-secondary); }
.filter-dropdown-item.selected { background: var(--accent-primary-muted); color: var(--accent-primary); font-weight: 500; }
.filter-dropdown-item:first-child { border-radius: 7px 7px 0 0; }
.filter-dropdown-item:last-child { border-radius: 0 0 7px 7px; }
.filter-clear { display: flex; align-items: center; gap: 6px; padding: 10px 16px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 0.85rem; cursor: pointer; transition: all 0.2s; white-space: nowrap; }
.filter-clear:hover { border-color: var(--accent-primary); color: var(--accent-primary); }
.filter-clear i { color: var(--text-muted); transition: color 0.2s; }
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
.event-info { display: flex; flex-direction: column; gap: 8px; }
.event-desc { font-size: 0.875rem; font-weight: 600; color: var(--text-primary); }
.event-badge { display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 0.6rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; white-space: nowrap; max-width: fit-content; }
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
.time-cell { display: flex; flex-direction: column; gap: 8px; }
.time-relative { font-size: 0.85rem; font-weight: 500; color: var(--text-primary); }
.time-absolute { font-size: 0.7rem; color: var(--text-muted); }
.actions-cell { text-align: left; }
.view-btn { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: transparent; border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--accent-primary); font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.view-btn:hover { background: var(--accent-primary); border-color: var(--accent-primary); color: white; }
.no-actions { color: var(--text-muted); font-size: 0.85rem; }
.activity-loading { display: flex; align-items: center; justify-content: center; min-height: 200px; color: var(--text-primary); }
.activity-loading i { font-size: 1.5rem; animation: spin 0.8s linear infinite; }
.activity-empty { text-align: center; padding: 4rem 2rem; color: var(--text-primary); }
.activity-empty i { font-size: 3rem; color: var(--accent-primary); opacity: 0.5; margin-bottom: 1rem; }
.activity-empty p { font-size: 0.9rem; }

/* Slide-out Panel */
.panel-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 999; opacity: 0; visibility: hidden; transition: all 0.3s; }
.panel-overlay.active { opacity: 1; visibility: visible; }
.event-panel { position: fixed; top: 0; right: 0; width: 400px; max-width: 100%; height: 100%; background: var(--bg-card); box-shadow: -4px 0 20px rgba(0,0,0,0.15); z-index: 1000; transform: translateX(100%); transition: transform 0.3s ease; display: flex; flex-direction: column; overflow: hidden; }
.panel-overlay.active .event-panel { transform: translateX(0); }
.panel-header { padding: 12px 20px; position: sticky; top: 0; background: var(--bg-card); border-bottom: 1px solid var(--border-color); }
.panel-header-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
.panel-title { display: flex; align-items: center; gap: 8px; font-size: 0.9rem; font-weight: 700; color: var(--text-primary); }
.panel-title i { color: #3b82f6; }
.panel-badge { display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 0.6rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; white-space: nowrap; max-width: fit-content; background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
.panel-badge.badge-success { background: rgba(22, 163, 74, 0.1); color: #16a34a; }
.panel-badge.badge-warning { background: rgba(245, 158, 11, 0.1); color: #d97706; }
.panel-badge.badge-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
.panel-badge.badge-primary { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
.panel-badge.badge-cyan { background: rgba(6, 182, 212, 0.1); color: #06b6d4; }
.panel-header-content { display: flex; flex-direction: column; gap: 8px; }
.panel-desc { font-size: 0.85rem; color: var(--text-primary); }
.panel-close { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: transparent; border: none; border-radius: 8px; color: var(--text-muted); cursor: pointer; font-size: 1.25rem; transition: all 0.2s; }
.panel-close:hover { background: var(--bg-secondary); color: var(--text-primary); }
.panel-body { padding: 12px 20px; flex: 1; overflow-y: auto; }
.panel-section { margin-bottom: 20px; }
.panel-section:last-child { margin-bottom: 0; }
.panel-section-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 10px; }
.panel-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.panel-info-item { display: flex; flex-direction: column; gap: 8px; }
.panel-info-label { font-size: 0.7rem; color: var(--text-muted); }
.panel-info-value { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 6px; }
.panel-info-value .client-badge { width: 20px; height: 20px; border-radius: 50%; font-size: 0.5rem; display: flex; align-items: center; justify-content: center; }

/* Info Rows */
.info-rows { display: flex; flex-direction: column; gap: 0; margin: 0 -20px; padding: 0 20px; border-bottom: 1px solid var(--border-color); }
.info-row { display: flex; align-items: center; gap: 12px; padding: 10px 0; }
.info-row:last-child { border-bottom: none; }
.info-row i { font-size: 0.85rem; }
.info-row-content { flex: 1; }
.info-row-label { font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 2px; }
.info-row-value { font-size: 0.85rem; color: var(--text-primary); display: flex; align-items: center; gap: 6px; }
.info-row-value .client-badge { width: 18px; height: 18px; border-radius: 50%; font-size: 0.45rem; font-weight: 700; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; }
.client-logo-wrapper { margin-left: auto; display: flex; align-items: center; }
.client-logo-wrapper img { width: 24px; height: 24px; }
.client-logo-wrapper .client-badge { width: 24px; height: 24px; border-radius: 50%; font-size: 0.5rem; font-weight: 700; display: flex; align-items: center; justify-content: center; color: white; }
.payload-block { background: #1e1e1e; border-radius: 8px; padding: 12px; position: relative; }
.payload-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #333; }
.payload-title { font-size: 0.7rem; font-weight: 600; color: #e0e0e0; text-transform: uppercase; letter-spacing: 0.03em; }
.payload-copy { background: #333; border: none; border-radius: 4px; padding: 4px 10px; font-size: 0.65rem; color: #a0a0a0; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.2s; }
.payload-copy:hover { background: #444; color: #fff; }

/* Additional Info */
.additional-info-header { display: flex; align-items: center; gap: 8px; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.02em; margin-bottom: 12px; }
.additional-info-divider { height: 1px; background: var(--border-color); margin: 16px -20px; }
.additional-info-list { display: flex; flex-direction: column; gap: 0; }
.additional-info-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; }
.additional-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.additional-info-label { font-size: 0.7rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.03em; }
.additional-info-value { font-size: 0.8rem; color: var(--text-primary); font-weight: 500; }
.payload-code-wrapper { display: flex; gap: 12px; }
.payload-line-numbers { font-family: 'SF Mono', Monaco, monospace; font-size: 0.75rem; line-height: 1.6; color: #555; text-align: right; user-select: none; min-width: 24px; }
.payload-code { font-family: 'SF Mono', Monaco, monospace; font-size: 0.75rem; line-height: 1.6; color: #d4d4d4; white-space: pre-wrap; word-break: break-word; max-height: 400px; overflow-y: auto; flex: 1; }
.payload-code .key { color: #9cdcfe; }
.payload-code .string { color: #ce9178; }
.payload-code .number { color: #b5cea8; }
.payload-code .bool { color: #569cd6; }
.payload-code .null { color: #569cd6; }
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
.pagination-buttons { display: flex; align-items: center; gap: 8px; }
.page-btn { display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 8px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-sm); color: var(--text-primary); font-size: 0.8rem; cursor: pointer; transition: all 0.2s; text-decoration: none; }
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
    <div class="filter-select" onclick="toggleDropdown('time')" id="timeFilterWrapper">
        <i class="fas fa-calendar"></i>
        <span id="timeFilterLabel">{{ $timeFilter == 'today' ? 'Today' : ($timeFilter == '7days' ? 'Last 7 Days' : ($timeFilter == '30days' ? 'Last 30 Days' : ($timeFilter == '90days' ? 'Last 90 Days' : 'All Time'))) }}</span>
        <i class="fas fa-chevron-down" style="position: absolute; right: 10px; color: var(--text-muted); font-size: 10px; pointer-events: none;"></i>
        <div class="filter-dropdown" id="timeDropdown">
            <div class="filter-dropdown-item" data-value="" onclick="selectOption('time', '', 'All Time', event)">All Time</div>
            <div class="filter-dropdown-item" data-value="today" onclick="selectOption('time', 'today', 'Today', event)">Today</div>
            <div class="filter-dropdown-item" data-value="7days" onclick="selectOption('time', '7days', 'Last 7 Days', event)">Last 7 Days</div>
            <div class="filter-dropdown-item" data-value="30days" onclick="selectOption('time', '30days', 'Last 30 Days', event)">Last 30 Days</div>
            <div class="filter-dropdown-item" data-value="90days" onclick="selectOption('time', '90days', 'Last 90 Days', event)">Last 90 Days</div>
        </div>
    </div>
    <div class="filter-select" onclick="toggleDropdown('event')" id="eventFilterWrapper">
        <i class="fas fa-filter"></i>
        <span id="eventFilterLabel">All Events</span>
        <i class="fas fa-chevron-down" style="position: absolute; right: 10px; color: var(--text-muted); font-size: 10px; pointer-events: none;"></i>
        <div class="filter-dropdown" id="eventDropdown">
            <div class="filter-dropdown-item" data-value="" onclick="selectOption('event', '', 'All Events', event)">All Events</div>
            <div class="filter-dropdown-item" data-value="tool_executed" onclick="selectOption('event', 'tool_executed', 'Tool Executed', event)">Tool Executed (All)</div>
            <div class="filter-dropdown-item" data-value="tool_executed_success" onclick="selectOption('event', 'tool_executed_success', 'Tool Executed - Success', event)">Tool Executed - Success</div>
            <div class="filter-dropdown-item" data-value="tool_executed_failed" onclick="selectOption('event', 'tool_executed_failed', 'Tool Executed - Failed', event)">Tool Executed - Failed</div>
            <div class="filter-dropdown-item" data-value="client_connected" onclick="selectOption('event', 'client_connected', 'Client Connected', event)">Client Connected</div>
            <div class="filter-dropdown-item" data-value="api_key_saved" onclick="selectOption('event', 'api_key_saved', 'API Key Saved', event)">API Key Saved</div>
            <div class="filter-dropdown-item" data-value="api_key_updated" onclick="selectOption('event', 'api_key_updated', 'API Key Updated', event)">API Key Updated</div>
            <div class="filter-dropdown-item" data-value="password_changed" onclick="selectOption('event', 'password_changed', 'Password Changed', event)">Password Changed</div>
            <div class="filter-dropdown-item" data-value="profile_updated" onclick="selectOption('event', 'profile_updated', 'Profile Updated', event)">Profile Updated</div>
        </div>
    </div>
    <div class="filter-select" onclick="toggleDropdown('client')" id="clientFilterWrapper">
        <i class="fas fa-user"></i>
        <span id="clientFilterLabel">All Clients</span>
        <i class="fas fa-chevron-down" style="position: absolute; right: 10px; color: var(--text-muted); font-size: 10px; pointer-events: none;"></i>
        <div class="filter-dropdown" id="clientDropdown">
            <div class="filter-dropdown-item" data-value="" onclick="selectOption('client', '', 'All Clients', event)">All Clients</div>
            @if(isset($clients) && $clients->count() > 0)
                @foreach($clients as $client)
                    <div class="filter-dropdown-item" data-value="{{ $client }}" onclick="selectOption('client', '{{ $client }}', '{{ $client }}', event)">{{ $client }}</div>
                @endforeach
            @endif
        </div>
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
                            <span class="event-badge badge-{{ $activity->color }}">{{ $activity->badge }}</span>
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
                            <div class="client-avatar" style="background: {{ $activity->type === 'api_key_updated' ? 'rgba(245, 158, 11, 0.2)' : ($activity->type === 'profile_updated' ? 'rgba(6, 182, 212, 0.2)' : ($activity->client_color ?? '#8b5cf6')) }};">
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
                <a href="javascript:void(0)" onclick="loadActivities({{ $currentPage - 1 }})" class="page-btn">
                    <i class="fas fa-chevron-left"></i> Previous
                </a>
            @else
                <span class="page-btn disabled"><i class="fas fa-chevron-left"></i> Previous</span>
            @endif
            
            @php
                $start = max(1, $currentPage - 1);
                $end = min($totalPages, $start + 2);
                if ($end - $start < 2) { $start = max(1, $end - 2); }
            @endphp
            
            @if($start > 1)
                <a href="javascript:void(0)" onclick="loadActivities(1)" class="page-btn">1</a>
                @if($start > 2)<span style="padding: 0 4px; color: var(--text-muted);">...</span>@endif
            @endif
            
            @for($i = $start; $i <= $end; $i++)
                @if($i == $currentPage)
                    <span class="page-btn active">{{ $i }}</span>
                @else
                    <a href="javascript:void(0)" onclick="loadActivities({{ $i }})" class="page-btn">{{ $i }}</a>
                @endif
            @endfor
            
            @if($end < $totalPages)
                @if($end < $totalPages - 1)<span style="padding: 0 4px; color: var(--text-muted);">...</span>@endif
                <a href="javascript:void(0)" onclick="loadActivities({{ $totalPages }})" class="page-btn">{{ $totalPages }}</a>
            @endif
            
            @if($currentPage < $totalPages)
                <a href="javascript:void(0)" onclick="loadActivities({{ $currentPage + 1 }})" class="page-btn">
                    Next <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="page-btn disabled">Next <i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Event Details Panel -->
<div class="panel-overlay" id="panelOverlay" onclick="closeEventPanel(event)">
    <div class="event-panel" onclick="event.stopPropagation()">
        <div class="panel-header" id="panelHeader">
            <div class="panel-header-top">
                <div class="panel-title">
                    <i class="fas fa-screwdriver-wrench" style="color: #3b82f6;"></i>
                    <span>Event Details</span>
                </div>
                <button class="panel-close" onclick="closeEventPanel()">&times;</button>
            </div>
            <div class="panel-header-content">
                <span class="panel-badge" id="panelBadge">EXECUTED</span>
                <div class="panel-desc" id="panelDesc">Event Details</div>
            </div>
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
        btns += '<a href="javascript:void(0)" onclick="loadActivities(' + (data.currentPage - 1) + ')" class="page-btn"><i class="fas fa-chevron-left"></i> Previous</a>';
    } else {
        btns += '<span class="page-btn disabled"><i class="fas fa-chevron-left"></i> Previous</span>';
    }
    
    var start = Math.max(1, data.currentPage - 1);
    var end = Math.min(data.totalPages, start + 2);
    if (end - start < 2) start = Math.max(1, end - 2);
    
    if (start > 1) {
        btns += '<a href="javascript:void(0)" onclick="loadActivities(1)" class="page-btn">1</a>';
        if (start > 2) btns += '<span style="padding: 0 4px; color: var(--text-muted);">...</span>';
    }
    
    for (var i = start; i <= end; i++) {
        if (i == data.currentPage) {
            btns += '<span class="page-btn active">' + i + '</span>';
        } else {
            btns += '<a href="javascript:void(0)" onclick="loadActivities(' + i + ')" class="page-btn">' + i + '</a>';
        }
    }
    
    if (end < data.totalPages) {
        if (end < data.totalPages - 1) btns += '<span style="padding: 0 4px; color: var(--text-muted);">...</span>';
        btns += '<a href="javascript:void(0)" onclick="loadActivities(' + data.totalPages + ')" class="page-btn">' + data.totalPages + '</a>';
    }
    
    if (data.currentPage < data.totalPages) {
        btns += '<a href="javascript:void(0)" onclick="loadActivities(' + (data.currentPage + 1) + ')" class="page-btn">Next <i class="fas fa-chevron-right"></i></a>';
    } else {
        btns += '<span class="page-btn disabled">Next <i class="fas fa-chevron-right"></i></span>';
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

// Custom Dropdown Functions
function toggleDropdown(filterType) {
    event.stopPropagation();
    var dropdown = document.getElementById(filterType + 'Dropdown');
    var wasActive = dropdown.classList.contains('active');
    
    // Close all dropdowns first
    document.querySelectorAll('.filter-dropdown').forEach(function(d) {
        d.classList.remove('active');
    });
    
    // Toggle this dropdown
    if (!wasActive) {
        // Mark selected item based on current filter
        var currentValue = currentFilters[filterType];
        dropdown.querySelectorAll('.filter-dropdown-item').forEach(function(item) {
            item.classList.remove('selected');
            if (item.getAttribute('data-value') === currentValue) {
                item.classList.add('selected');
            }
        });
        dropdown.classList.add('active');
    }
}

function selectOption(filterType, value, label, e) {
    e.stopPropagation();
    
    // Update current filter
    currentFilters[filterType] = value;
    
    // Update label
    document.getElementById(filterType + 'FilterLabel').textContent = label;
    
    // Update selected state in dropdown
    var dropdown = document.getElementById(filterType + 'Dropdown');
    dropdown.querySelectorAll('.filter-dropdown-item').forEach(function(item) {
        item.classList.remove('selected');
    });
    e.target.classList.add('selected');
    
    // Close dropdown
    dropdown.classList.remove('active');
    
    // Reload activities
    loadActivities(1);
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-select')) {
        document.querySelectorAll('.filter-dropdown').forEach(function(d) {
            d.classList.remove('active');
        });
    }
});

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



function clearFilters() {
    currentFilters = { search: '', time: '', event: '', client: '' };
    document.getElementById('searchInput').value = '';
    document.getElementById('timeFilterLabel').textContent = 'All Time';
    document.getElementById('eventFilterLabel').textContent = 'All Events';
    document.getElementById('clientFilterLabel').textContent = 'All Clients';
    
    // Remove selected class from all dropdown items
    document.querySelectorAll('.filter-dropdown-item').forEach(function(item) {
        item.classList.remove('selected');
    });
    
    // Close any open dropdowns
    document.querySelectorAll('.filter-dropdown').forEach(function(d) {
        d.classList.remove('active');
    });
    
    loadActivities(1);
}

function openEventPanel(id) {
    var row = document.querySelector('tr[data-id="' + id + '"]');
    if (!row) return;
    
    var activity = JSON.parse(row.dataset.activity);
    var metadata = activity.metadata || {};
    
    var panelBody = document.getElementById('panelBody');
    var panelBadge = document.getElementById('panelBadge');
    var panelDesc = document.getElementById('panelDesc');
    
    // Set badge and description in header
    panelBadge.textContent = activity.type_label || 'EXECUTED';
    panelBadge.className = 'panel-badge badge-' + (activity.color || 'primary');
    panelDesc.textContent = activity.description || '';
    
    var html = '';
    
    // Info Rows
    html += '<div class="info-rows">';
    
    // Client row
    var logoHtml = activity.client_logo 
                    ? '<img src="' + activity.client_logo.light + '" alt="" width="24" height="24" class="icon-light"><img src="' + activity.client_logo.dark + '" alt="" width="24" height="24" class="icon-dark">'
                    : '<span class="client-badge" style="background:' + (activity.client_color || '#8b5cf6') + ';">' + (activity.client_initials || 'SA') + '</span>';
    html += '<div class="info-row client-info-row">';
    html += '<i class="fas fa-user" style="color: #6b7280; width: 20px;"></i>';
    html += '<div class="info-row-content">';
    html += '<div class="info-row-label">Client</div>';
    html += '<div class="info-row-value">' + (activity.client_name || 'System') + '</div>';
    html += '</div>';
    html += '<div class="client-logo-wrapper">' + logoHtml + '</div>';
    html += '</div>';
    
    // IP Address row
    html += '<div class="info-row">';
    html += '<i class="fas fa-map-marker-alt" style="color: #6b7280; width: 20px;"></i>';
    html += '<div class="info-row-content">';
    html += '<div class="info-row-label">IP Address</div>';
    html += '<div class="info-row-value">' + (activity.ip_address || '—') + '</div>';
    html += '</div>';
    html += '</div>';
    
    // Time row
    html += '<div class="info-row">';
    html += '<i class="fas fa-clock" style="color: #6b7280; width: 20px;"></i>';
    html += '<div class="info-row-content">';
    html += '<div class="info-row-label">Time</div>';
    html += '<div class="info-row-value" style="flex-direction: column; align-items: flex-start; gap: 2px;">';
    html += '<span>' + activity.formatted_date + '</span>';
    html += '<span style="font-size: 0.75rem; color: var(--text-muted); font-weight: normal;">' + activity.time_ago + '</span>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    
    html += '</div>';
    
    // Request Payload
    if (metadata.arguments) {
        html += '<div class="panel-section" style="margin-top: 16px;">';
        html += '<div class="payload-block">';
        html += '<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">';
        html += '<div style="display: flex; align-items: center; gap: 8px;"><span style="font-size: 0.85rem; color: #6b7280;">{ }</span><span style="font-size: 0.7rem; font-weight: 600; color: #e0e0e0; text-transform: uppercase; letter-spacing: 0.02em;">REQUEST PAYLOAD</span></div>';
        html += '<button class="payload-copy" onclick="copyPayload(this)" data-payload="' + JSON.stringify(metadata.arguments).replace(/'/g, "&#39;") + '"><i class="fas fa-copy"></i> Copy</button>';
        html += '</div>';
        var argsJson = JSON.stringify(metadata.arguments, null, 2);
        html += '<div class="payload-code-wrapper"><pre class="payload-code" style="white-space: pre-wrap; overflow-x: auto;">' + syntaxHighlight(argsJson) + '</pre></div>';
        html += '</div>';
        html += '</div>';
    }
    
    // Response (if available)
    if (metadata.response) {
        html += '<div class="panel-section" style="margin-top: 16px;">';
        html += '<div class="payload-block">';
        html += '<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">';
        html += '<div style="display: flex; align-items: center; gap: 8px;"><span style="font-size: 0.85rem; color: #6b7280;">{ }</span><span style="font-size: 0.7rem; font-weight: 600; color: #e0e0e0; text-transform: uppercase; letter-spacing: 0.02em;">RESPONSE</span></div>';
        html += '<button class="payload-copy" onclick="copyPayload(this)" data-payload="' + JSON.stringify(metadata.response).replace(/'/g, "&#39;") + '"><i class="fas fa-copy"></i> Copy</button>';
        html += '</div>';
        var respJson = JSON.stringify(metadata.response, null, 2);
        var respLines = respJson.split('\n');
        var respLineNums = '';
        var respLineText = '';
        for (var i = 0; i < respLines.length; i++) { respLineNums += (i + 1) + '\n'; respLineText += respLines[i] + (i < respLines.length - 1 ? '\n' : ''); }
        html += '<div class="payload-code-wrapper"><pre class="payload-code" style="white-space: pre-wrap; overflow-x: auto;">' + syntaxHighlight(respJson) + '</pre></div>';
        html += '</div>';
        html += '</div>';
    }
    
    // Additional Info
    html += '<div class="additional-info-divider"></div>';
    html += '<div class="panel-section" style="margin-top: 16px;">';
    html += '<div class="additional-info-header"><i class="fas fa-info-circle" style="color: #6b7280;"></i><span>Additional Info</span></div>';
    html += '<div class="additional-info-list">';
    var userAgent = metadata.user_agent || 'N/A';
    // Status
    var isSuccess = metadata.success !== false;
    var statusBadge = isSuccess 
        ? '<span style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 2px 8px; border-radius: 12px; font-size: 0.65rem; font-weight: 600;">SUCCESS</span>' 
        : '<span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 2px 8px; border-radius: 12px; font-size: 0.65rem; font-weight: 600;">FAILED</span>';
    html += '<div class="additional-info-row"><span class="additional-info-label">Status</span>' + statusBadge + '</div>';
    html += '<div class="additional-info-row"><span class="additional-info-label">User Agent</span><span class="additional-info-value" style="font-size: 0.7rem; word-break: break-all; max-width: 200px;">' + userAgent + '</span></div>';
    html += '<div class="additional-info-row"><span class="additional-info-label">Platform</span><span class="additional-info-value">Web</span></div>';
    html += '<div class="additional-info-row"><span class="additional-info-label">Source</span><span class="additional-info-value">MCP Server</span></div>';
    html += '</div>';
    html += '</div>';
    
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
