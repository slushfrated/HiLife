<x-app-layout>
<div style="width:100vw; min-height:100vh; background:var(--background); color:var(--text); font-family:'Segoe UI',sans-serif; overflow-x: hidden;">
  <div style="max-width:1100px;margin:3rem auto 0 auto;">
    <div style="margin-bottom:2.5rem; display:flex; justify-content:center;">
      <span style="font-size:2.4rem; font-weight:bold; color:var(--tab-active-text, #654D48); letter-spacing:0.03em;">Leaderboard</span>
    </div>
    <div style="background:var(--container-bg, var(--secondary)); border-radius:1.2rem; padding:2.5rem 2.5rem 2.5rem 2.5rem; width:100%; display:flex; flex-direction:column; align-items:center; color:#3a2c1a;">
      <div style="width:100%; display:flex; flex-direction:column; gap:1.2rem;">
        <!-- Current User Row -->
        @php $currentUser = Auth::user(); @endphp
        @if($currentUser)
        @php
          $currentRank = $users->search(fn($u) => $u->id === $currentUser->id) + 1;
          $isTop3 = $currentRank <= 3;
          $icon = '🏆';
          $iconBg = '#fff';
          if ($currentRank === 1) { $icon = '🏆'; $iconBg = '#ffe066'; }
          elseif ($currentRank === 2) { $icon = '🥈'; $iconBg = '#e0e0e0'; }
          elseif ($currentRank === 3) { $icon = '🥉'; $iconBg = '#cfa97e'; }
        @endphp
        <div style="display:flex; align-items:center; background:var(--leaderboard-card-highlight-bg, var(--highlight-bg)); border-radius:1rem; padding:1.2rem 2rem; box-shadow:0 2px 12px var(--highlight-border, #7aa2f7)33; font-size:1.25rem; font-weight:bold; gap:1.2rem; border:3px solid var(--highlight-border); margin-bottom:1.5rem;">
          <div style="width:48px; height:48px; display:flex; align-items:center; justify-content:center; border-radius:0.7rem; background:{{ $isTop3 ? $iconBg : 'var(--primary)' }}; color:{{ $isTop3 ? '#4b3a2f' : '#fff' }}; font-size:2rem; font-weight:bold; margin-right:1.2rem;">
            @if($isTop3)
              {{ $icon }}
            @else
              {{ $currentRank }}
            @endif
          </div>
          <a href="{{ route('profile.show', $currentUser->id) }}">
            <img src="{{ $currentUser->profile_picture ? asset('storage/' . $currentUser->profile_picture) : asset('default-avatar.png') }}" alt="Profile Picture" style="width:40px; height:40px; border-radius:50%; object-fit:cover; margin-right:1rem; border:2px solid #fff; transition:box-shadow 0.2s;">
          </a>
          <span style="flex:1; color:var(--quest-card-text); font-size:1.2rem; font-weight:bold; transition:color 0.2s; cursor:pointer;" onmouseover="this.style.color='#7ed957'" onmouseout="this.style.color='var(--quest-card-text)';">
            <a href="{{ route('profile.show', $currentUser->id) }}" style="color:inherit; text-decoration:none;">{{ $currentUser->name ?? 'You' }}</a>
          </span>
          <span style="background:var(--exp-bar, #7ed957); color:#fff; font-size:1.1rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem;">{{ $currentUser->level ?? 1 }}</span>
          <span style="background:#f7b267; color:#fff; font-size:1.05rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">{{ $currentUser->exp ?? 0 }}</span>
        </div>
        @endif
        <!-- Header Row -->
        <div style="display:flex; align-items:center; background:transparent; font-size:1.1rem; font-weight:bold; color:var(--quest-card-text); gap:1.2rem; padding:0 2rem 0.5rem 2rem; border-bottom:2px solid var(--highlight-border, #7aa2f7);">
          <div style="width:48px; min-width:48px; height:40px;"></div>
          <div style="width:40px; min-width:40px; height:40px; margin-right:1rem;"></div>
          <span style="flex:1; color:var(--quest-card-text); font-size:1.2rem; display:flex; align-items:center; margin-left:18px;">Name</span>
          <span style="width:40px; min-width:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem; text-align:center;">Level</span>
          <span style="width:40px; min-width:40px; display:flex; align-items:center; justify-content:center; text-align:center;">EXP</span>
        </div>
        @foreach($users as $i => $user)
          @php
            $rank = $i + 1;
            $isTop3 = $rank <= 3;
            $icon = '🏆';
            $iconBg = '#fff';
            if ($rank === 1) { $icon = '🏆'; $iconBg = '#ffe066'; }
            elseif ($rank === 2) { $icon = '🥈'; $iconBg = '#e0e0e0'; }
            elseif ($rank === 3) { $icon = '🥉'; $iconBg = '#cfa97e'; }
            $isCurrentUser = $currentUser && $user->id === $currentUser->id;
          @endphp
          <div style="display:flex; align-items:center; background:{{ $isCurrentUser ? 'var(--leaderboard-card-highlight-bg, var(--highlight-bg))' : 'var(--leaderboard-card-bg)' }}; border-radius:1rem; padding:1.2rem 2rem; box-shadow:0 2px 8px #6e544540; font-size:1.25rem; font-weight:bold; gap:1.2rem; {{ $isCurrentUser ? 'border:3px solid var(--highlight-border); box-shadow:0 2px 12px var(--highlight-border)33;' : 'border:2.5px solid var(--highlight-border, #7aa2f7);' }}; color:var(--quest-card-text);">
            <div style="width:48px; height:48px; display:flex; align-items:center; justify-content:center; border-radius:0.7rem; background:{{ $isTop3 ? $iconBg : 'var(--primary)' }}; color:{{ $isTop3 ? '#4b3a2f' : '#fff' }}; font-size:2rem; font-weight:bold; margin-right:1.2rem;">
              @if($isTop3)
                {{ $icon }}
              @else
                {{ $rank }}
              @endif
            </div>
            <a href="{{ route('profile.show', $user->id) }}">
              <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default-avatar.png') }}" alt="Profile Picture" style="width:40px; height:40px; border-radius:50%; object-fit:cover; margin-right:1rem; border:2px solid #fff; transition:box-shadow 0.2s;">
            </a>
            <span style="flex:1; color:var(--quest-card-text); font-size:1.2rem; font-weight:bold; transition:color 0.2s; cursor:pointer;" onmouseover="this.style.color='#7ed957'" onmouseout="this.style.color='var(--quest-card-text)';">
              <a href="{{ route('profile.show', $user->id) }}" style="color:inherit; text-decoration:none;">{{ $user->name }}</a>
            </span>
            <span style="background:var(--exp-bar, #7ed957); color:#fff; font-size:1.1rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem;">{{ $user->level }}</span>
            <span style="background:#f7b267; color:#fff; font-size:1.05rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">{{ $user->exp }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
</x-app-layout> 