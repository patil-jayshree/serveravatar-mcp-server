    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ auth()->check() ? '/dashboard' : '/' }}" class="nav-brand">
                <div class="nav-logo"><i class="fas fa-bolt" style="color: #fbbf24;"></i></div>
                <span class="nav-title">Server<span>Avatar</span> MCP</span>
            </a>
            <div class="nav-right">
                <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme"></button>
                @auth
                    @include('components.profile-dropdown')
                @endauth
            </div>
        </div>
    </nav>