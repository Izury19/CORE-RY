@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.md-wrap * { box-sizing: border-box; }
.md-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.md-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.md-header-left h1 { font-family:'Outfit',sans-serif; font-size:22px; font-weight:800; color:#0f172a; letter-spacing:-0.03em; margin:0; }
.md-header-left p  { font-size:13px; color:#94a3b8; margin:3px 0 0; }
.md-header-right { display:flex; align-items:center; gap:12px; }
.md-status-pill { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:20px; font-size:12.5px; font-weight:700; color:#15803d; }
.md-status-dot  { width:7px; height:7px; border-radius:50%; background:#22c55e; animation: mdPulse 2s ease-in-out infinite; }
@keyframes mdPulse { 0%,100%{opacity:1;} 50%{opacity:.4;} }
.md-last-updated { font-size:12px; color:#94a3b8; }

/* Buttons */
.md-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.18s; text-decoration:none; }
.md-btn-primary { background:#3b82f6; color:#fff; }
.md-btn-primary:hover { background:#2563eb; transform:translateY(-1px); box-shadow:0 4px 12px rgba(59,130,246,0.28); }

/* Body */
.md-body { max-width:1400px; margin:0 auto; padding:28px 32px 60px; }

/* Stats grid */
.md-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
.md-stat { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.04); transition:all .18s; }
.md-stat:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,0.08); }
.md-stat::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; border-radius:4px 0 0 4px; }
.s-red::before    { background:#ef4444; }
.s-yellow::before { background:#f59e0b; }
.s-green::before  { background:#10b981; }
.s-blue::before   { background:#3b82f6; }
.md-stat-inner { display:flex; align-items:flex-start; gap:14px; }
.md-stat-icon { width:44px; height:44px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.icon-red    { background:#fee2e2; }
.icon-yellow { background:#fef3c7; }
.icon-green  { background:#dcfce7; }
.icon-blue   { background:#dbeafe; }
.md-stat-label { font-size:11.5px; font-weight:600; color:#64748b; margin-bottom:5px; }
.md-stat-value { font-family:'Outfit',sans-serif; font-size:30px; font-weight:800; color:#0f172a; line-height:1; margin-bottom:4px; }
.md-stat-sub   { font-size:11.5px; font-weight:600; }
.sub-red    { color:#ef4444; }
.sub-yellow { color:#f59e0b; }
.sub-green  { color:#10b981; }
.sub-gray   { color:#94a3b8; }

/* Main 2-col grid */
.md-grid { display:grid; grid-template-columns:1fr 380px; gap:20px; margin-bottom:20px; }

/* Cards */
.md-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.md-card-head { padding:16px 22px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
.md-card-head-left { display:flex; align-items:center; gap:9px; }
.md-card-head-left h2 { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin:0; }
.md-card-count { font-family:'Outfit',sans-serif; font-size:12px; font-weight:700; padding:2px 9px; border-radius:20px; background:#f1f5f9; color:#64748b; }
.md-card-body { padding:18px 22px; }

/* Upcoming items */
.md-upcoming-item { display:flex; align-items:center; justify-content:space-between; padding:13px 16px; background:#f8fafc; border:1px solid #f1f5f9; border-radius:11px; margin-bottom:10px; transition:all .18s; }
.md-upcoming-item:last-child { margin-bottom:0; }
.md-upcoming-item:hover { border-color:#bfdbfe; background:#eff6ff; }
.md-upcoming-left { flex:1; }
.md-upcoming-name { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin-bottom:4px; display:flex; align-items:center; gap:7px; flex-wrap:wrap; }
.md-upcoming-type { display:inline-flex; padding:1px 8px; border-radius:20px; font-size:11px; font-weight:700; background:#dbeafe; color:#1d4ed8; }
.md-upcoming-date { font-size:12.5px; color:#64748b; font-weight:500; }
.md-upcoming-right { text-align:right; flex-shrink:0; margin-left:14px; }
.md-risk-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:700; margin-bottom:4px; }
.risk-low    { background:#dcfce7; color:#15803d; }
.risk-medium { background:#fef3c7; color:#b45309; }
.risk-high   { background:#fee2e2; color:#dc2626; }
.md-days-left { font-size:11.5px; color:#64748b; font-weight:600; }

/* Notif items */
.md-notif-item { display:flex; align-items:flex-start; gap:11px; padding-bottom:14px; border-bottom:1px solid #f8fafc; margin-bottom:14px; }
.md-notif-item:last-child { border-bottom:none; margin-bottom:0; padding-bottom:0; }
.md-notif-icon { width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
.ni-upcoming { background:#dcfce7; color:#15803d; }
.ni-overdue  { background:#fee2e2; color:#dc2626; }
.ni-default  { background:#dbeafe; color:#1d4ed8; }
.md-notif-type { display:inline-flex; padding:2px 8px; border-radius:20px; font-size:10.5px; font-weight:700; margin-bottom:4px; }
.nt-upcoming { background:#dcfce7; color:#15803d; }
.nt-overdue  { background:#fee2e2; color:#dc2626; }
.nt-default  { background:#dbeafe; color:#1d4ed8; }
.md-notif-time { font-size:11px; color:#94a3b8; margin-left:6px; }
.md-notif-msg  { font-size:13px; font-weight:600; color:#1e293b; margin-bottom:2px; line-height:1.4; }
.md-notif-equip { font-size:11.5px; color:#94a3b8; }

/* Empty states */
.md-empty { padding:40px 20px; text-align:center; }
.md-empty svg { margin:0 auto 12px; color:#cbd5e1; }
.md-empty h3 { font-family:'Outfit',sans-serif; font-size:14px; font-weight:600; color:#475569; margin-bottom:4px; }
.md-empty p  { font-size:12.5px; color:#94a3b8; }

/* Monthly performance */
.md-monthly { background:#fff; border:1px solid #e2e8f0; border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.md-monthly-head { padding:16px 22px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:9px; }
.md-monthly-head h2 { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin:0; }
.md-monthly-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:0; }
.md-monthly-item { padding:22px 24px; position:relative; }
.md-monthly-item + .md-monthly-item { border-left:1px solid #f1f5f9; }
.md-monthly-item-label { font-size:11.5px; font-weight:600; color:#64748b; margin-bottom:6px; text-transform:uppercase; letter-spacing:.05em; font-size:10.5px; }
.md-monthly-value { font-family:'Outfit',sans-serif; font-size:32px; font-weight:800; line-height:1; margin-bottom:6px; }
.md-monthly-sub   { font-size:12px; font-weight:600; }
.md-progress-bar  { height:5px; border-radius:3px; background:#f1f5f9; margin-top:10px; overflow:hidden; }
.md-progress-fill { height:100%; border-radius:3px; transition:width .6s ease; }

/* Animations */
@keyframes mdFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.md-a  { animation:mdFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s}
.d4{animation-delay:.15s} .d5{animation-delay:.19s}

/* Responsive */
@media(max-width:1100px) { .md-grid{grid-template-columns:1fr;} }
@media(max-width:900px)  { .md-stats{grid-template-columns:repeat(2,1fr);} }
@media(max-width:700px)  { .md-body{padding:18px 14px 40px;} .md-header{padding:14px 18px;} .md-monthly-grid{grid-template-columns:1fr;} .md-monthly-item+.md-monthly-item{border-left:none;border-top:1px solid #f1f5f9;} }
</style>

<div class="md-wrap">

    {{-- Header --}}
    <div class="md-header">
        <div class="md-header-left">
            <h1>Maintenance Dashboard</h1>
            <p>Real-time equipment health and maintenance status</p>
        </div>
        <div class="md-header-right">
            <div class="md-status-pill">
                <span class="md-status-dot"></span>
                System Operational
            </div>
            <span class="md-last-updated">Updated {{ now()->format('M d, Y H:i') }}</span>
            <a href="{{ route('maintenance.create') }}" class="md-btn md-btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                New Schedule
            </a>
        </div>
    </div>

    <div class="md-body">

        {{-- Stats --}}
        <div class="md-stats md-a d1">
            <div class="md-stat s-red">
                <div class="md-stat-inner">
                    <div class="md-stat-icon icon-red">
                        <svg width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.195 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <div class="md-stat-label">High Risk Equipment</div>
                        <div class="md-stat-value">2</div>
                        <div class="md-stat-sub sub-red">AI Risk ≥ 80%</div>
                    </div>
                </div>
            </div>
            <div class="md-stat s-yellow">
                <div class="md-stat-inner">
                    <div class="md-stat-icon icon-yellow">
                        <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="md-stat-label">Medium Risk Equipment</div>
                        <div class="md-stat-value">5</div>
                        <div class="md-stat-sub sub-yellow">AI Risk 60–79%</div>
                    </div>
                </div>
            </div>
            <div class="md-stat s-green">
                <div class="md-stat-inner">
                    <div class="md-stat-icon icon-green">
                        <svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="md-stat-label">Low Risk Equipment</div>
                        <div class="md-stat-value">8</div>
                        <div class="md-stat-sub sub-green">AI Risk &lt; 60%</div>
                    </div>
                </div>
            </div>
            <div class="md-stat s-blue">
                <div class="md-stat-inner">
                    <div class="md-stat-icon icon-blue">
                        <svg width="20" height="20" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <div class="md-stat-label">Total Schedules</div>
                        <div class="md-stat-value">15</div>
                        <div class="md-stat-sub sub-gray">All maintenance</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main 2-col --}}
        <div class="md-grid">

            {{-- Upcoming Maintenance --}}
            <div class="md-card md-a d2">
                <div class="md-card-head">
                    <div class="md-card-head-left">
                        <svg width="16" height="16" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <h2>Upcoming Maintenance</h2>
                        <span class="md-card-count">Next 7 days</span>
                    </div>
                    <a href="{{ route('maintenance.index') }}" style="font-size:12px;font-weight:600;color:#3b82f6;text-decoration:none;">View all →</a>
                </div>
                <div class="md-card-body">
                    @if($upcomingMaintenance->count() > 0)
                        @foreach($upcomingMaintenance as $schedule)
                        @php
                            $risk = $schedule->ai_risk_score ?? 0;
                            $riskClass = $risk >= 0.8 ? 'risk-high' : ($risk >= 0.6 ? 'risk-medium' : 'risk-low');
                            $daysLeft = (int) now()->diffInDays(\Carbon\Carbon::parse($schedule->scheduled_date), false);
                        @endphp
                        <div class="md-upcoming-item">
                            <div class="md-upcoming-left">
                                <div class="md-upcoming-name">
                                    {{ $schedule->equipment_name }}
                                    <span class="md-upcoming-type">{{ $schedule->maintenanceType->name ?? 'N/A' }}</span>
                                </div>
                                <div class="md-upcoming-date">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:3px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('M d, Y') }}
                                </div>
                            </div>
                            <div class="md-upcoming-right">
                                @if($risk > 0)
                                <div class="md-risk-badge {{ $riskClass }}">
                                    AI {{ number_format($risk * 100, 0) }}%
                                </div>
                                @endif
                                <div class="md-days-left">
                                    @if($daysLeft <= 0)
                                        <span style="color:#dc2626;">Today</span>
                                    @elseif($daysLeft == 1)
                                        <span style="color:#f59e0b;">Tomorrow</span>
                                    @else
                                        in {{ $daysLeft }}d
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="md-empty">
                            <svg width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <h3>No upcoming maintenance</h3>
                            <p>All clear for the next 7 days.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent Notifications --}}
            <div class="md-card md-a d3">
                <div class="md-card-head">
                    <div class="md-card-head-left">
                        <svg width="16" height="16" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <h2>Notifications</h2>
                    </div>
                </div>
                <div class="md-card-body" style="max-height:460px;overflow-y:auto;">
                    @forelse($recentNotifications as $notif)
                    @php
                        $nType = $notif->notification_type ?? 'default';
                        $iconClass = $nType === 'upcoming' ? 'ni-upcoming' : ($nType === 'overdue' ? 'ni-overdue' : 'ni-default');
                        $tagClass  = $nType === 'upcoming' ? 'nt-upcoming' : ($nType === 'overdue' ? 'nt-overdue'  : 'nt-default');
                    @endphp
                    <div class="md-notif-item">
                        <div class="md-notif-icon {{ $iconClass }}">
                            @if($nType === 'overdue')
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.195 3 1.732 3z"/></svg>
                            @elseif($nType === 'upcoming')
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @else
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                        </div>
                        <div style="flex:1;">
                            <div>
                                <span class="md-notif-type {{ $tagClass }}">{{ ucfirst($nType) }}</span>
                                <span class="md-notif-time">{{ \Carbon\Carbon::parse($notif->created_at)->format('H:i') }}</span>
                            </div>
                            <div class="md-notif-msg">{{ preg_replace('/(\d+)\.\d+(\s*days?)/', '$1$2', $notif->message) }}</div>
                            <div class="md-notif-equip">{{ $notif->equipment_name }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="md-empty">
                        <svg width="38" height="38" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <h3>No notifications yet</h3>
                        <p>Notifications appear here when schedules are created or completed.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Monthly Performance --}}
        <div class="md-monthly md-a d4">
            <div class="md-monthly-head">
                <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <h2>Monthly Performance</h2>
            </div>
            <div class="md-monthly-grid">
                <div class="md-monthly-item">
                    <div class="md-monthly-item-label">Completed This Month</div>
                    <div class="md-monthly-value" style="color:#10b981;">7</div>
                    <div class="md-monthly-sub" style="color:#10b981;">✓ 100% target met</div>
                    <div class="md-progress-bar">
                        <div class="md-progress-fill" style="width:100%;background:#10b981;"></div>
                    </div>
                </div>
                <div class="md-monthly-item">
                    <div class="md-monthly-item-label">Total Schedules</div>
                    <div class="md-monthly-value" style="color:#3b82f6;">15</div>
                    <div class="md-monthly-sub" style="color:#3b82f6;">↑ +20% vs last month</div>
                    <div class="md-progress-bar">
                        <div class="md-progress-fill" style="width:75%;background:#3b82f6;"></div>
                    </div>
                </div>
                <div class="md-monthly-item">
                    <div class="md-monthly-item-label">Equipment Uptime</div>
                    <div class="md-monthly-value" style="color:#7c3aed;">85%</div>
                    <div class="md-monthly-sub" style="color:#94a3b8;">Target: 90%</div>
                    <div class="md-progress-bar">
                        <div class="md-progress-fill" style="width:85%;background:#7c3aed;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection