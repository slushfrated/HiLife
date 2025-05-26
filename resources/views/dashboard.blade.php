<x-app-layout>
    <div style="width:100vw; min-height:100vh; background:#8B6842; color:#fff; font-family:'Segoe UI',sans-serif;">
        @if(session('success'))
            <div id="toast-success"
                 style="position:fixed; top:2rem; left:50%; transform:translateX(-50%); background:#8fc97a; color:#fff; font-size:1.2rem; padding:1rem 2.5rem; border-radius:0.7rem; box-shadow:0 2px 8px #6e5445; z-index:9999; transition:opacity 0.5s;"
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
        <!-- EXP Bar + Goodmorning Navbar -->
        <div style="background:#6e5445; padding:1.2rem 0 1.2rem 0; display:flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100vw; z-index:100;">
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
        <div style="display:flex; width:100vw; min-height:80vh;">
            <!-- Left: Quests -->
            <div style="flex:2; padding:2.5rem 2rem 2rem 6rem;">
                <!-- Date and Clock at the top -->
                <div style="display:flex; align-items:center; margin-bottom:2.2rem;">
                    <span style="font-size:6rem; margin-right:1.2rem; border:5px solid #222; border-radius:50%; background:#f9d6d5; color:#222; width:110px; height:110px; display:flex; align-items:center; justify-content:center;">🕒</span>
                    <span style="background:#8fc97a; color:#fff; font-size:1.7rem; font-weight:bold; padding:0.7rem 2.2rem; border-radius:0.7rem; box-shadow:2px 2px 4px #6e5445;">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</span>
                </div>
                <!-- Add Quest and View All Quests Buttons -->
                <div style="display:flex; align-items:center; gap:1.2rem; margin-bottom:2.2rem;">
                    <button id="open-add-quest" style="width:180px; font-size:1.3rem; font-family:'Comic Sans MS',cursive; background:#8fc97a; color:#fff; border-radius:0.6rem; border:none; padding:0.7rem 0; font-weight:bold; box-shadow:2px 2px 8px #6e5445; cursor:pointer;">Add Quest</button>
                    <a href="{{ route('quests') }}" style="text-decoration:none;">
                        <button style="width:260px; font-size:1.3rem; font-family:'Comic Sans MS',cursive; background:#d2c1ad; color:#4b3a2f; border-radius:0.6rem; border:4px solid #cfc1ad; padding:0.7rem 0; font-weight:bold; box-shadow:2px 2px 8px #6e5445; cursor:pointer;">View All Quests</button>
                    </a>
                </div>
                {{-- Add Quest Modal --}}
                <div id="add-quest-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:2000; align-items:center; justify-content:center;">
                    <div style="background:#fffbe6; color:#4b3a2f; border-radius:1.2rem; box-shadow:0 4px 24px #6e5445cc; padding:2.5rem 2.5rem 2rem 2.5rem; min-width:350px; max-width:90vw; position:relative; display:flex; flex-direction:column; align-items:center;">
                        <button id="close-add-quest" style="position:absolute; top:1.2rem; right:1.5rem; background:none; border:none; font-size:2.2rem; color:#b28b67; cursor:pointer;">&times;</button>
                        <div style="font-size:1.7rem; font-family:'Comic Sans MS',cursive; font-weight:bold; margin-bottom:1.5rem;">Add New Quest</div>
                        <form method="POST" action="{{ route('tasks.store') }}" style="display:flex; flex-direction:column; gap:1.2rem; width:100%; align-items:center;">
                            @csrf
                            <input type="text" name="title" placeholder="Quest title" required style="color:#222; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; font-size:1.1rem; width:260px;">
                            <input type="text" name="description" placeholder="Description (optional)" style="color:#222; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; font-size:1.1rem; width:260px;">
                            <input type="datetime-local" name="deadline" placeholder="Deadline (optional)" style="color:#222; padding:0.7rem 1.2rem; border-radius:0.7rem; border:none; font-size:1.1rem; width:260px;">
                            <button type="submit" class="btn-green" style="font-size:1.1rem; padding:0.7rem 2.2rem; width:180px; margin-top:0.7rem;">Add Quest</button>
                        </form>
                    </div>
                </div>
                {{-- Upcoming Side Quest Section (move this above Daily Quests) --}}
                <div style="background:rgba(255,255,255,0.07); border-radius:1.2rem; padding:1.2rem 1.2rem 1.2rem 1.2rem; min-height:60px; position:relative; margin-bottom:1.2rem;">
                    <span style="position:absolute; top:0.7rem; left:1.2rem; background:#d2c1ad; color:#4b3a2f; font-size:1rem; font-weight:bold; border-radius:0.5rem; padding:0.15rem 0.8rem; font-family:'Comic Sans MS',cursive; box-shadow:0 2px 8px #cfc1ad; letter-spacing:0.03em; margin-bottom:0.7rem;">Upcoming side quest</span>
                    @php
                        $userTasks = $tasks ? $tasks->where('source', 'user') : collect();
                        $nearestTask = $userTasks->whereNotNull('deadline')->where('deadline', '>=', now())->sortBy('deadline')->first();
                        if (!$nearestTask) {
                            $nearestTask = $userTasks->first();
                        }
                    @endphp
                    @if(!$nearestTask)
                        <div style="color:#fff; margin-bottom:1rem; font-size:1.1rem; display:flex; align-items:center; justify-content:center; font-family:'Comic Sans MS',cursive; font-weight:bold; margin-top:1.2rem;">No active quests</div>
                    @else
                        <div class="quest-item" style="background:#f5e6d8; color:#4b3a2f; border-radius:0.7rem; margin-top:2.2rem; margin-bottom:0.5rem; box-shadow:2px 2px 8px #6e5445; padding:0.7rem 1.2rem; font-size:1.2rem; display:flex; align-items:center; justify-content:space-between;">
                            <div style="font-family:'Comic Sans MS',cursive; display:flex; align-items:center; gap:0.5rem;">
                                {{ $nearestTask->title }}
                                @if($nearestTask->description)
                                    <span style="color:#b28b67; font-size:0.95rem; margin-left:0.7rem; font-family:sans-serif;">{{ $nearestTask->description }}</span>
                                @endif
                                @if($nearestTask->deadline)
                                    @php $isOverdue = !$nearestTask->is_completed && \Carbon\Carbon::parse($nearestTask->deadline)->isPast(); @endphp
                                    <span style="display:inline-block; margin-left:0.7rem; font-size:0.95rem; font-weight:bold; color:{{ $isOverdue ? '#e74c3c' : '#b8860b' }}; background:{{ $isOverdue ? '#fbeaea' : '#fffbe6' }}; border-radius:0.5rem; padding:0.15rem 0.7rem;">Deadline: {{ \Carbon\Carbon::parse($nearestTask->deadline)->format('M d, Y H:i') }}@if($isOverdue) (Overdue)@endif</span>
                                @endif
                            </div>
                            <div style="display:flex; align-items:center; gap:0.2rem;">
                                <form method="POST" action="{{ route('tasks.update', $nearestTask) }}" style="display:inline;" class="complete-quest-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_completed" value="1">
                                    <input type="hidden" name="redirect" value="false">
                                    <button type="submit" style="background:#8fc97a; color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:1rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.1rem;">✅</button>
                                </form>
                                <form method="POST" action="{{ route('tasks.destroy', $nearestTask) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#e74c3c; color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:1rem; display:flex; align-items:center; justify-content:center; cursor:pointer;">🗑️</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
                <div style="width:100%; display:flex; justify-content:center; align-items:center; margin:0.5rem 0 1rem 0;">
                    <hr style="width:80%; border:0; border-top:2.5px dashed #b28b67; margin:0;">
                </div>
                {{-- Daily Quests Section --}}
                <div style="background:rgba(255,255,255,0.07); border-radius:1.2rem; padding:1.2rem 1.2rem 1.2rem 1.2rem; margin-bottom:1.2rem; min-height:60px; position:relative;">
                    <span style="position:absolute; top:0.7rem; left:1.2rem; background:#ffe066; color:#b8860b; font-size:1rem; font-weight:bold; border-radius:0.5rem; padding:0.15rem 0.8rem; font-family:'Comic Sans MS',cursive; box-shadow:0 2px 8px #ffe066; letter-spacing:0.03em; margin-bottom:0.7rem;">Daily Quests</span>
                    @php $systemTasks = $tasks ? $tasks->where('source', 'system') : collect(); @endphp
                    @php $systemCount = $systemTasks->count(); @endphp
                    @if($systemCount === 0)
                        <div style="color:#fff; margin-bottom:1rem; font-size:1.1rem; display:flex; align-items:center; justify-content:center; font-family:'Comic Sans MS',cursive; font-weight:bold; margin-top:1.2rem;">Congratulations, you have completed all daily quests!</div>
                    @endif
                    @php $firstSystem = true; @endphp
                    @foreach($systemTasks as $task)
                        <div class="quest-item" style="background:#fdf6d8; color:#4b3a2f; border-radius:0.7rem; {{ $firstSystem ? 'margin-top:2.2rem;' : '' }} margin-bottom:0.5rem; box-shadow:2px 2px 8px #6e5445; padding:0.7rem 1.2rem; font-size:1.2rem; display:flex; align-items:center; justify-content:space-between; border-left:8px solid #ffe066;">
                            <div style="font-family:'Comic Sans MS',cursive; display:flex; align-items:center; gap:0.5rem;">
                                <span style="background:#ffe066; color:#b8860b; font-size:0.95rem; font-weight:bold; border-radius:0.5rem; padding:0.15rem 0.7rem; margin-right:0.3rem; display:flex; align-items:center; gap:0.2rem; box-shadow:0 2px 8px #ffe066;">✨ Daily</span>
                                {{ $task->title }}
                                @if($task->description)
                                    <span style="color:#b28b67; font-size:0.95rem; margin-left:0.7rem; font-family:sans-serif;">{{ $task->description }}</span>
                                @endif
                                @if($task->deadline)
                                    @php $isOverdue = !$task->is_completed && \Carbon\Carbon::parse($task->deadline)->isPast(); @endphp
                                    <span style="display:inline-block; margin-left:0.7rem; font-size:0.95rem; font-weight:bold; color:{{ $isOverdue ? '#e74c3c' : '#b8860b' }}; background:{{ $isOverdue ? '#fbeaea' : '#fffbe6' }}; border-radius:0.5rem; padding:0.15rem 0.7rem;">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y H:i') }}@if($isOverdue) (Overdue)@endif</span>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('tasks.update', $task) }}" style="display:inline; margin-left:0.3rem;" class="complete-quest-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_completed" value="1">
                                <input type="hidden" name="redirect" value="false">
                                <button type="submit" style="background:#8fc97a; color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:1rem; display:flex; align-items:center; justify-content:center; cursor:pointer; margin-right:0.1rem;">✅</button>
                            </form>
                        </div>
                        @php $firstSystem = false; @endphp
                    @endforeach
                </div>
                {{-- Show the most recently completed task for fade-out --}}
                @if(isset($recentCompleted) && $recentCompleted)
                    <div class="quest-item completed-quest" data-completed="1" style="margin-top:1.5rem; display:flex; align-items:center; font-size:2rem; font-family:'Comic Sans MS',cursive;">
                        <span style="font-size:2.2rem; color:#FFD700; margin-right:0.7rem;">★</span>
                        <span style="margin-right:1rem;">{{ $recentCompleted->title }}</span>
                        @if($recentCompleted->description)
                            <span style="color:#ffe4b3; font-size:1.1rem; margin-right:1rem; font-family:sans-serif;">{{ $recentCompleted->description }}</span>
                        @endif
                        <span style="color:#8fc97a; font-size:1.1rem; margin-left:1rem; font-family:sans-serif;">Completed!</span>
                    </div>
                @endif
            </div>
            <!-- Right: Profile/Level/Note -->
            <div style="flex:1; background:#b28b67; min-height:100vh; padding:2.5rem 2rem 2rem 2rem; display:flex; flex-direction:column; align-items:center;">
                <div style="width:110px; height:110px; border-radius:50%; background:#eee; border:5px solid #fff; margin-bottom:1.2rem; display:flex; align-items:center; justify-content:center;">
                    <img src="https://www.svgrepo.com/show/382106/avatar-boy-face-man-10.svg" alt="avatar" style="width:80px; height:80px; opacity:0.7;">
                </div>
                <div style="font-size:2rem; font-family:'Comic Sans MS',cursive; margin-bottom:2.2rem;">{{ Auth::user()->name ?? 'Username' }}</div>
                <!-- Level Calendar -->
                <div style="position:relative; width:110px; margin-bottom:2.2rem;">
                    <div style="position:absolute; top:-18px; left:0; right:0; margin:auto; width:110px; height:60px; background:#fff; border-radius:0.5rem; box-shadow:2px 2px 8px #6e5445; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                        <div style="position:absolute; top:0; left:18px; width:15px; height:15px; background:#222; border-radius:50%;"></div>
                        <div style="position:absolute; top:0; right:18px; width:15px; height:15px; background:#222; border-radius:50%;"></div>
                        <div style="background:#e74c3c; color:#fff; font-size:1.1rem; font-weight:bold; border-radius:0.3rem; padding:0.1rem 0.7rem; margin-top:0.5rem;">Level</div>
                        <div style="font-size:2.2rem; color:#222; font-family:monospace;">{{ Auth::user()->level ?? '00' }}</div>
                    </div>
                </div>
                <!-- Note to self -->
                <textarea id="note" placeholder="Tap to give note to self!" style="width:100%; min-height:140px; border-radius:0.7rem; border:none; background:#c7a37a; color:#fff; font-size:1.1rem; padding:1rem; margin-top:2rem; opacity:0.7; resize:none;">{{ Auth::user()->note?->content }}</textarea>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Note to self script
            const noteTextarea = document.getElementById('note');
            let timeout;
            if (noteTextarea) {
                noteTextarea.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        fetch('{{ route("notes.update") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                content: this.value
                            })
                        });
                    }, 500);
                });
            }

            // Fade out completed quests after 3 seconds
            document.querySelectorAll('.quest-item.completed-quest').forEach(function(el) {
                setTimeout(function() {
                    el.style.transition = 'opacity 0.7s';
                    el.style.opacity = '0';
                    setTimeout(function() {
                        el.remove();
                    }, 700);
                }, 3000); // 3 seconds
            });

            // Add Quest Modal logic
            const openAddQuest = document.getElementById('open-add-quest');
            const closeAddQuest = document.getElementById('close-add-quest');
            const addQuestModal = document.getElementById('add-quest-modal');
            if (openAddQuest && closeAddQuest && addQuestModal) {
                openAddQuest.onclick = function() {
                    addQuestModal.style.display = 'flex';
                };
                closeAddQuest.onclick = function() {
                    addQuestModal.style.display = 'none';
                };
                addQuestModal.onclick = function(e) {
                    if (e.target === addQuestModal) {
                        addQuestModal.style.display = 'none';
                    }
                };
            }

            // Prevent redirect when completing a quest from dashboard
            document.querySelectorAll('.complete-quest-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    }).then(response => {
                        if (response.ok) {
                            // Optionally, remove the quest item from the DOM or update UI
                            const questItem = this.closest('.quest-item');
                            if (questItem) {
                                questItem.style.transition = 'opacity 0.7s';
                                questItem.style.opacity = '0';
                                setTimeout(() => questItem.remove(), 700);
                            }
                            // Show completion notification
                            const notification = document.createElement('div');
                            notification.style.position = 'fixed';
                            notification.style.top = '2rem';
                            notification.style.left = '50%';
                            notification.style.transform = 'translateX(-50%)';
                            notification.style.background = '#8fc97a';
                            notification.style.color = '#fff';
                            notification.style.fontSize = '1.2rem';
                            notification.style.padding = '1rem 2.5rem';
                            notification.style.borderRadius = '0.7rem';
                            notification.style.boxShadow = '0 2px 8px #6e5445';
                            notification.style.zIndex = '9999';
                            notification.style.transition = 'opacity 0.5s';
                            notification.textContent = 'Quest completed!';
                            document.body.appendChild(notification);
                            setTimeout(function() {
                                notification.style.opacity = '0';
                                setTimeout(function() { notification.remove(); }, 500);
                            }, 2500);
                        }
                    });
                });
            });
        });

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
