@extends('layouts.app')

@section('title', 'MCP Server - ServerAvatar MCP')
@section('breadcrumb', 'MCP Server')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">MCP Server</h1>
    <p class="page-subtitle">Manage your MCP endpoint and connection details.</p>
</div>

<div style="display: flex; flex-direction: column; gap: 1.5rem;">

    <!-- Server Status Card -->
    <div class="card" style="padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 8px rgba(22, 163, 74, 0.5); flex-shrink: 0;"></span>
            <span style="font-size: 1rem; font-weight: 600; color: var(--text-primary);">Server Status: Online</span>
        </div>
        <p style="font-size: 0.875rem; color: var(--text-secondary); margin: 0; padding-left: 1.25rem;">Everything is running normally and ready to accept MCP client connections.</p>
    </div>

    <!-- MCP Server URL Card -->
    <div class="card" style="padding: 1.5rem;">
        <div class="section-header" style="margin-bottom: 1rem;">
            <div class="section-icon" style="background: rgba(59, 130, 246, 0.12);"><i class="fas fa-globe" style="color: var(--accent-primary);"></i></div>
            <div>
                <div class="section-title">MCP Server URL</div>
                <div class="section-desc">Use this endpoint to connect any MCP-compatible AI client</div>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="flex: 1; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 12px 16px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-link" style="color: var(--accent-primary);"></i>
                <span style="font-family: monospace; font-size: 14px; color: var(--text-primary);">https://mcp.178.105.137.4.nip.io/mcp/serveravatar</span>
            </div>
            <button onclick="copyMcpUrl(this)" id="copyUrlBtn" class="btn-card-action primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: var(--accent-primary); border: none; border-radius: var(--radius-md); color: white; font-weight: 600; cursor: pointer; white-space: nowrap; transition: background 0.2s, border 0.2s, color 0.2s;">
                <i class="fas fa-copy"></i> Copy URL
            </button>
        </div>
    </div>

    <!-- IDE Access Tokens -->
    <div class="card" style="padding: 2rem;">
        <!-- Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(124, 92, 246, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-key" style="color: #7c3aed; font-size: 1.2rem;"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <h2 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">IDE Access Tokens</h2>
                        <span style="background: rgba(124, 92, 246, 0.1); border: 1px solid rgba(124, 92, 246, 0.2); border-radius: 20px; padding: 2px 10px; font-size: 0.7rem; font-weight: 600; color: #7c3aed;">MCP</span>
                    </div>
                    <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--text-secondary);">Generate secure access tokens for IDE-based MCP clients such as Cursor, Windsurf, Cline and VS Code.</p>
                </div>
            </div>
        </div>

        <!-- Token Generation Section -->
        <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: flex; gap: 1rem; align-items: flex-start;">
                <div style="flex: 1;">
                    <label for="tokenName" style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.5rem;">Token Name</label>
                    <div style="display: flex; gap: 1rem; align-items: flex-end;">
                        <div style="flex: 1; position: relative;">
                            <i class="fas fa-key" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.85rem; pointer-events: none;"></i>
                            <input type="text" id="tokenName" placeholder="e.g., Cursor Development, Windsurf, VS Code" 
                                   style="width: 100%; padding: 12px 14px 12px 40px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-primary); font-size: 0.9rem; box-sizing: border-box;"
                                   oninput="if(this.value.length <= 255) { document.getElementById('tokenNameError').style.display = 'none'; }">
                        </div>
                        <button onclick="generateMcpToken()" id="generateTokenBtn" 
                                style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 0.9rem; cursor: pointer; white-space: nowrap; box-shadow: 0 4px 12px rgba(124, 92, 246, 0.3);">
                            <i class="fas fa-plus"></i> Generate Token
                        </button>
                    </div>
                    <p id="tokenNameError" style="color: #ef4444; font-size: 0.75rem; margin: 6px 0 0 0; display: none;">Token name cannot exceed 255 characters.</p>
                </div>
            </div>
            <div style="display: flex; align-items: flex-start; gap: 8px; margin-top: 1rem;">
                <i class="fas fa-info-circle" style="color: var(--text-muted); font-size: 0.8rem; margin-top: 2px;"></i>
                <p style="margin: 0; font-size: 0.8rem; color: var(--text-secondary); line-height: 1.4;">IDE clients like Cursor, Windsurf, and Cline use token-based authentication. Generate a token and add it to your IDE's MCP configuration.</p>
            </div>
        </div>

        <!-- Token Display (hidden by default) -->
        <div id="tokenDisplay" style="display: none; background: rgba(124, 92, 246, 0.06); border: 1px solid rgba(124, 92, 246, 0.15); border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; position: relative;">
            <button onclick="closeTokenDisplay()" style="position: absolute; top: 1rem; right: 1rem; background: transparent; border: none; color: var(--text-muted); cursor: pointer; padding: 4px;">
                <i class="fas fa-times" style="font-size: 1rem;"></i>
            </button>
            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: #7c3aed; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 4px;">
                    <i class="fas fa-check" style="color: white; font-size: 0.7rem;"></i>
                </div>
                <div style="flex: 1;">
                    <h4 style="margin: 0 0 4px 0; font-size: 1rem; font-weight: 600; color: var(--text-primary);">Access Token Generated</h4>
                    <p style="margin: 0 0 12px 0; font-size: 0.8rem; color: var(--text-secondary);">Your access token has been created successfully. <span style="color: #d97706; font-weight: 500;">This token will only be shown once.</span></p>
                    <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; padding: 12px; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
                        <code id="tokenValue" style="font-family: monospace; font-size: 0.85rem; color: var(--text-primary); word-break: break-all;"></code>
                        <button onclick="copyToken()" id="copyTokenBtn" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: transparent; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-secondary); font-size: 0.8rem; font-weight: 600; cursor: pointer; white-space: nowrap;">
                            <i class="fas fa-copy"></i> <span id="copyBtnText">Copy</span>
                        </button>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px; margin-top: 8px;">
                        <i class="fas fa-info-circle" style="color: var(--text-muted); font-size: 0.75rem;"></i>
                        <p style="margin: 0; font-size: 0.75rem; color: var(--text-muted);">Store it securely. It won't be shown again.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div id="statsRow" style="margin-bottom: 1.5rem;">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 12px; padding: 1rem 1.25rem; display: flex; align-items: center; gap: 0.875rem;">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(124, 92, 246, 0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-key" style="color: #7c3aed; font-size: 0.85rem;"></i>
                    </div>
                    <div>
                        <p style="margin: 0 0 2px 0; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Active Tokens</p>
                        <p style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-primary);" id="statActiveTokens">0</p>
                    </div>
                </div>
                <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 12px; padding: 1rem 1.25rem; display: flex; align-items: center; gap: 0.875rem;">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(124, 92, 246, 0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-calendar" style="color: #7c3aed; font-size: 0.85rem;"></i>
                    </div>
                    <div>
                        <p style="margin: 0 0 2px 0; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Last Generated</p>
                        <p style="margin: 0; font-size: 0.85rem; font-weight: 600; color: var(--text-primary);" id="statLastGenerated">-</p>
                    </div>
                </div>
                <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 12px; padding: 1rem 1.25rem; display: flex; align-items: center; gap: 0.875rem;">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(124, 92, 246, 0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-shield-halved" style="color: #7c3aed; font-size: 0.85rem;"></i>
                    </div>
                    <div>
                        <p style="margin: 0 0 2px 0; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Authentication</p>
                        <p style="margin: 0; font-size: 0.85rem; font-weight: 600; color: var(--text-primary);">Token Based</p>
                    </div>
                </div>
                <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 12px; padding: 1rem 1.25rem; display: flex; align-items: center; gap: 0.875rem;">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(124, 92, 246, 0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-clock" style="color: #7c3aed; font-size: 0.85rem;"></i>
                    </div>
                    <div>
                        <p style="margin: 0 0 2px 0; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Last Used</p>
                        <p style="margin: 0; font-size: 0.85rem; font-weight: 600; color: var(--text-primary);" id="statLastUsed">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Tokens Section -->
        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <h4 style="margin: 0; font-size: 1rem; font-weight: 600; color: var(--text-primary);">Active Tokens</h4>

                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.8rem; color: var(--text-secondary);">Sort by:</span>
                    <div style="position: relative;">
                        <select id="sortTokens" style="padding: 6px 28px 6px 12px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 0.8rem; font-weight: 500; cursor: pointer; appearance: none; -webkit-appearance: none;">
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                        </select>
                        <i class="fas fa-chevron-down" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-size: 0.65rem; color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>
            </div>
            <div id="tokensList">
                <div style="text-align: center; padding: 2rem; color: var(--text-secondary); font-size: 0.875rem;">
                    <i class="fas fa-key" style="font-size: 1.5rem; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                    <p style="margin: 0;">No tokens yet. Generate one above to get started.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Endpoint Information -->
    <div class="card" style="padding: 1.5rem;">
        <div class="section-header" style="margin-bottom: 1rem;">
            <div class="section-icon" style="background: rgba(139, 92, 246, 0.12);"><i class="fas fa-info-circle" style="color: var(--accent-primary);"></i></div>
            <div>
                <div class="section-title">Endpoint Information</div>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">Transport</span>
                <span style="font-size: 0.9rem; color: var(--text-primary); font-weight: 500;">HTTP</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">Authentication</span>
                <span style="font-size: 0.9rem; color: var(--text-primary); font-weight: 500;">OAuth 2.0 + API Key</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">Available Tools</span>
                <span style="font-size: 0.9rem; color: var(--text-primary); font-weight: 500;">{{ $toolsCount }}</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                <span style="font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">Status</span>
                <span style="font-size: 0.9rem; color: #16a34a; font-weight: 500;">Online</span>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="card" style="padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="section-icon" style="background: rgba(139, 92, 246, 0.12); width: 36px; height: 36px;"><i class="fas fa-circle-question" style="color: var(--accent-primary); font-size: 1rem;"></i></div>
            <div>
                <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-primary);">Need Help?</div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);">Check our documentation for setup guides and troubleshooting.</div>
            </div>
        </div>
        <a href="{{ route('guide') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: var(--radius-md); color: var(--accent-primary); text-decoration: none; font-size: 0.8rem; font-weight: 600; white-space: nowrap;">
            <i class="fas fa-book"></i> Documentation
        </a>
    </div>

</div>
@endsection

@section('scripts')
<script>
// Copy MCP URL
function copyMcpUrl(btn) {
    navigator.clipboard.writeText('https://mcp.178.105.137.4.nip.io/mcp/serveravatar').then(function() {
        btn.innerHTML = '<i class="fas fa-check"></i> Copied';
        btn.style.background = '#16a34a';
        btn.style.border = 'none';
        btn.style.color = 'white';
        btn.style.cursor = 'default';
        setTimeout(function() {
            btn.innerHTML = '<i class="fas fa-copy"></i> Copy URL';
            btn.style.background = 'var(--accent-primary)';
            btn.style.border = 'none';
            btn.style.color = 'white';
            btn.style.cursor = '';
        }, 2000);
    });
}

// Load existing tokens
async function loadTokens() {
    try {
        const response = await fetch('/mcp-tokens');
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            console.error('API Error:', response.status, response.statusText);
            return;
        }
        
        const data = await response.json();
        console.log('API Response:', data);
        
        const tokensList = document.getElementById('tokensList');
        const sortBy = document.getElementById('sortTokens').value;
        
        if (!data.tokens || data.tokens.length === 0) {
            tokensList.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: var(--text-secondary); font-size: 0.875rem;">
                    <i class="fas fa-key" style="font-size: 1.5rem; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                    <p style="margin: 0;">No tokens yet. Generate one above to get started.</p>
                </div>
            `;
            return;
        }
        
        // Sort tokens
        const sortedTokens = [...data.tokens].sort((a, b) => {
            if (sortBy === 'newest') {
                return new Date(b.created_at) - new Date(a.created_at);
            } else {
                return new Date(a.created_at) - new Date(b.created_at);
            }
        });
        
        document.getElementById('statActiveTokens').textContent = sortedTokens.length;
        
        // Update Last Generated stat
        if (sortedTokens.length > 0) {
            document.getElementById('statLastGenerated').textContent = formatDate(sortedTokens[0].created_at);
        } else {
            document.getElementById('statLastGenerated').textContent = '-';
        }
        
        // Update Last Used stat - find most recently used token
        const usedTokens = sortedTokens.filter(t => t.last_used_at);
        if (usedTokens.length > 0) {
            usedTokens.sort((a, b) => new Date(b.last_used_at) - new Date(a.last_used_at));
            document.getElementById('statLastUsed').textContent = formatDate(usedTokens[0].last_used_at);
        } else {
            document.getElementById('statLastUsed').textContent = 'Never';
        }
        
        tokensList.innerHTML = sortedTokens.map(token => `
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); margin-bottom: 0.5rem;">
                <div style="flex: 1;">
                    <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-primary);">${escapeHtml(token.name.replace('mcp:', ''))}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary); display: flex; align-items: center; gap: 12px;">
                        <span style="display: flex; align-items: center; gap: 5px;"><i class="far fa-calendar" style="color: var(--text-muted);"></i> Created ${formatDate(token.created_at)}</span>
                        <span style="width: 1px; height: 10px; background: var(--text-muted); opacity: 0.5;"></span>
                        <span style="display: flex; align-items: center; gap: 5px;"><i class="far fa-clock" style="color: var(--text-muted);"></i> ${token.last_used_at ? 'Last used ' + formatDate(token.last_used_at) : 'Never used'}</span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="display: inline-flex; align-items: center; padding: 1px 6px; background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 20px; font-size: 0.65rem; font-weight: 600; color: #22c55e; text-transform: uppercase; letter-spacing: 0.3px;">Active</span>
                    <button onclick="revokeToken('${token.id}', '${escapeHtml(token.name)}')" 
                        style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; background: transparent; border: 1px solid #ef4444; border-radius: var(--radius-sm); color: #ef4444; font-size: 0.75rem; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-trash"></i> Revoke
                    </button>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading tokens:', error);
    }
}

// Get CSRF token (Laravel embeds it in the page)
function getCsrfToken() {
    // Try meta tag first (if set)
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta) return meta.content;
    // Try Laravel's _token input
    const tokenInput = document.querySelector('input[name="_token"]');
    if (tokenInput) return tokenInput.value;
    return '';
}

// Generate new MCP token
async function generateMcpToken() {
    const name = document.getElementById('tokenName').value.trim();
    const btn = document.getElementById('generateTokenBtn');
    const errorEl = document.getElementById('tokenNameError');
    
    if (!name) {
        showToast('Please enter a token name', true);
        return;
    }
    
    if (name.length > 255) {
        errorEl.style.display = 'block';
        return;
    }
    
    errorEl.style.display = 'none';
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
    
    try {
        const response = await fetch('/mcp-tokens', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.error || 'Failed to generate token');
        }
        
        // Show the token ID (what ValidateMcpToken middleware expects)
        document.getElementById('tokenValue').textContent = data.token_id;
        document.getElementById('tokenDisplay').style.display = 'block';
        
        // Show success message
        showToast('Token generated successfully! Copy it now - you won\'t see it again.');
        
        // Clear input
        document.getElementById('tokenName').value = '';
        
        // Reload tokens list
        loadTokens();
        
    } catch (error) {
        showToast(error.message, true);
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-plus"></i> Generate Token';
    }
}

// Copy token to clipboard
function closeTokenDisplay() {
    document.getElementById('tokenDisplay').style.display = 'none';
}

function copyToken() {
    const token = document.getElementById('tokenValue').textContent;
    navigator.clipboard.writeText(token).then(function() {
        const btn = document.getElementById('copyTokenBtn');
        const btnText = document.getElementById('copyBtnText');
        btn.style.background = '#16a34a';
        btn.style.borderColor = '#16a34a';
        btn.style.color = 'white';
        btnText.textContent = 'Copied';
        setTimeout(function() {
            btn.style.background = 'transparent';
            btn.style.borderColor = 'var(--border-color)';
            btn.style.color = 'var(--text-secondary)';
            btnText.textContent = 'Copy';
        }, 2000);
    });
}

// Revoke a token
let pendingRevokeTokenId = null;

function revokeToken(tokenId, tokenName) {
    pendingRevokeTokenId = tokenId;
    const displayName = tokenName ? tokenName.replace('mcp:', '') : 'Unnamed Token';
    document.getElementById('revokeTokenNameBox').textContent = displayName;
    document.getElementById('revokeModal').style.display = 'flex';
    document.getElementById('revokeConfirmInput').value = '';
    document.getElementById('revokeError').style.display = 'none';
    document.getElementById('confirmRevokeBtn').disabled = true;
    document.getElementById('confirmRevokeBtn').style.opacity = '0.5';
    setTimeout(() => document.getElementById('revokeConfirmInput').focus(), 100);
}

function closeRevokeModal() {
    document.getElementById('revokeModal').style.display = 'none';
    pendingRevokeTokenId = null;
}

function toggleRevokeBtn() {
    const input = document.getElementById('revokeConfirmInput');
    const btn = document.getElementById('confirmRevokeBtn');
    const error = document.getElementById('revokeError');
    const val = input.value.trim();
    
    if (val === 'REVOKE') {
        btn.disabled = false;
        btn.style.opacity = '1';
        error.style.display = 'none';
        input.style.borderColor = 'var(--border-color)';
    } else if (val.length > 0) {
        btn.disabled = true;
        btn.style.opacity = '0.5';
        error.style.display = 'block';
        error.textContent = 'Please type REVOKE to confirm';
        input.style.borderColor = '#ef4444';
        input.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
    } else {
        btn.disabled = true;
        btn.style.opacity = '0.5';
        error.style.display = 'none';
        input.style.borderColor = 'var(--border-color)';
        input.style.boxShadow = 'none';
    }
}

async function confirmRevoke() {
    if (!pendingRevokeTokenId) return;
    
    const tokenId = pendingRevokeTokenId;
    closeRevokeModal();
    
    try {
        const response = await fetch(`/mcp-tokens/${tokenId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) {
            const data = await response.json();
            throw new Error(data.error || 'Failed to revoke token');
        }
        
        showToast('Token revoked successfully');
        loadTokens();
        
    } catch (error) {
        showToast(error.message, true);
    }
}

// Show message
function showToast(msg, isErr) {
    var t = document.getElementById('toast');
    if (!t) { t = document.createElement('div'); t.id = 'toast'; document.body.appendChild(t); }
    var icon = isErr ? '<i class="fas fa-times"></i>' : '<i class="fas fa-check"></i>';
    t.style.cssText = 'position:fixed;top:5rem;right:2rem;background:' + (isErr ? 'linear-gradient(135deg,#ef4444,#dc2626)' : 'linear-gradient(135deg,#22c55e,#16a34a)') + ';color:white;padding:14px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;box-shadow:0 8px 30px ' + (isErr ? 'rgba(239,68,68,0.4)' : 'rgba(34,197,94,0.4)') + ';z-index:10000;max-width:350px;min-width:250px;';
    t.innerHTML = '<span style="width:28px;height:28px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;">' + icon + '</span><span style="font-size:0.9rem;font-weight:600;">' + msg + '</span>';
    t.style.display = 'flex';
    setTimeout(function() { t.style.display = 'none'; }, 3000);
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = now - date;
    
    if (diff < 60000) return 'just now';
    if (diff < 3600000) return Math.floor(diff / 60000) + ' min ago';
    if (diff < 86400000) return Math.floor(diff / 3600000) + ' hours ago';
    if (diff < 604800000) return Math.floor(diff / 86400000) + ' days ago';
    
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

// Escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Load tokens on page load
document.addEventListener('DOMContentLoaded', loadTokens);

// Sort tokens on change
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('sortTokens').addEventListener('change', loadTokens);
});
</script>
@endsection

<!-- Revoke Token Modal -->
<div id="revokeModal" class="modal-overlay" style="display: none;">
    <div style="background: var(--bg-card); border-radius: 16px; width: 100%; max-width: 520px; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.5); border: 1px solid var(--border-color);">
        <!-- Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color);">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(239,68,68,0.12); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-exclamation-triangle" style="color: #ef4444; font-size: 1.1rem;"></i>
                </div>
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: var(--text-primary);">Revoke Access Token</h3>
            </div>
            <button type="button" onclick="closeRevokeModal()" style="background: var(--bg-secondary); border: 1px solid var(--border-color); width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); font-size: 0.9rem;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Body -->
        <div style="padding: 1.25rem 1.5rem;">
            <!-- Warning Box -->
            <div style="background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.15); border-radius: 12px; padding: 1rem; margin-bottom: 1rem;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(239,68,68,0.12); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 0.85rem;"></i>
                    </div>
                    <p style="margin: 0; font-size: 0.9rem; font-weight: 600; color: #ef4444;">This action cannot be undone.</p>
                </div>
                <p style="margin: 0; font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">Revoking this token will immediately disconnect any IDE or AI client using it. A new token must be generated and configured to restore access.</p>
            </div>
            
            <!-- Token Name Box -->
            <p style="margin: 0 0 0.75rem 0; font-size: 0.9rem; color: var(--text-primary); font-weight: 500;">Are you sure you want to revoke this token?</p>
            <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 10px; padding: 0.75rem 1rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 0.875rem; color: var(--text-secondary);">Token Name:</span>
                <span style="width: 1px; align-self: stretch; background: var(--border-color); margin: 0 4px;"></span>
                <span style="font-size: 0.875rem; color: var(--text-primary); font-weight: 600;" id="revokeTokenNameBox">-</span>
            </div>
            
            <!-- Confirmation Input -->
            <div style="margin-bottom: 1rem;">
                <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">To confirm this action, type <strong style="color: #ef4444;">REVOKE</strong> below.</p>
                <div style="position: relative;">
                    <i class="fas fa-lock" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.85rem;"></i>
                    <input type="text" id="revokeConfirmInput" placeholder="Type REVOKE to continue" oninput="toggleRevokeBtn()" style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; background: var(--bg-primary); border: 2px solid var(--border-color); border-radius: 10px; font-size: 0.9rem; color: var(--text-primary); box-sizing: border-box; outline: none; transition: border-color 0.2s;">
                </div>
                <p id="revokeError" style="color: #ef4444; font-size: 0.75rem; margin: 0.5rem 0 0 0; display: none;"></p>
            </div>
            
            <!-- Final Notice -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-shield-alt" style="color: #7c3aed; font-size: 0.85rem;"></i>
                <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);">This token will be permanently revoked and can no longer be used.</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="padding: 1rem 1.25rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
            <button type="button" onclick="closeRevokeModal()" style="padding: 0.625rem 1.25rem; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 10px; color: var(--text-secondary); font-size: 0.875rem; font-weight: 600; cursor: pointer;">Cancel</button>
            <button type="button" id="confirmRevokeBtn" onclick="confirmRevoke()" disabled style="padding: 0.625rem 1.25rem; background: #ef4444; border: none; border-radius: 10px; color: white; font-size: 0.875rem; font-weight: 600; cursor: pointer; opacity: 0.5; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-trash"></i> Revoke Token
            </button>
        </div>
    </div>
</div>

<style>
#revokeConfirmInput:focus { border-color: #7c3aed !important; box-shadow: 0 0 0 3px rgba(124,92,252,0.15); }
#confirmRevokeBtn:not(:disabled):hover { background: #dc2626; }
</style>
