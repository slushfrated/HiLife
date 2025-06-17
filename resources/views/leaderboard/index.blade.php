<x-app-layout>
<div style="width:100vw; min-height:100vh; background:var(--background); color:var(--text); font-family:'Inter',sans-serif; overflow-x: hidden;">
  <div style="max-width:1100px;margin:3rem auto 0 auto;">
    <div style="margin-bottom:2.5rem; display:flex; justify-content:center;">
      <span style="font-size:2.4rem; font-weight:bold; color:var(--tab-active-text, #654D48); letter-spacing:0.03em;">Leaderboard</span>
    </div>
    <div style="background:var(--container-bg, var(--secondary)); border-radius:1.2rem; padding:2.5rem 2.5rem 2.5rem 2.5rem; width:100%; display:flex; flex-direction:column; align-items:center; color:var(--text, #3a2c1a);">
      <div style="width:100%; display:flex; flex-direction:column; gap:1.2rem;">
        <!-- Current User Row -->
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
        <div style="display:flex; align-items:center; background:var(--leaderboard-card-highlight-bg, var(--highlight-bg)); border-radius:1rem; padding:0.5rem 2rem; box-shadow:0 2px 12px var(--highlight-border, #7aa2f7)33; font-size:1.25rem; font-weight:bold; gap:1.2rem; border:3px solid var(--highlight-border); margin-bottom:1.1rem; min-height:unset;">
          <div style="width:48px; height:48px; display:flex; align-items:center; justify-content:center; border-radius:0.7rem; background:{{ $isTop3 ? $iconBg : 'var(--primary)' }}; color:{{ $isTop3 ? '#4b3a2f' : '#fff' }}; font-size:2rem; font-weight:bold; margin-right:1.2rem;">
            @if($isTop3)
              {{ $icon }}
            @else
              {{ $currentRank }}
            @endif
          </div>
          <a href="{{ route('profile.show', $currentUser->id) }}">
            <div style="position: relative; width: 90px; height: 90px; display: flex; align-items: center; justify-content: center;">
              @php $isPng = Str::endsWith($currentUser->currentFrame->image_path ?? '', '.png'); @endphp
              <img src="{{ $currentUser->profile_picture ? asset('storage/' . $currentUser->profile_picture) : asset('default-avatar.png') }}" alt="Profile Picture" style="width: 53px; height: 53px; border-radius: 50%; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 1;">
              @if($currentUser->avatar_frame && $currentUser->currentFrame)
                <img src="{{ asset($currentUser->currentFrame->image_path) }}" alt="Avatar Frame" style="position: absolute; left: 50%; top: 50%; width: {{ $isPng ? '90px' : '64px' }}; height: {{ $isPng ? '90px' : '64px' }}; z-index: 2; pointer-events: none; transform: translate(-50%, -50%);">
              @endif
            </div>
          </a>
          <div style="flex:1; display:flex; align-items:center; gap:0.5rem;">
            <span style="color:var(--quest-card-text); font-size:1.2rem; font-weight:bold; transition:color 0.2s; cursor:pointer;" onmouseover="this.style.color='#7ed957'" onmouseout="this.style.color='var(--quest-card-text)';">
              <a href="{{ route('profile.show', $currentUser->id) }}" style="color:inherit; text-decoration:none;">{{ $currentUser->name ?? 'You' }}</a>
              @if($currentUser->currentTitleAchievement)
                <span style="font-size:1.05rem; font-weight:bold; margin-left:0.5rem; padding:0.18em 0.7em; border-radius:0.6em; background:var(--title-bg, #e6ffe6); color:var(--title-text, #2e7d32); display:inline-block;">{{ $currentUser->currentTitleAchievement->name }}</span>
              @endif
            </span>
            <div style="display:flex; gap:0.3rem; align-items:center;">
              @foreach($currentUser->achievements as $achievement)
                <span title="{{ $achievement->name }}">
                  @switch($achievement->icon)
                    @case('fire')
                      <svg width="24" height="24" viewBox="0 0 32 32" fill="none">
                        <path d="M16 3C16 3 13 8 13 12C13 15 16 17 16 17C16 17 19 15 19 12C19 8 16 3 16 3Z" fill="#FFA726"/>
                        <path d="M16 29C21.5228 29 26 24.5228 26 19C26 13.4772 19 7 16 3C13 7 6 13.4772 6 19C6 24.5228 10.4772 29 16 29Z" fill="#FF7043"/>
                        <path d="M16 25C18.2091 25 20 23.2091 20 21C20 19.3431 16 15 16 15C16 15 12 19.3431 12 21C12 23.2091 13.7909 25 16 25Z" fill="#FFD54F"/>
                      </svg>
                      @break
                    @case('checkmark')
                      <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="12" fill="#E8F5E9"/>
                        <path d="M9 16.2l-3.5-3.5 1.4-1.4L9 13.4l7.1-7.1 1.4 1.4z" fill="#4CAF50"/>
                      </svg>
                      @break
                    @case('bronze-medal')
                      <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="12" fill="#FFF3E0"/>
                        <circle cx="12" cy="12" r="8" fill="#cd7f32"/>
                        <rect x="10" y="4" width="4" height="8" rx="2" fill="#b87333"/>
                        <circle cx="12" cy="12" r="4" fill="#fff"/>
                      </svg>
                      @break
                    @case('trophy')
                      <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <rect x="7" y="3" width="10" height="4" rx="2" fill="#FFD700"/>
                        <rect x="9" y="7" width="6" height="7" rx="3" fill="#FFD700"/>
                        <rect x="10" y="14" width="4" height="2" rx="1" fill="#B8860B"/>
                        <rect x="8" y="16" width="8" height="2" rx="1" fill="#B8860B"/>
                        <ellipse cx="5" cy="7" rx="2" ry="4" fill="#FFD700"/>
                        <ellipse cx="19" cy="7" rx="2" ry="4" fill="#FFD700"/>
                      </svg>
                      @break
                    @case('arrow-up')
                      <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="12" fill="#E3F2FD"/>
                        <path d="M12 19V5M12 5l-6 6M12 5l6 6" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                      @break
                    @case('shield')
                      <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path d="M12 3l7 4v5c0 5.25-3.5 9.74-7 11-3.5-1.26-7-5.75-7-11V7l7-4z" fill="#90CAF9" stroke="#1976D2" stroke-width="2"/>
                      </svg>
                      @break
                    @default
                      <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="margin-bottom:1rem;">
                        <path d="M8 21h8M12 17v4M17 5V3H7v2M17 5a5 5 0 0 1 5 5v2a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V10a5 5 0 0 1 5-5h10z"/>
                      </svg>
                  @endswitch
                </span>
              @endforeach
            </div>
          </div>
          <span style="background:var(--exp-bar, #7ed957); color:#fff; font-size:1.1rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem;">{{ $currentUser->level ?? 1 }}</span>
          <span style="background:#f7b267; color:#fff; font-size:1.05rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem;">
            {{ ($currentUser->level - 1) * 100 + ($currentUser->exp ?? 0) }}
          </span>
          <span style="background:#f7b267; color:#fff; font-size:1.05rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem;">{{ $currentUser->current_streak ?? 0 }}</span>
        </div>
        @endif
        <!-- Header Row -->
        <div style="display:flex; align-items:center; background:transparent; font-size:1.1rem; font-weight:bold; color:var(--quest-card-text); gap:1.2rem; padding:0 2rem 0.5rem 2rem; border-bottom:2px solid var(--highlight-border, #7aa2f7);">
          <div style="width:48px; min-width:48px; height:40px;"></div>
          <div style="width:40px; min-width:40px; height:40px; margin-right:1rem;"></div>
          <span style="flex:1; color:var(--quest-card-text); font-size:1.2rem; display:flex; align-items:center; margin-left:3em;">Name</span>
          <span style="width:40px; min-width:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem; text-align:center;">Level</span>
          <span style="width:40px; min-width:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem; text-align:center;">Total EXP</span>
          <span style="width:40px; min-width:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem; text-align:center;">Streak</span>
        </div>
        @php
            // Helper to get total EXP
            function getTotalExp($user) {
                return ($user->level - 1) * 100 + ($user->exp ?? 0);
            }
        @endphp
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
          <div style="display:flex; align-items:center; background:{{ $isCurrentUser ? 'var(--leaderboard-card-highlight-bg, var(--highlight-bg))' : 'var(--leaderboard-card-bg)' }}; border-radius:1rem; padding:0.5rem 2rem; box-shadow:0 2px 8px #6e544540; font-size:1.25rem; font-weight:bold; gap:1.2rem; {{ $isCurrentUser ? 'border:3px solid var(--highlight-border); box-shadow:0 2px 12px var(--highlight-border)33;' : 'border:2.5px solid var(--highlight-border, #7aa2f7);' }}; color:var(--quest-card-text); min-height:unset;">
            <div style="width:48px; height:48px; display:flex; align-items:center; justify-content:center; border-radius:0.7rem; background:{{ $isTop3 ? $iconBg : 'var(--primary)' }}; color:{{ $isTop3 ? '#4b3a2f' : '#fff' }}; font-size:2rem; font-weight:bold; margin-right:1.2rem;">
              @if($isTop3)
                {{ $icon }}
              @else
                {{ $rank }}
              @endif
            </div>
            <a href="{{ route('profile.show', $user->id) }}">
              <div style="position: relative; width: 90px; height: 90px; display: flex; align-items: center; justify-content: center;">
                @php $isPng = Str::endsWith($user->currentFrame->image_path ?? '', '.png'); @endphp
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default-avatar.png') }}" alt="Profile Picture" style="width: 53px; height: 53px; border-radius: 50%; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 1;">
                @if($user->avatar_frame && $user->currentFrame)
                  <img src="{{ asset($user->currentFrame->image_path) }}" alt="Avatar Frame" style="position: absolute; left: 50%; top: 50%; width: {{ $isPng ? '90px' : '64px' }}; height: {{ $isPng ? '90px' : '64px' }}; z-index: 2; pointer-events: none; transform: translate(-50%, -50%);">
                @endif
              </div>
            </a>
            <div style="flex:1; display:flex; align-items:center; gap:0.5rem;">
              <span style="color:var(--quest-card-text); font-size:1.2rem; font-weight:bold; transition:color 0.2s; cursor:pointer;" onmouseover="this.style.color='#7ed957'" onmouseout="this.style.color='var(--quest-card-text)';">
                <a href="{{ route('profile.show', $user->id) }}" style="color:inherit; text-decoration:none;">{{ $user->name }}</a>
                @if($user->currentTitleAchievement)
                  <span style="font-size:1.05rem; font-weight:bold; margin-left:0.5rem; padding:0.18em 0.7em; border-radius:0.6em; background:var(--title-bg, #e6ffe6); color:var(--title-text, #2e7d32); display:inline-block;">{{ $user->currentTitleAchievement->name }}</span>
                @endif
              </span>
              <div style="display:flex; gap:0.3rem; align-items:center;">
                @foreach($user->achievements as $achievement)
                  <span title="{{ $achievement->name }}">
                    @switch($achievement->icon)
                      @case('fire')
                        <svg width="24" height="24" viewBox="0 0 32 32" fill="none">
                          <path d="M16 3C16 3 13 8 13 12C13 15 16 17 16 17C16 17 19 15 19 12C19 8 16 3 16 3Z" fill="#FFA726"/>
                          <path d="M16 29C21.5228 29 26 24.5228 26 19C26 13.4772 19 7 16 3C13 7 6 13.4772 6 19C6 24.5228 10.4772 29 16 29Z" fill="#FF7043"/>
                          <path d="M16 25C18.2091 25 20 23.2091 20 21C20 19.3431 16 15 16 15C16 15 12 19.3431 12 21C12 23.2091 13.7909 25 16 25Z" fill="#FFD54F"/>
                        </svg>
                        @break
                      @case('checkmark')
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <circle cx="12" cy="12" r="12" fill="#E8F5E9"/>
                          <path d="M9 16.2l-3.5-3.5 1.4-1.4L9 13.4l7.1-7.1 1.4 1.4z" fill="#4CAF50"/>
                        </svg>
                        @break
                      @case('bronze-medal')
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <circle cx="12" cy="12" r="12" fill="#FFF3E0"/>
                          <circle cx="12" cy="12" r="8" fill="#cd7f32"/>
                          <rect x="10" y="4" width="4" height="8" rx="2" fill="#b87333"/>
                          <circle cx="12" cy="12" r="4" fill="#fff"/>
                        </svg>
                        @break
                      @case('trophy')
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <rect x="7" y="3" width="10" height="4" rx="2" fill="#FFD700"/>
                          <rect x="9" y="7" width="6" height="7" rx="3" fill="#FFD700"/>
                          <rect x="10" y="14" width="4" height="2" rx="1" fill="#B8860B"/>
                          <rect x="8" y="16" width="8" height="2" rx="1" fill="#B8860B"/>
                          <ellipse cx="5" cy="7" rx="2" ry="4" fill="#FFD700"/>
                          <ellipse cx="19" cy="7" rx="2" ry="4" fill="#FFD700"/>
                        </svg>
                        @break
                      @case('arrow-up')
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <circle cx="12" cy="12" r="12" fill="#E3F2FD"/>
                          <path d="M12 19V5M12 5l-6 6M12 5l6 6" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        @break
                      @case('shield')
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <path d="M12 3l7 4v5c0 5.25-3.5 9.74-7 11-3.5-1.26-7-5.75-7-11V7l7-4z" fill="#90CAF9" stroke="#1976D2" stroke-width="2"/>
                        </svg>
                        @break
                      @default
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="margin-bottom:1rem;">
                          <path d="M8 21h8M12 17v4M17 5V3H7v2M17 5a5 5 0 0 1 5 5v2a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V10a5 5 0 0 1 5-5h10z"/>
                        </svg>
                    @endswitch
                  </span>
                @endforeach
              </div>
            </div>
            <span style="background:var(--exp-bar, #7ed957); color:#fff; font-size:1.1rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem;">{{ $user->level }}</span>
            <span style="background:#f7b267; color:#fff; font-size:1.05rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem;">
              {{ ($user->level - 1) * 100 + ($user->exp ?? 0) }}
            </span>
            <span style="background:#f7b267; color:#fff; font-size:1.05rem; font-weight:bold; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; margin-right:0.7rem;">{{ $user->current_streak ?? 0 }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
</x-app-layout> 