<x-app-layout>
<div style="position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(139,104,66,0.95); backdrop-filter:blur(2px); z-index:1000;">
    @if(session('success'))
        <div id="toast-success"
             style="position:fixed; top:2rem; right:2.5rem; background:#e74c3c; color:#fff; font-size:1.2rem; padding:1rem 2.5rem; border-radius:0.7rem; box-shadow:0 2px 8px #6e5445; z-index:9999; transition:opacity 0.5s;"
        >
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
    <!-- Dynamic Greeting Navbar -->
    <div style="background:#6e5445; padding:1.2rem 0 1.2rem 0; display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100vw; z-index:1001;">
        <div style="flex:1; display:flex; align-items:center;">
            <span id="greeting-text" style="font-size:1.5rem; font-family:serif; color:#fff; letter-spacing:0.03em; margin-left:2.5rem;">Good morning, {{ Auth::user()->name ?? 'Grindmaster' }}!</span>
        </div>
        <div style="flex:2; display:flex; justify-content:center; align-items:center;">
            <div style="width:420px; max-width:90vw; background:#e89a9a; color:#fff; border-radius:1.2rem; font-size:1.2rem; font-family:serif; letter-spacing:0.05em; box-shadow:0 4px 16px #6e5445a0; padding:0.7rem 1.5rem; display:flex; align-items:center; gap:1.2rem;">
                <span style="font-weight:bold;">Level {{ Auth::user()->level }}</span>
                <div style="flex:1; height:12px; background:#fff; border-radius:6px; margin:0 1rem; box-shadow:0 1px 4px #e89a9a55; overflow:hidden;">
                    <div style="width:{{ Auth::user()->getExpProgress() }}%; height:100%; background:linear-gradient(90deg,#4CAF50,#8fc97a); border-radius:6px;"></div>
                </div>
                <span style="font-weight:bold;">{{ Auth::user()->exp }}/{{ Auth::user()->level * 100 }} EXP</span>
            </div>
        </div>
        <div style="flex:1;"></div>
    </div>
    <div style="height:84px;"></div>
    <div style="display:flex; height:100vh;">
        <!-- Sidebar -->
        <div style="flex:0 0 320px; background:#4b3a2f; display:flex; flex-direction:column; align-items:center; padding-top:3rem;">
            <div id="clock-top-left" style="color:#fff; font-size:2rem; margin-bottom:2.5rem; letter-spacing:0.05em;">00:00</div>
            <button id="filter-all" style="width:90%; font-size:1.3rem; font-family:'Comic Sans MS',cursive; background:#d2c1ad; color:#4b3a2f; border-radius:0.6rem; border:4px solid #cfc1ad; margin-bottom:1.5rem; padding:0.7rem 0; font-weight:bold;">All</button>
            <button id="filter-daily" style="width:90%; font-size:1.3rem; font-family:'Comic Sans MS',cursive; background:none; color:#fff; border-radius:0.6rem; border:4px solid #cfc1ad; margin-bottom:1.5rem; padding:0.7rem 0;">Daily Quests</button>
            <button id="filter-side" style="width:90%; font-size:1.3rem; font-family:'Comic Sans MS',cursive; background:none; color:#fff; border-radius:0.6rem; border:4px solid #cfc1ad; margin-bottom:1.5rem; padding:0.7rem 0;">Side Quests</button>
            <button id="filter-achievements" style="width:90%; font-size:1.3rem; font-family:'Comic Sans MS',cursive; background:none; color:#fff; border-radius:0.6rem; border:4px solid #cfc1ad; margin-bottom:1.5rem; padding:0.7rem 0;">Achievements</button>
        </div>
        <!-- Main Quests List -->
        <div id="main-quests-list" style="flex:1; padding:3rem 2rem; display:flex; flex-direction:column;">
            <!-- Tabs and Back Button Row -->
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
                <div style="display:flex; gap:2rem;">
                    <button id="tab-active" class="quest-tab" style="background:#fff; color:#4b3a2f; font-weight:bold; font-size:1.2rem; border:none; border-radius:0.7rem 0.7rem 0 0; padding:0.7rem 2.5rem; box-shadow:0 2px 8px #6e5445; cursor:pointer;">Active Quests</button>
                    <button id="tab-completed" class="quest-tab" style="background:#d2c1ad; color:#4b3a2f; font-weight:bold; font-size:1.2rem; border:none; border-radius:0.7rem 0.7rem 0 0; padding:0.7rem 2.5rem; box-shadow:0 2px 8px #6e5445; cursor:pointer;">Completed Quests</button>
                </div>
                <a href="{{ route('dashboard') }}" style="text-decoration:none;">
                    <button style="background:#fff; color:#4b3a2f; border:none; border-radius:50%; width:48px; height:48px; font-size:2rem; font-weight:bold; box-shadow:0 2px 8px #6e5445; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background 0.2s;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;"><line x1="19" y1="12" x2="5" y2="12" stroke="#4b3a2f" stroke-width="2.5" stroke-linecap="round"/><polyline points="9,7 4,12 9,17" fill="none" stroke="#4b3a2f" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </a>
            </div>
            <!-- Quest Lists -->
            <div id="active-list" style="overflow-y:auto; max-height:80vh; padding:0 0 3rem 0; padding-right:1rem;">
                <div id="daily-section">
                    {{-- Show just completed system quest for fade-out --}}
                    @if(session('just_completed_system_task_id'))
                        <div class="quest-item completed-quest" style="background:#fdf6d8; color:#4b3a2f; border-radius:0.7rem; margin-bottom:2rem; box-shadow:2px 2px 8px #6e5445; padding:1.2rem 2rem; font-size:1.4rem; display:flex; align-items:center; justify-content:space-between; border-left:8px solid #ffe066; opacity:1;">
                            <div style="font-family:'Comic Sans MS',cursive; display:flex; align-items:center; gap:0.7rem;">
                                <span style="background:#ffe066; color:#b8860b; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 0.8rem; margin-right:0.5rem; display:flex; align-items:center; gap:0.3rem; box-shadow:0 2px 8px #ffe066;">✨ Daily</span>
                                {{ session('just_completed_system_task_title') }}
                            </div>
                            <span style="color:#8fc97a; font-size:1.1rem; margin-left:1rem; font-family:sans-serif;">Completed!</span>
                        </div>
                    @endif
                    {{-- Daily (system) quests box --}}
                    <div style="background:rgba(255,255,255,0.07); border-radius:1.2rem; padding:2.5rem 2.5rem 2.5rem 2.5rem; margin-bottom:0; min-height:120px; position:relative;">
                        <span id="label-daily" style="display:block; position:absolute; top:1.2rem; left:2rem; background:#ffe066; color:#b8860b; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; font-family:'Comic Sans MS',cursive; box-shadow:0 2px 8px #ffe066; letter-spacing:0.03em; margin-bottom:1.2rem;">Daily Quests</span>
                        @php $hasSystem = false; $systemCount = 0; $firstSystem = true; @endphp
                        @foreach($activeTasks as $task)
                            @if($task->source == 'system')
                                @php $hasSystem = true; $systemCount++; @endphp
                                <div class="quest-item{{ $task->is_completed ? ' just-completed' : '' }}"
                                     data-task-id="{{ $task->id }}"
                                     data-completed="{{ $task->is_completed ? 'true' : 'false' }}"
                                     style="background:#fdf6d8; color:#4b3a2f; border-radius:0.7rem; {{ $firstSystem ? 'margin-top:2.2rem;' : '' }} margin-bottom:0.7rem; box-shadow:2px 2px 8px #6e5445; padding:1.2rem 2rem; font-size:1.4rem; display:flex; align-items:center; justify-content:space-between; border-left:8px solid #ffe066;">
                                    <div style="font-family:'Comic Sans MS',cursive; display:flex; align-items:center; gap:0.7rem;">
                                        <span style="background:#ffe066; color:#b8860b; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 0.8rem; margin-right:0.5rem; display:flex; align-items:center; gap:0.3rem; box-shadow:0 2px 8px #ffe066;">✨ Daily</span>
                                        {{ $task->title }}
                                        @if($task->description)
                                            <span style="color:#b28b67; font-size:1.1rem; margin-left:1rem; font-family:sans-serif;">{{ $task->description }}</span>
                                        @endif
                                        @if($task->deadline)
                                            @php $isOverdue = !$task->is_completed && \Carbon\Carbon::parse($task->deadline)->isPast(); @endphp
                                            <span style="display:inline-block; margin-left:1rem; font-size:1.1rem; font-weight:bold; color:{{ $isOverdue ? '#e74c3c' : '#b8860b' }}; background:{{ $isOverdue ? '#fbeaea' : '#fffbe6' }}; border-radius:0.5rem; padding:0.2rem 0.8rem;">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y H:i') }}@if($isOverdue) (Overdue)@endif</span>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline; margin-left:0.5rem;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_completed" value="1">
                                        <button type="submit" style="background:#8fc97a; color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.3rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem;">✅</button>
                                    </form>
                                </div>
                                @php $firstSystem = false; @endphp
                            @endif
                        @endforeach
                        @if($systemCount === 0)
                            <div style="color:#fff; margin-bottom:2rem; font-size:1.3rem; display:flex; align-items:center; justify-content:center; font-family:'Comic Sans MS',cursive; font-weight:bold; margin-top:2.2rem;">
                                Congratulations, you have completed all daily quests!
                            </div>
                        @endif
                    </div>
                    <div style="height:1px; background:#b28b67; margin:2.2rem 0 2.2rem 0; border-radius:1px;"></div>
                </div>
                <div id="side-section">
                    {{-- User (side) quests box --}}
                    <div style="background:rgba(255,255,255,0.07); border-radius:1.2rem; padding:2.5rem 2.5rem 2.5rem 2.5rem; min-height:120px; position:relative;">
                        <span id="label-side" style="display:block; position:absolute; top:1.2rem; left:2rem; background:#d2c1ad; color:#4b3a2f; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; font-family:'Comic Sans MS',cursive; box-shadow:0 2px 8px #cfc1ad; letter-spacing:0.03em; margin-bottom:1.2rem;">Side Quests</span>
                        @php $userCount = 0; $firstUser = true; @endphp
                        @foreach($activeTasks as $task)
                            @if($task->source == 'user')
                                @php $userCount++; @endphp
                                <div class="quest-item{{ $task->is_completed ? ' just-completed' : '' }}"
                                     data-task-id="{{ $task->id }}"
                                     data-completed="{{ $task->is_completed ? 'true' : 'false' }}"
                                     style="background:#f5e6d8; color:#4b3a2f; border-radius:0.7rem; {{ $firstUser ? 'margin-top:2.2rem;' : '' }} margin-bottom:0.7rem; box-shadow:2px 2px 8px #6e5445; padding:1.2rem 2rem; font-size:1.4rem; display:flex; align-items:center; justify-content:space-between;">
                                    <div style="font-family:'Comic Sans MS',cursive; display:flex; align-items:center; gap:0.7rem;">
                                        {{ $task->title }}
                                        @if($task->description)
                                            <span style="color:#b28b67; font-size:1.1rem; margin-left:1rem; font-family:sans-serif;">{{ $task->description }}</span>
                                        @endif
                                        @if($task->deadline)
                                            @php $isOverdue = !$task->is_completed && \Carbon\Carbon::parse($task->deadline)->isPast(); @endphp
                                            <span style="display:inline-block; margin-left:1rem; font-size:1.1rem; font-weight:bold; color:{{ $isOverdue ? '#e74c3c' : '#b8860b' }}; background:{{ $isOverdue ? '#fbeaea' : '#fffbe6' }}; border-radius:0.5rem; padding:0.2rem 0.8rem;">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y H:i') }}@if($isOverdue) (Overdue)@endif</span>
                                        @endif
                                    </div>
                                    <div style="display:flex; align-items:center; gap:0.3rem;">
                                        <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_completed" value="1">
                                            <button type="submit" style="background:#8fc97a; color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.3rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem;">✅</button>
                                        </form>
                                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:#e74c3c; color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.3rem; display:flex; align-items:center; justify-content:center; cursor:pointer;">🗑️</button>
                                        </form>
                                    </div>
                                </div>
                                @php $firstUser = false; @endphp
                            @endif
                        @endforeach
                        @if($userCount === 0)
                            <div style="color:#fff; margin-bottom:2rem; font-size:1.3rem; display:flex; align-items:center; justify-content:center; font-family:'Comic Sans MS',cursive; font-weight:bold; margin-top:2.2rem;">
                                No active quests
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div id="completed-list" style="display:none; overflow-y:auto; max-height:70vh; padding-right:1rem;">
                @foreach($completedTasks as $task)
                    <div style="background:{{ $task->source === 'system' ? '#fdf6d8' : '#e0d3c2' }}; color:#aaa; border-radius:0.7rem; margin-bottom:2rem; box-shadow:2px 2px 8px #6e5445; padding:1.2rem 2rem; font-size:1.4rem; display:flex; align-items:center; justify-content:space-between; opacity:0.7;{{ $task->source === 'system' ? ' border-left:8px solid #ffe066;' : '' }}">
                        <div style="font-family:'Comic Sans MS',cursive; text-decoration:line-through; display:flex; align-items:center; gap:0.7rem;">
                            @if($task->source == 'system')
                                <span style="background:#ffe066; color:#b8860b; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 0.8rem; margin-right:0.5rem; display:flex; align-items:center; gap:0.3rem; box-shadow:0 2px 8px #ffe066;">✨ System</span>
                            @endif
                            {{ $task->title }}
                            @if($task->deadline)
                                <span style="display:inline-block; margin-left:1rem; font-size:1.1rem; font-weight:bold; color:#b8860b; background:#fffbe6; border-radius:0.5rem; padding:0.2rem 0.8rem;">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y H:i') }}</span>
                            @endif
                        </div>
                        <span style="font-size:1.1rem; color:#8fc97a;">Completed</span>
                    </div>
                @endforeach
            </div>
            <script>
                const tabActive = document.getElementById('tab-active');
                const tabCompleted = document.getElementById('tab-completed');
                const activeList = document.getElementById('active-list');
                const completedList = document.getElementById('completed-list');
                tabActive.onclick = function() {
                    tabActive.style.background = '#fff';
                    tabCompleted.style.background = '#d2c1ad';
                    activeList.style.display = '';
                    completedList.style.display = 'none';
                };
                tabCompleted.onclick = function() {
                    tabActive.style.background = '#d2c1ad';
                    tabCompleted.style.background = '#fff';
                    activeList.style.display = 'none';
                    completedList.style.display = '';
                };
            </script>
        </div>
        <!-- Achievements Modal/Section -->
        <div id="achievements-section" style="display:none; flex:1; padding:3rem 2rem; flex-direction:column;">
            <div style="font-size:2rem; font-family:'Comic Sans MS',cursive; font-weight:bold; margin-bottom:2rem; color:#ffe066;">Achievements</div>
            @php
                $allAchievements = \App\Models\Achievement::all();
                $userAchievements = auth()->user()->achievements->keyBy('id');
                $completedQuests = auth()->user()->tasks()->where('is_completed', true)->count();
                $userLevel = auth()->user()->level;
            @endphp
            <div style="display:flex; flex-wrap:wrap; gap:2rem;">
                @foreach($allAchievements as $achievement)
                    @php
                        $isUnlocked = $userAchievements->has($achievement->id);
                        $progress = 0;
                        if ($achievement->type === 'quests') {
                            $progress = $isUnlocked ? $userAchievements[$achievement->id]->pivot->progress : $completedQuests;
                        } elseif ($achievement->type === 'level') {
                            $progress = $isUnlocked ? $userAchievements[$achievement->id]->pivot->progress : $userLevel;
                        }
                        $progressPercent = min(100, round(($progress / $achievement->target) * 100));
                    @endphp
                    <div style="background:{{ $isUnlocked ? '#fffbe6' : '#b28b67' }}; color:#4b3a2f; border-radius:1.2rem; box-shadow:2px 2px 8px #6e5445; padding:2rem 2.5rem; min-width:260px; min-height:210px; display:flex; flex-direction:column; align-items:center; justify-content:center; position:relative; border:4px solid {{ $isUnlocked ? '#ffe066' : '#cfc1ad' }};">
                        @if($achievement->icon)
                            <img src="/icons/{{ $achievement->icon }}" alt="icon" style="width:54px; height:54px; margin-bottom:1rem; opacity:{{ $isUnlocked ? '1' : '0.5' }};">
                        @else
                            <span style="font-size:2.5rem; margin-bottom:1rem;">🏆</span>
                        @endif
                        <div style="font-size:1.3rem; font-weight:bold; margin-bottom:0.7rem; text-align:center;">{{ $achievement->name }}</div>
                        <div style="font-size:1.15rem; color:#4b3a2f; font-weight:bold; background:#fffbe6; border-radius:0.5rem; padding:0.5rem 1.1rem; margin-bottom:0.7rem; text-align:center; box-shadow:0 2px 8px #ffe066; display:inline-block;">{{ $achievement->description }}</div>
                        <div style="width:100%; margin-bottom:0.7rem;">
                            <div style="background:#e0d3c2; border-radius:0.5rem; height:18px; width:100%; box-shadow:0 2px 8px #ffe066; position:relative;">
                                <div style="height:100%; border-radius:0.5rem; background:{{ $isUnlocked ? '#8fc97a' : '#ffe066' }}; width:{{ $progressPercent }}%; transition:width 0.5s;"></div>
                                <div style="position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:1rem; color:#4b3a2f; font-weight:bold;">{{ $progress }}/{{ $achievement->target }}</div>
                            </div>
                        </div>
                        @if($isUnlocked)
                            <div style="position:absolute; top:1.2rem; right:1.5rem; background:#8fc97a; color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; box-shadow:0 2px 8px #8fc97a;">Unlocked</div>
                        @else
                            <div style="position:absolute; top:1.2rem; right:1.5rem; background:#e74c3c; color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; box-shadow:0 2px 8px #e74c3c;">Locked</div>
                            <div style="position:absolute; inset:0; background:rgba(139,104,66,0.15); border-radius:1.2rem;"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtering logic
        const btnAll = document.getElementById('filter-all');
        const btnDaily = document.getElementById('filter-daily');
        const btnSide = document.getElementById('filter-side');
        const btnAchievements = document.getElementById('filter-achievements');
        const dailySection = document.getElementById('daily-section');
        const sideSection = document.getElementById('side-section');
        const separator = document.getElementById('section-separator');
        const mainQuestsList = document.getElementById('main-quests-list');
        const achievementsSection = document.getElementById('achievements-section');

        function setFilter(type) {
            btnAll.style.background = type === 'all' ? '#d2c1ad' : 'none';
            btnAll.style.color = type === 'all' ? '#4b3a2f' : '#fff';
            btnDaily.style.background = type === 'daily' ? '#ffe066' : 'none';
            btnDaily.style.color = type === 'daily' ? '#b8860b' : '#fff';
            btnSide.style.background = type === 'side' ? '#d2c1ad' : 'none';
            btnSide.style.color = type === 'side' ? '#4b3a2f' : '#fff';

            if (type === 'all') {
                dailySection.style.display = '';
                sideSection.style.display = '';
                separator.style.display = '';
            } else if (type === 'daily') {
                dailySection.style.display = '';
                sideSection.style.display = 'none';
                separator.style.display = 'none';
            } else if (type === 'side') {
                dailySection.style.display = 'none';
                sideSection.style.display = '';
                separator.style.display = 'none';
            }
        }
        btnAll.onclick = function() {
            mainQuestsList.style.display = '';
            achievementsSection.style.display = 'none';
            setFilter('all');
            btnAchievements.style.background = 'none';
            btnAchievements.style.color = '#fff';
        };
        btnDaily.onclick = function() {
            mainQuestsList.style.display = '';
            achievementsSection.style.display = 'none';
            setFilter('daily');
            btnAchievements.style.background = 'none';
            btnAchievements.style.color = '#fff';
        };
        btnSide.onclick = function() {
            mainQuestsList.style.display = '';
            achievementsSection.style.display = 'none';
            setFilter('side');
            btnAchievements.style.background = 'none';
            btnAchievements.style.color = '#fff';
        };
        btnAchievements.onclick = function() {
            mainQuestsList.style.display = 'none';
            achievementsSection.style.display = 'flex';
            btnAchievements.style.background = '#ffe066';
            btnAchievements.style.color = '#b8860b';
            btnAll.style.background = 'none';
            btnAll.style.color = '#fff';
            btnDaily.style.background = 'none';
            btnDaily.style.color = '#fff';
            btnSide.style.background = 'none';
            btnSide.style.color = '#fff';
        };
        // Default to All
        setFilter('all');

        // Fade out completed quests after 3 seconds (dashboard style)
        document.querySelectorAll('.quest-item.completed-quest').forEach(function(el) {
            setTimeout(function() {
                el.style.transition = 'opacity 0.7s';
                el.style.opacity = '0';
                setTimeout(function() {
                    el.remove();
                }, 700);
            }, 3000); // 3 seconds
        });

        // Handle form submissions
        document.querySelectorAll('form[action*="/tasks/"]').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                if (this.querySelector('input[name="is_completed"]')) {
                    e.preventDefault();
                    const taskItem = this.closest('.quest-item');
                    taskItem.classList.add('just-completed');
                    taskItem.setAttribute('data-completed', 'true');
                    
                    // Submit the form after a short delay
                    setTimeout(() => {
                        this.submit();
                    }, 100);
                }
            });
        });
    });

    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.querySelectorAll('.date-box, .time-box, .clock-top-left').forEach(function(el) {
            if (el.classList.contains('clock-top-left')) {
                el.textContent = `${hours}:${minutes}`;
            }
        });
        const clockEl = document.getElementById('clock-top-left');
        if (clockEl) {
            clockEl.textContent = `${hours}:${minutes}`;
        }
    }
    setInterval(updateClock, 1000);
    updateClock();

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
</script>
@endpush
</x-app-layout> 