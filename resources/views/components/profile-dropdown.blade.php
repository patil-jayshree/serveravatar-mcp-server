                    <div class="profile-dropdown">
                        <button class="profile-btn" onclick="toggleProfileMenu()">
                            <span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                            <span>{{ auth()->user()->name ?? 'User' }}</span>
                            <span style="color:var(--text-muted);font-size:0.7rem;">▼</span>
                        </button>
                        <div class="profile-menu" id="profileMenu">
                            <div class="profile-menu-header">
                                <div class="profile-menu-name">{{ auth()->user()->name }}</div>
                                <div class="profile-menu-email">{{ auth()->user()->email }}</div>
                            </div>
                            @if(!request()->is('account') && !request()->is('account/password') && !request()->is('account/api'))
                            <a href="/account" class="profile-menu-item"><i class="fas fa-user-circle" style="color: var(--accent-primary); width:16px;"></i> Account</a>
                            <div class="profile-menu-divider"></div>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="profile-menu-item danger" style="width:100%;border:none;background:none;text-align:left;cursor:pointer;"><i class="fas fa-sign-out-alt" style="width:16px;"></i> Logout</button>
                            </form>
                        </div>
                    </div>