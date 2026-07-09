@extends('layouts.app')

@section('title', 'Account Settings - ServerAvatar MCP')
@section('breadcrumb', 'Account Settings')

@php
$userApiKey = auth()->user()->api_key ?? '';
$user = auth()->user();
$name = $user->name ?? '';
$email = $user->email ?? '';
$initial = strtoupper(substr($name, 0, 1));
$createdAt = $user->created_at ? date('F d, Y', strtotime($user->created_at)) : 'Unknown';
$updatedAt = $user->updated_at ? date('F d, Y', strtotime($user->updated_at)) : 'Unknown';
@endphp

@section('styles')
<style>
    /* Page wrapper */
    .account-page { max-width: 940px; margin: 0 auto; }

    /* Page header */
    .page-header { margin-bottom: 2rem; }
    .page-title { font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.375rem; }
    .page-subtitle { font-size: 0.9rem; color: var(--text-secondary); }

    /* Cards */
    .card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 1.75rem; margin-bottom: 1.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    .card-header { display: flex; align-items: center; gap: 0.75rem; margin: -1.75rem -1.75rem 1.5rem -1.75rem; padding: 1rem 1.75rem; border-bottom: 1px solid var(--border-color); }
    .card-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .card-icon.purple { background: rgba(124,92,252,0.15); color: #7c3aed; }
    .card-icon.lock { background: rgba(124,92,252,0.15); color: #7c3aed; }
    .card-icon.key { background: rgba(124,92,252,0.15); color: #7c3aed; }
    .card-icon.danger { background: rgba(239,68,68,0.15); color: #ef4444; }
    .card-title { font-size: 1rem; font-weight: 700; color: var(--text-primary); }
    .card-desc { font-size: 0.8rem; color: var(--text-secondary); margin-top: 2px; }

    /* Profile section */
    .profile-grid { display: grid; grid-template-columns: 260px 1fr; gap: 2rem; align-items: start; }
    @media (max-width: 768px) { .profile-grid { grid-template-columns: 1fr; gap: 1.5rem; } }

    /* Avatar card */
    .avatar-card { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 12px; padding: 1.5rem; text-align: center; }
    .avatar-circle { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #7c3aed, #5b21b6); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; color: white; margin: 0 auto 1rem; }
    .avatar-name { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; }
    .verified-badge { display: inline-flex; align-items: center; gap: 4px; background: rgba(34,197,94,0.15); color: #22c55e; font-size: 0.7rem; font-weight: 600; padding: 3px 8px; border-radius: 20px; margin-bottom: 0.75rem; }
    .avatar-info { font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.25rem; }
    .avatar-info i { margin-right: 6px; color: var(--text-muted); }
    .avatar-since { font-size: 0.75rem; color: var(--text-muted); }

    /* Form fields */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }
    .form-group { }
    .form-label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .input-wrap { position: relative; }
    .input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.875rem; display: flex; align-items: center; }
    .form-input { width: 100%; padding: 0.625rem 0.75rem 0.625rem 2.25rem; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.875rem; color: var(--text-primary); transition: all 0.2s; box-sizing: border-box; }
    .form-input:focus { outline: none; border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,92,252,0.15); }
    .form-input::placeholder { color: var(--text-muted); }
    .form-input:disabled { background: var(--bg-secondary); cursor: not-allowed; }
    .form-hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.375rem; line-height: 1.4; }

    /* Buttons */
    .btn-group { display: flex; gap: 0.75rem; justify-content: flex-end; }
    .btn { padding: 0.625rem 1.25rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; border: none; }
    .btn-primary { background: #7c3aed; color: white; }
    .btn-primary:hover { background: #6d28d9; }
    .btn-outline { background: transparent; border: 1px solid var(--border-color); color: var(--text-secondary); }
    .btn-outline:hover { background: var(--bg-card-hover); color: var(--text-primary); }
    .btn:disabled { opacity: 0.5; cursor: not-allowed; }

    /* Password section */
    .pword-grid { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 1.5rem; align-items: start; }
    @media (max-width: 900px) { .pword-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 640px) { .pword-grid { grid-template-columns: 1fr; } }
    .field-wrap { position: relative; }
    .field-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.875rem; display: flex; align-items: center; }
    .field-input { width: 100%; padding: 0.625rem 2.5rem 0.625rem 2.25rem; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.875rem; color: var(--text-primary); transition: all 0.2s; box-sizing: border-box; }
    .field-input:focus { outline: none; border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,92,252,0.15); }
    .field-input::placeholder { color: var(--text-muted); }
    .eye-btn { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 4px; display: flex; align-items: center; font-size: 0.875rem; }
    .eye-btn:hover { color: var(--text-secondary); }
    .strength-bar-wrap { display: flex; align-items: center; gap: 4px; margin-top: 8px; }
    .strength-segment { height: 4px; width: 32px; background: var(--border-color); border-radius: 2px; transition: all 0.3s; }
    .strength-segment.active.weak { background: #ef4444; }
    .strength-segment.active.moderate { background: #f59e0b; }
    .strength-segment.active.strong { background: #22c55e; }
    .strength-text { font-size: 0.7rem; font-weight: 600; margin-left: 6px; }
    .strength-text.weak { color: #ef4444; }
    .strength-text.moderate { color: #f59e0b; }
    .strength-text.strong { color: #22c55e; }

    /* API section */
    .api-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.25rem; }
    .api-info-item { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 10px; padding: 1rem; }
    .api-info-label { font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.375rem; }
    .api-info-value { font-size: 0.875rem; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 6px; }
    .api-key-display { display: flex; align-items: center; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 10px; padding: 0.875rem 1rem; gap: 0.75rem; margin-bottom: 1.25rem; }
    .api-key-icon { width: 36px; height: 36px; border-radius: 8px; background: rgba(124,92,252,0.15); display: flex; align-items: center; justify-content: center; color: #7c3aed; flex-shrink: 0; }
    .api-key-content { flex: 1; min-width: 0; }
    .api-key-label { font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; }
    .api-key-value { font-family: 'SF Mono', Monaco, monospace; font-size: 0.85rem; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .api-key-value.empty { color: var(--text-muted); font-style: italic; font-family: inherit; }
    .api-key-actions { display: flex; gap: 0.5rem; flex-shrink: 0; }
    .btn-sm { padding: 0.5rem 0.875rem; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px; color: var(--text-secondary); }
    .btn-sm:hover { background: var(--bg-card-hover); border-color: #7c3aed; color: #7c3aed; }
    .btn-sm.primary { background: #7c3aed; border-color: #7c3aed; color: white; }
    .btn-sm.primary:hover { background: #6d28d9; }

    /* Danger zone */
    .danger-zone { border-color: rgba(239,68,68,0.3); }
    .danger-zone .card-header { border-bottom-color: rgba(239,68,68,0.2); }
    .danger-content { display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; }
    .danger-text { flex: 1; min-width: 200px; }
    .danger-title { font-size: 0.875rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem; }
    .danger-desc { font-size: 0.8rem; color: var(--text-secondary); line-height: 1.5; }
    .btn-danger { padding: 0.625rem 1.25rem; background: #ef4444; color: white; border: none; border-radius: 8px; font-size: 0.875rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .btn-danger:hover { background: #dc2626; }

    /* Modals */
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); align-items: center; justify-content: center; z-index: 9999; }
    .modal-box { background: var(--bg-card); border-radius: 16px; width: 100%; max-width: 480px; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.4); border: 1px solid var(--border-color); }
    .modal-hdr { display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); }
    .modal-title-row { display: flex; align-items: center; gap: 0.75rem; }
    .modal-icon { width: 36px; height: 36px; border-radius: 8px; background: rgba(124,92,252,0.15); display: flex; align-items: center; justify-content: center; }
    .modal-hdr h3 { margin: 0; font-size: 1rem; font-weight: 600; color: var(--text-primary); }
    .modal-close { background: var(--bg-secondary); border: none; width: 28px; height: 28px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); font-size: 0.8rem; }
    .modal-close:hover { background: var(--border-color); color: var(--text-primary); }
    .modal-body { padding: 1.25rem 1.5rem; }
    .modal-intro { font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1rem; line-height: 1.5; }
    .modal-label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .pw-wrap { position: relative; }
    .pw-wrap input { width: 100%; padding: 0.75rem 3rem 0.75rem 1rem; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.9rem; color: var(--text-primary); box-sizing: border-box; }
    .pw-wrap input:focus { outline: none; border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,92,252,0.15); }
    .pw-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 4px; display: flex; align-items: center; }
    .pw-toggle:hover { color: var(--text-secondary); }
    .star { color: #ef4444; }
    .sec-tips { background: rgba(124,92,252,0.08); border: 1px solid rgba(124,92,252,0.2); border-radius: 10px; padding: 0.875rem 1rem; margin-top: 1rem; }
    .tips-title { font-size: 0.7rem; font-weight: 700; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; }
    .tips-list { margin: 0; padding-left: 1.25rem; }
    .tips-list li { font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.25rem; }
    .tips-list li:last-child { margin-bottom: 0; }
    .modal-ftr { padding: 1rem 1.25rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem; }
    .btn-cancel { padding: 0.625rem 1.25rem; background: transparent; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-secondary); font-size: 0.875rem; font-weight: 600; cursor: pointer; }
    .btn-cancel:hover { background: var(--bg-card-hover); }
    .btn-save { padding: 0.625rem 1.5rem; background: #7c3aed; border: none; border-radius: 8px; color: white; font-size: 0.875rem; font-weight: 600; cursor: pointer; }
    .btn-save:hover { background: #6d28d9; }

    .delete-modal { border: 1px solid rgba(239,68,68,0.4); }
    .delete-modal .modal-hdr { border-bottom-color: rgba(239,68,68,0.3); }
    .delete-modal .modal-icon { background: rgba(239,68,68,0.15); }
    .delete-warn-box { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); border-radius: 10px; padding: 0.875rem 1rem; margin-bottom: 1rem; }
    .delete-warn-box p { color: var(--text-secondary); font-size: 0.875rem; margin: 0; line-height: 1.5; }
    .delete-confirm-label { font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 0.5rem; display: block; }
    .delete-confirm-input { width: 100%; padding: 0.625rem 0.875rem; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.875rem; color: var(--text-primary); box-sizing: border-box; outline: none; }
    .delete-confirm-input:focus { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.15); }
    .btn-del { padding: 0.625rem 1.25rem; background: #ef4444; border: none; border-radius: 8px; color: white; font-size: 0.875rem; font-weight: 600; cursor: pointer; opacity: 0.5; }
    .btn-del:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-del:not(:disabled):hover { background: #dc2626; }

    @media (max-width: 480px) {
        .api-key-display { flex-direction: column; align-items: flex-start; }
        .api-key-actions { width: 100%; }
        .api-key-actions .btn-sm { flex: 1; justify-content: center; }
        .danger-content { flex-direction: column; align-items: flex-start; }
        .card { padding: 1.25rem; }
    }
</style>
@endsection

@section('content')
<div class="account-page">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Account Settings</h1>
        <p class="page-subtitle">Manage your account information, security and API access.</p>
    </div>

    <!-- Profile Information Card -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon purple"><i class="fas fa-user"></i></div>
            <div>
                <div class="card-title">Profile Information</div>
                <div class="card-desc">Update your account details</div>
            </div>
        </div>
        <div class="profile-grid">
            <!-- Left: Avatar & Info -->
            <div class="avatar-card">
                <div class="avatar-circle">{{ $initial }}</div>
                <div class="avatar-name">{{ $name }}</div>
                <div class="verified-badge"><i class="fas fa-check-circle"></i> Verified</div>
                <div class="avatar-info"><i class="fas fa-envelope"></i>{{ $email }}</div>
                <div class="avatar-since"><i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>Member since {{ $createdAt }}</div>
            </div>
            <!-- Right: Form -->
            <div style="display: flex; flex-direction: column; justify-content: center; height: 100%;">
                <form id="profileForm">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fas fa-user"></i></span>
                                <input type="text" id="nameInput" class="form-input" placeholder="Enter your name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                <input type="email" id="emailInput" class="form-input" disabled placeholder="Email address">
                            </div>
                            <div class="form-hint">We'll never share your email with anyone else.</div>
                        </div>
                    </div>
                    <div style="border-top: 1px solid var(--border-color); margin: 2rem 0 1rem 0;"></div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline" onclick="location.reload()">Cancel</button>
                        <button type="button" class="btn btn-primary" id="saveProfileBtn" onclick="saveProfile()">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Card -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon lock"><i class="fas fa-lock"></i></div>
            <div>
                <div class="card-title">Change Password</div>
                <div class="card-desc">Update your password to keep your account secure</div>
            </div>
        </div>
        <div class="pword-grid">
            <div>
                <label class="form-label">Current Password <span style="color: #ef4444;">*</span></label>
                <div class="field-wrap">
                    <input type="password" id="current_password" class="field-input" placeholder="Current password" style="padding-left: 0.875rem;">
                    <button type="button" class="eye-btn" onclick="togglePwd('current_password')">
                        <i class="fas fa-eye" id="current_password_eye"></i>
                    </button>
                </div>
            </div>
            <div>
                <label class="form-label">New Password <span style="color: #ef4444;">*</span></label>
                <div class="field-wrap">
                    <input type="password" id="new_password" class="field-input" placeholder="New password" oninput="checkStrength()" style="padding-left: 0.875rem;">
                    <button type="button" class="eye-btn" onclick="togglePwd('new_password')">
                        <i class="fas fa-eye" id="new_password_eye"></i>
                    </button>
                </div>
                <div class="strength-bar-wrap">
                    <div class="strength-segment" id="seg1"></div>
                    <div class="strength-segment" id="seg2"></div>
                    <div class="strength-segment" id="seg3"></div>
                    <span class="strength-text" id="strengthText"></span>
                </div>
            </div>
            <div>
                <label class="form-label">Confirm Password <span style="color: #ef4444;">*</span></label>
                <div class="field-wrap">
                    <input type="password" id="confirm_password" class="field-input" placeholder="Confirm password" style="padding-left: 0.875rem;">
                    <button type="button" class="eye-btn" onclick="togglePwd('confirm_password')">
                        <i class="fas fa-eye" id="confirm_password_eye"></i>
                    </button>
                </div>
            </div>
        </div>
        <div style="display: flex; justify-content: flex-end; margin-top: 1.25rem;">
            <button type="button" class="btn btn-primary" id="updatePasswordBtn" onclick="updatePassword()" disabled>
                Update Password
            </button>
        </div>
    </div>

    <!-- API Access Card -->
    <div class="card">
        <div class="card-header">
            <div class="card-icon key"><i class="fas fa-key"></i></div>
            <div>
                <div class="card-title">API Access</div>
                <div class="card-desc">Manage your API key used to access the MCP server.</div>
            </div>
        </div>

        <!-- API Key Display Box -->
        <div style="background: rgba(124,92,252,0.08); border: 1px solid var(--border-color); border-radius: 12px; padding: 1.25rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <!-- Left: API Key -->
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">API Key</div>
                        @if($userApiKey)
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span id="apiKeyDisplay" style="font-family: 'SF Mono', Monaco, monospace; font-size: 0.875rem; color: var(--text-primary); letter-spacing: 0.5px;">{{ substr($userApiKey, 0, 12) . '••••••••' . substr($userApiKey, -6) }}</span>
                                <button type="button" onclick="toggleApiKeyVisibility()" style="background: none; border: none; cursor: pointer; padding: 4px; color: #7c3aed;">
                                    <i class="fas fa-eye" id="apiKeyEye" style="color: var(--text-muted);"></i>
                                </button>
                                <button type="button" onclick="copyApiKey()" style="background: none; border: none; cursor: pointer; padding: 4px; color: #7c3aed;">
                                    <i class="fas fa-copy" style="color: var(--text-muted);"></i>
                                </button>
                            </div>
                        @else
                            <div style="font-size: 0.875rem; color: var(--text-muted); font-style: italic;">No API key added yet</div>
                        @endif
                    </div>
                    <!-- Divider -->
                    <div style="width: 1px; height: 36px; background: var(--border-color);"></div>
                    <!-- Created -->
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">Created</div>
                        <div style="font-size: 0.875rem; color: var(--text-primary);">{{ $createdAt }}</div>
                    </div>
                    <!-- Divider -->
                    <div style="width: 1px; height: 36px; background: var(--border-color);"></div>
                    <!-- Last Updated -->
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">Last Updated</div>
                        <div style="font-size: 0.875rem; color: var(--text-primary);">{{ $updatedAt }}</div>
                    </div>
                </div>
                <!-- Right: Update API Key Button -->
                <button type="button" class="btn-sm" onclick="openApiKeyModal()" style="border: 1px solid #7c3aed; color: #7c3aed; white-space: nowrap;">
                    <i class="fas fa-edit"></i> Update API Key
                </button>
            </div>
        </div>

        <!-- Security Reminder -->
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem;">
            <i class="fas fa-shield-alt" style="color: var(--text-muted); font-size: 0.875rem;"></i>
            <span style="font-size: 0.8rem; color: var(--text-secondary);">Keep your API key secure. Do not share it with others.</span>
        </div>
    </div>

    <!-- Danger Zone Card -->
    <div class="card" style="margin-bottom: 1.75rem; border-color: rgba(239,68,68,0.2);">
        <!-- Header -->
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(239,68,68,0.1); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-exclamation-triangle" style="color: #ef4444; font-size: 1rem;"></i>
            </div>
            <div>
                <span class="card-title" style="color: #ef4444;">Danger Zone</span>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">Irreversible and permanent actions.</div>
            </div>
        </div>
        <!-- Delete Account Box -->
        <div style="background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.2); border-radius: 12px; padding: 1.25rem; margin-top: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <!-- Left: Text -->
                <div>
                    <div style="font-size: 0.875rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem;">Delete Account</div>
                    <div style="font-size: 0.8rem; color: var(--text-secondary);">Once you delete your account, there is no going back. All your data will be permanently removed.</div>
                </div>
                <!-- Right: Delete Button -->
                <button type="button" onclick="openDeleteModal()" style="background: #ef4444; color: white; border: none; border-radius: 8px; padding: 0.625rem 1.25rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; white-space: nowrap;">
                    <i class="fas fa-trash-alt" style="font-size: 0.875rem;"></i> Delete My Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- API Key Modal -->
<div class="modal-overlay" id="apiKeyModal">
    <div class="modal-box">
        <div class="modal-hdr">
            <div class="modal-title-row">
                <div class="modal-icon"><i class="fas fa-key" style="color: #7c3aed;"></i></div>
                <h3>{{ $userApiKey ? 'Update API Key' : 'Add API Key' }}</h3>
            </div>
            <button type="button" class="modal-close" onclick="closeApiKeyModal()"><i class="fas fa-times"></i></button>
        </div>
        <form id="apiKeyForm">
            @csrf
            <div class="modal-body">
                <p class="modal-intro">Enter your new ServerAvatar API key below.</p>
                <label class="modal-label">New API Key <span class="star">*</span></label>
                <div class="pw-wrap">
                    <input type="password" id="apiKeyInput" name="api_key" placeholder="Enter your API key" required value="{{ $userApiKey ?? '' }}">
                    <button type="button" class="pw-toggle" onclick="toggleApiKeyVis()">
                        <i class="fas fa-eye eye-on" style="font-size:15px;"></i>
                        <i class="fas fa-eye-slash eye-off" style="font-size:15px;display:none;"></i>
                    </button>
                </div>
                <div class="sec-tips">
                    <div class="tips-title">Security Best Practices</div>
                    <ul class="tips-list">
                        <li>Never share your API key with anyone</li>
                        <li>Store it securely in environment variables</li>
                        <li>Rotate your key periodically</li>
                    </ul>
                </div>
            </div>
            <div class="modal-ftr">
                <button type="button" class="btn-cancel" onclick="closeApiKeyModal()">Cancel</button>
                <button type="submit" class="btn-save">{{ $userApiKey ? 'Update API Key' : 'Add API Key' }}</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box delete-modal">
        <div class="modal-hdr">
            <div class="modal-title-row">
                <div class="modal-icon"><i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i></div>
                <h3 style="color: #ef4444;">Delete Account</h3>
            </div>
            <button type="button" class="modal-close" onclick="closeDeleteModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="delete-warn-box">
                <p>This action cannot be undone. This will permanently delete your account, data, and remove all your integrations.</p>
            </div>
            <p class="delete-confirm-label">To confirm, type <strong style="color: #ef4444;">DELETE</strong> in the box below:</p>
            <input type="text" id="deleteConfirmInput" class="delete-confirm-input" placeholder="Type DELETE" oninput="toggleDelBtn()">
        </div>
        <div class="modal-ftr">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" id="confirmDeleteBtn" class="btn-del" disabled onclick="confirmDelete()">Delete Account</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Fetch profile
fetch('/api/profile', {
    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
})
.then(function(r) { return r.json(); })
.then(function(d) {
    document.getElementById('nameInput').value = d.name || '';
    document.getElementById('emailInput').value = d.email || '';
});

// Save Profile
function saveProfile() {
    var btn = document.getElementById('saveProfileBtn');
    var name = document.getElementById('nameInput').value.trim();
    var token = document.querySelector('input[name="_token"]').value;
    if (!name) { showToast('Please enter your name', true); return; }
    btn.disabled = true;
    btn.textContent = 'Saving...';
    fetch('/api/profile', {
        method: 'PATCH',
        body: JSON.stringify({ name: name }),
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.success) { showToast('Profile updated successfully!'); }
        else { showToast(d.error || 'Failed to update profile', true); }
        btn.disabled = false;
        btn.textContent = 'Save Changes';
    })
    .catch(function() { showToast('Network error', true); btn.disabled = false; btn.textContent = 'Save Changes'; });
}

// Password toggle
function togglePwd(id) {
    var inp = document.getElementById(id);
    var eye = document.getElementById(id + '_eye');
    if (inp.type === 'password') { inp.type = 'text'; eye.className = 'fas fa-eye-slash'; }
    else { inp.type = 'password'; eye.className = 'fas fa-eye'; }
}

// Password strength
function checkStrength() {
    var pw = document.getElementById('new_password').value;
    var seg1 = document.getElementById('seg1');
    var seg2 = document.getElementById('seg2');
    var seg3 = document.getElementById('seg3');
    var text = document.getElementById('strengthText');
    var strength = 0;
    if (pw.length >= 8) strength++;
    if (/[A-Z]/.test(pw)) strength++;
    if (/[a-z]/.test(pw)) strength++;
    if (/[0-9]/.test(pw)) strength++;
    if (/[@$!%*?&]/.test(pw)) strength++;
    // Reset
    seg1.className = 'strength-segment';
    seg2.className = 'strength-segment';
    seg3.className = 'strength-segment';
    text.className = 'strength-text';
    if (pw.length === 0) { text.textContent = ''; return; }
    if (strength <= 2) {
        seg1.classList.add('active', 'weak');
        text.textContent = 'Weak password';
        text.classList.add('weak');
    } else if (strength <= 3) {
        seg1.classList.add('active', 'moderate');
        seg2.classList.add('active', 'moderate');
        text.textContent = 'Moderate password';
        text.classList.add('moderate');
    } else {
        seg1.classList.add('active', 'strong');
        seg2.classList.add('active', 'strong');
        seg3.classList.add('active', 'strong');
        text.textContent = 'Strong password';
        text.classList.add('strong');
    }
}

// Password validation
function checkPwordFields() {
    var curr = document.getElementById('current_password').value.trim();
    var pass = document.getElementById('new_password').value.trim();
    var conf = document.getElementById('confirm_password').value.trim();
    document.getElementById('updatePasswordBtn').disabled = !(curr && pass && conf);
}
document.getElementById('current_password').addEventListener('input', checkPwordFields);
document.getElementById('new_password').addEventListener('input', checkPwordFields);
document.getElementById('confirm_password').addEventListener('input', checkPwordFields);

// Update Password
function updatePassword() {
    var btn = document.getElementById('updatePasswordBtn');
    var token = document.querySelector('input[name="_token"]').value;
    // Hide all password fields before API call
    document.getElementById('current_password').type = 'password';
    document.getElementById('new_password').type = 'password';
    document.getElementById('confirm_password').type = 'password';
    // Reset eye icons
    document.getElementById('current_password_eye').className = 'fas fa-eye';
    document.getElementById('new_password_eye').className = 'fas fa-eye';
    document.getElementById('confirm_password_eye').className = 'fas fa-eye';
    var curr = document.getElementById('current_password').value;
    var pass = document.getElementById('new_password').value;
    var conf = document.getElementById('confirm_password').value;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    fetch('/api/profile/password', {
        method: 'PATCH',
        body: JSON.stringify({ current_password: curr, password: pass, password_confirmation: conf }),
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
    })
    .then(function(r) { return r.json().then(function(d) { return { ok: r.ok, data: d }; }); })
    .then(function(result) {
        if (result.ok && result.data.success) {
            showToast('Password updated successfully!');
            document.getElementById('current_password').value = '';
            document.getElementById('new_password').value = '';
            document.getElementById('confirm_password').value = '';
            checkPwordFields();
            checkStrength();
        } else {
            var err = 'Failed to update password';
            if (result.data && result.data.errors) { for (var k in result.data.errors) { err = result.data.errors[k][0]; break; } }
            else if (result.data && result.data.error) { err = result.data.error; }
            showToast(err, true);
        }
        btn.disabled = false;
        btn.textContent = 'Update Password';
    })
    .catch(function() { showToast('Network error', true); btn.disabled = false; btn.textContent = 'Update Password'; });
}

// Copy API Key
function copyApiKey() {
    navigator.clipboard.writeText('{{ $userApiKey }}').then(function() { showToast('API Key copied!'); });
}

// Toggle API Key Visibility
var apiKeyVisible = false;
var fullApiKey = '{{ $userApiKey }}';
function toggleApiKeyVisibility() {
    var display = document.getElementById('apiKeyDisplay');
    var eye = document.getElementById('apiKeyEye');
    if (!fullApiKey) return;
    if (apiKeyVisible) {
        display.textContent = fullApiKey.substring(0, 8) + '••••••••' + fullApiKey.slice(-8);
        eye.className = 'fas fa-eye';
        apiKeyVisible = false;
    } else {
        display.textContent = fullApiKey;
        eye.className = 'fas fa-eye-slash';
        apiKeyVisible = true;
    }
}

// API Modal
function openApiKeyModal() {
    document.getElementById('apiKeyModal').style.display = 'flex';
    var inp = document.getElementById('apiKeyInput');
    inp.type = 'password';
    var on = document.querySelector('.eye-on');
    var off = document.querySelector('.eye-off');
    if (on) on.style.display = 'block';
    if (off) off.style.display = 'none';
}
function closeApiKeyModal() { document.getElementById('apiKeyModal').style.display = 'none'; }
function toggleApiKeyVis() {
    var inp = document.getElementById('apiKeyInput');
    var on = document.querySelector('.eye-on');
    var off = document.querySelector('.eye-off');
    if (inp.type === 'password') { inp.type = 'text'; if (on) on.style.display = 'none'; if (off) off.style.display = 'block'; }
    else { inp.type = 'password'; if (on) on.style.display = 'block'; if (off) off.style.display = 'none'; }
}

// API Form Submit
document.getElementById('apiKeyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    var fd = new FormData(form);
    var btn = form.querySelector('.btn-save');
    btn.disabled = true;
    btn.textContent = 'Saving...';
    fetch('{{ route('dashboard.api-key') }}', {
        method: 'POST',
        body: fd,
        headers: { 'X-CSRF-TOKEN': fd.get('_token'), 'Accept': 'application/json' }
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.success || d.status || d.message) { closeApiKeyModal(); showToast('API Key updated!'); setTimeout(function() { location.reload(); }, 1500); }
        else { showToast(d.error || 'Error', true); btn.disabled = false; btn.textContent = '{{ $userApiKey ? 'Update API Key' : 'Add API Key' }}'; }
    })
    .catch(function() { showToast('Network error', true); btn.disabled = false; btn.textContent = '{{ $userApiKey ? 'Update API Key' : 'Add API Key' }}'; });
});

// Delete Modal
function openDeleteModal() { document.getElementById('deleteModal').style.display = 'flex'; document.getElementById('deleteConfirmInput').value = ''; var b = document.getElementById('confirmDeleteBtn'); b.disabled = true; b.style.opacity = '0.5'; }
function closeDeleteModal() { document.getElementById('deleteModal').style.display = 'none'; }
function toggleDelBtn() { var v = document.getElementById('deleteConfirmInput').value; var b = document.getElementById('confirmDeleteBtn'); if (v === 'DELETE') { b.disabled = false; b.style.opacity = '1'; } else { b.disabled = true; b.style.opacity = '0.5'; } }
function confirmDelete() {
    var btn = document.getElementById('confirmDeleteBtn');
    var token = document.querySelector('input[name="_token"]').value;
    btn.disabled = true;
    btn.textContent = 'Deleting...';
    fetch('{{ route('api.account.delete') }}', {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.success) { showToast('Account deleted!'); setTimeout(function() { window.location.href = '/login'; }, 1500); }
        else { showToast(d.error || 'Error', true); btn.disabled = false; btn.textContent = 'Delete Account'; }
    })
    .catch(function() { showToast('Network error', true); btn.disabled = false; btn.textContent = 'Delete Account'; });
}

// Toast
function showToast(msg, isErr) {
    var t = document.getElementById('toast');
    if (!t) { t = document.createElement('div'); t.id = 'toast'; document.body.appendChild(t); }
    var icon = isErr ? '<i class="fas fa-times"></i>' : '<i class="fas fa-check"></i>';
    t.style.cssText = 'position:fixed;top:5rem;right:2rem;background:' + (isErr ? 'linear-gradient(135deg,#ef4444,#dc2626)' : 'linear-gradient(135deg,#22c55e,#16a34a)') + ';color:white;padding:14px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;box-shadow:0 8px 30px ' + (isErr ? 'rgba(239,68,68,0.4)' : 'rgba(34,197,94,0.4)') + ';z-index:10000;max-width:350px;min-width:250px;';
    t.innerHTML = '<span style="width:28px;height:28px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;">' + icon + '</span><span style="font-size:0.9rem;font-weight:600;">' + msg + '</span>';
    t.style.display = 'flex';
    setTimeout(function() { t.style.display = 'none'; }, 3000);
}
</script>
@endsection
