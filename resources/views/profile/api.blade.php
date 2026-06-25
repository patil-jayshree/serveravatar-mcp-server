@extends('layouts.app')

@section('title', 'API Access - ServerAvatar MCP')

@php
$userApiKey = auth()->user()->api_key ?? '';
@endphp

@section('styles')
<style>
    .api-key-row { display: flex; align-items: center; gap: 8px; width: 100%; }
    .api-key-box { position: relative; flex: 1; }
    .api-key-box input { width: 100%; padding: 10px 100px 10px 16px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-family: 'SF Mono', 'Fira Code', monospace; font-size: 0.85rem; letter-spacing: 1px; box-sizing: border-box; }
    .api-key-box input:focus { outline: none; border-color: var(--accent-primary); }
    .icon-btn { position: absolute; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 6px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
    .settings-content { flex: 1; min-width: 0; }
    .page-header { margin-bottom: 0.75rem; }
    .page-title { font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem; }
    .page-subtitle { font-size: 0.9rem; color: var(--text-secondary); }
    .icon-btn:hover { color: var(--text-primary); }
    .eye-btn { right: 60px; }
    .copy-btn { right: 12px; }
    .copy-btn.copied { color: var(--accent-success); }
    .settings-card-title { font-size: 1rem; font-weight: 600; color: var(--text-primary); }

    /* API Access Card */
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
    .api-benefits { display: flex; justify-content: center; gap: 2rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); }
    .api-benefit { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }
    .api-benefit-icon { width: 40px; height: 40px; border-radius: 50%; background: rgba(124, 58, 237, 0.1); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    .api-benefit-label { font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); }
    .api-access-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: center; }
    .btn-outline { padding: 0.625rem 1.5rem; background: transparent; color: var(--accent-primary); border: 1px solid var(--accent-primary); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
    .btn-outline:hover { background: var(--accent-primary); color: white; }
    .api-features { display: flex; gap: 1rem; padding: 1.5rem; }
    .api-feature { display: flex; align-items: flex-start; gap: 1rem; flex: 1; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem 1.5rem; }
    .api-feature-icon { width: 36px; height: 36px; border-radius: var(--radius-md); background: rgba(124, 58, 237, 0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1rem; }
    .api-feature-content { display: flex; flex-direction: column; gap: 0.25rem; }
    .api-feature-title { font-size: 0.875rem; font-weight: 600; color: var(--text-primary); }
    .api-feature-desc { font-size: 0.8rem; color: var(--text-secondary); line-height: 1.4; }
</style>
@endsection

@section('content')
@include('components.page-header')

<div class="settings-page">
    <div class="settings-sidebar">
        <nav class="settings-nav">
            <a href="/account" class="settings-nav-item">
                <span class="icon">👤</span>
                Account
            </a>
            <a href="/account/password" class="settings-nav-item">
                <span class="icon">🔒</span>
                Change Password
            </a>
            <a href="/account/api" class="settings-nav-item active">
                <span class="icon">🔑</span>
                API Access
            </a>
        </nav>
    </div>
    
    <div class="settings-content">
        <div class="api-access-card">
            <div class="api-access-header">
                <div class="api-access-header-left">
                    <h2 class="api-access-title">ServerAvatar API Access</h2>
                    <p class="api-access-desc">Manage your ServerAvatar API key for MCP integration</p>
                </div>
                @if($userApiKey)
                <button class="btn-primary" onclick="openApiKeyModal()">Update API Key</button>
                @else
                <button class="btn-primary" onclick="openApiKeyModal()">Add API Key</button>
                @endif
            </div>
            <div class="api-access-body">
                @if($userApiKey)
                <div class="api-key-row">
                    <div class="api-key-box">
                        <input type="password" id="apiKeyField" value="{{ $userApiKey }}" readonly>
                        <button type="button" class="icon-btn eye-btn" id="eyeBtn">
                            <svg id="eyeShowIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg id="eyeHideIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        </button>
                        <button type="button" class="icon-btn copy-btn" id="copyBtn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @else
                <div class="api-empty-box">
                    <div class="api-empty-icon">🔑</div>
                    <div class="api-empty-title">No API key added yet</div>
                    <div class="api-empty-desc">Add an API key to connect your ServerAvatar account with MCP clients</div>
                    <button class="btn-outline" onclick="openApiKeyModal()">Add API Key</button>
                </div>
                @endif
            </div>
            <div class="api-features">
                <div class="api-feature">
                    <div class="api-feature-icon">🔒</div>
                    <div class="api-feature-content">
                        <div class="api-feature-title">Secure Access</div>
                        <div class="api-feature-desc">Your API key is encrypted and stored securely.</div>
                    </div>
                </div>
                <div class="api-feature">
                    <div class="api-feature-icon">⚡</div>
                    <div class="api-feature-content">
                        <div class="api-feature-title">Full Control</div>
                        <div class="api-feature-desc">Manage servers, sites, and databases via MCP.</div>
                    </div>
                </div>
                <div class="api-feature">
                    <div class="api-feature-icon">📋</div>
                    <div class="api-feature-content">
                        <div class="api-feature-title">MCP Protocol</div>
                        <div class="api-feature-desc">Connect with any MCP-compatible AI client.</div>
                    </div>
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
                copyBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                setTimeout(function() {
                    copyBtn.classList.remove('copied');
                    copyBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>';
                }, 2000);
            });
        });
    }
});
</script>
@endsection
