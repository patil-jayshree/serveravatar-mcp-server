@extends('layouts.app')

@section('title', 'Tools Library - ServerAvatar MCP')
@section('breadcrumb', 'Tools Library')

@section('styles')
<style>
.page-header a.loading { pointer-events: none; opacity: 0.7; }
.page-header a.loading .fa-sync-alt { animation: spin 0.6s linear infinite; }
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endsection

@php
$tools = $tools ?? [];
$categories = $categories ?? [];
$selectedCategory = $selectedCategory ?? '';
$searchQuery = $searchQuery ?? '';
$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? 1;
$totalTools = $totalTools ?? count($tools);
$perPage = $perPage ?? 10;
@endphp

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Tools Library <span class="tools-count-badge">{{ $totalTools }} Tools</span></h1>
    <p class="page-subtitle">Browse all MCP tools available in your ServerAvatar account</p>
</div>

<!-- Tools Controls -->
<div class="tools-controls">
    <form method="GET" action="{{ route('tools') }}" id="searchForm" style="display: flex; align-items: center; gap: 0.5rem; flex: 1;">
        <input type="hidden" name="category" value="{{ $selectedCategory }}">
        <div class="search-box" style="max-width: 320px; position: relative;">
            <span class="search-icon">🔍</span>
            <input type="text" name="q" class="search-input" placeholder="Search tools..." id="searchInput" value="{{ $searchQuery }}" autocomplete="off">
            @if(!empty($searchQuery))
            <a href="{{ route('tools', ['category' => $selectedCategory]) }}" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 18px; text-decoration: none;">×</a>
            @endif
        </div>
        <button type="submit" class="btn-card-action" style="display: inline-block; padding: 11px 16px; background: var(--accent-primary); color: white; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; border: none; cursor: pointer; white-space: nowrap; height: 44px;">Search</button>
    </form>
    
    <form method="GET" action="{{ route('tools') }}" id="filterForm" style="display: flex; align-items: center; gap: 0.5rem;">
        <div style="position: relative; display: flex; align-items: center;">
            <i class="fas fa-filter" style="position: absolute; left: 12px; color: var(--accent-primary); font-size: 12px; z-index: 1;"></i>
            <select name="category" onchange="document.getElementById('filterForm').submit();" autocomplete="off" style="padding: 11px 36px 11px 32px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 13px; font-weight: 500; cursor: pointer; appearance: none; -webkit-appearance: none; min-width: 160px; height: 44px;">
                <option value="" {{ empty($selectedCategory) ? 'selected' : '' }}>All Categories</option>
                @foreach($categories as $cat)
                @php
                $catDisplay = $cat === 'ApplicationDomain' ? 'Application Domain' : ($cat === 'ApplicationUser' ? 'Application User' : ($cat === 'DatabaseUser' ? 'Database User' : $cat));
                @endphp
                <option value="{{ $cat }}" {{ $selectedCategory === $cat ? 'selected' : '' }}>{{ $catDisplay }}</option>
                @endforeach
            </select>
            <i class="fas fa-chevron-down" style="position: absolute; right: 10px; color: var(--text-muted); font-size: 10px; pointer-events: none;"></i>
        </div>
    </form>
    
    <a href="{{ route('tools') }}" onclick="this.classList.add('loading'); setTimeout(function(){ window.location.href = '{{ route('tools') }}'; }, 50); return false;" style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 10px 14px; border-radius: var(--radius-md); cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; height: 44px;" title="Refresh">
        <i class="fas fa-sync-alt" style="color: var(--accent-primary);"></i>
    </a>
</div>

<!-- Tools Table -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div class="tools-table-wrap">
        <div class="tools-table">
            <div class="table-header">
                <div><span class="th-text">Tool Name</span></div>
                <div><span class="th-text">Category</span></div>
                <div><span class="th-text">Description</span></div>
                <div style="justify-content: center;"><span class="th-text-center">Status</span></div>
            </div>
            <div class="table-body" id="toolsTableBody">
                @forelse($tools as $tool)
                <div class="table-row">
                    <div class="tool-name-cell">
                        @php
                        $colors = ['#3b82f6', '#a855f7', '#22c55e', '#f59e0b', '#ef4444', '#0ea5e9', '#6366f1', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#06b6d4'];
                        $colorIndex = abs(crc32($tool['name'])) % count($colors);
                        $color = $colors[$colorIndex];
                        $r = hexdec(substr($color, 1, 2));
                        $g = hexdec(substr($color, 3, 2));
                        $b = hexdec(substr($color, 5, 2));
                        @endphp
                        <span style="width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.15); color: {{ $color }};">{{ $tool['icon'] }}</span>
                        <span class="tool-name-text">{{ Str::title(str_replace('_', ' ', $tool['name'])) }}</span>
                    </div>
                    <div>
                        <span class="category-badge" style="display: inline-flex; align-items: center; gap: 4px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">{{ $tool['category_badge'] }}</span>
                    </div>
                    <div class="tool-desc-cell"><span>{{ $tool['description'] }}</span></div>
                    <div class="tool-status-cell">
                        <span class="status-badge">
                            <span class="status-dot"></span>
                            {{ $tool['status'] }}
                        </span>
                    </div>
                </div>
                @empty
                <div style="padding: 3rem 1rem; text-align: center; color: var(--text-muted);">
                    <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p style="font-size: 16px; font-weight: 500; margin-bottom: 0.5rem;">No tools found</p>
                    <p style="font-size: 14px;">Try selecting a different category or clear the filter</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    @if($totalPages > 1)
    <div class="pagination">
        <div class="pagination-info">
            Showing {{ ($currentPage - 1) * $perPage + 1 }} to {{ min($currentPage * $perPage, $totalTools) }} of {{ $totalTools }} tools
        </div>
        <div class="pagination-buttons">
            @if($currentPage > 1)
            <a href="{{ route('tools') }}?page={{ $currentPage - 1 }}&q={{ urlencode($searchQuery) }}&category={{ urlencode($selectedCategory) }}" class="page-btn">
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
                <a href="{{ route('tools') }}?page=1&q={{ urlencode($searchQuery) }}&category={{ urlencode($selectedCategory) }}" class="page-btn">1</a>
                @if($start > 2)<span style="padding: 0 4px; color: var(--text-muted);">...</span>@endif
            @endif
            
            @for($i = $start; $i <= $end; $i++)
                @if($i == $currentPage)
                <span class="page-btn active">{{ $i }}</span>
                @else
                <a href="{{ route('tools') }}?page={{ $i }}&q={{ urlencode($searchQuery) }}&category={{ urlencode($selectedCategory) }}" class="page-btn">{{ $i }}</a>
                @endif
            @endfor
            
            @if($end < $totalPages)
                @if($end < $totalPages - 1)<span style="padding: 0 4px; color: var(--text-muted);">...</span>@endif
                <a href="{{ route('tools') }}?page={{ $totalPages }}&q={{ urlencode($searchQuery) }}&category={{ urlencode($selectedCategory) }}" class="page-btn">{{ $totalPages }}</a>
            @endif
            
            @if($currentPage < $totalPages)
            <a href="{{ route('tools') }}?page={{ $currentPage + 1 }}&q={{ urlencode($searchQuery) }}&category={{ urlencode($selectedCategory) }}" class="page-btn">
                Next <i class="fas fa-chevron-right"></i>
            </a>
            @else
            <span class="page-btn disabled">Next <i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit search on Enter
    var searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });
    }
});
</script>
@endsection