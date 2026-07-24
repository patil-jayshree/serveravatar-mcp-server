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

/* Guide Theme-Aware Styles */
.guide-banner { background: var(--bg-card); border: 1px solid var(--border-color); }
.guide-banner h1 { color: var(--text-primary); }
.guide-banner p { color: var(--text-secondary); }

.guide-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); }
.guide-card h2 { color: var(--text-primary); }
.guide-card h2 span { color: var(--accent-primary); }
.guide-card p { color: var(--text-secondary); }

.guide-card-purple { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 16px; }
.guide-card-purple .icon { color: var(--accent-primary); }
.guide-card-purple .title { color: var(--text-primary); }
.guide-card-purple .desc { color: var(--text-secondary); }

.guide-feature-box { background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px 16px; text-align: center; }
.guide-feature-box .icon { color: var(--accent-primary); font-size: 24px; margin-bottom: 10px; }
.guide-feature-box .title { font-size: 13px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px; }
.guide-feature-box .desc { font-size: 11px; color: var(--text-secondary); line-height: 1.4; }

.guide-flow-box { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 16px; }
.guide-flow-box .icon { color: var(--accent-primary); font-size: 24px; }
.guide-flow-box .title { font-size: 15px; font-weight: 600; color: var(--text-primary); }
.guide-flow-box .desc { font-size: 12px; color: var(--text-secondary); }

.guide-info-box { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; display: flex; align-items: flex-start; gap: 14px; }
.guide-info-box .icon { color: var(--accent-primary); font-size: 20px; min-width: 36px; }
.guide-info-box .text { font-size: 13px; color: var(--text-primary); line-height: 1.6; }

.guide-step-box { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 14px; }
.guide-step-box .icon { color: var(--accent-primary); font-size: 20px; }

.guide-timeline-step { display: flex; align-items: flex-start; gap: 14px; position: relative; }
.guide-timeline-step .step-num { width: 32px; height: 32px; background: var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; font-weight: 700; flex-shrink: 0; position: relative; z-index: 1; }
.guide-timeline-step .step-num.empty { background: transparent; border: 2px dashed var(--accent-primary); color: var(--accent-primary); }
.guide-timeline-step .step-content { flex: 1; }
.guide-timeline-step .step-title { font-size: 14px; font-weight: 600; color: var(--text-primary); line-height: 32px; }
.guide-timeline-step .step-desc { font-size: 12px; color: var(--text-secondary); line-height: 1.5; }
.guide-timeline-line { width: 2px; height: 32px; border-left: 2px dotted #d1d5db; margin-left: 15px; margin-top: -32px; padding-top: 32px; box-sizing: border-box; }
[data-theme="dark"] .guide-timeline-line { border-left-color: #4b5563; }

.guide-note-box { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 20px; display: flex; align-items: flex-start; gap: 14px; }
.guide-note-box .icon { color: var(--accent-primary); font-size: 24px; min-width: 24px; }
.guide-note-box .text { font-size: 13px; color: var(--text-primary); line-height: 1.6; }

.guide-tools-banner { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 16px 20px; }
.guide-tools-banner .icon-box { background: var(--accent-primary-muted); border: 2px solid var(--accent-primary); }
.guide-tools-banner .icon { color: var(--accent-primary); }
.guide-tools-banner h3 { color: var(--accent-primary); }
.guide-tools-banner p { color: var(--text-secondary); }

.guide-tools-stat .stat-icon { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); }
.guide-tools-stat .stat-icon i { color: var(--accent-primary); }
.guide-tools-stat .stat-num { color: var(--accent-primary); }
.guide-tools-stat .stat-label { color: var(--text-secondary); }

.guide-tool-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 14px; cursor: pointer; transition: all 0.2s; }
.guide-tool-card:hover { border-color: var(--border-color-hover); }
.guide-tool-card .icon-box-blue { background: rgba(59, 130, 246, 0.12); }
.guide-tool-card .icon-box-blue i { color: #3b82f6; }
.guide-tool-card .icon-box-orange { background: rgba(249, 115, 22, 0.12); }
.guide-tool-card .icon-box-orange i { color: #f97316; }
.guide-tool-card .icon-box-red { background: rgba(239, 68, 68, 0.12); }
.guide-tool-card .icon-box-red i { color: #ef4444; }
.guide-tool-card .icon-box-green { background: rgba(16, 185, 129, 0.12); }
.guide-tool-card .icon-box-green i { color: #10b981; }
.guide-tool-card .icon-box-purple { background: rgba(139, 92, 246, 0.12); }
.guide-tool-card .icon-box-purple i { color: #7c3aed; }
.guide-tool-card .title { font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 3px; }
.guide-tool-card .desc { font-size: 11px; color: var(--text-secondary); line-height: 1.4; }
.guide-tool-card .badge-blue { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.guide-tool-card .badge-orange { background: rgba(249, 115, 22, 0.12); color: #f97316; }
.guide-tool-card .badge-red { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
.guide-tool-card .badge-green { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.guide-tool-card .badge-purple { background: rgba(139, 92, 246, 0.12); color: #7c3aed; }

.guide-ai-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 14px; cursor: pointer; transition: all 0.2s; }
.guide-ai-card:hover { border-color: var(--border-color-hover); transform: translateY(-2px); }
.guide-ai-card .logo-box { background: rgba(139, 92, 246, 0.12); }
.guide-ai-card .name { font-weight: 600; font-size: 15px; color: var(--text-primary); }
.guide-ai-card .setup { font-size: 12px; color: var(--text-secondary); }

.guide-tools-banner-box { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; gap: 24px; margin-bottom: 20px; flex-wrap: wrap; }
.guide-tools-banner-box .icon-wrap { background: var(--bg-card); border: 2px solid var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.guide-tools-banner-box .icon { color: var(--accent-primary); }
.guide-tools-banner-box h3 { color: var(--accent-primary); font-size: 15px; font-weight: 700; margin: 0 0 4px 0; }
.guide-tools-banner-box p { color: var(--text-secondary); font-size: 12px; margin: 0; line-height: 1.4; }

.guide-tools-stat-box { display: flex; align-items: center; gap: 10px; }
.guide-tools-stat-box .stat-icon { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
.guide-tools-stat-box .stat-icon i { color: var(--accent-primary); }
.guide-tools-stat-box .stat-num { font-size: 18px; font-weight: 700; color: var(--accent-primary); }
.guide-tools-stat-box .stat-label { font-size: 11px; color: var(--text-secondary); }

.guide-tool-card-simple { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 14px; cursor: pointer; transition: all 0.2s; }
.guide-tool-card-simple:hover { border-color: var(--border-color-hover); }
.guide-tool-card-simple .icon-circle { border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.guide-tool-card-simple .icon-circle.blue { background: rgba(59, 130, 246, 0.12); }
.guide-tool-card-simple .icon-circle.blue i { color: #3b82f6; }
.guide-tool-card-simple .icon-circle.orange { background: rgba(249, 115, 22, 0.12); }
.guide-tool-card-simple .icon-circle.orange i { color: #f97316; }
.guide-tool-card-simple .icon-circle.red { background: rgba(239, 68, 68, 0.12); }
.guide-tool-card-simple .icon-circle.red i { color: #ef4444; }
.guide-tool-card-simple .icon-circle.green { background: rgba(34, 197, 94, 0.12); }
.guide-tool-card-simple .icon-circle.green i { color: #22c55e; }
.guide-tool-card-simple .title { font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 3px; }
.guide-tool-card-simple .desc { font-size: 11px; color: var(--text-secondary); line-height: 1.4; }
.guide-tool-card-simple .badge { font-size: 10px; font-weight: 600; padding: 5px 10px; border-radius: 20px; white-space: nowrap; }
.guide-tool-card-simple .badge.blue { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.guide-tool-card-simple .badge.orange { background: rgba(249, 115, 22, 0.12); color: #f97316; }
.guide-tool-card-simple .badge.red { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
.guide-tool-card-simple .badge.green { background: rgba(34, 197, 94, 0.12); color: #22c55e; }

.guide-how-it-works-box { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 20px; margin-bottom: 20px; }
.guide-how-it-works-box .step-circle { position: absolute; top: -9px; left: 50%; transform: translateX(-50%); width: 20px; height: 20px; background: var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.guide-how-it-works-box .step-circle span { color: #fff; font-size: 11px; font-weight: 600; }
.guide-how-it-works-box .outer-circle { background: var(--bg-card); border: 2px solid var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.guide-how-it-works-box .outer-circle i { color: var(--accent-primary); }
.guide-how-it-works-box h3 { color: var(--accent-primary); font-size: 16px; font-weight: 700; margin: 0 0 4px 0; }
.guide-how-it-works-box p { color: var(--text-secondary); font-size: 13px; margin: 0; line-height: 1.5; }

.guide-client-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; cursor: pointer; transition: all 200ms; }
.guide-client-card:hover { background: var(--bg-card-hover); border-color: var(--accent-primary); }
.guide-client-card .logo-wrap { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.guide-client-card .name { font-size: 14px; font-weight: 600; color: var(--text-primary); }
.guide-client-card .desc { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }
.guide-client-card .time-badge { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); color: var(--accent-primary); font-size: 12px; font-weight: 500; padding: 2px 10px; border-radius: 20px; }
.guide-client-card .arrow { color: var(--text-muted); font-size: 12px; }

.guide-star-desc { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.guide-star-desc i { color: var(--accent-primary); font-size: 16px; }
.guide-star-desc p { font-size: 13px; color: var(--text-secondary); margin: 0; line-height: 1.6; }
.guide-star-desc span { color: var(--accent-primary); font-weight: 500; }

.guide-step-visual { display: flex; flex-direction: column; align-items: center; }
.guide-step-visual .step-num-badge { position: absolute; top: -9px; left: 50%; transform: translateX(-50%); width: 20px; height: 20px; background: var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.guide-step-visual .step-num-badge span { color: #fff; font-size: 11px; font-weight: 600; }
.guide-step-visual .outer-circle { background: var(--bg-card); border: 2px solid var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.guide-step-visual .outer-circle i { color: var(--accent-primary); }
.guide-step-dotted-line { border-left: 2px dotted #d1d5db; }
[data-theme="dark"] .guide-step-dotted-line { border-left-color: #4b5563; }
.guide-step-label { font-size: 12px; font-weight: 500; color: var(--text-primary); white-space: nowrap; display: block; }
.guide-arrow { color: var(--accent-primary); font-size: 20px; font-weight: 300; }

.guide-ai-client-card-main { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); flex: 1; min-width: 0; }

.guide-example-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); flex: 1; min-width: 0; }
.guide-example-card h2 { font-size: 24px; font-weight: 700; margin: 0 0 6px 0; line-height: 1.2; }
.guide-example-card h2 span { color: #7c3aed; }
.guide-example-card p { font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0; }
.guide-example-card .card-link { color: #7c3aed; font-size: 14px; font-weight: 600; text-decoration: none; }

.guide-command-item { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; gap: 10px; cursor: pointer; transition: all 200ms; }
.guide-command-item:hover { border-color: var(--accent-primary); background: var(--bg-card-hover); }
.guide-command-item .cmd-icon { color: #7c3aed; font-size: 14px; }
.guide-command-item .cmd-text { font-size: 13px; font-weight: 500; color: var(--text-primary); }
.guide-command-item .cmd-copy { color: #9ca3af; font-size: 12px; }

.guide-security-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); flex: 1; min-width: 0; }
.guide-security-card h2 { font-size: 24px; font-weight: 700; margin: 0 0 6px 0; line-height: 1.2; }
.guide-security-card h2 span { color: #7c3aed; }
.guide-security-card p { font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0; }

.guide-security-item { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; padding: 10px 14px; display: flex; align-items: center; gap: 12px; }
.guide-security-item .sec-icon { color: #7c3aed; font-size: 14px; min-width: 20px; text-align: center; }
.guide-security-item .sec-text { font-size: 13px; font-weight: 500; color: var(--text-primary); }

.guide-code-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); }
.guide-code-block { background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 10px; padding: 16px; position: relative; }
.guide-code-block pre { margin: 0; font-size: 13px; color: var(--text-primary); white-space: pre-wrap; word-break: break-all; }
.guide-code-block .code-lang { font-size: 11px; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase; font-weight: 600; }

.guide-banner-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); }

.guide-troubleshoot-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); flex: 1; min-width: 0; }
.guide-troubleshoot-card h2 { font-size: 24px; font-weight: 700; margin: 0 0 6px 0; line-height: 1.2; }
.guide-troubleshoot-card h2 span { color: #7c3aed; }
.guide-troubleshoot-card p { font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0; }

.guide-accordion-item { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 0; cursor: pointer; transition: all 200ms; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.guide-accordion-item:hover { background: var(--bg-card-hover); border-color: var(--accent-primary); }
.guide-accordion-item .accordion-header { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 12px 16px; box-sizing: border-box; }
.guide-accordion-item .accordion-icon { width: 34px; height: 34px; min-width: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.guide-accordion-item .accordion-title { font-size: 15px; font-weight: 600; color: var(--text-primary); flex: 1; margin-left: 14px; }
.guide-accordion-item .accordion-chevron { color: var(--text-muted); font-size: 18px; margin-left: auto; transition: transform 200ms; }
.guide-accordion-item .accordion-content { background: var(--bg-card); border-top: 1px solid var(--border-color); }
.guide-accordion-item .accordion-content p { font-size: 13px; color: var(--text-secondary); line-height: 1.7; margin: 0; padding: 8px 14px; }

.guide-summary-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); flex: 1; min-width: 0; }
.guide-summary-card h2 { font-size: 24px; font-weight: 700; margin: 0 0 6px 0; line-height: 1.2; }
.guide-summary-card h2 span { color: #7c3aed; }
.guide-summary-card p { font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0; }

.guide-summary-step { display: flex; align-items: center; gap: 12px; }
.guide-summary-step .step-num { width: 28px; height: 28px; min-width: 28px; background: #f5f3ff; color: #7c3aed; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
.guide-summary-step .step-text { font-size: 13px; font-weight: 500; color: var(--text-primary); }

.guide-support-link { font-size: 14px; font-weight: 500; color: #6b7280; text-decoration: none; transition: color 200ms; }
.guide-support-link:hover { color: #7c3aed; }
.guide-support-link span { font-weight: 600; color: #7c3aed; }

.guide-code-snippet-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); }

.guide-mcp-universal-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); }

.guide-api-key-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); }

.guide-ide-token-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); }

.guide-modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999; background: rgba(0,0,0,0.5); }
.guide-modal-content { background: var(--bg-card); border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); overflow: hidden; display: flex; flex-direction: column; }
.guide-modal-header { background: var(--bg-card); border-bottom: 1px solid var(--border-color); padding: 24px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
.guide-modal-sidebar { background: #fafafa; border-right: 1px solid #e5e7eb; }
.guide-modal-sidebar::-webkit-scrollbar { width: 0; height: 0; }
.guide-modal-sidebar { -ms-overflow-style: none; scrollbar-width: none; }
.guide-modal-step-num { background: #7c3aed; color: #fff; }
.guide-modal-step-title-active { color: #7c3aed; }
.guide-modal-step-title { color: #1a1a2e; }
.guide-modal-header-title { color: #1a1a2e; }
.guide-modal-header-subtitle { color: #6b7280; }
.guide-modal-close-btn { color: #1a1a2e; }
.guide-modal-need-help { background: #f5f3ff; border: 1px solid #e9d5ff; }
.guide-modal-need-help p { color: #7c3aed; }
.guide-modal-need-help a { color: #7c3aed; }

/* Modal Step Cards */
.guide-modal-step-card { background: #fafafa; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 12px; }
.guide-modal-step-card h4 { font-size: 16px; font-weight: 700; color: #7c3aed; margin: 0 0 16px 0; }
.guide-modal-step-card h4 span { color: #1a1a2e; }
.guide-modal-substep { display: flex; align-items: center; gap: 12px; }
.guide-modal-substep-num { width: 24px; height: 24px; min-width: 24px; background: #7c3aed; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; flex-shrink: 0; }
.guide-modal-substep-text { font-size: 14px; color: #1a1a2e; margin: 0; line-height: 1.5; }
.guide-modal-info-note { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 12px; padding: 12px 16px; display: flex; align-items: flex-start; gap: 14px; margin-bottom: 16px; }
.guide-modal-info-note p { color: #7c3aed; }
.guide-modal-info-note .note-title { font-size: 14px; font-weight: 600; margin: 0 0 4px 0; }
.guide-modal-info-note .note-text { font-size: 13px; margin: 0; line-height: 1.5; }
.guide-modal-note-box { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 8px; padding: 12px 16px; margin-bottom: 12px; }
.guide-modal-note-box p { font-size: 13px; color: #7c3aed; margin: 0; line-height: 1.5; }
.guide-modal-note-box strong { font-weight: 600; }
.guide-modal-example-btn { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 500; color: #7c3aed; cursor: pointer; white-space: nowrap; }
.guide-modal-desc-text { font-size: 14px; color: #1a1a2e; margin: 0 0 12px 0; line-height: 1.5; }

/* VS Code Modal Specific */
.guide-modal-vscode-info { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 12px; padding: 16px; margin-bottom: 12px; }
.guide-modal-vscode-info .info-icon { width: 24px; height: 24px; min-width: 24px; background: #7c3aed; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; }
.guide-modal-vscode-info p { font-size: 13px; color: #7c3aed; margin: 0; line-height: 1.5; }
.guide-modal-vscode-section-title h4 { font-size: 18px; font-weight: 700; color: #1a1a2e; margin: 0 0 8px 0; }
.guide-modal-vscode-section-title p { font-size: 14px; color: #6b7280; margin: 0; }
.guide-modal-oauth-card { background: #ecfdf5; border: 1px solid #6ee7b7; border-radius: 12px; margin-bottom: 12px; overflow: hidden; }
.guide-modal-oauth-header { padding: 16px 16px 8px 16px; display: flex; align-items: center; gap: 12px; cursor: pointer; }
.guide-modal-oauth-icon { width: 48px; height: 48px; min-width: 48px; background: #10b981; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.guide-modal-oauth-icon i { font-size: 20px; }
.guide-modal-oauth-badge { background: #d1fae5; color: #065f46; font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 20px; display: inline-block; margin-bottom: 4px; }
.guide-modal-oauth-title { font-size: 15px; font-weight: 600; color: #065f46; margin: 0; }
.guide-modal-oauth-arrow { color: #10b981; font-size: 14px; transition: transform 0.3s; }
.guide-modal-oauth-body { padding: 0 16px 16px 76px; }
.guide-modal-oauth-body p { font-size: 13px; color: #065f46; margin: 0 0 6px 0; }
.guide-modal-oauth-body i { color: #10b981; margin-right: 8px; }
.guide-modal-oauth-content { padding: 0 16px 16px 16px; border-top: 1px solid #6ee7b7; }
.guide-modal-token-card { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 12px; margin-bottom: 12px; overflow: hidden; }
.guide-modal-token-header { padding: 16px 16px 8px 16px; display: flex; align-items: center; gap: 12px; cursor: pointer; }
.guide-modal-token-icon { width: 48px; height: 48px; min-width: 48px; background: #f59e0b; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.guide-modal-token-icon i { font-size: 20px; }
.guide-modal-token-badge { background: #fde68a; color: #92400e; font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 20px; display: inline-block; margin-bottom: 4px; }
.guide-modal-token-title { font-size: 15px; font-weight: 600; color: #92400e; margin: 0; }
.guide-modal-token-arrow { color: #f59e0b; font-size: 14px; transition: transform 0.3s; }
.guide-modal-token-body { padding: 0 16px 16px 76px; }
.guide-modal-token-body p { font-size: 13px; color: #92400e; margin: 0 0 6px 0; }
.guide-modal-token-body i { color: #f59e0b; margin-right: 8px; }

.guide-modal-idetoken-card { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 12px; margin-bottom: 12px; overflow: hidden; }
.guide-modal-idetoken-header { padding: 16px 16px 8px 16px; display: flex; align-items: center; gap: 12px; cursor: pointer; }
.guide-modal-idetoken-icon { width: 48px; height: 48px; min-width: 48px; background: #7c3aed; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.guide-modal-idetoken-icon i { font-size: 20px; }
.guide-modal-idetoken-title { font-size: 15px; font-weight: 600; color: #7c3aed; margin: 0; }
.guide-modal-idetoken-arrow { color: #7c3aed; font-size: 14px; transition: transform 0.3s; }
.guide-modal-idetoken-body { padding: 0 16px 16px 76px; }
.guide-modal-idetoken-body p { font-size: 13px; color: #7c3aed; margin: 0 0 6px 0; }
.guide-modal-idetoken-body i { color: #7c3aed; margin-right: 8px; }
.guide-modal-idetoken-content { padding: 0 16px 16px 16px; border-top: 1px solid #ddd6fe; }
.guide-modal-code { background: #f3f4f6; padding: 2px 8px; border-radius: 12px; font-size: 12px; color: #7c3aed; font-weight: 500; font-family: monospace; }
.guide-modal-code-inline { background: #f3f4f6; padding: 2px 8px; border-radius: 4px; font-size: 13px; color: #7c3aed; font-family: monospace; }
.guide-modal-bold-text { font-size: 14px; color: #1a1a2e; margin: 16px 0 0 0; line-height: 1.5; }
.guide-modal-bold-text strong { font-weight: 600; }
.guide-modal-check-item { font-size: 13px; color: #065f46; margin: 0 0 6px 0; }
.guide-modal-check-item i { color: #10b981; margin-right: 8px; }
.guide-modal-idetoken-check { font-size: 13px; color: #7c3aed; margin: 0 0 6px 0; }
.guide-modal-idetoken-check i { color: #7c3aed; margin-right: 8px; }
.guide-modal-help-box { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 12px; padding: 16px; display: flex; align-items: flex-start; gap: 12px; }
.guide-modal-help-box .help-icon { width: 24px; height: 24px; min-width: 24px; background: #f59e0b; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; flex-shrink: 0; }
.guide-modal-help-box .help-icon i { font-size: 12px; }
.guide-modal-help-box p { font-size: 13px; color: #92400e; margin: 0; line-height: 1.5; }
.guide-modal-help-box .help-title { font-size: 14px; font-weight: 600; color: #92400e; margin: 0 0 8px 0; }
.guide-modal-success-box { background: #ecfdf5; border: 1px solid #6ee7b7; border-radius: 10px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px; margin-top: 16px; text-align: center; justify-content: center; }
.guide-modal-success-box p { font-size: 14px; color: #065f46; margin: 0; font-weight: 500; }
.guide-modal-code-block { background: #1e1e2e; padding: 16px; border-radius: 8px; position: relative; margin-top: 12px; }
.guide-modal-code-block .code-title { position: absolute; top: 8px; left: 12px; font-size: 11px; color: #9ca3af; }
.guide-modal-code-block pre { margin: 0; font-size: 13px; color: #e2e8f0; white-space: pre-wrap; word-break: break-all; font-family: monospace; margin-top: 20px; }
.guide-modal-tip-box { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 8px; padding: 12px 16px; }
.guide-modal-tip-box p { font-size: 14px; color: #92400e; margin: 0; line-height: 1.5; }
.guide-modal-error-text { font-size: 14px; color: #991b1b; margin: 0; line-height: 1.5; }
.guide-modal-error-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-top: 16px; }
.guide-modal-step-title { font-size: 16px; font-weight: 700; color: #1a1a2e; margin: 0 0 16px 0; }
.guide-modal-step-title span { color: #7c3aed; }

.guide-warning-box { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 10px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px; margin-top: 16px; }
.guide-warning-box i { color: #dc2626; font-size: 18px; padding-top: 1px; }
.guide-warning-box p { font-size: 13px; color: #dc2626; line-height: 1.5; margin: 0; }

.guide-success-box { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 10px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px; margin-top: 16px; text-align: center; justify-content: center; }
.guide-success-box p { font-size: 14px; color: #7c3aed; margin: 0; font-weight: 500; }

.guide-final-banner { width: 100%; padding: 28px 120px 28px 32px; background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border: 1px solid #ddd6fe; border-radius: 16px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; box-sizing: border-box; }
.guide-final-banner .banner-text p { font-size: 18px; font-weight: 700; color: #7c3aed; margin: 0 0 6px 0; }
.guide-final-banner .banner-text p + p { font-size: 13px; color: #7c3aed; margin: 0 0 4px 0; line-height: 1.6; }
.guide-final-banner .banner-text p:last-child { margin: 0; }
.guide-final-banner .banner-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 32px; background: #7c3aed; color: #fff; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 200ms; white-space: nowrap; min-width: 180px; }
.guide-final-banner .banner-btn:hover { background: #6d28d9; }
.guide-final-banner .banner-link { display: inline-flex; align-items: center; gap: 6px; font-size: 14px; font-weight: 600; color: #7c3aed; text-decoration: none; transition: color 200ms; }
.guide-final-banner .banner-link:hover { color: #6d28d9; }

.guide-illustration { background: transparent; border-radius: 0; padding: 0; }
</style>

<div class="guide-banner" style="display:flex;flex-direction:row;align-items:flex-start;justify-content:space-between;padding:12px 24px 12px 24px;border-radius:12px;box-sizing:border-box;min-height:200px;">
    <div style="flex:1;padding-top:4px;">
        <h1 style="font-size:22px;font-weight:700;margin:0 0 6px 0;line-height:1.2;">MCP Guide</h1>
        <p style="font-size:14px;margin:0;line-height:1.5;max-width:520px;">Learn how to connect ServerAvatar MCP with your favorite AI clients and manage your infrastructure using natural language.</p>
    </div>
    <div style="flex-shrink:0;padding-left:24px;">
        <img src="/images/mcp-guide-illustration.png" alt="MCP Guide" style="width:280px;height:200px;object-fit:contain;" loading="lazy">
    </div>
</div>

<!-- Two Cards Row -->
<div style="display:flex;gap:24px;margin-top:20px;margin-bottom:24px;width:100%;box-sizing:border-box;">

<!-- Card 1: What is MCP? -->
<div class="guide-card" style="flex:1.7;">
    <div style="margin-bottom:20px;">
        <h2 style="font-size:24px;font-weight:700;margin:0 0 12px 0;line-height:1.2;"><span style="color:#7c3aed;">1.</span> What is MCP?</h2>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Model Context Protocol (MCP) is an open standard that allows AI applications to securely connect with external tools and data sources. It acts as a bridge between AI assistants and your real-world infrastructure.</p>
    </div>
    
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="guide-feature-box">
            <div class="icon"><i class="fas fa-globe"></i></div>
            <div class="title">Universal Connection</div>
            <div class="desc">One protocol, many integrations</div>
        </div>
        <div class="guide-feature-box">
            <div class="icon"><i class="fas fa-shield-alt"></i></div>
            <div class="title">Secure</div>
            <div class="desc">Authentication built-in</div>
        </div>
        <div class="guide-feature-box">
            <div class="icon"><i class="fas fa-bolt"></i></div>
            <div class="title">Real-Time Data</div>
            <div class="desc">Live information access</div>
        </div>
        <div class="guide-feature-box">
            <div class="icon"><i class="fas fa-wrench"></i></div>
            <div class="title">Tools Access</div>
            <div class="desc">Extensive capabilities</div>
        </div>
    </div>
    
    <!-- Info Box -->
    <div class="guide-info-box" style="margin-top:16px;">
        <div class="icon"><i class="fas fa-info-circle"></i></div>
        <div class="text">The AI client (ChatGPT, Claude, etc.) connects to an MCP server. The server exposes "tools" that the AI can use. When you ask the AI to do something, it can call these tools in real-time.</div>
    </div>
</div>

<!-- Card 2: How It Works -->
<div class="guide-card" style="flex:1;">
    <div style="margin-bottom:24px;">
        <h2 style="font-size:24px;font-weight:700;margin:0 0 8px 0;line-height:1.2;"><span style="color:#7c3aed;">2.</span> How MCP Works</h2>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">MCP follows a simple client-server architecture.</p>
    </div>
    
    <div style="display:flex;flex-direction:column;gap:6px;">
        <div class="guide-flow-box">
            <div class="icon"><i class="fas fa-robot"></i></div>
            <div style="flex:1;">
                <div class="title">AI Client</div>
                <div class="desc">ChatGPT, Claude, Cursor</div>
            </div>
        </div>
        
        <div style="display:flex;justify-content:center;margin:0;padding:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
        </div>
        
        <div class="guide-flow-box">
            <div class="icon"><i class="fas fa-server"></i></div>
            <div style="flex:1;">
                <div class="title">MCP Server</div>
                <div class="desc">ServerAvatar MCP</div>
            </div>
        </div>
        
        <div style="display:flex;justify-content:center;margin:0;padding:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
        </div>
        
        <div class="guide-flow-box">
            <div class="icon"><i class="fas fa-globe"></i></div>
            <div style="flex:1;">
                <div class="title">Real World</div>
                <div class="desc">Servers, Databases, APIs</div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Two Cards Row 2 -->
<div style="display:flex;gap:24px;margin-top:24px;width:100%;box-sizing:border-box;">

<!-- Card 3: What You Can Do with ServerAvatar MCP -->
<div class="guide-card" style="flex:1.7;">
    <div style="margin-bottom:20px;">
        <h2 style="font-size:24px;font-weight:700;margin:0 0 8px 0;line-height:1.2;"><span style="color:#7c3aed;">3.</span> What You Can Do with ServerAvatar MCP</h2>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Manage your entire infrastructure using simple, natural language through your AI assistant.</p>
    </div>
    
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
        <div class="guide-feature-box">
            <div class="icon"><i class="fas fa-cog"></i></div>
            <div class="title">Server Management</div>
            <div class="desc">Restart services, monitor resources, check logs and more.</div>
        </div>
        <div class="guide-feature-box">
            <div class="icon"><i class="fas fa-cube"></i></div>
            <div class="title">Application Management</div>
            <div class="desc">Create, deploy, update and manage all your applications.</div>
        </div>
        <div class="guide-feature-box">
            <div class="icon"><i class="fas fa-database"></i></div>
            <div class="title">Database Management</div>
            <div class="desc">Create, delete, and manage databases with ease.</div>
        </div>
        <div class="guide-feature-box">
            <div class="icon"><i class="fas fa-shield-alt"></i></div>
            <div class="title">Security & SSL</div>
            <div class="desc">Install SSL certificates and manage firewall rules.</div>
        </div>
        <div class="guide-feature-box">
            <div class="icon"><i class="fab fa-wordpress"></i></div>
            <div class="title">WordPress Management</div>
            <div class="desc">Manage WordPress sites, plugins, themes, and updates.</div>
        </div>
        <div class="guide-feature-box">
            <div class="icon"><i class="fas fa-clock"></i></div>
            <div class="title">Cronjob Automation</div>
            <div class="desc">Create, manage, and monitor scheduled tasks.</div>
        </div>
    </div>
</div>

<!-- Card 4: Quick Setup -->
<div class="guide-card" style="flex:1;">
    <div style="margin-bottom:20px;">
        <h2 style="font-size:24px;font-weight:700;margin:0 0 8px 0;line-height:1.2;"><span style="color:#7c3aed;">4.</span> Quick Setup</h2>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Connect ServerAvatar MCP in 4 simple steps.</p>
    </div>
    
    <div style="display:flex;flex-direction:column;gap:0;padding-top:0;">
        <div class="guide-timeline-step">
            <div class="step-num">1</div>
            <div class="step-content">
                <div class="step-title">Generate API Key</div>
                <div class="step-desc">Get your API Key from ServerAvatar Account Settings → API Access.</div>
            </div>
        </div>
        <div class="guide-timeline-line"></div>
        <div class="guide-timeline-step">
            <div class="step-num">2</div>
            <div class="step-content">
                <div class="step-title">Connect Your Account</div>
                <div class="step-desc">Add the API Key in ServerAvatar MCP Account Settings → API Access.</div>
            </div>
        </div>
        <div class="guide-timeline-line"></div>
        <div class="guide-timeline-step">
            <div class="step-num">3</div>
            <div class="step-content">
                <div class="step-title">Copy MCP Server URL</div>
                <div class="step-desc">Go to Endpoint & Tokens and copy your MCP Server URL.</div>
            </div>
        </div>
        <div class="guide-timeline-line"></div>
        <div class="guide-timeline-step">
            <div class="step-num">4</div>
            <div class="step-content">
                <div class="step-title">Connect AI Client</div>
                <div class="step-desc">Use the URL to connect your preferred AI client and start managing.</div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Card 5: Note -->
<div class="guide-note-box" style="margin-top:20px;">
    <div class="icon"><i class="fas fa-lightbulb"></i></div>
    <div class="text"><strong style="font-weight:600;">Note:</strong> IDE Access Tokens are only required for IDE-based AI clients such as Cursor, Windsurf, VS Code, Cline, and Continue. Browser-based AI clients like ChatGPT and Claude connect using the MCP Server URL and do not require an IDE Access Token.</div>
</div>

<!-- Cards 5 & 6 Row: Available Tools + Connect AI Clients -->
<div style="display:flex;gap:24px;margin-top:20px;width:100%;box-sizing:border-box;">

    <!-- Card 5: Available Tools -->
    <div class="guide-card" style="flex:1;">
        <div style="margin-bottom:20px;">
            <h2 style="font-size:24px;font-weight:700;margin:0 0 6px 0;line-height:1.2;"><span style="color:#7c3aed;">5.</span> Available Tools</h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">ServerAvatar MCP provides 80+ tools across multiple categories.</p>
        </div>
        
        <!-- Available Tools Banner -->
        <div class="guide-tools-banner-box">
            <!-- Left Side: Icon + Text -->
            <div style="display:flex;align-items:center;gap:14px;">
                <div class="icon-wrap" style="width:52px;height:52px;min-width:52px;">
                    <i class="fas fa-wrench icon" style="font-size:22px;"></i>
                </div>
                <div>
                    <h3>Powerful. Organized. Ready to Use.</h3>
                    <p>Tools are grouped by category to help you quickly find the right capabilities for your workflow.</p>
                </div>
            </div>
            
            <!-- Right Side: Stats -->
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                <!-- Stat 1: Total Tools -->
                <div class="guide-tools-stat-box">
                    <div class="stat-icon" style="width:36px;height:36px;min-width:36px;">
                        <i class="fas fa-star" style="font-size:14px;"></i>
                    </div>
                    <div>
                        <div class="stat-num">80+</div>
                        <div class="stat-label">Total Tools</div>
                    </div>
                </div>
                
                <!-- Stat 2: Categories -->
                <div class="guide-tools-stat-box">
                    <div class="stat-icon" style="width:36px;height:36px;min-width:36px;">
                        <i class="fas fa-th-large" style="font-size:14px;"></i>
                    </div>
                    <div>
                        <div class="stat-num">10+</div>
                        <div class="stat-label">Categories</div>
                    </div>
                </div>
                
                <!-- Stat 3: MCP Ready -->
                <div class="guide-tools-stat-box">
                    <div class="stat-icon" style="width:36px;height:36px;min-width:36px;">
                        <i class="fas fa-bolt" style="font-size:14px;"></i>
                    </div>
                    <div>
                        <div class="stat-num">100%</div>
                        <div class="stat-label">MCP Ready</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
            <div class="guide-tool-card-simple">
                <div class="icon-circle blue" style="width:48px;height:48px;min-width:48px;">
                    <i class="fas fa-server" style="font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="title">Servers</div>
                    <div class="desc">Manage and monitor servers, resources, and configurations</div>
                </div>
                <span class="badge blue">22 Tools</span>
            </div>
            <div class="guide-tool-card-simple">
                <div class="icon-circle blue" style="width:48px;height:48px;min-width:48px;">
                    <i class="fas fa-globe" style="font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="title">Applications</div>
                    <div class="desc">Deploy, manage and optimize your applications with ease</div>
                </div>
                <span class="badge blue">9 Tools</span>
            </div>
            <div class="guide-tool-card-simple">
                <div class="icon-circle orange" style="width:48px;height:48px;min-width:48px;">
                    <i class="fas fa-hdd" style="font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="title">Databases</div>
                    <div class="desc">Create, manage and optimize your databases</div>
                </div>
                <span class="badge orange">4 Tools</span>
            </div>
            <div class="guide-tool-card-simple">
                <div class="icon-circle red" style="width:48px;height:48px;min-width:48px;">
                    <i class="fas fa-shield-alt" style="font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="title">Firewall</div>
                    <div class="desc">Manage firewall rules and security settings</div>
                </div>
                <span class="badge red">4 Tools</span>
            </div>
            <div class="guide-tool-card-simple">
                <div class="icon-circle green" style="width:48px;height:48px;min-width:48px;">
                    <i class="fas fa-clock" style="font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="title">Cronjobs</div>
                    <div class="desc">Schedule and manage automated tasks</div>
                </div>
                <span class="badge green">6 Tools</span>
            </div>
            <div class="guide-tool-card-simple">
                <div class="icon-circle blue" style="width:48px;height:48px;min-width:48px;">
                    <i class="fab fa-wordpress" style="font-size:20px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="title">WordPress</div>
                    <div class="desc">Manage WordPress sites, plugins, themes, and updates</div>
                </div>
                <span class="badge blue">33 Tools</span>
            </div>
        </div>
        
        <div style="margin-top:20px;text-align:center;">
            <a href="{{ url('/tools') }}" style="display:inline-flex;align-items:center;gap:8px;color:#7c3aed;font-size:14px;font-weight:600;text-decoration:none;">Explore All Tools <i class="fas fa-arrow-right" style="font-size:12px;"></i></a>
        </div>
    </div>
</div>

<!-- Card 6: Connect AI Clients -->
<div style="display:flex;gap:24px;margin-top:20px;width:100%;box-sizing:border-box;">
    <div class="guide-ai-client-card-main">
        <div style="margin-bottom:20px;">
            <h2 style="font-size:24px;font-weight:700;margin:0 0 6px 0;line-height:1.2;"><span style="color:#7c3aed;">6.</span> Connect AI Clients</h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.6;margin:0;">Choose your AI client and follow the setup guide.</p>
        </div>
        
        <!-- How It Works Banner -->
        <div class="guide-how-it-works-box">
            <div style="display:flex;align-items:center;gap:20px;">
                <!-- Left Side: Title and Description -->
                <div style="display:flex;align-items:center;gap:16px;flex:1;">
                    <div class="guide-step-visual" style="width:48px;height:48px;min-width:48px;position:relative;">
                        <i class="fas fa-book-open" style="color:#7c3aed;font-size:22px;"></i>
                    </div>
                    <div>
                        <h3 style="font-size:16px;font-weight:700;color:#7c3aed;margin:0 0 4px 0;">How it works</h3>
                        <p style="font-size:13px;color:#6b7280;margin:0;line-height:1.5;">Click on any AI client below to open a step-by-step setup guide.</p>
                    </div>
                </div>
                
                <!-- Right Side: Steps -->
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;flex:1;">
                    <!-- Row 1: Circle Icons + Arrows -->
                    <div style="display:flex;align-items:center;justify-content:center;">
                        <!-- Step 1 -->
                        <div style="width:80px;display:flex;flex-direction:column;align-items:center;">
                            <div class="guide-step-visual" style="width:56px;height:56px;position:relative;">
                                <div class="step-num-badge"><span>1</span></div>
                                <div class="outer-circle" style="width:48px;height:48px;">
                                    <i class="fas fa-hand-pointer" style="color:#7c3aed;font-size:20px;"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Arrow 1 -->
                        <div style="width:50px;display:flex;align-items:center;justify-content:center;height:48px;">
                            <span class="guide-arrow">---></span>
                        </div>
                        <!-- Step 2 -->
                        <div style="width:80px;display:flex;flex-direction:column;align-items:center;">
                            <div class="guide-step-visual" style="width:56px;height:56px;position:relative;">
                                <div class="step-num-badge"><span>2</span></div>
                                <div class="outer-circle" style="width:48px;height:48px;">
                                    <i class="fas fa-file-alt" style="color:#7c3aed;font-size:20px;"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Arrow 2 -->
                        <div style="width:50px;display:flex;align-items:center;justify-content:center;height:48px;">
                            <span class="guide-arrow">---></span>
                        </div>
                        <!-- Step 3 -->
                        <div style="width:80px;display:flex;flex-direction:column;align-items:center;">
                            <div class="guide-step-visual" style="width:56px;height:56px;position:relative;">
                                <div class="step-num-badge"><span>3</span></div>
                                <div class="outer-circle" style="width:48px;height:48px;">
                                    <i class="fas fa-list-ul" style="color:#7c3aed;font-size:20px;"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Arrow 3 -->
                        <div style="width:50px;display:flex;align-items:center;justify-content:center;height:48px;">
                            <span class="guide-arrow">---></span>
                        </div>
                        <!-- Step 4 -->
                        <div style="width:80px;display:flex;flex-direction:column;align-items:center;">
                            <div class="guide-step-visual" style="width:56px;height:56px;position:relative;">
                                <div class="step-num-badge"><span>4</span></div>
                                <div class="outer-circle" style="width:48px;height:48px;">
                                    <i class="fas fa-check" style="color:#7c3aed;font-size:20px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Row 2: Labels -->
                    <div style="display:flex;align-items:flex-start;justify-content:center;margin-top:12px;">
                        <div style="width:80px;text-align:center;">
                            <span class="guide-step-label">Select AI Client</span>
                        </div>
                        <div style="width:50px;"></div>
                        <div style="width:80px;text-align:center;">
                            <span class="guide-step-label">Open Setup Guide</span>
                        </div>
                        <div style="width:50px;"></div>
                        <div style="width:80px;text-align:center;">
                            <span class="guide-step-label">Follow Steps</span>
                        </div>
                        <div style="width:50px;"></div>
                        <div style="width:80px;text-align:center;">
                            <span class="guide-step-label">Connect & Start</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Description -->
        <div class="guide-star-desc">
            <i class="fas fa-star"></i>
            <p>Click any AI client to view setup steps in a <span>guided walkthrough</span>.</p>
        </div>
        
        <!-- ChatGPT -->
        <div @click="openModal('chatgpt')" onclick="console.log('ChatGPT clicked')" class="guide-client-card">
            <div style="display:flex;align-items:center;gap:14px;">
                <div class="logo-wrap">
                    <img src="/images/clients/chatgpt-dark.png" alt="ChatGPT" class="icon-dark" style="width:32px;height:32px;object-fit:contain;">
                    <img src="/images/clients/chatgpt-light.png" alt="ChatGPT" class="icon-light" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div>
                    <div class="name">ChatGPT</div>
                    <div class="desc">Click to open step-by-step setup guide</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="time-badge">2 min</span>
                <i class="fas fa-chevron-right arrow"></i>
            </div>
        </div>
        
        <!-- Claude -->
        <div @click="openModal('claude')" class="guide-client-card">
            <div style="display:flex;align-items:center;gap:14px;">
                <div class="logo-wrap">
                    <img src="/images/clients/claude.png" alt="Claude" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div>
                    <div class="name">Claude</div>
                    <div class="desc">Click to open step-by-step setup guide</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="time-badge">2 min</span>
                <i class="fas fa-chevron-right arrow"></i>
            </div>
        </div>
        
        <!-- Cursor -->
        <div @click="openModal('cursor')" class="guide-client-card">
            <div style="display:flex;align-items:center;gap:14px;">
                <div class="logo-wrap">
                    <img src="/images/clients/cursor-dark.png" alt="Cursor" class="icon-dark" style="width:32px;height:32px;object-fit:contain;">
                    <img src="/images/clients/cursor-light.png" alt="Cursor" class="icon-light" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div>
                    <div class="name">Cursor</div>
                    <div class="desc">Click to open step-by-step setup guide</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="time-badge">3 min</span>
                <i class="fas fa-chevron-right arrow"></i>
            </div>
        </div>
        
        <!-- VS Code -->
        <div @click="openModal('vscode')" class="guide-client-card">
            <div style="display:flex;align-items:center;gap:14px;">
                <div class="logo-wrap">
                    <img src="/images/clients/vscode.png" alt="VS Code" style="width:32px;height:32px;object-fit:contain;">
                </div>
                <div>
                    <div class="name">VS Code</div>
                    <div class="desc">Click to open step-by-step setup guide</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="time-badge">3 min</span>
                <i class="fas fa-chevron-right arrow"></i>
            </div>
        </div>
        
        <!-- Info Banner -->
        <div class="guide-info-box" style="margin-top:4px;padding:14px;">
            <div style="display:flex;align-items:center;gap:16px;">
                <div style="width:44px;height:44px;min-width:44px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-lightbulb" style="color:#7c3aed;font-size:20px;"></i>
                </div>
                <p class="guide-info-desc" style="font-size:14px;color:#374151;margin:0;line-height:1.6;">
                    Choose your preferred AI client and follow the guided setup steps to connect ServerAvatar MCP in just a few minutes.
                </p>
            </div>
        </div>
        
    </div>

</div>

<!-- Cards 7 & 8 Row: Example Commands + Security Best Practices -->
<div style="display:flex;gap:24px;margin-top:20px;width:100%;box-sizing:border-box;">

    <!-- Card 7: Example Commands -->
    <div class="guide-example-card">
        <div style="margin-bottom:20px;">
            <h2><span>7.</span> Example Commands</h2>
            <p>Use natural language to manage your infrastructure.</p>
        </div>
        
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;">
            <div class="guide-command-item" onclick="copyCommand('List all organizations', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fas fa-building"></i></div>
                    <span class="cmd-text">List all organizations</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
            <div class="guide-command-item" onclick="copyCommand('Create a WordPress application', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fab fa-wordpress"></i></div>
                    <span class="cmd-text">Create a WordPress application</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
            <div class="guide-command-item" onclick="copyCommand('List all servers', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fas fa-server"></i></div>
                    <span class="cmd-text">List all servers</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
            <div class="guide-command-item" onclick="copyCommand('Restart Nginx', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fas fa-sync"></i></div>
                    <span class="cmd-text">Restart Nginx</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
            <div class="guide-command-item" onclick="copyCommand('Install SSL certificate', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fas fa-lock"></i></div>
                    <span class="cmd-text">Install SSL certificate</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
            <div class="guide-command-item" onclick="copyCommand('Create a database', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fas fa-database"></i></div>
                    <span class="cmd-text">Create a database</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
            <div class="guide-command-item" onclick="copyCommand('Show server usage', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fas fa-chart-line"></i></div>
                    <span class="cmd-text">Show server usage</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
            <div class="guide-command-item" onclick="copyCommand('List WordPress plugins', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fas fa-plug"></i></div>
                    <span class="cmd-text">List WordPress plugins</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
            <div class="guide-command-item" onclick="copyCommand('Restart PHP', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fas fa-sync"></i></div>
                    <span class="cmd-text">Restart PHP</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
            <div class="guide-command-item" onclick="copyCommand('Create a new firewall rule', this)">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="cmd-icon"><i class="fas fa-shield-alt"></i></div>
                    <span class="cmd-text">Create a new firewall rule</span>
                </div>
                <i class="fas fa-copy cmd-copy"></i>
            </div>
        </div>
        
        <div style="margin-top:20px;text-align:center;">
            <a href="{{ url('/tools') }}" class="card-link">Explore More Examples <i class="fas fa-arrow-right" style="font-size:12px;"></i></a>
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
    <div class="guide-security-card">
        <div style="margin-bottom:20px;">
            <h2><span>8.</span> Security Best Practices</h2>
            <p>Keep your API keys and tokens secure.</p>
        </div>
        
        <div style="display:flex;flex-direction:column;gap:10px;">
            <div class="guide-security-item">
                <div class="sec-icon"><i class="fas fa-key"></i></div>
                <span class="sec-text">Never share your API Key or IDE Access Tokens</span>
            </div>
            <div class="guide-security-item">
                <div class="sec-icon"><i class="fas fa-lock"></i></div>
                <span class="sec-text">Store tokens securely and never in public repositories</span>
            </div>
            <div class="guide-security-item">
                <div class="sec-icon"><i class="fas fa-trash-alt"></i></div>
                <span class="sec-text">Revoke unused tokens immediately</span>
            </div>
            <div class="guide-security-item">
                <div class="sec-icon"><i class="fas fa-id-card"></i></div>
                <span class="sec-text">Generate separate tokens for different devices</span>
            </div>
            <div class="guide-security-item">
                <div class="sec-icon"><i class="fas fa-sync"></i></div>
                <span class="sec-text">Review active tokens regularly</span>
            </div>
        </div>
        
        <div class="guide-warning-box">
            <i class="fas fa-shield-alt"></i>
            <p>Your tokens provide access to your ServerAvatar account. Keep them secure at all times.</p>
        </div>
    </div>

</div>

<!-- Cards 9 & 10 Row: Troubleshooting + Quick Setup Summary -->
<div style="display:flex;gap:24px;margin-top:20px;width:100%;box-sizing:border-box;">

    <!-- Card 9: Troubleshooting (Accordion) -->
    <div class="guide-troubleshoot-card">
        <div style="margin-bottom:20px;">
            <h2><span>9.</span> Troubleshooting</h2>
            <p>Common issues and their solutions.</p>
        </div>
        
        <div x-data="{ open: -1 }" style="display:flex;flex-direction:column;gap:16px;">
            
            <!-- Item 1 -->
            <div @click="open = open === 1 ? -1 : 1" class="guide-accordion-item">
                <div class="accordion-header">
                    <div class="accordion-icon" style="background:#fef2f2;">
                        <i class="fas fa-wifi" style="color:#dc2626;font-size:14px;"></i>
                    </div>
                    <span class="accordion-title">Connection failed</span>
                    <i class="fas fa-chevron-right accordion-chevron" :style="open === 1 ? 'transform:rotate(90deg);' : 'transform:rotate(0deg);'"></i>
                </div>
                <div x-show="open === 1" x-collapse x-cloak class="accordion-content">
                    <p>Check your MCP Server URL and internet connection.</p>
                </div>
            </div>
            
            <!-- Item 2 -->
            <div @click="open = open === 2 ? -1 : 2" class="guide-accordion-item">
                <div class="accordion-header">
                    <div class="accordion-icon" style="background:#fffbeb;">
                        <i class="fas fa-key" style="color:#d97706;font-size:14px;"></i>
                    </div>
                    <span class="accordion-title">Authentication failed</span>
                    <i class="fas fa-chevron-right accordion-chevron" :style="open === 2 ? 'transform:rotate(90deg);' : 'transform:rotate(0deg);'"></i>
                </div>
                <div x-show="open === 2" x-collapse x-cloak class="accordion-content">
                    <p>Verify your API Key or IDE Access Token.</p>
                </div>
            </div>
            
            <!-- Item 3 -->
            <div @click="open = open === 3 ? -1 : 3" class="guide-accordion-item">
                <div class="accordion-header">
                    <div class="accordion-icon" style="background:#eff6ff;">
                        <i class="fas fa-wrench" style="color:#2563eb;font-size:14px;"></i>
                    </div>
                    <span class="accordion-title">No tools available</span>
                    <i class="fas fa-chevron-right accordion-chevron" :style="open === 3 ? 'transform:rotate(90deg);' : 'transform:rotate(0deg);'"></i>
                </div>
                <div x-show="open === 3" x-collapse x-cloak class="accordion-content">
                    <p>Reconnect your AI client and refresh the tools list.</p>
                </div>
            </div>
            
            <!-- Item 4 -->
            <div @click="open = open === 4 ? -1 : 4" class="guide-accordion-item">
                <div class="accordion-header">
                    <div class="accordion-icon" style="background:#f5f3ff;">
                        <i class="fas fa-link" style="color:#7c3aed;font-size:14px;"></i>
                    </div>
                    <span class="accordion-title">Invalid MCP URL</span>
                    <i class="fas fa-chevron-right accordion-chevron" :style="open === 4 ? 'transform:rotate(90deg);' : 'transform:rotate(0deg);'"></i>
                </div>
                <div x-show="open === 4" x-collapse x-cloak class="accordion-content">
                    <p>Ensure the MCP Server URL is connected and active.</p>
                </div>
            </div>
            
        </div>
        
        <div style="text-align:center;margin-top:14px;">
            <a href="https://support.serveravatar.com" target="_blank" class="guide-support-link">
                Still stuck? <span>Contact our support team</span> <i class="fas fa-external-link-alt" style="font-size:11px;"></i>
            </a>
        </div>
    </div>

    <!-- Card 10: Quick Setup Summary -->
    <div class="guide-summary-card">
        <div style="margin-bottom:20px;">
            <h2><span>10.</span> Quick Setup Summary</h2>
            <p>Get started with ServerAvatar MCP in 6 steps.</p>
        </div>
        
        <div style="display:flex;flex-direction:column;gap:10px;">
            <div class="guide-summary-step">
                <div class="step-num">1</div>
                <span class="step-text">Generate ServerAvatar API Key</span>
            </div>
            <div class="guide-summary-step">
                <div class="step-num">2</div>
                <span class="step-text">Connect Account to ServerAvatar MCP</span>
            </div>
            <div class="guide-summary-step">
                <div class="step-num">3</div>
                <span class="step-text">Copy MCP Server URL</span>
            </div>
            <div class="guide-summary-step">
                <div class="step-num">4</div>
                <span class="step-text">Generate IDE Access Token (for IDE clients)</span>
            </div>
            <div class="guide-summary-step">
                <div class="step-num">5</div>
                <span class="step-text">Connect Your AI Client</span>
            </div>
            <div class="guide-summary-step">
                <div class="step-num">6</div>
                <span class="step-text">Verify Connection</span>
            </div>
        </div>
        
        <div class="guide-success-box">
            <p>🎉 You're all set! Start managing your infrastructure with AI.</p>
        </div>
    </div>

</div>

<!-- New Card: You're All Set -->
<div style="display:flex;justify-content:center;margin-top:20px;width:100%;box-sizing:border-box;padding:0 4px;">
    <div class="guide-final-banner">
        <div style="display:flex;align-items:center;gap:20px;flex:1;min-width:280px;">
            <img src="/images/rocket-illustration.png" alt="Rocket" style="width:96px;height:96px;object-fit:contain;opacity:0;transition:opacity 0.5s ease;flex-shrink:0;" onload="this.style.opacity='1'" onerror="this.style.display='none'">
            <div class="banner-text">
                <p>You're All Set! 🎉</p>
                <p>You can now manage your servers, applications, databases, WordPress sites,</p>
                <p>SSL certificates, and more — all through natural language.</p>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:12px;align-items:center;">
            <a href="/dashboard" class="banner-btn">
                Go to Dashboard <i class="fas fa-arrow-right" style="font-size:12px;"></i>
            </a>
            <a href="/tools" class="banner-link">
                Explore Tools Library <i class="fas fa-arrow-right" style="font-size:12px;"></i>
            </a>
        </div>
    </div>
</div>
<!-- AI Client Connection Modal -->
<div x-show="modalOpen" x-cloak class="guide-modal-overlay" @click.self="closeModal()">
    <div x-show="selectedClient" class="guide-modal-content" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:900px;max-width:calc(100vw - 48px);max-height:90vh;" @click.stop>
        
        <!-- Modal Header (Fixed) -->
        <div class="guide-modal-header">
            <div style="display:flex;align-items:center;gap:16px;">
                <template x-if="selectedClient && selectedClient.imageLight">
                    <div style="display:flex;">
                        <img :src="selectedClient.image" :alt="selectedClient.name" class="icon-dark" style="width:48px;height:48px;object-fit:contain;border-radius:8px;">
                        <img :src="selectedClient.imageLight" :alt="selectedClient.name" class="icon-light" style="width:48px;height:48px;object-fit:contain;border-radius:8px;">
                    </div>
                </template>
                <template x-if="selectedClient && !selectedClient.imageLight">
                    <div class="guide-modal-logo-wrap" style="width:48px;height:48px;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <img :src="selectedClient.image" :alt="selectedClient.name" style="width:40px;height:40px;object-fit:contain;">
                    </div>
                </template>
                <div>
                    <h3 class="guide-modal-header-title" style="font-size:20px;font-weight:700;margin:0;" x-text="selectedClient ? selectedClient.name + ' Setup Guide' : ''"></h3>
                    <p class="guide-modal-header-subtitle" style="font-size:13px;margin:6px 0 0 0;" x-text="selectedClient ? 'Follow the steps below to connect ServerAvatar MCP with ' + selectedClient.name : ''"></p>
                </div>
            </div>
            <button @click="closeModal()" class="guide-modal-close-btn" style="background:none;border:none;cursor:pointer;padding:8px;font-size:20px;line-height:1;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div style="display:flex;flex:1;overflow:hidden;min-height:0;max-height:calc(90vh - 140px);">
            
            <!-- Sidebar (Fixed) -->
            <div class="guide-modal-sidebar" style="width:240px;padding:20px;flex-shrink:0;overflow-y:auto;overflow-x:hidden;">
                
                <template x-for="(step, index) in selectedClient ? selectedClient.steps : []" :key="index">
                    <div style="display:flex;align-items:center;gap:12px;padding:12px 0;">
                        <div style="display:flex;align-items:center;gap:12px;position:relative;">
                            <div class="guide-modal-step-num" style="width:28px;height:28px;min-width:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;flex-shrink:0;z-index:1;" x-text="index + 1"></div>
                            <template x-if="index < (selectedClient ? selectedClient.steps.length - 1 : 0)">
                                <div class="guide-step-dotted-line" style="position:absolute;left:13px;top:28px;width:2px;height:28px;z-index:0;"></div>
                            </template>
                        </div>
                        <div x-text="step.title" :class="index === 0 ? 'guide-modal-step-text-active' : 'guide-modal-step-text'" style="font-size:14px;font-weight:500;line-height:1.4;flex:1;"></div>
                    </div>
                </template>
                
                <div class="guide-modal-need-help" style="margin-top:60px;padding:12px;border-radius:16px;">
                    <p style="font-size:14px;font-weight:700;margin:0 0 8px 0;">Need Help?</p>
                    <p class="guide-modal-need-help-desc" style="font-size:13px;margin:0 0 8px 0;">Contact our support team</p>
                    <a href="https://support.serveravatar.com" target="_blank" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;text-decoration:none;">
                        Get Support <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>
            </div>
            
            <!-- Main Content (Scrollable) -->
            <div style="flex:1;padding:24px;overflow-y:auto;overflow-x:hidden;min-height:0;">
                
                <!-- ChatGPT Info Note -->
                <template x-if="selectedClient && selectedClient.name === 'ChatGPT'">
                    <div class="guide-modal-info-note">
                        <i class="fas fa-info-circle" style="color:#7c3aed;font-size:20px;margin-top:2px;"></i>
                        <div>
                            <p class="note-title">Important Note</p>
                            <p class="note-text">MCP connectors are available only on supported ChatGPT plans and may not be available for every account.</p>
                        </div>
                    </div>
                </template>
                
                <!-- ChatGPT Step 1 Card -->
                <template x-if="selectedClient && selectedClient.name === 'ChatGPT'">
                    <div class="guide-modal-step-card">
                        <h4>Step 1: <span>Enable Developer Mode</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Log in to your ChatGPT account</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Open Settings</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">3</div>
                                <p class="guide-modal-substep-text">Enable Developer Mode (if available for your account)</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- ChatGPT Step 2 Card -->
                <template x-if="selectedClient && selectedClient.name === 'ChatGPT'">
                    <div class="guide-modal-step-card">
                        <h4>Step 2: <span>Create a New MCP Connector</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Open Settings</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Go to Apps (or Plugins, depending on your ChatGPT version)</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">3</div>
                                <p class="guide-modal-substep-text">Click Create New</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">4</div>
                                <p class="guide-modal-substep-text">Enter a name: ServerAvatar MCP</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">5</div>
                                <p class="guide-modal-substep-text">Paste your MCP Server URL into the Connection URL field</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">6</div>
                                <p class="guide-modal-substep-text">Save the connector</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">7</div>
                                <p class="guide-modal-substep-text">Complete the authorization process if prompted</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- ChatGPT Step 3 Card -->
                <template x-if="selectedClient && selectedClient.name === 'ChatGPT'">
                    <div class="guide-modal-step-card">
                        <h4>Step 3: <span>Start Using ServerAvatar MCP</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Open a new chat/Conversion</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Select the ServerAvatar MCP connector from the top model dropdown</p>
                            </div>
                        </div>
                        <p style="font-size:14px;color:#6b7280;margin:16px 0 12px 0;">You can now use natural language commands such as:</p>
                        <div style="display:flex;flex-wrap:nowrap;gap:8px;overflow-x:auto;">
                            <button class="guide-modal-example-btn">List all my servers</button>
                            <button class="guide-modal-example-btn">Show server status</button>
                            <button class="guide-modal-example-btn">Create new database</button>
                            <button class="guide-modal-example-btn">Deploy WordPress</button>
                        </div>
                    </div>
                </template>
                
                <!-- Claude Step 1 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Claude'">
                    <div class="guide-modal-step-card">
                        <h4>Step 1: <span>Open Claude Settings</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Log into your Claude account</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Open Settings</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">3</div>
                                <p class="guide-modal-substep-text">Navigate to Connectors or Customize (depending on your Claude version)</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Claude Step 2 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Claude'">
                    <div class="guide-modal-step-card">
                        <h4>Step 2: <span>Add a Custom Connector</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Click Add Custom Connector</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Enter a connector name: ServerAvatar MCP</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">3</div>
                                <p class="guide-modal-substep-text">Paste your MCP Server URL into the connection URL field</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">4</div>
                                <p class="guide-modal-substep-text">Save the connector</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">5</div>
                                <p class="guide-modal-substep-text">Complete the authorization process if required</p>
                            </div>
                        </div>
                        <p style="font-size:13px;color:#6b7280;margin:16px 0 0 0;line-height:1.5;">After a successful connection, the ServerAvatar MCP connector will be available in Claude.</p>
                    </div>
                </template>
                
                <!-- Claude Step 3 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Claude'">
                    <div class="guide-modal-step-card">
                        <h4 class="guide-modal-step-title">Step 3: <span>Start Managing Your Servers</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Open a new Claude chat</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Select your ServerAvatar MCP connector</p>
                            </div>
                        </div>
                        <p style="font-size:14px;color:#6b7280;margin:16px 0 12px 0;">You can now ask Claude to perform ServerAvatar operations, for example:</p>
                        <div style="display:flex;flex-wrap:nowrap;gap:8px;overflow-x:auto;">
                            <button class="guide-modal-example-btn">Create an application</button>
                            <button class="guide-modal-example-btn">List servers</button>
                            <button class="guide-modal-example-btn">Manage databases</button>
                            <button class="guide-modal-example-btn">Install SSL certificates</button>
                            <button class="guide-modal-example-btn">Change application settings</button>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 1 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div class="guide-modal-step-card">
                        <h4>Step 1: <span>Install and Sign In</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Download and install Cursor IDE on your computer</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Sign in to your Cursor account</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 2 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div class="guide-modal-step-card">
                        <h4>Step 2: <span>Generate an IDE Access Token</span></h4>
                        <div class="guide-modal-note-box">
                            <p><strong>Note:</strong> An access token is required before connecting Cursor.</p>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Log in to ServerAvatar MCP</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Navigate to Endpoint & Tokens</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">3</div>
                                <p class="guide-modal-substep-text">Under IDE Access Tokens, enter a token name (e.g., Cursor Development)</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">4</div>
                                <p class="guide-modal-substep-text">Click Generate Token</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">5</div>
                                <p class="guide-modal-substep-text">Copy the generated token immediately (it won't be shown again)</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 3 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div class="guide-modal-step-card">
                        <h4>Step 3: <span>Open MCP Settings</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Open Cursor</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Navigate to Settings → Tools & MCP</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">3</div>
                                <p class="guide-modal-substep-text">Under Installed MCP Servers, click + Add New MCP Server</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">4</div>
                                <p class="guide-modal-substep-text">Cursor will open the mcp.json configuration file</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 4 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div class="guide-modal-step-card">
                        <h4>Step 4: <span>Configure ServerAvatar MCP</span></h4>
                        <p class="guide-modal-desc-text">Modify your mcp.json file with the following configuration:</p>
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
                            <div class="guide-modal-substep">
                                <div style="width:6px;height:6px;min-width:6px;background:#7c3aed;border-radius:50%;flex-shrink:0;"></div>
                                <p class="guide-modal-substep-text"><code class="guide-modal-code">YOUR_MCP_SERVER_URL</code> with the MCP Server URL from ServerAvatar MCP → Endpoint & Tokens</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div style="width:6px;height:6px;min-width:6px;background:#7c3aed;border-radius:50%;flex-shrink:0;"></div>
                                <p class="guide-modal-substep-text"><code class="guide-modal-code">YOUR_IDE_ACCESS_TOKEN</code> with the IDE Access Token you generated</p>
                            </div>
                        </div>
                        <div class="guide-modal-tip-box" style="margin-top:16px;">
                            <p><strong>Don't forget!</strong> Save the <code class="guide-modal-code">mcp.json</code> file after making the changes.</p>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 5 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div class="guide-modal-step-card">
                        <h4>Step 5: <span>Verify the Connection</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Return to Settings → Tools & MCP.</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Verify that ServerAvatar MCP appears under Installed MCP Servers.</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">3</div>
                                <p class="guide-modal-substep-text">Ensure the server status shows Connected or Available.</p>
                            </div>
                        </div>
                        <div class="guide-modal-error-box">
                            <p class="guide-modal-error-text">If the connection fails, verify your MCP Server URL and IDE Access Token, then reload Cursor.</p>
                        </div>
                    </div>
                </template>
                
                <!-- Cursor Step 6 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Cursor'">
                    <div class="guide-modal-step-card">
                        <h4>Step 6: <span>Start Using ServerAvatar MCP</span></h4>
                        <p class="guide-modal-desc-text">Open a new AI chat or Agent session in Cursor and start using natural language commands, for example:</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;">
                            <button class="guide-modal-example-btn">List my servers</button>
                            <button class="guide-modal-example-btn">Create a WordPress application</button>
                            <button class="guide-modal-example-btn">List databases</button>
                            <button class="guide-modal-example-btn">Restart Nginx</button>
                            <button class="guide-modal-example-btn">Install an SSL certificate</button>
                        </div>
                        <p class="guide-modal-desc-text" style="margin:0 0 16px 0;">Cursor will automatically invoke the appropriate ServerAvatar MCP tools when required.</p>
                        <div class="guide-modal-tip-box">
                            <p><strong>💡 Tip:</strong> If you update the mcp.json file, reload or restart Cursor to ensure the new MCP configuration is loaded.</p>
                        </div>
                    </div>
                </template>
                
                <!-- VS Code Info Note -->
                <template x-if="selectedClient && selectedClient.name === 'VS Code'">
                    <div class="guide-modal-vscode-info">
                        <div style="display:flex;align-items:flex-start;gap:12px;">
                            <div class="info-icon">i</div>
                            <p>Visual Studio Code supports connecting to ServerAvatar MCP using <strong>OAuth Authorization (Recommended)</strong> or <strong>IDE Access Tokens (Manual Configuration)</strong>.</p>
                        </div>
                    </div>
                </template>
                
                <!-- VS Code Section Title -->
                <template x-if="selectedClient && selectedClient.name === 'VS Code'">
                    <div class="guide-modal-vscode-section-title" style="margin-bottom:12px;">
                        <h4>Choose Authentication Method</h4>
                        <p>Select the method you want to use to connect to ServerAvatar MCP.</p>
                    </div>
                </template>
                
                <!-- VS Code OAuth Card -->
                <template x-if="selectedClient && selectedClient.name === 'VS Code'">
                    <div class="guide-modal-oauth-card">
                        <div onclick="toggleVsCodeCard('oauth')" style="cursor:pointer;">
                            <div class="guide-modal-oauth-header">
                                <div class="guide-modal-oauth-icon">
                                    <i class="fas fa-shield-alt" style="font-size:20px;"></i>
                                </div>
                                <div style="flex:1;">
                                    <span class="guide-modal-oauth-badge">Recommended</span>
                                    <p class="guide-modal-oauth-title">OAuth Authorization</p>
                                </div>
                                <i id="vscode-oauth-arrow" class="fas fa-chevron-down" style="color:#10b981;font-size:14px;transition:transform 0.3s;" class="guide-modal-oauth-arrow"></i>
                            </div>
                            <div style="padding:0 16px 16px 76px;">
                                <p class="guide-modal-check-item"><i class="fas fa-check-circle"></i>Secure and easy to set up</p>
                                <p class="guide-modal-check-item"><i class="fas fa-check-circle"></i>No tokens to manage</p>
                                <p class="guide-modal-check-item"><i class="fas fa-check-circle"></i>One-click browser authorization</p>
                            </div>
                        </div>
                        <div id="vscode-oauth-content" style="display:none;padding:0 16px 16px 16px;border-top:1px solid #6ee7b7;">
                            <div class="guide-modal-step-card" style="margin-top:16px;">
                                <h4>Step 1: <span>Install and Sign In</span></h4>
                                <div style="display:flex;flex-direction:column;gap:10px;">
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">1</div>
                                        <p class="guide-modal-substep-text">Install the latest version of Visual Studio Code.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">2</div>
                                        <p class="guide-modal-substep-text">Install the GitHub Copilot and GitHub Copilot Chat extensions.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">3</div>
                                        <p class="guide-modal-substep-text">Sign in with your GitHub account.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="guide-modal-step-card" style="margin-top:12px;">
                                <h4>Step 2: <span>Add Your MCP Server</span></h4>
                                <div style="display:flex;flex-direction:column;gap:10px;">
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">1</div>
                                        <p class="guide-modal-substep-text">Press <strong>Ctrl + Shift + P</strong>.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">2</div>
                                        <p class="guide-modal-substep-text">Run: <code class="guide-modal-code-inline">MCP: Add Server</code></p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">3</div>
                                        <p class="guide-modal-substep-text">Select <strong>HTTP (Remote) MCP Server</strong>.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">4</div>
                                        <p class="guide-modal-substep-text">Enter your ServerAvatar MCP Endpoint URL.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">5</div>
                                        <p class="guide-modal-substep-text">Enter a name (for example, <strong>ServerAvatar MCP</strong>).</p>
                                    </div>
                                </div>
                            </div>
                            <div class="guide-modal-step-card" style="margin-top:12px;">
                                <h4>Step 3: <span>Authorize</span></h4>
                                <div style="display:flex;flex-direction:column;gap:10px;">
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">1</div>
                                        <p class="guide-modal-substep-text">Visual Studio Code will automatically open your browser.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">2</div>
                                        <p class="guide-modal-substep-text">Sign in to your ServerAvatar MCP account if prompted.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">3</div>
                                        <p class="guide-modal-substep-text">Click <strong>Authorize</strong>.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">4</div>
                                        <p class="guide-modal-substep-text">Return to Visual Studio Code.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="guide-modal-step-card" style="margin-top:12px;">
                                <h4>Step 4: <span>Verify</span></h4>
                                <div style="display:flex;flex-direction:column;gap:10px;">
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">1</div>
                                        <p class="guide-modal-substep-text">Open <strong>Extensions → MCP Servers</strong>.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">2</div>
                                        <p class="guide-modal-substep-text">Your ServerAvatar MCP server should appear under <strong>Installed</strong>.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="guide-modal-step-card" style="margin-top:12px;">
                                <h4>Step 5: <span>Start Using</span></h4>
                                <div style="display:flex;flex-direction:column;gap:10px;">
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">1</div>
                                        <p class="guide-modal-substep-text">Open <strong>GitHub Copilot Chat</strong> in <strong>Agent mode</strong>.</p>
                                    </div>
                                    <div class="guide-modal-substep">
                                        <div class="guide-modal-substep-num">2</div>
                                        <p class="guide-modal-substep-text">Use your connected MCP server to manage your infrastructure with natural language.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- VS Code IDE Token Card -->
                <template x-if="selectedClient && selectedClient.name === 'VS Code'">
                    <div class="guide-modal-idetoken-card">
                        <div onclick="toggleVsCodeCard('token')" style="cursor:pointer;">
                            <div class="guide-modal-idetoken-header">
                                <div class="guide-modal-idetoken-icon">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div style="flex:1;">
                                    <p class="guide-modal-idetoken-title">IDE Access Token</p>
                                </div>
                                <i id="vscode-token-arrow" class="fas fa-chevron-down guide-modal-idetoken-arrow"></i>
                            </div>
                            <div class="guide-modal-idetoken-body">
                                <p class="guide-modal-idetoken-check"><i class="fas fa-check-circle"></i>Manual configuration</p>
                                <p class="guide-modal-idetoken-check"><i class="fas fa-check-circle"></i>Use your IDE Access Token</p>
                                <p class="guide-modal-idetoken-check"><i class="fas fa-check-circle"></i>Works with any MCP client</p>
                            </div>
                        </div>
                        <div id="vscode-token-content" class="guide-modal-idetoken-content" style="display:none;">
                            <div style="padding-top:16px;">
                                <div class="guide-modal-step-card">
                                    <h4>Step 1: <span>Generate an IDE Access Token</span></h4>
                                    <div style="display:flex;flex-direction:column;gap:10px;">
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">1</div>
                                            <p class="guide-modal-substep-text">Log in to ServerAvatar MCP.</p>
                                        </div>
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">2</div>
                                            <p class="guide-modal-substep-text">Open Endpoint & Tokens.</p>
                                        </div>
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">3</div>
                                            <p class="guide-modal-substep-text">Generate an IDE Access Token.</p>
                                        </div>
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">4</div>
                                            <p class="guide-modal-substep-text">Copy the token immediately.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="guide-modal-step-card">
                                    <h4>Step 2: <span>Open MCP Configuration</span></h4>
                                    <div style="display:flex;flex-direction:column;gap:10px;">
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">1</div>
                                            <p class="guide-modal-substep-text">Press: <strong>Ctrl + Shift + P</strong></p>
                                        </div>
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">2</div>
                                            <p class="guide-modal-substep-text">Run: <code class="guide-modal-code-inline">MCP: Open User Configuration</code></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="guide-modal-step-card">
                                    <h4>Step 3: <span>Configure ServerAvatar MCP</span></h4>
                                    <p class="guide-modal-desc-text">Add the following configuration:</p>
                                    <div style="background:#1e1e2e;border-radius:12px;padding:16px;margin-bottom:12px;overflow-x:auto;position:relative;">
                                        <div style="position:absolute;top:12px;left:16px;font-size:12px;color:#9ca3af;"><i class="fas fa-file-code" style="margin-right:6px;"></i>mcp.json</div>
                                        <button onclick="copyCode(this)" style="position:absolute;top:12px;right:12px;background:#374151;border:none;border-radius:6px;padding:6px 10px;cursor:pointer;color:#9ca3af;font-size:12px;display:flex;align-items:center;gap:4px;">
                                            <i class="fas fa-copy"></i> Copy
                                        </button>
                                        <pre style="font-size:12px;color:#a5f3cb;margin:0;line-height:1.7;white-space:pre;padding-top:24px;">{
  "inputs": [
    {
      "type": "promptString",
      "id": "serveravatar-token",
      "description": "ServerAvatar IDE Access Token",
      "password": true
    }
  ],
  "servers": {
    "serveravatar-mcp": {
      "type": "http",
      "url": "YOUR_MCP_SERVER_URL",
      "headers": {
        "Authorization": "Bearer YOUR_IDE_ACCESS_TOKEN"
      }
    }
  }
}</pre>
                                    </div>
                                    <p style="font-size:14px;font-weight:600;color:#7c3aed;margin:0 0 12px 0;">Replace:</p>
                                    <div style="display:flex;flex-direction:column;gap:10px;">
                                        <div class="guide-modal-substep">
                                            <div style="width:6px;height:6px;min-width:6px;background:#7c3aed;border-radius:50%;flex-shrink:0;"></div>
                                            <p class="guide-modal-substep-text"><code class="guide-modal-code">YOUR_MCP_SERVER_URL</code> with your ServerAvatar MCP Endpoint.</p>
                                        </div>
                                        <div class="guide-modal-substep">
                                            <div style="width:6px;height:6px;min-width:6px;background:#7c3aed;border-radius:50%;flex-shrink:0;"></div>
                                            <p class="guide-modal-substep-text"><code class="guide-modal-code">YOUR_IDE_ACCESS_TOKEN</code> with your generated IDE Access Token.</p>
                                        </div>
                                    </div>
                                    <p class="guide-modal-bold-text"><strong>Save the file.</strong></p>
                                </div>
                                <div class="guide-modal-step-card">
                                    <h4>Step 4: <span>Reload VS Code</span></h4>
                                    <div style="display:flex;flex-direction:column;gap:10px;">
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">1</div>
                                            <p class="guide-modal-substep-text">Run: <code class="guide-modal-code-inline">Developer: Reload Window</code></p>
                                        </div>
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">2</div>
                                            <p class="guide-modal-substep-text">Or restart Visual Studio Code.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="guide-modal-step-card">
                                    <h4>Step 5: <span>Verify</span></h4>
                                    <div style="display:flex;flex-direction:column;gap:10px;">
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">1</div>
                                            <p class="guide-modal-substep-text">Open: <strong>Extensions → MCP Servers</strong></p>
                                        </div>
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">2</div>
                                            <p class="guide-modal-substep-text">Confirm that ServerAvatar MCP appears under <strong>Installed</strong>.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="guide-modal-step-card">
                                    <h4>Step 6: <span>Start Using</span></h4>
                                    <div style="display:flex;flex-direction:column;gap:10px;">
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">1</div>
                                            <p class="guide-modal-substep-text">Open <strong>GitHub Copilot Chat</strong> in <strong>Agent mode</strong>.</p>
                                        </div>
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">2</div>
                                            <p class="guide-modal-substep-text">Use: <code class="guide-modal-code-inline">@ServerAvatar MCP</code></p>
                                        </div>
                                        <div class="guide-modal-substep">
                                            <div class="guide-modal-substep-num">3</div>
                                            <p class="guide-modal-substep-text">Then ask natural language commands, for example:</p>
                                        </div>
                                    </div>
                                    <div style="display:flex;flex-wrap:nowrap;gap:8px;margin:12px 0 0 0;overflow-x:auto;">
                                        <button class="guide-modal-example-btn">List all my servers</button>
                                        <button class="guide-modal-example-btn">Create a WordPress application</button>
                                        <button class="guide-modal-example-btn">Install an SSL certificate</button>
                                        <button class="guide-modal-example-btn">Create a database</button>
                                    </div>
                                    <p class="guide-modal-substep-text">GitHub Copilot will automatically invoke the appropriate ServerAvatar MCP tools.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- VS Code Help Section -->
                <template x-if="selectedClient && selectedClient.name === 'VS Code'">
                    <div class="guide-modal-help-box" style="margin-top:16px;margin-bottom:10px;">
                        <div class="help-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div>
                            <p class="help-title">Not sure which one to choose?</p>
                            <p>We recommend using <strong>OAuth Authorization</strong> for an easier and more secure experience. <strong>IDE Access Token</strong> is great for manual configuration or testing purposes.</p>
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
                    <div class="guide-modal-step-card">
                        <h4>Step 1: <span>Install Windsurf</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Download and install Windsurf IDE</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Launch Windsurf and create an account</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Windsurf Step 2 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Windsurf'">
                    <div class="guide-modal-step-card">
                        <h4>Step 2: <span>Generate an IDE Access Token</span></h4>
                        <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:8px;padding:12px 16px;margin-bottom:12px;">
                            <p style="font-size:13px;color:#7c3aed;margin:0;line-height:1.5;"><strong>Note:</strong> An access token is required before connecting Windsurf.</p>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Log in to ServerAvatar MCP</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Navigate to Endpoint & Tokens</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">3</div>
                                <p class="guide-modal-substep-text">Generate a new IDE Access Token</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">4</div>
                                <p class="guide-modal-substep-text">Copy the token immediately</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Windsurf Step 3 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Windsurf'">
                    <div class="guide-modal-step-card">
                        <h4>Step 3: <span>Add ServerAvatar MCP to Windsurf</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Open Windsurf Settings</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Go to Extensions or MCP Settings</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">3</div>
                                <p class="guide-modal-substep-text">Add a new MCP server with your Server URL and token</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Windsurf Step 4 Card -->
                <template x-if="selectedClient && selectedClient.name === 'Windsurf'">
                    <div class="guide-modal-step-card">
                        <h4>Step 4: <span>Start Using</span></h4>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">1</div>
                                <p class="guide-modal-substep-text">Open the Windsurf AI chat</p>
                            </div>
                            <div class="guide-modal-substep">
                                <div class="guide-modal-substep-num">2</div>
                                <p class="guide-modal-substep-text">Start using natural language commands</p>
                            </div>
                        </div>
                        <p style="font-size:14px;color:#6b7280;margin:16px 0 12px 0;">Example commands:</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <button class="guide-modal-example-btn">List all my servers</button>
                            <button class="guide-modal-example-btn">Create a database</button>
                            <button class="guide-modal-example-btn">Deploy WordPress</button>
                        </div>
                    </div>
                </template>
                
                <!-- Success Message -->
                <div class="guide-modal-success-box" style="border-radius:12px;padding:16px 20px;display:flex;align-items:center;">
                    <div style="color:#22c55e;font-size:20px;"><i class="fas fa-check-circle"></i></div>
                    <p style="font-size:14px;font-weight:600;margin:0;">You're all set! Start managing your infrastructure with AI.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Closing x-data div -->
</div>

@endsection
