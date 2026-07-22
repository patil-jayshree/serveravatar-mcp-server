@extends('layouts.app')

@section('title', 'MCP Guide - ServerAvatar MCP')
@section('breadcrumb', 'Guide')

@section('content')
<script>
window.clientsData = {
    chatgpt: {
        name: 'ChatGPT',
        image: '/images/clients/chatgpt-dark.png',
        imageLight: '/images/clients/chatgpt-light.png',
        badge: '2 min',
        steps: [
            { title: 'Log in to your ChatGPT Account', desc: 'Open ChatGPT and sign in to your account.' },
            { title: 'Enable Developer Mode', desc: 'Navigate to Settings and enable Developer Mode.' },
            { title: 'Create MCP Connector', desc: 'Click "Create New", name it "ServerAvatar MCP", and paste the connection URL.' },
            { title: 'Start Using ServerAvatar MCP', desc: 'Open a new chat and start managing your infrastructure!' }
        ]
    },
    claude: {
        name: 'Claude',
        image: '/images/clients/claude.png',
        badge: '2 min',
        steps: [
            { title: 'Log in to your Claude account', desc: 'Open Claude.ai and sign in to your account.' },
            { title: 'Open Settings', desc: 'Navigate to Settings.' },
            { title: 'Add a custom connector', desc: 'Click "Add Extension", name it "ServerAvatar MCP", and paste the connection URL.' },
            { title: 'Start Managing MCP', desc: 'Start a new conversation and use ServerAvatar tools!' }
        ]
    },
    cursor: {
        name: 'Cursor',
        image: '/images/clients/cursor-dark.png',
        imageLight: '/images/clients/cursor-light.png',
        badge: '3 min',
        steps: [
            { title: 'Install & Sign In', desc: 'Download and install Cursor, then sign in to your account.' },
            { title: 'Generate Token', desc: 'Go to your dashboard, navigate to MCP Panel, and generate a new IDE Access Token.' },
            { title: 'Open Settings', desc: 'Press Cmd/Ctrl + , to open Settings, then navigate to the MCP section.' },
            { title: 'Configuration', desc: 'Click "Add MCP Server", select HTTP, name it "ServerAvatar MCP", and paste the URL and token.' },
            { title: 'Verify the Connection', desc: 'Click "Check" next to your server to verify the connection is working.' },
            { title: 'Start using MCP', desc: 'Start coding and managing your servers directly!' }
        ]
    },
    vscode: {
        name: 'VS Code',
        image: '/images/clients/vscode.png',
        badge: '3 min',
        steps: [
            { title: 'Install VS Code', desc: 'Download and install Visual Studio Code.' },
            { title: 'Install Copilot Extensions', desc: 'Install GitHub Copilot and GitHub Copilot Chat extensions.' },
            { title: 'Add ServerAvatar MCP', desc: 'Add your MCP server to VS Code.' },
            { title: 'Authenticate', desc: 'OAuth or IDE Access Token.' },
            { title: 'Start Using', desc: 'Open GitHub Copilot Chat in Agent mode.' }
        ]
    },
    windsurf: {
        name: 'Windsurf',
        image: '/images/clients/windsurf-dark.png',
        imageLight: '/images/clients/windsurf-light.png',
        badge: '3 min',
        steps: [
            { title: 'Open Windsurf Settings', desc: 'Launch Windsurf and open Settings.' },
            { title: 'Go to MCP Settings', desc: 'Navigate to the MCP section in settings.' },
            { title: 'Generate an IDE Access Token', desc: 'Go to your ServerAvatar dashboard, navigate to MCP Panel, and generate a new IDE Access Token.' },
            { title: 'Add MCP Server', desc: 'Click "Add Server", name it "ServerAvatar MCP", select HTTP, paste the URL and token.' },
            { title: 'Start Using', desc: 'Start building with AI-powered server management!' }
        ]
    }
};
</script>

<div x-data="{
    modalOpen: false,
    selectedClient: null,
    clients: window.clientsData || {},
    openModal(client) {
        this.selectedClient = this.clients[client];
        this.modalOpen = true;
        document.body.style.overflow = 'hidden';
    },
    closeModal() {
        this.modalOpen = false;
        this.selectedClient = null;
        document.body.style.overflow = '';
    }
}">
<style>
.blog-content { max-width: 800px; margin: 0 auto; }
.blog-content h2 { margin-top: 2rem; }
.blog-content h3 { margin-top: 1.5rem; color: var(--accent-primary); }
.blog-content pre { 
    background: var(--bg-tertiary); 
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    overflow-x: auto;
    font-size: 0.875rem;
}
.blog-content code {
    font-family: 'Fira Code', 'Monaco', monospace;
}
.blog-content .step-box {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1.25rem;
    margin: 1rem 0;
}
.blog-content .step-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background: #f5f3ff;
    color: #7c3aed;
    border-radius: 50%;
    font-size: 0.875rem;
    font-weight: 600;
    margin-right: 0.75rem;
}
.blog-content .client-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    margin: 1rem 0;
}
.blog-content .client-card h4 { margin-top: 0; color: var(--accent-primary); }
.blog-content .note-box {
    background: rgba(139, 92, 246, 0.1);
    border-left: 4px solid var(--accent-primary);
    padding: 1rem;
    border-radius: 0 8px 8px 0;
    margin: 1rem 0;
}
.blog-content .feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 1rem 0;
}
.blog-content .feature-item {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
}
.blog-content .feature-item i {
    font-size: 1.5rem;
    color: var(--accent-primary);
    margin-bottom: 0.5rem;
}
</style>

<div class="guide-banner" style="display:flex;flex-direction:row;align-items:flex-start;justify-content:space-between;padding:12px 24px 12px 24px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-sizing:border-box;min-height:200px;box-shadow:0 1px 3px rgba(0,0,0,0.04);">
    <div style="flex:1;padding-top:4px;">
        <h1 style="font-size:22px;font-weight:700;color:#0f172a;margin:0 0 6px 0;line-height:1.2;">MCP Guide</h1>
        <p style="font-size:14px;color:#475569;margin:0;line-height:1.5;max-width:520px;">Learn how to connect ServerAvatar MCP with your favorite AI clients and manage your infrastructure using natural language.</p>
    </div>
    <div style="flex-shrink:0;padding-left:24px;">
        <img src="/images/mcp-guide-illustration.png" alt="MCP Guide" style="width:220px;height:160px;object-fit:contain;" loading="lazy">
    </div>
</div>

<!-- Two Cards Row -->
<div style="display:flex;gap:24px;margin-top:20px;margin-bottom:24px;width:100%;box-sizing:border-box;">

<!-- Card 1: What is MCP? -->
<div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1.7;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
    <div style="margin-bottom:20px;">
        <h2 style="font-size:24px;font-weight:700;margin:0 0 12px 0;line-height:1.2;"><span style="color:#7c3aed;">1.</span> What is MCP?</h2>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Model Context Protocol (MCP) is an open standard that allows AI applications to securely connect with external tools and data sources. It acts as a bridge between AI assistants and your real-world infrastructure.</p>
    </div>
    
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:20px 16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:10px;"><i class="fas fa-globe"></i></div>
            <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:4px;">Universal Connection</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">One protocol, many integrations</div>
        </div>
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:20px 16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:10px;"><i class="fas fa-shield-alt"></i></div>
            <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:4px;">Secure</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">Authentication built-in</div>
        </div>
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:20px 16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:10px;"><i class="fas fa-bolt"></i></div>
            <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:4px;">Real-Time Data</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">Live information access</div>
        </div>
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:20px 16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:10px;"><i class="fas fa-wrench"></i></div>
            <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:4px;">Tools Access</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">Extensive capabilities</div>
        </div>
    </div>
    
    <!-- Info Box -->
    <div style="border:1px solid #e5e7eb;border-radius:12px;padding:20px;display:flex;align-items:flex-start;gap:14px;margin-top:16px;">
        <div style="width:36px;height:36px;min-width:36px;display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:20px;"><i class="fas fa-info-circle"></i></div>
        <div style="font-size:13px;color:#1a1a2e;line-height:1.6;padding-top:6px;">The AI client (ChatGPT, Claude, etc.) connects to an MCP server. The server exposes "tools" that the AI can use. When you ask the AI to do something, it can call these tools in real-time.</div>
    </div>
</div>

<!-- Card 2: How It Works -->
<div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
    <div style="margin-bottom:24px;">
        <h2 style="font-size:24px;font-weight:700;margin:0 0 8px 0;line-height:1.2;"><span style="color:#7c3aed;">2.</span> How MCP Works</h2>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">MCP follows a simple client-server architecture.</p>
    </div>
    
    <div style="display:flex;flex-direction:column;gap:6px;">
        <div style="background:#f3effd;border:1px solid #ede9fe;border-radius:12px;padding:16px;display:flex;align-items:center;gap:16px;">
            <div style="color:#7c3aed;font-size:24px;"><i class="fas fa-robot"></i></div>
            <div style="flex:1;">
                <div style="font-size:15px;font-weight:600;color:#1a1a2e;">AI Client</div>
                <div style="font-size:12px;color:#6b6b80;">ChatGPT, Claude, Cursor</div>
            </div>
        </div>
        
        <div style="display:flex;justify-content:center;margin:0;padding:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
        </div>
        
        <div style="background:#f3effd;border:1px solid #ede9fe;border-radius:12px;padding:16px;display:flex;align-items:center;gap:16px;">
            <div style="color:#7c3aed;font-size:24px;"><i class="fas fa-server"></i></div>
            <div style="flex:1;">
                <div style="font-size:15px;font-weight:600;color:#1a1a2e;">MCP Server</div>
                <div style="font-size:12px;color:#6b6b80;">ServerAvatar MCP</div>
            </div>
        </div>
        
        <div style="display:flex;justify-content:center;margin:0;padding:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
        </div>
        
        <div style="background:#f3effd;border:1px solid #ede9fe;border-radius:12px;padding:16px;display:flex;align-items:center;gap:16px;">
            <div style="color:#7c3aed;font-size:24px;"><i class="fas fa-globe"></i></div>
            <div style="flex:1;">
                <div style="font-size:15px;font-weight:600;color:#1a1a2e;">Real World</div>
                <div style="font-size:12px;color:#6b6b80;">Servers, Databases, APIs</div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Two Cards Row 2 -->
<div style="display:flex;gap:24px;margin-top:24px;width:100%;box-sizing:border-box;">

<!-- Card 3: What You Can Do with ServerAvatar MCP -->
<div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1.7;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
    <div style="margin-bottom:20px;">
        <h2 style="font-size:24px;font-weight:700;margin:0 0 8px 0;line-height:1.2;"><span style="color:#7c3aed;">3.</span> What You Can Do with ServerAvatar MCP</h2>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Manage your entire infrastructure using simple, natural language through your AI assistant.</p>
    </div>
    
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:8px;"><i class="fas fa-cog"></i></div>
            <div style="font-size:12px;font-weight:600;color:#1a1a2e;line-height:1.3;margin-bottom:4px;">Server Management</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">Restart services, monitor resources, check logs and more.</div>
        </div>
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:8px;"><i class="fas fa-cube"></i></div>
            <div style="font-size:12px;font-weight:600;color:#1a1a2e;line-height:1.3;margin-bottom:4px;">Application Management</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">Create, deploy, update and manage all your applications.</div>
        </div>
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:8px;"><i class="fas fa-database"></i></div>
            <div style="font-size:12px;font-weight:600;color:#1a1a2e;line-height:1.3;margin-bottom:4px;">Database Management</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">Create, delete, and manage databases with ease.</div>
        </div>
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:8px;"><i class="fas fa-shield-alt"></i></div>
            <div style="font-size:12px;font-weight:600;color:#1a1a2e;line-height:1.3;margin-bottom:4px;">Security & SSL</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">Install SSL certificates and manage firewall rules.</div>
        </div>
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:8px;"><i class="fab fa-wordpress"></i></div>
            <div style="font-size:12px;font-weight:600;color:#1a1a2e;line-height:1.3;margin-bottom:4px;">WordPress Management</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">Manage WordPress sites, plugins, themes, and updates.</div>
        </div>
        <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px;text-align:center;">
            <div style="color:#7c3aed;font-size:24px;margin-bottom:8px;"><i class="fas fa-clock"></i></div>
            <div style="font-size:12px;font-weight:600;color:#1a1a2e;line-height:1.3;margin-bottom:4px;">Cronjob Automation</div>
            <div style="font-size:11px;color:#6b6b80;line-height:1.4;">Create, manage, and monitor scheduled tasks.</div>
        </div>
    </div>
</div>

<!-- Card 4: Quick Setup -->
<div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
    <div style="margin-bottom:20px;">
        <h2 style="font-size:24px;font-weight:700;margin:0 0 8px 0;line-height:1.2;"><span style="color:#7c3aed;">4.</span> Quick Setup</h2>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Connect ServerAvatar MCP in 4 simple steps.</p>
    </div>
    
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div style="display:flex;align-items:flex-start;gap:14px;position:relative;">
            <div style="position:absolute;left:15px;top:16px;bottom:-16px;width:2px;background:transparent;border-left:2px dashed #7c3aed;z-index:0;"></div>
            <div style="width:32px;height:32px;background:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:700;flex-shrink:0;position:relative;z-index:1;">1</div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:600;color:#1a1a2e;line-height:32px;">Generate API Key</div>
                <div style="font-size:12px;color:#6b6b80;line-height:1.5;">Get your API Key from ServerAvatar Account Settings → API Access.</div>
            </div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:14px;position:relative;">
            <div style="position:absolute;left:15px;top:-16px;bottom:-16px;width:2px;background:transparent;border-left:2px dashed #7c3aed;z-index:0;"></div>
            <div style="width:32px;height:32px;background:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:700;flex-shrink:0;position:relative;z-index:1;">2</div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:600;color:#1a1a2e;line-height:32px;">Connect Your Account</div>
                <div style="font-size:12px;color:#6b6b80;line-height:1.5;">Add the API Key in ServerAvatar MCP Account Settings → API Access.</div>
            </div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:14px;position:relative;">
            <div style="position:absolute;left:15px;top:-16px;bottom:-16px;width:2px;background:transparent;border-left:2px dashed #7c3aed;z-index:0;"></div>
            <div style="width:32px;height:32px;background:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:700;flex-shrink:0;position:relative;z-index:1;">3</div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:600;color:#1a1a2e;line-height:32px;">Copy MCP Server URL</div>
                <div style="font-size:12px;color:#6b6b80;line-height:1.5;">Go to Endpoint & Tokens and copy your MCP Server URL.</div>
            </div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:14px;position:relative;">
            <div style="width:32px;height:32px;background:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:700;flex-shrink:0;position:relative;z-index:1;">4</div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:600;color:#1a1a2e;line-height:32px;">Connect AI Client</div>
                <div style="font-size:12px;color:#6b6b80;line-height:1.5;">Use the URL to connect your preferred AI client and start managing.</div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Card 5: Note -->
<div style="background:#f3effd;border:1px solid #e9d5ff;border-radius:12px;padding:20px;display:flex;align-items:flex-start;gap:14px;margin-top:20px;">
    <div style="color:#eab308;font-size:24px;min-width:24px;"><i class="fas fa-lightbulb"></i></div>
    <div style="font-size:13px;color:#1a1a2e;line-height:1.6;padding-top:2px;"><strong style="font-weight:600;">Note:</strong> IDE Access Tokens are only required for IDE-based AI clients such as Cursor, Windsurf, VS Code, Cline, and Continue. Browser-based AI clients like ChatGPT and Claude connect using the MCP Server URL and do not require an IDE Access Token.</div>
</div>

<!-- Cards 5 & 6 Row: Available Tools + Connect AI Clients -->
<div style="display:flex;gap:24px;margin-top:20px;width:100%;box-sizing:border-box;">

    <!-- Card 5: Available Tools -->
    <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
        <div style="margin-bottom:20px;">
            <h2 style="font-size:24px;font-weight:700;margin:0 0 6px 0;line-height:1.2;"><span style="color:#7c3aed;">5.</span> Available Tools</h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">ServerAvatar MCP provides 55+ tools across multiple categories.</p>
        </div>
        
        <!-- Available Tools Banner -->
        <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:12px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;gap:24px;margin-bottom:20px;flex-wrap:wrap;">
            <!-- Left Side: Icon + Text -->
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:52px;height:52px;min-width:52px;background:#f5f3ff;border:2px solid #ddd6fe;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-wrench" style="color:#7c3aed;font-size:22px;"></i>
                </div>
                <div>
                    <h3 style="font-size:15px;font-weight:700;color:#7c3aed;margin:0 0 4px 0;">Powerful. Organized. Ready to Use.</h3>
                    <p style="font-size:12px;color:#6b7280;margin:0;line-height:1.4;">Tools are grouped by category to help you quickly find the right capabilities for your workflow.</p>
                </div>
            </div>
            
            <!-- Divider -->
            <div style="width:1px;height:44px;background:#ddd6fe;display:none;"></div>
            
            <!-- Right Side: Stats -->
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                <!-- Stat 1: Total Tools -->
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:36px;height:36px;min-width:36px;background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-star" style="color:#7c3aed;font-size:14px;"></i>
                    </div>
                    <div>
                        <div style="font-size:18px;font-weight:700;color:#7c3aed;">55+</div>
                        <div style="font-size:11px;color:#6b7280;">Total Tools</div>
                    </div>
                </div>
                
                <!-- Stat 2: Categories -->
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:36px;height:36px;min-width:36px;background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-th-large" style="color:#7c3aed;font-size:14px;"></i>
                    </div>
                    <div>
                        <div style="font-size:18px;font-weight:700;color:#7c3aed;">10+</div>
                        <div style="font-size:11px;color:#6b7280;">Categories</div>
                    </div>
                </div>
                
                <!-- Stat 3: MCP Ready -->
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:36px;height:36px;min-width:36px;background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-bolt" style="color:#7c3aed;font-size:14px;"></i>
                    </div>
                    <div>
                        <div style="font-size:18px;font-weight:700;color:#7c3aed;">100%</div>
                        <div style="font-size:11px;color:#6b7280;">MCP Ready</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
            <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;cursor:pointer;transition:all 0.2s;">
                <div style="width:48px;height:48px;min-width:48px;background:#eff6ff;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-server" style="color:#3b82f6;font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;margin-bottom:3px;">Servers</div>
                    <div style="font-size:11px;color:#6b7280;line-height:1.4;">Manage and monitor servers, resources, and configurations</div>
                </div>
                <span style="background:#eff6ff;color:#3b82f6;font-size:10px;font-weight:600;padding:5px 10px;border-radius:20px;white-space:nowrap;">19 Tools</span>
            </div>
            <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;cursor:pointer;transition:all 0.2s;">
                <div style="width:48px;height:48px;min-width:48px;background:#eff6ff;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-globe" style="color:#3b82f6;font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;margin-bottom:3px;">Applications</div>
                    <div style="font-size:11px;color:#6b7280;line-height:1.4;">Deploy, manage and optimize your applications with ease</div>
                </div>
                <span style="background:#eff6ff;color:#3b82f6;font-size:10px;font-weight:600;padding:5px 10px;border-radius:20px;white-space:nowrap;">7 Tools</span>
            </div>
            <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;cursor:pointer;transition:all 0.2s;">
                <div style="width:48px;height:48px;min-width:48px;background:#fff7ed;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-hdd" style="color:#f97316;font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;margin-bottom:3px;">Databases</div>
                    <div style="font-size:11px;color:#6b7280;line-height:1.4;">Create, manage and optimize your databases</div>
                </div>
                <span style="background:#fff7ed;color:#f97316;font-size:10px;font-weight:600;padding:5px 10px;border-radius:20px;white-space:nowrap;">2 Tools</span>
            </div>
            <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;cursor:pointer;transition:all 0.2s;">
                <div style="width:48px;height:48px;min-width:48px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-shield-alt" style="color:#ef4444;font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;margin-bottom:3px;">Firewall</div>
                    <div style="font-size:11px;color:#6b7280;line-height:1.4;">Manage firewall rules and security settings</div>
                </div>
                <span style="background:#fef2f2;color:#ef4444;font-size:10px;font-weight:600;padding:5px 10px;border-radius:20px;white-space:nowrap;">4 Tools</span>
            </div>
            <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;cursor:pointer;transition:all 0.2s;">
                <div style="width:48px;height:48px;min-width:48px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-clock" style="color:#22c55e;font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;margin-bottom:3px;">Cronjobs</div>
                    <div style="font-size:11px;color:#6b7280;line-height:1.4;">Schedule and manage automated tasks</div>
                </div>
                <span style="background:#f0fdf4;color:#22c55e;font-size:10px;font-weight:600;padding:5px 10px;border-radius:20px;white-space:nowrap;">6 Tools</span>
            </div>
            <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;cursor:pointer;transition:all 0.2s;">
                <div style="width:48px;height:48px;min-width:48px;background:#eff6ff;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="fab fa-wordpress" style="color:#3b82f6;font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;margin-bottom:3px;">WordPress</div>
                    <div style="font-size:11px;color:#6b7280;line-height:1.4;">Manage WordPress sites, plugins, themes, and updates</div>
                </div>
                <span style="background:#eff6ff;color:#3b82f6;font-size:10px;font-weight:600;padding:5px 10px;border-radius:20px;white-space:nowrap;">33 Tools</span>
            </div>
        </div>
        
        <div style="margin-top:20px;text-align:center;">
            <a href="{{ url('/tools') }}" style="display:inline-flex;align-items:center;gap:8px;color:#7c3aed;font-size:14px;font-weight:600;text-decoration:none;">Explore All Tools <i class="fas fa-arrow-right" style="font-size:12px;"></i></a>
        </div>
    </div>
</div>

<!-- Card 6: Connect AI Clients -->
<div style="display:flex;gap:24px;margin-top:20px;width:100%;box-sizing:border-box;">
    <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
        <div style="margin-bottom:20px;">
            <h2 style="font-size:24px;font-weight:700;margin:0 0 6px 0;line-height:1.2;"><span style="color:#7c3aed;">6.</span> Connect AI Clients</h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Choose your AI client and follow the setup guide.</p>
        </div>
        
        <!-- How It Works Banner -->
        <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:12px;padding:20px;margin-bottom:20px;">
            <div style="display:flex;align-items:center;gap:20px;">
                <!-- Left Side: Title and Description -->
                <div style="display:flex;align-items:center;gap:16px;flex:1;">
                    <div style="width:48px;height:48px;min-width:48px;background:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(124,58,237,0.1);">
                        <i class="fas fa-book-open" style="color:#7c3aed;font-size:22px;"></i>
                    </div>
                    <div>
                        <h3 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 4px 0;">How it works</h3>
                        <p style="font-size:13px;color:#6b7280;margin:0;line-height:1.5;">Click on any AI client below to open a step-by-step setup guide. Each guide contains simple steps with screenshots for easy connection.</p>
                    </div>
                </div>
                
                <!-- Right Side: Steps -->
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;flex:1;">
                    <!-- Row 1: Circle Icons + Arrows -->
                    <div style="display:flex;align-items:center;justify-content:center;">
                        <!-- Step 1 -->
                        <div style="width:80px;display:flex;flex-direction:column;align-items:center;">
                            <div style="position:relative;width:56px;height:56px;display:flex;align-items:center;justify-content:center;">
                                <div style="position:absolute;top:-9px;left:50%;transform:translateX(-50%);width:20px;height:20px;background:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#fff;font-size:11px;font-weight:600;">1</span>
                                </div>
                                <div style="width:48px;height:48px;background:#f5f3ff;border:2px solid #ddd6fe;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-hand-pointer" style="color:#7c3aed;font-size:20px;"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Arrow 1 -->
                        <div style="width:50px;display:flex;align-items:center;justify-content:center;height:48px;">
                            <span style="color:#7c3aed;font-size:20px;font-weight:300;">---></span>
                        </div>
                        <!-- Step 2 -->
                        <div style="width:80px;display:flex;flex-direction:column;align-items:center;">
                            <div style="position:relative;width:56px;height:56px;display:flex;align-items:center;justify-content:center;">
                                <div style="position:absolute;top:-9px;left:50%;transform:translateX(-50%);width:20px;height:20px;background:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#fff;font-size:11px;font-weight:600;">2</span>
                                </div>
                                <div style="width:48px;height:48px;background:#f5f3ff;border:2px solid #ddd6fe;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-file-alt" style="color:#7c3aed;font-size:20px;"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Arrow 2 -->
                        <div style="width:50px;display:flex;align-items:center;justify-content:center;height:48px;">
                            <span style="color:#7c3aed;font-size:20px;font-weight:300;">---></span>
                        </div>
                        <!-- Step 3 -->
                        <div style="width:80px;display:flex;flex-direction:column;align-items:center;">
                            <div style="position:relative;width:56px;height:56px;display:flex;align-items:center;justify-content:center;">
                                <div style="position:absolute;top:-9px;left:50%;transform:translateX(-50%);width:20px;height:20px;background:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#fff;font-size:11px;font-weight:600;">3</span>
                                </div>
                                <div style="width:48px;height:48px;background:#f5f3ff;border:2px solid #ddd6fe;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-list-ul" style="color:#7c3aed;font-size:20px;"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Arrow 3 -->
                        <div style="width:50px;display:flex;align-items:center;justify-content:center;height:48px;">
                            <span style="color:#7c3aed;font-size:20px;font-weight:300;">---></span>
                        </div>
                        <!-- Step 4 -->
                        <div style="width:80px;display:flex;flex-direction:column;align-items:center;">
                            <div style="position:relative;width:56px;height:56px;display:flex;align-items:center;justify-content:center;">
                                <div style="position:absolute;top:-9px;left:50%;transform:translateX(-50%);width:20px;height:20px;background:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#fff;font-size:11px;font-weight:600;">4</span>
                                </div>
                                <div style="width:48px;height:48px;background:#f5f3ff;border:2px solid #ddd6fe;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-check" style="color:#7c3aed;font-size:20px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Row 2: Labels -->
                    <div style="display:flex;align-items:flex-start;justify-content:center;margin-top:12px;">
                        <div style="width:80px;text-align:center;">
                            <span style="font-size:12px;font-weight:500;color:#374151;white-space:nowrap;display:block;">Select AI Client</span>
                        </div>
                        <div style="width:50px;"></div>
                        <div style="width:80px;text-align:center;">
                            <span style="font-size:12px;font-weight:500;color:#374151;white-space:nowrap;display:block;">Open Setup Guide</span>
                        </div>
                        <div style="width:50px;"></div>
                        <div style="width:80px;text-align:center;">
                            <span style="font-size:12px;font-weight:500;color:#374151;white-space:nowrap;display:block;">Follow Steps</span>
                        </div>
                        <div style="width:50px;"></div>
                        <div style="width:80px;text-align:center;">
                            <span style="font-size:12px;font-weight:500;color:#374151;white-space:nowrap;display:block;">Connect & Start</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Description -->
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
            <i class="fas fa-star" style="color:#7c3aed;font-size:16px;"></i>
            <p style="font-size:13px;color:#6b7280;margin:0;line-height:1.6;">
                Click any AI client to view setup steps in a <span style="color:#7c3aed;font-weight:500;">guided walkthrough</span>.
            </p>
        </div>
        
        <!-- ChatGPT -->
        <div @click="openModal('chatgpt')" onclick="console.log('ChatGPT clicked')" style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;cursor:pointer;transition:all 200ms;" onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#ddd6fe'" onmouseout="this.style.background='#f9f8fc';this.style.borderColor='#f0eef5'">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="/images/clients/chatgpt-dark.png" alt="ChatGPT" class="icon-dark" style="width:32px;height:32px;object-fit:contain;">
                    <img src="/images/clients/chatgpt-light.png" alt="ChatGPT" class="icon-light" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div>
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;">ChatGPT</div>
                    <div style="font-size:12px;color:#6b7280;margin-top:2px;">Click to open step-by-step setup guide</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:#f3effd;border:1px solid #e9d5ff;color:#7c3aed;font-size:12px;font-weight:500;padding:2px 10px;border-radius:20px;">2 min</span>
                <i class="fas fa-chevron-right" style="color:#9ca3af;font-size:12px;"></i>
            </div>
        </div>
        
        <!-- Claude -->
        <div @click="openModal('claude')" style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;cursor:pointer;transition:all 200ms;" onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#ddd6fe'" onmouseout="this.style.background='#f9f8fc';this.style.borderColor='#f0eef5'">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="/images/clients/claude.png" alt="Claude" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div>
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;">Claude</div>
                    <div style="font-size:12px;color:#6b7280;margin-top:2px;">Click to open step-by-step setup guide</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:#f3effd;border:1px solid #e9d5ff;color:#7c3aed;font-size:12px;font-weight:500;padding:2px 10px;border-radius:20px;">2 min</span>
                <i class="fas fa-chevron-right" style="color:#9ca3af;font-size:12px;"></i>
            </div>
        </div>
        
        <!-- Cursor -->
        <div @click="openModal('cursor')" style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;cursor:pointer;transition:all 200ms;" onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#ddd6fe'" onmouseout="this.style.background='#f9f8fc';this.style.borderColor='#f0eef5'">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="/images/clients/cursor-dark.png" alt="Cursor" class="icon-dark" style="width:32px;height:32px;object-fit:contain;">
                    <img src="/images/clients/cursor-light.png" alt="Cursor" class="icon-light" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div>
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;">Cursor</div>
                    <div style="font-size:12px;color:#6b7280;margin-top:2px;">Click to open step-by-step setup guide</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:#f3effd;border:1px solid #e9d5ff;color:#7c3aed;font-size:12px;font-weight:500;padding:2px 10px;border-radius:20px;">3 min</span>
                <i class="fas fa-chevron-right" style="color:#9ca3af;font-size:12px;"></i>
            </div>
        </div>
        
        <!-- VS Code -->
        <div @click="openModal('vscode')" style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;cursor:pointer;transition:all 200ms;" onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#ddd6fe'" onmouseout="this.style.background='#f9f8fc';this.style.borderColor='#f0eef5'">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="/images/clients/vscode.png" alt="VS Code" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div>
                    <div style="font-size:14px;font-weight:600;color:#1a1a2e;">VS Code</div>
                    <div style="font-size:12px;color:#6b7280;margin-top:2px;">Click to open step-by-step setup guide</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:#f3effd;border:1px solid #e9d5ff;color:#7c3aed;font-size:12px;font-weight:500;padding:2px 10px;border-radius:20px;">3 min</span>
                <i class="fas fa-chevron-right" style="color:#9ca3af;font-size:12px;"></i>
            </div>
        </div>
        
        <!-- Info Banner -->
        <div style="background:#f5f3ff;border:1px solid #e9d5ff;border-radius:12px;padding:12px 16px;display:flex;align-items:center;gap:16px;margin-top:4px;">
            <div style="width:44px;height:44px;min-width:44px;background:#f5f3ff;border:2px solid #ddd6fe;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-lightbulb" style="color:#7c3aed;font-size:20px;"></i>
            </div>
            <p style="font-size:14px;color:#374151;margin:0;line-height:1.6;">
                Choose your preferred AI client and follow the guided setup steps to connect ServerAvatar MCP in just a few minutes.
            </p>
        </div>
        
    </div>

</div>

<!-- Cards 7 & 8 Row: Example Commands + Security Best Practices -->
<div style="display:flex;gap:24px;margin-top:20px;width:100%;box-sizing:border-box;">

    <!-- Card 7: Example Commands -->
    <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
        <div style="margin-bottom:20px;">
            <h2 style="font-size:24px;font-weight:700;margin:0 0 6px 0;line-height:1.2;"><span style="color:#7c3aed;">7.</span> Example Commands</h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Use natural language to manage your infrastructure.</p>
        </div>
        
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;">
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('List all organizations', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fas fa-building"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">List all organizations</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('Create a WordPress application', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fab fa-wordpress"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Create a WordPress application</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('List all servers', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fas fa-server"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">List all servers</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('Restart Nginx', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fas fa-sync"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Restart Nginx</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('Install SSL certificate', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fas fa-lock"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Install SSL certificate</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('Create a database', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fas fa-database"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Create a database</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('Show server usage', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fas fa-chart-line"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Show server usage</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('List WordPress plugins', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fas fa-plug"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">List WordPress plugins</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('Restart PHP', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fas fa-sync"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Restart PHP</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;cursor:pointer;" onclick="copyCommand('Create a new firewall rule', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="color:#7c3aed;font-size:14px;"><i class="fas fa-shield-alt"></i></div>
                    <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Create a new firewall rule</span>
                </div>
                <i class="fas fa-copy" style="color:#9ca3af;font-size:12px;"></i>
            </div>
        </div>
        
        <div style="margin-top:20px;text-align:center;">
            <a href="{{ url('/tools') }}" style="display:inline-flex;align-items:center;gap:8px;color:#7c3aed;font-size:14px;font-weight:600;text-decoration:none;">Explore More Examples <i class="fas fa-arrow-right" style="font-size:12px;"></i></a>
        </div>
        <script>
        function copyCommand(text, el) {
            navigator.clipboard.writeText(text).then(function() {
                var icon = el.querySelector('.fa-copy');
                icon.classList.remove('fa-copy');
                icon.classList.add('fa-check');
                icon.style.color = '#22c55e';
                setTimeout(function() {
                    icon.classList.remove('fa-check');
                    icon.classList.add('fa-copy');
                    icon.style.color = '#9ca3af';
                }, 1500);
            });
        }
        function copyCode(el) {
            var codeBlock = el.parentElement.querySelector('pre');
            var text = codeBlock.textContent;
            navigator.clipboard.writeText(text).then(function() {
                var icon = el.querySelector('.fa-copy');
                icon.classList.remove('fa-copy');
                icon.classList.add('fa-check');
                icon.style.color = '#22c55e';
                setTimeout(function() {
                    icon.classList.remove('fa-check');
                    icon.classList.add('fa-copy');
                    icon.style.color = '#9ca3af';
                }, 1500);
            });
        }
        </script>
    </div>

    <!-- Card 8: Security Best Practices -->
    <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
        <div style="margin-bottom:20px;">
            <h2 style="font-size:24px;font-weight:700;margin:0 0 6px 0;line-height:1.2;"><span style="color:#7c3aed;">8.</span> Security Best Practices</h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Keep your API keys and tokens secure.</p>
        </div>
        
        <div style="display:flex;flex-direction:column;gap:10px;">
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:12px;">
                <div style="color:#7c3aed;font-size:14px;min-width:20px;text-align:center;"><i class="fas fa-key"></i></div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Never share your API Key or IDE Access Tokens</span>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:12px;">
                <div style="color:#7c3aed;font-size:14px;min-width:20px;text-align:center;"><i class="fas fa-lock"></i></div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Store tokens securely and never in public repositories</span>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:12px;">
                <div style="color:#7c3aed;font-size:14px;min-width:20px;text-align:center;"><i class="fas fa-trash-alt"></i></div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Revoke unused tokens immediately</span>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:12px;">
                <div style="color:#7c3aed;font-size:14px;min-width:20px;text-align:center;"><i class="fas fa-id-card"></i></div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Generate separate tokens for different devices</span>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:12px;">
                <div style="color:#7c3aed;font-size:14px;min-width:20px;text-align:center;"><i class="fas fa-sync"></i></div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Review active tokens regularly</span>
            </div>
        </div>
        
        <div style="background:#fef3c7;border:1px solid #fcd34d;border-radius:10px;padding:14px 16px;display:flex;align-items:flex-start;gap:12px;margin-top:16px;">
            <div style="color:#dc2626;font-size:18px;padding-top:1px;"><i class="fas fa-shield-alt"></i></div>
            <p style="font-size:13px;color:#dc2626;line-height:1.5;margin:0;">Your tokens provide access to your ServerAvatar account. Keep them secure at all times.</p>
        </div>
    </div>

</div>

<!-- Cards 9 & 10 Row: Troubleshooting + Quick Setup Summary -->
<div style="display:flex;gap:24px;margin-top:20px;width:100%;box-sizing:border-box;">

    <!-- Card 9: Troubleshooting (Accordion) -->
    <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
        <div style="margin-bottom:20px;">
            <h2 style="font-size:24px;font-weight:700;margin:0 0 6px 0;line-height:1.2;"><span style="color:#7c3aed;">9.</span> Troubleshooting</h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Common issues and their solutions.</p>
        </div>
        
        <div x-data="{ open: -1 }" style="display:flex;flex-direction:column;gap:16px;">
            
            <!-- Item 1 -->
            <div @click="open = open === 1 ? -1 : 1" style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:0;cursor:pointer;transition:all 200ms;box-shadow:0 1px 3px rgba(0,0,0,0.04);" onmouseover="this.style.background='#fafaff';this.style.borderColor='#ddd6fe';this.style.boxShadow='0 4px 12px rgba(124,58,237,0.08)'" onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb';this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)'">
                <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding:12px 16px;box-sizing:border-box;">
                    <div style="width:34px;height:34px;min-width:34px;background:#fef2f2;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-wifi" style="color:#dc2626;font-size:14px;"></i>
                    </div>
                    <span style="font-size:15px;font-weight:600;color:#111827;flex:1;margin-left:14px;">Connection failed</span>
                    <i class="fas fa-chevron-right" style="color:#6b7280;font-size:18px;margin-left:auto;transition:transform 200ms;" :style="open === 1 ? 'transform:rotate(90deg);' : 'transform:rotate(0deg);'"></i>
                </div>
                <div x-show="open === 1" x-collapse x-cloak style="background:#fcfcff;border-top:1px solid #f3f4f6;">
                    <div style="padding:8px 14px;">
                        <p style="font-size:13px;color:#6b7280;line-height:1.7;margin:0;">Check your MCP Server URL and internet connection.</p>
                    </div>
                </div>
            </div>
            
            <!-- Item 2 -->
            <div @click="open = open === 2 ? -1 : 2" style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:0;cursor:pointer;transition:all 200ms;box-shadow:0 1px 3px rgba(0,0,0,0.04);" onmouseover="this.style.background='#fafaff';this.style.borderColor='#ddd6fe';this.style.boxShadow='0 4px 12px rgba(124,58,237,0.08)'" onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb';this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)'">
                <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding:12px 16px;box-sizing:border-box;">
                    <div style="width:34px;height:34px;min-width:34px;background:#fffbeb;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-key" style="color:#d97706;font-size:14px;"></i>
                    </div>
                    <span style="font-size:15px;font-weight:600;color:#111827;flex:1;margin-left:14px;">Authentication failed</span>
                    <i class="fas fa-chevron-right" style="color:#6b7280;font-size:18px;margin-left:auto;transition:transform 200ms;" :style="open === 2 ? 'transform:rotate(90deg);' : 'transform:rotate(0deg);'"></i>
                </div>
                <div x-show="open === 2" x-collapse x-cloak style="background:#fcfcff;border-top:1px solid #f3f4f6;">
                    <div style="padding:8px 14px;">
                        <p style="font-size:13px;color:#6b7280;line-height:1.7;margin:0;">Verify your API Key or IDE Access Token.</p>
                    </div>
                </div>
            </div>
            
            <!-- Item 3 -->
            <div @click="open = open === 3 ? -1 : 3" style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:0;cursor:pointer;transition:all 200ms;box-shadow:0 1px 3px rgba(0,0,0,0.04);" onmouseover="this.style.background='#fafaff';this.style.borderColor='#ddd6fe';this.style.boxShadow='0 4px 12px rgba(124,58,237,0.08)'" onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb';this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)'">
                <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding:12px 16px;box-sizing:border-box;">
                    <div style="width:34px;height:34px;min-width:34px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-wrench" style="color:#2563eb;font-size:14px;"></i>
                    </div>
                    <span style="font-size:15px;font-weight:600;color:#111827;flex:1;margin-left:14px;">No tools available</span>
                    <i class="fas fa-chevron-right" style="color:#6b7280;font-size:18px;margin-left:auto;transition:transform 200ms;" :style="open === 3 ? 'transform:rotate(90deg);' : 'transform:rotate(0deg);'"></i>
                </div>
                <div x-show="open === 3" x-collapse x-cloak style="background:#fcfcff;border-top:1px solid #f3f4f6;">
                    <div style="padding:8px 14px;">
                        <p style="font-size:13px;color:#6b7280;line-height:1.7;margin:0;">Reconnect your AI client and refresh the tools list.</p>
                    </div>
                </div>
            </div>
            
            <!-- Item 4 -->
            <div @click="open = open === 4 ? -1 : 4" style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:0;cursor:pointer;transition:all 200ms;box-shadow:0 1px 3px rgba(0,0,0,0.04);" onmouseover="this.style.background='#fafaff';this.style.borderColor='#ddd6fe';this.style.boxShadow='0 4px 12px rgba(124,58,237,0.08)'" onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb';this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)'">
                <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding:12px 16px;box-sizing:border-box;">
                    <div style="width:34px;height:34px;min-width:34px;background:#f5f3ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-link" style="color:#7c3aed;font-size:14px;"></i>
                    </div>
                    <span style="font-size:15px;font-weight:600;color:#111827;flex:1;margin-left:14px;">Invalid MCP URL</span>
                    <i class="fas fa-chevron-right" style="color:#6b7280;font-size:18px;margin-left:auto;transition:transform 200ms;" :style="open === 4 ? 'transform:rotate(90deg);' : 'transform:rotate(0deg);'"></i>
                </div>
                <div x-show="open === 4" x-collapse x-cloak style="background:#fcfcff;border-top:1px solid #f3f4f6;">
                    <div style="padding:8px 14px;">
                        <p style="font-size:13px;color:#6b7280;line-height:1.7;margin:0;">Ensure the MCP Server URL is connected and active.</p>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div style="text-align:center;margin-top:14px;">
            <a href="https://support.serveravatar.com" target="_blank" style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:500;color:#6b7280;text-decoration:none;transition:color 200ms;" onmouseover="this.style.color='#7c3aed'" onmouseout="this.style.color='#6b7280'">
                Still stuck? <span style="font-weight:600;color:#7c3aed;">Contact our support team</span> <i class="fas fa-external-link-alt" style="font-size:11px;"></i>
            </a>
        </div>
    </div>

    <!-- Card 10: Quick Setup Summary -->
    <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
        <div style="margin-bottom:20px;">
            <h2 style="font-size:24px;font-weight:700;margin:0 0 6px 0;line-height:1.2;"><span style="color:#7c3aed;">10.</span> Quick Setup Summary</h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Get started with ServerAvatar MCP in 6 steps.</p>
        </div>
        
        <div style="display:flex;flex-direction:column;gap:10px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:28px;height:28px;min-width:28px;background:#f5f3ff;color:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;">1</div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Generate ServerAvatar API Key</span>
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:28px;height:28px;min-width:28px;background:#f5f3ff;color:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;">2</div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Connect Account to ServerAvatar MCP</span>
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:28px;height:28px;min-width:28px;background:#f5f3ff;color:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;">3</div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Copy MCP Server URL</span>
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:28px;height:28px;min-width:28px;background:#f5f3ff;color:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;">4</div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Generate IDE Access Token (for IDE clients)</span>
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:28px;height:28px;min-width:28px;background:#f5f3ff;color:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;">5</div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Connect Your AI Client</span>
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:28px;height:28px;min-width:28px;background:#f5f3ff;color:#7c3aed;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;">6</div>
                <span style="font-size:13px;font-weight:500;color:#1a1a2e;">Verify Connection</span>
            </div>
        </div>
        
        <div style="margin-top:16px;padding:14px 18px;background:#f5f3ff;border:1px solid #ddd6fe;border-radius:12px;text-align:center;">
            <p style="font-size:14px;color:#7c3aed;margin:0;font-weight:500;">🎉 You're all set! Start managing your infrastructure with AI.</p>
        </div>
    </div>

</div>

<!-- New Card: You're All Set -->
<div style="display:flex;justify-content:center;margin-top:20px;width:100%;box-sizing:border-box;padding:0 4px;">
    <div style="width:100%;padding:28px 120px 28px 32px;background:linear-gradient(135deg,#f5f3ff 0%,#ede9fe 100%);border:1px solid #ddd6fe;border-radius:16px;display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:20px;flex:1;min-width:280px;">
            <img src="/images/rocket-illustration.png" alt="Rocket" style="width:72px;height:72px;object-fit:contain;opacity:0;transition:opacity 0.5s ease;flex-shrink:0;" onload="this.style.opacity='1'" onerror="this.style.display='none'">
            <div>
                <p style="font-size:18px;font-weight:700;color:#7c3aed;margin:0 0 6px 0;">You're All Set! 🎉</p>
                <p style="font-size:13px;color:#7c3aed;margin:0 0 4px 0;line-height:1.6;">You can now manage your servers, applications, databases, WordPress sites,</p>
                <p style="font-size:13px;color:#7c3aed;margin:0;line-height:1.6;">SSL certificates, and more — all through natural language.</p>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:12px;align-items:center;">
            <a href="/dashboard" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 32px;background:#7c3aed;color:#fff;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;transition:all 200ms;white-space:nowrap;min-width:180px;" onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                Go to Dashboard <i class="fas fa-arrow-right" style="font-size:12px;"></i>
            </a>
            <a href="/tools" style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:600;color:#7c3aed;text-decoration:none;transition:color 200ms;" onmouseover="this.style.color='#6d28d9'" onmouseout="this.style.color='#7c3aed'">
                Explore Tools Library <i class="fas fa-arrow-right" style="font-size:12px;"></i>
            </a>
        </div>
    </div>
</div>
<!-- AI Client Connection Modal -->
<div x-show="modalOpen" x-cloak style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:9999;background:rgba(0,0,0,0.5);" @click.self="closeModal()">
    <div x-show="selectedClient" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:900px;max-width:calc(100vw - 48px);max-height:90vh;background:#fff;border-radius:20px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);overflow:hidden;display:flex;flex-direction:column;" @click.stop>
        
        <!-- Modal Header (Fixed) -->
        <div style="background:#fff;padding:24px 24px 20px 24px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #e5e7eb;flex-shrink:0;">
            <div style="display:flex;align-items:center;gap:16px;">
                <template x-if="selectedClient && selectedClient.imageLight">
                    <img :src="selectedClient.imageLight" :alt="selectedClient.name" class="icon-light" style="width:48px;height:48px;object-fit:contain;border-radius:8px;">
                </template>
                <template x-if="selectedClient && !selectedClient.imageLight">
                    <img :src="selectedClient.image" :alt="selectedClient.name" style="width:48px;height:48px;object-fit:contain;border-radius:8px;">
                </template>
                <div>
                    <h3 style="font-size:20px;font-weight:700;color:#1a1a2e;margin:0;" x-text="selectedClient ? selectedClient.name + ' Setup Guide' : ''"></h3>
                    <p style="font-size:13px;color:#6b7280;margin:6px 0 0 0;" x-text="selectedClient ? 'Follow the steps below to connect ServerAvatar MCP with ' + selectedClient.name : ''"></p>
                </div>
            </div>
            <button @click="closeModal()" style="background:none;border:none;cursor:pointer;padding:8px;color:#1a1a2e;font-size:20px;line-height:1;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div style="display:flex;flex:1;overflow:hidden;min-height:0;max-height:calc(90vh - 140px);">
            
            <!-- Sidebar (Fixed) -->
            <div style="width:240px;background:#fafafa;border-right:1px solid #e5e7eb;padding:20px;flex-shrink:0;overflow-y:auto;overflow-x:hidden;">
                
                <template x-for="(step, index) in selectedClient ? selectedClient.steps : []" :key="index">
                    <div style="display:flex;align-items:center;gap:12px;padding:12px 0;">
                        <div style="display:flex;align-items:center;gap:12px;position:relative;">
                            <div style="width:28px;height:28px;min-width:28px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;flex-shrink:0;z-index:1;" x-text="index + 1"></div>
                            <template x-if="index < (selectedClient ? selectedClient.steps.length - 1 : 0)">
                                <div style="position:absolute;left:13px;top:28px;width:2px;height:28px;border-left:2px dotted #d1d5db;z-index:0;"></div>
                            </template>
                        </div>
                        <div x-text="step.title" :style="index === 0 ? 'font-size:14px;font-weight:500;color:#7c3aed;line-height:1.4;flex:1;' : 'font-size:14px;font-weight:500;color:#1a1a2e;line-height:1.4;flex:1;'"></div>
                    </div>
                </template>
                
                <div style="margin-top:60px;padding:12px;background:#f5f3ff;border-radius:16px;border:1px solid #e9d5ff;">
                    <p style="font-size:14px;font-weight:700;color:#7c3aed;margin:0 0 8px 0;">Need Help?</p>
                    <p style="font-size:13px;color:#6b7280;margin:0 0 8px 0;">Contact our support team</p>
                    <a href="https://support.serveravatar.com" target="_blank" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:#7c3aed;text-decoration:none;">
                        Get Support <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>
            </div>
            
            <!-- Main Content (Scrollable) -->
            <div style="flex:1;padding:24px;overflow-y:auto;overflow-x:hidden;min-height:0;">
                
                <!-- ChatGPT Info Note -->
                <template x-if="selectedClient && selectedClient.name === 'ChatGPT'">
                    <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:12px;padding:12px 16px;display:flex;align-items:flex-start;gap:14px;margin-bottom:16px;">
                        <i class="fas fa-info-circle" style="color:#7c3aed;font-size:20px;margin-top:2px;"></i>
                        <div>
                            <p style="font-size:14px;font-weight:600;color:#7c3aed;margin:0 0 4px 0;">Important Note</p>
                            <p style="font-size:13px;color:#7c3aed;margin:0;line-height:1.5;">MCP connectors are available only on supported ChatGPT plans and may not be available for every account.</p>
                        </div>
                    </div>
                </template>
                
                <!-- ChatGPT Step 1 Card -->
                <template x-if="selectedClient && selectedClient.name === 'ChatGPT'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 1: <span style="color:#1a1a2e;">Enable Developer Mode</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Log in to your ChatGPT account</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Open Settings</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">3</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Enable Developer Mode (if available for your account)</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- ChatGPT Step 2 Card -->
                <template x-if="selectedClient && selectedClient.name === 'ChatGPT'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 2: <span style="color:#1a1a2e;">Create a New MCP Connector</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Open Settings</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Go to Apps (or Plugins, depending on your ChatGPT version)</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">3</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Click Create New</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">4</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Enter a name: ServerAvatar MCP</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">5</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Paste your MCP Server URL into the Connection URL field</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">6</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Save the connector</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">7</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Complete the authorization process if prompted</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- ChatGPT Step 3 Card -->
                <template x-if="selectedClient && selectedClient.name === 'ChatGPT'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 3: <span style="color:#1a1a2e;">Start Using ServerAvatar MCP</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Open a new chat/Conversion</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Select the ServerAvatar MCP connector from the top model dropdown</p>
                            </div>
                        </div>
                        <p style="font-size:14px;color:#6b7280;margin:16px 0 12px 0;">You can now use natural language commands such as:</p>
                        <div style="display:flex;flex-wrap:nowrap;gap:8px;overflow-x:auto;">
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">List all my servers</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Show server status</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Create new database</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Deploy WordPress</button>
                        </div>
                    </div>
                </template>
                
                <!-- Claude Step 1 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Claude'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 1: <span style="color:#1a1a2e;">Open Claude Settings</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Log into your Claude account</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Open Settings</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">3</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Navigate to Connectors or Customize (depending on your Claude version)</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Claude Step 2 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Claude'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 2: <span style="color:#1a1a2e;">Add a Custom Connector</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Click Add Custom Connector</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Enter a connector name: ServerAvatar MCP</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">3</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Paste your MCP Server URL into the connection URL field</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">4</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Save the connector</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">5</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Complete the authorization process if required</p>
                            </div>
                        </div>
                        <p style="font-size:13px;color:#6b7280;margin:16px 0 0 0;line-height:1.5;">After a successful connection, the ServerAvatar MCP connector will be available in Claude.</p>
                    </div>
                </template>
                
                <!-- Claude Step 3 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Claude'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#1a1a2e;margin:0 0 16px 0;">Step 3: <span style="color:#7c3aed;">Start Managing Your Servers</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Open a new Claude chat</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Select your ServerAvatar MCP connector</p>
                            </div>
                        </div>
                        <p style="font-size:14px;color:#6b7280;margin:16px 0 12px 0;">You can now ask Claude to perform ServerAvatar operations, for example:</p>
                        <div style="display:flex;flex-wrap:nowrap;gap:8px;overflow-x:auto;">
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Create an application</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">List servers</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Manage databases</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Install SSL certificates</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Change application settings</button>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 1 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 1: <span style="color:#1a1a2e;">Install and Sign In</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Download and install Cursor IDE on your computer</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Sign in to your Cursor account</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 2 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 2: <span style="color:#1a1a2e;">Generate an IDE Access Token</span></h4>
                        <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:12px 16px;margin-bottom:12px;">
                            <p style="font-size:13px;color:#7c3aed;margin:0;line-height:1.5;"><strong>Note:</strong> An access token is required before connecting Cursor.</p>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Log in to ServerAvatar MCP</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Navigate to Endpoint & Tokens</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">3</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Under IDE Access Tokens, enter a token name (e.g., Cursor Development)</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">4</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Click Generate Token</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">5</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Copy the generated token immediately (it won't be shown again)</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 3 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 3: <span style="color:#1a1a2e;">Open MCP Settings</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Open Cursor</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Navigate to Settings → Tools & MCP</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">3</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Under Installed MCP Servers, click + Add New MCP Server</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">4</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Cursor will open the mcp.json configuration file</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 4 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 4: <span style="color:#1a1a2e;">Configure ServerAvatar MCP</span></h4>
                        <p style="font-size:14px;color:#1a1a2e;margin:0 0 12px 0;line-height:1.5;">Modify your mcp.json file with the following configuration:</p>
                        <div style="background:#1e1e2e;border-radius:12px;padding:16px;margin-bottom:12px;overflow-x:auto;position:relative;">
                            <div style="position:absolute;top:12px;left:16px;font-size:12px;color:#9ca3af;"><i class="fas fa-file-code" style="margin-right:6px;"></i>mcp.json</div>
                            <button onclick="copyCode(this)" style="position:absolute;top:12px;right:12px;background:#374151;border:none;border-radius:6px;padding:6px 10px;cursor:pointer;color:#9ca3af;font-size:12px;display:flex;align-items:center;gap:4px;">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                            <pre style="font-size:12px;color:#a5f3cb;margin:0;line-height:1.7;white-space:pre;padding-top:24px;">{
  "mcpServers": {
    "serveravatar-mcp" : {
      "url" : "YOUR_MCP_SERVER_URL",
      "headers": {
        "Authorization": "Bearer YOUR_IDE_ACCESS_TOKEN"
      }
    }
  }
}</pre>
                        </div>
                        <p style="font-size:14px;font-weight:600;color:#7c3aed;margin:0 0 12px 0;">Replace:</p>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:6px;height:6px;min-width:6px;background:#7c3aed;border-radius:50%;flex-shrink:0;"></div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;"><code style="background:#f3f4f6;padding:2px 8px;border-radius:12px;font-size:12px;color:#7c3aed;font-weight:500;">YOUR_MCP_SERVER_URL</code> with the MCP Server URL from ServerAvatar MCP → Endpoint & Tokens</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:6px;height:6px;min-width:6px;background:#7c3aed;border-radius:50%;flex-shrink:0;"></div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;"><code style="background:#f3f4f6;padding:2px 8px;border-radius:12px;font-size:12px;color:#7c3aed;font-weight:500;">YOUR_IDE_ACCESS_TOKEN</code> with the IDE Access Token you generated</p>
                            </div>
                        </div>
                        <div style="background:#fef3c7;border:1px solid #fcd34d;border-radius:8px;padding:12px 16px;margin-top:16px;">
                            <p style="font-size:14px;color:#92400e;margin:0;line-height:1.5;"><strong>Don't forget!</strong> Save the <code style="background:#fde68a;padding:2px 6px;border-radius:4px;font-size:13px;">mcp.json</code> file after making the changes.</p>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 5 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 5: <span style="color:#1a1a2e;">Verify the Connection</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Return to Settings → Tools & MCP.</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Verify that ServerAvatar MCP appears under Installed MCP Servers.</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">3</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Ensure the server status shows Connected or Available.</p>
                            </div>
                        </div>
                        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:12px 16px;margin-top:16px;">
                            <p style="font-size:14px;color:#991b1b;margin:0;line-height:1.5;">If the connection fails, verify your MCP Server URL and IDE Access Token, then reload Cursor.</p>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 6 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 6: <span style="color:#1a1a2e;">Start Using ServerAvatar MCP</span></h4>
                        <p style="font-size:14px;color:#1a1a2e;margin:0 0 12px 0;line-height:1.5;">Open a new AI chat or Agent session in Cursor and start using natural language commands, for example:</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;">
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">List my servers</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Create a WordPress application</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">List databases</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Restart Nginx</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Install an SSL certificate</button>
                        </div>
                        <p style="font-size:14px;color:#1a1a2e;margin:0 0 16px 0;line-height:1.5;">Cursor will automatically invoke the appropriate ServerAvatar MCP tools when required.</p>
                        <div style="background:#fef3c7;border:1px solid #fcd34d;border-radius:8px;padding:12px 16px;">
                            <p style="font-size:14px;color:#92400e;margin:0;line-height:1.5;"><strong>💡 Tip:</strong> If you update the mcp.json file, reload or restart Cursor to ensure the new MCP configuration is loaded.</p>
                        </div>
                    </div>
                </template>
                
                <!-- VS Code Info Note -->
                <template x-if="selectedClient && selectedClient.name === 'VS Code'">
                    <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:12px;padding:16px;margin-bottom:12px;">
                        <div style="display:flex;align-items:flex-start;gap:12px;">
                            <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;">i</div>
                            <p style="font-size:13px;color:#7c3aed;margin:0;line-height:1.5;">Visual Studio Code supports connecting to ServerAvatar MCP using <strong>OAuth Authorization (Recommended)</strong> or <strong>IDE Access Tokens (Manual Configuration)</strong>.</p>
                        </div>
                    </div>
                </template>
                
                <!-- VS Code Section Title -->
                <template x-if="selectedClient && selectedClient.name === 'VS Code'">
                    <div style="margin-bottom:12px;">
                        <h4 style="font-size:18px;font-weight:700;color:#1a1a2e;margin:0 0 8px 0;">Choose Authentication Method</h4>
                        <p style="font-size:14px;color:#6b7280;margin:0;">Select the method you want to use to connect to ServerAvatar MCP.</p>
                    </div>
                </template>
                
                <!-- VS Code OAuth Card -->
                <template x-if="selectedClient && selectedClient.name === 'VS Code'">
                    <div style="background:#ecfdf5;border:1px solid #6ee7b7;border-radius:12px;padding:16px;margin-bottom:12px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:48px;height:48px;min-width:48px;background:#10b981;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-shield-alt" style="font-size:20px;"></i>
                            </div>
                            <div style="flex:1;">
                                <span style="background:#d1fae5;color:#065f46;font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;display:inline-block;margin-bottom:4px;">Recommended</span>
                                <p style="font-size:15px;font-weight:600;color:#065f46;margin:0;">OAuth Authorization</p>
                            </div>
                        </div>
                        <div style="padding-left:60px;margin-top:8px;">
                            <p style="font-size:13px;color:#065f46;margin:0 0 6px 0;"><i class="fas fa-check-circle" style="color:#10b981;margin-right:8px;"></i>Secure and easy to set up</p>
                            <p style="font-size:13px;color:#065f46;margin:0 0 6px 0;"><i class="fas fa-check-circle" style="color:#10b981;margin-right:8px;"></i>No tokens to manage</p>
                            <p style="font-size:13px;color:#065f46;margin:0;"><i class="fas fa-check-circle" style="color:#10b981;margin-right:8px;"></i>One-click browser authorization</p>
                        </div>
                    </div>
                </template>
                
                <!-- VS Code IDE Token Card -->
                <template x-if="selectedClient && selectedClient.name === 'VS Code'">
                    <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:12px;padding:16px;margin-bottom:12px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:48px;height:48px;min-width:48px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-key" style="font-size:20px;"></i>
                            </div>
                            <div style="flex:1;">
                                <p style="font-size:15px;font-weight:600;color:#7c3aed;margin:0;">IDE Access Token</p>
                            </div>
                            <i class="fas fa-arrow-right" style="color:#7c3aed;font-size:14px;"></i>
                        </div>
                        <div style="padding-left:60px;margin-top:8px;">
                            <p style="font-size:13px;color:#7c3aed;margin:0 0 6px 0;"><i class="fas fa-check-circle" style="color:#7c3aed;margin-right:8px;"></i>Manual configuration</p>
                            <p style="font-size:13px;color:#7c3aed;margin:0 0 6px 0;"><i class="fas fa-check-circle" style="color:#7c3aed;margin-right:8px;"></i>Use your IDE Access Token</p>
                            <p style="font-size:13px;color:#7c3aed;margin:0;"><i class="fas fa-check-circle" style="color:#7c3aed;margin-right:8px;"></i>Works with any MCP client</p>
                        </div>
                    </div>
                </template>
                
                <script>
                function toggleVsCodeCard(card) {
                    var oauthContent = document.getElementById('vscode-oauth-content');
                    var tokenContent = document.getElementById('vscode-token-content');
                    var oauthArrow = document.getElementById('vscode-oauth-arrow');
                    var tokenArrow = document.getElementById('vscode-token-arrow');
                    
                    if (card === 'oauth') {
                        if (oauthContent.style.display === 'none' || oauthContent.style.display === '') {
                            oauthContent.style.display = 'block';
                            oauthArrow.style.transform = 'rotate(180deg)';
                            tokenContent.style.display = 'none';
                            tokenArrow.style.transform = 'rotate(0deg)';
                        } else {
                            oauthContent.style.display = 'none';
                            oauthArrow.style.transform = 'rotate(0deg)';
                        }
                    } else {
                        if (tokenContent.style.display === 'none' || tokenContent.style.display === '') {
                            tokenContent.style.display = 'block';
                            tokenArrow.style.transform = 'rotate(180deg)';
                            oauthContent.style.display = 'none';
                            oauthArrow.style.transform = 'rotate(0deg)';
                        } else {
                            tokenContent.style.display = 'none';
                            tokenArrow.style.transform = 'rotate(0deg)';
                        }
                    }
                }
                </script>
                
                <!-- Windsurf Step 1 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Windsurf'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 1: <span style="color:#1a1a2e;">Install Windsurf</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Download and install Windsurf IDE</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Launch Windsurf and create an account</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Windsurf Step 2 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Windsurf'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 2: <span style="color:#1a1a2e;">Generate an IDE Access Token</span></h4>
                        <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:12px 16px;margin-bottom:12px;">
                            <p style="font-size:13px;color:#7c3aed;margin:0;line-height:1.5;"><strong>Note:</strong> An access token is required before connecting Windsurf.</p>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Log in to ServerAvatar MCP</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Navigate to Endpoint & Tokens</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">3</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Generate a new IDE Access Token</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">4</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Copy the token immediately</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Windsurf Step 3 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Windsurf'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 3: <span style="color:#1a1a2e;">Add ServerAvatar MCP to Windsurf</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Open Windsurf Settings</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Go to Extensions or MCP Settings</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">3</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Add a new MCP server with your Server URL and token</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Windsurf Step 4 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Windsurf'">
                    <div style="background:#fafafa;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:12px;">
                        <h4 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 16px 0;">Step 4: <span style="color:#1a1a2e;">Start Using</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">1</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Open the Windsurf AI chat</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:24px;height:24px;min-width:24px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;">2</div>
                                <p style="font-size:14px;color:#1a1a2e;margin:0;line-height:1.5;">Start using natural language commands</p>
                            </div>
                        </div>
                        <p style="font-size:14px;color:#6b7280;margin:16px 0 12px 0;">Example commands:</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">List all my servers</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Create a database</button>
                            <button style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:500;color:#7c3aed;cursor:pointer;white-space:nowrap;">Deploy WordPress</button>
                        </div>
                    </div>
                </template>
                
                <!-- Success Message -->
                <div style="background:#dcfce7;border:1px solid #86efac;border-radius:12px;padding:16px 20px;display:flex;align-items:center;gap:12px;">
                    <div style="color:#22c55e;font-size:20px;"><i class="fas fa-check-circle"></i></div>
                    <p style="font-size:14px;font-weight:600;color:#166534;margin:0;">You're all set! Start managing your infrastructure with AI.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Closing x-data div -->
</div>

@endsection
