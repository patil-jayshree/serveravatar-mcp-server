@extends('layouts.app')

@section('title', 'Change Password - ServerAvatar MCP')

@section('styles')
<style>
    .settings-page { display: flex; gap: 2rem; padding-top: 1rem; }
    .settings-sidebar { width: 240px; flex-shrink: 0; }
    .settings-nav { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; }
    .settings-nav-item { display: flex; align-items: center; gap: 10px; padding: 0.875rem 1rem; color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s ease; border-left: 3px solid transparent; }
    .settings-nav-item:hover { background: var(--bg-card-hover); color: var(--text-primary); }
    .settings-nav-item.active { background: var(--accent-primary-muted); color: var(--accent-primary); border-left-color: var(--accent-primary); }
    .settings-nav-item .icon { font-size: 1rem; }
    .settings-content { flex: 1; min-width: 0; }
    .page-header { margin-bottom: 0.75rem; }
    .page-title { font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem; }
    .page-subtitle { font-size: 0.9rem; color: var(--text-secondary); }
    .settings-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden; }
    .settings-card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); }
    .settings-card-title { font-size: 1rem; font-weight: 600; color: var(--text-primary); }
    .settings-card-body { padding: 1.5rem; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group:last-child { margin-bottom: 0; }
    .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .input-wrap { position: relative; }
    .form-input { width: 100%; padding: 0.75rem 3rem 0.75rem 1rem; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.9rem; color: var(--text-primary); transition: all 0.2s ease; box-sizing: border-box; }
    .form-input:focus { outline: none; border-color: var(--accent-primary); background: var(--bg-card); }
    .form-input::placeholder { color: var(--text-muted); }
    .eye-btn { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 4px; display: flex; align-items: center; }
    .eye-btn:hover { color: var(--text-primary); }
    .settings-card-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; gap: 12px; justify-content: flex-end; }
    .btn-primary { padding: 0.625rem 1.5rem; background: var(--accent-primary); color: white; border: none; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
    .btn-primary:hover { background: var(--accent-primary-hover); }
    .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }
    .btn-secondary { padding: 0.625rem 1.5rem; background: var(--bg-tertiary); color: var(--text-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
    .btn-secondary:hover { background: var(--bg-card-hover); border-color: var(--border-color-hover); }
    .btn-secondary:disabled { opacity: 0.6; cursor: not-allowed; }
    .info-box { background: var(--accent-primary-muted); border: 1px solid rgba(99, 102, 241, 0.2); border-radius: var(--radius-md); padding: 1rem 1.25rem; margin-bottom: 1.5rem; }
    .info-box-title { font-size: 0.8rem; font-weight: 700; color: var(--accent-primary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 6px; }
    .info-box ul { margin: 0; padding-left: 1.25rem; }
    .info-box li { font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.25rem; }
    .info-box li:last-child { margin-bottom: 0; }
    @media (max-width: 768px) {
        .settings-page { flex-direction: column; }
        .settings-sidebar { width: 100%; }
    }
</style>
@endsection

@section('content')
@include('components.page-header')

<div class="settings-page">
    <div class="settings-sidebar">
        <nav class="settings-nav">
            <a href="/account" class="settings-nav-item">
                <span class="icon"><i class="fas fa-user-circle" style="color: var(--accent-primary);"></i></span>
                Account
            </a>
            <a href="/account/password" class="settings-nav-item active">
                <span class="icon"><i class="fas fa-lock" style="color: var(--accent-primary);"></i></span>
                Change Password
            </a>
            <a href="/account/api" class="settings-nav-item">
                <span class="icon"><i class="fas fa-key" style="color: var(--accent-primary);"></i></span>
                API Access
            </a>
        </nav>
    </div>
    
    <div class="settings-content">
        <div class="settings-card">
            <div class="settings-card-header">
                <h2 class="settings-card-title">Change Password</h2>
            </div>
            <div class="settings-card-body">
                <div class="info-box">
                    <div class="info-box-title">
                        <i class="fas fa-info-circle" style="color: var(--accent-primary);"></i> Password Requirements
                    </div>
                    <ul>
                        <li>At least 8 characters long</li>
                        <li>At least one uppercase letter (A-Z)</li>
                        <li>At least one lowercase letter (a-z)</li>
                        <li>At least one number (0-9)</li>
                        <li>At least one special character (@$!%*?&)</li>
                    </ul>
                </div>
                <form id="passwordForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Current Password <span style="color: var(--accent-danger);">*</span></label>
                        <div class="input-wrap">
                            <input type="password" name="current_password" id="current_password" class="form-input" placeholder="Enter current password" required>
                            <button type="button" class="eye-btn" onclick="togglePassword('current_password')">
                                <svg class="eye-show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg class="eye-hide" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">New Password <span style="color: var(--accent-danger);">*</span></label>
                        <div class="input-wrap">
                            <input type="password" name="password" id="password" class="form-input" placeholder="Enter new password" required>
                            <button type="button" class="eye-btn" onclick="togglePassword('password')">
                                <svg class="eye-show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg class="eye-hide" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password <span style="color: var(--accent-danger);">*</span></label>
                        <div class="input-wrap">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Confirm new password" required>
                            <button type="button" class="eye-btn" onclick="togglePassword('password_confirmation')">
                                <svg class="eye-show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg class="eye-hide" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="settings-card-footer">
                <button type="button" class="btn-primary" id="updatePasswordBtn" disabled title="Please fill all fields">Update Password</button>
                <button type="button" class="btn-primary" id="updateLogoutBtn" disabled title="Please fill all fields">Update & Logout</button>
            </div>
        </div>
    </div>
</div>

<script>
// v=20260626-1 - cache-bust: hard-refresh (Ctrl+Shift+R) if old code runs
function togglePassword(id) {
    var input = document.getElementById(id);
    var btn = input.nextElementSibling;
    var eyeShow = btn.querySelector('.eye-show');
    var eyeHide = btn.querySelector('.eye-hide');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeShow.style.display = 'none';
        eyeHide.style.display = 'block';
    } else {
        input.type = 'password';
        eyeShow.style.display = 'block';
        eyeHide.style.display = 'none';
    }
}

function updatePassword(doLogout) {
    var btn = doLogout ? document.getElementById('updateLogoutBtn') : document.getElementById('updatePasswordBtn');
    var form = document.getElementById('passwordForm');
    var formData = new FormData(form);
    var token = document.querySelector('input[name="_token"]').value;
    
    btn.disabled = true;
    btn.textContent = 'Updating...';
    if (!doLogout) {
        document.getElementById('updateLogoutBtn').disabled = true;
    } else {
        document.getElementById('updatePasswordBtn').disabled = true;
    }
    
    fetch('/api/profile/password', {
        method: 'PATCH',
        body: JSON.stringify({
            current_password: formData.get('current_password'),
            password: formData.get('password'),
            password_confirmation: formData.get('password_confirmation')
        }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(function(response) { 
        return response.json().then(function(data) {
            return { ok: response.ok, status: response.status, data: data };
        });
    })
    .then(function(result) {
        // SUCCESS: only when HTTP status is 2xx AND response has success=true
        var isSuccess = (result.ok === true && result.data && result.data.success === true);
        
        if (isSuccess) {
            if (doLogout) {
                fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                }).then(function() {
                    window.location.href = '/login';
                });
            } else {
                showSuccessToast('Password updated successfully!');
                form.reset();
            }
        } else {
            // ERROR: any non-success case (validation errors, 422, 500, etc.)
            var errorMsg = 'An error occurred';
            if (result.data && result.data.errors && typeof result.data.errors === 'object') {
                var errors = result.data.errors;
                for (var field in errors) {
                    if (errors[field] && errors[field].length > 0) {
                        errorMsg = errors[field][0];
                        break;
                    }
                }
            } else if (result.data && result.data.error) {
                errorMsg = result.data.error;
            }
            showErrorToast(errorMsg);
        }
        
        btn.disabled = false;
        btn.textContent = doLogout ? 'Update & Logout' : 'Update Password';
        document.getElementById('updatePasswordBtn').disabled = false;
        document.getElementById('updateLogoutBtn').disabled = false;
    })
    .catch(function() {
        showErrorToast('Network error. Please try again.');
        btn.disabled = false;
        btn.textContent = doLogout ? 'Update & Logout' : 'Update Password';
        document.getElementById('updatePasswordBtn').disabled = false;
        document.getElementById('updateLogoutBtn').disabled = false;
    });
}

document.getElementById('updatePasswordBtn').addEventListener('click', function() {
    updatePassword(false);
});

document.getElementById('updateLogoutBtn').addEventListener('click', function() {
    updatePassword(true);
});

// Enable/disable buttons based on form fill
function checkFormFields() {
    var curr = document.getElementById('current_password').value.trim();
    var pass = document.getElementById('password').value.trim();
    var confirm = document.getElementById('password_confirmation').value.trim();
    var filled = curr && pass && confirm;
    document.getElementById('updatePasswordBtn').disabled = !filled;
    document.getElementById('updateLogoutBtn').disabled = !filled;
}

document.getElementById('current_password').addEventListener('input', checkFormFields);
document.getElementById('password').addEventListener('input', checkFormFields);
document.getElementById('password_confirmation').addEventListener('input', checkFormFields);

// Remove any existing global toast functions to avoid conflicts with layout
if (typeof window.showToast === 'function') { window.showToast = undefined; try { delete window.showToast; } catch(e) {} }

function passwordPageToast(msg, type) {
    var toastId = type === 'success' ? 'ppt-success' : 'ppt-error';
    var t = document.getElementById(toastId);
    if (t) { t.remove(); }
    t = document.createElement('div');
    t.id = toastId;
    if (type === 'success') {
        t.style.cssText = 'position:fixed;top:5rem;right:2rem;background:linear-gradient(135deg, #22c55e 0%, #16a34a 100%);color:white;padding:14px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;box-shadow:0 8px 30px rgba(34,197,94,0.4);z-index:10000;max-width:350px;';
        t.innerHTML = '<span style="width:28px;height:28px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;font-weight:bold;">&#10003;</span><span style="font-size:0.9rem;font-weight:600;">' + msg + '</span>';
    } else {
        t.style.cssText = 'position:fixed;top:5rem;right:2rem;background:linear-gradient(135deg, #ef4444 0%, #dc2626 100%);color:white;padding:14px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;box-shadow:0 8px 30px rgba(239,68,68,0.4);z-index:10000;max-width:350px;';
        t.innerHTML = '<span style="width:28px;height:28px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;font-weight:bold;">&#10007;</span><span style="font-size:0.9rem;font-weight:600;">' + msg + '</span>';
    }
    document.body.appendChild(t);
    setTimeout(function() { t.style.display = 'none'; }, 3000);
}
function passwordPageToastSuccess(msg) { passwordPageToast(msg, 'success'); }
function passwordPageToastError(msg) { passwordPageToast(msg, 'error'); }

// Update references from old names to new unique names
var showSuccessToast = passwordPageToastSuccess;
var showErrorToast = passwordPageToastError;
</script>
@endsection