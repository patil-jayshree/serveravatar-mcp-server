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
    <p class="page-subtitle">Learn how to connect ServerAvatar MCP with your favorite AI clients and manage your servers using natural language.</p>
</div>

<div class="card blog-content">
    <h2>🤖 What is MCP?</h2>
    <p><strong>Model Context Protocol (MCP)</strong> is an open standard that allows AI applications to securely communicate with external tools and services.</p>
    
    <p>Instead of relying only on their built-in knowledge, AI assistants can perform real-time actions such as:</p>
    <ul>
        <li>Manage servers</li>
        <li>Access databases</li>
        <li>Read and write files</li>
        <li>Call APIs</li>
        <li>Automate infrastructure tasks</li>
    </ul>
    
    <p>Think of MCP as a bridge between your AI assistant and your ServerAvatar account.</p>

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
    <p>MCP uses a simple client-server architecture to connect AI assistants with external tools.</p>
    <div class="note-box" style="font-family: monospace; font-size: 0.9rem; line-height: 1.4;">
        <pre style="margin: 0; padding: 0; background: transparent; border: none; font-family: inherit;">┌─────────────────────────────┐
│ 🤖 AI Client │
│ ChatGPT • Claude • Cursor │
└──────────────┬──────────────┘
              │
      Secure MCP Connection
              │
              ▼
┌─────────────────────────────┐
│ ⚡ ServerAvatar MCP Server │
│ Authentication & MCP Tools │
└──────────────┬──────────────┘
              │
              ▼
┌─────────────────────────────┐
│ 🌍 Your Infrastructure │
│ Servers • Apps • Databases │
│ SSL • Firewall • WordPress │
└─────────────────────────────┘</pre>
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
@endsection
