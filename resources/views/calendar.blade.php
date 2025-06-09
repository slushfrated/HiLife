<x-app-layout>
<style>
    .calendar-container {
        max-width: 1200px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 12px #0001;
        padding: 2rem 2rem 1.5rem 2rem;
    }
    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .calendar-header .nav-btn {
        background: #f76c7b;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 1.3rem;
        padding: 0.4rem 1.1rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .calendar-header .nav-btn:hover {
        background: #e05566;
    }
    .calendar-header .month-label {
        font-size: 1.3rem;
        font-weight: bold;
        letter-spacing: 0.03em;
    }
    .calendar-legend {
        display: flex;
        gap: 2.5rem;
        align-items: center;
        margin-bottom: 1.2rem;
        font-size: 1.05rem;
        justify-content: center;
    }
    .calendar-legend span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .calendar-legend .dot {
        width: 1.1rem;
        height: 1.1rem;
        border-radius: 50%;
        display: inline-block;
    }
    .calendar-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
    }
    .calendar-table th, .calendar-table td {
        width: 14.28%;
        aspect-ratio: 1/1;
        min-width: 120px;
        max-width: 180px;
        min-height: 90px;
        max-height: 140px;
        height: 130px;
        text-align: left;
        vertical-align: top;
        border: 1px solid #eee;
        padding: 0;
        position: relative;
        background: #fff;
        box-sizing: border-box;
        /* overflow: hidden; */
    }
    .calendar-table td > div {
        height: 100%;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        padding: 0.3rem 0.5rem 0.2rem 0.5rem;
        scrollbar-width: thin;
        scrollbar-color: #f76c7b #f7f7f7;
    }
    .calendar-table td > div::-webkit-scrollbar {
        width: 6px;
    }
    .calendar-table td > div::-webkit-scrollbar-thumb {
        background: #f76c7b;
        border-radius: 4px;
    }
    .calendar-table th {
        background: #faf7f7;
        font-weight: bold;
        text-align: center;
        font-size: 1.08rem;
        color: #b28b67;
        border-bottom: 2px solid #f76c7b;
    }
    .calendar-table td.inactive {
        background: #f7f7f7;
        color: #bbb;
    }
    .calendar-event {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f6e6a7;
        color: #222;
        border-radius: 6px;
        padding: 0.2rem 0.7rem;
        font-size: 0.98rem;
        font-weight: 500;
        margin-top: 0.15rem;
        margin-bottom: 0.1rem;
        box-shadow: 0 1px 4px #0001;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
    .calendar-event span, .calendar-event {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        display: inline-block;
    }
    .calendar-event.lecture {
        background: #c6f7f7;
        color: #222;
    }
    .calendar-event.assessment {
        background: #f6e6a7;
        color: #222;
    }
    .calendar-event.both {
        background: #bdb2f7;
        color: #222;
    }
    @media (max-width: 700px) {
        .calendar-container { padding: 0.5rem; }
        .calendar-table th, .calendar-table td { min-width: 40px; font-size: 0.95rem; }
    }
</style>
<div class="calendar-container">
    <div class="calendar-header">
        <button class="nav-btn" id="prevMonthBtn">&#8592;</button>
        <span style="display: flex; flex-direction: column; align-items: center;">
            <span id="calendarLabel" style="font-size:1.2rem; font-weight:bold; margin-bottom:0.3rem;"></span>
            <span style="display: flex; align-items: center; gap: 1.2rem;">
                <select id="monthSelect" style="font-size:1.1rem; padding:0.2rem 0.7rem; border-radius:6px; border:1px solid #ccc;">
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
                <select id="yearSelect" style="font-size:1.1rem; padding:0.2rem 0.7rem; border-radius:6px; border:1px solid #ccc; min-width: 80px;"></select>
            </span>
        </span>
        <button class="nav-btn" id="nextMonthBtn">&#8594;</button>
    </div>
    <div class="calendar-legend" style="margin-bottom: 1.2rem;">
        <span><span class="dot" style="background:#4A90E2;"></span>Low</span>
        <span><span class="dot" style="background:#F5A623;"></span>Medium</span>
        <span><span class="dot" style="background:#E74C3C;"></span>High</span>
    </div>
    <table class="calendar-table">
        <thead>
            <tr>
                <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
            </tr>
        </thead>
        <tbody id="calendarBody">
            <!-- Calendar rows will be rendered here -->
        </tbody>
    </table>
</div>
<script>
// Pass personal quests from PHP to JS
const events = @json($personalQuests);

let currentMonth = (new Date()).getMonth();
let currentYear = (new Date()).getFullYear();

// Populate year dropdown
const yearSelect = document.getElementById('yearSelect');
const thisYear = (new Date()).getFullYear();
for (let y = thisYear - 10; y <= thisYear + 10; y++) {
    const opt = document.createElement('option');
    opt.value = y;
    opt.textContent = y;
    yearSelect.appendChild(opt);
}

document.getElementById('monthSelect').value = currentMonth;
yearSelect.value = currentYear;

document.getElementById('monthSelect').onchange = function() {
    currentMonth = parseInt(this.value);
    renderCalendar(currentMonth, currentYear);
};
yearSelect.onchange = function() {
    currentYear = parseInt(this.value);
    renderCalendar(currentMonth, currentYear);
};

function renderCalendar(month, year) {
    document.getElementById('monthSelect').value = month;
    document.getElementById('yearSelect').value = year;
    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    document.getElementById('calendarLabel').textContent = `${monthNames[month]} ${year}`;
    const calendarBody = document.getElementById('calendarBody');

    // First day of the month
    const firstDay = new Date(year, month, 1).getDay();
    // Number of days in the month
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    let date = 1;
    let rows = '';
    for (let i = 0; i < 6; i++) { // 6 weeks max
        let row = '<tr>';
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
                row += '<td class="inactive"></td>';
            } else if (date > daysInMonth) {
                row += '<td class="inactive"></td>';
            } else {
                // Find events for this date
                const dayStr = `${year}-${String(month+1).padStart(2,'0')}-${String(date).padStart(2,'0')}`;
                const dayEvents = events.filter(e => e.date === dayStr);
                row += `<td><div>`;
                row += `<span style="font-weight:bold; margin-bottom:2px;">${date}</span>`;
                for (const ev of dayEvents) {
                    let bgColor = '#F5A623'; // default medium
                    if (ev.priority === 'high') bgColor = '#E74C3C';
                    else if (ev.priority === 'low') bgColor = '#4A90E2';
                    row += `<div class="calendar-event assessment" style="background:${bgColor}; color:#fff;"><span style='font-weight:bold;'>${ev.time}</span> ${ev.title}</div>`;
                }
                row += `</div></td>`;
                date++;
            }
        }
        row += '</tr>';
        rows += row;
        if (date > daysInMonth) break;
    }
    calendarBody.innerHTML = rows;
}

document.getElementById('prevMonthBtn').onclick = function() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    renderCalendar(currentMonth, currentYear);
};
document.getElementById('nextMonthBtn').onclick = function() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar(currentMonth, currentYear);
};

renderCalendar(currentMonth, currentYear);
</script>
</x-app-layout> 