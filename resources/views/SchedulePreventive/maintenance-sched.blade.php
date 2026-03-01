@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.ms-wrap * { box-sizing: border-box; }
.ms-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.ms-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.ms-header-left h1 { font-family:'Outfit',sans-serif; font-size:22px; font-weight:800; color:#0f172a; letter-spacing:-0.03em; margin:0; display:flex; align-items:center; gap:10px; }
.ms-header-left p  { font-size:13px; color:#94a3b8; margin:3px 0 0; }
.ms-header-right { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }

/* Buttons */
.ms-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.18s; text-decoration:none; white-space:nowrap; }
.ms-btn-primary { background:#3b82f6; color:#fff; }
.ms-btn-primary:hover { background:#2563eb; transform:translateY(-1px); box-shadow:0 4px 12px rgba(59,130,246,0.28); }

/* Body */
.ms-body { max-width:1400px; margin:0 auto; padding:28px 32px 60px; }

/* Stats */
.ms-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
.ms-stat { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px 18px; position:relative; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.04); }
.ms-stat::before { content:''; position:absolute; left:0; top:0; bottom:0; width:3px; border-radius:3px 0 0 3px; }
.s-blue::before   { background:#3b82f6; }
.s-yellow::before { background:#f59e0b; }
.s-green::before  { background:#10b981; }
.s-red::before    { background:#ef4444; }
.ms-stat-label { font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.06em; margin-bottom:5px; }
.ms-stat-value { font-family:'Outfit',sans-serif; font-size:26px; font-weight:800; color:#0f172a; line-height:1; }
.ms-stat-sub   { font-size:11.5px; color:#94a3b8; margin-top:3px; }

/* Main card */
.ms-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); }

/* Toolbar */
.ms-toolbar { padding:14px 24px; background:#f8fafc; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
.ms-search-wrap { position:relative; flex:1; min-width:240px; }
.ms-search-wrap svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; }
.ms-search { width:100%; padding:9px 12px 9px 36px; border:1.5px solid #e2e8f0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; color:#1e293b; background:#fff; outline:none; transition:border-color .18s,box-shadow .18s; }
.ms-search:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.ms-search::placeholder { color:#cbd5e1; }
.ms-filter { height:40px; padding:0 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; color:#475569; background:#fff; outline:none; cursor:pointer; transition:border-color .18s; }
.ms-filter:focus { border-color:#3b82f6; }

/* Table */
.ms-table-wrap { overflow-x:auto; }
.ms-table { width:100%; border-collapse:collapse; font-size:13px; }
.ms-table thead th { padding:11px 16px; text-align:left; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#94a3b8; background:#f8fafc; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
.ms-table tbody tr { border-bottom:1px solid #f8fafc; transition:background .14s; }
.ms-table tbody tr:hover { background:#f8fafc; }
.ms-table tbody tr:last-child { border-bottom:none; }
.ms-table tbody td { padding:13px 16px; color:#334155; vertical-align:middle; }
.t-equip { font-family:'Outfit',sans-serif; font-weight:700; color:#0f172a; font-size:13.5px; }
.t-sub   { font-size:11.5px; color:#94a3b8; margin-top:2px; }

/* Recurring badge */
.ms-recurring { display:inline-flex; align-items:center; gap:4px; background:#dbeafe; color:#1d4ed8; padding:2px 8px; border-radius:20px; font-size:11px; font-weight:700; margin-top:4px; }

/* Priority badges */
.ms-priority { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:6px; font-size:11.5px; font-weight:700; }
.p-critical { background:#fee2e2; color:#dc2626; }
.p-high     { background:#ffedd5; color:#ea580c; }
.p-medium   { background:#fef9c3; color:#ca8a04; }
.p-low      { background:#dcfce7; color:#166534; }

/* Status pills */
.ms-pill { display:inline-flex; align-items:center; padding:4px 12px; border-radius:20px; font-size:11.5px; font-weight:700; }
.pill-pending   { background:#fef3c7; color:#b45309; }
.pill-completed { background:#dcfce7; color:#15803d; }
.pill-overdue   { background:#fee2e2; color:#dc2626; }

/* AI risk */
.ms-risk { display:inline-flex; align-items:center; gap:7px; }
.ms-risk-val { font-family:'Outfit',sans-serif; font-weight:700; font-size:13.5px; color:#0f172a; }
.ms-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
.d-red    { background:#ef4444; }
.d-yellow { background:#f59e0b; }
.d-green  { background:#10b981; }

/* Action buttons */
.ms-actions { display:flex; align-items:center; gap:6px; }
.ms-icon-btn { width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:8px; border:1px solid #e2e8f0; background:#fff; cursor:pointer; transition:all .18s; color:#64748b; text-decoration:none; }
.ms-icon-btn:hover { border-color:#3b82f6; color:#3b82f6; background:#eff6ff; }

/* Empty */
.ms-empty { padding:56px 24px; text-align:center; }
.ms-empty svg { margin:0 auto 14px; color:#cbd5e1; }
.ms-empty h3 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; color:#334155; margin-bottom:5px; }
.ms-empty p  { font-size:13px; color:#94a3b8; }

/* Pagination */
.ms-pagination { padding:16px 24px; border-top:1px solid #f1f5f9; display:flex; align-items:center; justify-content:center; gap:4px; }
.ms-page-btn { display:flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 10px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; text-decoration:none; transition:all .18s; border:1.5px solid #e2e8f0; color:#3b82f6; background:#fff; }
.ms-page-btn:hover { background:#eff6ff; border-color:#93c5fd; }
.ms-page-active { background:#3b82f6; color:#fff; border-color:#3b82f6; }
.ms-page-active:hover { background:#2563eb; }
.ms-page-disabled { color:#cbd5e1; background:#f8fafc; cursor:not-allowed; pointer-events:none; }

/* Animations */
@keyframes msFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.ms-a  { animation:msFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s}

/* Responsive */
@media(max-width:900px) { .ms-stats{grid-template-columns:repeat(2,1fr);} }
@media(max-width:700px) { .ms-body{padding:18px 14px 40px;} .ms-header{padding:14px 18px;} .ms-stats{grid-template-columns:1fr 1fr;} }
</style>

<div class="ms-wrap">

    {{-- Header --}}
    <div class="ms-header">
        <div class="ms-header-left">
            <h1>
                <svg width="20" height="20" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Maintenance Schedule
            </h1>
            <p>Track and manage equipment maintenance across all units</p>
        </div>
        <div class="ms-header-right">
            <a href="{{ route('maintenance.create') }}" class="ms-btn ms-btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Add New Schedule
            </a>
        </div>
    </div>

    <div class="ms-body">

        {{-- Stats --}}
        @php
            $total     = $schedules->total();
            $pending   = $schedules->getCollection()->where('status','pending')->count();
            $completed = $schedules->getCollection()->where('status','completed')->count();
            $highRisk  = $schedules->getCollection()->filter(fn($s) => ($s->ai_risk_score ?? 0) >= 0.8)->count();
        @endphp
        <div class="ms-stats ms-a d1">
            <div class="ms-stat s-blue">
                <div class="ms-stat-label">Total Schedules</div>
                <div class="ms-stat-value">{{ $total }}</div>
                <div class="ms-stat-sub">All records</div>
            </div>
            <div class="ms-stat s-yellow">
                <div class="ms-stat-label">Pending</div>
                <div class="ms-stat-value">{{ $pending }}</div>
                <div class="ms-stat-sub">This page</div>
            </div>
            <div class="ms-stat s-green">
                <div class="ms-stat-label">Completed</div>
                <div class="ms-stat-value">{{ $completed }}</div>
                <div class="ms-stat-sub">This page</div>
            </div>
            <div class="ms-stat s-red">
                <div class="ms-stat-label">High AI Risk</div>
                <div class="ms-stat-value">{{ $highRisk }}</div>
                <div class="ms-stat-sub">≥ 80% risk score</div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="ms-card ms-a d2">

            {{-- Toolbar --}}
            <div class="ms-toolbar">
                <div class="ms-search-wrap">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    <form method="GET" action="{{ route('maintenance.index') }}" id="searchForm">
                        <input type="text" name="search" class="ms-search"
                               placeholder="Search equipment or maintenance type…"
                               value="{{ request('search') }}"
                               onchange="document.getElementById('searchForm').submit()">
                    </form>
                </div>
                <select class="ms-filter" onchange="window.location='{{ route('maintenance.index') }}?status='+this.value+'&search={{ request('search') }}'">
                    <option value="">All Statuses</option>
                    <option value="pending"   {{ request('status')=='pending'   ?'selected':'' }}>⏳ Pending</option>
                    <option value="completed" {{ request('status')=='completed' ?'selected':'' }}>✅ Completed</option>
                </select>
                <select class="ms-filter" onchange="window.location='{{ route('maintenance.index') }}?priority='+this.value+'&search={{ request('search') }}'">
                    <option value="">All Priorities</option>
                    <option value="critical" {{ request('priority')=='critical'?'selected':'' }}>🔴 Critical</option>
                    <option value="high"     {{ request('priority')=='high'    ?'selected':'' }}>🟠 High</option>
                    <option value="medium"   {{ request('priority')=='medium'  ?'selected':'' }}>🟡 Medium</option>
                    <option value="low"      {{ request('priority')=='low'     ?'selected':'' }}>🟢 Low</option>
                </select>
            </div>

            {{-- Table --}}
            <div class="ms-table-wrap">
                <table class="ms-table">
                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Maintenance Type</th>
                            <th>Scheduled Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>AI Risk</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                        @php
                            $isOverdue = $schedule->status === 'pending' && \Carbon\Carbon::parse($schedule->scheduled_date)->isPast();
                        @endphp
                        <tr>
                            <td>
                                <div class="t-equip">{{ $schedule->equipment_name }}</div>
                                @if($schedule->is_recurring)
                                <span class="ms-recurring">
                                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Recurring
                                </span>
                                @endif
                            </td>

                            <td>{{ $schedule->maintenanceType->name ?? 'N/A' }}</td>

                            <td>
                                <div style="font-weight:600;color:#1e293b;">{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('M d, Y') }}</div>
                                @if($isOverdue)
                                <div class="t-sub" style="color:#dc2626;">{{ \Carbon\Carbon::parse($schedule->scheduled_date)->diffForHumans() }}</div>
                                @else
                                <div class="t-sub">{{ \Carbon\Carbon::parse($schedule->scheduled_date)->diffForHumans() }}</div>
                                @endif
                            </td>

                            <td>
                                @php $p = strtolower($schedule->priority ?? 'low'); @endphp
                                <span class="ms-priority p-{{ $p }}">
                                    @if($p === 'critical') 🔴
                                    @elseif($p === 'high') 🟠
                                    @elseif($p === 'medium') 🟡
                                    @else 🟢
                                    @endif
                                    {{ ucfirst($p) }}
                                </span>
                            </td>

                            <td>
                                @if($isOverdue)
                                    <span class="ms-pill pill-overdue">Overdue</span>
                                @elseif($schedule->status === 'completed')
                                    <span class="ms-pill pill-completed">Completed</span>
                                @else
                                    <span class="ms-pill pill-pending">Pending</span>
                                @endif
                            </td>

                            <td>
                                @if(($schedule->ai_risk_score ?? 0) > 0)
                                <div class="ms-risk">
                                    <span class="ms-risk-val">{{ number_format($schedule->ai_risk_score * 100, 0) }}%</span>
                                    @if($schedule->ai_risk_score >= 0.8)
                                        <span class="ms-dot d-red" title="High Risk"></span>
                                    @elseif($schedule->ai_risk_score >= 0.6)
                                        <span class="ms-dot d-yellow" title="Medium Risk"></span>
                                    @else
                                        <span class="ms-dot d-green" title="Low Risk"></span>
                                    @endif
                                </div>
                                @else
                                    <span style="color:#cbd5e1;font-size:12.5px;">N/A</span>
                                @endif
                            </td>

                            <td>
                                <div class="ms-actions">
                                    <a href="{{ route('maintenance.edit', $schedule->maintenance_sched_id) }}" class="ms-icon-btn" title="Edit">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="ms-empty">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <h3>No maintenance schedules found</h3>
                                    <p>Get started by creating your first maintenance schedule.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($schedules->hasPages())
            <div class="ms-pagination">
                @if($schedules->onFirstPage())
                    <span class="ms-page-btn ms-page-disabled">← Prev</span>
                @else
                    <a href="{{ $schedules->previousPageUrl() }}" class="ms-page-btn">← Prev</a>
                @endif

                @foreach($schedules->links()->elements[0] as $page => $url)
                    @if($page == $schedules->currentPage())
                        <span class="ms-page-btn ms-page-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="ms-page-btn">{{ $page }}</a>
                    @endif
                @endforeach

                @if($schedules->hasMorePages())
                    <a href="{{ $schedules->nextPageUrl() }}" class="ms-page-btn">Next →</a>
                @else
                    <span class="ms-page-btn ms-page-disabled">Next →</span>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>

@endsection