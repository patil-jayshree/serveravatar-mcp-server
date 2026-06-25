<?php $title = 'ServerAvatar MCP'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServerAvatar MCP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

        /* Navbar */
        /* Theme Toggle */
        .theme-toggle { background: none; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 8px; cursor: pointer; color: var(--text-secondary); display: flex; align-items: center; justify-content: center; transition: all var(--transition-fast); flex-shrink: 0; }
        .theme-toggle:hover { background: var(--bg-tertiary); color: var(--text-primary); border-color: var(--border-color-hover); }
        .theme-toggle svg { width: 18px; height: 18px; }

        /* Navbar */
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; background: var(--bg-nav); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border-color); padding: 0 2rem; }
        .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 72px; gap: 2rem; }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--text-primary); }
        .nav-logo-icon { width: 40px; height: 40px; background: var(--gradient-primary); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .nav-logo-text { font-weight: 700; font-size: 1.1rem; letter-spacing: -0.02em; }
        .nav-logo-text span { color: var(--accent-primary); }
        .nav-right { display: flex; align-items: center; gap: 1rem; }
        .nav-link { color: var(--text-secondary); text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: color var(--transition-fast); }
        .nav-link:hover { color: var(--text-primary); }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; border-radius: var(--radius-md); font-weight: 600; font-size: 0.9rem; border: none; cursor: pointer; transition: all var(--transition-fast); text-decoration: none; white-space: nowrap; }
        .btn-ghost { background: transparent; color: var(--text-secondary); }
        .btn-ghost:hover { background: var(--bg-tertiary); color: var(--text-primary); }
        .btn-primary { background: var(--gradient-primary); color: white; box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3); }
        .btn-primary:hover { box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4); transform: translateY(-1px); }

        /* Hero */
        .hero { min-height: auto; display: flex; align-items: flex-start; justify-content: center; padding: 4rem 2rem 3rem; position: relative; overflow: hidden; box-sizing: border-box; }
        .hero-bg { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
        .hero-glow { position: absolute; top: -50%; right: -40%; width: 70%; height: 100%; background: radial-gradient(ellipse at center, rgba(99, 102, 241, 0.12) 0%, rgba(139, 92, 246, 0.06) 40%, transparent 70%); filter: blur(80px); }
        .hero-glow-2 { position: absolute; bottom: -30%; left: -20%; width: 50%; height: 60%; background: radial-gradient(ellipse at center, rgba(251, 191, 36, 0.06) 0%, transparent 60%); filter: blur(60px); }
        .star { position: absolute; opacity: 0.75; animation: starPulse 3s ease-in-out infinite; }
        .star svg { width: 100%; height: 100%; }
        .star-1 { top: 40%; left: 30%; width: 45px; height: 45px; animation-delay: 0s; }
        .star-2 { top: 30%; left: 25%; width: 26px; height: 26px; animation-delay: 0.7s; }
        .star-3 { top: 55%; left: 18%; width: 32px; height: 32px; animation-delay: 1.4s; }
        .star-4 { top: 75%; left: 27%; width: 22px; height: 22px; animation-delay: 2.1s; }
        .star-5 { top: 35%; right: 28%; width: 40px; height: 40px; animation-delay: 0.4s; }
        .star-6 { top: 25%; right: 22%; width: 28px; height: 28px; animation-delay: 1.1s; }
        .star-7 { top: 50%; right: 15%; width: 30px; height: 30px; animation-delay: 1.8s; }
        .star-8 { top: 68%; right: 24%; width: 24px; height: 24px; animation-delay: 2.5s; }
        .star-9 { top: 15%; left: 15%; width: 20px; height: 20px; animation-delay: 0.2s; }
        .star-10 { top: 60%; left: 35%; width: 18px; height: 18px; animation-delay: 1.3s; }
        .star-11 { top: 85%; left: 20%; width: 16px; height: 16px; animation-delay: 1.9s; }
        .star-12 { top: 15%; right: 15%; width: 20px; height: 20px; animation-delay: 0.5s; }
        .star-13 { top: 60%; right: 35%; width: 18px; height: 18px; animation-delay: 1.2s; }
        .star-14 { top: 85%; right: 20%; width: 16px; height: 16px; animation-delay: 1.8s; }
        @keyframes starPulse { 0%, 100% { opacity: 0.4; transform: scale(0.95); } 50% { opacity: 0.6; transform: scale(1); } }
        .hero-wrapper { max-width: 800px; text-align: center; position: relative; z-index: 1; padding-top: 5rem; }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; margin-bottom: 0.75rem; }
        .hero-how-link { display: inline-block; color: var(--accent-primary); font-size: 0.85rem; font-weight: 600; text-decoration: none; margin-bottom: 1rem; transition: opacity 0.2s; }
        .hero-how-link:hover { opacity: 0.8; text-decoration: underline; }
        .hero-title { font-size: 3.5rem; font-weight: 800; letter-spacing: -0.03em; line-height: 1.2; margin-bottom: 0.75rem; }
        .hero-title span { background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-subtitle { color: var(--text-secondary); font-size: 1rem; margin-bottom: 1.5rem; line-height: 1.6; max-width: 560px; margin-left: auto; margin-right: auto; }
        .hero-buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 0; }
        .hero-buttons .btn { padding: 12px 28px; font-size: 0.95rem; }
        .btn-secondary { background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border-color); box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .btn-secondary:hover { background: var(--bg-card-hover); border-color: var(--border-color-hover); }


        /* Why Section */
        .why-section { max-width: 1000px; margin: 0 auto; padding: 2.5rem 2rem; }
        .why-header { text-align: center; margin-bottom: 3rem; }
        .why-tag { display: inline-block; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem; }
        .why-title { font-size: 1.50rem; font-weight: 800; margin-bottom: 0.75rem; line-height: 1.2; }
        .why-subtitle { color: var(--text-secondary); font-size: 1rem; max-width: 600px; margin: 0 auto; }
        .why-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .why-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 1.75rem; transition: all var(--transition-fast); }
        .why-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--border-color-hover); }
        .why-card-highlight { border: 2px solid rgba(139, 92, 246, 0.3); background: linear-gradient(to bottom, rgba(139, 92, 246, 0.03), var(--bg-card)); }
        .why-card-highlight:hover { border-color: rgba(139, 92, 246, 0.5); }
        .why-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
        .why-icon span { font-size: 1.5rem; }
        .why-icon-lg { width: 560px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
        .why-icon-lg span { font-size: 1.75rem; }
        .icon-purple { background: rgba(139, 92, 246, 0.12); }
        .icon-blue { background: rgba(59, 130, 246, 0.12); }
        .icon-green { background: rgba(34, 197, 94, 0.12); }
        .icon-orange { background: rgba(249, 115, 22, 0.12); }
        .icon-pink { background: rgba(236, 72, 153, 0.12); }
        .icon-yellow { background: rgba(234, 179, 8, 0.12); }
        .icon-teal { background: rgba(20, 184, 166, 0.12); }
        .why-card-title { font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem; }
        .why-card-subtitle { color: var(--text-secondary); font-size: 0.8rem; line-height: 1.4; }

        /* Works With Section */
        .works-section { background: var(--bg-secondary); padding: 4rem 2rem; }
        .works-container { max-width: 1000px; margin: 0 auto; text-align: center; }
        .works-header { margin-bottom: 2.5rem; }
        .works-tag { display: inline-block; background: var(--accent-primary-muted); color: var(--accent-primary); padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1rem; }
        .works-title { font-size: 1.50rem; font-weight: 800; color: var(--text-primary); }
        .works-grid { display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
        .works-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 0.875rem 0.5rem; display: flex; flex-direction: column; align-items: center; gap: 0.4rem; transition: all var(--transition-fast); width: 105px; flex-shrink: 0; }
        .works-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); border-color: var(--border-color-hover); }
        .works-card-more { border-style: dashed; background: var(--bg-secondary); }
        .works-logo { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; }
        .works-logo img { width: 100%; height: 100%; object-fit: contain; }
        .icon-light { display: none !important; }
        .icon-dark { display: block !important; }
        [data-theme="light"] .icon-light { display: block !important; }
        [data-theme="light"] .icon-dark { display: none !important; }
        .works-logo-more { width: 36px; height: 36px; background: var(--accent-primary-muted); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--accent-primary); font-weight: 600; }
        .works-name { font-size: 0.7rem; font-weight: 600; color: var(--text-primary); text-align: center; }

        /* How It Works Section */
        .how-section { background: var(--bg-primary); padding: 4rem 2rem; }
        .how-container { max-width: 800px; margin: 0 auto; text-align: center; }
        .how-tag { display: inline-block; background: rgba(139, 92, 246, 0.1); color: #7c3aed; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.75rem; }
        .how-heading { font-size: 1.50rem; font-weight: 800; color: var(--text-primary); margin: 0 0 1.5rem 0; }
        .how-grid { display: flex; align-items: center; justify-content: center; gap: 0.5rem; flex-wrap: wrap; }
        .how-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 1.5rem 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; flex: 1; min-width: 180px; max-width: 220px; }
        .how-icon { width: 48px; height: 48px; background: rgba(139, 92, 246, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.5rem; }
        .how-icon svg { width: 28px; height: 28px; }
        .how-title { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .how-desc { font-size: 0.8rem; color: var(--text-secondary); margin: 0; line-height: 1.4; }
        .how-arrow { color: #7c3aed; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

        /* CTA Section */
        .cta-section { background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(139, 92, 246, 0.03) 100%); border-top: 1px solid rgba(139, 92, 246, 0.1); border-bottom: 1px solid rgba(139, 92, 246, 0.1); padding: 3rem 2rem; }
        .cta-container { max-width: 900px; margin: 0 auto; display: flex; align-items: center; gap: 1.5rem; }
        .cta-icon { width: 64px; height: 64px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 28px; }
        .cta-content { flex: 1; }
        .cta-title { font-size: 1.5rem; font-weight: 800; color: var(--text-primary); margin: 0 0 0.25rem 0; }
        .cta-desc { font-size: 0.95rem; color: var(--text-secondary); margin: 0; line-height: 1.5; }
        .cta-btn { background: #7c3aed; color: #fff; padding: 0.875rem 1.5rem; border-radius: 10px; font-size: 0.95rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.2s; flex-shrink: 0; }
        .cta-btn:hover { background: #6d28d9; transform: translateY(-1px); }

        /* Footer */
        .footer { text-align: center; padding: 1.5rem 2rem; font-size: 12px; font-weight: 400; color: #64748b; width: 100%; box-sizing: border-box; margin-top: 1rem; }
        .footer a { color: #7c3aed; }
        [data-theme="light"] .footer { color: #9ca3af; }
        .footer a { color: var(--accent-primary); text-decoration: none; font-weight: 600; }
        .footer a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            .nav-right { display: none; }
            .hero-title { font-size: 2.25rem; }
            .hero-subtitle { font-size: 1rem; }
            .features-grid { grid-template-columns: 1fr; }
            .hero-buttons { flex-direction: column; align-items: center; }
            .works-grid { flex-wrap: wrap; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <div class="nav-logo-icon">⚡</div>
                <span class="nav-logo-text">Server<span>Avatar</span> MCP</span>
            </a>
            <div class="nav-right">
                <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme">
                    <svg class="sun-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                    <svg class="moon-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>
                <a href="{{ route('login') }}" class="btn btn-ghost">LOGIN</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-bg">
            <div class="hero-glow"></div>
            <div class="hero-glow-2"></div>
            <div class="star star-1"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#purple)"/><defs><linearGradient id="purple" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#818cf8"/><stop offset="1" stop-color="#6366f1"/></linearGradient></defs></svg></div>
            <div class="star star-2"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#yellow)"/><defs><linearGradient id="yellow" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#fbbf24"/><stop offset="1" stop-color="#f59e0b"/></linearGradient></defs></svg></div>
            <div class="star star-3"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#yellow2)"/><defs><linearGradient id="yellow2" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#fcd34d"/><stop offset="1" stop-color="#fbbf24"/></linearGradient></defs></svg></div>
            <div class="star star-4"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#purple2)"/><defs><linearGradient id="purple2" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#a78bfa"/><stop offset="1" stop-color="#8b5cf6"/></linearGradient></defs></svg></div>
            <div class="star star-5"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#purple3)"/><defs><linearGradient id="purple3" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#c4b5fd"/><stop offset="1" stop-color="#a78bfa"/></linearGradient></defs></svg></div>
            <div class="star star-6"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#yellow3)"/><defs><linearGradient id="yellow3" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#fde68a"/><stop offset="1" stop-color="#fcd34d"/></linearGradient></defs></svg></div>
            <div class="star star-7"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#purple4)"/><defs><linearGradient id="purple4" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#ddd6fe"/><stop offset="1" stop-color="#c4b5fd"/></linearGradient></defs></svg></div>
            <div class="star star-8"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#yellow4)"/><defs><linearGradient id="yellow4" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#fef3c7"/><stop offset="1" stop-color="#fde68a"/></linearGradient></defs></svg></div>
            <div class="star star-9"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#purple)"/><defs><linearGradient id="purple" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#818cf8"/><stop offset="1" stop-color="#6366f1"/></linearGradient></defs></svg></div>
            <div class="star star-10"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#yellow)"/><defs><linearGradient id="yellow" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#fbbf24"/><stop offset="1" stop-color="#f59e0b"/></linearGradient></defs></svg></div>
            <div class="star star-11"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#purple2)"/><defs><linearGradient id="purple2" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#a78bfa"/><stop offset="1" stop-color="#8b5cf6"/></linearGradient></defs></svg></div>
            <div class="star star-12"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#yellow2)"/><defs><linearGradient id="yellow2" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#fcd34d"/><stop offset="1" stop-color="#fbbf24"/></linearGradient></defs></svg></div>
            <div class="star star-13"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#purple3)"/><defs><linearGradient id="purple3" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#c4b5fd"/><stop offset="1" stop-color="#a78bfa"/></linearGradient></defs></svg></div>
            <div class="star star-14"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#yellow3)"/><defs><linearGradient id="yellow3" x1="2" y1="2" x2="22" y2="22"><stop stop-color="#fde68a"/><stop offset="1" stop-color="#fcd34d"/></linearGradient></defs></svg></div>
        </div>
        <div class="hero-wrapper">
            <div class="hero-badge">✨ MCP SERVER FOR AI WORKFLOWS</div>
            <h1 class="hero-title">Connect Your AI.<br><span>Manage Your Servers.</span></h1>
            <p class="hero-subtitle">ServerAvatar MCP helps you connect AI clients to your servers and automate server management tasks with ease.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started ➜</a>
                <a href="{{ route('login') }}" class="btn btn-secondary">Log in</a>
            </div>
        </div>
    </section>

    <!-- Why ServerAvatar MCP -->
    <section class="why-section">
        <div class="why-header">
            <span class="why-tag">WHY SERVERAVATAR MCP</span>
            <h2 class="why-title">Built for production AI workflows</h2>
            <p class="why-subtitle">Everything you need to operate servers from inside your favorite AI client.</p>
        </div>
        <div class="why-grid">
            <div class="why-card why-card-highlight">
                <div class="why-icon icon-purple"><span>🔧</span></div>
                <h3 class="why-card-title">14+ server tools</h3>
                <p class="why-card-subtitle">Manage servers, sites, databases, SSL, logs, and more through MCP tools.</p>
            </div>
            <div class="why-card why-card-highlight">
                <div class="why-icon icon-purple"><span>🌐</span></div>
                <h3 class="why-card-title">Works with MCP Clients</h3>
                <p class="why-card-subtitle">Connect with ChatGPT, Claude, and other MCP-compatible clients.</p>
            </div>
            <div class="why-card why-card-highlight">
                <div class="why-icon icon-purple"><span>🔑</span></div>
                <h3 class="why-card-title">Scoped & secure</h3>
                <p class="why-card-subtitle">Securely authenticate MCP requests with your ServerAvatar API key.</p>
            </div>
            <div class="why-card why-card-highlight">
                <div class="why-icon icon-purple"><span>🔌</span></div>
                <h3 class="why-card-title">Multi-client support</h3>
                <p class="why-card-subtitle">Connect multiple AI clients simultaneously to the same server</p>
            </div>
            <div class="why-card why-card-highlight">
                <div class="why-icon icon-purple"><span>⚡</span></div>
                <h3 class="why-card-title">Lightning fast</h3>
                <p class="why-card-subtitle">Powered by MCP protocol for instant tool responses</p>
            </div>
            <div class="why-card why-card-highlight">
                <div class="why-icon icon-purple"><span>🚀</span></div>
                <h3 class="why-card-title">Developer friendly</h3>
                <p class="why-card-subtitle">Simple setup and powerful tools to supercharge your AI workflows.</p>
            </div>
        </div>
    </section>

    <!-- Works With Section -->
    <section class="works-section">
        <div class="works-container">
            <div class="works-header">
                <span class="works-tag">WORKS WITH YOUR FAVORITE AI TOOLS</span>
                <h2 class="works-title">Integrate in Minutes</h2>
            </div>
            <div class="works-grid">
                <div class="works-card">
                    <div class="works-logo"><img src="{{ asset('images/clients/chatgpt-light.png') }}" class="icon-light" alt="ChatGPT" /><img src="{{ asset('images/clients/chatgpt-dark.png') }}" class="icon-dark" alt="ChatGPT" /></div>
                    <span class="works-name">ChatGPT</span>
                </div>
                <div class="works-card">
                    <div class="works-logo"><img src="{{ asset('images/clients/claude.png') }}" alt="Claude" /></div>
                    <span class="works-name">Claude</span>
                </div>
                <div class="works-card">
                    <div class="works-logo"><img src="{{ asset('images/clients/cursor-light.png') }}" class="icon-light" alt="Cursor" /><img src="{{ asset('images/clients/cursor-dark.png') }}" class="icon-dark" alt="Cursor" /></div>
                    <span class="works-name">Cursor</span>
                </div>
                <div class="works-card">
                    <div class="works-logo"><img src="{{ asset('images/clients/vscode.png') }}" alt="VS Code" /></div>
                    <span class="works-name">VS Code</span>
                </div>
                <div class="works-card">
                    <div class="works-logo"><img src="{{ asset('images/clients/windsurf-light.png') }}" class="icon-light" alt="Windsurf" /><img src="{{ asset('images/clients/windsurf-dark.png') }}" class="icon-dark" alt="Windsurf" /></div>
                    <span class="works-name">Windsurf</span>
                </div>
                <div class="works-card">
                    <div class="works-logo"><img src="{{ asset('images/clients/zed.png') }}" alt="Zed" /></div>
                    <span class="works-name">Zed</span>
                </div>
                <div class="works-card">
                    <div class="works-logo"><img src="{{ asset('images/clients/gemini.png') }}" alt="Gemini" /></div>
                    <span class="works-name">Gemini</span>
                </div>
                <div class="works-card works-card-more">
                    <div class="works-logo works-logo-more">+</div>
                    <span class="works-name">More</span>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-section" id="how-it-works">
        <div class="how-container">
            <span class="how-tag">GET STARTED IN SIMPLE STEPS</span>
            <h2 class="how-heading">How It Works</h2>
            <div class="how-grid">
                <div class="how-card">
                    <div class="how-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M13.8 12H3" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                    <h3 class="how-title">Connect</h3>
                    <p class="how-desc">Add your MCP server to get started.</p>
                </div>
                <div class="how-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="24" height="24"><path d="M5 12h14M12 5l7 7-7 7" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                <div class="how-card">
                    <div class="how-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                    <h3 class="how-title">Integrate</h3>
                    <p class="how-desc">Connect with your favorite AI client.</p>
                </div>
                <div class="how-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="24" height="24"><path d="M5 12h14M12 5l7 7-7 7" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                <div class="how-card">
                    <div class="how-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" fill="#7c3aed"/></svg></div>
                    <h3 class="how-title">Automate</h3>
                    <p class="how-desc">Start managing your servers with AI.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-icon"><span>⚡</span></div>
            <div class="cta-content">
                <h2 class="cta-title">Ready to get started?</h2>
                <p class="cta-desc">Connect your AI tools and automate your server management workflows.</p>
            </div>
            <a href="{{ route('register') }}" class="cta-btn">
                Create Your Account <span style="margin-left: 6px;">→</span>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" style="width: 100%; padding: 1.25rem 2rem; box-sizing: border-box;">
        <p>&copy; {{ date('Y') }} ServerAvatar MCP. Built with Laravel & MCP Protocol</p>
        <p style="margin-top: 4px;">Powered by <a href="https://serveravatar.com" target="_blank">ServerAvatar</a></p>
    </footer>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcons(newTheme);
        }

        function updateThemeIcons(theme) {
            document.querySelectorAll('.sun-icon').forEach(el => {
                el.style.display = theme === 'dark' ? 'block' : 'none';
            });
            document.querySelectorAll('.moon-icon').forEach(el => {
                el.style.display = theme === 'light' ? 'block' : 'none';
            });
        }

        function initTheme() {
            const saved = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
            updateThemeIcons(saved);
        }

        initTheme();
    </script>
</body>
</html>
