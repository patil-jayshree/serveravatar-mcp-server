# ServerAvatar MCP Server - Complete Documentation

**Version:** 1.0.0
**Date:** July 29, 2026
**Documentation Generated:** Automatically by OpenClaw

---

## 1. Project Overview

### What is ServerAvatar MCP Server?

ServerAvatar MCP Server is a **Model Context Protocol (MCP)** implementation that integrates with [ServerAvatar](https://serveravatar.com) - a cloud server management panel. This project enables AI clients (ChatGPT, Claude, Cursor, VS Code, Windsurf, etc.) to interact with ServerAvatar's API, allowing users to manage their servers, applications, databases, and more through natural language commands.

### Purpose

- **Bridge AI with Server Management**: Enable AI assistants to perform server management tasks
- **Unified Interface**: Control servers, databases, applications, SSL certificates, domains, and more through 115 MCP tools
- **Streamlined Workflow**: Reduce manual server management overhead

### Tech Stack

| Component | Technology |
|-----------|------------|
| Framework | Laravel 13.8 |
| PHP Version | 8.2+ |
| Database | MariaDB |
| Protocol | MCP (Model Context Protocol) |
| Authentication | Laravel Passport (OAuth) |
| Web Server | Nginx |

---

## 2. Features Summary

### 2.1 Core Features

#### 🔧 Server Management (22 Tools)
- Create, list, and delete servers
- View server usage, logs, and processes
- Manage server services (PHP-FPM, Nginx, etc.)
- Server restart scheduling
- Server tags management
- Server alerts configuration

#### 🛡️ Firewall Management (4 Tools)
- List firewall rules
- Create/delete firewall rules
- Toggle server firewall

#### ⏰ Cronjob Management (6 Tools)
- Create, list, update, and delete cronjobs
- Toggle cronjob status

#### 🗄️ Database Management (7 Tools)
- List server/organization databases
- Create/delete databases
- Manage database users

#### 🌐 Application Management (8 Tools)
- List and manage applications
- Create Node.js applications
- Deploy and manage SSR apps
- Get PM2 process details and logs

#### 👤 Application User Management (8 Tools)
- Create and manage application users
- Control SSH and root access
- Remove user SSH keys

#### 🔒 SSL Certificate Management (8 Tools)
- Install/uninstall SSL certificates
- Manage force HTTPS
- Auto-renewal support

#### 🌏 Domain Management (5 Tools)
- Create/delete domains
- Change primary domain
- Toggle domain status

#### 📦 Supervisor Management (5 Tools)
- Manage Supervisor processes
- Create/update/delete supervisor configs

#### 📝 WordPress Toolkit (35+ Tools)
- WordPress core management
- Theme management (install, update, activate, uninstall)
- Plugin management (install, update, toggle, uninstall)
- Cache management
- Cron configuration
- Debug tools
- Search & replace
- Object Cache Pro support

#### 🏢 Organization Management (3 Tools)
- Create organizations
- List and get organization details

### 2.2 Web Dashboard Features

| Page | Features |
|------|----------|
| **Dashboard** | Quick setup guide, active connections stats, server overview |
| **MCP Server** | Server information, IDE access tokens management |
| **Tools** | Browse and search all 115 MCP tools with descriptions |
| **Clients** | View connected AI clients (ChatGPT, Claude, Cursor, etc.) |
| **Activity** | Real-time request/response logs with JSON viewer |
| **Integrations** | Manage connected integrations |
| **Guide** | Step-by-step setup instructions for each AI client |
| **Profile** | Account settings, API key management, password change |

### 2.3 Authentication & Security

- **Multi-auth**: Email/password login + OAuth via Laravel Passport
- **IDE Access Tokens**: Token-based auth for IDE-based AI clients (Cursor, Windsurf, VS Code, Cline)
- **Per-user API Keys**: Each user has their own API key for ServerAvatar
- **MCP Token Validation**: Middleware validates MCP tokens on every request
- **Connection Tracking**: Track active MCP connections with 30-minute activity window

---

## 3. MCP Tools Reference

### Tool Categories Overview

| Category | Count | Description |
|----------|-------|-------------|
| Server Management | 22 | Full server lifecycle management |
| Firewall | 4 | Firewall rules management |
| Cronjob | 6 | Scheduled task management |
| Database | 7 | Database and user management |
| Application | 8 | Application deployment and management |
| Application User | 8 | User access control |
| SSL | 8 | SSL certificate management |
| WordPress | 35+ | WordPress-specific management |
| Supervisor | 5 | Process supervisor management |
| Domain | 5 | Domain management |
| Organization | 3 | Organization management |

### Sample Tool Usage

**List all servers:**
```
Tool: list_servers
Parameters: { "organization_id": "org_xxx" }
```

**Create a database:**
```
Tool: create_database
Parameters: { "server_id": "srv_xxx", "name": "my_database" }
```

**Install WordPress theme:**
```
Tool: install_wordpress_theme
Parameters: { "application_id": "app_xxx", "theme": "astra" }
```

---

## 4. AI Client Integration

### Supported AI Clients

| Client | Connection Method | Token Type |
|--------|-------------------|------------|
| **ChatGPT** | MCP Connector | IDE Access Token |
| **Claude** | Custom Connector | IDE Access Token |
| **Cursor** | MCP Settings | IDE Access Token |
| **VS Code** | MCP extension | IDE Access Token |
| **Windsurf** | MCP settings | IDE Access Token |

### Setup Flow

1. **Generate IDE Access Token** in MCP Server dashboard
2. **Configure AI Client** with:
   - MCP Server URL: `https://mcp.178.105.137.4.nip.io`
   - Auth Type: Bearer Token
   - Token: Your generated access token
3. **Start Managing** your servers through natural language

---

## 5. Production Deployment Steps

### 5.1 Server Requirements

| Resource | Minimum |
|----------|---------|
| CPU | 2 vCPU |
| RAM | 4 GB |
| Storage | 40 GB SSD |
| OS | Ubuntu 22.04 LTS |

### 5.2 Installation Steps

#### Step 1: Clone the Repository
```bash
cd /var/www/html
git clone git@github.com:patil-jayshree/serveravatar-mcp-server.git
cd serveravatar-mcp-server
```

#### Step 2: Install Dependencies
```bash
composer install
npm install
npm run build
```

#### Step 3: Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_URL=https://mcp.your-domain.com
SERVERAVATAR_API_URL=https://api.serveravatar.com
DB_HOST=127.0.0.1
DB_DATABASE=serveravatar_mcp
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

#### Step 4: Database Setup
```bash
php artisan migrate
php artisan passport:install
```

#### Step 5: Permissions
```bash
chown -R www-data:www-data /var/www/html/serveravatar-mcp-server
chmod -R 775 storage bootstrap/cache
```

#### Step 6: Nginx Configuration
```nginx
server {
    listen 80;
    server_name mcp.your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name mcp.your-domain.com;
    
    root /var/www/html/serveravatar-mcp-server/public;
    index index.php;
    
    ssl_certificate /etc/ssl/certs/your-cert.pem;
    ssl_certificate_key /etc/ssl/private/your-key.pem;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location /mcp {
        proxy_pass http://127.0.0.1:8000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }
}
```

#### Step 7: SSL Certificate (Let's Encrypt)
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d mcp.your-domain.com
```

#### Step 8: Start MCP Server
```bash
php artisan mcp:serve &
# Or use Supervisor (recommended)
```

#### Step 9: Queue Worker (for background jobs)
```bash
php artisan queue:work redis --sleep=3 --tries=3
```

### 5.3 Production Checklist

- [ ] SSL certificate installed and auto-renewal configured
- [ ] Database backups scheduled (daily)
- [ ] Application logs monitored
- [ ] Queue worker running with Supervisor
- [ ] MCP server running with Supervisor
- [ ] Firewall configured (only 80, 443 open)
- [ ] Environment variables secured (.env should not be in git)
- [ ] OAuth keys generated (`php artisan passport:keys`)
- [ ] API rate limiting configured
- [ ] Monitoring alerts set up

### 5.4 Supervisor Configuration

Create `/etc/supervisor/conf.d/serveravatar-mcp.conf`:
```ini
[program:serveravatar-mcp]
command=php /var/www/html/serveravatar-mcp-server/artisan mcp:serve
directory=/var/www/html/serveravatar-mcp-server
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/serveravatar-mcp.log
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start serveravatar-mcp:*
```

---

## 6. API Reference

### Authentication

**Bearer Token (IDE Access Token):**
```
Authorization: Bearer <your-access-token>
```

**MCP Protocol Endpoint:**
```
POST /mcp
Content-Type: application/json

{
  "jsonrpc": "2.0",
  "id": 1,
  "method": "tools/call",
  "params": {
    "name": "list_servers",
    "arguments": { "organization_id": "org_xxx" }
  }
}
```

### Response Format
```json
{
  "jsonrpc": "2.0",
  "id": 1,
  "result": {
    "content": [
      {
        "type": "text",
        "text": "{\"status\": \"success\", \"data\": [...]}"
      }
    ]
  }
}
```

---

## 7. Configuration Reference

### Environment Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_URL` | Application URL | `https://mcp.yourdomain.com` |
| `SERVERAVATAR_API_URL` | ServerAvatar API URL | `https://api.serveravatar.com` |
| `SERVERAVATAR_API_KEY` | ServerAvatar API Key | `sk_xxx` |
| `DB_HOST` | Database host | `127.0.0.1` |
| `DB_DATABASE` | Database name | `serveravatar_mcp` |
| `DB_USERNAME` | Database user | `forge` |
| `DB_PASSWORD` | Database password | `***` |

### Middleware

| Middleware | Purpose |
|------------|---------|
| `ValidateMcpToken` | Validates MCP access tokens |
| `AuthenticateToken` | User authentication for IDE tokens |

---

## 8. Support & Maintenance

### Logs Location
- Application: `/storage/logs/laravel.log`
- MCP Server: `/var/log/serveravatar-mcp.log`
- Nginx: `/var/log/nginx/access.log`, `/var/log/nginx/error.log`

### Useful Commands
```bash
# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache

# Database
php artisan migrate:fresh --seed

# Passport
php artisan passport:client --personal
php artisan passport:keys
```

---

## 9. Project Structure

```
serveravatar-mcp-server/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Web controllers
│   │   └── Middleware/        # Auth middleware
│   ├── Mcp/
│   │   ├── Traits/           # Shared API trait
│   │   └── Tools/            # 115 MCP tools
│   └── Services/             # Business logic
├── config/
│   └── mcp_tools.php         # Tool definitions
├── resources/views/          # 10 Blade views
├── routes/
│   ├── web.php              # Web routes
│   ├── api.php              # API routes
│   └── ai.php               # MCP routes
├── database/migrations/      # 20 migrations
├── storage/app/              # File storage
└── bootstrap/cache/          # Laravel cache
```

---

## 10. Quick Reference

| Item | Value |
|------|-------|
| **Repository** | `git@github.com:patil-jayshree/serveravatar-mcp-server.git` |
| **MCP Endpoint** | `https://mcp.178.105.137.4.nip.io/mcp` |
| **Tools Count** | 115 |
| **Categories** | 11 |
| **Views** | 10 |
| **Laravel** | 13.8 |
| **PHP** | 8.2+ |

---

**Document Generated:** July 29, 2026
**Project Status:** ✅ Production Ready
