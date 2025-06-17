<x-app-layout>
<div style="width:100vw; min-height:100vh; background:var(--background); color:var(--text); font-family:'Segoe UI',sans-serif; overflow-x: hidden;">
    <div style="max-width:1200px; margin:2.5rem auto; padding:0 2rem; box-sizing:border-box;">
        <div style="font-size:2rem; font-weight:bold; margin-bottom:2rem; color:var(--achievement-text); letter-spacing:0.01em;">🏆 Achievements</div>
        <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:2.2rem; justify-items:center; align-items:stretch;">
            @foreach($allAchievements as $achievement)
                @php
                    $isUnlocked = $userAchievements->has($achievement->id);
                    $claimed = $isUnlocked && $userAchievements[$achievement->id]->pivot->claimed_at;
                    $progress = 0;
                    if ($achievement->type === 'quests') {
                        if (in_array($achievement->name, ['Quest Novice', 'Quest Master'])) {
                        $progress = $isUnlocked ? $userAchievements[$achievement->id]->pivot->progress : $completedQuests;
                        } else {
                            $progress = $isUnlocked ? $userAchievements[$achievement->id]->pivot->progress : 0;
                        }
                    } elseif ($achievement->type === 'level') {
                        $progress = $isUnlocked ? $userAchievements[$achievement->id]->pivot->progress : $userLevel;
                    } elseif ($achievement->type === 'streak') {
                        $progress = $isUnlocked ? $userAchievements[$achievement->id]->pivot->progress : (Auth::user()->current_streak ?? 0);
                    }
                    $progressPercent = min(100, round((min($progress, $achievement->target) / $achievement->target) * 100));
                    $isActuallyUnlocked = $progress >= $achievement->target;
                @endphp
                <div style="background:var(--secondary); color:var(--text); border-radius:1.2rem; box-shadow:1px 1px 8px #0002; padding:2rem 2.5rem; width:320px; height:320px; min-width:260px; min-height:260px; max-width:340px; max-height:340px; display:flex; flex-direction:column; align-items:center; justify-content:center; position:relative; border:2px solid var(--primary); aspect-ratio:1/1;">
                    <div style="width:54px; height:54px; display:flex; align-items:center; justify-content:center; border-radius:0.7rem; background:var(--primary); color:var(--text); font-size:1.5rem; margin-bottom:1rem;">
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
                    <div style="font-size:1.3rem; font-weight:bold; margin-bottom:0.7rem; text-align:center; color:var(--achievement-text, var(--text));">{{ $achievement->name }}</div>
                    <div style="font-size:1.1rem; margin-bottom:0.7rem; text-align:center; color:var(--achievement-text, var(--text));">{{ $achievement->description }}</div>
                    <div style="width:100%; margin-bottom:0.7rem;">
                        <div style="background:var(--primary); border-radius:0.5rem; height:18px; width:100%; box-shadow:0 2px 8px var(--primary, #ffe066); position:relative;">
                            <div style="height:100%; border-radius:0.5rem; background:var(--exp-bar, #7ed957); width:{{ $progressPercent }}%; transition:width 0.5s;"></div>
                            <div style="position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:1rem; color:#fff; font-weight:bold;">{{ min($progress, $achievement->target) }}/{{ $achievement->target }}</div>
                        </div>
                    </div>
                    <div style="height:44px; display:flex; align-items:center; justify-content:center; width:100%;">
                        @if($isActuallyUnlocked)
                        @if($claimed)
                            <div style="position:absolute; top:1.2rem; right:1.5rem; background:#7aa2f7; color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; box-shadow:0 2px 8px #7aa2f7;">Claimed</div>
                        @else
                            <div style="position:absolute; top:1.2rem; right:1.5rem; background:#8fc97a; color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; box-shadow:0 2px 8px #8fc97a;">Unlocked</div>
                                <form method="POST" action="{{ route('achievements.claim', $achievement->id) }}" style="width:100%; display:flex; justify-content:center; align-items:center;">
                                @csrf
                                <button type="submit" style="background:#99C680; color:#fff; font-size:1.08rem; font-weight:bold; border:none; border-radius:0.7rem; padding:0.5rem 1.5rem; box-shadow:0 2px 8px #8fc97a; cursor:pointer; transition:background 0.2s;">Claim</button>
                            </form>
                        @endif
                    @else
                        <div style="position:absolute; top:1.2rem; right:1.5rem; background:#e74c3c; color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; box-shadow:0 2px 8px #e74c3c;">Locked</div>
                        <div style="position:absolute; inset:0; background:rgba(139,104,66,0.10); border-radius:1.2rem;"></div>
                    @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@if(session('rewards'))
    @php $rewards = session('rewards'); @endphp
    <div id="reward-modal" style="position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.35); z-index:9999; display:flex; align-items:center; justify-content:center;">
        <div style="background:#fffbe6; border-radius:1.2rem; box-shadow:0 4px 32px #0003; padding:2.5rem 2.5rem 2rem 2.5rem; min-width:340px; max-width:95vw; text-align:center; position:relative; display:flex; flex-direction:column; align-items:center;">
            <button onclick="document.getElementById('reward-modal').style.display='none'" style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:1.5rem; color:#654D48; cursor:pointer;">&times;</button>
            <div style="font-size:2rem; font-weight:bold; color:#654D48; margin-bottom:1.2rem;">🎉 Reward Unlocked!</div>
            <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%;">
            @if(isset($rewards['title']))
                <div style="margin-bottom:1.2rem;">
                    <div style="font-size:1.2rem; color:#654D48;">New Title:</div>
                    <div style="font-size:1.4rem; font-weight:bold; color:{{ $rewards['title']->color }};">{{ $rewards['title']->name }}</div>
                    <div style="font-size:1rem; color:#654D48;">{{ $rewards['title']->description }}</div>
                </div>
            @endif
            @if(isset($rewards['frame']))
                <div style="margin-bottom:1.2rem;">
                    <div style="font-size:1.2rem; color:#654D48;">New Avatar Frame:</div>
                    <img src="{{ asset($rewards['frame']->image_path) }}" alt="Frame" style="width:64px; height:64px; margin:0.5rem 0; display:block; margin-left:auto; margin-right:auto;">
                    <div style="font-size:1.1rem; color:#654D48;">{{ $rewards['frame']->name }}</div>
                    <div style="font-size:1rem; color:#654D48;">{{ $rewards['frame']->description }}</div>
                </div>
            @endif
            @if(isset($rewards['theme']))
                <div style="margin-bottom:1.2rem;">
                    <div style="font-size:1.2rem; color:#654D48;">New Theme:</div>
                    <div style="font-size:1.1rem; font-weight:bold; color:#4f8cff;">{{ $rewards['theme']->name }}</div>
                    <div style="font-size:1rem; color:#654D48;">{{ $rewards['theme']->description }}</div>
                </div>
            @endif
            </div>
            <button onclick="document.getElementById('reward-modal').style.display='none'" style="margin-top:1.5rem; background:#654D48; color:#fff; font-size:1.1rem; font-weight:bold; border:none; border-radius:0.7rem; padding:0.6rem 2.2rem; cursor:pointer;">Close</button>
        </div>
    </div>
@endif
</x-app-layout> 