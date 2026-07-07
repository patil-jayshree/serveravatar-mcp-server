@extends('layouts.app')

@section('title', 'API Access - ServerAvatar MCP')
@section('breadcrumb', 'API Access')

@php
$userApiKey = auth()->user()->api_key ?? '';
@endphp

@section('styles')
<style>
    .settings-tabs { display: flex; gap: 0; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 1.5rem; }
    .settings-tab { display: flex; align-items: center; gap: 8px; padding: 0.875rem 1.25rem; color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s ease; border-bottom: 3px solid transparent; flex: 1; justify-content: center; }
    .settings-tab:hover { background: var(--bg-card-hover); color: var(--text-primary); }
    .settings-tab.active { background: var(--accent-primary-muted); color: var(--accent-primary); border-bottom-color: var(--accent-primary); }
    .settings-tab .icon { font-size: 1rem; }
    .settings-content { flex: 1; min-width: 0; }
    .api-key-row { display: flex; align-items: center; gap: 8px; width: 100%; }
    .api-key-box { position: relative; flex: 1; }
    .api-key-box input { width: 100%; padding: 10px 100px 10px 16px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.85rem; letter-spacing: 1px; box-sizing: border-box; }
    .api-key-box input:focus { outline: none; border-color: var(--accent-primary); }
    .icon-btn { position: absolute; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 6px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
    .icon-btn:hover { color: var(--text-primary); }
    .eye-btn { right: 60px; }
    .copy-btn { right: 12px; }
    .copy-btn.copied { color: var(--accent-success); }
    .api-access-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; }
    .api-access-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
    .api-access-header-left { display: flex; flex-direction: column; gap: 0.25rem; }
    .api-access-title { font-size: 1rem; font-weight: 600; color: var(--text-primary); }
    .api-access-desc { font-size: 0.875rem; color: var(--text-secondary); }
    .api-access-body { padding: 1.5rem; }
    .api-empty-box { border: 2px dashed var(--border-color); border-radius: var(--radius-lg); padding: 1.75rem 1.5rem; text-align: center; }
    .api-empty-icon { font-size: 3rem; margin-bottom: 0.75rem; }
    .api-empty-title { font-size: 0.9rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem; }
    .api-empty-desc { font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1.5rem; }
    .btn-outline { padding: 0.625rem 1.5rem; background: transparent; color: var(--accent-primary); border: 1px solid var(--accent-primary); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
    .btn-outline:hover { background: var(--accent-primary); color: white; }
    .btn-primary { padding: 0.625rem 1.5rem; background: var(--accent-primary); color: white; border: none; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
    .btn-primary:hover { background: var(--accent-primary-hover); }
    .api-features { display: flex; gap: 1rem; padding: 1.5rem; }
    .api-feature { display: flex; align-items: flex-start; gap: 1rem; flex: 1; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem 1.5rem; }
    .api-feature-icon { width: 36px; height: 36px; border-radius: var(--radius-md); background: rgba(124, 58, 237, 0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1rem; }
    .api-feature-content { display: flex; flex-direction: column; gap: 0.25rem; }
    .api-feature-title { font-size: 0.875rem; font-weight: 600; color: var(--text-primary); }
    .api-feature-desc { font-size: 0.8rem; color: var(--text-secondary); line-height: 1.4; }
    @media (max-width: 768px) {
        .settings-tabs { flex-direction: column; }
        .api-features { flex-direction: column; }
    }
</style>
@endsection

@section('content')

<div class="page-header">
    <h1 class="page-title">Account Settings</h1>
    <p class="page-subtitle">Manage your account and preferences.</p>
</div>

<div class="settings-tabs">
    <a href="/account" class="settings-tab">
        <span class="icon"><i class="fas fa-user-circle"></i></span>
        Account
    </a>
    <a href="/account/password" class="settings-tab">
        <span class="icon"><i class="fas fa-lock"></i></span>
        Change Password
    </a>
    <a href="/account/api" class="settings-tab active">
        <span class="icon"><i class="fas fa-key"></i></span>
        API Access
    </a>
</div>

<div class="settings-content">
    <div class="api-access-card">
        <div class="api-access-header">
            <div class="api-access-header-left">
                <h2 class="api-access-title">ServerAvatar API Access</h2>
                <p class="api-access-desc">Manage your ServerAvatar API key for MCP integration</p>
            </div>
            <button class="btn-primary" onclick="openApiKeyModal()">
                {{ $userApiKey ? 'Update API Key' : 'Add API Key' }}
            </button>
        </div>
        <div class="api-access-body">
            @if($userApiKey)
            <div class="api-key-row">
                <div class="api-key-box">
                    <input type="password" id="apiKeyField" value="{{ $userApiKey }}" readonly>
                    <button type="button" class="icon-btn eye-btn" id="eyeBtn">
                        <i id="eyeShowIcon" class="fas fa-eye" style="font-size: 15px;"></i>
                        <i id="eyeHideIcon" class="fas fa-eye-slash" style="font-size: 15px; display: none;"></i>
                    </button>
                    <button type="button" class="icon-btn copy-btn" id="copyBtn">
                        <i class="fas fa-copy" style="font-size: 15px;"></i>
                    </button>
                </div>
            </div>
            @else
            <div class="api-empty-box">
                <div class="api-empty-icon"><i class="fas fa-key" style="color: var(--accent-primary);"></i></div>
                <div class="api-empty-title">No API key added yet</div>
                <div class="api-empty-desc">Add an API key to connect your ServerAvatar account with MCP clients</div>
                <button class="btn-outline" onclick="openApiKeyModal()">Add API Key</button>
            </div>
            @endif
        </div>
        <div class="api-features">
            <div class="api-feature">
                <div class="api-feature-icon"><i class="fas fa-lock" style="color: var(--accent-primary);"></i></div>
                <div class="api-feature-content">
                    <div class="api-feature-title">Secure Access</div>
                    <div class="api-feature-desc">Your API key is encrypted and stored securely.</div>
                </div>
            </div>
            <div class="api-feature">
                <div class="api-feature-icon"><i class="fas fa-bolt" style="color: var(--accent-primary);"></i></div>
                <div class="api-feature-content">
                    <div class="api-feature-title">Full Control</div>
                    <div class="api-feature-desc">Manage servers, sites, and databases via MCP.</div>
                </div>
            </div>
            <div class="api-feature">
                <div class="api-feature-icon"><i class="fas fa-clipboard-list" style="color: var(--accent-primary);"></i></div>
                <div class="api-feature-content">
                    <div class="api-feature-title">MCP Protocol</div>
                    <div class="api-feature-desc">Connect with any MCP-compatible AI client.</div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.api-key-modal', ['apiKey' => $userApiKey, 'hasApiKey' => !empty($userApiKey)])
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var keyVisible = false;
    var eyeBtn = document.getElementById('eyeBtn');
    var copyBtn = document.getElementById('copyBtn');
    var apiKeyField = document.getElementById('apiKeyField');
    var eyeShowIcon = document.getElementById('eyeShowIcon');
    var eyeHideIcon = document.getElementById('eyeHideIcon');
    
    if (eyeBtn) {
        eyeBtn.addEventListener('click', function() {
            if (!keyVisible) {
                apiKeyField.type = 'text';
                eyeShowIcon.style.display = 'none';
                eyeHideIcon.style.display = 'block';
                keyVisible = true;
            } else {
                apiKeyField.type = 'password';
                eyeShowIcon.style.display = 'block';
                eyeHideIcon.style.display = 'none';
                keyVisible = false;
            }
        });
    }
    
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            navigator.clipboard.writeText(apiKeyField.value).then(function() {
                copyBtn.classList.add('copied');
                copyBtn.innerHTML = '<i class="fas fa-check" style="font-size: 15px;"></i>';
                setTimeout(function() {
                    copyBtn.classList.remove('copied');
                    copyBtn.innerHTML = '<i class="fas fa-copy" style="font-size: 15px;"></i>';
                }, 2000);
            });
        });
    }
});
</script>
@endsection
