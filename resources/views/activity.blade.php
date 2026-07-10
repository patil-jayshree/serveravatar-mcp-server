@extends('layouts.app')

@section('title', 'Activity - ServerAvatar MCP')
@section('breadcrumb', 'Activity')

@php
$csrf = csrf_token();
@endphp

@section('styles')
.activity-loading { display: flex; align-items: center; justify-content: center; min-height: 150px; color: var(--text-secondary); }
.activity-loading i { font-size: 1.5rem; animation: spin 0.8s linear infinite; }
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between;">
    <div>
        <h1 class="page-title">Activity Log</h1>
        <p class="page-subtitle">Track all MCP events and account changes</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button onclick="loadActivities(1)" class="refresh-btn" title="Refresh" id="refreshBtn">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
</div>

<!-- Activity Table -->
<div class="card" style="padding: 0; margin-bottom: 1rem;">
    <div class="activity-table-header">
        <div class="activity-th" style="flex: 1;">EVENT</div>
        <div class="activity-th" style="flex: 1;">DESCRIPTION</div>
        <div class="activity-th" style="flex: 1;">CLIENT</div>
        <div class="activity-th" style="flex: 1;">IP ADDRESS</div>
        <div class="activity-th" style="flex: 1;">TIME</div>
    </div>
    
    <div class="activity-table-body" id="activityTableBody">
        @if($activities->count() > 0)
        @foreach($activities as $activity)
        <div class="activity-tr">
            <div class="activity-td" style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.1rem;">{!! $activity->icon !!}</span>
                    <span class="activity-type-badge badge-{{ $activity->color }}">{{ $activity->typeLabel }}</span>
                </div>
            </div>
            <div class="activity-td" style="flex: 1;">
                <span class="activity-desc">{{ $activity->description }}</span>
            </div>
            <div class="activity-td" style="flex: 1;">
                <span class="activity-client">{{ $activity->client_name ?? '—' }}</span>
            </div>
            <div class="activity-td" style="flex: 1;">
                <span class="activity-ip">{{ $activity->ip_address ?? '—' }}</span>
            </div>
            <div class="activity-td" style="flex: 1;">
                <span class="activity-time">{{ $activity->created_at->format('M d, Y') }}<br><span style="color: var(--text-muted); font-size: 12px;">{{ $activity->created_at->format('h:i A') }}</span></span>
            </div>
        </div>
        @endforeach
        @else
        <div style="text-align: center; padding: 3rem; color: var(--text-secondary);">
            <i class="fas fa-clock" style="font-size: 2rem; color: var(--accent-primary); margin-bottom: 0.5rem;"></i>
            <p style="font-size: 0.9rem;">No activity recorded yet.</p>
        </div>
        @endif
    </div>
    
    <div id="activityPagination" class="pagination" style="{{ $totalPages <= 1 ? 'display: none;' : '' }}">
        @if($totalPages > 1)
        <div class="pagination-info">
            Showing {{ ($currentPage - 1) * $perPage + 1 }} to {{ min($currentPage * $perPage, $totalActivities) }} of {{ $totalActivities }} activities
        </div>
        <div class="pagination-buttons">
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
        @endif
    </div>
</div>

<style>
.activity-table-header { display: flex; padding: 0.75rem 1rem; background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); gap: 2rem;}
.activity-th { font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; padding: 0 0.5rem; }
.activity-table-body { display: flex; flex-direction: column; }
.activity-tr { display: flex; align-items: center; padding: 0.5rem 1rem; border-bottom: 1px solid var(--border-color); transition: background 0.15s; gap: 2rem; }
.activity-tr:last-child { border-bottom: none; }
.activity-tr:hover { background: var(--bg-secondary); }
.activity-td { font-size: 0.875rem; color: var(--text-primary); padding: 0 0.5rem; display: flex; align-items: center; }
.activity-type-badge { font-size: 0.65rem; font-weight: 600; padding: 2px 8px; border-radius: 20px; text-transform: capitalize; letter-spacing: 0.03em; }
.activity-desc { font-weight: 500; }
.activity-client { color: var(--text-secondary); }
.activity-ip { color: var(--text-secondary); font-size: 0.8rem; }
.activity-time { font-size: 0.8rem; line-height: 1.4; }
.badge-success { background: rgba(22, 163, 74, 0.15); color: #16a34a; }
.badge-info { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
.badge-warning { background: rgba(245, 158, 11, 0.15); color: #d97706; }
.badge-danger { background: rgba(249, 115, 22, 0.15); color: #f97316; }
.badge-secondary { background: rgba(148, 163, 184, 0.15); color: #64748b; }
.badge-primary { background: rgba(139, 92, 246, 0.15); color: #8b5cf6; }
.badge-cyan { background: rgba(6, 182, 212, 0.15); color: #06b6d4; }
</style>
@endsection

@section('scripts')
<script>
var csrfToken = '{{ $csrf }}';
var currentPage = {{ $currentPage }};

function loadActivities(page) {
    var tbody = document.getElementById('activityTableBody');
    var pagination = document.getElementById('activityPagination');
    var refreshBtn = document.getElementById('refreshBtn');
    
    // Show loading
    tbody.innerHTML = '<div class="activity-loading"><i class="fas fa-spinner"></i></div>';
    
    // Add loading state to refresh button
    if (refreshBtn) {
        refreshBtn.classList.add('loading');
    }
    
    // Fetch data
    fetch('/activity/fetch?page=' + page, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            tbody.innerHTML = data.html || '<div style="text-align: center; padding: 3rem; color: var(--text-secondary);"><i class="fas fa-clock" style="font-size: 2rem; color: var(--accent-primary); margin-bottom: 0.5rem;"></i><p style="font-size: 0.9rem;">No activity recorded yet.</p></div>';
            
            // Update pagination
            if (data.totalPages > 1) {
                pagination.style.display = 'flex';
                pagination.innerHTML = '<div class="pagination-info">' +
                    'Showing ' + ((data.currentPage - 1) * 10 + 1) + ' to ' + Math.min(data.currentPage * 10, data.totalActivities) + ' of ' + data.totalActivities + ' activities' +
                    '</div><div class="pagination-buttons">' + data.pagination + '</div>';
            } else {
                pagination.style.display = 'none';
            }
            
            currentPage = data.currentPage;
        } else {
            tbody.innerHTML = '<div style="text-align: center; padding: 3rem; color: var(--text-secondary);"><i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i><p>Error loading activities</p></div>';
        }
        
        // Remove loading state
        if (refreshBtn) {
            refreshBtn.classList.remove('loading');
        }
    })
    .catch(function(err) {
        console.error('Error:', err);
        tbody.innerHTML = '<div style="text-align: center; padding: 3rem; color: var(--text-secondary);"><i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i><p>Network error. Please try again.</p></div>';
        if (refreshBtn) {
            refreshBtn.classList.remove('loading');
        }
    });
}
</script>
@endsection
