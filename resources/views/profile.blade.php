@extends('layouts.app')

@section('title', 'Account Settings - ServerAvatar MCP')
@section('breadcrumb', 'Account Settings')

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
    .form-input { width: 100%; padding: 0.75rem 1rem; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.9rem; color: var(--text-primary); transition: all 0.2s ease; box-sizing: border-box; }
    .form-input:focus { outline: none; border-color: var(--accent-primary); background: var(--bg-card); }
    .form-input::placeholder { color: var(--text-muted); }
    .settings-card-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; }
    .btn-primary { padding: 0.625rem 1.5rem; background: var(--accent-primary); color: white; border: none; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
    .btn-primary:hover { background: var(--accent-primary-hover); }
    .btn-danger { padding: 0.625rem 1.5rem; background: var(--accent-danger); color: white; border: 1px solid var(--accent-danger); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
    .btn-danger:hover { background: #dc2626; border-color: #dc2626; }
    .btn-secondary { padding: 0.625rem 1.25rem; background: transparent; color: var(--text-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
    .btn-secondary:hover { background: var(--bg-card-hover); color: var(--text-primary); }
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); align-items: center; justify-content: center; z-index: 9999; }
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

<div style="display: flex; justify-content: center;">
    <div class="settings-tabs">
    <a href="/account" class="settings-tab active">
        <i class="fas fa-user tab-icon"></i> Account
    </a>
    <a href="/account/password" class="settings-tab ">
        <i class="fas fa-lock tab-icon"></i> Change Password
    </a>
    <a href="/account/api" class="settings-tab ">
        <i class="fas fa-key tab-icon"></i> API Access
    </a>
</div>
    </div>

<div class="settings-content">
    <div class="settings-card">
        <div class="settings-card-header">
            <h2 class="settings-card-title">Personal Information</h2>
        </div>
        <div class="settings-card-body">
            <form id="profileForm">
                @csrf
                <div class="form-group">
                    <label class="form-label">Full Name <span style="color: var(--accent-danger);">*</span></label>
                    <input type="text" name="name" id="nameInput" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" id="emailInput" class="form-input" disabled>
                </div>
            </form>
        </div>
        <div class="settings-card-footer">
            <button type="button" class="btn-primary" onclick="submitProfile()">Save Changes</button>
        </div>
    </div>

    <div class="settings-card" style="margin-top: 1rem;">
        <div class="settings-card-header">
            <h2 class="settings-card-title" style="color: var(--accent-danger);">Danger Zone</h2>
        </div>
        <div class="settings-card-body">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">Delete Account</div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary);">Permanently delete your account and all associated data. This action cannot be undone.</div>
                </div>
                <button type="button" class="btn-danger" onclick="openDeleteModal()">Delete Account</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal-overlay" id="deleteModal">
    <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 2rem; max-width: 400px; width: 90%;">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--accent-danger);">Delete Account</h3>
        <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 1.5rem;">Are you sure you want to delete your account? This action is permanent and cannot be undone. All your data will be lost.</p>
        <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
            <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-danger" onclick="confirmDelete()">Delete Account</button>
        </div>
    </div>
</div>

<div id="toast" class="toast" style="display: none;">
    <span class="toast-icon">✓</span>
    <span class="toast-message"></span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/profile', { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => {
                document.getElementById('nameInput').value = data.name || '';
                document.getElementById('emailInput').value = data.email || '';
            });
    });

    function submitProfile() {
        const formData = new FormData();
        formData.append('name', document.getElementById('nameInput').value);
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        fetch('/api/profile', { method: 'PATCH', body: formData, headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => {
                if (data.success) { showToast('Profile updated successfully!'); }
                else { showToast(data.error || 'Update failed', true); }
            });
    }

    function openDeleteModal() { document.getElementById('deleteModal').style.display = 'flex'; }
    function closeDeleteModal() { document.getElementById('deleteModal').style.display = 'none'; }

    function confirmDelete() {
        fetch('/api/account', { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value } })
            .then(r => r.json())
            .then(data => {
                if (data.success) { window.location.href = '/'; }
                else { showToast(data.error || 'Delete failed', true); }
            });
    }

    function showToast(msg, err = false) {
        const toast = document.getElementById('toast');
        toast.querySelector('.toast-message').textContent = msg;
        toast.className = 'toast ' + (err ? 'error' : '');
        toast.style.display = 'flex';
        setTimeout(() => { toast.style.display = 'none'; }, 3000);
    }
</script>
@endsection
