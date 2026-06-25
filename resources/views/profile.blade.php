@extends('layouts.app')

@section('title', 'Profile - ServerAvatar MCP')

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
            <a href="/account" class="settings-nav-item active">
                <span class="icon">👤</span>
                Account
            </a>
            <a href="/account/password" class="settings-nav-item">
                <span class="icon">🔒</span>
                Change Password
            </a>
            <a href="/account/api" class="settings-nav-item">
                <span class="icon">🔑</span>
                API Access
            </a>
        </nav>
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
                <button type="button" class="btn-primary" id="saveBtn">Save Changes</button>
            </div>
        </div>

        <!-- Delete Account Section -->
        <div class="settings-card" style="margin-top: 1.5rem;">
            <div class="settings-card-header">
                <h2 class="settings-card-title">Delete Account</h2>
            </div>
            <div class="settings-card-body" style="padding: 1rem 1.5rem;">
                <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: var(--radius-md); padding: 0.75rem 1rem; display: flex; align-items: flex-start; gap: 0.625rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0; line-height: 1.5;">Once you delete your account, there is no going back. All your data will be permanently removed.</p>
                </div>
            </div>
            <div class="settings-card-footer">
                <button type="button" class="btn-danger" id="deleteAccountBtn">Delete My Account</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal-overlay" id="deleteModal" style="display: none;">
    <div class="modal-content" style="background: var(--bg-card); border-radius: var(--radius-lg); max-width: 460px; width: 100%; margin: 1rem; overflow: hidden;">
        <div class="modal-header" style="padding: 0.875rem 1rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 0.625rem;">
                <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(239, 68, 68, 0.1); display: flex; align-items: center; justify-content: center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h3 style="margin: 0; font-size: 1rem; font-weight: 600; color: var(--text-primary);">Delete Account</h3>
            </div>
            <button onclick="closeDeleteModal()" style="background: rgba(255,255,255,0.05); border: none; width: 28px; height: 28px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.8rem;">✕</button>
        </div>
        <div style="padding: 1rem 1.25rem;">
            <div style="padding: 0.75rem 1rem;">
            <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: var(--radius-md); padding: 0.75rem 1rem; margin-bottom: 1rem;">
                <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0; line-height: 1.5;">This action cannot be undone. This will permanently delete your account, data, and remove all your integrations.</p>
            </div>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0 0 0.75rem 0;">To confirm, type <strong style="color: var(--accent-danger);">DELETE</strong> in the input box below:</p>
            <input type="text" id="deleteConfirmInput" placeholder="Type DELETE" style="width: 100%; padding: 8px 12px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--text-primary); font-size: 0.9rem; box-sizing: border-box; outline: none;" oninput="toggleDeleteBtn()">
        </div>
        <div style="padding: 0.875rem 1.25rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
            <button onclick="closeDeleteModal()" class="btn-secondary">Cancel</button>
            <button id="confirmDeleteBtn" disabled style="padding: 0.625rem 1.25rem; background: #ef4444; color: white; border: none; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; opacity: 0.5;">Delete Account</button>
        </div>
    </div>
</div>

<script>
// Fetch user profile on load
fetch('/api/profile', {
    headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    }
})
.then(function(response) { return response.json(); })
.then(function(data) {
    document.getElementById('nameInput').value = data.name;
    document.getElementById('emailInput').value = data.email;
});

// Save profile on click
document.getElementById('saveBtn').addEventListener('click', function() {
    var btn = this;
    var name = document.getElementById('nameInput').value;
    var token = document.querySelector('input[name="_token"]').value;
    
    btn.disabled = true;
    btn.textContent = 'Saving...';
    
    fetch('/api/profile', {
        method: 'PATCH',
        body: JSON.stringify({ name: name }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        var t = document.getElementById('toast');
        if (!t) {
            t = document.createElement('div');
            t.id = 'toast';
            t.style.cssText = 'position:fixed;top:5rem;right:2rem;background:linear-gradient(135deg, #22c55e 0%, #16a34a 100%);color:white;padding:14px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;box-shadow:0 8px 30px rgba(34,197,94,0.4);z-index:10000;max-width:350px;';
            document.body.appendChild(t);
        }
        t.innerHTML = '<span style="width:28px;height:28px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;font-weight:bold;">✓</span><span style="font-size:0.9rem;font-weight:600;">Profile updated successfully!</span>';
        t.style.display = 'flex';
        btn.disabled = false;
        btn.textContent = 'Save Changes';
        setTimeout(function() { t.style.display = 'none'; }, 3000);
    })
    .catch(function(error) {
        btn.disabled = false;
        btn.textContent = 'Save Changes';
    });
});

// Delete Account Modal
function openDeleteModal() {
    document.getElementById('deleteModal').style.display = 'flex';
    document.getElementById('deleteConfirmInput').value = '';
    document.getElementById('confirmDeleteBtn').disabled = true;
    document.getElementById('confirmDeleteBtn').style.opacity = '0.5';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function toggleDeleteBtn() {
    var input = document.getElementById('deleteConfirmInput').value;
    var btn = document.getElementById('confirmDeleteBtn');
    if (input === 'DELETE') {
        btn.disabled = false;
        btn.style.opacity = '1';
    } else {
        btn.disabled = true;
        btn.style.opacity = '0.5';
    }
}

document.getElementById('deleteAccountBtn').addEventListener('click', function() {
    openDeleteModal();
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    var btn = this;
    var token = document.querySelector('input[name="_token"]').value;
    btn.disabled = true;
    btn.textContent = 'Deleting...';

    fetch('{{ route('api.account.delete') }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        closeDeleteModal();
        var t = document.getElementById('toast');
        if (!t) {
            t = document.createElement('div');
            t.id = 'toast';
            t.style.cssText = 'position:fixed;top:5rem;right:2rem;background:linear-gradient(135deg, #16a34a 0%, #15803d 100%);color:white;padding:14px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;box-shadow:0 8px 30px rgba(22,163,74,0.4);z-index:10000;max-width:350px;';
            document.body.appendChild(t);
        }
        t.innerHTML = '<span style="width:28px;height:28px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;font-weight:bold;">✓</span><span style="font-size:0.9rem;font-weight:600;">Account deleted successfully!</span>';
        t.style.display = 'flex';
        setTimeout(function() { window.location.href = '/login'; }, 1500);
    })
    .catch(function(error) {
        alert('Error deleting account');
        btn.disabled = false;
        btn.textContent = 'Delete Account';
    });
});
</script>
@endsection