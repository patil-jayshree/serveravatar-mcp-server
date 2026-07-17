@extends('layouts.app')

@section('title', 'MCP Guide - ServerAvatar MCP')
@section('breadcrumb', 'Guide')

@section('styles')
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
    background: var(--accent-primary);
    color: white;
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
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">MCP Guide</h1>
    <p class="page-subtitle">Learn how to connect ServerAvatar MCP with AI clients.</p>
</div>

<div class="card blog-content">
    <h2>🤖 What is MCP?</h2>
    <p><strong>Model Context Protocol (MCP)</strong> is a standardized way for AI applications to connect with external tools and data sources. Think of it like a universal adapter that lets AI clients like ChatGPT, Claude, or Cursor connect to almost anything – servers, databases, files, APIs, and more.</p>
    
    <p>Without MCP, AI models are limited to their training data. MCP opens up the real world to AI, allowing it to:</p>
    <ul>
        <li>Read and write files on your computer</li>
        <li>Access web APIs and external services</li>
        <li>Manage servers and databases</li>
        <li>Control applications</li>
    </ul>

    <h2>💡 Key Features of MCP</h2>
    <div class="feature-grid">
        <div class="feature-item">
            <i class="fas fa-plug"></i>
            <p><strong>Universal Connection</strong></p>
            <small>One protocol, many integrations</small>
        </div>
        <div class="feature-item">
            <i class="fas fa-shield-halved"></i>
            <p><strong>Secure</strong></p>
            <small>Authentication built-in</small>
        </div>
        <div class="feature-item">
            <i class="fas fa-bolt"></i>
            <p><strong>Real-time Data</strong></p>
            <small>Live information access</small>
        </div>
        <div class="feature-item">
            <i class="fas fa-wrench"></i>
            <p><strong>Tool Access</strong></p>
            <small>Extensive capabilities</small>
        </div>
    </div>

    <h2>🔌 How MCP Works</h2>
    <p>MCP follows a simple client-server architecture:</p>
    <div class="note-box">
        <p><strong>AI Client (Your Computer)</strong></p>
        <p style="margin: 0.5rem 0; text-align: center;">↓ ↓ ↓</p>
        <p><strong>MCP Server (like ServerAvatar)</strong></p>
        <p style="margin: 0.5rem 0; text-align: center;">↓</p>
        <p><strong>Real World (Servers, Databases, APIs)</strong></p>
    </div>
    <p>The AI client (ChatGPT, Claude, etc.) connects to an MCP server. The server exposes "tools" that the AI can use. When you ask the AI to do something, it can call these tools in real-time.</p>

    <h2>🎯 MCP Use Cases</h2>
    <ul>
        <li><strong>Server Management</strong> – Restart services, check logs, deploy apps</li>
        <li><strong>Database Operations</strong> – Query data, create tables, backup</li>
        <li><strong>File Operations</strong> – Read/write files, search code</li>
        <li><strong>API Integration</strong> – Connect third-party services</li>
        <li><strong>Automation</strong> – Chain complex tasks together</li>
    </ul>

    <hr style="border: none; border-top: 1px solid var(--border-color); margin: 2rem 0;">

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

    <h2>🤖 Step 3: Connect with AI Clients</h2>
    <p>Now that you have your MCP token, choose your preferred AI client below and follow the steps to connect:</p>

    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin: 1rem 0;">
        <a href="#chatgpt" style="padding: 0.5rem 1rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 20px; text-decoration: none; color: var(--text-primary);">🤖 ChatGPT</a>
        <a href="#claude" style="padding: 0.5rem 1rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 20px; text-decoration: none; color: var(--text-primary);">🧠 Claude</a>
        <a href="#cursor" style="padding: 0.5rem 1rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 20px; text-decoration: none; color: var(--text-primary);">📝 Cursor</a>
        <a href="#windsurf" style="padding: 0.5rem 1rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 20px; text-decoration: none; color: var(--text-primary);">🌊 Windsurf</a>
        <a href="#cline" style="padding: 0.5rem 1rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 20px; text-decoration: none; color: var(--text-primary);">⚡ Cline</a>
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
        
        <h3>Step 1: Open Cursor Settings</h3>
        <div class="step-box">
            <p><span class="step-number">1</span>Open Cursor → Settings (Cmd+,)</p>
            <p><span class="step-number">2</span>Go to <strong>MCP Servers</strong></p>
            <p><span class="step-number">3</span>Click <strong>Add New MCP Server</strong></p>
        </div>

        <h3>Step 2: Configure Server</h3>
        <pre><code>Server Name: serveravatar
Server URL: https://mcp.178.105.137.4.nip.io/mcp/serveravatar
Headers: {"Authorization": "***"}</code></pre>
    </div>

    <h2 id="windsurf">🌊 Windsurf</h2>
    
    <div class="client-card">
        <h4>Windsurf + ServerAvatar MCP</h4>
        <p>Integrate ServerAvatar with Windsurf IDE.</p>
        
        <h3>Configuration</h3>
        <pre><code>{
  "mcpServers": {
    "serveravatar": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-http", "https://mcp.178.105.137.4.nip.io/mcp/serveravatar"],
      "env": {
        "AUTHORIZATION": "***"
      }
    }
  }
}</code></pre>
    </div>

    <h2 id="cline">⚡ Cline</h2>
    
    <div class="client-card">
        <h4>Cline + ServerAvatar MCP</h4>
        <p>Use ServerAvatar tools in Cline VS Code extension.</p>
        
        <h3>Step 1: Configure MCP in Cline Settings</h3>
        <pre><code>{
  "mcpServers": {
    "serveravatar": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-http", "https://mcp.178.105.137.4.nip.io/mcp/serveravatar"],
      "env": {
        "AUTHORIZATION": "***"
      }
    }
  }
}</code></pre>
    </div>

    <h2>📋 Example Commands</h2>
    
    <p>Once connected, you can use natural language to manage your infrastructure:</p>
    
    <pre><code># List all servers
"List all my servers"

# Get server status
"Show me the status of my production server"
