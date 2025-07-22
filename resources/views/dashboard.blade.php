<x-app-layout>
    <div style="width:100vw; min-height:100vh; background:var(--background); color:var(--text); font-family:'Inter',sans-serif; overflow-x: hidden;">
        @if(session('success'))
            <div id="toast-success"
                 style="position:fixed; top:2rem; left:50%; transform:translateX(-50%); background:var(--primary); color:var(--text); font-size:1.1rem; padding:0.8rem 2rem; border-radius:0.6rem; box-shadow:0 2px 8px #6e5445; z-index:9999; transition:opacity 0.5s;"
            >
                {{ session('success') }}
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var toast = document.getElementById('toast-success');
                    if (toast) {
                        toast.style.opacity = '0';
                        setTimeout(function(){ toast.remove(); }, 500);
                    }
                    }, 3000);
                });
            </script>
        @endif

        <!-- Date above the main container, aligned left -->
        <div style="width:100%; display:flex; align-items:center; margin-top:2.5rem; margin-left:3.5rem; margin-right:3.5rem; gap:1.5rem; position:relative;">
            <div style="display:flex; align-items:center; gap:1.2rem;">
            <div style="background:var(--date-bg, #D2B78A); color:var(--date-text, #fff); font-size:1.4rem; font-weight:bold; padding:0.5rem 1.8rem; border-radius:0.7rem; display: inline-block; align-self: flex-start;">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</div>
                <button id="add-quest-top-btn" style="background:var(--primary, #7aa2f7); color:#fff; font-size:1.1rem; font-weight:bold; border:none; border-radius:0.7rem; padding:0.5rem 1.5rem; box-shadow:0 2px 8px #6e5445; cursor:pointer; display:flex; align-items:center; gap:0.7rem; transition:background 0.2s;">
                    <span style="font-size:1.3rem; font-weight:bold;">+</span> Add New Quest
                </button>
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:2.5rem; margin:2.5rem 0 1.5rem 3.5rem;">
            <!-- Streaks removed: now shown in top bar -->
        </div>

        <div style="padding-top:0.3rem; margin-top:-4rem;"> <!-- Move containers up, keep date position -->
            <div style="display:flex; width:100%; max-width:calc(100vw - 430px); padding: 2rem; box-sizing: border-box; gap: 2rem; min-height: 100vh; align-items: flex-start; margin-right: 410px;">
                <div style="flex: 2; display:flex; flex-direction:column; gap:1.5rem;">
                    <!-- Today's Quests Section -->
                    <div style="background:var(--quest-container-bg, #CAD7C3); border-radius:1.2rem; box-shadow:2px 2px 12px var(--container-shadow, #6e5445); padding:1.2rem 1.2rem; color:var(--container-text, #4b3a2f); border:2.5px solid var(--highlight-border, #7aa2f7);">
                    <div style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:0.5rem;">
                            <div style="background:var(--upcoming-bg, #99C680); color:#fff; font-size:1.1rem; font-family:'Inter',sans-serif; font-weight:bold; border-radius:0.7rem; padding:0.4rem 1.5rem; letter-spacing:0.03em; width:auto; min-width:0; display:inline-block;">Today's Quests</div>
                    </div>
                        @php
                            $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                            $tomorrow = \Carbon\Carbon::now('Asia/Jakarta')->addDay()->toDateString();
                            $sevenDaysLater = \Carbon\Carbon::now('Asia/Jakarta')->addDays(7)->toDateString();
                            $todaysQuests = $tasks ? $tasks->where('is_completed', false)->filter(function($task) use ($today) {
                                if ($task->source == 'system') return true;
                                return ($task->due_date && \Carbon\Carbon::parse($task->due_date)->toDateString() === $today);
                            }) : collect();
                            $personalQuests = $todaysQuests->filter(function($task) { return $task->source == 'user'; });
                            $dailyQuests = $todaysQuests->filter(function($task) { return $task->source == 'system'; });
                            $upcomingQuests = $tasks ? $tasks->where('is_completed', false)->filter(function($task) use ($today, $sevenDaysLater) {
                                if ($task->source == 'system' || !$task->due_date) return false;
                                $date = \Carbon\Carbon::parse($task->due_date)->toDateString();
                                return $date > $today && $date <= $sevenDaysLater;
                            })->sortBy(function($task) {
                                return \Carbon\Carbon::parse($task->due_date)->toDateString();
                            }) : collect();
                            $groupedUpcoming = $upcomingQuests->groupBy(function($task) {
                                return \Carbon\Carbon::parse($task->due_date)->toDateString();
                            });
                    @endphp
                        @if($todaysQuests->isEmpty())
                            <div style="color:var(--dashboard-empty-text, #fff); font-size:1.1rem; font-family:'Inter',sans-serif; font-weight:bold; margin-top: 0.5rem; margin-bottom: 0.5rem; text-align:left;">No quests for today!</div>
                    @endif
                        @foreach($personalQuests as $task)
                            <div class="quest-item" style="background:var(--quest-card-bg, #DFEDD7); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px var(--quest-card-shadow, #6e544580); padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:stretch; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7); position:relative;" data-quest-item-id="{{ $task->id }}">
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
                                    @php
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
                                </div>
                                <div style="display:flex; align-items:flex-start; gap:1rem; width:100%; margin-top:0.2rem;">
                                    @if($task->description)
                                    <div style="background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;">{{ $task->description }}</div>
                                    @endif
                                        @if($task->source == 'user' && ($task->due_date || $task->due_time))
                                            <div style="display:flex; align-items:center; gap:0.7rem; margin-top:0.2rem;">
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
                                                    <div style="display:inline-flex; align-items:center; gap:0.3rem; font-size:1.05rem; font-weight:bold; color:var(--quest-deadline-text, #654D48); background:var(--quest-deadline-bg, #fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Inter',sans-serif; white-space:nowrap;">
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
                                                            <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.85em; font-weight:500; vertical-align:middle;">{{ $durationStr }}</span>
                                                        @endif
                                                    </div>
                                                @elseif($task->duration_minutes)
                                                    @php
                                                        $hours = intdiv($task->duration_minutes, 60);
                                                        $minutes = $task->duration_minutes % 60;
                                                        $durationStr = '';
                                                        if ($hours > 0) $durationStr .= $hours . 'h ';
                                                        if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                        $durationStr = trim($durationStr);
                                                    @endphp
                                                    <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.98em; font-weight:500; vertical-align:middle;">{{ $durationStr }}</span>
                                                @endif
                                                @endif
                                                <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Inter',sans-serif;">+{{ $expAmount }} EXP</span>
                                            </div>
                                            @if($isOverdue)
                                                <span style="margin-left:0.5rem; background:#fff; color:#e74c3c; border-radius:0.4rem; padding:0.1rem 0.5rem; font-size:0.95em; font-weight:bold;">Overdue!</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div style="display:flex; align-items:center; gap:0.3rem;">
                                    <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline;" class="quest-complete-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_completed" value="1">
                                        <button type="button" onclick="showModal(this)" data-title="{{ $task->title }}" data-desc="{{ $task->description }}" data-action="complete" style="background:var(--quest-btn-complete, #8fc97a); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0;">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 10.5L9 14.5L15 7.5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </button>
                                    </form>
                                    @if($task->source == 'user')
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
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;" class="quest-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showModal(this)" data-title="{{ $task->title }}" data-desc="{{ $task->description }}" data-action="delete" data-quest-id="{{ $task->id }}" style="background:var(--quest-btn-delete, #e74c3c); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; padding:0;">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="8" width="10" height="7" rx="1.5" fill="white"/><rect x="8" y="5" width="4" height="2" rx="1" fill="white"/><rect x="3" y="8" width="14" height="1.5" fill="white"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($dailyQuests->count())
                            <div style="margin:1.2rem 0 0.7rem 0; padding-top:0.2rem; padding-bottom:0.2rem;">
                                <div style="font-size:1.13rem; font-weight:bold; color:#5a5a5a; margin-bottom:0.3em; font-family:'Inter',sans-serif; text-align:left;">Don't know what to do today? Complete these daily quests for extra EXP!</div>
                            </div>
                        @endif
                        @foreach($dailyQuests as $task)
                            <div class="quest-item" style="background:var(--quest-card-bg, #DFEDD7); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:stretch; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7); position:relative;" data-quest-item-id="{{ $task->id }}">
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
                                    @php
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
                                </div>
                                <div style="display:flex; align-items:flex-start; gap:1rem; width:100%; margin-top:0.2rem;">
                                    @if($task->description)
                                    <div style="background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;">{{ $task->description }}</div>
                                    @endif
                                    <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Inter',sans-serif;">+{{ $expAmount }} EXP</span>
                                </div>
                                </div> <!-- FIX: Close quest card content before action buttons -->
                                <div style="display:flex; align-items:center; gap:0.3rem;">
                                    <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline;" class="quest-complete-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_completed" value="1">
                                        <button type="button" onclick="showModal(this)" data-title="{{ $task->title }}" data-desc="{{ $task->description }}" data-action="complete" style="background:var(--quest-btn-complete, #8fc97a); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0;">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 10.5L9 14.5L15 7.5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </button>
                                    </form>
                                    @if($task->source == 'user')
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
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;" class="quest-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showModal(this)" data-title="{{ $task->title }}" data-desc="{{ $task->description }}" data-action="delete" data-quest-id="{{ $task->id }}" style="background:var(--quest-btn-delete, #e74c3c); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; padding:0;">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="8" width="10" height="7" rx="1.5" fill="white" /><rect x="8" y="5" width="4" height="2" rx="1" fill="white" /><rect x="3" y="8" width="14" height="1.5" fill="white" /></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Upcoming Quests Section -->
                    <div style="background:var(--quest-container-bg, #CAD7C3); border-radius:1.2rem; box-shadow:2px 2px 12px #6e5445; padding:1.2rem 1.2rem; color:var(--container-text, #4b3a2f); border:2.5px solid var(--highlight-border, #7aa2f7);">
                        <div style="background:var(--upcoming-bg, #99C680); color:var(--upcoming-text, #fff); font-size:1.1rem; font-family:'Inter',sans-serif; font-weight:bold; border-radius:0.7rem; padding:0.4rem 1.5rem; letter-spacing:0.03em; width:auto; min-width:0; display:inline-block; margin-bottom:0.5rem;">Next 7 Days</div>
                        @if($groupedUpcoming->count())
                            @foreach($groupedUpcoming->sortKeys() as $date => $questsForDate)
                                <div style="font-size:1.13rem; font-weight:bold; color:#5a5a5a; margin-top:1.2em; margin-bottom:0.3em;">
                                    @if($date === $tomorrow)
                                        Tomorrow
                                    @else
                                        {{ \Carbon\Carbon::parse($date)->format('j F Y') }}
                                    @endif
                                </div>
                                @foreach($questsForDate as $task)
                                    <div class="quest-item" style="background:var(--quest-card-bg, #DFEDD7); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:stretch; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7); position:relative;" data-quest-item-id="{{ $task->id }}">
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
                                                @php
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
                                            </div>
                                            <div style="display:flex; align-items:flex-start; gap:1rem; width:100%; margin-top:0.2rem;">
                                                @if($task->description)
                                                    <div style="background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;">{{ $task->description }}</div>
                                                @endif
                                                    @if($task->source == 'user' && ($task->due_date || $task->due_time))
                                                        <div style="display:flex; align-items:center; gap:0.7rem; margin-top:0.2rem;">
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
                                                                <div style="display:inline-flex; align-items:center; gap:0.3rem; font-size:1.05rem; font-weight:bold; color:var(--quest-deadline-text, #654D48); background:var(--quest-deadline-bg, #fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Inter',sans-serif; white-space:nowrap;">
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
                                                                        <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.85em; font-weight:500; vertical-align:middle;">{{ $durationStr }}</span>
                                                                    @endif
                                                                </div>
                                                            @elseif($task->duration_minutes)
                                                                @php
                                                                    $hours = intdiv($task->duration_minutes, 60);
                                                                    $minutes = $task->duration_minutes % 60;
                                                                    $durationStr = '';
                                                                    if ($hours > 0) $durationStr .= $hours . 'h ';
                                                                    if ($minutes > 0) $durationStr .= $minutes . 'm';
                                                                    $durationStr = trim($durationStr);
                                                                @endphp
                                                                <span style="display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.98em; font-weight:500; vertical-align:middle;">{{ $durationStr }}</span>
                                                            @endif
                                                            @endif
                                                            <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Inter',sans-serif;">+{{ $expAmount }} EXP</span>
                                                        </div>
                                                        @if($isOverdue)
                                                            <span style="margin-left:0.5rem; background:#fff; color:#e74c3c; border-radius:0.4rem; padding:0.1rem 0.5rem; font-size:0.95em; font-weight:bold;">Overdue!</span>
                                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div style="display:flex; align-items:center; gap:0.3rem;">
                                                    <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline;" class="quest-complete-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_completed" value="1">
                                    <button type="button" onclick="showModal(this)" data-title="{{ $task->title }}" data-desc="{{ $task->description }}" data-action="complete" style="background:var(--quest-btn-complete, #8fc97a); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0;">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 10.5L9 14.5L15 7.5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                                @if($task->source == 'user')
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
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;" class="quest-delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="showModal(this)" data-title="{{ $task->title }}" data-desc="{{ $task->description }}" data-action="delete" data-quest-id="{{ $task->id }}" style="background:var(--quest-btn-delete, #e74c3c); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; padding:0;">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="8" width="10" height="7" rx="1.5" fill="white" /><rect x="8" y="5" width="4" height="2" rx="1" fill="white" /><rect x="3" y="8" width="14" height="1.5" fill="white" /></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                            @endforeach
                        @else
                            <div style="color:var(--dashboard-empty-text, #fff); font-size:1.1rem; font-family:'Inter',sans-serif; font-weight:bold; margin-top: 0.5rem; margin-bottom: 0.5rem; text-align:left;">No upcoming quests in the next 7 days.</div>
                        @endif
                    </div>
                </div>
                <!-- Right: Calendar Widget -->
                <div style="position:fixed; top:6.5rem; right:2.5rem; width:370px; height:420px; display:flex; flex-direction:column; align-items:center; background:var(--calendar-bg, #D2B78A); border-radius:1.2rem; padding:2.7rem 1.7rem 2.7rem 1.7rem; box-shadow:2px 2px 8px #6e5445; box-sizing: border-box; color:var(--container-text, #4b3a2f); border:2.5px solid var(--calendar-border, var(--highlight-border, #7aa2f7)); z-index:10;">
                    <div style="position:absolute; top:0; left:0; right:0; height:56px; background:var(--calendar-top-bg, #403232); border-radius:1.2rem 1.2rem 0 0; display:flex; align-items:center; gap:0.7rem; justify-content:center; z-index:1; color:var(--calendar-header-text,#fff);">
                        <button id="prev-month-btn" style="background:none; border:none; color:var(--calendar-header-text,#fff); font-size:1.3rem; cursor:pointer; margin-right:0.5rem;">&#8592;</button>
                        <div style="position:fixed; top:6.5rem; right:2.5rem; width:370px; height:420px; display:flex; flex-direction:column; align-items:center; background:var(--calendar-bg, #D2B78A); border-radius:1.2rem; padding:2.7rem 1.7rem 2.7rem 1.7rem; box-shadow:2px 2px 8px #6e5445; box-sizing: border-box; color:var(--container-text, #4b3a2f); border:2.5px solid var(--highlight-border, #7aa2f7); z-index:10;">
                    <div style="position:absolute; top:0; left:0; right:0; height:56px; background:var(--calendar-top-bg, #403232); border-radius:1.2rem 1.2rem 0 0; display:flex; align-items:center; gap:0.7rem; justify-content:center; z-index:1;">
                        <button id="prev-month-btn" style="background:none; border:none; color:var(--calendar-header-text,#fff); font-size:1.3rem; cursor:pointer; margin-right:0.5rem;">&#8592;</button>
                        <select id="calendar-month-select" style="font-size:1.1rem; border-radius:0.4rem; border:1.5px solid #b28b67; background:var(--calendar-header-bg, #fff); color:var(--calendar-header-text, #403232); padding:0.1rem 1.7rem 0.1rem 0.5rem; margin:0 0.3rem; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg fill=%27%23403232%27 height=%2712%27 viewBox=%270 0 20 20%27 width=%2712%27 xmlns=%27http://www.w3.org/2000/svg%27><path d=%27M6 8l4 4 4-4%27 stroke=%27%23403232%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 fill=%27none%27/></svg>'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1rem;">
                            <option value="0">January</option>
                            <option value="1">February</option>
                            <option value="2">March</option>
                            <option value="3">April</option>
                            <option value="4">May</option>
                            <option value="5">June</option>
                            <option value="6">July</option>
                            <option value="7">August</option>
                            <option value="8">September</option>
                            <option value="9">October</option>
                            <option value="10">November</option>
                            <option value="11">December</option>
                        </select>
                        <select id="calendar-year-select" style="font-size:1.1rem; border-radius:0.4rem; border:1.5px solid #b28b67; background:var(--calendar-header-bg, #fff); color:var(--calendar-header-text, #403232); padding:0.1rem 1.7rem 0.1rem 0.5rem; margin:0 0.3rem; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg fill=%27%23403232%27 height=%2712%27 viewBox=%270 0 20 20%27 width=%2712%27 xmlns=%27http://www.w3.org/2000/svg%27><path d=%27M6 8l4 4 4-4%27 stroke=%27%23403232%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 fill=%27none%27/></svg>'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1rem;">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                        <button id="next-month-btn" style="background:none; border:none; color:var(--calendar-header-text,#fff); font-size:1.3rem; cursor:pointer; margin-left:0.5rem;">&#8594;</button>
                    </div>
                    <div id="calendar-grid" style="display:grid; grid-template-columns: repeat(7, 1fr); gap: 0.3rem; text-align: center; font-size:1rem; width:100%; justify-items:stretch; align-items:stretch; margin-top:1.2rem;"></div>
                        <div id="calendar-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:99999; align-items:center; justify-content:center;">
                            <div id="calendar-modal-content" style="background:var(--modal-bg, #f5e6d8); color:var(--modal-text, var(--text, #222)); border-radius:1.2rem; box-shadow:0 6px 32px #0008; padding:2.7rem 2.7rem 2.7rem 2.7rem; min-width:480px; max-width:98vw; position:relative; display:flex; flex-direction:column; align-items:center;">
                                <div style="width:100%; display:flex; align-items:center; justify-content:space-between; margin-bottom:1.2rem;">
                                    <div id="calendar-modal-date" style="font-size:1.3rem; font-weight:bold;">Quests on ...</div>
                                    <button onclick="document.getElementById('calendar-modal').style.display='none'" style="background:none; border:none; font-size:2.1rem; color:var(--modal-close-btn, #e74c3c); cursor:pointer; margin-left:1.2rem; border-radius:0.5rem; width:2.3rem; height:2.3rem; display:flex; align-items:center; justify-content:center;">&times;</button>
                                </div>
                                <div id="calendar-modal-list" style="width:100%;"></div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Notification Container -->
    <div id="custom-notification" style="display:none; position:fixed; top:2rem; left:50%; transform:translateX(-50%); background:var(--primary,#7aa2f7); color:var(--text, #fff); font-size:1.1rem; padding:0.8rem 2rem; border-radius:0.6rem; box-shadow:0 2px 8px #6e5445; z-index:99999; transition:opacity 0.5s;"></div>
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
                            <option value="low">🔵 Low</option>
                            <option value="medium">🟠 Medium</option>
                            <option value="high">🔴 High</option>
                        </select>
                        <span style="position:absolute; right:1.2rem; top:50%; transform:translateY(-50%); pointer-events:none; font-size:1.1rem; color:#888;">▼</span>
                    </div>
                    <button type="submit" style="font-size:1.1rem; padding:0.9rem 2.2rem; width:100%; margin-top:0.7rem; background:#99C680 !important; color:var(--modal-btn-text, #fff); border-radius:0.7rem; border:none; font-weight:bold; box-shadow:2px 2px 8px #0002; cursor:pointer; transition:background 0.2s;">Update Quest</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const allTasks = @json($tasks);
        const calendarGrid = document.getElementById('calendar-grid');
        const monthSelect = document.getElementById('calendar-month-select');
        const yearSelect = document.getElementById('calendar-year-select');
        const prevMonthBtn = document.getElementById('prev-month-btn');
        const nextMonthBtn = document.getElementById('next-month-btn');

        let today = new Date();
        let selectedMonth = today.getMonth();
        let selectedYear = today.getFullYear();

        function fillYearOptions() {
            const currentYear = today.getFullYear();
            for (let y = currentYear - 3; y <= currentYear + 3; y++) {
                let opt = document.createElement('option');
                opt.value = y;
                opt.textContent = y;
                if (y === selectedYear) opt.selected = true;
                yearSelect.appendChild(opt);
            }
        }

        function renderCalendar(month, year) {
            // Clear grid
            calendarGrid.innerHTML = '';
            // Days of week
            const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            for (let d of daysOfWeek) {
                let cell = document.createElement('div');
                cell.textContent = d;
                cell.style.fontWeight = 'bold';
                cell.style.color = 'var(--primary, #6e5445)';
                cell.style.aspectRatio = '1/1';
                cell.style.display = 'flex';
                cell.style.alignItems = 'center';
                cell.style.justifyContent = 'center';
                calendarGrid.appendChild(cell);
            }
            // First day of month
            let firstDay = new Date(year, month, 1).getDay();
            let daysInMonth = new Date(year, month + 1, 0).getDate();
            // Previous month's trailing days (optional: leave blank)
            for (let i = 0; i < firstDay; i++) {
                let cell = document.createElement('div');
                cell.style.background = 'transparent';
                cell.style.color = 'transparent';
                calendarGrid.appendChild(cell);
            }
            // Days of month
            for (let date = 1; date <= daysInMonth; date++) {
                let cell = document.createElement('div');
                cell.className = 'calendar-date-cell';
                cell.dataset.date = date;
                cell.style.aspectRatio = '1/1';
                cell.style.width = '100%';
                cell.style.maxWidth = '38px';
                cell.style.minWidth = '28px';
                cell.style.display = 'flex';
                cell.style.alignItems = 'center';
                cell.style.justifyContent = 'center';
                cell.style.borderRadius = '50%';
                cell.style.fontWeight = 'bold';
                cell.style.margin = '0 auto';
                cell.style.cursor = 'pointer';
                cell.style.transition = 'background 0.18s, color 0.18s';
                cell.style.position = 'relative';
                cell.innerHTML = `<span>${date}</span>`;
                // Highlight today
                if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    cell.style.background = 'var(--highlight-border, #7aa2f7)';
                    cell.style.color = '#403232';
                    cell.style.boxShadow = '0 0 0 2px var(--highlight-border, #7aa2f7)';
                    cell.style.border = '2.5px solid #403232';
                } else {
                    cell.style.color = 'var(--quest-card-text, #c0caf5)';
                    cell.style.background = '#fff';
                }
                // Dot if quest exists
                let hasQuest = allTasks.some(task => {
                    if (!task.due_date || task.is_completed) return false;
                    let d = new Date(task.due_date);
                    return d.getDate() === date && d.getMonth() === month && d.getFullYear() === year;
                });
                if (hasQuest) {
                    let dot = document.createElement('span');
                    dot.style.position = 'absolute';
                    dot.style.left = '50%';
                    dot.style.bottom = '2px';
                    dot.style.transform = 'translateX(-50%)';
                    dot.style.display = 'block';
                    dot.style.width = '7px';
                    dot.style.height = '7px';
                    dot.style.borderRadius = '50%';
                    dot.style.background = '#99C680';
                    cell.appendChild(dot);
                }
                cell.onclick = function() { showQuestsForDate(date, month, year); };
                cell.onmouseover = function() { cell.style.background = '#99C680'; cell.style.color = '#fff'; };
                cell.onmouseout = function() {
                    if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        cell.style.background = 'var(--highlight-border, #7aa2f7)';
                        cell.style.color = '#403232';
                    } else {
                        cell.style.background = '#fff';
                        cell.style.color = 'var(--quest-card-text, #c0caf5)';
                    }
                };
                calendarGrid.appendChild(cell);
            }
        }

        function updateCalendarHeader() {
            monthSelect.value = selectedMonth;
            yearSelect.value = selectedYear;
        }

        monthSelect.onchange = function() {
            selectedMonth = parseInt(monthSelect.value);
            renderCalendar(selectedMonth, selectedYear);
        };
        yearSelect.onchange = function() {
            selectedYear = parseInt(yearSelect.value);
            renderCalendar(selectedMonth, selectedYear);
        };
        prevMonthBtn.onclick = function() {
            selectedMonth--;
            if (selectedMonth < 0) {
                selectedMonth = 11;
                selectedYear--;
            }
            updateCalendarHeader();
            renderCalendar(selectedMonth, selectedYear);
        };
        nextMonthBtn.onclick = function() {
            selectedMonth++;
            if (selectedMonth > 11) {
                selectedMonth = 0;
                selectedYear++;
            }
            updateCalendarHeader();
            renderCalendar(selectedMonth, selectedYear);
        };
        fillYearOptions();
        updateCalendarHeader();
        renderCalendar(selectedMonth, selectedYear);

        function showQuestsForDate(date, month = selectedMonth, year = selectedYear) {
            if (!date || date === '') return;
            const modal = document.getElementById('calendar-modal');
            const modalDate = document.getElementById('calendar-modal-date');
            const modalList = document.getElementById('calendar-modal-list');
            modal.style.display = 'flex';
            modalDate.textContent = 'Quests on ' + date + ' ' + monthSelect.options[month].text + ' ' + year;
            // Filter tasks by day
            const quests = allTasks.filter(task => {
                if (!task.due_date || task.is_completed) return false;
                const d = new Date(task.due_date);
                return d.getDate() == date && d.getMonth() == month && d.getFullYear() == year;
            });
            if (quests.length === 0) {
                modalList.innerHTML = '<div style="color:#888; font-size:1.1rem; text-align:center;">No quests on this date.</div>';
            } else {
                modalList.innerHTML = quests.map(task => {
                    let isOverdue = false;
                    let expAmount = 50;
                    let priorityColor = '#CAD7C3';
                    if (task.priority === 'high') priorityColor = '#E74C3C';
                    else if (task.priority === 'medium') priorityColor = '#F5A623';
                    else if (task.priority === 'low') priorityColor = '#4A90E2';
                    if (task.source === 'user') {
                        const now = new Date();
                        const dueDate = new Date(task.due_date);
                        // Only overdue if today is after due date
                        isOverdue = !task.is_completed && now.setHours(0,0,0,0) > dueDate.setHours(0,0,0,0);
                        if (task.priority === 'low') {
                            expAmount = 30;
                        } else if (task.priority === 'high') {
                            expAmount = 70;
                        } else {
                            expAmount = 50;
                        }
                        if (isOverdue) expAmount = 10;
                    }
                    let badge = '';
                    if (task.source === 'system') {
                        badge = `<span style=\"background:var(--quest-badge-bg-daily, #99D877); color:var(--quest-badge-text-daily, #183408); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;\">★ Daily</span>`;
                    } else {
                        badge = `<span style=\"background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;\">● Personal</span>`;
                    }
                    return `<div class='quest-item' style=\"background:var(--quest-card-bg, #DFEDD7); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:stretch; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7); position:relative;\" data-quest-item-id='${task.id}'>
                        <div style=\"position:absolute; top:0; bottom:0; left:0; width:8px; border-radius:0.7rem 0 0 0.7rem; background:${priorityColor};\"></div>
                        <div style='font-family:Inter,sans-serif; display:flex; flex-direction:column; gap:0.3rem; flex-grow: 1; margin-right: 1rem; padding-left:16px;'>
                            <div style='display:flex; align-items:center; gap:0.5rem;'>
                                ${badge}
                                <div style=\"display:flex; align-items:center; gap:0.7em;\">
                                    <span style=\"font-size:1.25rem; font-weight:bold; font-family:'Inter',sans-serif;\">${task.title}</span>
                                </div>
                            </div>
                            <div style='display:flex; align-items:flex-start; gap:1rem; width:100%; margin-top:0.2rem;'>
                                ${task.description && task.description.trim() !== '' ? `<div style='background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;'>${task.description}</div>` : ''}
                                ${(task.source === 'user' && (task.due_date || task.due_time)) ? `<div style=\"display:flex; align-items:center; gap:0.7rem; margin-top:0.2rem;\">
                                    ${task.due_time ? (() => {
                                        let formattedTime = task.due_time;
                                        // Try to parse as ISO or time string
                                        let dateObj = new Date(task.due_time);
                                        if (!isNaN(dateObj.getTime())) {
                                            let hours = dateObj.getHours().toString().padStart(2, '0');
                                            let minutes = dateObj.getMinutes().toString().padStart(2, '0');
                                            formattedTime = `${hours}:${minutes}`;
                                        } else {
                                            const match = formattedTime.match(/([01]\\d|2[0-3]):([0-5]\\d)/);
                                            if (match) {
                                                formattedTime = match[0];
                                            }
                                        }
                                        return `<div style=\"display:inline-flex; align-items:center; gap:0.3rem; font-size:1.05rem; font-weight:bold; color:var(--quest-deadline-text, #654D48); background:var(--quest-deadline-bg, #fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Inter',sans-serif; white-space:nowrap;\">
                                            ${formattedTime}
                                            ${task.duration_minutes ? (() => {
                                                let hours = Math.floor(task.duration_minutes / 60);
                                                let minutes = task.duration_minutes % 60;
                                                let durationStr = '';
                                                if (hours > 0) durationStr += hours + 'h ';
                                                if (minutes > 0) durationStr += minutes + 'm';
                                                durationStr = durationStr.trim();
                                                return `<span style=\"display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.85em; font-weight:500; vertical-align:middle;\">${durationStr}</span>`;
                                            })() : ''}
                                        </div>`;
                                    })() : (task.duration_minutes ? (() => {
                                        let hours = Math.floor(task.duration_minutes / 60);
                                        let minutes = task.duration_minutes % 60;
                                        let durationStr = '';
                                        if (hours > 0) durationStr += hours + 'h ';
                                        if (minutes > 0) durationStr += minutes + 'm';
                                        durationStr = durationStr.trim();
                                        return `<span style=\"display:inline-block; background:#99C680; color:#fff; border-radius:1em; padding:0.18em 0.9em; font-size:0.98em; font-weight:500; vertical-align:middle;\">${durationStr}</span>`;
                                    })() : '')}
                                    <span style=\"display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Inter',sans-serif;\">+${expAmount} EXP</span>
                                </div>` : ''}
                            </div>
                        </div>
                        <div style='display:flex; align-items:center; gap:0.3rem;'>
                            <form method=\"POST\" action=\"/tasks/${task.id}\" style=\"display:inline;\" class=\"quest-complete-form\" id=\"complete-form-${task.id}\">
                                <input type=\"hidden\" name=\"_token\" value=\"${document.querySelector('meta[name=csrf-token]').content}\">
                                <input type=\"hidden\" name=\"_method\" value=\"PUT\">
                                <input type=\"hidden\" name=\"is_completed\" value=\"1\">
                                <button type=\"button\" onclick=\"showModal(this)\" data-title=\"${task.title.replace(/\"/g, '&quot;')}\" data-desc=\"${(task.description||'').replace(/\"/g, '&quot;')}\" data-action=\"complete\" style=\"background:var(--quest-btn-complete, #8fc97a); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0;\">
                                    <svg width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M5 10.5L9 14.5L15 7.5\" stroke=\"white\" stroke-width=\"2.2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/></svg>
                                </button>
                            </form>
                            <button class="open-edit-quest-modal" data-quest='${JSON.stringify({
                                id: task.id,
                                title: task.title,
                                description: task.description,
                                due_date: task.due_date,
                                due_time: task.due_time,
                                duration_hours: task.duration_minutes ? Math.floor(task.duration_minutes / 60) : '',
                                duration_minutes: task.duration_minutes ? task.duration_minutes % 60 : '',
                                priority: task.priority
                            })}' style="background:var(--quest-btn-edit, #f5a623); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem; padding:0; text-decoration:none;" title="Edit Quest">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 13.5V16H6.5L14.1 8.4C14.3 8.2 14.3 7.9 14.1 7.7L12.3 5.9C12.1 5.7 11.8 5.7 11.6 5.9L4 13.5ZM16.7 6.3C17.1 5.9 17.1 5.3 16.7 4.9L15.1 3.3C14.7 2.9 14.1 2.9 13.7 3.3L12.1 4.9L15.1 7.9L16.7 6.3Z" fill="white"/></svg>
                            </button>
                            <form method=\"POST\" action=\"/tasks/${task.id}\" style=\"display:inline;\" class=\"quest-delete-form\" id=\"delete-form-${task.id}\">
                                <input type=\"hidden\" name=\"_token\" value=\"${document.querySelector('meta[name=csrf-token]').content}\">
                                <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                                <button type=\"button\" onclick=\"showModal(this)\" data-title=\"${task.title.replace(/\"/g, '&quot;')}\" data-desc=\"${(task.description||'').replace(/\"/g, '&quot;')}\" data-action=\"delete\" data-quest-id=\"${task.id}\" style=\"background:var(--quest-btn-delete, #e74c3c); color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.25rem; display:flex; align-items:center; justify-content:center; cursor:pointer; padding:0;\">
                                    <svg width=\"20\" height=\"20\" viewBox=\"0 0 20 20\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><rect x=\"5\" y=\"8\" width=\"10\" height=\"7\" rx=\"1.5\" fill=\"white\"/><rect x=\"8\" y=\"5\" width=\"4\" height=\"2\" rx=\"1\" fill=\"white\"/><rect x=\"3\" y=\"8\" width=\"14\" height=\"1.5\" fill=\"white\"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>`;
                }).join('');
            }
        }

        // Add this function to update the calendar after quest deletion
        function updateCalendarAfterAction() {
            // Re-render the calendar to reflect changes
            renderCalendar(selectedMonth, selectedYear);
            
            // If the modal is open, update its content
            const modal = document.getElementById('calendar-modal');
            if (modal.style.display === 'flex') {
                const currentDate = document.getElementById('calendar-modal-date').textContent;
                const dateMatch = currentDate.match(/Quests on (\d+) /);
                if (dateMatch) {
                    const date = parseInt(dateMatch[1]);
                    showQuestsForDate(date, selectedMonth, selectedYear);
                }
            }
        }

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

        let formToSubmit = null;

        window.showModal = function(button) {
            const modal = document.getElementById('custom-confirm-modal');
            const message = document.getElementById('custom-confirm-message');
            const questDetail = document.getElementById('custom-confirm-quest');
            const form = button.closest('form');
            const action = button.getAttribute('data-action');
            if (action === 'complete') {
                message.textContent = 'Mark this quest as complete?';
            } else if (action === 'delete') {
                message.textContent = 'Are you sure you want to delete this quest?';
            }
            // Show quest details
            let title = button.getAttribute('data-title') || '';
            let desc = button.getAttribute('data-desc') || '';
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
        };

        document.addEventListener('DOMContentLoaded', function() {
            let modal = document.getElementById('custom-confirm-modal');
            let okBtn = document.getElementById('custom-confirm-ok');
            let cancelBtn = document.getElementById('custom-confirm-cancel');
            
            function hideModal() {
                modal.style.display = 'none';
                formToSubmit = null;
            }
            
            okBtn.onclick = function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
                hideModal();
            };
            
            cancelBtn.onclick = hideModal;
            
            modal.onclick = function(e) {
                if (e.target === modal) hideModal();
            };
        });

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

        document.addEventListener('click', function(e) {
            let btn = e.target.closest('.open-edit-quest-modal');
            if (btn) {
                const questData = btn.getAttribute('data-quest');
                if (questData && typeof openEditQuestModal === 'function') {
                    openEditQuestModal(JSON.parse(questData));
                }
            }
        });

        window.openEditQuestModal = function(quest) {
            var editQuestModal = document.getElementById('edit-quest-modal');
            // Populate modal fields
            document.getElementById('edit-quest-title').value = quest.title || '';
            document.getElementById('edit-quest-desc').value = quest.description || '';
            var dateInput = document.getElementById('edit-quest-date');
            if (quest.due_date) {
                if (/^\d{4}-\d{2}-\d{2}$/.test(quest.due_date)) {
                    dateInput.value = quest.due_date;
                } else {
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
        };
        // Close logic for edit modal
        if (document.getElementById('close-edit-quest')) {
            document.getElementById('close-edit-quest').onclick = function() {
                document.getElementById('edit-quest-modal').style.display = 'none';
            };
        }
        if (document.getElementById('edit-quest-modal')) {
            document.getElementById('edit-quest-modal').onclick = function(e) {
                if (e.target === this) this.style.display = 'none';
            };
        }
    </script>
        @if(session('quest_notification'))
        <script>
        window.addEventListener('DOMContentLoaded', function() {
            window.dispatchEvent(new CustomEvent('quest-action', { detail: @json(session('quest_notification')) }));
        });
        </script>
        @endif
</x-app-layout>
