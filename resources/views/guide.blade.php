<?php $title = 'MCP Guide - ServerAvatar MCP'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        (function() {
            var t = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/fontawesome.css">
    <style>
        :root {
            --bg-primary: #f8fafc; --bg-secondary: #f1f5f9; --bg-tertiary: #e2e8f0; --bg-card: #ffffff;
            --bg-card-hover: #f8fafc; --bg-input: #f1f5f9; --bg-nav: rgba(255, 255, 255, 0.95);
            --text-primary: #111827; --text-secondary: #475569; --text-muted: #94a3b8; --text-inverse: #ffffff;
            --border-color: rgba(0, 0, 0, 0.08); --border-color-hover: rgba(0, 0, 0, 0.15);
            --border-color-active: rgba(99, 102, 241, 0.5);
            --accent-primary: #7c3aed; --accent-primary-hover: #6366f1; --accent-primary-muted: rgba(79, 70, 229, 0.1);
            --accent-success: #16a34a; --accent-success-muted: rgba(22, 163, 74, 0.1);
            --accent-danger: #dc2626; --accent-danger-muted: rgba(220, 38, 38, 0.1);
            --gradient-primary: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.08); --shadow-glow: 0 0 40px rgba(79, 70, 229, 0.1);
            --radius-sm: 6px; --radius-md: 10px; --radius-lg: 16px; --radius-xl: 24px;
            --transition-fast: 150ms ease; --transition-normal: 250ms ease;
        }
        [data-theme="dark"] {
            --bg-primary: #0a0a0f; --bg-secondary: #12121a; --bg-tertiary: #1a1a25; --bg-card: #15151f;
            --bg-card-hover: #1c1c28; --bg-input: #1a1a25; --bg-nav: rgba(10, 10, 15, 0.9);
            --text-primary: #ffffff; --text-secondary: #a0a0b0; --text-muted: #6b6b7b; --text-inverse: #0a0a0f;
            --border-color: rgba(255, 255, 255, 0.08); --border-color-hover: rgba(255, 255, 255, 0.15);
            --border-color-active: rgba(99, 102, 241, 0.5);
            --accent-primary: #6366f1; --accent-primary-hover: #818cf8; --accent-primary-muted: rgba(99, 102, 241, 0.15);
            --accent-success: #22c55e; --accent-success-muted: rgba(34, 197, 94, 0.15);
            --accent-danger: #ef4444; --accent-danger-muted: rgba(239, 68, 68, 0.15);
            --gradient-primary: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.5); --shadow-glow: 0 0 40px rgba(99, 102, 241, 0.15);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; -webkit-font-smoothing: antialiased; scroll-behavior: smooth; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg-primary); color: var(--text-primary); line-height: 1.6; }
        a { color: var(--accent-primary); text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* Navbar */
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; background: var(--bg-nav); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border-color); padding: 0 2rem; }
        .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 72px; gap: 2rem; }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text-primary); }
        .nav-logo-icon { width: 40px; height: 40px; background: var(--gradient-primary); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .nav-logo-text { font-weight: 700; font-size: 1.1rem; letter-spacing: -0.02em; }
        .nav-logo-text span { color: var(--accent-primary); }
        .nav-links { display: flex; align-items: center; gap: 0.5rem; }
        .nav-link { padding: 8px 16px; border-radius: var(--radius-md); font-size: 0.9rem; font-weight: 500; color: var(--text-secondary); transition: all var(--transition-fast); }
        .nav-link:hover { color: var(--text-primary); background: var(--bg-secondary); text-decoration: none; }
        .nav-btn { padding: 10px 20px; background: var(--accent-primary); color: #fff; border-radius: var(--radius-md); font-size: 0.9rem; font-weight: 600; transition: all var(--transition-fast); }
        .nav-btn:hover { background: var(--accent-primary-hover); text-decoration: none; }
        .theme-toggle { width: 48px; height: 28px; background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 20px; cursor: pointer; position: relative; transition: all var(--transition-normal); flex-shrink: 0; }
        .theme-toggle::before { content: '🌙'; position: absolute; left: 4px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 50%; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all var(--transition-normal); }
        [data-theme="light"] .theme-toggle::before { content: '☀️'; left: calc(100% - 24px); }

        /* Main Content */
        .main { padding-top: 72px; }
        .hero { min-height: auto; display: flex; align-items: flex-start; justify-content: center; padding: 4rem 2rem 3rem; position: relative; overflow: hidden; box-sizing: border-box; }
        .hero-inner { max-width: 800px; margin: 0 auto; text-align: center; }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: var(--accent-primary-muted); border: 1px solid var(--border-color-active); border-radius: 20px; font-size: 0.85rem; font-weight: 600; color: var(--accent-primary); margin-bottom: 1.5rem; }
        .hero-title { font-size: 3rem; font-weight: 800; letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 1rem; }
        .hero-title span { background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-desc { font-size: 1.1rem; color: var(--text-secondary); max-width: 600px; margin: 0 auto 2rem; line-height: 1.7; }

        /* Guide Content */
        .guide-content { max-width: 800px; margin: 0 auto; padding: 2rem 2rem 4rem; }
        .guide-content h2 { font-size: 1.75rem; font-weight: 700; margin: 2.5rem 0 1rem; color: var(--text-primary); }
        .guide-content h3 { font-size: 1.25rem; font-weight: 600; margin: 1.5rem 0 0.75rem; color: var(--accent-primary); }
        .guide-content p { color: var(--text-secondary); margin-bottom: 1rem; line-height: 1.7; }
        .guide-content ul, .guide-content ol { color: var(--text-secondary); margin: 0.5rem 0 1rem 1.5rem; }
        .guide-content li { margin-bottom: 0.5rem; line-height: 1.6; }
        .guide-content pre { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; overflow-x: auto; font-size: 0.875rem; margin: 1rem 0; }
        .guide-content code { font-family: 'SF Mono', Monaco, monospace; }
        .step-box { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; margin: 1rem 0; }
        .step-number { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: var(--accent-primary); color: white; border-radius: 50%; font-size: 0.875rem; font-weight: 600; margin-right: 0.75rem; }
        .client-card { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem; margin: 1.5rem 0; }
        .client-card h4 { margin: 0 0 0.5rem 0; color: var(--accent-primary); font-size: 1.1rem; }
        .client-card p { margin: 0 0 1rem 0; }
        .note-box { background: var(--accent-primary-muted); border-left: 4px solid var(--accent-primary); padding: 1rem; border-radius: 0 var(--radius-md) var(--radius-md) 0; margin: 1rem 0; }
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin: 1rem 0; }
        .feature-item { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; text-align: center; }
        .feature-item i { font-size: 1.5rem; color: var(--accent-primary); margin-bottom: 0.5rem; }
        .feature-item p { margin: 0; font-weight: 600; font-size: 0.9rem; }
        .feature-item small { color: var(--text-muted); font-size: 0.8rem; }
        table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        th, td { padding: 0.75rem; text-align: left; border: 1px solid var(--border-color); }
        th { background: var(--bg-tertiary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; }
        td { font-size: 0.9rem; }

        /* Footer */
        .footer { width: 100%; padding: 1.5rem 2rem; border-top: 1px solid var(--border-color); text-align: center; }
        .footer p { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.25rem; }
        .footer a { color: var(--accent-primary); }

        /* CTA Section */
        .cta-section { background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(139, 92, 246, 0.03) 100%); border-top: 1px solid rgba(139, 92, 246, 0.1); border-bottom: 1px solid rgba(139, 92, 246, 0.1); padding: 3rem 2rem; }
        .cta-container { max-width: 900px; margin: 0 auto; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; justify-content: center; }
        .cta-content { flex: 1; min-width: 280px; text-align: center; }
        .cta-title { font-size: 1.5rem; font-weight: 800; color: var(--text-primary); margin: 0 0 0.5rem 0; }
        .cta-desc { font-size: 0.95rem; color: var(--text-secondary); margin: 0; line-height: 1.5; }
        .cta-btn { padding: 12px 24px; background: var(--accent-primary); color: #fff; border-radius: var(--radius-md); font-size: 0.95rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .cta-btn:hover { background: var(--accent-primary-hover); transform: translateY(-1px); text-decoration: none; }

        hr { border: none; border-top: 1px solid var(--border-color); margin: 2rem 0; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <div class="nav-logo-icon">⚡</div>
                <div class="nav-logo-text">Server<span>Avatar</span> MCP</div>
            </a>
            <div class="nav-links">
                <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme"></button>
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-btn">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main">
        <!-- Hero -->
        <section class="hero">
            <div class="hero-inner">
                <div class="hero-badge">📚 Complete Guide</div>
                <h1 class="hero-title">Getting Started with <span>MCP</span></h1>
                <p class="hero-desc">A complete guide to understanding Model Context Protocol and how to connect it with your favorite AI clients.</p>
            </div>
        </section>

        <!-- Guide Content -->
        <div class="guide-content">
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
                    <p>Universal Connection</p>
                    <small>One protocol, many integrations</small>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shield-halved"></i>
                    <p>Secure</p>
                    <small>Authentication built-in</small>
                </div>
                <div class="feature-item">
                    <i class="fas fa-bolt"></i>
                    <p>Real-time Data</p>
                    <small>Live information access</small>
                </div>
                <div class="feature-item">
                    <i class="fas fa-wrench"></i>
                    <p>Tool Access</p>
                    <small>Extensive capabilities</small>
                </div>
            </div>

            <h2>🔌 How MCP Works</h2>
            <p>MCP follows a simple client-server architecture:</p>
            <div class="note-box">
                <p><strong>AI Client (Your Computer)</strong></p>
                <p style="text-align: center; margin: 0.5rem 0;">↓ ↓ ↓</p>
                <p><strong>MCP Server (like ServerAvatar)</strong></p>
                <p style="text-align: center; margin: 0.5rem 0;">↓</p>
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

            <hr>

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

            <h2>🔑 Step 1: Get Your ServerAvatar API Access Key</h2>
            <p>Before connecting to AI clients, you need to get your ServerAvatar API access key. This key authenticates your account with the MCP server.</p>
            
            <div class="step-box">
                <p><span class="step-number">1</span>Log in to your ServerAvatar account</p>
                <p><span class="step-number">2</span>Go to <strong>Account → API</strong> in the sidebar</p>
                <p><span class="step-number">3</span>Click on <strong>Create API Key</strong> or use your existing key</p>
                <p><span class="step-number">4</span>Copy the API key - you'll use this to connect AI clients</p>
            </div>

            <div class="note-box">
                <p><strong>⚠️ Important:</strong> Your API key is like a password. Never share it publicly or commit it to version control.</p>
            </div>

            <h2>📡 Step 2: Your MCP Server Details</h2>
            <p>You'll need these two things to connect AI clients:</p>
            
            <div class="step-box">
                <p><strong>MCP Server URL:</strong></p>
                <pre><code>https://mcp.178.105.137.4.nip.io/mcp/serveravatar</code></pre>
                
                <p style="margin-top: 1rem;"><strong>Authentication:</strong> API Key (from Step 1)</p>
            </div>

            <h3>Where to Find Your MCP Server Info</h3>
            <div class="step-box">
                <p><span class="step-number">1</span>Go to <strong>Dashboard → MCP Server</strong> page</p>
                <p><span class="step-number">2</span>Copy the <strong>MCP Server URL</strong></p>
                <p><span class="step-number">3</span>Use your <strong>API Key</strong> (from Account → API) as the authentication token</p>
            </div>

            <h2>📊 ServerAvatar MCP Tools</h2>
            <p>ServerAvatar MCP provides <strong>55+ tools</strong> organized into categories:</p>

            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Tools</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Server</strong></td>
                        <td>19</td>
                        <td>Create, list, restart, update, tags, firewall</td>
                    </tr>
                    <tr>
                        <td><strong>Application</strong></td>
                        <td>7</td>
                        <td>Manage websites and apps</td>
                    </tr>
                    <tr>
                        <td><strong>Database</strong></td>
                        <td>2</td>
                        <td>Database user management</td>
                    </tr>
                    <tr>
                        <td><strong>Firewall</strong></td>
                        <td>4</td>
                        <td>Firewall rules configuration</td>
                    </tr>
                    <tr>
                        <td><strong>Cronjob</strong></td>
                        <td>6</td>
                        <td>Schedule management tasks</td>
                    </tr>
                    <tr>
                        <td><strong>WordPress Toolkit</strong></td>
                        <td>33</td>
                        <td>Themes, plugins, updates, security</td>
                    </tr>
                </tbody>
            </table>

            <h2>🤖 Step 3: Connect with AI Clients</h2>
            <p>Now that you have your MCP token, choose your preferred AI client below and follow the steps to connect:</p>

            <!-- ChatGPT -->
            <div class="client-card">
                <h4>🤖 ChatGPT</h4>
                <p>Connect via MCP in ChatGPT Settings to manage your servers directly from ChatGPT.</p>
                
                <h3>Step 1: Get Your MCP Token</h3>
                <div class="step-box">
                    <p>1. Log in to your ServerAvatar account</p>
                    <p>2. Go to <strong>Dashboard → MCP Server</strong></p>
                    <p>3. Copy your unique MCP authentication token</p>
                </div>

                <h3>Step 2: Add to ChatGPT</h3>
                <div class="step-box">
                    <p><span class="step-number">1</span>Open ChatGPT and click on your profile</p>
                    <p><span class="step-number">2</span>Go to <strong>Settings → Beta Features</strong></p>
                    <p><span class="step-number">3</span>Enable <strong>MCP Servers</strong></p>
                    <p><span class="step-number">4</span>Add a new MCP server with:</p>
                </div>
                <pre><code>Name: serveravatar
URL: https://mcp.178.105.137.4.nip.io/mcp/serveravatar
Auth Type: Bearer Token
Token: your-api-key-from-account-api</code></pre>
            </div>

            <!-- Claude -->
            <div class="client-card">
                <h4>🧠 Claude</h4>
                <p>Add ServerAvatar MCP to your Claude configuration file.</p>
                
                <h3>Step 1: Find Claude Config File</h3>
                <div class="step-box">
                    <p><strong>macOS:</strong> <code>~/Library/Application Support/Claude/claude_desktop_config.json</code></p>
                    <p><strong>Windows:</strong> <code>%APPDATA%\Claude\claude_desktop_config.json</code></p>
                    <p><strong>Linux:</strong> <code>~/.config/Claude/claude_desktop_config.json</code></p>
                </div>

                <h3>Step 2: Edit Config</h3>
                <pre><code>{
  "mcpServers": {
    "serveravatar": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-http",
        "https://mcp.178.105.137.4.nip.io/mcp/serveravatar",
        {
          "Authorization": "***"
        }
      ]
    }
  }
}</code></pre>

                <h3>Step 3: Restart Claude</h3>
                <p>Quit and reopen Claude Desktop for the changes to take effect.</p>
            </div>

            <!-- Cursor -->
            <div class="client-card">
                <h4>📝 Cursor</h4>
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
Headers: {"Authorization": "Bearer your-api-key"}</code></pre>
            </div>

            <!-- Windsurf -->
            <div class="client-card">
                <h4>🌊 Windsurf</h4>
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

            <!-- Cline -->
            <div class="client-card">
                <h4>⚡ Cline</h4>
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

# Create database
"Create a new database called myapp_production"

# Manage cronjobs
"List all cronjobs on my server"

# WordPress management
"Update all WordPress plugins on my site"

# Server monitoring
"What's the current server load and memory usage?"</code></pre>

            <h2>🔐 Security</h2>
            <div class="note-box">
                <p><strong>Important:</strong> Your MCP token provides access to your ServerAvatar account. Keep it secure and never share it publicly.</p>
                <ul style="margin: 0.5rem 0 0 1.25rem;">
                    <li>Each user has their own unique token</li>
                    <li>Tokens are stored securely in your user profile</li>
                    <li>You can regenerate your token anytime from the dashboard</li>
                </ul>
            </div>

            <h2>❓ Troubleshooting</h2>
            
            <h3>Connection Issues</h3>
            <ul>
                <li><strong>Token expired?</strong> Regenerate from Dashboard → MCP Server</li>
                <li><strong>Server unreachable?</strong> Check if the MCP server URL is correct</li>
                <li><strong>Auth failed?</strong> Ensure Bearer token format is correct</li>
            </ul>

            <h3>Tool Not Working</h3>
            <ul>
                <li>Verify your account has permission for the requested action</li>
                <li>Check if the server/application exists</li>
                <li>Some features require specific ServerAvatar plan</li>
            </ul>
        </div>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="cta-container">
                <div class="cta-content">
                    <h2 class="cta-title">Ready to get started?</h2>
                    <p class="cta-desc">Connect your AI tools and automate your server management workflows.</p>
                </div>
                <a href="{{ route('register') }}" class="cta-btn">
                    Create Your Account <span>→</span>
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <p>© {{ date('Y') }} ServerAvatar MCP. Built with Laravel & MCP Protocol</p>
            <p>Powered by <a href="https://serveravatar.com" target="_blank">ServerAvatar</a></p>
        </footer>
    </main>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const theme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }
    </script>
</body>
</html>
