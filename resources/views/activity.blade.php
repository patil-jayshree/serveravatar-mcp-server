@extends('layouts.app')

@section('title', 'Activity - ServerAvatar MCP')
@section('breadcrumb', 'Activity')

@section('styles')
.refresh-btn.loading .fa-sync-alt { animation: spin 0.6s linear infinite; }
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between;">
    <div>
        <h1 class="page-title">Activity Log</h1>
        <p class="page-subtitle">Track all MCP events and account changes</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('activity') }}" onclick="this.classList.add('loading'); setTimeout(function(){ window.location.href = '{{ route('activity') }}'; }, 50); return false;" class="refresh-btn" title="Refresh" style="margin-top: 0.25rem;">
            <i class="fas fa-sync-alt"></i>
        </a>
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
    
    @if($activities->count() > 0)
    <div class="activity-table-body">
        @foreach($activities as $activity)
        <div class="activity-tr">
            <div class="activity-td" style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.1rem;">{{ $activity->icon }}</span>
                    <span class="activity-type-badge badge-{{ $activity->badge }}">{{ ucfirst(str_replace('_', ' ', $activity->type)) }}</span>
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
    </div>
    
    <!-- Pagination -->
    @if($activities->hasPages())
    <div style="padding: 1rem; display: flex; justify-content: center; gap: 0.5rem; border-top: 1px solid var(--border-color);">
        @if($activities->onFirstPage())
            <span class="page-btn disabled" style="opacity: 0.5; cursor: not-allowed;">← Previous</span>
        @else
            <a href="{{ $activities->previousPageUrl() }}" class="page-btn">← Previous</a>
        @endif
        
        <span class="page-info" style="padding: 0.375rem 0.75rem; font-size: 0.8rem; color: var(--text-secondary);">
            Page {{ $activities->currentPage() }} of {{ $activities->lastPage() }}
        </span>
        
        @if($activities->hasMorePages())
            <a href="{{ $activities->nextPageUrl() }}" class="page-btn">Next →</a>
        @else
            <span class="page-btn disabled" style="opacity: 0.5; cursor: not-allowed;">Next →</span>
        @endif
    </div>
    @endif
    
    @else
    <div style="text-align: center; padding: 3rem; color: var(--text-secondary);">
        <i class="fas fa-clock" style="font-size: 2rem; color: var(--accent-primary); margin-bottom: 0.5rem;"></i>
        <p style="font-size: 0.9rem;">No activity recorded yet.</p>
    </div>
    @endif
</div>

<style>
.activity-table-header { display: flex; padding: 0.75rem 1rem; background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); }
.activity-th { font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; padding: 0 0.5rem; }
.activity-table-body { }
.activity-tr { display: flex; align-items: center; padding: 0.875rem 1rem; border-bottom: 1px solid var(--border-color); transition: background 0.15s; }
.activity-tr:last-child { border-bottom: none; }
.activity-tr:hover { background: var(--bg-secondary); }
.activity-td { font-size: 0.875rem; color: var(--text-primary); padding: 0 0.5rem; display: flex; align-items: center; }
.activity-type-badge { font-size: 0.65rem; font-weight: 600; padding: 2px 8px; border-radius: 20px; text-transform: capitalize; letter-spacing: 0.03em; }
.activity-desc { font-weight: 500; }
.activity-client { color: var(--text-secondary); }
.activity-ip { color: var(--text-secondary); font-size: 0.8rem; }
.activity-time { font-size: 0.8rem; line-height: 1.4; }
.page-btn { padding: 0.375rem 0.75rem; font-size: 0.8rem; font-weight: 500; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-sm); color: var(--accent-primary); text-decoration: none; transition: all 0.15s; }
.page-btn:hover { background: var(--accent-primary); color: white; border-color: var(--accent-primary); }
.badge-success { background: rgba(22, 163, 74, 0.15); color: #16a34a; }
.badge-info { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
.badge-warning { background: rgba(245, 158, 11, 0.15); color: #d97706; }
.badge-danger { background: rgba(220, 38, 38, 0.15); color: #dc2626; }
.badge-secondary { background: rgba(148, 163, 184, 0.15); color: #64748b; }
</style>
@endsection
