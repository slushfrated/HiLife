<x-app-layout>
<div style="width:100vw; min-height:100vh; background:var(--background); color:var(--text); font-family:'Segoe UI',sans-serif; overflow-x: hidden;">
    <!-- Main container -->
    <div style="width:100%; max-width:1200px; margin:2.5rem auto; padding:0 2rem; box-sizing:border-box; background:var(--background); display:flex; flex-direction:row; align-items:flex-start; gap:2.5rem; overflow:visible;">
        <!-- Vertical Filter Buttons -->
        <div style="display:flex; flex-direction:column; gap:1.2rem; min-width:120px; align-items:stretch; margin-top:2.5rem;">
            <button id="filter-all" style="background:var(--tab-active-bg, #fff); color:var(--tab-active-text, #4b3a2f); font-weight:bold; font-size:1.1rem; border:2.5px solid var(--highlight-border, transparent); border-radius:0.7rem; padding:0.8rem 0; box-shadow:0 2px 8px var(--highlight-border, transparent); cursor:pointer; transition:background 0.2s, border 0.2s, box-shadow 0.2s;">All</button>
            <button id="filter-daily" style="background:var(--tab-inactive-bg, #d2c1ad); color:var(--tab-inactive-text, #4b3a2f); font-weight:bold; font-size:1.1rem; border:2.5px solid transparent; border-radius:0.7rem; padding:0.8rem 0; box-shadow:none; cursor:pointer; transition:background 0.2s, border 0.2s, box-shadow 0.2s;">Daily</button>
            <button id="filter-personal" style="background:var(--tab-inactive-bg, #d2c1ad); color:var(--tab-inactive-text, #4b3a2f); font-weight:bold; font-size:1.1rem; border:2.5px solid transparent; border-radius:0.7rem; padding:0.8rem 0; box-shadow:none; cursor:pointer; transition:background 0.2s, border 0.2s, box-shadow 0.2s;">Personal</button>
        </div>
        <!-- Quest Content -->
        <div style="flex:1; min-width:0;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
                <div style="display:flex; gap:2rem;">
                    <button id="tab-active" class="quest-tab" style="background:var(--tab-active-bg, #fff); color:var(--tab-active-text, #4b3a2f); font-weight:bold; font-size:1.2rem; border:2.5px solid var(--highlight-border, transparent); border-radius:0.7rem 0.7rem 0 0; padding:0.7rem 2.5rem; box-shadow:0 2px 8px var(--highlight-border, transparent); cursor:pointer;">Active Quests</button>
                    <button id="tab-completed" class="quest-tab" style="background:var(--tab-inactive-bg, #d2c1ad); color:var(--tab-inactive-text, #4b3a2f); font-weight:bold; font-size:1.2rem; border:2.5px solid transparent; border-radius:0.7rem 0.7rem 0 0; padding:0.7rem 2.5rem; box-shadow:none; cursor:pointer;">Completed Quests</button>
                </div>
                <button id="add-quest-top-btn" style="background:var(--primary, #7aa2f7); color:#fff; font-size:1.1rem; font-weight:bold; border:none; border-radius:0.7rem; padding:0.5rem 1.5rem; box-shadow:0 2px 8px #6e5445; cursor:pointer; display:flex; align-items:center; gap:0.7rem; transition:background 0.2s;">
                    <span style="font-size:1.3rem; font-weight:bold;">+</span> Add New Quest
                </button>
            </div>
            <!-- Quest Lists -->
            <div id="active-list" style="overflow-y:auto; max-height:80vh; padding:0 0 3rem 0; padding-right:1rem;">
                <div id="daily-section">
                    <!-- Show just completed system quest for fade-out -->
                    @if(session('just_completed_system_task_id'))
                        <div class="quest-item completed-quest" style="background:var(--highlight-bg, #fdf6d8); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; margin-bottom:2rem; box-shadow:2px 2px 8px #6e5445; padding:1.2rem 2rem; font-size:1.4rem; display:flex; align-items:center; justify-content:space-between; border-left:8px solid var(--highlight-border, #ffe066); opacity:1;">
                            <div style="font-family:'Comic Sans MS',cursive; display:flex; align-items:center; gap:0.7rem;">
                                <span style="background:#ffe066; color:#b8860b; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 0.8rem; margin-right:0.5rem; display:flex; align-items:center; gap:0.3rem; box-shadow:0 2px 8px #ffe066;">✨ Daily</span>
                                Daily quest completed!
                            </div>
                            <span style="color:#8fc97a; font-size:1.1rem; margin-left:1rem; font-family:sans-serif;">Completed!</span>
                        </div>
                    @endif
                    <!-- Daily (system) quests box -->
                    <div style="background:var(--quest-container-bg, #fffbe6); border-radius:1.1rem; box-shadow:1px 1px 6px #6e544520; padding:1.2rem 1.2rem 1.2rem 1.2rem; margin-bottom:2.2rem;">
                        <span style="display:inline-block; background:var(--quest-section-bg, #fffbe6); color:var(--quest-section-text, #b8860b); font-size:0.93rem; font-weight:600; border-radius:0.5rem; padding:0.08rem 0.8rem 0.04rem 0.8rem; box-shadow:0 1px 4px #ffe06633; font-family:'Segoe UI',sans-serif; letter-spacing:0.01em; border:1px solid var(--quest-section-border, #ffe066); margin-bottom:0.1rem; margin-left:0.1rem;">★ Daily Quests</span>
                        <div style="padding:1.7rem 1.2rem 1.2rem 1.2rem; margin-top:0.3rem;">
                            @php $hasSystem = false; $systemCount = 0; $firstSystem = true; @endphp
                            @foreach($activeTasks as $task)
                                @if($task->source == 'system')
                                    @php $hasSystem = true; $systemCount++; @endphp
                                    <div class="quest-item" style="background:var(--quest-card-bg, #e7d6b8); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:none; border:2.5px solid var(--highlight-border, #7aa2f7); padding:1.2rem 2rem; font-size:1.1rem; display:flex; align-items:center; justify-content:space-between; margin-bottom:0.7rem; font-family:'Segoe UI',sans-serif;">
                                        <div style="display:flex; flex-direction:column; gap:0.3rem; flex-grow:1; margin-right:1rem; font-family:'Segoe UI',sans-serif;">
                                            <div style="display:flex; align-items:center; gap:0.5rem;">
                                                @if($task->source == 'system')
                                                    <span style="background:var(--quest-badge-bg-daily, #99D877); color:var(--quest-badge-text-daily, #183408); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; font-family:'Segoe UI',sans-serif;">★ Daily</span>
                                                    <span style="font-weight:bold; font-family:'Segoe UI',sans-serif;">{{ $task->title }}</span>
                                                @else
                                                    <span style="background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; font-family:'Segoe UI',sans-serif;">● Personal</span>
                                                    <span style="font-weight:bold; font-family:'Segoe UI',sans-serif;">{{ $task->title }}</span>
                                                @endif
                                            </div>
                                            <div style="display:flex; align-items:center; gap:0.7rem; flex-wrap:wrap; margin-top:0.2rem;">
                                                <div style="background:var(--quest-desc-bg, #fffbe6); color:var(--quest-desc-text, #4b3a2f); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; max-width:50%; word-break:break-word; white-space:normal; font-size:1.08rem; font-family:'Segoe UI',sans-serif; font-weight:500;">
                                                    {{ $task->description }}
                                                </div>
                                                @php
                                                    $isOverdue = !$task->is_completed && \Carbon\Carbon::now('Asia/Jakarta')->gt(\Carbon\Carbon::parse($task->deadline, 'Asia/Jakarta'));
                                                    $expAmount = $task->source === 'user' ? ($isOverdue ? 20 : 50) : 50;
                                                @endphp
                                                @if($task->source == 'user' && $task->deadline)
                                                    <span style="display:inline-block; font-size:1.05rem; font-weight:bold; color:{{ $isOverdue ? '#fff' : 'var(--quest-deadline-text, #b8860b)' }}; background:{{ $isOverdue ? '#e74c3c' : 'var(--quest-deadline-bg, #fffbe6)' }}; border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Segoe UI',sans-serif;">
                                                        Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y H:i') }}
                                                        @if($isOverdue)
                                                            <span style="margin-left:0.5rem; background:#fff; color:#e74c3c; border-radius:0.4rem; padding:0.1rem 0.5rem; font-size:0.95em; font-weight:bold;">Overdue!</span>
                                                        @endif
                                                    </span>
                                                @endif
                                                <span style="font-weight:bold; font-family:'Segoe UI',sans-serif;">
                                                    {{ $task->title }}
                                                    <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Segoe UI',sans-serif; margin-left:0.5rem;">+{{ $expAmount }} EXP</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div style="display:flex; gap:0.5rem;">
                                            <form action="{{ route('tasks.complete', $task->id) }}" method="POST" style="margin:0;">
                                                @csrf
                                                <button type="submit" style="background:var(--quest-btn-complete, #8fc97a); color:var(--quest-btn-text, #fff); border:none; border-radius:50%; width:36px; height:36px; font-size:1.3rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem;">✅</button>
                                            </form>
                                        </div>
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
                    </div>
                    <div style="height:1px; background:var(--highlight-border, #7aa2f7); margin:2.2rem 0 2.2rem 0; border-radius:1px;"></div>
                </div>
                <div id="side-section">
                    <!-- User (side) quests box -->
                    <div style="background:var(--quest-container-bg, #f5e6d8); border-radius:1.1rem; box-shadow:1px 1px 6px #6e544520; padding:1.2rem 1.2rem 1.2rem 1.2rem; margin-bottom:2.2rem;">
                        <span style="display:inline-block; background:var(--quest-section-bg, #f7f3ef); color:var(--quest-section-text, #4b3a2f); font-size:0.93rem; font-weight:600; border-radius:0.5rem; padding:0.08rem 0.8rem 0.04rem 0.8rem; box-shadow:0 1px 4px #cfc1ad33; font-family:'Segoe UI',sans-serif; letter-spacing:0.01em; border:1px solid var(--quest-section-border, #e5ded6); margin-bottom:0.1rem; margin-left:0.1rem;">● Personal</span>
                        <div style="padding:1.7rem 1.2rem 1.2rem 1.2rem; margin-top:0.3rem;">
                            @php $userCount = 0; $firstUser = true; @endphp
                            @foreach($activeTasks as $task)
                                @if($task->source == 'user')
                                    @php $userCount++; @endphp
                                    <div class="quest-item" style="background:var(--quest-card-bg, #e7d6b8); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:none; border:2.5px solid var(--highlight-border, #7aa2f7); padding:1.2rem 2rem; font-size:1.1rem; display:flex; align-items:center; justify-content:space-between; margin-bottom:0.7rem; font-family:'Segoe UI',sans-serif;">
                                        <div style="display:flex; flex-direction:column; gap:0.3rem; flex-grow:1; margin-right:1rem; font-family:'Segoe UI',sans-serif;">
                                            <div style="display:flex; align-items:center; gap:0.5rem;">
                                                @if($task->source == 'system')
                                                    <span style="background:var(--quest-badge-bg-daily, #99D877); color:var(--quest-badge-text-daily, #183408); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; font-family:'Segoe UI',sans-serif;">★ Daily</span>
                                                    <span style="font-weight:bold; font-family:'Segoe UI',sans-serif;">{{ $task->title }}</span>
                                                @else
                                                    <span style="background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; font-family:'Segoe UI',sans-serif;">● Personal</span>
                                                    <span style="font-weight:bold; font-family:'Segoe UI',sans-serif;">
                                                        @if($task->priority === 'high')
                                                            <span style="background:#E74C3C; color:#fff; font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem;">High</span>
                                                        @elseif($task->priority === 'medium')
                                                            <span style="background:#F5A623; color:#fff; font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem;">Medium</span>
                                                        @elseif($task->priority === 'low')
                                                            <span style="background:#4A90E2; color:#fff; font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem;">Low</span>
                                                        @endif
                                                        {{ $task->title }}
                                                        <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Segoe UI',sans-serif; margin-left:0.5rem;">+{{ $expAmount }} EXP</span>
                                                    </span>
                                                @endif
                                            </div>
                                            <div style="display:flex; align-items:center; gap:0.7rem; flex-wrap:wrap; margin-top:0.2rem;">
                                                <div style="background:var(--quest-desc-bg, #fffbe6); color:var(--quest-desc-text, #4b3a2f); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; max-width:50%; word-break:break-word; white-space:normal; font-size:1.08rem; font-family:'Segoe UI',sans-serif; font-weight:500;">
                                                    {{ $task->description }}
                                                </div>
                                                @php
                                                    $isOverdue = !$task->is_completed && \Carbon\Carbon::now('Asia/Jakarta')->gt(\Carbon\Carbon::parse($task->deadline, 'Asia/Jakarta'));
                                                    $expAmount = $task->source === 'user' ? ($isOverdue ? 20 : 50) : 50;
                                                @endphp
                                                @if($task->source == 'user' && $task->deadline)
                                                    <span style="display:inline-block; font-size:1.05rem; font-weight:bold; color:{{ $isOverdue ? '#fff' : 'var(--quest-deadline-text, #b8860b)' }}; background:{{ $isOverdue ? '#e74c3c' : 'var(--quest-deadline-bg, #fffbe6)' }}; border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Segoe UI',sans-serif;">
                                                        Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y H:i') }}
                                                        @if($isOverdue)
                                                            <span style="margin-left:0.5rem; background:#fff; color:#e74c3c; border-radius:0.4rem; padding:0.1rem 0.5rem; font-size:0.95em; font-weight:bold;">Overdue!</span>
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="display:flex; align-items:center; gap:0.3rem;">
                                            <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline;" onsubmit="return confirm('Mark this quest as complete?');">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_completed" value="1">
                                                <button type="submit" style="background:var(--quest-btn-complete, #8fc97a); color:var(--quest-btn-text, #fff); border:none; border-radius:50%; width:36px; height:36px; font-size:1.3rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem;">✅</button>
                                            </form>
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this quest?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background:var(--quest-btn-delete, #e74c3c); color:var(--quest-btn-text, #fff); border:none; border-radius:50%; width:36px; height:36px; font-size:1.3rem; display:flex; align-items:center; justify-content:center; cursor:pointer;">🗑️</button>
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
            </div>
            <div id="completed-list" style="display:none; overflow-y:auto; max-height:70vh; padding-right:1rem;">
                @foreach($completedTasks as $task)
                    <div class="quest-item" style="background:var(--quest-card-bg, #8fc97a); color:var(--quest-card-text, #222); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:1.2rem 2rem; font-size:1.1rem; display:flex; align-items:center; justify-content:space-between; margin-bottom:0.7rem; border:2.5px solid var(--highlight-border, #7aa2f7); opacity:0.7;">
                        <div style="display:flex; flex-direction:column; gap:0.3rem; flex-grow:1; margin-right:1rem; font-family:'Segoe UI',sans-serif;">
                            <div style="display:flex; align-items:center; gap:0.5rem;">
                                @if($task->source == 'system')
                                    <span style="background:var(--quest-badge-bg-daily, #99D877); color:var(--quest-badge-text-daily, #183408); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; font-family:'Segoe UI',sans-serif;">★ Daily</span>
                                @else
                                    <span style="background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; font-family:'Segoe UI',sans-serif;">● Personal</span>
                                @endif
                                <span style="font-weight:bold; font-family:'Segoe UI',sans-serif; text-decoration:line-through;">{{ $task->title }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:0.7rem; flex-wrap:wrap; margin-top:0.2rem;">
                                <div style="background:var(--quest-desc-bg, #f5f5f5); color:var(--quest-desc-text, #222); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; max-width:50%; word-break:break-word; white-space:normal; font-size:1.08rem; font-family:'Segoe UI',sans-serif; font-weight:500; text-decoration:line-through;">
                                    {{ $task->description }}
                                </div>
                                @if($task->deadline)
                                    <span style="display:inline-block; margin-left:1rem; font-size:1.1rem; font-weight:bold; color:var(--quest-deadline-text, #b8860b); background:var(--quest-deadline-bg, #fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem;">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y H:i') }}</span>
                                @endif
                            </div>
                        </div>
                        <span style="font-size:1.1rem; color:#8fc97a; font-weight:bold;">Completed</span>
                    </div>
                @endforeach
            </div>
            <script>
                const tabActive = document.getElementById('tab-active');
                const tabCompleted = document.getElementById('tab-completed');
                const activeList = document.getElementById('active-list');
                const completedList = document.getElementById('completed-list');
                const filterAll = document.getElementById('filter-all');
                const filterDaily = document.getElementById('filter-daily');
                const filterPersonal = document.getElementById('filter-personal');
                const dailySection = document.getElementById('daily-section');
                const sideSection = document.getElementById('side-section');

                function setActive(btn) {
                    [filterAll, filterDaily, filterPersonal].forEach(b => {
                        b.style.background = 'var(--tab-inactive-bg, #d2c1ad)';
                        b.style.color = 'var(--tab-inactive-text, #4b3a2f)';
                        b.style.border = '2.5px solid transparent';
                        b.style.boxShadow = 'none';
                    });
                    btn.style.background = 'var(--tab-active-bg, #fff)';
                    btn.style.color = 'var(--tab-active-text, #4b3a2f)';
                    btn.style.border = '2.5px solid var(--highlight-border, #7aa2f7)';
                    btn.style.boxShadow = '0 2px 8px var(--highlight-border, #7aa2f7)';
                }

                filterAll.onclick = function() {
                    setActive(filterAll);
                    dailySection.style.display = '';
                    sideSection.style.display = '';
                };
                filterDaily.onclick = function() {
                    setActive(filterDaily);
                    dailySection.style.display = '';
                    sideSection.style.display = 'none';
                };
                filterPersonal.onclick = function() {
                    setActive(filterPersonal);
                    dailySection.style.display = 'none';
                    sideSection.style.display = '';
                };

                tabActive.onclick = function() {
                    tabActive.style.background = 'var(--tab-active-bg, #fff)';
                    tabActive.style.color = 'var(--tab-active-text, #4b3a2f)';
                    tabActive.style.border = '2.5px solid var(--highlight-border, #7aa2f7)';
                    tabActive.style.boxShadow = '0 2px 8px var(--highlight-border, #7aa2f7)';
                    tabCompleted.style.background = 'var(--tab-inactive-bg, #d2c1ad)';
                    tabCompleted.style.color = 'var(--tab-inactive-text, #4b3a2f)';
                    tabCompleted.style.border = '2.5px solid transparent';
                    tabCompleted.style.boxShadow = 'none';
                    activeList.style.display = '';
                    completedList.style.display = 'none';
                };
                tabCompleted.onclick = function() {
                    tabActive.style.background = 'var(--tab-inactive-bg, #d2c1ad)';
                    tabActive.style.color = 'var(--tab-inactive-text, #4b3a2f)';
                    tabActive.style.border = '2.5px solid transparent';
                    tabActive.style.boxShadow = 'none';
                    tabCompleted.style.background = 'var(--tab-active-bg, #fff)';
                    tabCompleted.style.color = 'var(--tab-active-text, #4b3a2f)';
                    tabCompleted.style.border = '2.5px solid var(--highlight-border, #7aa2f7)';
                    tabCompleted.style.boxShadow = '0 2px 8px var(--highlight-border, #7aa2f7)';
                    activeList.style.display = 'none';
                    completedList.style.display = '';
                };

                document.addEventListener('DOMContentLoaded', function() {
                    // Add New Quest button at top triggers modal
                    var addQuestTopBtn = document.getElementById('add-quest-top-btn');
                    var addQuestModal = document.getElementById('add-quest-modal');
                    if (addQuestTopBtn && addQuestModal) {
                        addQuestTopBtn.onclick = function() {
                            addQuestModal.style.display = 'flex';
                        };
                    }
                });
            </script>
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
                        <div style="background:{{ $isUnlocked ? 'var(--highlight-bg, #fffbe6)' : '#b28b67' }}; color:#4b3a2f; border-radius:1.2rem; box-shadow:2px 2px 8px #6e5445; padding:2rem 2.5rem; min-width:260px; min-height:210px; display:flex; flex-direction:column; align-items:center; justify-content:center; position:relative; border:4px solid {{ $isUnlocked ? 'var(--highlight-border, #ffe066)' : '#cfc1ad' }};">
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
                                <div style="position:absolute; top:1.2rem; right:1.5rem; background:var(--highlight-border, #8fc97a); color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; box-shadow:0 2px 8px var(--highlight-border, #8fc97a);">Unlocked</div>
                            @else
                                <div style="position:absolute; top:1.2rem; right:1.5rem; background:var(--quest-btn-delete, #e74c3c); color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.5rem; padding:0.2rem 1.1rem; box-shadow:0 2px 8px var(--quest-btn-delete, #e74c3c);">Locked</div>
                                <div style="position:absolute; inset:0; background:rgba(139,104,66,0.15); border-radius:1.2rem;"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout> 