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
            { title: 'Log in to your ChatGPT account', desc: 'Open ChatGPT and sign in to your account.' },
            { title: 'Go to Settings > Developer', desc: 'Navigate to Settings and enable Developer Mode.' },
            { title: 'Create MCP Connector', desc: 'Click "Create New", name it "ServerAvatar MCP", and paste the connection URL.' },
            { title: 'Start Using', desc: 'Open a new chat and start managing your infrastructure!' }
        ]
    },
    claude: {
        name: 'Claude',
        image: '/images/clients/claude.png',
        badge: '2 min',
        steps: [
            { title: 'Log in to Claude', desc: 'Open Claude.ai and sign in to your account.' },
            { title: 'Go to Settings > Extensions', desc: 'Navigate to Settings and find the MCP extensions section.' },
            { title: 'Add MCP Server', desc: 'Click "Add Extension", name it "ServerAvatar MCP", and paste the connection URL.' },
            { title: 'Start Using', desc: 'Start a new conversation and use ServerAvatar tools!' }
        ]
    },
    cursor: {
        name: 'Cursor',
        image: '/images/clients/cursor-dark.png',
        imageLight: '/images/clients/cursor-light.png',
        badge: '3 min',
        steps: [
            { title: 'Install and Sign In', desc: 'Download and install Cursor, then sign in to your account.' },
            { title: 'Generate an IDE Access Token', desc: 'Go to your dashboard, navigate to MCP Panel, and generate a new IDE Access Token.' },
            { title: 'Open MCP Settings', desc: 'Press Cmd/Ctrl + , to open Settings, then navigate to the MCP section.' },
            { title: 'Configure ServerAvatar MCP', desc: 'Click "Add MCP Server", select HTTP, name it "ServerAvatar MCP", and paste the URL and token.' },
            { title: 'Verify the Connection', desc: 'Click "Check" next to your server to verify the connection is working.' },
            { title: 'Start Using', desc: 'Start coding and managing your servers directly!' }
        ]
    },
    vscode: {
        name: 'VS Code',
        image: '/images/clients/vscode.png',
        badge: '3 min',
        steps: [
            { title: 'Install VS Code', desc: 'Download and install Visual Studio Code from code.visualstudio.com.' },
            { title: 'Install MCP Extension', desc: 'Open Extensions (Cmd/Ctrl+Shift+X), search for "MCP", and install the official MCP extension.' },
            { title: 'Generate an IDE Access Token', desc: 'Go to your ServerAvatar dashboard, navigate to MCP Panel, and generate a new IDE Access Token.' },
            { title: 'Configure MCP Server', desc: 'Open settings.json, add ServerAvatar MCP config with connection URL and your IDE Access Token.' },
            { title: 'Start Using', desc: 'Use the Command Palette to access ServerAvatar tools!' }
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
        
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px 12px;text-align:center;">
                <div style="color:#3b82f6;font-size:22px;margin-bottom:8px;"><i class="fas fa-server"></i></div>
                <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:2px;">Servers</div>
                <div style="font-size:11px;color:#6b7280;">19 Tools</div>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px 12px;text-align:center;">
                <div style="color:#3b82f6;font-size:22px;margin-bottom:8px;"><i class="fas fa-globe"></i></div>
                <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:2px;">Applications</div>
                <div style="font-size:11px;color:#6b7280;">7 Tools</div>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px 12px;text-align:center;">
                <div style="color:#f97316;font-size:22px;margin-bottom:8px;"><i class="fas fa-database"></i></div>
                <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:2px;">Databases</div>
                <div style="font-size:11px;color:#6b7280;">2 Tools</div>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px 12px;text-align:center;">
                <div style="color:#ef4444;font-size:22px;margin-bottom:8px;"><i class="fas fa-shield-alt"></i></div>
                <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:2px;">Firewall</div>
                <div style="font-size:11px;color:#6b7280;">4 Tools</div>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px 12px;text-align:center;">
                <div style="color:#22c55e;font-size:22px;margin-bottom:8px;"><i class="fas fa-clock"></i></div>
                <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:2px;">Cronjobs</div>
                <div style="font-size:11px;color:#6b7280;">6 Tools</div>
            </div>
            <div style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:16px 12px;text-align:center;">
                <div style="color:#3b82f6;font-size:22px;margin-bottom:8px;"><i class="fab fa-wordpress"></i></div>
                <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:2px;">WordPress</div>
                <div style="font-size:11px;color:#6b7280;">33 Tools</div>
            </div>
        </div>
        
        <div style="margin-top:20px;text-align:center;">
            <a href="{{ url('/tools') }}" style="display:inline-flex;align-items:center;gap:8px;color:#7c3aed;font-size:14px;font-weight:600;text-decoration:none;">Explore All Tools <i class="fas fa-arrow-right" style="font-size:12px;"></i></a>
        </div>
    </div>

    <!-- Card 6: Connect AI Clients -->
    <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;padding:32px;flex:1;box-shadow:0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);">
        <div style="margin-bottom:20px;">
            <h2 style="font-size:24px;font-weight:700;margin:0 0 6px 0;line-height:1.2;"><span style="color:#7c3aed;">6.</span> Connect AI Clients</h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Choose your AI client and follow the setup guide.</p>
        </div>
        
        <!-- ChatGPT -->
        <div @click="openModal('chatgpt')" onclick="console.log('ChatGPT clicked')" style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:6px 10px;display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;cursor:pointer;transition:all 200ms;" onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#ddd6fe'" onmouseout="this.style.background='#f9f8fc';this.style.borderColor='#f0eef5'">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="/images/clients/chatgpt-dark.png" alt="ChatGPT" class="icon-dark" style="width:32px;height:32px;object-fit:contain;">
                    <img src="/images/clients/chatgpt-light.png" alt="ChatGPT" class="icon-light" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div style="font-size:14px;font-weight:600;color:#1a1a2e;">ChatGPT</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:#f3effd;border:1px solid #e9d5ff;color:#7c3aed;font-size:12px;font-weight:500;padding:2px 10px;border-radius:20px;">2 min</span>
                <i class="fas fa-chevron-right" style="color:#9ca3af;font-size:12px;"></i>
            </div>
        </div>
        
        <!-- Claude -->
        <div @click="openModal('claude')" style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:6px 10px;display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;cursor:pointer;transition:all 200ms;" onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#ddd6fe'" onmouseout="this.style.background='#f9f8fc';this.style.borderColor='#f0eef5'">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="/images/clients/claude.png" alt="Claude" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div style="font-size:14px;font-weight:600;color:#1a1a2e;">Claude</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:#f3effd;border:1px solid #e9d5ff;color:#7c3aed;font-size:12px;font-weight:500;padding:2px 10px;border-radius:20px;">2 min</span>
                <i class="fas fa-chevron-right" style="color:#9ca3af;font-size:12px;"></i>
            </div>
        </div>
        
        <!-- Cursor -->
        <div @click="openModal('cursor')" style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:6px 10px;display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;cursor:pointer;transition:all 200ms;" onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#ddd6fe'" onmouseout="this.style.background='#f9f8fc';this.style.borderColor='#f0eef5'">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="/images/clients/cursor-dark.png" alt="Cursor" class="icon-dark" style="width:32px;height:32px;object-fit:contain;">
                    <img src="/images/clients/cursor-light.png" alt="Cursor" class="icon-light" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div style="font-size:14px;font-weight:600;color:#1a1a2e;">Cursor</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:#f3effd;border:1px solid #e9d5ff;color:#7c3aed;font-size:12px;font-weight:500;padding:2px 10px;border-radius:20px;">3 min</span>
                <i class="fas fa-chevron-right" style="color:#9ca3af;font-size:12px;"></i>
            </div>
        </div>
        
        <!-- VS Code -->
        <div @click="openModal('vscode')" style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:6px 10px;display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;cursor:pointer;transition:all 200ms;" onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#ddd6fe'" onmouseout="this.style.background='#f9f8fc';this.style.borderColor='#f0eef5'">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="/images/clients/vscode.png" alt="VS Code" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div style="font-size:14px;font-weight:600;color:#1a1a2e;">VS Code</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:#f3effd;border:1px solid #e9d5ff;color:#7c3aed;font-size:12px;font-weight:500;padding:2px 10px;border-radius:20px;">3 min</span>
                <i class="fas fa-chevron-right" style="color:#9ca3af;font-size:12px;"></i>
            </div>
        </div>
        
        <!-- Windsurf -->
        <div @click="openModal('windsurf')" style="background:#f9f8fc;border:1px solid #f0eef5;border-radius:12px;padding:6px 10px;display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;cursor:pointer;transition:all 200ms;" onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#ddd6fe'" onmouseout="this.style.background='#f9f8fc';this.style.borderColor='#f0eef5'">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="/images/clients/windsurf-dark.png" alt="Windsurf" class="icon-dark" style="width:32px;height:32px;object-fit:contain;">
                    <img src="/images/clients/windsurf-light.png" alt="Windsurf" class="icon-light" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div style="font-size:14px;font-weight:600;color:#1a1a2e;">Windsurf</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:#f3effd;border:1px solid #e9d5ff;color:#7c3aed;font-size:12px;font-weight:500;padding:2px 10px;border-radius:20px;">3 min</span>
                <i class="fas fa-chevron-right" style="color:#9ca3af;font-size:12px;"></i>
            </div>
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

<h2>🚀 Introducing ServerAvatar MCP</h2>
    <p>Now that you understand MCP, let's talk about <strong>ServerAvatar MCP</strong> – a powerful implementation that brings your ServerAvatar server management panel directly into any MCP-compatible AI client.</p>

    <div class="note-box">
        <p><strong>💡 What is ServerAvatar?</strong></p>
        <p>ServerAvatar is a server management platform that helps you manage VPS servers, websites, databases, domains, SSL certificates, and more – all from a web dashboard.</p>
    </div>

    <p>With ServerAvatar MCP, you can do everything from your AI chat:</p>
    <ul>
        <li>List and manage your servers</li>
        <li>Create/delete databases</li>
        <li>Manage applications and websites</li>
        <li>Configure firewall rules</li>
        <li>Set up cronjobs</li>
        <li>Manage WordPress sites (themes, plugins, updates)</li>
        <li>Check server resources and logs</li>
    </ul>

    <h2>Quick Setup</h2>
    <h2>🔑 Step 1: Generate Your ServerAvatar API Key</h2>
    <p>Follow these simple steps to connect ServerAvatar MCP with your favorite AI client.</p>
    
    <div class="step-box">
        <p><span class="step-number">1</span>Log in to your ServerAvatar account</p>
        <p><span class="step-number">2</span>Navigate to <strong>Account Settings → API Access</strong></p>
        <p><span class="step-number">3</span>Generate or view your API Access Key</p>
        <p><span class="step-number">4</span>Copy the API Key—you'll use it to authorize ServerAvatar MCP</p>
    </div>

    <div class="note-box">
        <p><strong>⚠️ Note:</strong> Keep your API Key secure. Never share it publicly.</p>
    </div>

    <h2>🔗 Step 2: Connect Your ServerAvatar Account to ServerAvatar MCP</h2>
    <p>Once your API Key is verified, your ServerAvatar MCP account is ready to communicate with your ServerAvatar account.</p>
    
    <div class="step-box">
        <p><span class="step-number">1</span>Log in to your ServerAvatar MCP dashboard</p>
        <p><span class="step-number">2</span>Go to <strong>Account Settings → API Access</strong></p>
        <p><span class="step-number">3</span>Paste the API Key you copied from your ServerAvatar account</p>
        <p><span class="step-number">4</span>Click <strong>Update API Key</strong></p>
    </div>

    <h2>📋 Step 3: Copy Your MCP Server URL</h2>
    <p>After connecting your API Key:</p>
    
    <div class="step-box">
        <p><span class="step-number">1</span>Open the <strong>Dashboard</strong> or <strong>MCP Server</strong> page</p>
        <p><span class="step-number">2</span>Locate the <strong>MCP Server URL</strong></p>
        <p><span class="step-number">3</span>Click <strong>Copy URL</strong></p>
    </div>

    <p>You'll need this URL when configuring your AI client.</p>

    <h2>🤖 Step 4: Connect Your AI Client</h2>
    <p>Choose the AI client you'd like to use with ServerAvatar MCP.</p>

    <h2>📊 ServerAvatar MCP Tools</h2>
    <p>ServerAvatar MCP provides <strong>55+ tools</strong> organized into categories:</p>

    <table style="width: 100%; border-collapse: collapse; margin: 1rem 0;">
        <thead>
            <tr style="background: var(--bg-tertiary);">
                <th style="padding: 0.75rem; text-align: left; border: 1px solid var(--border-color);">Category</th>
                <th style="padding: 0.75rem; text-align: left; border: 1px solid var(--border-color);">Tools</th>
                <th style="padding: 0.75rem; text-align: left; border: 1px solid var(--border-color);">Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);"><strong>Server</strong></td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">19</td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">Create, list, restart, update, tags, firewall</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);"><strong>Application</strong></td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">7</td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">Manage websites and apps</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);"><strong>Database</strong></td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">2</td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">Database user management</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);"><strong>Firewall</strong></td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">4</td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">Firewall rules configuration</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);"><strong>Cronjob</strong></td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">6</td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">Schedule management tasks</td>
            </tr>
            <tr>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);"><strong>WordPress Toolkit</strong></td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">33</td>
                <td style="padding: 0.75rem; border: 1px solid var(--border-color);">Themes, plugins, updates, security</td>
            </tr>
        </tbody>
    </table>

    <div class="note-box">
        <p><strong>📌 Before You Connect</strong></p>
        <p><strong>💡 IDE Access Token Requirement</strong></p>
        <p>IDE Access Tokens are only required for IDE-based AI clients such as Cursor, Windsurf, VS Code, Cline, and Continue.</p>
        <p>Browser-based AI clients like ChatGPT and Claude connect using your MCP Server URL and do not require an IDE Access Token.</p>
    </div>

    <h2 id="chatgpt">🤖 ChatGPT</h2>
    
    <div class="client-card">
        <h4>ChatGPT + ServerAvatar MCP</h4>
        <p>Before connecting your MCP server, make sure your ChatGPT account supports MCP connectors.</p>
        
        <h3>Step 1: Enable Developer Mode</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Log in to your ChatGPT account</p>
            <p><span class="step-number">2</span>Open Settings</p>
            <p><span class="step-number">3</span>Enable Developer Mode (if available for your account)</p>
        </div>

        <div class="note-box">
            <p><strong>⚠️ Note:</strong> MCP connectors are available only on supported ChatGPT plans and may not be available for every account.</p>
        </div>

        <h3>Step 2: Create a New MCP Connector</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Open Settings</p>
            <p><span class="step-number">2</span>Go to <strong>Apps</strong> (or Plugins, depending on your ChatGPT version)</p>
            <p><span class="step-number">3</span>Click <strong>Create New</strong></p>
            <p><span class="step-number">4</span>Enter a name: <strong>ServerAvatar MCP</strong></p>
            <p><span class="step-number">5</span>Paste your MCP Server URL into the <strong>Connection URL</strong> field</p>
            <p><span class="step-number">6</span>Save the connector</p>
            <p><span class="step-number">7</span>Complete the authorization process if prompted</p>
        </div>

        <p>Once connected successfully, ServerAvatar MCP will appear in your available connectors.</p>

        <h3>Step 3: Start Using ServerAvatar MCP</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Open a new conversation</p>
            <p><span class="step-number">2</span>Select your connected <strong>ServerAvatar MCP</strong> connector</p>
        </div>

        <p>You can now use natural language commands such as:</p>
        <ul>
            <li>Create a WordPress application</li>
            <li>List all servers</li>
            <li>Restart Nginx</li>
            <li>Install an SSL certificate</li>
            <li>Create a database</li>
        </ul>
    </div>

    <h2 id="claude">🧠 Claude</h2>
    
    <div class="client-card">
        <h4>Claude Desktop + ServerAvatar MCP</h4>
        <p>Claude supports connecting external MCP servers using Custom Connectors.</p>
        
        <h3>Step 1: Open Claude Settings</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Log in to your Claude account</p>
            <p><span class="step-number">2</span>Open Settings</p>
            <p><span class="step-number">3</span>Navigate to <strong>Connectors</strong> or <strong>Customize</strong> (depending on your Claude version)</p>
        </div>

        <h3>Step 2: Add a Custom Connector</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Click <strong>Add Custom Connector</strong></p>
            <p><span class="step-number">2</span>Enter a connector name: <strong>ServerAvatar MCP</strong></p>
            <p><span class="step-number">3</span>Paste your MCP Server URL into the connection URL field</p>
            <p><span class="step-number">4</span>Save the connector</p>
            <p><span class="step-number">5</span>Complete the authorization process if required</p>
        </div>

        <p>After a successful connection, the ServerAvatar MCP connector will be available in Claude.</p>

        <h3>Step 3: Start Managing Your Servers</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Open a new Claude chat</p>
            <p><span class="step-number">2</span>Select your <strong>ServerAvatar MCP</strong> connector</p>
        </div>

        <p>You can now ask Claude to perform ServerAvatar operations, for example:</p>
        <ul>
            <li>Create an application</li>
            <li>List servers</li>
            <li>Manage databases</li>
            <li>Restart services</li>
            <li>Install SSL certificates</li>
            <li>Change application settings</li>
        </ul>
    </div>

    <h2 id="cursor">📝 Cursor</h2>
    
    <div class="client-card">
        <h4>Cursor IDE + ServerAvatar MCP</h4>
        <p>Use ServerAvatar tools directly in Cursor's AI chat.</p>
        
        <h3>Step 1: Install and Sign In</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Download and install Cursor IDE on your computer.</p>
            <p><span class="step-number">2</span>Sign in to your Cursor account.</p>
        </div>

        <h3>Step 2: Generate an IDE Access Token</h3>
        <p>Before connecting Cursor, you need an access token.</p>
        <div class="step-box">
            <p><span class="step-number">1</span>Log in to ServerAvatar MCP.</p>
            <p><span class="step-number">2</span>Navigate to <strong>Endpoint & Tokens</strong>.</p>
            <p><span class="step-number">3</span>Under <strong>IDE Access Tokens</strong>, enter a token name (e.g., Cursor Development).</p>
            <p><span class="step-number">4</span>Click <strong>Generate Token</strong>.</p>
            <p><span class="step-number">5</span>Copy the generated token immediately. It is displayed only once.</p>
        </div>

        <h3>Step 3: Open MCP Settings</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Open Cursor.</p>
            <p><span class="step-number">2</span>Navigate to <strong>Settings → Tools & MCP</strong>.</p>
            <p><span class="step-number">3</span>Under <strong>Installed MCP Servers</strong>, click <strong>+ Add New MCP Server</strong>.</p>
            <p><span class="step-number">4</span>Cursor will open the <code>mcp.json</code> configuration file.</p>
        </div>

        <h3>Step 4: Configure ServerAvatar MCP</h3>
        <p>Replace or add the following configuration in the <code>mcp.json</code> file.</p>
        <pre><code>{
  "mcpServers": {
    "ServerAvatar MCP": {
      "url": "YOUR_MCP_SERVER_URL",
      "headers": {
        "Authorization": "Bearer YOUR_IDE_ACCESS_TOKEN"
      }
    }
  }
}</code></pre>
        <p>Replace:</p>
        <ul>
            <li><code>YOUR_MCP_SERVER_URL</code> with the MCP Server URL from ServerAvatar MCP → Endpoint & Tokens.</li>
            <li><code>YOUR_IDE_ACCESS_TOKEN</code> with the IDE Access Token you generated earlier.</li>
        </ul>
        <p>Save the <code>mcp.json</code> file.</p>

        <h3>Step 5: Verify the Connection</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Return to <strong>Settings → Tools & MCP</strong>.</p>
            <p><span class="step-number">2</span>Verify that <strong>ServerAvatar MCP</strong> appears under <strong>Installed MCP Servers</strong>.</p>
            <p><span class="step-number">3</span>Ensure the server status shows <strong>Connected</strong> or <strong>Available</strong>.</p>
        </div>
        <p>If the connection fails, verify your MCP Server URL and IDE Access Token, then reload Cursor.</p>

        <h3>Step 6: Start Using ServerAvatar MCP</h3>
        <p>Open a new AI chat or Agent session in Cursor and start using natural language commands, for example:</p>
        <ul>
            <li>List my servers</li>
            <li>Create a WordPress application</li>
            <li>List databases</li>
            <li>Restart Nginx</li>
            <li>Install an SSL certificate</li>
        </ul>
        <p>Cursor will automatically invoke the appropriate ServerAvatar MCP tools when required.</p>
        
        <div class="note-box">
            <p><strong>💡 Tip:</strong> If you update the <code>mcp.json</code> file, reload or restart Cursor to ensure the new MCP configuration is loaded.</p>
        </div>
    </div>

    <h2>📋 Example Commands</h2>
    
    <p>Once connected, you can use natural language to manage your infrastructure:</p>
    
    <pre><code># List all servers
"List all my servers"

# Get server status
"Show me the status of my production server"

# Create a WordPress application
"Create a new WordPress application"

# List all databases
"List all my databases"

# Restart Nginx service
"Restart Nginx on my server"

# Install SSL certificate
"Install SSL for mydomain.com"
</code></pre>

    <h2>🔐 Security</h2>
    <div class="note-box">
        <p><strong>Important:</strong> Keep your API Key and IDE Access Tokens secure at all times.</p>
        <ul style="margin: 0.5rem 0 0 1.25rem;">
            <li>Never share your API Key or IDE Access Tokens.</li>
            <li>Store tokens securely.</li>
            <li>Revoke unused tokens immediately.</li>
            <li>Generate separate IDE tokens for different devices.</li>
            <li>Review active tokens regularly.</li>
        </ul>
    </div>

    <h2>⚡ Quick Recap</h2>
    <ul>
        <li>✅ Generate your ServerAvatar API Key</li>
        <li>✅ Connect your ServerAvatar account to ServerAvatar MCP</li>
        <li>✅ Copy your MCP Server URL</li>
        <li>✅ Connect your preferred AI client</li>
        <li>✅ Verify the connection</li>
        <li>✅ Start managing your infrastructure with AI</li>
    </ul>

    <h2>❓ Troubleshooting</h2>
    
    <div style="margin: 1.5rem 0;">
        <div style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; margin-bottom: 1rem;">
            <p style="font-weight: 600; margin: 0 0 0.5rem 0;">Connection failed</p>
            <p style="margin: 0; text-align: center; color: var(--text-muted);">↓</p>
            <p style="margin: 0.5rem 0 0 0;">Check your MCP Server URL.</p>
        </div>
        <hr style="border: none; border-top: 1px dashed var(--border-color); margin: 1rem 0;">
        
        <div style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; margin-bottom: 1rem;">
            <p style="font-weight: 600; margin: 0 0 0.5rem 0;">Unauthorized</p>
            <p style="margin: 0; text-align: center; color: var(--text-muted);">↓</p>
            <p style="margin: 0.5rem 0 0 0;">Verify your API Key or IDE Access Token.</p>
        </div>
        <hr style="border: none; border-top: 1px dashed var(--border-color); margin: 1rem 0;">
        
        <div style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem;">
            <p style="font-weight: 600; margin: 0 0 0.5rem 0;">No tools found</p>
            <p style="margin: 0; text-align: center; color: var(--text-muted);">↓</p>
            <p style="margin: 0.5rem 0 0 0;">Reconnect your AI client.</p>
        </div>
    </div>

<!-- AI Client Connection Modal -->
<div x-show="modalOpen" x-cloak style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:9999;padding:20px;" @click.self="closeModal()">
    <div x-show="selectedClient" style="background:#fff;border-radius:16px;width:100%;max-width:900px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 25px 50px rgba(0,0,0,0.25);" @click.stop>
        
        <!-- Modal Header -->
        <div style="background:linear-gradient(135deg,#f5f3ff 0%,#ede9fe 100%);padding:20px 24px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #e5e7eb;">
            <div style="display:flex;align-items:center;gap:14px;">
                <template x-if="selectedClient && selectedClient.imageLight">
                    <img :src="selectedClient.imageLight" :alt="selectedClient.name" class="icon-light" style="width:36px;height:36px;object-fit:contain;">
                </template>
                <template x-if="selectedClient && !selectedClient.imageLight">
                    <img :src="selectedClient.image" :alt="selectedClient.name" style="width:36px;height:36px;object-fit:contain;">
                </template>
                <div>
                    <h3 style="font-size:18px;font-weight:700;color:#1a1a2e;margin:0;" x-text="selectedClient ? selectedClient.name + ' Setup Guide' : ''"></h3>
                    <p style="font-size:12px;color:#6b7280;margin:4px 0 0 0;" x-text="selectedClient ? selectedClient.badge + ' setup' : ''"></p>
                </div>
            </div>
            <button @click="closeModal()" style="background:none;border:none;cursor:pointer;padding:8px;color:#6b7280;font-size:18px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div style="display:flex;flex:1;overflow:hidden;">
            
            <!-- Sidebar -->
            <div style="width:240px;background:#fafafa;border-right:1px solid #e5e7eb;padding:20px;flex-shrink:0;">
                <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:16px;">Steps</div>
                <template x-for="(step, index) in selectedClient ? selectedClient.steps : []" :key="index">
                    <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid #f0f0f0;">
                        <div style="width:28px;height:28px;min-width:28px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;" x-text="index + 1"></div>
                        <div style="font-size:13px;font-weight:500;color:#1a1a2e;line-height:1.4;" x-text="step.title"></div>
                    </div>
                </template>
                
                <div style="margin-top:20px;padding:16px;background:#fff;border-radius:12px;border:1px solid #e5e7eb;">
                    <p style="font-size:12px;font-weight:600;color:#1a1a2e;margin:0 0 8px 0;">Need Help?</p>
                    <a href="https://support.serveravatar.com" target="_blank" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:500;color:#7c3aed;text-decoration:none;">
                        Contact Support <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>
            </div>
            
            <!-- Main Content -->
            <div style="flex:1;padding:24px;overflow-y:auto;">
                <template x-for="(step, index) in selectedClient ? selectedClient.steps : []" :key="index">
                    <div style="margin-bottom:28px;">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                            <div style="width:32px;height:32px;min-width:32px;background:#7c3aed;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;" x-text="index + 1"></div>
                            <h4 style="font-size:16px;font-weight:700;color:#1a1a2e;margin:0;" x-text="step.title"></h4>
                        </div>
                        <p style="font-size:14px;color:#6b7280;margin:0 0 16px 44px;line-height:1.6;" x-text="step.desc"></p>
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
