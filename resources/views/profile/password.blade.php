@extends('layouts.app')

@section('title', 'Change Password - ServerAvatar MCP')
@section('breadcrumb', 'Change Password')

@section('styles')
<style>
    .settings-tabs { margin-bottom: 1.5rem; text-align: center; }
    .settings-tab { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: all 0.2s ease; margin-right: 0.5rem; margin-bottom: 0.5rem; }
    .settings-tab:hover { background: var(--bg-card-hover); color: var(--text-primary); border-color: var(--accent-primary); }
    .settings-tab.active { background: var(--accent-primary); color: white; border-color: var(--accent-primary); }
    .settings-tab .tab-icon { font-size: 0.9rem; }
    .settings-tab .icon { font-size: 1rem; }
    .settings-content { flex: 1; min-width: 0; }
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
    .info-box { background: var(--accent-primary-muted); border: 1px solid rgba(99, 102, 241, 0.2); border-radius: var(--radius-md); padding: 1rem 1.25rem; margin-bottom: 1.5rem; }
    .info-box-title { font-size: 0.8rem; font-weight: 700; color: var(--accent-primary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 6px; }
    .info-box ul { margin: 0; padding-left: 1.25rem; }
    .info-box li { font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.25rem; }
    .info-box li:last-child { margin-bottom: 0; }
    @media (max-width: 768px) {
        .settings-tabs { flex-wrap: wrap; }
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
    <a href="/account/password" class="settings-tab active">
        <span class="icon"><i class="fas fa-lock"></i></span>
        Change Password
    </a>
    <a href="/account/api" class="settings-tab">
        <span class="icon"><i class="fas fa-key"></i></span>
        API Access
    </a>
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
                            <i class="fas fa-eye" style="font-size: 15px;"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">New Password <span style="color: var(--accent-danger);">*</span></label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="password" class="form-input" placeholder="Enter new password" required>
                        <button type="button" class="eye-btn" onclick="togglePassword('password')">
                            <i class="fas fa-eye" style="font-size: 15px;"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm New Password <span style="color: var(--accent-danger);">*</span></label>
                    <div class="input-wrap">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Confirm new password" required>
                        <button type="button" class="eye-btn" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" style="font-size: 15px;"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="settings-card-footer">
            <button type="button" class="btn-primary" id="updatePasswordBtn" disabled>Update Password</button>
            <button type="button" class="btn-primary" id="updateLogoutBtn" disabled>Update & Logout</button>
        </div>
    </div>
</div>

<script>
function togglePassword(id) {
    var input = document.getElementById(id);
    var btn = input.nextElementSibling;
    var eye = btn.querySelector('i');
    if (input.type === 'password') { input.type = 'text'; eye.className = 'fas fa-eye-slash'; }
    else { input.type = 'password'; eye.className = 'fas fa-eye'; }
}

function updatePassword(doLogout) {
    var btn = doLogout ? document.getElementById('updateLogoutBtn') : document.getElementById('updatePasswordBtn');
    var form = document.getElementById('passwordForm');
    var formData = new FormData(form);
    var token = document.querySelector('input[name="_token"]').value;

    btn.disabled = true;
    btn.textContent = 'Updating...';

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
    .then(function(response) { return response.json().then(function(data) { return { ok: response.ok, data: data }; }); })
    .then(function(result) {
        var isSuccess = (result.ok === true && result.data && result.data.success === true);

        if (isSuccess) {
            if (doLogout) {
                fetch('/logout', { method: 'POST', headers: { 'X-CSRF-TOKEN': token } }).then(function() { window.location.href = '/login'; });
            } else {
                showToast('Password updated successfully!');
                form.reset();
            }
        } else {
            var errorMsg = 'An error occurred';
            if (result.data && result.data.errors) {
                for (var field in result.data.errors) {
                    if (result.data.errors[field] && result.data.errors[field].length > 0) {
                        errorMsg = result.data.errors[field][0]; break;
                    }
                }
            } else if (result.data && result.data.error) {
                errorMsg = result.data.error;
            }
            showToast(errorMsg, true);
        }
        btn.disabled = false;
        btn.textContent = doLogout ? 'Update & Logout' : 'Update Password';
    })
    .catch(function() { showToast('Network error. Please try again.', true); btn.disabled = false; btn.textContent = doLogout ? 'Update & Logout' : 'Update Password'; });
}

document.getElementById('updatePasswordBtn').addEventListener('click', function() { updatePassword(false); });
document.getElementById('updateLogoutBtn').addEventListener('click', function() { updatePassword(true); });

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

function showToast(msg, isError) {
    var t = document.getElementById('toast');
    if (!t) { t = document.createElement('div'); t.id = 'toast'; document.body.appendChild(t); }
    t.style.cssText = 'position:fixed;top:5rem;right:2rem;background:' + (isError ? 'linear-gradient(135deg,#ef4444,#dc2626)' : 'linear-gradient(135deg,#22c55e,#16a34a)') + ';color:white;padding:14px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;box-shadow:0 8px 30px ' + (isError ? 'rgba(239,68,68,0.4)' : 'rgba(34,197,94,0.4)') + ';z-index:10000;max-width:350px;';
    t.innerHTML = '<span>' + msg + '</span>';
    setTimeout(function() { t.style.display = 'none'; }, 3000);
}
</script>
@endsection
