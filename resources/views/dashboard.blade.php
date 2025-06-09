<x-app-layout>
    <div style="width:100vw; min-height:100vh; background:var(--background); color:var(--text); font-family:'Segoe UI',sans-serif; overflow-x: hidden;">
        @if(session('success'))
            <div id="toast-success"
                 style="position:fixed; top:2rem; left:50%; transform:translateX(-50%); background:var(--primary); color:var(--text); font-size:1.1rem; padding:0.8rem 2rem; border-radius:0.6rem; box-shadow:0 2px 8px #6e5445; z-index:9999; transition:opacity 0.5s;"
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

        <!-- Date above the main container, aligned left -->
        <div style="width:100%; display:flex; justify-content:space-between; align-items:center; margin-top:2.5rem; margin-left:3.5rem; margin-right:3.5rem; gap:1.5rem;">
            <div style="background:var(--date-bg, #D2B78A); color:#fff; font-size:1.4rem; font-weight:bold; padding:0.5rem 1.8rem; border-radius:0.7rem; display: inline-block; align-self: flex-start;">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</div>
        </div>

        <div style="display:flex; align-items:center; gap:2.5rem; margin:2.5rem 0 1.5rem 3.5rem;">
            <!-- Streaks removed: now shown in top bar -->
        </div>

        <div style="padding-top:0.3rem; margin-top:-4rem;"> <!-- Move containers up, keep date position -->
            <div style="display:flex; width:100%; padding: 2rem; box-sizing: border-box; gap: 2rem;">
                <!-- Left: Upcoming Quests Section -->
                <div style="flex: 2; display:flex; flex-direction:column; gap:0.5rem; background:var(--quest-container-bg, #CAD7C3); border-radius:1.2rem; box-shadow:2px 2px 12px #6e5445; padding:1.2rem 1.2rem; color:var(--container-text, #4b3a2f); border:2.5px solid var(--highlight-border, #7aa2f7);">
                    <!-- Upcoming Quests Title as a pill label matching Side Quests -->
                    <div style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:0.5rem;">
                        <div style="background:#99C680; color:#fff; font-size:1.1rem; font-family:'Inter',sans-serif; font-weight:bold; border-radius:0.7rem; padding:0.4rem 1.5rem; letter-spacing:0.03em; width:auto; min-width:0; display:inline-block;">Upcoming Quests</div>
                        <button id="add-quest-top-btn" style="background:var(--primary, #7aa2f7); color:#fff; font-size:1.1rem; font-weight:bold; border:none; border-radius:0.7rem; padding:0.5rem 1.5rem; box-shadow:0 2px 8px #6e5445; cursor:pointer; display:flex; align-items:center; gap:0.7rem; transition:background 0.2s;">
                            <span style="font-size:1.3rem; font-weight:bold;">+</span> Add New Quest
                        </button>
                    </div>

                    <!-- Quest Items -->
                    @php
                        $upcomingQuests = $tasks ? $tasks->where('is_completed', false)->sortBy('deadline') : collect();
                    @endphp
                    @if($upcomingQuests->isEmpty())
                        <div style="color:#fff; font-size:1.1rem; font-family:'Comic Sans MS',cursive; font-weight:bold; margin-top: 0.5rem;">No upcoming quests!</div>
                    @endif
                    @foreach($upcomingQuests as $task)
                        <div class="quest-item" style="background:var(--quest-card-bg, #fdf6d8); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:center; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7);">
                            <div style="font-family:'Inter',sans-serif; display:flex; flex-direction:column; gap:0.3rem; flex-grow: 1; margin-right: 1rem;">
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    @if($task->source == 'system')
                                        <span style="background:var(--quest-badge-bg-daily, #99D877); color:var(--quest-badge-text-daily, #183408); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;">★ Daily</span>
                                    @else
                                        <span style="background:var(--quest-badge-bg-personal, #345222); color:var(--quest-badge-text, #fff); font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem; white-space:nowrap; flex-shrink:0;">● Personal</span>
                                    @endif
                                    <span style="font-weight:bold; font-family:'Inter',sans-serif; word-break:break-word; overflow-wrap:anywhere; max-width:90%; display:inline-block;">
                                        @if($task->priority === 'high')
                                            <span style="background:#E74C3C; color:#fff; font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem;">High</span>
                                        @elseif($task->priority === 'medium')
                                            <span style="background:#F5A623; color:#fff; font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem;">Medium</span>
                                        @elseif($task->priority === 'low')
                                            <span style="background:#4A90E2; color:#fff; font-size:0.9rem; font-weight:bold; border-radius:0.7rem; padding:0.1rem 0.8rem; margin-right:0.3rem;">Low</span>
                                        @endif
                                        {{ $task->title }}
                                    </span>
                                    @php
                                        $isOverdue = !$task->is_completed && \Carbon\Carbon::now('Asia/Jakarta')->gt(\Carbon\Carbon::parse($task->deadline, 'Asia/Jakarta'));
                                        $expAmount = $task->source === 'user' ? ($isOverdue ? 20 : 50) : 50;
                                    @endphp
                                    <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Segoe UI',sans-serif; margin-left:0.7rem; white-space:nowrap; flex-shrink:0;">+{{ $expAmount }} EXP</span>
                                </div>
                                <div style="display:flex; align-items:flex-start; gap:1rem; width:100%; margin-top:0.2rem;">
                                    @if(!empty($task->description))
                                    <div style="background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;">{{ $task->description }}</div>
                                    @endif
                                    @if($task->source == 'user')
                                        <span style="display:inline-block; font-size:1.05rem; font-weight:bold; color:{{ $isOverdue ? '#fff' : 'var(--quest-deadline-text, #b8860b)' }}; background:{{ $isOverdue ? '#e74c3c' : 'var(--quest-deadline-bg, #fffbe6)' }}; border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Segoe UI',sans-serif; white-space:nowrap; flex-shrink:0; margin-left:1rem;">
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
                                @if($task->source == 'user')
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this quest?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:var(--quest-btn-delete, #e74c3c); color:var(--quest-btn-text, #fff); border:none; border-radius:50%; width:36px; height:36px; font-size:1.3rem; display:flex; align-items:center; justify-content:center; cursor:pointer;">🗑️</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Right: Calendar Widget -->
                <div style="flex: 0 0 370px; display:flex; flex-direction:column; align-items:center; background:var(--calendar-bg, #D2B78A); border-radius:1.2rem; padding:1.7rem 1.7rem 2.7rem 1.7rem; box-shadow:2px 2px 8px #6e5445; width: 370px; height: 420px; box-sizing: border-box; flex-shrink: 0; color:var(--container-text, #4b3a2f); border:2.5px solid var(--highlight-border, #7aa2f7);">
                    <div style="font-size:1.1rem; font-weight:bold; margin-bottom:0.7rem; color:#fff; background:#403232; padding: 0.4rem 1rem; border-radius: 0.6rem; display:flex; align-items:center; gap:0.7rem; justify-content:center;">
                        <button id="prev-month-btn" style="background:none; border:none; color:#fff; font-size:1.3rem; cursor:pointer; margin-right:0.5rem;">&#8592;</button>
                        <select id="calendar-month-select" style="font-size:1.1rem; border-radius:0.4rem; border:1.5px solid #b28b67; background:#fff; color:#403232; padding:0.1rem 1.7rem 0.1rem 0.5rem; margin:0 0.3rem; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg fill=\'%23403232\' height=\'12\' viewBox=\'0 0 20 20\' width=\'12\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M5.516 7.548a.625.625 0 0 1 .884-.032L10 10.885l3.6-3.369a.625.625 0 1 1 .852.914l-4.025 3.77a.625.625 0 0 1-.852 0l-4.025-3.77a.625.625 0 0 1-.032-.884z\'/></svg>'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1rem;">
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
                        <select id="calendar-year-select" style="font-size:1.1rem; border-radius:0.4rem; border:1.5px solid #b28b67; background:#fff; color:#403232; padding:0.1rem 1.7rem 0.1rem 0.5rem; margin:0 0.3rem; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg fill=\'%23403232\' height=\'12\' viewBox=\'0 0 20 20\' width=\'12\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M5.516 7.548a.625.625 0 0 1 .884-.032L10 10.885l3.6-3.369a.625.625 0 1 1 .852.914l-4.025 3.77a.625.625 0 0 1-.852 0l-4.025-3.77a.625.625 0 0 1-.032-.884z\'/></svg>'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1rem;">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                        <button id="next-month-btn" style="background:none; border:none; color:#fff; font-size:1.3rem; cursor:pointer; margin-left:0.5rem;">&#8594;</button>
                    </div>
                    <div id="calendar-grid" style="display:grid; grid-template-columns: repeat(7, 1fr); gap: 0.3rem; text-align: center; font-size:1rem; width:100%; justify-items:stretch; align-items:stretch;"></div>
                        <div id="calendar-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:99999; align-items:center; justify-content:center;">
                            <div id="calendar-modal-content" style="background:var(--modal-bg, #f5e6d8); color:var(--modal-text, var(--text, #222)); border-radius:1.2rem; box-shadow:0 6px 32px #0008; padding:2.7rem 2.7rem 2.7rem 2.7rem; min-width:480px; max-width:98vw; position:relative; display:flex; flex-direction:column; align-items:center;">
                                <div style="width:100%; display:flex; align-items:center; justify-content:space-between; margin-bottom:1.2rem;">
                                    <div id="calendar-modal-date" style="font-size:1.3rem; font-weight:bold;">Quests on ...</div>
                                    <button onclick="document.getElementById('calendar-modal').style.display='none'" style="background:none; border:none; font-size:2.1rem; color:#e74c3c; cursor:pointer; margin-left:1.2rem; border-radius:0.5rem; width:2.3rem; height:2.3rem; display:flex; align-items:center; justify-content:center;">&times;</button>
                                </div>
                                <div id="calendar-modal-list" style="width:100%;"></div>
                            </div>
                    </div>
                </div>
            </div>
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
                } else {
                    cell.style.color = 'var(--quest-card-text, #c0caf5)';
                    cell.style.background = 'var(--container-bg, #23243a)';
                }
                // Dot if quest exists
                let hasQuest = allTasks.some(task => {
                    if (!task.deadline) return false;
                    let d = new Date(task.deadline);
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
                        cell.style.background = 'var(--container-bg, #23243a)';
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
                if (!task.deadline) return false;
                const d = new Date(task.deadline);
                return d.getDate() == date && d.getMonth() == month && d.getFullYear() == year;
            });
            if (quests.length === 0) {
                modalList.innerHTML = '<div style="color:#888; font-size:1.1rem; text-align:center;">No quests on this date.</div>';
            } else {
                modalList.innerHTML = quests.map(task => {
                    let isOverdue = false;
                    let expAmount = 50;
                    if (task.source === 'user') {
                        const now = new Date();
                        const deadline = new Date(task.deadline);
                        isOverdue = !task.is_completed && now > deadline;
                        expAmount = isOverdue ? 20 : 50;
                    }
                    return `<div class='quest-item' style="background:var(--quest-card-bg, #fdf6d8); color:var(--quest-card-text, #4b3a2f); border-radius:0.7rem; box-shadow:1px 1px 6px #6e544580; padding:0.5rem 1rem; font-size:1.1rem; display:flex; align-items:center; justify-content:space-between; margin-bottom:0.3rem; border:2.5px solid var(--highlight-border, #7aa2f7);">
                        <div style='font-family:Inter,sans-serif; display:flex; flex-direction:column; gap:0.3rem; flex-grow: 1; margin-right: 1rem;'>
                            <div style='display:flex; align-items:center; gap:0.5rem;'>
                                <span style="background:var(--quest-badge-bg-personal,#345222);color:var(--quest-badge-text,#fff);font-size:0.9rem;font-weight:bold;border-radius:0.7rem;padding:0.1rem 0.8rem;margin-right:0.3rem;">● Personal</span>
                                <span style='font-weight:bold; font-family:Inter,sans-serif; word-break:break-word; overflow-wrap:anywhere; max-width:90%; display:inline-block;'>${task.title}</span>
                                <span style="display:inline-block; font-size:0.98rem; font-weight:bold; color:#fff; background:#7ed957; border-radius:0.5rem; padding:0.18rem 0.7rem; font-family:'Segoe UI',sans-serif; margin-left:0.7rem;">+${expAmount} EXP</span>
                            </div>
                            <div style='display:flex; align-items:flex-start; gap:1rem; width:100%;'>
                                ${task.description && task.description.trim() !== '' ? `<div style='background:var(--quest-desc-bg, #fffbe6); border-radius:0.7rem; padding:0.25rem 0.7rem; display:inline-block; color:var(--quest-desc-text, #222); font-size:1.08rem; font-family:Segoe UI,sans-serif; font-weight:500; word-break:break-word; overflow-wrap:anywhere; white-space:pre-line; max-width:95%; min-width:0; width:auto;'>${task.description}</div>` : ''}
                                ${task.source === 'user' && task.deadline ? `<span style="display:inline-block; font-size:1.05rem; font-weight:bold; color:var(--quest-deadline-text,#654D48); background:var(--quest-deadline-bg,#fffbe6); border-radius:0.5rem; padding:0.2rem 0.8rem; font-family:'Segoe UI',sans-serif;">Deadline: ${new Date(task.deadline).toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}${isOverdue ? '<span style=\"margin-left:0.5rem; background:#fff; color:#e74c3c; border-radius:0.4rem; padding:0.1rem 0.5rem; font-size:0.95em; font-weight:bold;\">Overdue!</span>' : ''}</span>` : ''}
                            </div>
                        </div>
                        <div style='display:flex; align-items:center; gap:0.3rem;'>
                            <form method="POST" action="/tasks/${task.id}" style="display:inline;" onsubmit="return confirm('Mark this quest as complete?');">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="is_completed" value="1">
                                <button type="submit" style="background:var(--quest-btn-complete, #8fc97a); color:var(--quest-btn-text, #fff); border:none; border-radius:50%; width:36px; height:36px; font-size:1.3rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.2rem;">✅</button>
                            </form>
                            <form method="POST" action="/tasks/${task.id}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this quest?');">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" style="background:var(--quest-btn-delete, #e74c3c); color:var(--quest-btn-text, #fff); border:none; border-radius:50%; width:36px; height:36px; font-size:1.3rem; display:flex; align-items:center; justify-content:center; cursor:pointer;">🗑️</button>
                            </form>
                        </div>
                    </div>`;
                }).join('');
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
    </script>
</x-app-layout>
