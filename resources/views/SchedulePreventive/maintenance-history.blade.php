@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.mh-wrap * { box-sizing: border-box; }
.mh-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.mh-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.mh-header-left h1 { font-family:'Outfit',sans-serif; font-size:22px; font-weight:800; color:#0f172a; letter-spacing:-0.03em; margin:0; }
.mh-header-left p  { font-size:13px; color:#94a3b8; margin:3px 0 0; }
.mh-header-right { display:flex; align-items:center; gap:10px; }

/* Search */
.mh-search-wrap { position:relative; }
.mh-search-wrap svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; }
.mh-search { height:40px; width:280px; padding:0 13px 0 36px; border:1.5px solid #e2e8f0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; color:#1e293b; background:#f8fafc; outline:none; transition:border-color .18s, box-shadow .18s; }
.mh-search:focus { border-color:#0d9488; box-shadow:0 0 0 3px rgba(13,148,136,.1); background:#fff; }
.mh-search::placeholder { color:#cbd5e1; }

/* Body */
.mh-body { max-width:1400px; margin:0 auto; padding:28px 32px 60px; }

/* Stats */
.mh-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
.mh-stat { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.04); transition:all .18s; }
.mh-stat:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,0.08); }
.mh-stat::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; border-radius:4px 0 0 4px; }
.s-teal::before  { background:#0d9488; }
.s-green::before { background:#10b981; }
.s-red::before   { background:#ef4444; }
.s-yellow::before{ background:#f59e0b; }
.mh-stat-inner { display:flex; align-items:flex-start; gap:14px; }
.mh-stat-icon { width:44px; height:44px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.icon-teal   { background:#ccfbf1; }
.icon-green  { background:#dcfce7; }
.icon-red    { background:#fee2e2; }
.icon-yellow { background:#fef3c7; }
.mh-stat-label { font-size:11.5px; font-weight:600; color:#64748b; margin-bottom:5px; }
.mh-stat-value { font-family:'Outfit',sans-serif; font-size:30px; font-weight:800; color:#0f172a; line-height:1; margin-bottom:4px; }
.mh-stat-sub   { font-size:11.5px; font-weight:600; }
.sub-teal   { color:#0d9488; }
.sub-green  { color:#10b981; }
.sub-red    { color:#ef4444; }
.sub-yellow { color:#f59e0b; }

/* Card */
.mh-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.mh-card-head { padding:16px 22px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
.mh-card-head-left { display:flex; align-items:center; gap:9px; }
.mh-card-head-left h2 { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin:0; }
.mh-result-count { font-size:12px; color:#94a3b8; }

/* Table */
.mh-table-wrap { overflow-x:auto; }
.mh-table { width:100%; border-collapse:collapse; font-size:13px; }
.mh-table thead th { padding:11px 18px; text-align:left; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#0f766e; background:#f0fdfa; border-bottom:2px solid #ccfbf1; white-space:nowrap; }
.mh-table tbody tr { border-bottom:1px solid #f8fafc; transition:background .14s; }
.mh-table tbody tr:hover { background:#f0fdfa; }
.mh-table tbody tr:last-child { border-bottom:none; }
.mh-table tbody td { padding:13px 18px; color:#334155; vertical-align:middle; }

/* Equipment cell */
.mh-equip-name { font-family:'Outfit',sans-serif; font-weight:700; color:#0f172a; font-size:13.5px; }
.mh-type-badge { display:inline-flex; padding:2px 9px; border-radius:20px; font-size:11px; font-weight:700; background:#ccfbf1; color:#0f766e; margin-top:3px; }

/* Date cells */
.mh-date { font-size:13px; color:#334155; font-weight:500; }
.mh-date-na { color:#cbd5e1; font-size:12.5px; }

/* Status pills */
.mh-pill { display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:20px; font-size:11.5px; font-weight:700; white-space:nowrap; }
.pill-completed { background:#dcfce7; color:#15803d; }
.pill-overdue   { background:#fee2e2; color:#dc2626; }
.pill-pending   { background:#fef3c7; color:#b45309; }

/* Proof link */
.mh-proof-link { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:8px; border:1px solid #ccfbf1; background:#f0fdfa; font-size:12px; font-weight:600; color:#0d9488; text-decoration:none; transition:all .18s; }
.mh-proof-link:hover { background:#ccfbf1; border-color:#5eead4; }
.mh-no-proof { font-size:12.5px; color:#cbd5e1; }

/* Empty */
.mh-empty { padding:56px 24px; text-align:center; }
.mh-empty svg { margin:0 auto 14px; color:#ccfbf1; }
.mh-empty h3 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; color:#334155; margin-bottom:5px; }
.mh-empty p  { font-size:13px; color:#94a3b8; }

/* Pagination */
.mh-pagination { padding:16px 22px; border-top:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.mh-pagination-info { font-size:13px; color:#64748b; }
.mh-pages { display:flex; gap:4px; }
.mh-pages a, .mh-pages span { display:flex; align-items:center; justify-content:center; min-width:34px; height:34px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:all .18s; padding:0 8px; }
.mh-pages a { color:#0d9488; background:#f0fdfa; }
.mh-pages a:hover { background:#ccfbf1; }
.mh-pages .pg-active { background:#0d9488; color:#fff; }
.mh-pages .pg-disabled { color:#94a3b8; background:#f1f5f9; cursor:not-allowed; }

/* Animations */
@keyframes mhFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.mh-a { animation:mhFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s}

@media(max-width:900px) { .mh-stats{grid-template-columns:repeat(2,1fr);} }
@media(max-width:700px) { .mh-body{padding:18px 14px 40px;} .mh-header{padding:14px 18px;} .mh-search{width:100%;} }
</style>

<div class="mh-wrap">

    {{-- Header --}}
    <div class="mh-header">
        <div class="mh-header-left">
            <h1>Maintenance History Log</h1>
            <p>Complete record of all maintenance schedules and their outcomes</p>
        </div>
        <div class="mh-header-right">
            <form method="GET" action="{{ route('maintenance-history') }}">
                <div class="mh-search-wrap">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" name="search" class="mh-search"
                           placeholder="Search equipment or type…"
                           value="{{ request('search') }}">
                </div>
            </form>
        </div>
    </div>

    <div class="mh-body">

        {{-- Stats --}}
        @php
            $all       = $historyLogs->getCollection();
            $total     = $historyLogs->total();
            $completed = $all->where('status','completed')->count();
            $overdue   = $all->filter(fn($l) => $l->status === 'pending' && \Carbon\Carbon::parse($l->scheduled_date)->isPast())->count();
            $pending   = $all->where('status','pending')->count() - $overdue;
        @endphp
        <div class="mh-stats mh-a d1">
            <div class="mh-stat s-teal">
                <div class="mh-stat-inner">
                    <div class="mh-stat-icon icon-teal">
                        <svg width="20" height="20" fill="none" stroke="#0d9488" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <div>
                        <div class="mh-stat-label">Total Records</div>
                        <div class="mh-stat-value">{{ $total }}</div>
                        <div class="mh-stat-sub sub-teal">All log entries</div>
                    </div>
                </div>
            </div>
            <div class="mh-stat s-green">
                <div class="mh-stat-inner">
                    <div class="mh-stat-icon icon-green">
                        <svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="mh-stat-label">Completed</div>
                        <div class="mh-stat-value">{{ $completed }}</div>
                        <div class="mh-stat-sub sub-green">This page</div>
                    </div>
                </div>
            </div>
            <div class="mh-stat s-red">
                <div class="mh-stat-inner">
                    <div class="mh-stat-icon icon-red">
                        <svg width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.195 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <div class="mh-stat-label">Overdue</div>
                        <div class="mh-stat-value">{{ $overdue }}</div>
                        <div class="mh-stat-sub sub-red">Past scheduled date</div>
                    </div>
                </div>
            </div>
            <div class="mh-stat s-yellow">
                <div class="mh-stat-inner">
                    <div class="mh-stat-icon icon-yellow">
                        <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="mh-stat-label">Pending</div>
                        <div class="mh-stat-value">{{ $pending }}</div>
                        <div class="mh-stat-sub sub-yellow">Not yet due</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="mh-card mh-a d2">
            <div class="mh-card-head">
                <div class="mh-card-head-left">
                    <svg width="16" height="16" fill="none" stroke="#0d9488" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <h2>History Log</h2>
                </div>
                @if(request('search'))
                <span class="mh-result-count">Results for "{{ request('search') }}"</span>
                @endif
            </div>

            <div class="mh-table-wrap">
                <table class="mh-table">
                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Maintenance Type</th>
                            <th>Scheduled Date</th>
                            <th>Completed Date</th>
                            <th>Status</th>
                            <th>Proof</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historyLogs as $log)
                        @php
                            $isOverdue = $log->status === 'pending' && \Carbon\Carbon::parse($log->scheduled_date)->isPast();
                        @endphp
                        <tr>
                            <td>
                                <div class="mh-equip-name">{{ $log->equipment_name }}</div>
                            </td>
                            <td>
                                <span class="mh-type-badge">{{ $log->maintenanceType->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="mh-date">{{ \Carbon\Carbon::parse($log->scheduled_date)->format('M d, Y') }}</div>
                                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">{{ \Carbon\Carbon::parse($log->scheduled_date)->diffForHumans() }}</div>
                            </td>
                            <td>
                                @if($log->completed_at)
                                    <div class="mh-date">{{ \Carbon\Carbon::parse($log->completed_at)->format('M d, Y') }}</div>
                                @else
                                    <span class="mh-date-na">—</span>
                                @endif
                            </td>
                            <td>
                                @if($log->status === 'completed')
                                    <span class="mh-pill pill-completed">✓ Completed</span>
                                @elseif($isOverdue)
                                    <span class="mh-pill pill-overdue">⚠ Overdue</span>
                                @else
                                    <span class="mh-pill pill-pending">⏳ Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($log->proof_image)
                                    <a href="{{ asset('storage/' . $log->proof_image) }}" target="_blank" class="mh-proof-link">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                @else
                                    <span class="mh-no-proof">No proof</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="mh-empty">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    <h3>No maintenance history found</h3>
                                    <p>{{ request('search') ? 'Try a different search term.' : 'Completed maintenance schedules will appear here.' }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($historyLogs->hasPages())
            <div class="mh-pagination">
                <div class="mh-pagination-info">
                    Showing {{ $historyLogs->firstItem() }}–{{ $historyLogs->lastItem() }} of {{ $historyLogs->total() }} records
                </div>
                <div class="mh-pages">
                    @if($historyLogs->onFirstPage())
                        <span class="pg-disabled">‹ Prev</span>
                    @else
                        <a href="{{ $historyLogs->previousPageUrl() }}">‹ Prev</a>
                    @endif

                    @foreach($historyLogs->links()->elements[0] as $page => $url)
                        @if($page == $historyLogs->currentPage())
                            <span class="pg-active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($historyLogs->hasMorePages())
                        <a href="{{ $historyLogs->nextPageUrl() }}">Next ›</a>
                    @else
                        <span class="pg-disabled">Next ›</span>
                    @endif
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

@endsection