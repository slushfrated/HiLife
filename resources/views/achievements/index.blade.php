<x-app-layout>
<div style="width:100vw; min-height:100vh; background:var(--background); color:var(--text); font-family:'Segoe UI',sans-serif; overflow-x: hidden;">
    <div style="max-width:1200px; margin:2.5rem auto; padding:0 2rem; box-sizing:border-box;">
        <div style="font-size:2rem; font-weight:bold; margin-bottom:2rem; color:var(--achievement-text); letter-spacing:0.01em;">🏆 Achievements</div>
        <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:2.2rem; justify-items:center; align-items:stretch;">
            @foreach($allAchievements as $achievement)
                @php
                    $isUnlocked = $userAchievements->has($achievement->id);
                    $progress = 0;
                    if ($achievement->type === 'quests') {
                        $progress = $isUnlocked ? $userAchievements[$achievement->id]->pivot->progress : $completedQuests;
                    } elseif ($achievement->type === 'level') {
                        $progress = $isUnlocked ? $userAchievements[$achievement->id]->pivot->progress : $userLevel;
                    } elseif ($achievement->type === 'streak') {
                        $progress = $isUnlocked ? $userAchievements[$achievement->id]->pivot->progress : (Auth::user()->current_streak ?? 0);
                    }
                    $progressPercent = min(100, round((min($progress, $achievement->target) / $achievement->target) * 100));
                @endphp
                <div style="background:var(--secondary); color:var(--text); border-radius:1.2rem; box-shadow:1px 1px 8px #0002; padding:2rem 2.5rem; width:320px; height:320px; min-width:260px; min-height:260px; max-width:340px; max-height:340px; display:flex; flex-direction:column; align-items:center; justify-content:center; position:relative; border:2px solid var(--primary); aspect-ratio:1/1;">
                    <div style="width:54px; height:54px; display:flex; align-items:center; justify-content:center; border-radius:0.7rem; background:var(--primary); color:var(--text); font-size:1.5rem; margin-bottom:1rem;">
                        @if($achievement->type === 'streak')
                            <span style="font-size:2.5rem;">🔥</span>
                        @else
                            <img src="/icons/medal.png" alt="icon" style="width:32px; height:32px; opacity:{{ $isUnlocked ? '1' : '0.5' }};">
                        @endif
                    </div>
                    <div style="font-size:1.3rem; font-weight:bold; margin-bottom:0.7rem; text-align:center; color:var(--achievement-text);">{{ $achievement->name }}</div>
                    <div style="font-size:1.1rem; margin-bottom:0.7rem; text-align:center; color:var(--achievement-text);">{{ $achievement->description }}</div>
                    <div style="width:100%; margin-bottom:0.7rem;">
                        <div style="background:var(--primary); border-radius:0.5rem; height:18px; width:100%; box-shadow:0 2px 8px var(--primary, #ffe066); position:relative;">
                            <div style="height:100%; border-radius:0.5rem; background:var(--exp-bar, #7ed957); width:{{ $progressPercent }}%; transition:width 0.5s;"></div>
                            <div style="position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:1rem; color:#fff; font-weight:bold;">{{ min($progress, $achievement->target) }}/{{ $achievement->target }}</div>
                        </div>
                    </div>
                    @if($isUnlocked)
                        <div style="position:absolute; top:1.2rem; right:1.5rem; background:#8fc97a; color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; box-shadow:0 2px 8px #8fc97a;">Unlocked</div>
                    @else
                        <div style="position:absolute; top:1.2rem; right:1.5rem; background:#e74c3c; color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; box-shadow:0 2px 8px #e74c3c;">Locked</div>
                        <div style="position:absolute; inset:0; background:rgba(139,104,66,0.10); border-radius:1.2rem;"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout> 