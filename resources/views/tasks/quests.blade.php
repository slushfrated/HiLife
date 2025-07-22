<x-app-layout>
<div style="width:100vw; min-height:100vh; background:var(--background); color:var(--text); font-family:'Segoe UI',sans-serif; overflow-x: hidden;">
    <!-- Main container -->
    <div style="width:100%; max-width:1200px; margin:2.5rem auto; padding:0 2rem; box-sizing:border-box; background:var(--background); display:flex; flex-direction:row; align-items:flex-start; gap:2.5rem; overflow:visible;">
        <!-- Vertical Filter Buttons -->
        <div style="display:flex; flex-direction:column; gap:1.2rem; min-width:120px; align-items:stretch; margin-top:2.5rem;">
            <button id="filter-all" style="background:var(--tab-active-bg, #fff); color:var(--tab-active-text, #4b3a2f); font-weight:bold; font-size:1.1rem; border:2.5px solid var(--highlight-border, transparent); border-radius:0.7rem; padding:0.8rem 0; box-shadow:0 2px 8px var(--highlight-border, transparent); cursor:pointer; transition:background 0.2s, border 0.2s, box-shadow 0.2s;">All</button>
            <button id="filter-daily" style="background:var(--tab-inactive-bg, #d2c1ad); color:var(--tab-inactive-text, #4b3a2f); font-weight:bold; font-size:1.1rem; border:2.5px solid transparent; border-radius:0.7rem; padding:0.8rem 0; box-shadow:none; cursor:pointer; transition:background 0.2s, border 0.2s, box-shadow 0.2s;">Daily</button>
            <button id="filter-personal" style="background:var(--tab-inactive-bg, #d2c1ad); color:var(--tab-inactive-text, #4b3a2f); font-weight:bold; font-size:1.1rem; border:2.5px solid transparent; border-radius:0.7rem; padding:0.8rem 0; box-shadow:none; cursor:pointer; transition:background 0.2s, border 0.2s, box-shadow 0.2s;">Upcoming</button>
            <button id="filter-overdue" style="background:var(--tab-inactive-bg, #d2c1ad); color:var(--tab-inactive-text, #4b3a2f); font-weight:bold; font-size:1.1rem; border:2.5px solid transparent; border-radius:0.7rem; padding:0.8rem 0; box-shadow:none; cursor:pointer; transition:background 0.2s, border 0.2s, box-shadow 0.2s;">Overdue</button>
            <button id="filter-unscheduled" style="background:var(--tab-inactive-bg, #d2c1ad); color:var(--tab-inactive-text, #4b3a2f); font-weight:bold; font-size:1.1rem; border:2.5px solid transparent; border-radius:0.7rem; padding:0.8rem 0; box-shadow:none; cursor:pointer; transition:background 0.2s, border 0.2s, box-shadow 0.2s;">Unscheduled</button>
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
            <div id="active-list" style="display:block; overflow-y:auto; max-height:80vh; padding:0 0 3rem 0; padding-right:1rem;">
                <div id="daily-section">
                    <!-- Daily (system) quests box -->
                    <div style="background:var(--quest-container-bg, #fffbe6); border-radius:1.1rem; box-shadow:1px 1px 6px #6e544520; padding:1.2rem 1.2rem 1.2rem 1.2rem; margin-bottom:2.2rem;">
                        <span style="display:inline-block; background:var(--quest-section-bg, #fffbe6); color:var(--quest-section-text, #b8860b); font-size:0.93rem; font-weight:600; border-radius:0.5rem; padding:0.08rem 0.8rem 0.04rem 0.8rem; box-shadow:0 1px 4px #ffe06633; font-family:'Inter',sans-serif; letter-spacing:0.01em; border:1px solid var(--quest-section-border, #ffe066); margin-bottom:0.1rem; margin-left:0.1rem;">★ Daily Quests</span>
                        <div style="padding:1.7rem 1.2rem 1.2rem 1.2rem; margin-top:0.3rem;">
                            @php $hasSystem = false; $systemCount = 0; $firstSystem = true; @endphp
                            @foreach($activeTasks as $task)
                                @php
                                    $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                                    $isOverdue = !$task->is_completed && $task->due_date && \Carbon\Carbon::parse($task->due_date)->lt($today);
                                    if ($isOverdue) {
                                        $expAmount = 10;
                                    } else {
                                        if ($task->priority === 'low') {
                                            $expAmount = 30;
                                        } elseif ($task->priority === 'high') {
                                            $expAmount = 70;
                                        } else {
                                            $expAmount = 50;
                                        }
                                    }
                                @endphp
                                @if($task->source == 'system')
                                    @php $hasSystem = true; $systemCount++; @endphp
                                    <div class="quest-item" style="background:var(--quest-card-bg, #DFEDD7); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:stretch; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7); position:relative;">
                                        <div style="position:absolute; top:0; bottom:0; left:0; width:8px; border-radius:0.7rem 0 0 0.7rem; background:
                                            @if($task->priority === 'high') #E74C3C
                                            @elseif($task->priority === 'medium') #F5A623
                                            @elseif($task->priority === 'low') #4A90E2
                                            @else #CAD7C3 @endif;"></div>
                                        <div style="font-family:'Inter',sans-serif; display:flex; flex-direction:column; gap:0.3rem; flex-grow: 1; margin-right: 1rem; padding-left:16px;">
                                            <div style="display:flex; align-items:center; gap:0.5rem;">
                                                @if($task->source == 'system')
                                                    <span style="background:var(--quest-badge-bg-daily, #99D877); color:var(--quest-badge-text-daily, #183408); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;">★ Daily</span>
                                                @else
                                                    <span style="background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;">● Personal</span>
                                                @endif
                                                <div style="display:flex; align-items:center; gap:0.7em;">
                                                    <span style="font-size:1.25rem; font-weight:bold; font-family:'Inter',sans-serif;">{{ $task->title }}</span>
                                                </div>
                                            </div>
                                            <div style="display:flex; align-items:center; gap:1rem; width:100%; margin-top:0.2rem;">
                                                @if($task->description)
                                                <div style="background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;">{{ $task->description }}</div>
                                                @endif
                                                @if($task->source == 'user' && ($task->due_date || $task->due_time))
                                                    <div style="display:flex; align-items:center; gap:0.7rem; margin-top:0.2rem;">
                                                        @if($task->due_date)
                                                            <span style="display:inline-block; font-size:1.05rem; font-weight:bold; color:var(--quest-deadline-text, #654D48); background:var(--quest-deadline-bg, #fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Inter',sans-serif; white-space:nowrap;">
                                                                {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                                            </span>
                                                        @else
                                                            <span style="color: #aaa;">No due date</span>
                                                        @endif
                                                        @if($task->due_time)
                                                            @php
                                                                try {
                                                                    $timeObj = \Carbon\Carbon::parse($task->due_time);
                                                                    $formattedTime = $timeObj->format('H:i');
                                                                } catch (\Exception $e) {
                                                                    $formattedTime = $task->due_time;
                                                                }
                                                            @endphp
                                                            <span style="display:inline-block; font-size:1.05rem; font-weight:bold; color:var(--quest-deadline-text, #654D48); background:var(--quest-deadline-bg, #fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Inter',sans-serif; white-space:nowrap; position:relative;">
                                                                {{ $formattedTime }}
                                                                @if($task->duration_minutes)
                                                                    @php
                                                                        $hours = intdiv($task->duration_minutes, 60);
                                                                        $minutes = $task->duration_minutes % 60;
                                                                        $durationStr = '';
                                                                        if ($hours > 0) $durationStr .= $hours . 'h ';
                                                                        if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                                        $durationStr = trim($durationStr);
                                                                    @endphp
                                                                    <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.08em 0.7em; font-size:0.85em; font-weight:500; margin-left:0.5em; position:relative; top:-1px; vertical-align:middle;">{{ $durationStr }}</span>
                                                                @endif
                                                            </span>
                                                        @elseif($task->duration_minutes)
                                                            @php
                                                                $hours = intdiv($task->duration_minutes, 60);
                                                                $minutes = $task->duration_minutes % 60;
                                                                $durationStr = '';
                                                                if ($hours > 0) $durationStr .= $hours . 'h ';
                                                                if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                                $durationStr = trim($durationStr);
                                                            @endphp
                                                            <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.98em; font-weight:500;">{{ $durationStr }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                                <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Inter',sans-serif;">+{{ $expAmount }} EXP</span>
                                                @if($isOverdue)
                                                    <span style="margin-left:0.5rem; background:#fff; color:#e74c3c; border-radius:0.4rem; padding:0.1rem 0.5rem; font-size:0.95em; font-weight:bold;">Overdue!</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="display:flex; align-items:center; gap:0.3rem;">
                                            <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline;" class="quest-complete-form" data-title="{{ $task->title }}" data-desc="{{ $task->description }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_completed" value="1">
                                                <input type="hidden" name="redirect_to" value="quests">
                                                <button type="submit" style="background:var(--quest-btn-complete, #8fc97a); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0;">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 10.5L9 14.5L15 7.5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @php $firstSystem = false; @endphp
                                @endif
                            @endforeach
                            @if($systemCount === 0)
                                <div style="color:#fff; margin-bottom:2rem; font-size:1.3rem; display:flex; align-items:center; justify-content:center; font-family:'Inter',sans-serif; font-weight:bold; margin-top:2.2rem;">Congratulations, you have completed all daily quests!</div>
                            @endif
                        </div>
                    </div>
                    <div style="height:1px; background:var(--highlight-border, #7aa2f7); margin:2.2rem 0 2.2rem 0; border-radius:1px;"></div>
                </div>
                <div id="side-section">
                    <!-- User (side) quests box -->
                    <div style="background:var(--quest-container-bg, #f5e6d8); border-radius:1.1rem; box-shadow:1px 1px 6px #6e544520; padding:1.2rem 1.2rem 1.2rem 1.2rem; margin-bottom:2.2rem;">
                        <span style="display:inline-block; background:var(--quest-section-bg, #f7f3ef); color:var(--quest-section-text, #4b3a2f); font-size:0.93rem; font-weight:600; border-radius:0.5rem; padding:0.08rem 0.8rem 0.04rem 0.8rem; box-shadow:0 1px 4px #cfc1ad33; font-family:'Inter',sans-serif; letter-spacing:0.01em; border:1px solid var(--quest-section-border, #e5ded6); margin-bottom:0.1rem; margin-left:0.1rem;">Upcoming</span>
                        <div style="padding:1.7rem 1.2rem 1.2rem 1.2rem; margin-top:0.3rem;">
                            @php 
                                $userCount = 0;
                                $currentDate = null;
                                $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                                $tomorrow = \Carbon\Carbon::now('Asia/Jakarta')->addDay()->toDateString();
                                $laterTasks = [];
                                $overdueTasks = [];
                                $dayTasks = [];
                                foreach ($activeTasks as $task) {
                                    if ($task->source == 'user') {
                                        $userCount++;
                                        $taskDate = $task->due_date ? \Carbon\Carbon::parse($task->due_date)->toDateString() : null;
                                        $isOverdue = !$task->is_completed && $task->due_date && \Carbon\Carbon::parse($task->due_date)->lt($today);
                                        if (!$taskDate) {
                                            $laterTasks[] = $task;
                                        } elseif ($isOverdue) {
                                            $overdueTasks[] = $task;
                                        } else {
                                            $dayTasks[$taskDate][] = $task;
                                        }
                                    }
                                }
                            @endphp
                            @if((count($dayTasks) === 0) && (count($laterTasks) > 0 || count($overdueTasks) > 0))
                                <div style="color:var(--quest-empty-text, #4b3a2f); margin-bottom:2rem; font-size:1.3rem; display:flex; align-items:center; justify-content:center; font-family:'Inter',sans-serif; font-weight:bold; margin-top:2.2rem;">No Upcoming Quests</div>
                            @endif
                            {{-- Render day groups (today, tomorrow, etc.) --}}
                            @php $dates = array_keys($dayTasks); sort($dates); @endphp
                            @foreach($dates as $date)
                                <div style="margin-bottom: 1.5rem;">
                                    <div style="font-size:1.2rem; font-weight:bold; color:var(--quest-section-text, #4b3a2f); margin-bottom:1rem; font-family:'Inter',sans-serif;">
                                        @if($date === $today)
                                            Today
                                        @elseif($date === $tomorrow)
                                            Tomorrow
                                        @else
                                            {{ \Carbon\Carbon::parse($date)->format('l, M d, Y') }}
                                        @endif
                                    </div>
                                    <div style="display:flex; flex-direction:column; gap:0.3rem;">
                                        @foreach($dayTasks[$date] as $task)
                                            @php
                                                $isOverdue = false;
                                                if ($task->priority === 'low') {
                                                    $expAmount = 30;
                                                } elseif ($task->priority === 'high') {
                                                    $expAmount = 70;
                                                } else {
                                                    $expAmount = 50;
                                                }
                                            @endphp
                                            <div class="quest-item" style="background:var(--quest-card-bg, #DFEDD7); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:stretch; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7); position:relative;">
                                                <div style="position:absolute; top:0; bottom:0; left:0; width:8px; border-radius:0.7rem 0 0 0.7rem; background:
                                                    @if($task->priority === 'high') #E74C3C
                                                    @elseif($task->priority === 'medium') #F5A623
                                                    @elseif($task->priority === 'low') #4A90E2
                                                    @else #8fc97a @endif;"></div>
                                                <div style="font-family:'Inter',sans-serif; display:flex; flex-direction:column; gap:0.3rem; flex-grow: 1; margin-right: 1rem; padding-left:16px;">
                                            <div style="display:flex; align-items:center; gap:0.5rem;">
                                                        <span style="background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;">● Personal</span>
                                                        <div style="display:flex; align-items:center; gap:0.7em;">
                                                            <span style="font-size:1.25rem; font-weight:bold; font-family:'Inter',sans-serif;">{{ $task->title }}</span>
                                                        </div>
                                                    </div>
                                                    <div style="display:flex; align-items:center; gap:1rem; width:100%; margin-top:0.2rem;">
                                                        @if($task->description)
                                                        <div style="background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;">{{ $task->description }}</div>
                                                        @endif
                                                        @if($task->due_time || $task->duration_minutes)
                                                            @if($task->due_time)
                                                                @php
                                                                    try {
                                                                        $timeObj = \Carbon\Carbon::parse($task->due_time);
                                                                        $formattedTime = $timeObj->format('H:i');
                                                                    } catch (\Exception $e) {
                                                                        $formattedTime = $task->due_time;
                                                                    }
                                                                @endphp
                                                                <span style="display:inline-block; font-size:1.05rem; font-weight:bold; color:var(--quest-deadline-text, #654D48); background:var(--quest-deadline-bg, #fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Inter',sans-serif; white-space:nowrap; position:relative;">
                                                                    {{ $formattedTime }}
                                                                    @if($task->duration_minutes)
                                                                        @php
                                                                            $hours = intdiv($task->duration_minutes, 60);
                                                                            $minutes = $task->duration_minutes % 60;
                                                                            $durationStr = '';
                                                                            if ($hours > 0) $durationStr .= $hours . 'h ';
                                                                            if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                                            $durationStr = trim($durationStr);
                                                                        @endphp
                                                                        <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.08em 0.7em; font-size:0.85em; font-weight:500; margin-left:0.5em; position:relative; top:-1px; vertical-align:middle;">{{ $durationStr }}</span>
                                                                    @endif
                                                                </span>
                                                            @elseif($task->duration_minutes)
                                                                @php
                                                                    $hours = intdiv($task->duration_minutes, 60);
                                                                    $minutes = $task->duration_minutes % 60;
                                                                    $durationStr = '';
                                                                    if ($hours > 0) $durationStr .= $hours . 'h ';
                                                                    if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                                    $durationStr = trim($durationStr);
                                                                @endphp
                                                                <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.98em; font-weight:500;">{{ $durationStr }}</span>
                                                            @endif
                                                @endif
                                                        <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Inter',sans-serif;">+{{ $expAmount }} EXP</span>
                                                    </div>
                                                </div>
                                                <div style="display:flex; align-items:center; gap:0.3rem;">
                                                    <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline;" class="quest-complete-form" data-title="{{ $task->title }}" data-desc="{{ $task->description }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="is_completed" value="1">
                                                        <input type="hidden" name="redirect_to" value="quests">
                                                        <button type="submit" style="background:var(--quest-btn-complete, #8fc97a); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0;">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 10.5L9 14.5L15 7.5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        </button>
                                                    </form>
                                                    @php
                                                        $questData = [
                                                            "id" => $task->id,
                                                            "title" => $task->title,
                                                            "description" => $task->description,
                                                            "due_date" => $task->due_date,
                                                            "due_time" => $task->due_time,
                                                            "duration_hours" => $task->duration_minutes ? intdiv($task->duration_minutes, 60) : '',
                                                            "duration_minutes" => $task->duration_minutes ? $task->duration_minutes % 60 : '',
                                                            "priority" => $task->priority
                                                        ];
                                                    @endphp
                                                    <button class="open-edit-quest-modal" data-quest='@json($questData)' style="background:var(--quest-btn-edit, #f5a623); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0; text-decoration:none;" title="Edit Quest">
                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 13.5V16H6.5L14.1 8.4C14.3 8.2 14.3 7.9 14.1 7.7L12.3 5.9C12.1 5.7 11.8 5.7 11.6 5.9L4 13.5ZM16.7 6.3C17.1 5.9 17.1 5.3 16.7 4.9L15.1 3.3C14.7 2.9 14.1 2.9 13.7 3.3L12.1 4.9L15.1 7.9L16.7 6.3Z" fill="white"/></svg>
                                                    </button>
                                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;" class="quest-delete-form" data-title="{{ $task->title }}" data-desc="{{ $task->description }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="redirect_to" value="quests">
                                                        <button type="submit" style="background:var(--quest-btn-delete, #e74c3c); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; padding:0;">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="8" width="10" height="7" rx="1.5" fill="white"/><rect x="8" y="5" width="4" height="2" rx="1" fill="white"/><rect x="3" y="8" width="14" height="1.5" fill="white"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @if(count($laterTasks) === 0 && count($overdueTasks) === 0 && count($dayTasks) === 0)
                                <div style="color:var(--quest-empty-text, #4b3a2f); margin-bottom:2rem; font-size:1.3rem; display:flex; align-items:center; justify-content:center; font-family:'Inter',sans-serif; font-weight:bold; margin-top:2.2rem;">No active quests</div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Overdue section container --}}
                            @if(count($overdueTasks) > 0)
                <div id="overdue-section" style="background:var(--quest-container-bg, #ffeaea); border-radius:1.1rem; box-shadow:1px 1px 6px #6e544520; padding:1.2rem 1.2rem 1.2rem 1.2rem; margin-bottom:2.2rem;">
                    <span style="display:inline-block; background:var(--quest-section-bg, #ffeaea); color:#e74c3c; font-size:0.93rem; font-weight:600; border-radius:0.5rem; padding:0.08rem 0.8rem 0.04rem 0.8rem; box-shadow:0 1px 4px #ffe06633; font-family:'Inter',sans-serif; letter-spacing:0.01em; border:1px solid #e74c3c; margin-bottom:0.1rem; margin-left:0.1rem;">Overdue</span>
                    <div style="padding:1.7rem 1.2rem 1.2rem 1.2rem; margin-top:0.3rem;">
                        @php
                            $yesterday = \Carbon\Carbon::now('Asia/Jakarta')->subDay()->toDateString();
                            $overdueByDate = [];
                            foreach ($overdueTasks as $task) {
                                $date = $task->due_date ? \Carbon\Carbon::parse($task->due_date)->toDateString() : 'No Date';
                                $overdueByDate[$date][] = $task;
                            }
                            krsort($overdueByDate); // Most recent overdue first
                            $first = true;
                        @endphp
                        @foreach($overdueByDate as $date => $tasks)
                            <div style="font-size:1.2rem; font-weight:bold; color:#e74c3c; margin-bottom:1rem; font-family:'Inter',sans-serif; {{ $first ? 'margin-top:0;' : 'margin-top:1.2em;' }}">
                                @if($date === $yesterday)
                                    Yesterday
                                @elseif($date === 'No Date')
                                    No Due Date
                                @else
                                    {{ \Carbon\Carbon::parse($date)->format('l, M d, Y') }}
                                @endif
                            </div>
                            @php $first = false; @endphp
                                    <div style="display:flex; flex-direction:column; gap:0.3rem;">
                                @foreach($tasks as $task)
                                            @php
                                                $isOverdue = true;
                                        $expAmount = 10;
                                            @endphp
                                            <div class="quest-item" style="background:var(--quest-card-bg, #DFEDD7); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:stretch; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7); position:relative;">
                                                <div style="position:absolute; top:0; bottom:0; left:0; width:8px; border-radius:0.7rem 0 0 0.7rem; background:
                                                    @if($task->priority === 'high') #E74C3C
                                                    @elseif($task->priority === 'medium') #F5A623
                                                    @elseif($task->priority === 'low') #4A90E2
                                                    @else #8fc97a @endif;"></div>
                                                <div style="font-family:'Inter',sans-serif; display:flex; flex-direction:column; gap:0.3rem; flex-grow: 1; margin-right: 1rem; padding-left:16px;">
                                                    <div style="display:flex; align-items:center; gap:0.5rem;">
                                                        <span style="background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;">● Personal</span>
                                                        <div style="display:flex; align-items:center; gap:0.7em;">
                                                            <span style="font-size:1.25rem; font-weight:bold; font-family:'Inter',sans-serif;">{{ $task->title }}</span>
                                                        </div>
                                                    </div>
                                            <div style="display:flex; align-items:center; gap:1rem; width:100%; margin-top:0.2rem; flex-wrap:wrap;">
                                                        @if($task->description)
                                                        <div style="background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;">{{ $task->description }}</div>
                                                        @endif
                                                        @if($task->due_time || $task->duration_minutes)
                                                            @if($task->due_time)
                                                                @php
                                                                    try {
                                                                        $timeObj = \Carbon\Carbon::parse($task->due_time);
                                                                        $formattedTime = $timeObj->format('H:i');
                                                                    } catch (\Exception $e) {
                                                                        $formattedTime = $task->due_time;
                                                                    }
                                                                @endphp
                                                                <span style="display:inline-block; font-size:1.05rem; font-weight:bold; color:var(--quest-deadline-text, #654D48); background:var(--quest-deadline-bg, #fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Inter',sans-serif; white-space:nowrap; position:relative;">
                                                                    {{ $formattedTime }}
                                                                    @if($task->duration_minutes)
                                                                        @php
                                                                            $hours = intdiv($task->duration_minutes, 60);
                                                                            $minutes = $task->duration_minutes % 60;
                                                                            $durationStr = '';
                                                                            if ($hours > 0) $durationStr .= $hours . 'h ';
                                                                            if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                                            $durationStr = trim($durationStr);
                                                                        @endphp
                                                                        <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.08em 0.7em; font-size:0.85em; font-weight:500; margin-left:0.5em; position:relative; top:-1px; vertical-align:middle;">{{ $durationStr }}</span>
                                                                    @endif
                                                                </span>
                                                            @elseif($task->duration_minutes)
                                                                @php
                                                                    $hours = intdiv($task->duration_minutes, 60);
                                                                    $minutes = $task->duration_minutes % 60;
                                                                    $durationStr = '';
                                                                    if ($hours > 0) $durationStr .= $hours . 'h ';
                                                                    if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                                    $durationStr = trim($durationStr);
                                                                @endphp
                                                                <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.98em; font-weight:500;">{{ $durationStr }}</span>
                                                            @endif
                                                @endif
                                                        <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Inter',sans-serif;">+{{ $expAmount }} EXP</span>
                                                    </div>
                                                </div>
                                                <div style="display:flex; align-items:center; gap:0.3rem;">
                                                    <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline;" class="quest-complete-form" data-title="{{ $task->title }}" data-desc="{{ $task->description }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="is_completed" value="1">
                                                        <input type="hidden" name="redirect_to" value="quests">
                                                        <button type="submit" style="background:var(--quest-btn-complete, #8fc97a); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0;">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 10.5L9 14.5L15 7.5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        </button>
                                                    </form>
                                                    @php
                                                        $questData = [
                                                            "id" => $task->id,
                                                            "title" => $task->title,
                                                            "description" => $task->description,
                                                            "due_date" => $task->due_date,
                                                            "due_time" => $task->due_time,
                                                            "duration_hours" => $task->duration_minutes ? intdiv($task->duration_minutes, 60) : '',
                                                            "duration_minutes" => $task->duration_minutes ? $task->duration_minutes % 60 : '',
                                                            "priority" => $task->priority
                                                        ];
                                                    @endphp
                                            <button class="open-edit-quest-modal" data-quest='@json($questData)' style="background:var(--quest-btn-edit, #f5a623); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0; text-decoration:none;" title="Edit Quest">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 13.5V16H6.5L14.1 8.4C14.3 8.2 14.3 7.9 14.1 7.7L12.3 5.9C12.1 5.7 11.8 5.7 11.6 5.9L4 13.5ZM16.7 6.3C17.1 5.9 17.1 5.3 16.7 4.9L15.1 3.3C14.7 2.9 14.1 2.9 13.7 3.3L12.1 4.9L15.1 7.9L16.7 6.3Z" fill="white"/></svg>
                                            </button>
                                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;" class="quest-delete-form" data-title="{{ $task->title }}" data-desc="{{ $task->description }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="redirect_to" value="quests">
                                                        <button type="submit" style="background:var(--quest-btn-delete, #e74c3c); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; padding:0;">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="8" width="10" height="7" rx="1.5" fill="white"/><rect x="8" y="5" width="4" height="2" rx="1" fill="white"/><rect x="3" y="8" width="14" height="1.5" fill="white"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                    </div>
                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                {{-- Later section container --}}
                            @if(count($laterTasks) > 0)
                <div id="unscheduled-section" style="background:var(--quest-container-bg, #e6f7ff); border-radius:1.1rem; box-shadow:1px 1px 6px #6e544520; padding:1.2rem 1.2rem 1.2rem 1.2rem; margin-bottom:2.2rem;">
                    <span style="display:inline-block; background:var(--quest-section-bg, #e6f7ff); color:var(--quest-section-text, #1e90ff); font-size:0.93rem; font-weight:600; border-radius:0.5rem; padding:0.08rem 0.8rem 0.04rem 0.8rem; box-shadow:0 1px 4px var(--quest-section-shadow, #cfc1ad33); font-family:'Inter',sans-serif; letter-spacing:0.01em; border:1px solid var(--quest-section-border, #1e90ff); margin-bottom:0.1rem; margin-left:0.1rem;">Unscheduled</span>
                    <div style="padding:1.7rem 1.2rem 1.2rem 1.2rem; margin-top:0.3rem;">
                                        @foreach($laterTasks as $task)
                                            @php
                                                $isOverdue = false;
                                                if ($task->priority === 'low') {
                                                    $expAmount = 30;
                                                } elseif ($task->priority === 'high') {
                                                    $expAmount = 70;
                                                } else {
                                                    $expAmount = 50;
                                                }
                                                @endphp
                                            <div class="quest-item" style="background:var(--quest-card-bg, #DFEDD7); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:stretch; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7); position:relative;">
                                                <div style="position:absolute; top:0; bottom:0; left:0; width:8px; border-radius:0.7rem 0 0 0.7rem; background:
                                                    @if($task->priority === 'high') #E74C3C
                                                    @elseif($task->priority === 'medium') #F5A623
                                                    @elseif($task->priority === 'low') #4A90E2
                                                    @else #8fc97a @endif;"></div>
                                                <div style="font-family:'Inter',sans-serif; display:flex; flex-direction:column; gap:0.3rem; flex-grow: 1; margin-right: 1rem; padding-left:16px;">
                                                    <div style="display:flex; align-items:center; gap:0.5rem;">
                                                        <span style="background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;">● Personal</span>
                                                        <div style="display:flex; align-items:center; gap:0.7em;">
                                                            <span style="font-size:1.25rem; font-weight:bold; font-family:'Inter',sans-serif;">{{ $task->title }}</span>
                                                        </div>
                                                    </div>
                                                    <div style="display:flex; align-items:center; gap:1rem; width:100%; margin-top:0.2rem;">
                                                        @if($task->description)
                                                        <div style="background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;">{{ $task->description }}</div>
                                                        @endif
                                                        @if($task->due_time || $task->duration_minutes)
                                                            @if($task->due_time)
                                                                @php
                                                                    try {
                                                                        $timeObj = \Carbon\Carbon::parse($task->due_time);
                                                                        $formattedTime = $timeObj->format('H:i');
                                                                    } catch (\Exception $e) {
                                                                        $formattedTime = $task->due_time;
                                                                    }
                                                                @endphp
                                                                <span style="display:inline-block; font-size:1.05rem; font-weight:bold; color:var(--quest-deadline-text, #654D48); background:var(--quest-deadline-bg, #fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Inter',sans-serif; white-space:nowrap; position:relative;">
                                                                    {{ $formattedTime }}
                                                                    @if($task->duration_minutes)
                                                                        @php
                                                                            $hours = intdiv($task->duration_minutes, 60);
                                                                            $minutes = $task->duration_minutes % 60;
                                                                            $durationStr = '';
                                                                            if ($hours > 0) $durationStr .= $hours . 'h ';
                                                                            if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                                            $durationStr = trim($durationStr);
                                                                        @endphp
                                                                        <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.08em 0.7em; font-size:0.85em; font-weight:500; margin-left:0.5em; position:relative; top:-1px; vertical-align:middle;">{{ $durationStr }}</span>
                                                                    @endif
                                                                </span>
                                                            @elseif($task->duration_minutes)
                                                                @php
                                                                    $hours = intdiv($task->duration_minutes, 60);
                                                                    $minutes = $task->duration_minutes % 60;
                                                                    $durationStr = '';
                                                                    if ($hours > 0) $durationStr .= $hours . 'h ';
                                                                    if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                                    $durationStr = trim($durationStr);
                                                                @endphp
                                                                <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.98em; font-weight:500;">{{ $durationStr }}</span>
                                                            @endif
                                                @endif
                                                        <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Inter',sans-serif;">+{{ $expAmount }} EXP</span>
                                            </div>
                                        </div>
                                        <div style="display:flex; align-items:center; gap:0.3rem;">
                                                    <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline;" class="quest-complete-form" data-title="{{ $task->title }}" data-desc="{{ $task->description }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_completed" value="1">
                                                <input type="hidden" name="redirect_to" value="quests">
                                                <button type="submit" style="background:var(--quest-btn-complete, #8fc97a); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0;">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 10.5L9 14.5L15 7.5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </button>
                                            </form>
                                                    @php
                                                        $questData = [
                                                            "id" => $task->id,
                                                            "title" => $task->title,
                                                            "description" => $task->description,
                                                            "due_date" => $task->due_date,
                                                            "due_time" => $task->due_time,
                                                            "duration_hours" => $task->duration_minutes ? intdiv($task->duration_minutes, 60) : '',
                                                            "duration_minutes" => $task->duration_minutes ? $task->duration_minutes % 60 : '',
                                                            "priority" => $task->priority
                                                        ];
                                                    @endphp
                                    <button class="open-edit-quest-modal" data-quest='@json($questData)' style="background:var(--quest-btn-edit, #f5a623); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0; text-decoration:none;" title="Edit Quest">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 13.5V16H6.5L14.1 8.4C14.3 8.2 14.3 7.9 14.1 7.7L12.3 5.9C12.1 5.7 11.8 5.7 11.6 5.9L4 13.5ZM16.7 6.3C17.1 5.9 17.1 5.3 16.7 4.9L15.1 3.3C14.7 2.9 14.1 2.9 13.7 3.3L12.1 4.9L15.1 7.9L16.7 6.3Z" fill="white"/></svg>
                                    </button>
                                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;" class="quest-delete-form" data-title="{{ $task->title }}" data-desc="{{ $task->description }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="redirect_to" value="quests">
                                                        <button type="submit" style="background:var(--quest-btn-delete, #e74c3c); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; padding:0;">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="8" width="10" height="7" rx="1.5" fill="white"/><rect x="8" y="5" width="4" height="2" rx="1" fill="white"/><rect x="3" y="8" width="14" height="1.5" fill="white"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                    </div>
                            @endforeach
                                    </div>
                            @endif
            </div>
            <div style="color: orange;">
            @foreach($completedTasks as $task)
            <div id="completed-list" style="display:none; overflow-y:auto; max-height:70vh; padding-right:1rem;">
                @if(count($completedTasks) === 0)
                    <div style="color:var(--quest-card-text, #4b3a2f); margin-bottom:2rem; font-size:1.3rem; display:flex; align-items:center; justify-content:center; font-family:'Inter',sans-serif; font-weight:bold; margin-top:2.2rem;">
                        No completed quests yet
                    </div>
                @else
                    @foreach($completedTasks as $task)
                        <div class="quest-item" style="background:var(--quest-card-bg, #DFEDD7); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:stretch; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7); position:relative;">
                            <div style="position:absolute; top:0; bottom:0; left:0; width:8px; border-radius:0.7rem 0 0 0.7rem; background:
                                @if($task->priority === 'high') #E74C3C
                                @elseif($task->priority === 'medium') #F5A623
                                @elseif($task->priority === 'low') #4A90E2
                                @else #8fc97a @endif;"></div>
                            <div style="font-family:'Inter',sans-serif; display:flex; flex-direction:column; gap:0.3rem; flex-grow: 1; margin-right: 1rem; padding-left:16px;">
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    @if($task->source == 'system')
                                        <span style="background:var(--quest-badge-bg-daily, #99D877); color:var(--quest-badge-text-daily, #183408); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;">★ Daily</span>
                                    @else
                                        <span style="background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;">● Personal</span>
                                    @endif
                                    <div style="display:flex; align-items:center; gap:0.7em;">
                                        <span style="font-size:1.25rem; font-weight:bold; font-family:'Inter',sans-serif;">{{ $task->title }}</span>
                                    </div>
                                </div>
                                <div style="display:flex; align-items:center; gap:1rem; width:100%; margin-top:0.2rem;">
                                    @if($task->description)
                                        <div style="background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;">{{ $task->description }}</div>
                                    @endif
                                    @if($task->completed_at)
                                        <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#8fc97a; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Inter',sans-serif;">Completed {{ date('M j, Y g:i A', strtotime($task->completed_at)) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div style="display:flex; align-items:center; gap:0.3rem;">
                                @php
                                    $questData = [
                                        "id" => $task->id,
                                        "title" => $task->title,
                                        "description" => $task->description,
                                        "due_time" => $task->due_time,
                                        "duration_hours" => $task->duration_minutes ? intdiv($task->duration_minutes, 60) : '',
                                        "duration_minutes" => $task->duration_minutes ? $task->duration_minutes % 60 : '',
                                        "priority" => $task->priority
                                    ];
                                @endphp
                                <button class="readd-quest-btn" data-quest='@json($questData)' style="background:var(--quest-btn-complete, #8fc97a); color:#fff; border:none; border-radius:0.7rem; padding:0.5rem 1.2rem; font-size:1rem; font-weight:bold; cursor:pointer;">Re-add</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

@endforeach
</div>
            <script>
                // Wait for both DOM and Alpine to be ready
                window.addEventListener('alpine:init', function() {
                    setTimeout(function() {
                        console.log('DOM and Alpine Content Loaded');
                        
                        const tabActive = document.getElementById('tab-active');
                        const tabCompleted = document.getElementById('tab-completed');
                        const activeList = document.getElementById('active-list');
                        const completedList = document.getElementById('completed-list');
                        const filterAll = document.getElementById('filter-all');
                        const filterDaily = document.getElementById('filter-daily');
                        const filterPersonal = document.getElementById('filter-personal');
                        const filterOverdue = document.getElementById('filter-overdue');
                        const filterUnscheduled = document.getElementById('filter-unscheduled');
                        const dailySection = document.getElementById('daily-section');
                        const sideSection = document.getElementById('side-section');
                        const overdueSection = document.getElementById('overdue-section');
                        const unscheduledSection = document.getElementById('unscheduled-section');
                        
                        console.log('Elements found:', {
                            tabActive: !!tabActive,
                            tabCompleted: !!tabCompleted,
                            activeList: !!activeList,
                            filterAll: !!filterAll,
                            filterDaily: !!filterDaily,
                            filterPersonal: !!filterPersonal,
                            dailySection: !!dailySection,
                            sideSection: !!sideSection
                        });

                        function setActive(btn) {
                            console.log('Setting active filter:', btn.id);
                            [filterAll, filterDaily, filterPersonal, filterOverdue, filterUnscheduled].forEach(b => {
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

                        // Initialize with "All" filter active and active list showing
                        console.log('Initializing view state');
                        setActive(filterAll);
                        dailySection.style.display = 'block';
                        sideSection.style.display = 'block';
                        activeList.style.display = 'block';

                        filterAll.onclick = function() {
                            console.log('Filter All clicked');
                            setActive(filterAll);
                            dailySection.style.display = 'block';
                            sideSection.style.display = 'block';
                        };
                        filterDaily.onclick = function() {
                            console.log('Filter Daily clicked');
                            setActive(filterDaily);
                            dailySection.style.display = 'block';
                            sideSection.style.display = 'none';
                            overdueSection.style.display = 'none';
                            unscheduledSection.style.display = 'none';
                        };
                        filterPersonal.onclick = function() {
                            console.log('Filter Personal clicked');
                            setActive(filterPersonal);
                            dailySection.style.display = 'none';
                            sideSection.style.display = 'block';
                            overdueSection.style.display = 'none';
                            unscheduledSection.style.display = 'none';
                        };
                        filterOverdue.onclick = function() {
                            console.log('Filter Overdue clicked');
                            setActive(filterOverdue);
                            dailySection.style.display = 'none';
                            sideSection.style.display = 'none';    
                            overdueSection.style.display = 'block';
                            unscheduledSection.style.display = 'none';
                        };
                        filterUnscheduled.onclick = function() {
                            console.log('Filter Unscheduled clicked');
                            setActive(filterUnscheduled);
                            dailySection.style.display = 'none';
                            sideSection.style.display = 'none';
                            overdueSection.style.display = 'none';
                            unscheduledSection.style.display = 'block';
                        };

                        tabActive.onclick = function() {
                            console.log('Tab Active clicked');
                            tabActive.style.background = 'var(--tab-active-bg, #fff)';
                            tabActive.style.color = 'var(--tab-active-text, #4b3a2f)';
                            tabActive.style.border = '2.5px solid var(--highlight-border, #7aa2f7)';
                            tabActive.style.boxShadow = '0 2px 8px var(--highlight-border, #7aa2f7)';
                            tabCompleted.style.background = 'var(--tab-inactive-bg, #d2c1ad)';
                            tabCompleted.style.color = 'var(--tab-inactive-text, #4b3a2f)';
                            tabCompleted.style.border = '2.5px solid transparent';
                            tabCompleted.style.boxShadow = 'none';
                            activeList.style.display = 'block';
                            completedList.style.display = 'none';
                            console.log('Active list display:', activeList.style.display);
                        };

                        tabCompleted.onclick = function() {
                            console.log('Tab Completed clicked');
                            tabActive.style.background = 'var(--tab-inactive-bg, #d2c1ad)';
                            tabActive.style.color = 'var(--tab-inactive-text, #4b3a2f)';
                            tabActive.style.border = '2.5px solid transparent';
                            tabActive.style.boxShadow = 'none';
                            tabCompleted.style.background = 'var(--tab-active-bg, #fff)';
                            tabCompleted.style.color = 'var(--tab-active-text, #4b3a2f)';
                            tabCompleted.style.border = '2.5px solid var(--highlight-border, #7aa2f7)';
                            tabCompleted.style.boxShadow = '0 2px 8px var(--highlight-border, #7aa2f7)';
                            activeList.style.display = 'none';
                            completedList.style.display = 'block';
                            console.log('Active list display:', activeList.style.display);
                        };

                        // Add New Quest button at top triggers modal
                        var addQuestTopBtn = document.getElementById('add-quest-top-btn');
                        var addQuestModal = document.getElementById('add-quest-modal');
                        if (addQuestTopBtn && addQuestModal) {
                            addQuestTopBtn.onclick = function() {
                                addQuestModal.style.display = 'flex';
                            };
                        }
                    }, 100); // Small delay to ensure DOM is fully loaded
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
<!-- Notification Container -->
<div id="custom-notification" style="display:none; position:fixed; top:2rem; left:50%; transform:translateX(-50%); background:var(--primary,#7aa2f7); color:var(--text, #fff); font-size:1.1rem; padding:0.8rem 2rem; border-radius:0.6rem; box-shadow:0 2px 8px #6e5445; z-index:99999; transition:opacity 0.5s;"></div>
<script>
function showNotification(message, color) {
    var notif = document.getElementById('custom-notification');
    notif.textContent = message;
    notif.style.background = color || 'var(--primary,#7aa2f7)';
    notif.style.display = 'block';
    notif.style.opacity = '1';
    setTimeout(function() {
        notif.style.opacity = '0';
        setTimeout(function(){ notif.style.display = 'none'; }, 500);
    }, 2200);
}
// Listen for custom events
window.addEventListener('quest-action', function(e) {
    showNotification(e.detail.message, e.detail.color);
});
</script>
@if(session('quest_notification'))
<script>
window.addEventListener('DOMContentLoaded', function() {
    window.dispatchEvent(new CustomEvent('quest-action', { detail: @json(session('quest_notification')) }));
});
</script>
@endif
<!-- Custom Confirmation Modal -->
<div id="custom-confirm-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.35); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:var(--modal-bg, #fffbe6); color:var(--modal-text, #403232); border-radius:1.2rem; box-shadow:0 6px 32px #0008; padding:2.2rem 2.7rem; min-width:340px; max-width:98vw; position:relative; display:flex; flex-direction:column; align-items:center;">
        <div id="custom-confirm-message" style="font-size:1.25rem; font-weight:bold; margin-bottom:1.7rem; text-align:center;">Are you sure?</div>
        <div id="custom-confirm-quest" style="font-size:1.05rem; color:var(--modal-text, #555); margin-bottom:1.2rem; text-align:center;"></div>
        <div style="display:flex; gap:1.2rem;">
            <button id="custom-confirm-ok" style="background:var(--primary,#7aa2f7); color:var(--modal-btn-text-ok, #fff); font-size:1.1rem; font-weight:bold; border:none; border-radius:0.7rem; padding:0.5rem 1.5rem; box-shadow:0 2px 8px #6e5445; cursor:pointer;">OK</button>
            <button id="custom-confirm-cancel" style="background:var(--modal-btn-cancel, #e74c3c); color:var(--modal-btn-text-cancel, #fff); font-size:1.1rem; font-weight:bold; border:none; border-radius:0.7rem; padding:0.5rem 1.5rem; box-shadow:0 2px 8px #6e5445; cursor:pointer;">Cancel</button>
        </div>
    </div>
</div>
<script>
(function() {
    let modal = document.getElementById('custom-confirm-modal');
    let message = document.getElementById('custom-confirm-message');
    let questDetail = document.getElementById('custom-confirm-quest');
    let okBtn = document.getElementById('custom-confirm-ok');
    let cancelBtn = document.getElementById('custom-confirm-cancel');
    let formToSubmit = null;
    function showModal(msg, form) {
        message.textContent = msg;
        // Get quest title and description from form attributes
        let title = form.getAttribute('data-title') || '';
        let desc = form.getAttribute('data-desc') || '';
        let html = '';
        if (title) {
            html += `<div style=\"font-weight:bold; font-size:1.1rem; margin-bottom:0.3rem; color:#222;\">${title}</div>`;
        }
        if (desc) {
            html += `<div style=\"font-size:1rem; color:#555; background:#f5e6d8; border-radius:0.5rem; padding:0.3rem 0.8rem; display:inline-block;\">${desc}</div>`;
        }
        questDetail.innerHTML = html;
        modal.style.display = 'flex';
        formToSubmit = form;
    }
    function hideModal() {
        modal.style.display = 'none';
        formToSubmit = null;
        questDetail.innerHTML = '';
    }
    document.querySelectorAll('.quest-complete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            showModal('Mark this quest as complete?', form);
        });
    });
    document.querySelectorAll('.quest-delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            showModal('Are you sure you want to delete this quest?', form);
        });
    });
    okBtn.onclick = function() {
        if (formToSubmit) formToSubmit.submit();
        hideModal();
    };
    cancelBtn.onclick = function() {
        hideModal();
    };
    modal.onclick = function(e) {
        if (e.target === modal) hideModal();
    };
})();

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.readd-quest-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var quest = JSON.parse(this.getAttribute('data-quest'));
            // Open modal
            var modal = document.getElementById('add-quest-modal');
            modal.style.display = 'flex';
            // Prefill fields
            document.getElementById('quest-title').value = quest.title || '';
            document.getElementById('quest-desc').value = quest.description || '';
            document.getElementById('quest-date').value = '';
            document.getElementById('quest-time').value = quest.due_time ? quest.due_time.slice(0,5) : '';
            document.querySelector('input[name="duration_hours"]').value = quest.duration_hours || '';
            document.querySelector('input[name="duration_minutes"]').value = quest.duration_minutes || '';
            document.getElementById('quest-priority').value = quest.priority || 'medium';
        });
    });
});
</script>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.readd-quest-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var quest = JSON.parse(this.getAttribute('data-quest'));
            // Open modal
            var modal = document.getElementById('add-quest-modal');
            modal.style.display = 'flex';
            // Prefill fields
            document.getElementById('quest-title').value = quest.title || '';
            document.getElementById('quest-desc').value = quest.description || '';
            document.getElementById('quest-date').value = '';
            document.getElementById('quest-time').value = quest.due_time ? quest.due_time.slice(0,5) : '';
            document.querySelector('input[name="duration_hours"]').value = quest.duration_hours || '';
            document.querySelector('input[name="duration_minutes"]').value = quest.duration_minutes || '';
            document.getElementById('quest-priority').value = quest.priority || 'medium';
        });
    });
});
</script>
@endpush
</x-app-layout> 