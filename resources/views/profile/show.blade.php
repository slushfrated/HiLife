<x-app-layout>
<a href="{{ route('leaderboard') }}" style="position:fixed; left:calc(50% - 350px - 18rem); top:8.5rem; background:var(--container-bg,#DFEDD7); color:var(--tab-active-text,#654D48); border-radius:0.7rem; padding:0.5rem 1.3rem; font-size:1.1rem; font-weight:bold; box-shadow:0 2px 8px #0002; text-decoration:none; display:inline-flex; align-items:center; gap:0.7rem; z-index:100; transition:background 0.2s;">
    <span style="font-size:1.3rem;">←</span> Back to Leaderboard
</a>
<div style="max-width:700px; margin:7.5rem auto 0 auto; background:var(--container-bg); border-radius:1.2rem; box-shadow:0 2px 16px #0001; padding:1.2rem 1.2rem 1.2rem 1.2rem; color:var(--text); position:relative;">
    <div style="display:flex; align-items:center; gap:2rem; margin-bottom:2.5rem;">
        @php $isPng = isset($user->currentFrame) && Str::endsWith($user->currentFrame->image_path ?? '', '.png');
            $frameSize = $isPng ? 170 : 120;
        @endphp
        <div style="position: relative; width: {{ $frameSize }}px; height: {{ $frameSize }}px; display: flex; align-items: center; justify-content: center;">
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default-avatar.png') }}" 
                 alt="Profile Picture" 
                 style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid #fff; box-shadow:0 2px 8px #0002; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 1;">
            @if($user->avatar_frame && $user->currentFrame)
                <img src="{{ asset($user->currentFrame->image_path) }}" 
                     alt="Avatar Frame" 
                     style="position: absolute; left: 50%; top: 50%; width: {{ $frameSize }}px; height: {{ $frameSize }}px; z-index: 2; pointer-events: none; transform: translate(-50%, -50%);">
            @endif
        </div>
        <div style="flex:1;">
            <div style="font-size:2.1rem; font-weight:bold; color:var(--tab-active-text, #654D48);">{{ $user->name }}</div>
            @if($user->currentTitleAchievement)
                <div style="font-size:1.1rem; font-weight:bold; margin-top:0.2rem; display:inline-block; padding:0.18em 0.7em; border-radius:0.6em; background:var(--title-bg, #e6ffe6); color:var(--title-text, #2e7d32);">{{ $user->currentTitleAchievement->name }}</div>
            @endif
            <div style="display:flex; align-items:center; gap:1.2rem; margin-top:0.7rem;">
                <div style="width:260px; height:2.1rem; background:rgba(255,255,255,0.18); border-radius:1.2rem; position:relative; box-shadow:0 2px 8px #6e544540; display:flex; align-items:center;">
                    <div style="width:{{ min(100, round(($user->exp / max(1, $user->level * 100)) * 100)) }}%; background:var(--exp-bar, #DD7A7A); height:100%; border-radius:1.2rem; transition:width 0.4s;"></div>
                    <div style="position:absolute; left:0; top:0; width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-weight:bold; color:#fff; font-size:1.08rem; letter-spacing:0.03em;">
                        EXP: {{ $user->exp }} / {{ $user->level * 100 }}
                    </div>
                </div>
                <div style="width:48px; height:48px; background:var(--level-circle-bg, #DD7A7A); color:var(--level-circle-text, #fff); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.3rem; font-family:serif; font-weight:bold; box-shadow:0 1px 6px #6e5445a0; border:4px solid var(--container-bg, #ECEDDF); margin-left:-36px; z-index:1;">
                    {{ $user->level }}
                </div>
            </div>
        </div>
    </div>
    <div style="display:flex; flex-wrap:wrap; gap:2.5rem; margin-bottom:2.5rem;">
        <div style="flex:1; min-width:180px; background:var(--leaderboard-card-bg,#DFEDD7); border-radius:1rem; padding:1.2rem 1.5rem; box-shadow:0 2px 8px #0001; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
            <div style="font-size:1.1rem; color:var(--tab-active-text,#654D48); font-weight:bold; margin-bottom:0.2rem; word-break:break-word; white-space:normal; line-height:1.2; min-height:2.2em; display:flex; align-items:center; justify-content:center; text-align:center;">Completed Quests</div>
            <div style="font-size:2.1rem; font-weight:bold; color:var(--exp-bar,#7ed957); margin-top:0.5rem;">{{ $completedQuests }}</div>
        </div>
        <div style="flex:1; min-width:180px; background:var(--leaderboard-card-bg,#DFEDD7); border-radius:1rem; padding:1.2rem 1.5rem; box-shadow:0 2px 8px #0001; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
            <div style="font-size:1.1rem; color:var(--tab-active-text,#654D48); font-weight:bold; margin-bottom:0.2rem; word-break:break-word; white-space:normal; line-height:1.2; min-height:2.2em; display:flex; align-items:center; justify-content:center; text-align:center;">Achievements</div>
            <div style="font-size:2.1rem; font-weight:bold; color:var(--exp-bar,#7ed957); margin-top:0.5rem;">{{ $achievements->count() }}</div>
        </div>
        <div style="flex:1; min-width:180px; background:var(--leaderboard-card-bg,#DFEDD7); border-radius:1rem; padding:1.2rem 1.5rem; box-shadow:0 2px 8px #0001; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
            <div style="font-size:1.1rem; color:var(--tab-active-text,#654D48); font-weight:bold; margin-bottom:0.2rem; word-break:break-word; white-space:normal; line-height:1.2; min-height:2.2em; display:flex; align-items:center; justify-content:center; text-align:center;">Current Streak</div>
            <div style="font-size:2.1rem; font-weight:bold; color:var(--exp-bar,#7ed957); margin-top:0.5rem;">{{ $currentStreak }}</div>
        </div>
        <div style="flex:1; min-width:180px; background:var(--leaderboard-card-bg,#DFEDD7); border-radius:1rem; padding:1.2rem 1.5rem; box-shadow:0 2px 8px #0001; display:flex; flex-direction:column; align-items:center;">
            <div style="font-size:1.1rem; color:var(--tab-active-text,#654D48); font-weight:bold; margin-bottom:0.5rem;">Longest Streak</div>
            <div style="font-size:2.1rem; font-weight:bold; color:var(--exp-bar,#7ed957);">{{ $longestStreak }}</div>
        </div>
    </div>
    <!-- Unlocked Achievements Section -->
    <div style="margin-top:2.5rem;">
        <div style="font-size:1.2rem; font-weight:bold; color:var(--tab-active-text,#654D48); margin-bottom:1rem;">Unlocked Achievements</div>
        <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:1.5rem;">
            @forelse($achievements as $achievement)
                @php
                    $iconMap = [
                        'First Quest Complete' => 'icons/badge-first-quest.svg',
                        'Quest Novice' => 'icons/badge-quest-novice.svg',
                        'Quest Master' => 'icons/badge-quest-master.svg',
                        'Level Up!' => 'icons/badge-level-up.svg',
                        'Veteran' => 'icons/badge-veteran.svg',
                        '7-Day Streak' => 'icons/badge-fire.svg',
                    ];
                    $iconPath = isset($iconMap[$achievement->name]) ? asset($iconMap[$achievement->name]) : asset('icons/checkmark.png');
                @endphp
                <div style="background:var(--secondary,#fffbe6); color:var(--achievement-text,#654D48); border-radius:1rem; box-shadow:0 2px 8px #0001; padding:1.2rem 1.3rem; display:flex; flex-direction:column; align-items:center; justify-content:flex-start; min-height:180px;">
                    <div style="width:48px; height:48px; display:flex; align-items:center; justify-content:center; border-radius:0.7rem; background:var(--primary); color:var(--text); font-size:1.5rem; margin-bottom:0.7rem;">
                        @switch($achievement->icon)
                            @case('fire')
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M16 3C16 3 13 8 13 12C13 15 16 17 16 17C16 17 19 15 19 12C19 8 16 3 16 3Z" fill="#FFA726"/>
                                    <path d="M16 29C21.5228 29 26 24.5228 26 19C26 13.4772 19 7 16 3C13 7 6 13.4772 6 19C6 24.5228 10.4772 29 16 29Z" fill="#FF7043"/>
                                    <path d="M16 25C18.2091 25 20 23.2091 20 21C20 19.3431 16 15 16 15C16 15 12 19.3431 12 21C12 23.2091 13.7909 25 16 25Z" fill="#FFD54F"/>
                                </svg>
                                @break
                            @case('plus-circle')
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" fill="#E3F2FD"/>
                                    <path d="M12 8v8M8 12h8" stroke="#2196F3" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                @break
                            @case('calendar-check')
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                                    <rect x="3" y="4" width="18" height="18" rx="2" fill="#E8F5E9"/>
                                    <path d="M16 2v4M8 2v4M3 10h18M9 16l2 2 4-4" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                @break
                            @case('checkmark')
                                <svg width="32" height="32" fill="none" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="12" fill="#E8F5E9"/>
                                    <path d="M9 16.2l-3.5-3.5 1.4-1.4L9 13.4l7.1-7.1 1.4 1.4z" fill="#4CAF50"/>
                                </svg>
                                @break
                            @case('bronze-medal')
                                <svg width="32" height="32" fill="none" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="12" fill="#FFF3E0"/>
                                    <circle cx="12" cy="12" r="8" fill="#cd7f32"/>
                                    <rect x="10" y="4" width="4" height="8" rx="2" fill="#b87333"/>
                                    <circle cx="12" cy="12" r="4" fill="#fff"/>
                                </svg>
                                @break
                            @case('trophy')
                                <svg width="32" height="32" fill="none" viewBox="0 0 24 24">
                                    <rect x="7" y="3" width="10" height="4" rx="2" fill="#FFD700"/>
                                    <rect x="9" y="7" width="6" height="7" rx="3" fill="#FFD700"/>
                                    <rect x="10" y="14" width="4" height="2" rx="1" fill="#B8860B"/>
                                    <rect x="8" y="16" width="8" height="2" rx="1" fill="#B8860B"/>
                                    <ellipse cx="5" cy="7" rx="2" ry="4" fill="#FFD700"/>
                                    <ellipse cx="19" cy="7" rx="2" ry="4" fill="#FFD700"/>
                                </svg>
                                @break
                            @case('arrow-up')
                                <svg width="32" height="32" fill="none" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="12" fill="#E3F2FD"/>
                                    <path d="M12 19V5M12 5l-6 6M12 5l6 6" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                @break
                            @case('shield')
                                <svg width="32" height="32" fill="none" viewBox="0 0 24 24">
                                    <path d="M12 3l7 4v5c0 5.25-3.5 9.74-7 11-3.5-1.26-7-5.75-7-11V7l7-4z" fill="#90CAF9" stroke="#1976D2" stroke-width="2"/>
                                </svg>
                                @break
                            @default
                                <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="margin-bottom:1rem;">
                                    <path d="M8 21h8M12 17v4M17 5V3H7v2M17 5a5 5 0 0 1 5 5v2a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V10a5 5 0 0 1 5-5h10z"/>
                                </svg>
                        @endswitch
                    </div>
                    <div style="font-size:1.08rem; font-weight:bold; text-align:center; color:var(--achievement-text,#654D48); margin-bottom:0.3rem; min-height:2.2em; display:flex; align-items:center; justify-content:center;">{{ $achievement->name }}</div>
                    <div style="font-size:0.98rem; text-align:center; color:var(--achievement-text,#654D48); margin-bottom:0.5rem;">{{ $achievement->description }}</div>
                </div>
            @empty
                <span style="color:#aaa;">No achievements unlocked yet.</span>
            @endforelse
        </div>
    </div>
</div>
</x-app-layout> 