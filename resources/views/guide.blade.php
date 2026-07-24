<?php $title = 'MCP Guide - ServerAvatar MCP'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
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
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/fontawesome.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        .nav-link.active { color: var(--accent-primary); background: var(--accent-primary-muted); }
        .nav-btn { padding: 10px 20px; background: var(--accent-primary); color: #fff; border-radius: var(--radius-md); font-size: 0.9rem; font-weight: 600; transition: all var(--transition-fast); }
        .nav-btn:hover { background: var(--accent-primary-hover); text-decoration: none; }
        .theme-toggle { width: 48px; height: 28px; background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 20px; cursor: pointer; position: relative; transition: all var(--transition-normal); flex-shrink: 0; }
        .theme-toggle::before { content: '🌙'; position: absolute; left: 4px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; border-radius: 50%; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all var(--transition-normal); }
        [data-theme="light"] .theme-toggle::before { content: '☀️'; left: calc(100% - 24px); }

        /* Main Content */
        .main { padding-top: 72px; min-height: 100vh; display: flex; flex-direction: column; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; width: 100%; box-sizing: border-box; }
        
        /* Guide Content */
        .guide-content { padding: 2rem 0; }

        /* Guide Banner */
        .guide-banner { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; display: flex; flex-direction: row; align-items: flex-start; justify-content: space-between; }
        .guide-banner h1 { font-size: 22px; font-weight: 700; margin: 0 0 6px 0; color: var(--text-primary); }
        .guide-banner p { font-size: 14px; color: var(--text-secondary); margin: 0; line-height: 1.5; max-width: 520px; }
        .guide-banner img { width: 280px; height: 200px; object-fit: contain; flex-shrink: 0; padding-left: 24px; }

        /* Cards Layout */
        .cards-row { display: flex; gap: 24px; margin-bottom: 20px; width: 100%; }
        .cards-row-full { display: flex; gap: 24px; margin-bottom: 20px; width: 100%; }
        .guide-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); }
        .guide-card h2 { font-size: 24px; font-weight: 700; margin: 0 0 12px 0; line-height: 1.2; color: var(--text-primary); }
        .guide-card h2 span { color: var(--accent-primary); }
        .guide-card p { font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin: 0; }
        .guide-card.flex-1-7 { flex: 1.7; }
        .guide-card.flex-1 { flex: 1; }

        /* Feature Boxes Grid */
        .feature-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 16px; }
        .guide-feature-box { background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px 16px; text-align: center; }
        .guide-feature-box .icon { color: var(--accent-primary); font-size: 24px; margin-bottom: 10px; }
        .guide-feature-box .title { font-size: 13px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px; }
        .guide-feature-box .desc { font-size: 11px; color: var(--text-secondary); line-height: 1.4; }

        /* Info Box */
        .guide-info-box { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; display: flex; align-items: flex-start; gap: 14px; }
        .guide-info-box .icon { color: var(--accent-primary); font-size: 20px; min-width: 36px; }
        .guide-info-box .text { font-size: 13px; color: var(--text-primary); line-height: 1.6; }

        /* Flow Box */
        .guide-flow-box { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 16px; }
        .guide-flow-box .icon { color: var(--accent-primary); font-size: 24px; }
        .guide-flow-box .title { font-size: 15px; font-weight: 600; color: var(--text-primary); }
        .guide-flow-box .desc { font-size: 12px; color: var(--text-secondary); }

        /* Timeline */
        .guide-timeline-step { display: flex; align-items: flex-start; gap: 14px; position: relative; }
        .guide-timeline-step .step-num { width: 32px; height: 32px; background: var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; font-weight: 700; flex-shrink: 0; position: relative; z-index: 1; }
        .guide-timeline-step .step-title { font-size: 14px; font-weight: 600; color: var(--text-primary); line-height: 32px; }
        .guide-timeline-step .step-desc { font-size: 12px; color: var(--text-secondary); line-height: 1.5; }
        

        /* Note Box */
        .guide-note-box { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 20px; display: flex; align-items: flex-start; gap: 14px; margin-bottom: 20px; }
        .guide-note-box .icon { color: var(--accent-primary); font-size: 24px; min-width: 24px; }
        .guide-note-box .text { font-size: 13px; color: var(--text-primary); line-height: 1.6; }

        /* AI Client Card Main */
        .guide-ai-client-card-main { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); flex: 1; min-width: 0; }

        /* How It Works Box */
        .guide-how-it-works-box { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .guide-step-visual { display: flex; flex-direction: column; align-items: center; }
        .guide-step-visual .step-num-badge { position: absolute; top: -9px; left: 50%; transform: translateX(-50%); width: 20px; height: 20px; background: var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .guide-step-visual .step-num-badge span { color: #fff; font-size: 11px; font-weight: 600; }
        .guide-step-visual .outer-circle { background: var(--bg-card); border: 2px solid var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .guide-step-visual .outer-circle i { color: var(--accent-primary); }
        .guide-step-dotted-line { border-left: 2px dotted #d1d5db; }
        [data-theme="dark"] .guide-step-dotted-line { border-left-color: #4b5563; }
        .timeline-dotted-line { border-left: 2px dotted #d1d5db; width: 2px; }
        [data-theme="dark"] .timeline-dotted-line { border-left-color: #4b5563; }
        .guide-timeline-connector { width: 2px; height: 16px; background: repeating-linear-gradient(to bottom, #d1d5db 0px, #d1d5db 4px, transparent 4px, transparent 8px); margin-left: 15px; }
        [data-theme="dark"] .guide-timeline-connector { background: repeating-linear-gradient(to bottom, #4b5563 0px, #4b5563 4px, transparent 4px, transparent 8px); }
        .guide-step-label { font-size: 12px; font-weight: 500; color: var(--text-primary); white-space: nowrap; display: block; }
        .guide-arrow { color: var(--accent-primary); font-size: 20px; font-weight: 300; }
        .step-num-badge { position: absolute; top: -9px; left: 50%; transform: translateX(-50%); width: 20px; height: 20px; background: var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .step-num-badge span { color: #fff; font-size: 11px; font-weight: 600; }
        .outer-circle { background: var(--bg-card); border: 2px solid var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .outer-circle i { color: var(--accent-primary); }
        .guide-step-visual { display: flex; flex-direction: column; align-items: center; }
        .guide-step-label { font-size: 12px; font-weight: 500; color: var(--text-primary); white-space: nowrap; display: block; }
        .guide-warning-box { background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 8px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px; margin-top: 16px; }
        .guide-warning-box i { color: var(--accent-primary); font-size: 18px; min-width: 18px; margin-top: 2px; }
        .guide-warning-box p { font-size: 14px; color: var(--text-primary); margin: 0; line-height: 1.5; }

        /* Client Cards */
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

        /* Tools Banner */
        .guide-tools-banner { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; }
        .guide-tools-stat { display: flex; gap: 24px; }
        .guide-tools-stat-box { display: flex; align-items: center; gap: 10px; }
        .guide-tools-stat-box .stat-icon { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; min-width: 36px; }
        .guide-tools-stat-box .stat-icon i { color: var(--accent-primary); font-size: 14px; }
        .guide-tools-stat-box .stat-num { font-size: 18px; font-weight: 700; color: var(--accent-primary); }
        .guide-tools-stat-box .stat-label { font-size: 11px; color: var(--text-secondary); }
        .guide-tools-banner-box { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; gap: 24px; margin-bottom: 20px; flex-wrap: wrap; }
        .guide-tools-banner-box .icon-wrap { background: var(--bg-card); border: 2px solid var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .guide-tools-banner-box .icon { color: var(--accent-primary); }
        .guide-tools-banner-box h3 { color: var(--accent-primary); font-size: 15px; font-weight: 700; margin: 0 0 4px 0; }
        .guide-tools-banner-box p { color: var(--text-secondary); font-size: 12px; margin: 0; line-height: 1.4; }

        /* Tools Grid */
        .tools-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .guide-tool-card-simple { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 14px; }
        .guide-tool-card-simple .icon-circle { border-radius: 50%; display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; min-width: 48px; }
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

        /* Example Cards */
        .guide-example-card, .guide-security-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); flex: 1; min-width: 0; }
        .guide-example-card h2, .guide-security-card h2 { font-size: 24px; font-weight: 700; margin: 0 0 6px 0; line-height: 1.2; color: var(--text-primary); }
        .guide-example-card h2 span, .guide-security-card h2 span { color: var(--accent-primary); }
        .guide-example-card p, .guide-security-card p { font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin: 0; }

        .guide-command-item { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 8px; cursor: pointer; transition: all 200ms; }
        .guide-command-item:hover { border-color: var(--accent-primary); background: var(--bg-card-hover); }
        .guide-command-item .cmd-icon { color: var(--accent-primary); font-size: 14px; }
        .guide-command-item .cmd-text { font-size: 13px; font-weight: 500; color: var(--text-primary); }
        .guide-command-item .cmd-copy { color: var(--text-muted); font-size: 12px; }

        .guide-security-item { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; padding: 10px 14px; display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
        .guide-security-item .sec-icon { color: var(--accent-primary); font-size: 14px; min-width: 20px; text-align: center; }
        .guide-security-item .sec-text { font-size: 13px; font-weight: 500; color: var(--text-primary); }

        /* Troubleshooting */
        .guide-troubleshoot-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); flex: 1; min-width: 0; margin-bottom: 20px; }
        .guide-troubleshoot-card h2 { font-size: 24px; font-weight: 700; margin: 0 0 6px 0; line-height: 1.2; color: var(--text-primary); }
        .guide-troubleshoot-card h2 span { color: var(--accent-primary); }
        .guide-troubleshoot-card p { font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin: 0; }

        .guide-accordion-item { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 0; cursor: pointer; transition: all 200ms; box-shadow: 0 1px 3px rgba(0,0,0,0.04); margin-bottom: 8px; }
        .guide-accordion-item:hover { background: var(--bg-card-hover); border-color: var(--accent-primary); }
        .guide-accordion-item .accordion-header { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 12px 16px; box-sizing: border-box; }
        .guide-accordion-item .accordion-icon { width: 34px; height: 34px; min-width: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: #f5f3ff; }
        .guide-accordion-item .accordion-icon i { color: var(--accent-primary); font-size: 14px; }
        .guide-accordion-item .accordion-title { font-size: 15px; font-weight: 600; color: var(--text-primary); flex: 1; margin-left: 14px; }
        .guide-accordion-item .accordion-chevron { color: var(--text-muted); font-size: 18px; margin-left: auto; transition: transform 200ms; }
        .guide-accordion-item .accordion-content { background: var(--bg-card); border-top: 1px solid var(--border-color); }
        .guide-accordion-item .accordion-content p { font-size: 13px; color: var(--text-secondary); line-height: 1.7; margin: 0; padding: 8px 14px; }
        [x-cloak] { display: none !important; }

        /* Summary */
        .guide-summary-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .guide-summary-card h2 { font-size: 24px; font-weight: 700; margin: 0 0 6px 0; line-height: 1.2; color: var(--text-primary); }
        .guide-summary-card h2 span { color: var(--accent-primary); }
        .guide-summary-card p { font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin: 0; }

        .guide-summary-step { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
        .guide-summary-step .step-num { width: 28px; height: 28px; min-width: 28px; background: #f5f3ff; color: var(--accent-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .guide-summary-step .step-text { font-size: 13px; font-weight: 500; color: var(--text-primary); }

        .guide-success-box { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 10px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px; margin-top: 16px; text-align: center; justify-content: center; }
        .guide-success-box p { font-size: 14px; color: #7c3aed; margin: 0; font-weight: 500; }
        [data-theme="dark"] .guide-success-box { background: rgba(124, 58, 237, 0.15); border: 1px solid rgba(124, 58, 237, 0.3); }
        [data-theme="dark"] .guide-success-box p { color: #a78bfa; }

        .guide-support-link { font-size: 14px; font-weight: 500; color: var(--text-secondary); text-decoration: none; transition: color 200ms; }
        .guide-support-link:hover { color: var(--accent-primary); }
        .guide-support-link span { font-weight: 600; color: var(--accent-primary); }

        /* Final Banner */
        .guide-final-banner { width: 100%; padding: 28px 32px; background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border: 1px solid #ddd6fe; border-radius: 16px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; box-sizing: border-box; margin-bottom: 20px; }
        [data-theme="dark"] .guide-final-banner { background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0.1) 100%); border-color: rgba(99, 102, 241, 0.3); }
        .guide-final-banner .banner-text p { font-size: 18px; font-weight: 700; color: var(--accent-primary); margin: 0 0 6px 0; }
        .guide-final-banner .banner-text p + p { font-size: 13px; color: var(--accent-primary); margin: 0 0 4px 0; line-height: 1.6; }
        .guide-final-banner .banner-text p:last-child { margin: 0; }
        .guide-final-banner .banner-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 32px; background: var(--accent-primary); color: #fff; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 200ms; white-space: nowrap; min-width: 180px; }
        .guide-final-banner .banner-btn:hover { background: var(--accent-primary-hover); text-decoration: none; }
        .guide-final-banner .banner-link { display: inline-flex; align-items: center; gap: 6px; font-size: 14px; font-weight: 600; color: var(--accent-primary); text-decoration: none; transition: color 200ms; }
        .guide-final-banner .banner-link:hover { color: var(--accent-primary-hover); text-decoration: none; }

        /* Footer */
        .footer { width: 100%; padding: 2rem; border-top: 1px solid var(--border-color); text-align: center; margin-top: auto; }
        .footer p { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.25rem; }
        .footer a { color: var(--accent-primary); }

        /* Modal Styles */
        .guide-modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999; background: rgba(0,0,0,0.5); display: none; }
        .guide-modal-overlay.show { display: flex; align-items: center; justify-content: center; }
        .guide-modal-content { background: var(--bg-card); border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); width: 95%; max-width: 900px; max-height: 90vh; display: flex; flex-direction: column; overflow: hidden; }
        .guide-modal-header { background: var(--bg-card); border-bottom: 1px solid var(--border-color); padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .guide-modal-logo-wrap { width: 44px; height: 44px; min-width: 44px; background: var(--bg-secondary); border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .guide-modal-logo-wrap img { width: 32px; height: 32px; object-fit: contain; }
        .guide-modal-header-titles h3 { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0 0 2px 0; }
        .guide-modal-header-titles p { font-size: 13px; color: var(--text-secondary); margin: 0; }
        .guide-modal-close-btn { width: 36px; height: 36px; border-radius: 10px; background: var(--bg-secondary); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-primary); font-size: 18px; transition: all 200ms; }
        .guide-modal-close-btn:hover { background: var(--accent-primary); color: #fff; }
        .guide-modal-body { display: flex; flex: 1; overflow: hidden; }
        .guide-modal-sidebar { width: 220px; background: var(--bg-secondary); border-right: 1px solid var(--border-color); padding: 16px; overflow-y: auto; flex-shrink: 0; }
        .guide-modal-sidebar::-webkit-scrollbar { width: 0; height: 0; }
        .guide-modal-sidebar { -ms-overflow-style: none; scrollbar-width: none; }
        .guide-modal-sidebar-step { display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 10px; cursor: pointer; margin-bottom: 4px; transition: all 200ms; }
        .guide-modal-sidebar-step:hover { background: var(--bg-card); }
        .guide-modal-sidebar-step.active { background: var(--bg-card); }
        .guide-modal-step-num { width: 26px; height: 26px; min-width: 26px; background: var(--accent-primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .guide-modal-step-text { font-size: 13px; color: var(--text-secondary); font-weight: 500; }
        .guide-modal-step-text-active { font-size: 13px; color: var(--accent-primary); font-weight: 600; }
        .guide-modal-main { flex: 1; padding: 24px; overflow-y: auto; }
        .guide-modal-need-help { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 16px; margin-top: 20px; }
        .guide-modal-need-help p { font-size: 13px; color: var(--accent-primary); margin: 0 0 6px 0; line-height: 1.5; }
        .guide-modal-need-help a { color: var(--accent-primary); font-weight: 600; }

        /* Modal Step Cards */
        .guide-modal-step-card { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-bottom: 14px; }
        .guide-modal-step-card h4 { font-size: 16px; font-weight: 700; color: var(--accent-primary); margin: 0 0 14px 0; }
        .guide-modal-step-card h4 span { color: var(--text-primary); }
        .guide-modal-substep { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px; }
        .guide-modal-substep:last-child { margin-bottom: 0; }
        .guide-modal-substep-num { width: 24px; height: 24px; min-width: 24px; background: var(--accent-primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0; margin-top: 2px; }
        .guide-modal-substep-text { font-size: 14px; color: var(--text-primary); margin: 0; line-height: 1.5; flex: 1; }
        .guide-modal-info-note { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px; margin-bottom: 14px; }
        .guide-modal-info-note .icon { color: var(--accent-primary); font-size: 18px; min-width: 18px; margin-top: 2px; }
        .guide-modal-info-note p { font-size: 13px; color: var(--text-primary); margin: 0; line-height: 1.5; }
        .guide-modal-note-box { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 8px; padding: 12px 16px; margin-bottom: 12px; }
        .guide-modal-note-box p { font-size: 13px; color: var(--accent-primary); margin: 0; line-height: 1.5; }
        .guide-modal-example-btn { background: var(--accent-primary-muted); border: 1px solid var(--accent-primary); border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 500; color: var(--accent-primary); cursor: pointer; white-space: nowrap; display: inline-block; margin-right: 8px; margin-bottom: 8px; }
        .guide-modal-desc-text { font-size: 14px; color: var(--text-secondary); margin: 0 0 14px 0; line-height: 1.5; }
        .guide-modal-code { background: var(--bg-tertiary); padding: 2px 8px; border-radius: 6px; font-size: 12px; color: var(--accent-primary); font-weight: 500; font-family: monospace; }
        .guide-modal-code-block { background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 10px; padding: 16px; position: relative; margin-top: 12px; }
        .guide-modal-code-block .code-title { position: absolute; top: 8px; left: 12px; font-size: 11px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; }
        .guide-modal-code-block pre { margin: 0; font-size: 13px; color: var(--text-primary); white-space: pre-wrap; word-break: break-all; font-family: monospace; margin-top: 20px; }
        .guide-modal-tip-box { background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 8px; padding: 12px 16px; margin-bottom: 12px; }
        .guide-modal-tip-box p { font-size: 14px; color: var(--text-primary); margin: 0; line-height: 1.5; }
        .guide-modal-error-box { background: rgba(220, 38, 38, 0.1); border: 1px solid rgba(220, 38, 38, 0.2); border-radius: 8px; padding: 12px 16px; margin-top: 14px; }
        .guide-modal-error-text { font-size: 14px; color: var(--text-primary); margin: 0; line-height: 1.5; }
        .guide-modal-success-box { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 10px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; margin-top: 16px; }
        .guide-modal-success-box p { font-size: 14px; color: var(--text-primary); margin: 0; font-weight: 500; }

        /* Icon Dark/Light */
        .icon-dark { display: none; }
        .icon-light { display: block; }
        [data-theme="dark"] .icon-dark { display: block; }
        [data-theme="dark"] .icon-light { display: none; }

        /* Responsive */
        @media (max-width: 1100px) {
            .cards-row, .cards-row-full { flex-direction: column; }
            .feature-grid { grid-template-columns: repeat(2, 1fr); }
            .tools-grid { grid-template-columns: repeat(2, 1fr); }
            .guide-tools-stat { flex-wrap: wrap; }
            .guide-final-banner { padding: 20px; }
            .guide-final-banner .banner-text { width: 100%; }
            [style*="grid-template-columns:repeat(4,1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
        }
        @media (max-width: 600px) {
            .feature-grid { grid-template-columns: 1fr; }
            .tools-grid { grid-template-columns: 1fr; }
            .guide-banner { flex-direction: column; }
            .guide-banner img { width: 100%; padding-left: 0; padding-top: 16px; }
        }
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
                <a href="{{ url('/') }}#features" class="nav-link">Feature</a>
                <a href="{{ url('/') }}#integration" class="nav-link">Integration</a>
                <a href="{{ route('guide') }}" class="nav-link active">Guide</a>
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-btn">Register</a>
                <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme"></button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <div class="guide-content">
                
                <!-- Guide Banner -->
                <div class="guide-banner" style="flex-direction:row;align-items:center;gap:60px;padding:32px;">
                    <!-- Left Side: Content -->
                    <div style="flex:1.5;min-width:0;">
                        <!-- MCP GUIDE Badge -->
                        <div style="margin-bottom:16px;">
                            <span style="display:inline-block;font-size:11px;font-weight:700;color:var(--accent-primary);letter-spacing:1px;padding:5px 14px;background:var(--accent-primary-muted);border-radius:20px;border:1px solid var(--accent-primary);">MCP GUIDE</span>
                        </div>
                        
                        <!-- Title -->
                        <div style="margin-bottom:16px;">
                            <h2 style="font-size:28px;font-weight:800;color:var(--text-primary);line-height:1.3;margin:0;">Connect ServerAvatar MCP with your favorite AI clients</h2>
                            <h2 style="font-size:28px;font-weight:800;color:var(--accent-primary);line-height:1.3;margin:0;">in minutes.</h2>
                        </div>
                        
                        <!-- Description -->
                        <div style="margin-bottom:20px;">
                            <p style="font-size:14px;color:var(--text-secondary);line-height:1.6;margin:0;">ServerAvatar MCP lets you manage your infrastructure, applications, and servers using natural language through AI assistants.</p>
                        </div>
                        
                        <!-- AI Clients List -->
                        <div style="display:flex;align-items:center;gap:20px;margin-bottom:24px;">
                            <div style="display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-check-circle" style="color:var(--accent-primary);font-size:14px;"></i>
                                <span style="font-size:13px;color:var(--text-primary);font-weight:500;">ChatGPT</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-check-circle" style="color:var(--accent-primary);font-size:14px;"></i>
                                <span style="font-size:13px;color:var(--text-primary);font-weight:500;">Claude</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-check-circle" style="color:var(--accent-primary);font-size:14px;"></i>
                                <span style="font-size:13px;color:var(--text-primary);font-weight:500;">Cursor</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-check-circle" style="color:var(--accent-primary);font-size:14px;"></i>
                                <span style="font-size:13px;color:var(--text-primary);font-weight:500;">VS Code</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <i class="fas fa-check-circle" style="color:var(--accent-primary);font-size:14px;"></i>
                                <span style="font-size:13px;color:var(--text-primary);font-weight:500;">80+ Built-in Tools</span>
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div style="display:flex;align-items:center;gap:16px;">
                            <a href="{{ url('/register') }}" style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:var(--accent-primary);color:#fff;font-size:14px;font-weight:600;border-radius:8px;text-decoration:none;transition:all 200ms;">
                                Get Started Free <i class="fas fa-arrow-right" style="font-size:12px;"></i>
                            </a>
                            <a href="#supported-clients" style="display:inline-flex;align-items:center;gap:8px;padding:12px 20px;background:transparent;color:var(--accent-primary);font-size:14px;font-weight:600;border-radius:8px;border:1px solid var(--accent-primary);text-decoration:none;transition:all 200ms;">
                                View Supported Clients <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Right Side: Illustration -->
                    <div style="flex-shrink:0;width:480px;">
                        <img src="/images/mcp-guide-illustration.png" alt="MCP Guide" style="width:100%;height:auto;object-fit:contain;" loading="lazy">
                    </div>
                </div>

                <!-- Connect in 4 Simple Steps -->
                <div style="background:rgba(139,92,246,0.08);border:1px solid rgba(139,92,246,0.2);border-radius:16px;padding:32px;margin-bottom:24px;">
                    <h2 style="text-align:center;font-size:20px;font-weight:700;color:var(--text-primary);margin-bottom:28px;">Connect in 4 Simple Steps</h2>
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;">
                        <!-- Step 1 -->
                        <div style="display:flex;align-items:flex-start;gap:16px;flex:1;">
                            <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 14px rgba(124,58,237,0.35);">
                                <i class="fas fa-mouse-pointer" style="color:#fff;font-size:16px;"></i>
                            </div>
                            <div>
                                <div style="font-size:11px;font-weight:700;color:#7c3aed;letter-spacing:0.5px;margin-bottom:6px;">STEP 1</div>
                                <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:4px;">Select AI Client</h3>
                                <p style="font-size:12px;color:var(--text-secondary);line-height:1.4;margin:0;">Choose your preferred AI client from our supported list.</p>
                            </div>
                        </div>
                        <!-- Arrow -->
                        <div style="display:flex;align-items:center;padding-top:16px;flex-shrink:0;">
                            <i class="fas fa-arrow-right" style="color:#7c3aed;font-size:18px;"></i>
                        </div>
                        <!-- Step 2 -->
                        <div style="display:flex;align-items:flex-start;gap:16px;flex:1;">
                            <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 14px rgba(124,58,237,0.35);">
                                <i class="fas fa-clipboard-list" style="color:#fff;font-size:16px;"></i>
                            </div>
                            <div>
                                <div style="font-size:11px;font-weight:700;color:#7c3aed;letter-spacing:0.5px;margin-bottom:6px;">STEP 2</div>
                                <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:4px;">Follow Setup Guide</h3>
                                <p style="font-size:12px;color:var(--text-secondary);line-height:1.4;margin:0;">Open the step-by-step guide and follow easy instructions.</p>
                            </div>
                        </div>
                        <!-- Arrow -->
                        <div style="display:flex;align-items:center;padding-top:16px;flex-shrink:0;">
                            <i class="fas fa-arrow-right" style="color:#7c3aed;font-size:18px;"></i>
                        </div>
                        <!-- Step 3 -->
                        <div style="display:flex;align-items:flex-start;gap:16px;flex:1;">
                            <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 14px rgba(124,58,237,0.35);">
                                <i class="fas fa-link" style="color:#fff;font-size:16px;"></i>
                            </div>
                            <div>
                                <div style="font-size:11px;font-weight:700;color:#7c3aed;letter-spacing:0.5px;margin-bottom:6px;">STEP 3</div>
                                <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:4px;">Authorize & Connect</h3>
                                <p style="font-size:12px;color:var(--text-secondary);line-height:1.4;margin:0;">Authorize your account and securely connect to MCP.</p>
                            </div>
                        </div>
                        <!-- Arrow -->
                        <div style="display:flex;align-items:center;padding-top:16px;flex-shrink:0;">
                            <i class="fas fa-arrow-right" style="color:#7c3aed;font-size:18px;"></i>
                        </div>
                        <!-- Step 4 -->
                        <div style="display:flex;align-items:flex-start;gap:16px;flex:1;">
                            <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 14px rgba(124,58,237,0.35);">
                                <i class="fas fa-check" style="color:#fff;font-size:16px;"></i>
                            </div>
                            <div>
                                <div style="font-size:11px;font-weight:700;color:#7c3aed;letter-spacing:0.5px;margin-bottom:6px;">STEP 4</div>
                                <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:4px;">Start Managing</h3>
                                <p style="font-size:12px;color:var(--text-secondary);line-height:1.4;margin:0;">Start managing your infrastructure with AI power.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4 Feature Cards Row -->
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:24px;">
                    <!-- Card 1: What is MCP? -->
                    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;display:flex;flex-direction:column;gap:12px;">
                        <div style="width:52px;height:52px;background:var(--accent-primary-muted);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-cube" style="color:var(--accent-primary);font-size:22px;"></i>
                        </div>
                        <h3 style="font-size:17px;font-weight:700;color:var(--text-primary);margin:0;line-height:1.3;"><span style="color:var(--accent-primary);">1.</span> What is MCP?</h3>
                        <p style="font-size:13px;color:var(--text-secondary);margin:0;line-height:1.6;flex:1;">MCP (Model Context Protocol) is an open protocol that enables AI assistants to securely connect with external systems and perform actions.</p>
                        <a href="{{ route('login') }}" style="font-size:13px;font-weight:600;color:var(--accent-primary);text-decoration:none;display:flex;align-items:center;gap:4px;">Learn more <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
                    </div>

                    <!-- Card 2: How MCP Works -->
                    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;display:flex;flex-direction:column;gap:12px;">
                        <div style="width:52px;height:52px;background:var(--accent-primary-muted);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-puzzle-piece" style="color:var(--accent-primary);font-size:22px;"></i>
                        </div>
                        <h3 style="font-size:17px;font-weight:700;color:var(--text-primary);margin:0;line-height:1.3;"><span style="color:var(--accent-primary);">2.</span> How MCP Works</h3>
                        <p style="font-size:13px;color:var(--text-secondary);margin:0;line-height:1.6;flex:1;">MCP acts as a bridge between your AI client and ServerAvatar, allowing seamless communication and real-time actions.</p>
                        <a href="{{ route('login') }}" style="font-size:13px;font-weight:600;color:var(--accent-primary);text-decoration:none;display:flex;align-items:center;gap:4px;">Learn more <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
                    </div>

                    <!-- Card 3: What You Can Do -->
                    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;display:flex;flex-direction:column;gap:12px;">
                        <div style="width:52px;height:52px;background:var(--accent-primary-muted);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-terminal" style="color:var(--accent-primary);font-size:22px;"></i>
                        </div>
                        <h3 style="font-size:17px;font-weight:700;color:var(--text-primary);margin:0;line-height:1.3;"><span style="color:var(--accent-primary);">3.</span> What You Can Do</h3>
                        <p style="font-size:13px;color:var(--text-secondary);margin:0;line-height:1.6;flex:1;">Manage servers, applications, databases, cron jobs, firewall, backups, logs, and much more — all using simple natural language.</p>
                        <a href="#try-asking" style="font-size:13px;font-weight:600;color:var(--accent-primary);text-decoration:none;display:flex;align-items:center;gap:4px;">Explore examples <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
                    </div>

                    <!-- Card 4: Quick Setup -->
                    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;display:flex;flex-direction:column;gap:12px;">
                        <div style="width:52px;height:52px;background:var(--accent-primary-muted);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-rocket" style="color:var(--accent-primary);font-size:22px;"></i>
                        </div>
                        <h3 style="font-size:17px;font-weight:700;color:var(--text-primary);margin:0;line-height:1.3;"><span style="color:var(--accent-primary);">4.</span> Quick Setup</h3>
                        <p style="font-size:13px;color:var(--text-secondary);margin:0;line-height:1.6;flex:1;">Get connected in a few minutes. We'll guide you through each step to connect your AI client with ServerAvatar MCP.</p>
                    </div>
                </div>

                <!-- Try AI Assistant Section -->
                <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:20px 24px;margin-top:20px;scroll-margin-top:80px;" id="try-asking">
                    <!-- Header Row -->
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                        <h3 style="font-size:17px;font-weight:700;color:var(--accent-primary);margin:0;">Try asking your AI assistant</h3>
                        <a href="{{ route('login') }}" style="font-size:13px;color:var(--accent-primary);text-decoration:none;font-weight:500;display:flex;align-items:center;gap:4px;">View all examples <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
                    </div>
                    <!-- Example Buttons Row -->
                    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px;">
                        <div style="display:flex;align-items:center;gap:10px;background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;cursor:pointer;transition:all 200ms;">
                            <div style="width:30px;height:30px;min-width:30px;background:rgba(124,58,237,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-server" style="color:var(--accent-primary);font-size:13px;"></i>
                            </div>
                            <span style="font-size:13px;font-weight:500;color:var(--text-primary);">List all my servers</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;cursor:pointer;transition:all 200ms;">
                            <div style="width:30px;height:30px;min-width:30px;background:rgba(33,117,155,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fab fa-wordpress" style="color:#21759b;font-size:13px;"></i>
                            </div>
                            <span style="font-size:13px;font-weight:500;color:var(--text-primary);">Create a WordPress application</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;cursor:pointer;transition:all 200ms;">
                            <div style="width:30px;height:30px;min-width:30px;background:rgba(0,150,57,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-sync-alt" style="color:#009639;font-size:13px;"></i>
                            </div>
                            <span style="font-size:13px;font-weight:500;color:var(--text-primary);">Restart Nginx</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;cursor:pointer;transition:all 200ms;">
                            <div style="width:30px;height:30px;min-width:30px;background:rgba(124,58,237,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-database" style="color:var(--accent-primary);font-size:13px;"></i>
                            </div>
                            <span style="font-size:13px;font-weight:500;color:var(--text-primary);">Create a database</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;cursor:pointer;transition:all 200ms;">
                            <div style="width:30px;height:30px;min-width:30px;background:rgba(124,58,237,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-lock" style="color:var(--accent-primary);font-size:13px;"></i>
                            </div>
                            <span style="font-size:13px;font-weight:500;color:var(--text-primary);">Install SSL</span>
                        </div>
                    </div>
                </div>

                <!-- Supported AI Clients Section -->
                <div style="margin-top:20px;scroll-margin-top:80px;" id="supported-clients">
                    <!-- Main Card Container -->
                    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
                        
                        <!-- Section Header -->
                        <div style="text-align:left;margin-bottom:16px;">
                            <h2 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0 0 6px 0;">Supported AI Clients</h2>
                            <p style="font-size:13px;color:var(--text-secondary);margin:0;">Connect ServerAvatar MCP with the most popular AI assistants and IDEs.</p>
                        </div>
                        
                        <!-- Clients Grid -->
                        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;">
                            <!-- ChatGPT -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;cursor:pointer;transition:all 200ms;" @click="openModal('chatgpt')">
                                <div style="display:flex;align-items:flex-start;gap:10px;">
                                    <div style="width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;background:var(--bg-card);">
                                        <img src="/images/clients/chatgpt-dark.png" alt="ChatGPT" style="width:22px;height:22px;object-fit:contain;" class="icon-dark">
                                        <img src="/images/clients/chatgpt-light.png" alt="ChatGPT" style="width:22px;height:22px;object-fit:contain;" class="icon-light">
                                    </div>
                                    <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:3px;">
                                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);">ChatGPT</div>
                                        <div style="font-size:10px;color:var(--text-secondary);line-height:1.3;">Connect via Apps & Custom GPTs</div>
                                        <a href="{{ route('login') }}" style="font-size:11px;font-weight:500;color:var(--accent-primary);text-decoration:none;display:flex;align-items:center;gap:3px;margin-top:4px;">View Setup <span>→</span></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Claude -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;cursor:pointer;transition:all 200ms;" @click="openModal('claude')">
                                <div style="display:flex;align-items:flex-start;gap:10px;">
                                    <div style="width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;background:var(--bg-card);">
                                        <img src="/images/clients/claude.png" alt="Claude" style="width:22px;height:22px;object-fit:contain;">
                                    </div>
                                    <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:3px;">
                                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);">Claude</div>
                                        <div style="font-size:10px;color:var(--text-secondary);line-height:1.3;">Connect via Custom Connectors</div>
                                        <a href="{{ route('login') }}" style="font-size:11px;font-weight:500;color:var(--accent-primary);text-decoration:none;display:flex;align-items:center;gap:3px;margin-top:4px;">View Setup <span>→</span></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cursor -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;cursor:pointer;transition:all 200ms;" @click="openModal('cursor')">
                                <div style="display:flex;align-items:flex-start;gap:10px;">
                                    <div style="width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;background:var(--bg-card);">
                                        <img src="/images/clients/cursor-dark.png" alt="Cursor" style="width:22px;height:22px;object-fit:contain;" class="icon-dark">
                                        <img src="/images/clients/cursor-light.png" alt="Cursor" style="width:22px;height:22px;object-fit:contain;" class="icon-light">
                                    </div>
                                    <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:3px;">
                                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);">Cursor</div>
                                        <div style="font-size:10px;color:var(--text-secondary);line-height:1.3;">Connect via mcp.json</div>
                                        <a href="{{ route('login') }}" style="font-size:11px;font-weight:500;color:var(--accent-primary);text-decoration:none;display:flex;align-items:center;gap:3px;margin-top:4px;">View Setup <span>→</span></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- VS Code -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;cursor:pointer;transition:all 200ms;" @click="openModal('vscode')">
                                <div style="display:flex;align-items:flex-start;gap:10px;">
                                    <div style="width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;background:var(--bg-card);">
                                        <img src="/images/clients/vscode.png" alt="VS Code" style="width:22px;height:22px;object-fit:contain;">
                                    </div>
                                    <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:3px;">
                                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);">VS Code</div>
                                        <div style="font-size:10px;color:var(--text-secondary);line-height:1.3;">Connect via MCP Extension</div>
                                        <a href="{{ route('login') }}" style="font-size:11px;font-weight:500;color:var(--accent-primary);text-decoration:none;display:flex;align-items:center;gap:3px;margin-top:4px;">View Setup <span>→</span></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- More Clients -->
                            <div style="background:var(--bg-tertiary);border:1px solid var(--border-color);border-radius:10px;padding:14px;cursor:default;">
                                <div style="display:flex;align-items:flex-start;gap:10px;">
                                    <div style="width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:var(--accent-primary-muted);">
                                        <i class="fas fa-plus" style="color:var(--accent-primary);font-size:14px;"></i>
                                    </div>
                                    <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:3px;">
                                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);">More Clients</div>
                                        <div style="font-size:10px;color:var(--text-secondary);line-height:1.3;">Coming Soon</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Security Note -->
                        <div style="text-align:center;margin-top:16px;">
                            <div style="display:inline-flex;align-items:center;gap:8px;font-size:12px;color:var(--text-secondary);">
                                <i class="fas fa-lock" style="color:var(--accent-primary);font-size:11px;"></i>
                                Secure OAuth authentication & encrypted communication
                            </div>
                        </div>
                        
                    </div>
                </div>

                <!-- Available Tools Section -->
                <div style="margin-top:20px;">
                    <!-- Main Card Container -->
                    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
                        
                        <!-- Section Header -->
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                            <h2 style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;">80+ Built-in Tools Across Multiple Categories</h2>
                            <a href="{{ route('register') }}" style="font-size:13px;color:var(--accent-primary);text-decoration:none;font-weight:500;display:flex;align-items:center;gap:4px;">View all tools after Register <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
                        </div>
                        
                        <!-- Tools Grid -->
                        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
                            
                            <!-- Servers -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:8px;background:var(--accent-primary);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-server" style="color:#ffffff;font-size:15px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Servers</div>
                                    <div style="font-size:11px;color:var(--text-secondary);line-height:1.3;">Manage servers</div>
                                </div>
                            </div>
                            
                            <!-- Applications -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:8px;background:#21759b;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-rocket" style="color:#ffffff;font-size:15px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Applications</div>
                                    <div style="font-size:11px;color:var(--text-secondary);line-height:1.3;">Deploy & manage apps</div>
                                </div>
                            </div>
                            
                            <!-- Databases -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:8px;background:#009639;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-database" style="color:#ffffff;font-size:15px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Databases</div>
                                    <div style="font-size:11px;color:var(--text-secondary);line-height:1.3;">Create & manage DBs</div>
                                </div>
                            </div>
                            
                            <!-- Firewall -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:8px;background:#dc2626;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-shield-alt" style="color:#ffffff;font-size:15px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Firewall</div>
                                    <div style="font-size:11px;color:var(--text-secondary);line-height:1.3;">Secure your servers</div>
                                </div>
                            </div>
                            
                            <!-- Backups -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:8px;background:#d97706;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-cloud-upload-alt" style="color:#ffffff;font-size:15px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Backups</div>
                                    <div style="font-size:11px;color:var(--text-secondary);line-height:1.3;">Manage backups</div>
                                </div>
                            </div>
                            
                            <!-- WordPress -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:8px;background:#21759b;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fab fa-wordpress-simple" style="color:#ffffff;font-size:15px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">WordPress</div>
                                    <div style="font-size:11px;color:var(--text-secondary);line-height:1.3;">One-click actions</div>
                                </div>
                            </div>
                            
                            <!-- Cron Jobs -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:8px;background:#7c3aed;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-clock" style="color:#ffffff;font-size:15px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Cron Jobs</div>
                                    <div style="font-size:11px;color:var(--text-secondary);line-height:1.3;">Schedule tasks</div>
                                </div>
                            </div>
                            
                            <!-- And more -->
                            <div style="background:var(--bg-secondary);border:1px solid var(--border-color);border-radius:10px;padding:14px;display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:8px;background:var(--accent-primary-muted);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-ellipsis-h" style="color:var(--accent-primary);font-size:15px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">And more</div>
                                    <div style="font-size:11px;color:var(--text-secondary);line-height:1.3;">Explore all features</div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>

                <!-- Security Features Section -->
                <div style="margin-top:20px;">
                    <!-- Main Card Container -->
                    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
                        
                        <!-- Features Row -->
                        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:28px;">
                            
                            <!-- Secure OAuth Authentication -->
                            <div style="display:flex;align-items:flex-start;gap:14px;">
                                <div style="width:44px;height:44px;border-radius:12px;background:rgba(124,58,237,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-lock" style="color:var(--accent-primary);font-size:18px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:4px;">Secure OAuth Authentication</div>
                                    <div style="font-size:12px;color:var(--text-secondary);line-height:1.4;">Industry standard OAuth 2.1 authentication for safe access.</div>
                                </div>
                            </div>
                            
                            <!-- IDE Access Tokens -->
                            <div style="display:flex;align-items:flex-start;gap:14px;">
                                <div style="width:44px;height:44px;border-radius:12px;background:rgba(124,58,237,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-key" style="color:var(--accent-primary);font-size:18px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:4px;">IDE Access Tokens</div>
                                    <div style="font-size:12px;color:var(--text-secondary);line-height:1.4;">Use personal access tokens to connect securely from IDEs.</div>
                                </div>
                            </div>
                            
                            <!-- Encrypted Connections -->
                            <div style="display:flex;align-items:flex-start;gap:14px;">
                                <div style="width:44px;height:44px;border-radius:12px;background:rgba(124,58,237,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-shield-alt" style="color:var(--accent-primary);font-size:18px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:4px;">Encrypted Connections</div>
                                    <div style="font-size:12px;color:var(--text-secondary);line-height:1.4;">All communications are encrypted with end-to-end security.</div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>

                <!-- CTA Section -->
                <div style="margin-top:20px;">
                    <div style="background:linear-gradient(135deg,rgba(124,58,237,0.08) 0%,rgba(167,139,250,0.12) 100%);border:1px solid var(--border-color);border-radius:16px;padding:24px;display:flex;align-items:center;justify-content:space-between;gap:24px;">
                        
                        <!-- Left Content with Rocket -->
                        <div style="display:flex;align-items:center;gap:24px;flex:1;">
                            <div style="flex-shrink:0;">
                                <img src="/images/rocket-illustration.png" alt="Rocket" style="width:180px;height:auto;">
                            </div>
                            <div>
                                <h2 style="font-size:22px;font-weight:700;color:var(--accent-primary);margin:0 0 8px 0;">Ready to Manage Your Infrastructure with AI?</h2>
                                <p style="font-size:14px;color:var(--text-secondary);margin:0;line-height:1.5;">Connect ChatGPT, Claude, Cursor, VS Code, and more with ServerAvatar MCP in just a few minutes.</p>
                            </div>
                        </div>
                        
                        <!-- Right CTA Button -->
                        <div style="flex-shrink:0;text-align:center;">
                            <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:8px;background:var(--accent-primary);color:#ffffff;text-decoration:none;font-size:14px;font-weight:600;padding:12px 24px;border-radius:10px;transition:all 200ms;margin-bottom:8px;">
                                Create Free Account <i class="fas fa-arrow-right" style="font-size:12px;"></i>
                            </a>
                            <div style="font-size:13px;color:var(--text-secondary);">
                                Already have an account? <a href="{{ route('login') }}" style="color:var(--accent-primary);text-decoration:none;font-weight:500;display:inline-flex;align-items:center;gap:4px;">Log in <i class="fas fa-arrow-right" style="font-size:10px;"></i></a>
                            </div>
                        </div>
                        
                    </div>
                </div>

        <!-- Footer -->
        <footer class="footer">
            <p>© {{ date('Y') }} ServerAvatar MCP. Built with Laravel & MCP Protocol</p>
            <p>Powered by <a href="https://serveravatar.com" target="_blank">ServerAvatar</a></p>
        </footer>
    </main>

    <!-- Modal -->
    <div id="guideModal" class="guide-modal-overlay">
        <div class="guide-modal-content">
            <div class="guide-modal-header">
                <div class="guide-modal-header-left" style="display:flex;align-items:center;gap:14px;">
                    <div class="guide-modal-logo-wrap">
                        <img id="modalLogo" src="/images/clients/chatgpt-dark.png" alt="">
                    </div>
                    <div class="guide-modal-header-titles">
                        <h3 id="modalTitle">ChatGPT</h3>
                        <p id="modalSubtitle">Step-by-step setup guide</p>
                    </div>
                </div>
                <button class="guide-modal-close-btn" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="guide-modal-body">
                <div class="guide-modal-sidebar" id="modalSidebar"></div>
                <div class="guide-modal-main" id="modalMain"></div>
            </div>
        </div>
    </div>

    <script>
        // Theme Toggle
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved) {
                document.documentElement.setAttribute('data-theme', saved);
            }
        })();
        function toggleTheme() {
            const html = document.documentElement;
            const theme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }

        // Client Data
        const clients = {
            chatgpt: {
                name: 'ChatGPT',
                image: '/images/clients/chatgpt-dark.png',
                imageLight: '/images/clients/chatgpt-light.png',
                steps: [
                    { title: 'Enable Developer Mode', content: '<div class="guide-modal-step-card"><h4>Step 1: <span>Enable Developer Mode</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Log in to your ChatGPT account</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Open Settings</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Enable Developer Mode (if available for your account)</p></div></div>' },
                    { title: 'Create MCP Connector', content: '<div class="guide-modal-step-card"><h4>Step 2: <span>Create a New MCP Connector</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Open Settings</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Go to Apps (or Plugins, depending on your ChatGPT version)</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Click Create New</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">4</div><p class="guide-modal-substep-text">Enter a name: ServerAvatar MCP</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">5</div><p class="guide-modal-substep-text">Paste your MCP Server URL into the Connection URL field</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">6</div><p class="guide-modal-substep-text">Save the connector</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">7</div><p class="guide-modal-substep-text">Complete the authorization process if prompted</p></div></div>' },
                    { title: 'Start Using', content: '<div class="guide-modal-step-card"><h4>Step 3: <span>Start Using ServerAvatar MCP</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Open a new chat/conversation</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Select the ServerAvatar MCP connector from the top model dropdown</p></div></div><p class="guide-modal-desc-text">You can now use natural language commands such as:</p><div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;"><button class="guide-modal-example-btn">List all my servers</button><button class="guide-modal-example-btn">Show server status</button><button class="guide-modal-example-btn">Create new database</button><button class="guide-modal-example-btn">Deploy WordPress</button></div><div class="guide-modal-success-box"><p>🎉 You\'re all set! Start managing your infrastructure with AI.</p></div>' }
                ]
            },
            claude: {
                name: 'Claude',
                image: '/images/clients/claude.png',
                steps: [
                    { title: 'Open Claude Settings', content: '<div class="guide-modal-step-card"><h4>Step 1: <span>Open Claude Settings</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Log into your Claude account</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Open Settings</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Navigate to Connectors or Customize (depending on your Claude version)</p></div></div>' },
                    { title: 'Add Custom Connector', content: '<div class="guide-modal-step-card"><h4>Step 2: <span>Add a Custom Connector</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Click Add Custom Connector</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Enter a connector name: ServerAvatar MCP</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Paste your MCP Server URL into the connection URL field</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">4</div><p class="guide-modal-substep-text">Save the connector</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">5</div><p class="guide-modal-substep-text">Complete the authorization process if required</p></div></div><p class="guide-modal-desc-text">After a successful connection, the ServerAvatar MCP connector will be available in Claude.</p>' },
                    { title: 'Start Managing', content: '<div class="guide-modal-step-card"><h4>Step 3: <span>Start Managing Your Servers</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Open a new Claude chat</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Select your ServerAvatar MCP connector</p></div></div><p class="guide-modal-desc-text">You can now ask Claude to perform ServerAvatar operations, for example:</p><div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;"><button class="guide-modal-example-btn">Create an application</button><button class="guide-modal-example-btn">List servers</button><button class="guide-modal-example-btn">Manage databases</button><button class="guide-modal-example-btn">Install SSL certificates</button><button class="guide-modal-example-btn">Change application settings</button></div><div class="guide-modal-success-box"><p>🎉 You\'re all set! Start managing your infrastructure with AI.</p></div>' }
                ]
            },
            cursor: {
                name: 'Cursor',
                image: '/images/clients/cursor-dark.png',
                imageLight: '/images/clients/cursor-light.png',
                steps: [
                    { title: 'Install and Sign In', content: '<div class="guide-modal-step-card"><h4>Step 1: <span>Install and Sign In</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Download and install Cursor IDE on your computer</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Sign in to your Cursor account</p></div></div>' },
                    { title: 'Generate Token', content: '<div class="guide-modal-step-card"><h4>Step 2: <span>Generate an IDE Access Token</span></h4><div class="guide-modal-note-box"><p><strong>Note:</strong> An access token is required before connecting Cursor.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Log in to ServerAvatar MCP</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Navigate to Endpoint & Tokens</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Under IDE Access Tokens, enter a token name (e.g., Cursor Development)</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">4</div><p class="guide-modal-substep-text">Click Generate Token</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">5</div><p class="guide-modal-substep-text">Copy the generated token immediately (it won\'t be shown again)</p></div></div>' },
                    { title: 'Open MCP Settings', content: '<div class="guide-modal-step-card"><h4>Step 3: <span>Open MCP Settings</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Open Cursor</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Navigate to Settings → Tools & MCP</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Under Installed MCP Servers, click + Add New MCP Server</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">4</div><p class="guide-modal-substep-text">Cursor will open the mcp.json configuration file</p></div></div>' },
                    { title: 'Configure', content: '<div class="guide-modal-step-card"><h4>Step 4: <span>Configure ServerAvatar MCP</span></h4><p class="guide-modal-desc-text">Modify your mcp.json file with the following configuration:</p><div class="guide-modal-code-block"><div class="code-title">mcp.json</div><pre>{ "mcpServers": { "serveravatar-mcp": { "url": "YOUR_MCP_SERVER_URL", "headers": { "Authorization": "Bearer YOUR_IDE_ACCESS_TOKEN" } } } }</pre></div><p style="font-size:14px;font-weight:600;color:var(--accent-primary);margin:16px 0 12px 0;">Replace:</p><div class="guide-modal-substep"><div style="width:6px;height:6px;min-width:6px;background:var(--accent-primary);border-radius:50%;flex-shrink:0;"></div><p class="guide-modal-substep-text"><code class="guide-modal-code">YOUR_MCP_SERVER_URL</code> with the MCP Server URL from ServerAvatar MCP → Endpoint & Tokens</p></div><div class="guide-modal-substep"><div style="width:6px;height:6px;min-width:6px;background:var(--accent-primary);border-radius:50%;flex-shrink:0;"></div><p class="guide-modal-substep-text"><code class="guide-modal-code">YOUR_IDE_ACCESS_TOKEN</code> with the IDE Access Token you generated</p></div><div class="guide-modal-tip-box" style="margin-top:16px;"><p><strong>Don\'t forget!</strong> Save the <code class="guide-modal-code">mcp.json</code> file after making the changes.</p></div></div>' },
                    { title: 'Verify Connection', content: '<div class="guide-modal-step-card"><h4>Step 5: <span>Verify the Connection</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Return to Settings → Tools & MCP.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Verify that ServerAvatar MCP appears under Installed MCP Servers.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Ensure the server status shows Connected or Available.</p></div></div><div class="guide-modal-error-box"><p class="guide-modal-error-text">If the connection fails, verify your MCP Server URL and IDE Access Token, then reload Cursor.</p></div>' },
                    { title: 'Start Using', content: '<div class="guide-modal-step-card"><h4>Step 6: <span>Start Using ServerAvatar MCP</span></h4><p class="guide-modal-desc-text">Open a new AI chat or Agent session in Cursor and start using natural language commands, for example:</p><div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;"><button class="guide-modal-example-btn">List my servers</button><button class="guide-modal-example-btn">Create a WordPress application</button><button class="guide-modal-example-btn">List databases</button><button class="guide-modal-example-btn">Restart Nginx</button><button class="guide-modal-example-btn">Install an SSL certificate</button></div><p class="guide-modal-desc-text">Cursor will automatically invoke the appropriate ServerAvatar MCP tools when required.</p><div class="guide-modal-tip-box"><p><strong>💡 Tip:</strong> If you update the mcp.json file, reload or restart Cursor to ensure the new MCP configuration is loaded.</p></div><div class="guide-modal-success-box"><p>🎉 You\'re all set! Start managing your infrastructure with AI.</p></div>' }
                ]
            },
            vscode: {
                name: 'VS Code',
                image: '/images/clients/vscode.png',
                steps: [
                    { title: 'Install VS Code', content: '<div class="guide-modal-info-note"><i class="fas fa-info-circle icon"></i><p>Visual Studio Code supports connecting to ServerAvatar MCP using <strong>OAuth Authorization (Recommended)</strong> or <strong>IDE Access Tokens (Manual Configuration)</strong>.</p></div><div class="guide-modal-step-card"><h4>Step 1: <span>Install and Sign In</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Install the latest version of Visual Studio Code.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Install the GitHub Copilot and GitHub Copilot Chat extensions.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Sign in with your GitHub account.</p></div></div>' },
                    { title: 'Add MCP Server', content: '<div class="guide-modal-step-card"><h4>Step 2: <span>Add Your MCP Server</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Press <strong>Ctrl + Shift + P</strong>.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Run: <code class="guide-modal-code">MCP: Add Server</code></p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Select <strong>HTTP (Remote) MCP Server</strong>.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">4</div><p class="guide-modal-substep-text">Enter your ServerAvatar MCP Endpoint URL.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">5</div><p class="guide-modal-substep-text">Enter a name (for example, <strong>ServerAvatar MCP</strong>).</p></div></div>' },
                    { title: 'Authorize', content: '<div class="guide-modal-step-card"><h4>Step 3: <span>Authorize</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Visual Studio Code will automatically open your browser.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Sign in to your ServerAvatar MCP account if prompted.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Click <strong>Authorize</strong>.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">4</div><p class="guide-modal-substep-text">Return to Visual Studio Code.</p></div></div><div class="guide-modal-success-box"><p>🎉 You\'re all set! Start managing your infrastructure with AI.</p></div>' },
                    { title: 'Start Using', content: '<div class="guide-modal-step-card"><h4>Step 4: <span>Start Using</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Open <strong>GitHub Copilot Chat</strong> in <strong>Agent mode</strong>.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Use your connected MCP server to manage your infrastructure with natural language.</p></div></div>' }
                ]
            },
            windsurf: {
                name: 'Windsurf',
                image: '/images/clients/windsurf-dark.png',
                imageLight: '/images/clients/windsurf-light.png',
                steps: [
                    { title: 'Install Windsurf', content: '<div class="guide-modal-step-card"><h4>Step 1: <span>Install Windsurf</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Download and install Windsurf IDE</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Launch Windsurf and create an account</p></div></div>' },
                    { title: 'Generate Token', content: '<div class="guide-modal-step-card"><h4>Step 2: <span>Generate an IDE Access Token</span></h4><div class="guide-modal-note-box"><p><strong>Note:</strong> An access token is required before connecting Windsurf.</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Log in to ServerAvatar MCP</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Navigate to Endpoint & Tokens</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Generate a new IDE Access Token</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">4</div><p class="guide-modal-substep-text">Copy the token immediately</p></div></div>' },
                    { title: 'Add MCP Server', content: '<div class="guide-modal-step-card"><h4>Step 3: <span>Add ServerAvatar MCP to Windsurf</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Open Windsurf Settings</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Go to Extensions or MCP Settings</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">3</div><p class="guide-modal-substep-text">Add a new MCP server with your Server URL and token</p></div></div>' },
                    { title: 'Start Using', content: '<div class="guide-modal-step-card"><h4>Step 4: <span>Start Using</span></h4><div class="guide-modal-substep"><div class="guide-modal-substep-num">1</div><p class="guide-modal-substep-text">Open the Windsurf AI chat</p></div><div class="guide-modal-substep"><div class="guide-modal-substep-num">2</div><p class="guide-modal-substep-text">Start using natural language commands</p></div></div><p class="guide-modal-desc-text">Example commands:</p><div style="display:flex;flex-wrap:wrap;gap:8px;"><button class="guide-modal-example-btn">List all my servers</button><button class="guide-modal-example-btn">Create a database</button><button class="guide-modal-example-btn">Deploy WordPress</button></div><div class="guide-modal-success-box" style="margin-top:16px;"><p>🎉 You\'re all set! Start managing your infrastructure with AI.</p></div>' }
                ]
            }
        };

        let currentClient = null;
        let currentStep = 0;

        function openModal(clientKey) {
            const client = clients[clientKey];
            if (!client) return;

            currentClient = clientKey;
            currentStep = 0;

            const theme = document.documentElement.getAttribute('data-theme');
            document.getElementById('modalLogo').src = theme === 'dark' && client.imageLight ? client.imageLight : client.image;
            document.getElementById('modalTitle').textContent = client.name;
            document.getElementById('modalSubtitle').textContent = 'Step-by-step setup guide';

            // Build sidebar
            const sidebar = document.getElementById('modalSidebar');
            sidebar.innerHTML = client.steps.map((step, i) => `
                <div class="guide-modal-sidebar-step ${i === 0 ? 'active' : ''}" onclick="showStep(${i})">
                    <div class="guide-modal-step-num">${i + 1}</div>
                    <span class="${i === 0 ? 'guide-modal-step-text-active' : 'guide-modal-step-text'}">${step.title}</span>
                </div>
            `).join('');

            showStep(0);
            document.getElementById('guideModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function showStep(index) {
            if (!currentClient) return;
            const client = clients[currentClient];
            if (!client || !client.steps[index]) return;

            document.querySelectorAll('.guide-modal-sidebar-step').forEach((el, i) => {
                el.classList.toggle('active', i === index);
                el.querySelector('span').className = i === index ? 'guide-modal-step-text-active' : 'guide-modal-step-text';
            });

            document.getElementById('modalMain').innerHTML = client.steps[index].content;
            currentStep = index;
        }

        function closeModal() {
            document.getElementById('guideModal').classList.remove('show');
            document.body.style.overflow = '';
            currentClient = null;
            currentStep = 0;
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        document.getElementById('guideModal').addEventListener('click', (e) => {
            if (e.target.id === 'guideModal') closeModal();
        });
    </script>
</body>
</html>
