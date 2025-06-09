<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased"
        style="background: var(--background, #8B6842); color: var(--text, #fff); min-height: 100vh; margin: 0; font-family: 'Segoe UI', sans-serif;">
        @php
            $theme = Auth::user() && Auth::user()->theme ? Auth::user()->theme : (object)[
                'primary_color' => '#b8860b',
                'secondary_color' => '#fdf6d8',
                'background_color' => '#8B6842',
                'text_color' => '#fff',
                'name' => 'Classic',
            ];
            $exp = Auth::user()->exp ?? 0;
            $level = Auth::user()->level ?? 1;
            $expNeeded = $level * 100;
            $expPercent = min(100, round(($exp / $expNeeded) * 100));
        @endphp
        <style>
            :root {
                --primary: {{ $theme->primary_color ?? '#b8860b' }};
                --secondary: {{ $theme->secondary_color ?? '#fdf6d8' }};
                --background: {{ $theme->background_color ?? '#8B6842' }};
                --text: {{ $theme->text_color ?? '#fff' }};
                --exp-bar: #DD7A7A;
                --achievement-text: {{ $theme->achievement_text_color ?? ($theme->name == 'Night Owl' ? '#fff' : '#3a2c1a') }};
                @if($theme->name == 'Night Owl')
                    --container-bg: #23243a;
                    --quest-container-bg: #23243a;
                    --quest-section-bg: #7aa2f7;
                    --quest-section-text: #23243a;
                    --quest-section-border: #fff;
                    --tab-active-bg: #23243a;
                    --tab-active-text: #c0caf5;
                    --tab-inactive-bg: #1a1b26;
                    --tab-inactive-text: #7aa2f7;
                    --quest-card-bg: #23243a;
                    --quest-card-text: #c0caf5;
                    --quest-badge-bg: #7aa2f7;
                    --quest-badge-text: #fff;
                    --quest-desc-bg: #1a1b26;
                    --quest-desc-text: #c0caf5;
                    --quest-btn-complete: #9ece6a;
                    --quest-btn-delete: #f7768e;
                    --quest-btn-text: #fff;
                    --quest-deadline-bg: #23243a;
                    --quest-deadline-text: #7aa2f7;
                    --highlight-bg: rgba(122, 162, 247, 0.18);
                    --highlight-border: #fff;
                    --fab-bg: #7aa2f7;
                    --fab-shadow: 0 4px 16px #7aa2f799;
                    --fab-icon: #fff;
                    --modal-bg: #23243a;
                    --modal-header-bg: #363a54;
                    --modal-header-text: #fff;
                    --modal-btn-bg: #7aa2f7;
                    --modal-btn-text: #fff;
                    --leaderboard-card-bg: #23243a;
                    --leaderboard-card-highlight-bg: #E6EFC2;
                    --date-bg: #D2B78A;
                    --calendar-bg: #D2B78A;
                    --level-circle-bg: #DD7A7A;
                    --level-circle-text: #fff;
                    --quest-badge-bg-personal: #345222;
                    --quest-badge-bg-daily: #99D877;
                    --quest-badge-text-daily: #183408;
                @elseif($theme->name == 'Monochrome')
                    --container-bg: #666;
                    --quest-container-bg: #666;
                    --quest-section-bg: #8fc97a;
                    --quest-section-text: #fff;
                    --quest-section-border: #8fc97a;
                    --tab-active-bg: #fff;
                    --tab-active-text: #222;
                    --tab-inactive-bg: #e0e0e0;
                    --tab-inactive-text: #222;
                    --quest-card-bg: #8fc97a;
                    --quest-card-text: #222;
                    --quest-badge-bg: #5ea05e;
                    --quest-badge-text: #fff;
                    --quest-desc-bg: #f5f5f5;
                    --quest-desc-text: #222;
                    --quest-btn-complete: #8fc97a;
                    --quest-btn-delete: #e74c3c;
                    --quest-btn-text: #fff;
                    --quest-deadline-bg: #222;
                    --quest-deadline-text: #fff;
                    --highlight-bg: #8fc97a22;
                    --highlight-border: #8fc97a;
                    --fab-bg: #8fc97a;
                    --fab-shadow: 0 4px 16px #2222;
                    --fab-icon: #fff;
                    --modal-bg: #f5f5f5;
                    --modal-header-bg: #222;
                    --modal-header-text: #fff;
                    --modal-btn-bg: #8fc97a;
                    --modal-btn-text: #fff;
                    --leaderboard-card-bg: #f5f5f5;
                    --leaderboard-card-highlight-bg: #8fc97a33;
                    --background: #e0e0e0;
                    --primary: #666;
                    --secondary: #888;
                    --text: #fff;
                    --exp-bar: #8fc97a;
                    --achievement-text: #222;
                    --sidebar-text: #fff;
                    --sidebar-icon: #fff;
                    --level-circle-bg: #8fc97a;
                    --level-circle-text: #fff;
                @else
                    --container-bg: #CAD7C3;
                    --quest-container-bg: #CAD7C3;
                    --leaderboard-card-bg: #DFEDD7;
                    --leaderboard-card-highlight-bg: #E6EFC2;
                    --quest-section-bg: #fffbe6;
                    --quest-section-text: #654D48;
                    --quest-section-border: #fff;
                    --tab-active-bg: #fff;
                    --tab-active-text: #654D48;
                    --tab-inactive-bg: #d2c1ad;
                    --tab-inactive-text: #654D48;
                    --quest-card-bg: #e7d6b8;
                    --quest-card-text: #654D48;
                    --quest-badge-bg: #ffe066;
                    --quest-badge-text: #fff;
                    --quest-desc-bg: #fffbe6;
                    --quest-desc-text: #654D48;
                    --quest-btn-complete: #8fc97a;
                    --quest-btn-delete: #e74c3c;
                    --quest-btn-text: #fff;
                    --quest-deadline-bg: #A4CC8F;
                    --quest-deadline-text: #654D48;
                    --highlight-bg: rgba(255, 224, 102, 0.18);
                    --highlight-border: #fff;
                    --fab-bg: #654D48;
                    --fab-shadow: 0 4px 16px #654D4899;
                    --fab-icon: #fff;
                    --modal-bg: #f5e6d8;
                    --modal-header-bg: #654D48;
                    --modal-header-text: #fff;
                    --modal-btn-bg: #8fc97a;
                    --modal-btn-text: #fff;
                    --background: #ECEDDF;
                    --primary: #654D48;
                    --secondary: #fdf6d8;
                    --text: #654D48;
                    --exp-bar: #DD7A7A;
                    --achievement-text: #654D48;
                    --sidebar-text: #654D48;
                    --sidebar-icon: #654D48;
                    --level-circle-bg: #DD7A7A;
                    --level-circle-text: #654D48;
                    --topbar-bg: #654D48;
                @endif
            }
        </style>
        <div class="min-h-screen" style="background: var(--background); color: var(--text); min-height: 100vh; font-family: 'Segoe UI', sans-serif;">
            <!-- Fixed Navbar/Header -->
            <div id="main-navbar" style="position:fixed; top:0; left:0; width:100vw; background:var(--topbar-bg, var(--primary)); padding:1rem 2.5rem; display:flex; align-items:center; justify-content:space-between; z-index:5000; box-sizing: border-box; box-shadow:0 2px 8px #6e544580; color:#fff;">
                <div style="flex:1; display:flex; align-items:center;">
                    <span id="sidebar-toggle" style="margin-right:1.2rem; font-size:1.8rem; cursor: pointer; color:#fff;">☰</span>
                    <span id="greeting-text" style="font-size:1.4rem; font-family:serif; color:#fff; letter-spacing:0.02em;">Good morning, {{ Auth::user()->name ?? 'Grindmaster' }}!</span>
                    <span style="display:flex; align-items:center; gap:0.7rem; margin-left:2.2rem; background:rgba(0,0,0,0.10); border-radius:0.7rem; padding:0.3rem 1.1rem; font-size:1.1rem; font-family:'Segoe UI',sans-serif; font-weight:bold; color:#fff; box-shadow:0 2px 8px #0002;">
                        <span style="font-size:1.4rem; margin-right:0.5rem;">🔥</span>
                        Streak: <span style="margin:0 0.5rem; color:var(--exp-bar, #DD7A7A); font-size:1.2rem;">{{ Auth::user()->current_streak ?? 0 }}</span>
                        <span style="font-size:1rem; color:#fff; margin-left:1.1rem;">Longest: <span style="color:var(--exp-bar, #DD7A7A); font-size:1.1rem;">{{ Auth::user()->longest_streak ?? 0 }}</span></span>
                    </span>
                </div>
                <div style="flex:1; display:flex; align-items:center; justify-content:center;">
                    <div style="width:320px; height:2.1rem; background:rgba(255,255,255,0.18); border-radius:1.2rem; position:relative; box-shadow:0 2px 8px #6e544540; display:flex; align-items:center;">
                        <div style="width:{{ $expPercent }}%; background:var(--exp-bar, #DD7A7A); height:100%; border-radius:1.2rem; transition:width 0.4s;"></div>
                        <div style="position:absolute; left:0; top:0; width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-weight:bold; color:#fff; font-size:1.08rem; letter-spacing:0.03em;">
                            EXP: {{ $exp }} / {{ $expNeeded }}
                        </div>
                    </div>
                    <div style="width:48px; height:48px; background:var(--level-circle-bg, #DD7A7A); color:var(--level-circle-text, #fff); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.3rem; font-family:serif; font-weight:bold; box-shadow:0 1px 6px #6e5445a0; border:4px solid var(--background); margin-left:-18px; z-index:1;">
                        {{ Auth::user()->level ?? 1 }}
                    </div>
                </div>
                <div style="flex:1; display:flex; align-items:center; justify-content:flex-end;">
                    <span id="clock-top-right" style="font-size:1.6rem; font-family:monospace; color:#fff; font-weight: bold; border-radius:0.7rem; padding:0.3rem 1.2rem;">12:00 pm</span>
                </div>
            </div>

            <!-- Sidebar Overlay (blurred when sidebar is open) -->
            <div id="sidebar-overlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; z-index:3999; background:rgba(60,40,40,0.15); backdrop-filter: blur(3px);"></div>
            <!-- Sidebar (no blur, solid, rounded right corners, icons) -->
            <div id="sidebar" style="position:fixed; top:0; left:0; height:100vh; width:340px; max-width:90vw; background:var(--primary); z-index:4000; box-shadow:2px 0 16px #2d1c1c55; padding:0; transition:transform 0.3s; border-top-right-radius:1rem; border-bottom-right-radius:1rem; transform:translateX(-100%); display:flex; flex-direction:column; justify-content:space-between; color:var(--text);">
                <div style="padding:2.2rem 1.5rem 0.5rem 1.5rem;">
                    <div style="display:flex; align-items:center; gap:1.2rem; margin-bottom:2.2rem;">
                        <span id="sidebar-toggle-inside" style="font-size:2rem; color:var(--text); cursor:pointer;">☰</span>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:1.2rem;">
                        <a href="{{ route('dashboard') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">🏠</span>
                            Home
                        </a>
                        <a href="{{ route('profile.edit') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">👤</span>
                            Profile
                        </a>
                        <a href="{{ route('tasks.index') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">📝</span>
                            Quests
                        </a>
                        <a href="{{ route('calendar') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">📅</span>
                            Calendar
                        </a>
                        <a href="{{ route('leaderboard') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">🏆</span>
                            Leaderboard
                        </a>
                        <a href="{{ route('achievements') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">🎖️</span>
                            Achievements
                        </a>
                    </div>
                </div>
                <div style="padding:1.5rem 1.5rem 2.2rem 1.5rem;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button id="sidebar-logout-btn" type="submit" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33; border:none; outline:none; cursor:pointer; opacity:0.7; width:100%; margin-top:0.7rem;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">↩️</span>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Page Content -->
            <main style="margin-top:84px;">
                {{ $slot }}
            </main>
        </div>

        <!-- Global Floating Action Button (FAB) -->
        <!-- Global Add Quest Modal -->
        <div id="add-quest-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:6000; align-items:center; justify-content:center;">
            <div style="background:var(--modal-bg); color:var(--modal-text, #222); border-radius:1.5rem; box-shadow:0 6px 32px #0008; padding:2.2rem 2.2rem 2.2rem 2.2rem; min-width:370px; max-width:95vw; position:relative; display:flex; flex-direction:column; align-items:center;">
                <!-- Header Bar -->
                <div style="width:100%; display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
                    <div style="background:var(--modal-header-bg); color:var(--modal-header-text, #fff); font-size:1.35rem; font-weight:bold; border-radius:0.7rem; padding:0.3rem 1.2rem; display:flex; align-items:center; gap:0.7rem; box-shadow:0 2px 8px #0002;">
                        <span style="font-size:1.7rem; font-weight:bold;">+</span> Create New Quest
                    </div>
                    <button id="close-add-quest" style="background:none; border:none; font-size:2.1rem; color:var(--modal-header-bg); cursor:pointer; margin-left:1.2rem; border-radius:0.5rem; transition:background 0.2s; width:2.3rem; height:2.3rem; display:flex; align-items:center; justify-content:center;" onmouseover="this.style.background='var(--highlight-bg)'" onmouseout="this.style.background='none'">&times;</button>
                </div>
                <form method="POST" action="{{ route('tasks.store') }}" style="width:100%; display:flex; flex-direction:column; gap:1.2rem;">
                    @csrf
                    <label for="quest-title" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Quest Title</label>
                    <input id="quest-title" type="text" name="title" required style="font-size:1.1rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:var(--container-bg, #fff); color:var(--modal-text, #222); margin-bottom:0.7rem;">
                    <label for="quest-desc" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Quest Description (Optional)</label>
                    <textarea id="quest-desc" name="description" style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:var(--container-bg, #fff); color:var(--modal-text, #222); min-height:80px;"></textarea>
                    <label for="quest-deadline" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Quest Deadline</label>
                    <input id="quest-deadline" type="datetime-local" name="deadline" style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:var(--container-bg, #fff); color:var(--modal-text, #222);">
                    <label for="quest-priority" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Priority</label>
                    <select id="quest-priority" name="priority" required style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:var(--container-bg, #fff); color:var(--modal-text, #222);">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                    <button type="submit" class="btn-green" style="font-size:1.1rem; padding:0.9rem 2.2rem; width:100%; margin-top:0.7rem; background:var(--modal-btn-bg); color:var(--modal-btn-text, #fff); border-radius:0.7rem; border:none; font-weight:bold; box-shadow:2px 2px 8px #0002; cursor:pointer; transition:background 0.2s;">Create Quest</button>
                </form>
            </div>
        </div>
        @if(session('success'))
            <div id="toast-success"
                 style="position:fixed; top:2rem; left:50%; transform:translateX(-50%); background:var(--primary); color:#fff; font-size:1.1rem; padding:0.8rem 2rem; border-radius:0.6rem; box-shadow:0 2px 8px #6e5445; z-index:9999; transition:opacity 0.5s;">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    var toast = document.getElementById('toast-success');
                    if (toast) {
                        toast.style.opacity = '0';
                        setTimeout(function(){ toast.remove(); }, 500);
                    }
                }, 2500);
            </script>
        @endif
        @stack('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar logic
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarToggleInside = document.getElementById('sidebar-toggle-inside');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            let sidebarOpen = false;
            function openSidebar() {
                sidebar.style.transform = 'translateX(0)';
                overlay.style.display = 'block';
                sidebarOpen = true;
            }
            function closeSidebar() {
                sidebar.style.transform = 'translateX(-100%)';
                overlay.style.display = 'none';
                sidebarOpen = false;
            }
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                if (!sidebarOpen) openSidebar();
                else closeSidebar();
            });
            sidebarToggleInside.addEventListener('click', function(e) {
                e.stopPropagation();
                closeSidebar();
            });
            overlay.addEventListener('click', closeSidebar);
            // Optional: close sidebar on ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebarOpen) closeSidebar();
            });
            // Also close sidebar if user clicks anywhere outside the sidebar
            document.addEventListener('click', function(e) {
                if (sidebarOpen && !sidebar.contains(e.target) && e.target !== sidebarToggle) {
                    closeSidebar();
                }
            });
            // Prevent clicks inside sidebar from closing it
            sidebar.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            // Logout confirmation
            var logoutBtn = document.getElementById('sidebar-logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to logout?')) {
                        e.preventDefault();
                    }
                });
            }
            // Clock update (Header)
            function updateClockHeader() {
                const now = new Date();
                const hours = String(now.getHours() % 12 || 12).padStart(2, '0'); // 12-hour format
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const ampm = now.getHours() >= 12 ? 'pm' : 'am';
                document.getElementById('clock-top-right').textContent = `${hours}:${minutes} ${ampm}`;
            }
            setInterval(updateClockHeader, 1000);
            updateClockHeader(); // Initial call to display clock immediately
            // Greeting update (Header)
            function updateGreeting() {
                const now = new Date();
                const hour = now.getHours();
                let greeting = 'Good morning';
                if (hour >= 5 && hour < 12) greeting = 'Good morning';
                else if (hour >= 12 && hour < 17) greeting = 'Good afternoon';
                else greeting = 'Good evening';
                const name = @json(Auth::user()->name ?? 'Grindmaster');
                document.getElementById('greeting-text').textContent = `${greeting}, ${name}!`;
            }
            setInterval(updateGreeting, 1000 * 60); // update every minute
            updateGreeting();
            // Add Quest Modal close logic
            var closeAddQuest = document.getElementById('close-add-quest');
            var addQuestModal = document.getElementById('add-quest-modal');
            if (closeAddQuest && addQuestModal) {
                closeAddQuest.onclick = function() {
                    addQuestModal.style.display = 'none';
                };
                addQuestModal.onclick = function(e) {
                    if (e.target === addQuestModal) {
                        addQuestModal.style.display = 'none';
                    }
                };
            }
        });
        </script>
    </body>
</html>
