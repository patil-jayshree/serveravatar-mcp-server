            <div id="apiKeyModal" class="modal-overlay">
                <div class="modal-content api-modal">
                    <div class="modal-header">
                        <div class="modal-title-row">
                            <span class="modal-icon">🔑</span>
                            <h3>{{ isset($hasApiKey) && $hasApiKey ? 'Update API Key' : 'Add API Key' }}</h3>
                        </div>
                        <button type="button" class="modal-close" onclick="closeApiKeyModal()">&times;</button>
                    </div>
                    <form id="apiKeyForm">
                        @csrf
                        <div class="modal-body">
                            <p class="modal-intro">{{ isset($hasApiKey) && $hasApiKey ? 'Enter your updated ServerAvatar API key below.' : 'Enter your ServerAvatar API key below.' }}</p>
                            <label class="modal-label">New API Key <span class="required-star">*</span></label>
                            <div class="input-password-wrap">
                                <input type="password" id="apiKeyInput" name="api_key" placeholder="Enter your API key" required value="{{ $apiKey ?? '' }}">
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                                    <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                        <line x1="1" y1="1" x2="23" y2="23"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="security-tips">
                                <div class="tips-title">Security Best Practices</div>
                                <ul class="tips-list">
                                    <li>Never share your API key with anyone</li>
                                    <li>Store it securely in environment variables</li>
                                    <li>Rotate your key periodically</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-modal-cancel" onclick="closeApiKeyModal()">Cancel</button>
                            <button type="submit" class="btn-modal-save">{{ isset($hasApiKey) && $hasApiKey ? 'Update API Key' : 'Add API Key' }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                // Override layout functions AFTER layout scripts load (ensures our versions win)
                document.addEventListener('DOMContentLoaded', function() {
                    window.openApiKeyModal = function() {
                        var modal = document.getElementById('apiKeyModal');
                        var input = document.getElementById('apiKeyInput');
                        var titleEl = modal.querySelector('.modal-title-row h3');
                        var saveBtn = modal.querySelector('.btn-modal-save');
                        var hasApiKey = {{ isset($hasApiKey) && $hasApiKey ? 'true' : 'false' }};

                        if (hasApiKey) {
                            titleEl.textContent = 'Update API Key';
                            saveBtn.textContent = 'Update API Key';
                            input.value = '{{ $apiKey ?? '' }}';
                        } else {
                            titleEl.textContent = 'Add API Key';
                            saveBtn.textContent = 'Add API Key';
                            input.value = '';
                        }

                        if (modal) { modal.style.display = 'flex'; }
                        if (input) { input.focus(); }
                    };

                    window.closeApiKeyModal = function() {
                        var modal = document.getElementById('apiKeyModal');
                        var input = document.getElementById('apiKeyInput');
                        if (modal) { modal.style.display = 'none'; }
                        if (input) {
                            input.value = '';
                            input.type = 'password';
                            var eyeIcon = document.querySelector('.eye-icon');
                            var eyeOffIcon = document.querySelector('.eye-off-icon');
                            if (eyeIcon) eyeIcon.style.display = 'block';
                            if (eyeOffIcon) eyeOffIcon.style.display = 'none';
                        }
                    };

                    window.togglePasswordVisibility = function() {
                        var input = document.getElementById('apiKeyInput');
                        var eyeIcon = document.querySelector('.eye-icon');
                        var eyeOffIcon = document.querySelector('.eye-off-icon');
                        if (input.type === 'password') {
                            input.type = 'text';
                            if (eyeIcon) eyeIcon.style.display = 'none';
                            if (eyeOffIcon) eyeOffIcon.style.display = 'block';
                        } else {
                            input.type = 'password';
                            if (eyeIcon) eyeIcon.style.display = 'block';
                            if (eyeOffIcon) eyeOffIcon.style.display = 'none';
                        }
                    };
                }, { once: true });

                document.getElementById('apiKeyForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    var form = this;
                    var formData = new FormData(form);
                    var submitBtn = form.querySelector('.btn-modal-save');
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Saving...';
                    
                    fetch('{{ route('dashboard.api-key') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(response) { return response.json(); })
                    .then(function(data) {
                        if (data.success || data.message || data.status) {
                            closeApiKeyModal();
                            var toast = document.getElementById('toast') || createToast();
                            toast.innerHTML = '<span class="toast-icon">✓</span><span class="toast-message">API Key updated successfully!</span>';
                            toast.classList.add('show');
                            setTimeout(function() { toast.classList.remove('show'); location.reload(); }, 1500);
                        } else {
                            var toast = document.getElementById('toast') || createToastError();
                            toast.innerHTML = '<span class="toast-icon">✕</span><span class="toast-message">' + (data.error || 'Error updating API key') + '</span>';
                            toast.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
                            toast.style.boxShadow = '0 8px 30px rgba(239,68,68,0.4)';
                            toast.classList.add('show');
                            setTimeout(function() { toast.classList.remove('show'); }, 3000);
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Save API Key';
                        }
                    })
                    .catch(function(error) {
                        var toast = document.getElementById('toast') || createToastError();
                        toast.innerHTML = '<span class="toast-icon">✕</span><span class="toast-message">Error updating API key</span>';
                        toast.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
                        toast.style.boxShadow = '0 8px 30px rgba(239,68,68,0.4)';
                        toast.classList.add('show');
                        setTimeout(function() { toast.classList.remove('show'); }, 3000);
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Save API Key';
                    });
                });
                function createToast() {
                    var t = document.createElement('div');
                    t.id = 'toast';
                    t.className = 'toast';
                    t.style.cssText = 'position:fixed;top:5rem;right:2rem;background:linear-gradient(135deg, #22c55e 0%, #16a34a 100%);color:white;padding:14px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;box-shadow:0 8px 30px rgba(34,197,94,0.4);z-index:10000;max-width:350px;';
                    document.body.appendChild(t);
                    return t;
                }
                function createToastError() {
                    var t = document.createElement('div');
                    t.id = 'toast';
                    t.className = 'toast';
                    t.style.cssText = 'position:fixed;top:5rem;right:2rem;background:linear-gradient(135deg, #ef4444 0%, #dc2626 100%);color:white;padding:14px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;box-shadow:0 8px 30px rgba(239,68,68,0.4);z-index:10000;max-width:350px;';
                    document.body.appendChild(t);
                    return t;
                }
            </script>