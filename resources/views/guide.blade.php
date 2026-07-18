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
                <h1 class="hero-title">MCP Guide</h1>
                <p class="hero-desc">Learn how to connect ServerAvatar MCP with your favorite AI clients and manage your servers using natural language.</p>
            </div>
        </section>

        <!-- Guide Content -->
        <div class="guide-content">
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

            <div class="note-box">
                <p><strong>📌 Before You Connect</strong></p>
                <p><strong>💡 IDE Access Token Requirement</strong></p>
                <p>IDE Access Tokens are only required for IDE-based AI clients such as Cursor, Windsurf, VS Code, Cline, and Continue.</p>
                <p>Browser-based AI clients like ChatGPT and Claude connect using your MCP Server URL and do not require an IDE Access Token.</p>
            </div>


            <!-- ChatGPT -->
            <div class="client-card">
                <h4>🤖 ChatGPT</h4>
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

            <!-- Claude -->
            <div class="client-card">
                <h4>🧠 Claude</h4>
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

            <!-- Cursor -->
            <div class="client-card">
                <h4>📝 Cursor</h4>
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
