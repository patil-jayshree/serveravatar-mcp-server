@extends('layouts.app')

@section('title', 'Tools Library - ServerAvatar MCP')
@section('breadcrumb', 'Tools Library')

@php
$csrf = csrf_token();
$tools = $tools ?? [];
$categories = $categories ?? [];
$selectedCategory = $selectedCategory ?? '';
$searchQuery = $searchQuery ?? '';
$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? 1;
$totalTools = $totalTools ?? count($tools);
$perPage = $perPage ?? 10;
@endphp

@section('styles')
.table-body { min-height: 150px; }
.tools-loading { display: flex; align-items: center; justify-content: center; min-height: 150px; color: var(--text-secondary); }
.tools-loading i { font-size: 1.5rem; animation: spin 0.8s linear infinite; }
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Tools Library <span class="tools-count-badge" id="toolsCount">{{ $totalTools }} Tools</span></h1>
    <p class="page-subtitle">Browse all MCP tools available in your ServerAvatar account</p>
</div>

<!-- Tools Controls -->
<div class="tools-controls">
    <form onsubmit="return false;" id="searchForm" style="display: flex; align-items: center; gap: 0.5rem; flex: 1;">
        <input type="hidden" name="category" id="searchCategory" value="{{ $selectedCategory }}">
        <div class="search-box" style="max-width: 320px; position: relative;">
            <span class="search-icon">🔍</span>
            <input type="text" name="q" class="search-input" placeholder="Search tools..." id="searchInput" value="{{ $searchQuery }}" autocomplete="off">
            <a href="javascript:void(0)" id="clearSearchBtn" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 16px; text-decoration: none; display: {{ empty($searchQuery) ? 'none' : 'flex' }}; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 50%; background: var(--border-color); transition: all 0.2s;" title="Clear search" onmouseover="this.style.background='var(--text-muted)'; this.style.color='var(--bg-primary)'" onmouseout="this.style.background='var(--border-color)'; this.style.color='var(--text-muted)'">×</a>
        </div>
        <button type="button" onclick="performSearch()" class="btn-card-action" style="display: inline-block; padding: 11px 16px; background: var(--accent-primary); color: white; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; border: none; cursor: pointer; white-space: nowrap; height: 44px;">Search</button>
    </form>
    
    <form onsubmit="return false;" id="filterForm" style="display: flex; align-items: center; gap: 0.5rem;">
        <div style="position: relative; display: flex; align-items: center;">
            <i class="fas fa-filter" style="position: absolute; left: 12px; color: var(--accent-primary); font-size: 12px; z-index: 1;"></i>
            <select name="category" id="categorySelect" autocomplete="off" onchange="performFilter()" style="padding: 11px 36px 11px 32px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 13px; font-weight: 500; cursor: pointer; appearance: none; -webkit-appearance: none; min-width: 160px; height: 44px;">
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
    
    <button onclick="loadTools(1)" class="refresh-btn" title="Refresh" id="refreshBtn">
        <i class="fas fa-sync-alt"></i>
    </button>
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
                    <div class="tool-desc-cell"><span title="{{ $tool['description'] }}">{{ $tool['description'] }}</span></div>
                    <div class="tool-status-cell">
                        <span class="status-badge">
                            <span class="status-dot"></span>
                            {{ $tool['status'] }}
                        </span>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                    <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p style="font-size: 16px; font-weight: 500; margin-bottom: 0.5rem;">No tools found</p>
                    <p style="font-size: 14px;">Try selecting a different category or clear the filter</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div id="toolsPagination" class="pagination" style="{{ $totalPages <= 1 ? 'display: none;' : '' }}">
        @if($totalPages > 1)
        <div class="pagination-info">
            Showing {{ ($currentPage - 1) * $perPage + 1 }} to {{ min($currentPage * $perPage, $totalTools) }} of {{ $totalTools }} tools
        </div>
        <div class="pagination-buttons">
            @if($currentPage > 1)
            <a href="javascript:void(0)" onclick="loadTools({{ $currentPage - 1 }})" class="page-btn">
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
                <a href="javascript:void(0)" onclick="loadTools(1)" class="page-btn">1</a>
                @if($start > 2)<span style="padding: 0 4px; color: var(--text-muted);">...</span>@endif
            @endif
            
            @for($i = $start; $i <= $end; $i++)
                @if($i == $currentPage)
                <span class="page-btn active">{{ $i }}</span>
                @else
                <a href="javascript:void(0)" onclick="loadTools({{ $i }})" class="page-btn">{{ $i }}</a>
                @endif
            @endfor
            
            @if($end < $totalPages)
                @if($end < $totalPages - 1)<span style="padding: 0 4px; color: var(--text-muted);">...</span>@endif
                <a href="javascript:void(0)" onclick="loadTools({{ $totalPages }})" class="page-btn">{{ $totalPages }}</a>
            @endif
            
            @if($currentPage < $totalPages)
            <a href="javascript:void(0)" onclick="loadTools({{ $currentPage + 1 }})" class="page-btn">
                Next <i class="fas fa-chevron-right"></i>
            </a>
            @else
            <span class="page-btn disabled">Next <i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
var csrfToken = '{{ $csrf }}';
var currentSearch = '{{ $searchQuery }}';
var currentCategory = '{{ $selectedCategory }}';

function loadTools(page) {
    var tbody = document.getElementById('toolsTableBody');
    var pagination = document.getElementById('toolsPagination');
    var countBadge = document.getElementById('toolsCount');
    var refreshBtn = document.getElementById('refreshBtn');
    
    // Show loading
    tbody.innerHTML = '<div class="tools-loading"><i class="fas fa-spinner"></i></div>';
    
    // Add loading state to refresh button
    if (refreshBtn) {
        refreshBtn.classList.add('loading');
    }
    
    // Build URL with params
    var url = '/tools/fetch?page=' + page;
    if (currentSearch) {
        url += '&q=' + encodeURIComponent(currentSearch);
    }
    if (currentCategory) {
        url += '&category=' + encodeURIComponent(currentCategory);
    }
    
    // Fetch data
    fetch(url, {
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
            countBadge.textContent = data.totalTools + ' Tools';
            currentSearch = data.searchQuery;
            currentCategory = data.selectedCategory;
            
            // Update search input and clear button visibility
            var searchInput = document.getElementById('searchInput');
            var clearBtn = document.getElementById('clearSearchBtn');
            var hasSearch = currentSearch && currentSearch.length > 0;
            if (searchInput) {
                searchInput.value = data.searchQuery;
            }
            if (clearBtn) {
                clearBtn.style.display = hasSearch ? 'flex' : 'none';
            }
            
            // Update category select
            var categorySelect = document.getElementById('categorySelect');
            if (categorySelect) {
                categorySelect.value = data.selectedCategory;
            }
            
            // Update pagination
            if (data.totalPages > 1) {
                pagination.style.display = 'flex';
                pagination.innerHTML = data.pagination;
            } else {
                pagination.style.display = 'none';
            }
        } else {
            tbody.innerHTML = '<div style="text-align: center; padding: 3rem; color: var(--text-secondary);"><i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i><p>Error loading tools</p></div>';
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

function performSearch() {
    var searchInput = document.getElementById('searchInput');
    currentSearch = searchInput.value;
    loadTools(1);
}

function performFilter() {
    var categorySelect = document.getElementById('categorySelect');
    currentCategory = categorySelect.value;
    loadTools(1);
}

function clearSearch() {
    currentSearch = '';
    var searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    loadTools(1);
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit search on Enter
    var searchInput = document.getElementById('searchInput');
    var clearBtn = document.getElementById('clearSearchBtn');
    
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
        
        // Show/hide clear button as user types
        searchInput.addEventListener('input', function() {
            if (clearBtn) {
                clearBtn.style.display = searchInput.value.length > 0 ? 'flex' : 'none';
            }
        });
    }
    
    // Clear button click handler
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearSearch();
        });
    }
});
</script>
@endsection
