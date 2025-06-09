<x-app-layout>
<a href="{{ route('leaderboard') }}" style="position:fixed; left:calc(50% - 350px - 18rem); top:8.5rem; background:var(--container-bg,#DFEDD7); color:var(--tab-active-text,#654D48); border-radius:0.7rem; padding:0.5rem 1.3rem; font-size:1.1rem; font-weight:bold; box-shadow:0 2px 8px #0002; text-decoration:none; display:inline-flex; align-items:center; gap:0.7rem; z-index:100; transition:background 0.2s;">
    <span style="font-size:1.3rem;">←</span> Back to Leaderboard
</a>
<div style="max-width:700px; margin:7.5rem auto 0 auto; background:var(--container-bg); border-radius:1.2rem; box-shadow:0 2px 16px #0001; padding:2.5rem 2.5rem 2.5rem 2.5rem; color:var(--text); position:relative;">
    <div style="display:flex; align-items:center; gap:2rem; margin-bottom:2.5rem;">
        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default-avatar.png') }}" alt="Profile Picture" style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid #fff; box-shadow:0 2px 8px #0002;">
        <div style="flex:1;">
            <div style="font-size:2.1rem; font-weight:bold; color:var(--tab-active-text, #654D48);">{{ $user->name }}</div>
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
    <div style="margin-top:2.5rem;">
        <div style="font-size:1.2rem; font-weight:bold; color:var(--tab-active-text,#654D48); margin-bottom:1rem;">Achievements</div>
        <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:1.5rem; justify-items:stretch; align-items:stretch; width:100%;">
            @forelse($achievements as $achievement)
                <div style="background:var(--secondary,#fffbe6); color:var(--achievement-text,#654D48); border-radius:0.9rem; box-shadow:0 2px 8px #0001; padding:1.2rem 1.3rem; width:100%; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:flex-start;">
                    <div style="width:38px; height:38px; display:flex; align-items:center; justify-content:center; border-radius:0.7rem; background:var(--primary,#ffe066); color:var(--text,#fff); font-size:1.2rem; margin-bottom:0.7rem; flex-shrink:0; flex-grow:0;">
                        <img src="/icons/medal.png" alt="icon" style="width:24px; height:24px; opacity:1;">
                    </div>
                    <div style="font-size:1.08rem; font-weight:bold; text-align:center; color:var(--achievement-text,#654D48); margin-bottom:0.3rem; min-height:2.2em; display:flex; align-items:center; justify-content:center;">{{ $achievement->name }}</div>
                    <div style="font-size:0.98rem; text-align:center; color:var(--achievement-text,#654D48);">{{ $achievement->description }}</div>
                </div>
            @empty
                <span style="color:#aaa;">No achievements yet.</span>
            @endforelse
        </div>
    </div>
</div>
</x-app-layout> 