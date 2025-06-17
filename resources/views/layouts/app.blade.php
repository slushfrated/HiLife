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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased"
        style="background: var(--background, #8B6842); color: var(--text, #fff); min-height: 100vh; margin: 0; font-family: 'Inter', sans-serif;">
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
                    --quest-card-bg: #DFEDD7;
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
        <div class="min-h-screen" style="background: var(--background); color: var(--text); min-height: 100vh; font-family: 'Inter', sans-serif;">
            <!-- Fixed Navbar/Header -->
            <div id="main-navbar" style="position:fixed; top:0; left:0; width:100vw; background:var(--topbar-bg, var(--primary)); padding:1rem 2.5rem; display:flex; align-items:center; justify-content:space-between; z-index:5000; box-sizing: border-box; box-shadow:0 2px 8px #6e544580; color:#fff;">
                <div style="flex:1; display:flex; align-items:center;">
                    <span id="sidebar-toggle" style="margin-right:1.2rem; font-size:1.8rem; cursor: pointer; color:#fff;">☰</span>
                    <span id="greeting-text" style="font-size:1.4rem; font-family:'Inter',sans-serif; color:#fff; letter-spacing:0.02em;">Good morning, {{ Auth::user()->name ?? 'Grindmaster' }}!</span>
                    <span style="display:flex; align-items:center; gap:0.7rem; margin-left:2.2rem; background:rgba(0,0,0,0.10); border-radius:0.7rem; padding:0.3rem 1.1rem; font-size:1.1rem; font-family:'Segoe UI',sans-serif; font-weight:bold; color:#fff; box-shadow:0 2px 8px #0002;">
                        <span style="font-size:1.4rem; margin-right:0.5rem; display:flex; align-items:center; justify-content:center;">
                            <svg width='24' height='24' viewBox='0 0 32 32' fill='none' style='display:block;'><path d='M16 3C16 3 13 8 13 12C13 15 16 17 16 17C16 17 19 15 19 12C19 8 16 3 16 3Z' fill='#FFA726'/><path d='M16 29C21.5228 29 26 24.5228 26 19C26 13.4772 19 7 16 3C13 7 6 13.4772 6 19C6 24.5228 10.4772 29 16 29Z' fill='#FF7043'/><path d='M16 25C18.2091 25 20 23.2091 20 21C20 19.3431 16 15 16 15C16 15 12 19.3431 12 21C12 23.2091 13.7909 25 16 25Z' fill='#FFD54F'/></svg>
                        </span>
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
                    <span id="clock-top-right" style="font-size:1.6rem; font-family:'Inter',sans-serif; color:#fff; font-weight: bold; border-radius:0.7rem; padding:0.3rem 1.2rem;">12:00 pm</span>
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
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">
                                <!-- Home/House -->
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 12L12 3l9 9"/><path d="M9 21V9h6v12"/></svg>
                            </span>
                            Home
                        </a>
                        <a href="{{ route('profile.edit') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">
                                <!-- User/Profile -->
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg>
                            </span>
                            Profile
                        </a>
                        <a href="{{ route('tasks.index') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">
                                <!-- Quests/Checklist -->
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"/><path d="M9 9h6M9 13h6M9 17h2"/></svg>
                            </span>
                            Quests
                        </a>
                        <a href="{{ route('leaderboard') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">
                                <!-- Leaderboard/Podium -->
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="9" y="8" width="6" height="12"/><rect x="3" y="14" width="6" height="6"/><rect x="15" y="12" width="6" height="8"/></svg>
                            </span>
                            Leaderboard
                        </a>
                        <a href="{{ route('achievements.index') }}" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">
                                <!-- Medal/Achievements -->
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"/><path d="M8.21 13.89l-2.39 4.14a1 1 0 0 0 1.37 1.37l4.14-2.39M15.79 13.89l2.39 4.14a1 1 0 0 1-1.37 1.37l-4.14-2.39"/></svg>
                            </span>
                            Achievements
                        </a>
                    </div>
                </div>
                <div style="padding:1.5rem 1.5rem 2.2rem 1.5rem;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button id="sidebar-logout-btn" type="submit" style="display:flex; align-items:center; gap:1.1rem; background:var(--secondary); color:var(--sidebar-text, var(--primary)); font-size:1.25rem; font-weight:bold; border-radius:0.7rem; padding:1.1rem 1.2rem; text-decoration:none; box-shadow:0 2px 8px #2d1c1c33; border:none; outline:none; cursor:pointer; opacity:0.7; width:100%; margin-top:0.7rem;">
                            <span style="font-size:2rem; display:flex; align-items:center; color:var(--sidebar-icon, var(--sidebar-text, var(--primary)));">
                                <!-- Logout/Arrow -->
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            </span>
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
                    <div style="font-size:1.65rem; font-weight:bold; color:var(--modal-header-bg); padding:0; background:none; box-shadow:none; border-radius:0;">
                        Create New Quest
                    </div>
                    <button id="close-add-quest" style="background:none; border:none; font-size:2.1rem; color:var(--modal-header-bg); cursor:pointer; margin-left:1.2rem; border-radius:0.5rem; transition:background 0.2s; width:2.3rem; height:2.3rem; display:flex; align-items:center; justify-content:center;" onmouseover="this.style.background='var(--highlight-bg)'" onmouseout="this.style.background='none'">&times;</button>
                </div>
                <form method="POST" action="{{ route('tasks.store') }}" style="width:100%; display:flex; flex-direction:row; gap:2.2rem; min-width:350px; max-width:600px;">
                    @csrf
                    <!-- Left Side: Title & Description -->
                    <div style="flex:1; display:flex; flex-direction:column; gap:1.2rem;">
                    <label for="quest-title" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Quest Title</label>
                        <input id="quest-title" type="text" name="title" required placeholder="Enter quest title..." style="font-size:1.1rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:var(--container-bg, #fff); color:var(--modal-text, #222); margin-bottom:0.7rem;">
                        <label for="quest-desc" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Quest Description <span style="color:#888; font-size:0.95em; font-weight:normal;">(Optional)</span></label>
                        <textarea id="quest-desc" name="description" placeholder="Describe your quest (optional)..." style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:var(--container-bg, #fff); color:var(--modal-text, #222); min-height:80px;"></textarea>
                    </div>
                    <!-- Right Side: Date, Time, Duration, Priority -->
                    <div style="flex:1; display:flex; flex-direction:column; gap:1.2rem;">
                        <label for="quest-date" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Date</label>
                        <input id="quest-date" type="date" name="due_date" style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222);" placeholder="dd/mm/yyyy">
                        <div style="color:#888; font-size:0.97em; margin-top:0.2em; margin-bottom:0.7em;">Leave blank if you haven't decided when to do this quest.</div>
                        <label for="quest-time" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Time</label>
                        <input id="quest-time" type="time" name="due_time" style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222);" placeholder="--:--">
                        <div style="color:#888; font-size:0.97em; margin-top:0.2em; margin-bottom:0.7em;">You can set a time later.</div>
                        <label style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Duration <span style="color:#888; font-size:0.95em; font-weight:normal;">(Optional)</span></label>
                        <div style="display:flex; gap:0.7rem; align-items:center;">
                            <input type="number" name="duration_hours" min="0" max="23" placeholder="Hours (optional)" style="width:70px; font-size:1.05rem; padding:0.7rem 0.7rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222);">
                            <span style="font-size:1.1rem; color:var(--modal-text, #222);">:</span>
                            <input type="number" name="duration_minutes" min="0" max="59" placeholder="Minutes (optional)" style="width:70px; font-size:1.05rem; padding:0.7rem 0.7rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222);">
                        </div>
                    <label for="quest-priority" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Priority</label>
                        <div style="position:relative; width:100%;">
                            <select id="quest-priority" name="priority" required style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222); width:100%; appearance:none; -webkit-appearance:none; -moz-appearance:none;">
                                <option value="low">🔵 Low</option>
                                <option value="medium" selected>🟠 Medium</option>
                                <option value="high">🔴 High</option>
                            </select>
                            <span style="position:absolute; right:1.2rem; top:50%; transform:translateY(-50%); pointer-events:none; font-size:1.1rem; color:#888;">▼</span>
                        </div>
                        <button type="submit" style="font-size:1.1rem; padding:0.9rem 2.2rem; width:100%; margin-top:0.7rem; background:#99C680 !important; color:var(--modal-btn-text, #fff); border-radius:0.7rem; border:none; font-weight:bold; box-shadow:2px 2px 8px #0002; cursor:pointer; transition:background 0.2s;">Create Quest</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Quest Modal -->
        <div id="edit-quest-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:6000; align-items:center; justify-content:center;">
            <div style="background:var(--modal-bg); color:var(--modal-text, #222); border-radius:1.5rem; box-shadow:0 6px 32px #0008; padding:2.2rem 2.2rem 2.2rem 2.2rem; min-width:370px; max-width:95vw; position:relative; display:flex; flex-direction:column; align-items:center;">
                <!-- Header Bar -->
                <div style="width:100%; display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
                    <div style="font-size:1.65rem; font-weight:bold; color:var(--modal-header-bg); padding:0; background:none; box-shadow:none; border-radius:0;">
                        Edit Quest
                    </div>
                    <button id="close-edit-quest" style="background:none; border:none; font-size:2.1rem; color:var(--modal-header-bg); cursor:pointer; margin-left:1.2rem; border-radius:0.5rem; transition:background 0.2s; width:2.3rem; height:2.3rem; display:flex; align-items:center; justify-content:center;" onmouseover="this.style.background='var(--highlight-bg)'" onmouseout="this.style.background='none'">&times;</button>
                </div>
                <form id="edit-quest-form" method="POST" style="width:100%; display:flex; flex-direction:row; gap:2.2rem; min-width:350px; max-width:600px;">
                    @csrf
                    @method('PUT')
                    <!-- Left Side: Title & Description -->
                    <div style="flex:1; display:flex; flex-direction:column; gap:1.2rem;">
                        <label for="edit-quest-title" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Quest Title</label>
                        <input id="edit-quest-title" type="text" name="title" required placeholder="Enter quest title..." style="font-size:1.1rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:var(--container-bg, #fff); color:var(--modal-text, #222); margin-bottom:0.7rem;">
                        <label for="edit-quest-desc" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Quest Description <span style="color:#888; font-size:0.95em; font-weight:normal;">(Optional)</span></label>
                        <textarea id="edit-quest-desc" name="description" placeholder="Describe your quest (optional)..." style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:var(--container-bg, #fff); color:var(--modal-text, #222); min-height:80px;"></textarea>
                    </div>
                    <!-- Right Side: Date, Time, Duration, Priority -->
                    <div style="flex:1; display:flex; flex-direction:column; gap:1.2rem;">
                        <label for="edit-quest-date" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Date</label>
                        <input id="edit-quest-date" type="date" name="due_date" style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222);" placeholder="dd/mm/yyyy">
                        <div style="color:#888; font-size:0.97em; margin-top:0.2em; margin-bottom:0.7em;">Leave blank if you haven't decided when to do this quest.</div>
                        <label for="edit-quest-time" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Time</label>
                        <input id="edit-quest-time" type="time" name="due_time" style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222);" placeholder="--:--">
                        <div style="color:#888; font-size:0.97em; margin-top:0.2em; margin-bottom:0.7em;">You can set a time later.</div>
                        <label style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Duration <span style="color:#888; font-size:0.95em; font-weight:normal;">(Optional)</span></label>
                        <div style="display:flex; gap:0.7rem; align-items:center;">
                            <input id="edit-duration-hours" type="number" name="duration_hours" min="0" max="23" placeholder="Hours (optional)" style="width:70px; font-size:1.05rem; padding:0.7rem 0.7rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222);">
                            <span style="font-size:1.1rem; color:var(--modal-text, #222);">:</span>
                            <input id="edit-duration-minutes" type="number" name="duration_minutes" min="0" max="59" placeholder="Minutes (optional)" style="width:70px; font-size:1.05rem; padding:0.7rem 0.7rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222);">
                        </div>
                        <label for="edit-quest-priority" style="font-weight:600; margin-bottom:0.2rem; color:var(--modal-text, #222);">Priority</label>
                        <div style="position:relative; width:100%;">
                            <select id="edit-quest-priority" name="priority" required style="font-size:1.05rem; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; background:#fff; color:var(--modal-text, #222); width:100%; appearance:none; -webkit-appearance:none; -moz-appearance:none;">
                                <option value="low">🟢 Low</option>
                                <option value="medium">🟠 Medium</option>
                                <option value="high">🔴 High</option>
                    </select>
                            <span style="position:absolute; right:1.2rem; top:50%; transform:translateY(-50%); pointer-events:none; font-size:1.1rem; color:#888;">▼</span>
                        </div>
                        <button type="submit" style="font-size:1.1rem; padding:0.9rem 2.2rem; width:100%; margin-top:0.7rem; background:#99C680 !important; color:var(--modal-btn-text, #fff); border-radius:0.7rem; border:none; font-weight:bold; box-shadow:2px 2px 8px #0002; cursor:pointer; transition:background 0.2s;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        @if(session('success'))
            <div id="toast-success"
                 style="position:fixed; top:2rem; left:50%; transform:translateX(-50%); background:#27ae60; color:#fff; font-size:1.18rem; font-weight:bold; padding:1.1rem 2.5rem; border-radius:0.8rem; box-shadow:0 4px 18px #0005; z-index:9999; transition:opacity 0.5s; letter-spacing:0.01em; text-align:center;">
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
                // Capitalize first letter (in case of future localization or changes)
                greeting = greeting.charAt(0).toUpperCase() + greeting.slice(1);
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
            // Edit Quest Modal logic
            var editQuestModal = document.getElementById('edit-quest-modal');
            var closeEditQuest = document.getElementById('close-edit-quest');
            if (closeEditQuest && editQuestModal) {
                closeEditQuest.onclick = function() {
                    editQuestModal.style.display = 'none';
                };
                editQuestModal.onclick = function(e) {
                    if (e.target === editQuestModal) {
                        editQuestModal.style.display = 'none';
                    }
                };
            }
            // Listen for edit button clicks
            document.querySelectorAll('.open-edit-quest-modal').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var quest = JSON.parse(this.getAttribute('data-quest'));
                    // Populate modal fields
                    document.getElementById('edit-quest-title').value = quest.title || '';
                    document.getElementById('edit-quest-desc').value = quest.description || '';
                    var dateInput = document.getElementById('edit-quest-date');
                    if (quest.due_date) {
                        // If already yyyy-mm-dd, use as is
                        if (/^\d{4}-\d{2}-\d{2}$/.test(quest.due_date)) {
                            dateInput.value = quest.due_date;
                        } else {
                            // fallback: try to parse and format
                            let d = new Date(quest.due_date);
                            if (!isNaN(d.getTime())) {
                                dateInput.value = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
                            } else {
                                dateInput.value = '';
                            }
                        }
                    } else {
                        dateInput.value = '';
                    }
                    var timeInput = document.getElementById('edit-quest-time');
                    if (quest.due_time) {
                        // Accepts HH:MM:SS or HH:MM
                        let t = quest.due_time;
                        if (t.length > 5) t = t.slice(0, 5);
                        timeInput.value = t;
                    } else {
                        timeInput.value = '';
                    }
                    document.getElementById('edit-duration-hours').value = quest.duration_hours || '';
                    document.getElementById('edit-duration-minutes').value = quest.duration_minutes || '';
                    document.getElementById('edit-quest-priority').value = quest.priority || 'medium';
                    // Set form action
                    document.getElementById('edit-quest-form').action = '/tasks/' + quest.id;
                    editQuestModal.style.display = 'flex';
                });
            });
        });
        </script>
    </body>
</html>
