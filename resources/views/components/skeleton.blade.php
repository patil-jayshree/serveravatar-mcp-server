<!-- Skeleton Loader Component -->
@props([
    'rows' => 3,
    'height' => 'md',
    'showAvatar' => false,
    'avatarSize' => 'md',
    'showBadge' => false,
])

@php
$heightClass = match($height) {
    'sm' => 'skeleton-h-sm',
    'lg' => 'skeleton-h-lg',
    default => 'skeleton-h-md',
};

$avatarSizeClass = match($avatarSize) {
    'sm' => 'skeleton-avatar-sm',
    'lg' => 'skeleton-avatar-lg',
    default => 'skeleton-avatar-md',
};
@endphp

<style>
/* Skeleton Animations */
@keyframes skeleton-pulse {
    0%, 100% { opacity: 0.4; }
    50% { opacity: 0.8; }
}

.skeleton {
    background: var(--bg-secondary);
    border-radius: 6px;
    animation: skeleton-pulse 1.5s ease-in-out infinite;
}

.skeleton-h-sm { height: 12px; }
.skeleton-h-md { height: 16px; }
.skeleton-h-lg { height: 24px; }

.skeleton-avatar-sm { width: 24px; height: 24px; border-radius: 50%; }
.skeleton-avatar-md { width: 32px; height: 32px; border-radius: 50%; }
.skeleton-avatar-lg { width: 40px; height: 40px; border-radius: 50%; }

.skeleton-text { height: 14px; margin-bottom: 8px; border-radius: 4px; }
.skeleton-text:last-child { width: 70%; margin-bottom: 0; }

.skeleton-badge { width: 60px; height: 20px; border-radius: 10px; }

.skeleton-btn { width: 80px; height: 32px; border-radius: 8px; }

/* Card Skeleton */
.skeleton-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.skeleton-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.skeleton-card-body {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Table Row Skeleton */
.skeleton-table-row {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-color);
}

.skeleton-table-row:last-child {
    border-bottom: none;
}

/* Stat Card Skeleton */
.skeleton-stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.25rem;
}

.skeleton-stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    margin-bottom: 12px;
}

.skeleton-stat-value {
    height: 28px;
    width: 60%;
    margin-bottom: 8px;
}

.skeleton-stat-label {
    height: 14px;
    width: 80%;
}
</style>

<!-- Table Row Skeleton -->
@if(isset($type) && $type === 'table-row')
<div class="skeleton-table-row">
    @if($showAvatar)
    <div class="skeleton {{ $avatarSizeClass }}"></div>
    @endif
    <div style="flex: 1;">
        <div class="skeleton skeleton-text" style="width: 40%;"></div>
        <div class="skeleton skeleton-text" style="width: 25%;"></div>
    </div>
    @if($showBadge)
    <div class="skeleton skeleton-badge"></div>
    @endif
    <div class="skeleton skeleton-btn"></div>
</div>
@endif

<!-- Card Skeleton -->
@if(isset($type) && $type === 'card')
<div class="skeleton-card">
    <div class="skeleton-card-header">
        @if($showAvatar)
        <div class="skeleton {{ $avatarSizeClass }}"></div>
        @endif
        <div style="flex: 1;">
            <div class="skeleton skeleton-text" style="width: 50%;"></div>
            <div class="skeleton skeleton-text" style="width: 30%;"></div>
        </div>
    </div>
    <div class="skeleton-card-body">
        @for($i = 0; $i < $rows; $i++)
        <div class="skeleton skeleton-text"></div>
        @endfor
    </div>
</div>
@endif

<!-- Stat Card Skeleton -->
@if(isset($type) && $type === 'stat')
<div class="skeleton-stat-card">
    <div class="skeleton skeleton-stat-icon"></div>
    <div class="skeleton skeleton-stat-value"></div>
    <div class="skeleton skeleton-stat-label"></div>
</div>
@endif

<!-- List Skeleton (default) -->
@if(!isset($type))
@for($i = 0; $i < $rows; $i++)
<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
    @if($showAvatar)
    <div class="skeleton {{ $avatarSizeClass }}"></div>
    @endif
    <div style="flex: 1;">
        <div class="skeleton skeleton-text {{ $heightClass }}" style="width: {{ rand(40, 70) }}%;"></div>
    </div>
</div>
@endfor
@endif
