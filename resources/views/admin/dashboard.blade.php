@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $statusClasses = [
        'draft' => 'bg-slate-100 text-slate-600',
        'published' => 'bg-emerald-50 text-emerald-600',
        'upcoming' => 'bg-sky-50 text-sky-600',
        'approved' => 'bg-blue-50 text-blue-600',
        'completed' => 'bg-violet-50 text-violet-600',
        'archived' => 'bg-slate-100 text-slate-500',
        'pending' => 'bg-amber-50 text-amber-600',
        'rejected' => 'bg-rose-50 text-rose-600',
    ];
    $summaryScale = max(1, collect($monthlyEventSummary)->max('value'));
@endphp

<div class="dashboard-page dashboard-shell-content">
    <div class="mx-auto max-w-7xl">
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Dashboard</p>
        <section class="mb-8 grid items-start gap-5 lg:grid-cols-[minmax(0,1fr)_22rem]">
            <div class="min-w-0 space-y-5">
                <header class="flex flex-col justify-start self-start pt-1">
                    <h1 class="text-3xl font-extrabold leading-tight text-slate-900 sm:text-4xl" style="font-family: 'Plus Jakarta Sans', sans-serif;">Halo, {{ auth()->user()->name }}!</h1>
                    <p class="mt-2 text-sm font-medium text-slate-500 sm:text-base">Berikut ringkasan aktivitas hari ini.</p>
                </header>

                <section class="dashboard-stats-grid grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($stats as $stat)
                        <article class="dashboard-stat-card dashboard-overview-card dashboard-stat-card-{{ $loop->iteration }}">
                            <div class="flex items-start justify-between gap-2">
                                <span class="stat-card-icon flex h-7 w-7 shrink-0 items-center justify-center" style="{{ $stat['iconStyle'] }}"><i class="bi {{ $stat['icon'] }} text-base"></i></span>
                                <a href="{{ $stat['url'] }}" class="stat-card-arrow" aria-label="Buka {{ $stat['label'] }}" title="Buka {{ $stat['label'] }}"><i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                            </div>
                            <p class="mt-1 text-xs font-medium text-slate-500">{{ $stat['label'] }}</p>
                            <p class="mt-0.5 text-lg font-extrabold tracking-tight text-slate-900">{{ $stat['value'] }}</p>
                            <p class="mt-0.5 text-[10px] font-medium text-slate-500">{{ $stat['detail'] }}</p>
                        </article>
                    @endforeach
                </section>

                <article class="dashboard-white-card rounded-3xl border border-slate-100 bg-white p-5 shadow-sm dashboard-panel-card sm:p-6">
                    <div class="flex items-end justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Ringkasan Event Bulanan</h2>
                            <p class="mt-1 text-xs text-slate-500">Event berlangsung per bulan</p>
                        </div>
                        <div class="flex shrink-0 items-center gap-1">
                            @if ($previousChartYear)
                                <a href="{{ route('admin.dashboard', ['chart_year' => $previousChartYear]) }}" class="inline-flex h-7 w-7 items-center justify-center text-slate-500 transition hover:text-sky-700" aria-label="Tahun {{ $previousChartYear }}" title="Tahun {{ $previousChartYear }}"><i class="bi bi-chevron-left" aria-hidden="true"></i></a>
                            @else
                                <span class="inline-flex h-7 w-7 items-center justify-center text-slate-300"><i class="bi bi-chevron-left" aria-hidden="true"></i></span>
                            @endif
                            <span class="min-w-10 text-center text-xs font-bold text-slate-700" data-chart-year="{{ $chartYear }}">{{ $chartYear }}</span>
                            @if ($nextChartYear)
                                <a href="{{ route('admin.dashboard', ['chart_year' => $nextChartYear]) }}" class="inline-flex h-7 w-7 items-center justify-center text-slate-500 transition hover:text-sky-700" aria-label="Tahun {{ $nextChartYear }}" title="Tahun {{ $nextChartYear }}"><i class="bi bi-chevron-right" aria-hidden="true"></i></a>
                            @else
                                <span class="inline-flex h-7 w-7 items-center justify-center text-slate-300"><i class="bi bi-chevron-right" aria-hidden="true"></i></span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-5 grid h-36 grid-cols-12 items-end gap-1 sm:gap-2" role="img" aria-label="Grafik jumlah event per bulan tahun {{ $chartYear }}">
                        @foreach ($monthlyEventSummary as $item)
                            @php($barHeight = $item['value'] > 0 ? max(6, ($item['value'] / $summaryScale) * 100) : 0)
                            <div class="flex h-full min-w-0 flex-col items-center justify-end gap-1.5" data-year="{{ $chartYear }}" data-month="{{ $item['month'] }}" data-count="{{ $item['value'] }}" title="{{ $item['label'] }} {{ $chartYear }}: {{ $item['value'] }} event">
                                <span class="text-[9px] font-medium text-slate-500 sm:text-[10px]">{{ $item['value'] }}</span>
                                <div class="flex h-24 w-full items-end justify-center">
                                    <div class="w-2.5 rounded-t-sm bg-sky-500 transition-all sm:w-3" style="height: {{ $barHeight }}%"></div>
                                </div>
                                <span class="text-[9px] font-medium text-slate-500 sm:text-[10px]">{{ $item['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="dashboard-white-card flex flex-col rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dashboard-panel-card">
                    <h2 class="text-lg font-bold text-slate-800">Event Terbaru</h2>
                    <div class="mt-6 flex-1 divide-y divide-slate-100">
                        @forelse ($recentEvents as $event)
                            @php($status = strtolower($event->status ?? 'draft'))
                            <div class="flex items-center gap-4 py-3.5 first:pt-0 last:pb-0">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sm font-bold uppercase text-sky-600">{{ \Illuminate\Support\Str::substr($event->name, 0, 2) }}</span>
                                <div class="min-w-0 flex-1"><p class="truncate text-base font-bold text-slate-800">{{ $event->name }}</p><p class="mt-0.5 truncate text-sm text-slate-400">{{ $event->category?->name ?? 'Tanpa kategori' }}{{ $event->start_date ? ' · ' . $event->start_date->translatedFormat('d M Y') : '' }}</p></div>
                                <span class="shrink-0 rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses[$status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($status) }}</span>
                            </div>
                        @empty
                            <p class="py-8 text-center text-sm text-slate-400">Belum ada event di database.</p>
                        @endforelse
                    </div>
                </article>

                <article class="dashboard-white-card rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dashboard-panel-card">
                    <h2 class="text-lg font-bold text-slate-800">Sponsor Teratas</h2>
                    <div class="mt-5 divide-y divide-slate-50">
                        @forelse ($topSponsors as $sponsor)
                            <div class="flex items-center gap-4 py-3 first:pt-0 last:pb-0"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sm font-semibold text-sky-600">{{ $loop->iteration }}</span><div class="min-w-0 flex-1"><p class="truncate text-base text-slate-600">{{ $sponsor->name }}</p><p class="mt-0.5 text-xs text-slate-400">{{ $sponsor->tier ?: 'Sponsor' }}</p></div><span class="shrink-0 rounded-full bg-sky-50 px-3 py-1 text-xs font-medium text-sky-600">{{ $sponsor->events_count }} event</span></div>
                        @empty
                            <p class="py-6 text-center text-sm text-slate-400">Belum ada sponsor di database.</p>
                        @endforelse
                    </div>
                </article>

            </div>

            <div class="min-w-0 space-y-6">
            <article class="relative mx-auto w-full max-w-[22rem] min-w-0 rounded-2xl border border-blue-100 bg-white p-4 shadow-sm lg:mx-0 lg:justify-self-end" data-dashboard-calendar data-year="{{ $currentYear }}" data-save-note-url="{{ route('admin.dashboard.calendar-notes.store') }}" data-delete-note-url="{{ route('admin.dashboard.calendar-notes.destroy') }}">
                <div class="mb-2 flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold text-slate-400">Kalender event</p>
                        <h2 class="mt-0.5 truncate text-sm font-bold text-slate-900" data-calendar-month aria-live="polite"></h2>
                    </div>
                    <div class="flex shrink-0 items-center gap-1">
                        <button type="button" data-calendar-previous class="inline-flex h-8 w-8 items-center justify-center text-sky-700 transition hover:text-sky-900 disabled:cursor-not-allowed disabled:text-slate-300" aria-label="Bulan sebelumnya">
                            <i class="bi bi-chevron-left" aria-hidden="true"></i>
                        </button>
                        <button type="button" data-calendar-next class="inline-flex h-8 w-8 items-center justify-center text-sky-700 transition hover:text-sky-900 disabled:cursor-not-allowed disabled:text-slate-300" aria-label="Bulan berikutnya">
                            <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-1 grid grid-cols-7 gap-1 text-center text-[10px] font-semibold text-slate-400" role="row">
                    @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $weekday)
                        <span role="columnheader" class="py-1">{{ $weekday }}</span>
                    @endforeach
                </div>
                <div class="grid grid-cols-7 justify-items-center gap-x-1 gap-y-0" data-calendar-grid role="grid" aria-label="Tanggal kalender"></div>
                <div class="mt-2">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-xs font-semibold text-slate-700" data-calendar-selected-date></p>
                        <span class="text-[10px] text-slate-400" data-calendar-event-count></span>
                    </div>
                    <ul class="mt-1 space-y-1" data-calendar-event-list aria-live="polite"></ul>
                </div>
                <div class="absolute z-50 hidden w-72 max-w-[calc(100vw-2rem)]" data-calendar-note-editor>
                    <section class="w-full rounded-2xl border border-blue-100 bg-white p-4 shadow-xl" role="dialog" aria-labelledby="calendar-note-title">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold text-slate-400">Catatan tanggal</p>
                                <h3 id="calendar-note-title" class="mt-1 text-sm font-bold text-slate-800" data-calendar-note-title></h3>
                            </div>
                            <button type="button" data-calendar-note-cancel class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-slate-400 transition hover:text-slate-700" aria-label="Tutup catatan"><i class="bi bi-x-lg text-sm" aria-hidden="true"></i></button>
                        </div>
                        <textarea id="calendar-note" data-calendar-note rows="3" maxlength="1000" placeholder="Tulis catatan..." class="w-full resize-y rounded-xl border border-blue-100 bg-blue-50/50 px-3 py-2 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-2 focus:ring-sky-100"></textarea>
                        <div class="mt-3 flex items-center justify-between gap-2">
                            <p class="min-h-4 text-[10px] text-slate-500" data-calendar-note-status role="status" aria-live="polite"></p>
                            <div class="flex shrink-0 items-center gap-2">
                                <button type="button" data-calendar-note-delete hidden class="text-xs font-semibold text-rose-600 hover:text-rose-700">Hapus</button>
                                <button type="button" data-calendar-note-save class="rounded-full bg-sky-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-sky-700 disabled:cursor-wait disabled:opacity-60">Simpan</button>
                            </div>
                        </div>
                    </section>
                </div>
            </article>
            <article class="dashboard-white-card rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dashboard-panel-card">
                <h2 class="text-lg font-bold text-slate-800">Aktivitas Terkini</h2>
                <div class="mt-5 divide-y divide-slate-50">
                    @forelse ($recentActivities as $activity)
                        <div class="flex gap-4 py-3.5 first:pt-0 last:pb-0"><span class="mt-1.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-50 text-slate-500"><i class="bi {{ $activity['icon'] }}"></i></span><div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-700">{{ $activity['label'] }}</p><p class="mt-1 text-xs text-slate-400">{{ $activity['type'] }} · {{ $activity['created_at']?->diffForHumans() ?? 'Tanggal tidak tersedia' }}</p></div></div>
                    @empty
                        <p class="py-6 text-center text-sm text-slate-400">Belum ada aktivitas untuk ditampilkan.</p>
                    @endforelse
                </div>
            </article>
            </div>
        </section>

    </div>
</div>

@push('scripts')
<script>
    const dashboardCalendar = document.querySelector('[data-dashboard-calendar]');

    if (dashboardCalendar) {
        const calendarYear = Number(dashboardCalendar.dataset.year);
        const calendarEvents = {{ Illuminate\Support\Js::from($calendarEvents) }};
        const calendarNotes = new Map(Object.entries({{ Illuminate\Support\Js::from($calendarNotes) }}));
        const calendarGrid = dashboardCalendar.querySelector('[data-calendar-grid]');
        const monthHeading = dashboardCalendar.querySelector('[data-calendar-month]');
        const selectedDateHeading = dashboardCalendar.querySelector('[data-calendar-selected-date]');
        const eventCount = dashboardCalendar.querySelector('[data-calendar-event-count]');
        const eventList = dashboardCalendar.querySelector('[data-calendar-event-list]');
        const noteEditor = dashboardCalendar.querySelector('[data-calendar-note-editor]');
        const noteTitle = dashboardCalendar.querySelector('[data-calendar-note-title]');
        const previousButton = dashboardCalendar.querySelector('[data-calendar-previous]');
        const nextButton = dashboardCalendar.querySelector('[data-calendar-next]');
        const noteInput = dashboardCalendar.querySelector('[data-calendar-note]');
        const noteStatus = dashboardCalendar.querySelector('[data-calendar-note-status]');
        const saveNoteButton = dashboardCalendar.querySelector('[data-calendar-note-save]');
        const deleteNoteButton = dashboardCalendar.querySelector('[data-calendar-note-delete]');
        const cancelNoteButton = dashboardCalendar.querySelector('[data-calendar-note-cancel]');
        const noteCsrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const monthFormatter = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric', timeZone: 'UTC' });
        const dateFormatter = new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC' });
        const eventsByDate = new Map();
        const makeDateKey = (year, month, day) => `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const parseDateKey = (dateKey) => {
            const [year, month, day] = dateKey.split('-').map(Number);
            return new Date(Date.UTC(year, month - 1, day));
        };
        const yearStart = Date.UTC(calendarYear, 0, 1);
        const yearEnd = Date.UTC(calendarYear, 11, 31);
        let displayedMonth = new Date().getFullYear() === calendarYear ? new Date().getMonth() : 0;
        const today = new Date();
        let selectedDate = today.getFullYear() === calendarYear
            ? makeDateKey(calendarYear, today.getMonth(), today.getDate())
            : makeDateKey(calendarYear, 0, 1);
        let editingDate = null;
        let clickTimer = null;

        calendarEvents.forEach((event) => {
            const eventStart = parseDateKey(event.startDate).getTime();
            const eventEnd = Math.min(parseDateKey(event.endDate).getTime(), yearEnd);
            const firstDay = Math.max(eventStart, yearStart);

            for (let timestamp = firstDay; timestamp <= eventEnd; timestamp += 86400000) {
                const date = new Date(timestamp);
                const dateKey = makeDateKey(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate());
                const events = eventsByDate.get(dateKey) ?? [];
                events.push(event);
                eventsByDate.set(dateKey, events);
            }
        });

        const renderSelectedEvents = () => {
            const events = eventsByDate.get(selectedDate) ?? [];
            const note = calendarNotes.get(selectedDate);
            selectedDateHeading.textContent = dateFormatter.format(parseDateKey(selectedDate));
            eventCount.textContent = [
                events.length ? `${events.length} event${events.length === 1 ? '' : 's'}` : '',
                note ? 'ada catatan' : '',
            ].filter(Boolean).join(' · ');
            eventList.replaceChildren();
            if (noteEditor.classList.contains('hidden')) {
                noteInput.value = calendarNotes.get(selectedDate) ?? '';
            }
            deleteNoteButton.hidden = !calendarNotes.has(selectedDate);

            if (events.length === 0 && !note) {
                const emptyMessage = document.createElement('li');
                emptyMessage.className = 'text-sm text-slate-400';
                emptyMessage.textContent = 'Tidak ada event pada tanggal ini.';
                eventList.append(emptyMessage);
                return;
            }

            events.forEach((event) => {
                const item = document.createElement('li');
                item.className = 'flex items-center gap-2 text-sm font-medium text-slate-700';
                const marker = document.createElement('span');
                marker.className = 'h-2 w-2 shrink-0 rounded-full bg-sky-500';
                const name = document.createElement('span');
                name.className = 'min-w-0 truncate';
                name.textContent = event.name;
                item.append(marker, name);
                eventList.append(item);
            });

            if (note) {
                const item = document.createElement('li');
                item.className = 'flex items-start gap-2 rounded-lg bg-amber-50/80 px-2 py-1.5';
                const marker = document.createElement('span');
                marker.className = 'mt-1 h-2 w-2 shrink-0 rounded-full bg-amber-500';
                const noteText = document.createElement('span');
                noteText.className = 'line-clamp-3 min-w-0 break-words whitespace-pre-line text-xs text-slate-700';
                noteText.title = note;
                noteText.textContent = note;
                item.append(marker, noteText);
                eventList.append(item);
            }
        };

        const closeNoteEditor = () => {
            noteEditor.classList.add('hidden');
            editingDate = null;
            noteStatus.textContent = '';
            noteInput.value = calendarNotes.get(selectedDate) ?? '';
            dashboardCalendar.querySelector(`[data-date="${selectedDate}"]`)?.focus();
        };

        const openNoteEditor = (dateKey) => {
            if (noteEditor.classList.contains('hidden') || editingDate !== dateKey) {
                noteInput.value = calendarNotes.get(dateKey) ?? '';
            }
            selectedDate = dateKey;
            editingDate = dateKey;
            noteTitle.textContent = dateFormatter.format(parseDateKey(dateKey));
            noteStatus.textContent = '';
            noteEditor.classList.remove('hidden');
            renderCalendar();
            positionNoteEditor(dateKey);
            noteInput.focus();
        };

        const positionNoteEditor = (dateKey) => {
            const dateButton = calendarGrid.querySelector(`[data-date="${dateKey}"]`);
            if (!dateButton) return;

            const calendarBounds = dashboardCalendar.getBoundingClientRect();
            const dateBounds = dateButton.getBoundingClientRect();
            const editorWidth = noteEditor.offsetWidth;
            const editorHeight = noteEditor.offsetHeight;
            const maxLeft = Math.max(8, dashboardCalendar.clientWidth - editorWidth - 8);
            const left = Math.min(maxLeft, Math.max(8, dateBounds.left - calendarBounds.left + (dateBounds.width - editorWidth) / 2));
            let top = dateBounds.bottom - calendarBounds.top + 8;

            if (top + editorHeight > dashboardCalendar.clientHeight - 8) {
                top = dateBounds.top - calendarBounds.top - editorHeight - 8;
            }

            noteEditor.style.left = `${left}px`;
            noteEditor.style.top = `${Math.max(8, top)}px`;
        };

        const renderCalendar = () => {
            const firstWeekday = new Date(Date.UTC(calendarYear, displayedMonth, 1)).getUTCDay();
            const daysInMonth = new Date(Date.UTC(calendarYear, displayedMonth + 1, 0)).getUTCDate();
            const cellCount = Math.ceil((firstWeekday + daysInMonth) / 7) * 7;
            monthHeading.textContent = monthFormatter.format(new Date(Date.UTC(calendarYear, displayedMonth, 1)));
            previousButton.disabled = displayedMonth === 0;
            nextButton.disabled = displayedMonth === 11;
            calendarGrid.replaceChildren();

            for (let cell = 0; cell < cellCount; cell += 1) {
                const day = cell - firstWeekday + 1;
                if (day < 1 || day > daysInMonth) {
                    const emptyCell = document.createElement('div');
                    emptyCell.className = 'h-8 w-full';
                    emptyCell.setAttribute('role', 'gridcell');
                    calendarGrid.append(emptyCell);
                    continue;
                }

                const dateKey = makeDateKey(calendarYear, displayedMonth, day);
                const events = eventsByDate.get(dateKey) ?? [];
                const hasNote = calendarNotes.has(dateKey);
                const calendarCell = document.createElement('div');
                calendarCell.className = 'flex h-8 w-full items-center justify-center';
                calendarCell.setAttribute('role', 'gridcell');
                const dayButton = document.createElement('button');
                dayButton.type = 'button';
                dayButton.dataset.date = dateKey;
                dayButton.setAttribute('aria-pressed', String(dateKey === selectedDate));
                dayButton.setAttribute('aria-label', `${day} ${monthHeading.textContent}, ${events.length} event${events.length === 1 ? '' : 's'}${hasNote ? ', ada catatan' : ''}, klik dua kali untuk catatan`);
                dayButton.className = `relative flex h-8 w-8 shrink-0 flex-col items-center justify-center text-sm transition focus:outline-none focus-visible:underline focus-visible:decoration-sky-500 ${dateKey === selectedDate ? 'font-bold text-sky-700 underline decoration-sky-500 decoration-2 underline-offset-4' : 'text-slate-600 hover:text-sky-700'} ${events.length > 0 && dateKey !== selectedDate ? 'font-semibold' : ''}`;
                dayButton.textContent = day;

                if (events.length > 0 || hasNote) {
                    const markers = document.createElement('span');
                    markers.className = 'absolute bottom-0 flex items-center gap-0.5';
                    markers.setAttribute('aria-hidden', 'true');
                    if (events.length > 0) {
                        const eventMarker = document.createElement('span');
                        eventMarker.className = 'h-1 w-1 rounded-full bg-sky-500';
                        markers.append(eventMarker);
                    }
                    if (hasNote) {
                        const noteMarker = document.createElement('span');
                        noteMarker.className = 'h-1 w-1 rounded-full bg-amber-500';
                        markers.append(noteMarker);
                    }
                    dayButton.append(markers);
                }

                const selectDate = () => {
                    if (dateKey === selectedDate) {
                        return true;
                    }

                    if (dateKey !== selectedDate && !noteEditor.classList.contains('hidden') && noteInput.value.trim() !== (calendarNotes.get(editingDate) ?? '')) {
                        noteStatus.textContent = 'Simpan atau batalkan catatan sebelum pindah tanggal.';
                        return false;
                    }

                    selectedDate = dateKey;
                    closeNoteEditor();
                    noteStatus.textContent = '';
                    renderCalendar();
                    renderSelectedEvents();
                    return true;
                };

                dayButton.addEventListener('click', () => {
                    window.clearTimeout(clickTimer);
                    clickTimer = window.setTimeout(() => {
                        clickTimer = null;
                        selectDate();
                    }, 260);
                });
                dayButton.addEventListener('dblclick', () => {
                    window.clearTimeout(clickTimer);
                    clickTimer = null;
                    if (dateKey !== selectedDate && !selectDate()) {
                        return;
                    }

                    openNoteEditor(dateKey);
                });
                calendarCell.append(dayButton);
                calendarGrid.append(calendarCell);
            }

            renderSelectedEvents();
        };

        previousButton.addEventListener('click', () => {
            if (displayedMonth > 0) {
                displayedMonth -= 1;
                renderCalendar();
            }
        });
        nextButton.addEventListener('click', () => {
            if (displayedMonth < 11) {
                displayedMonth += 1;
                renderCalendar();
            }
        });

        const submitCalendarNote = async (method, url, note) => {
            const noteDate = selectedDate;
            saveNoteButton.disabled = true;
            deleteNoteButton.disabled = true;
            noteStatus.textContent = method === 'DELETE' ? 'Menghapus catatan...' : 'Menyimpan catatan...';

            try {
                const response = await fetch(url, {
                    method,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': noteCsrfToken,
                    },
                    body: JSON.stringify({ date: noteDate, ...(method === 'POST' ? { note } : {}) }),
                });
                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message ?? result.errors?.note?.[0] ?? result.errors?.date?.[0] ?? 'Catatan gagal disimpan.');
                }

                if (method === 'DELETE') {
                    calendarNotes.delete(noteDate);
                    if (editingDate === noteDate) {
                        noteInput.value = '';
                    }
                } else {
                    calendarNotes.set(noteDate, result.note);
                    if (editingDate === noteDate) {
                        noteInput.value = result.note;
                    }
                }

                renderCalendar();
                noteStatus.textContent = method === 'DELETE' ? 'Catatan dihapus.' : 'Catatan tersimpan.';
            } catch (error) {
                noteStatus.textContent = error.message;
            } finally {
                saveNoteButton.disabled = false;
                deleteNoteButton.disabled = false;
            }
        };

        saveNoteButton.addEventListener('click', () => {
            const note = noteInput.value.trim();
            if (!note) {
                noteStatus.textContent = 'Isi catatan terlebih dahulu.';
                noteInput.focus();
                return;
            }

            submitCalendarNote('POST', dashboardCalendar.dataset.saveNoteUrl, note);
        });

        deleteNoteButton.addEventListener('click', () => {
            submitCalendarNote('DELETE', dashboardCalendar.dataset.deleteNoteUrl);
        });

        cancelNoteButton.addEventListener('click', closeNoteEditor);

        document.addEventListener('click', (event) => {
            if (noteEditor.classList.contains('hidden') || noteEditor.contains(event.target) || dashboardCalendar.contains(event.target)) {
                return;
            }

            if (noteInput.value.trim() !== (calendarNotes.get(editingDate) ?? '')) {
                noteStatus.textContent = 'Simpan atau batalkan catatan sebelum menutup.';
                return;
            }

            closeNoteEditor();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !noteEditor.classList.contains('hidden')) {
                closeNoteEditor();
            }
        });

        noteInput.addEventListener('input', () => {
            noteStatus.textContent = '';
        });

        renderCalendar();
    }
</script>
@endpush
@endsection
