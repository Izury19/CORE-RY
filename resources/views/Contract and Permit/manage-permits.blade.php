@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.mp-wrap * { box-sizing: border-box; }
.mp-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.mp-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.mp-header-left h1 { font-family:'Outfit',sans-serif; font-size:22px; font-weight:800; color:#0f172a; letter-spacing:-0.03em; margin:0; }
.mp-header-left p  { font-size:13px; color:#94a3b8; margin:3px 0 0; }
.mp-header-right   { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }

/* Buttons */
.mp-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.18s; text-decoration:none; white-space:nowrap; }
.mp-btn-primary { background:#059669; color:#fff; }
.mp-btn-primary:hover { background:#047857; transform:translateY(-1px); box-shadow:0 4px 12px rgba(5,150,105,0.28); }
.mp-btn-ghost   { background:#f1f5f9; color:#475569; border:none; }
.mp-btn-ghost:hover { background:#e2e8f0; }

/* Body */
.mp-body { max-width:1400px; margin:0 auto; padding:28px 32px 60px; }

/* Alerts */
.mp-alert { display:flex; align-items:center; gap:10px; padding:13px 18px; border-radius:10px; margin-bottom:20px; font-size:13.5px; font-weight:500; }
.alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
.alert-error   { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }

/* Stats row */
.mp-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
.mp-stat { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px 18px; position:relative; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.04); }
.mp-stat::before { content:''; position:absolute; left:0; top:0; bottom:0; width:3px; border-radius:3px 0 0 3px; }
.s-green::before  { background:#10b981; }
.s-yellow::before { background:#f59e0b; }
.s-red::before    { background:#ef4444; }
.s-blue::before   { background:#3b82f6; }
.mp-stat-label { font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.06em; margin-bottom:5px; }
.mp-stat-value { font-family:'Outfit',sans-serif; font-size:26px; font-weight:800; color:#0f172a; line-height:1; }
.mp-stat-sub   { font-size:11.5px; color:#94a3b8; margin-top:3px; }

/* Main card */
.mp-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.mp-card-head { padding:18px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
.mp-card-head-left h2 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:700; color:#0f172a; margin:0; }
.mp-card-head-left p  { font-size:12px; color:#94a3b8; margin:3px 0 0; }

/* Toolbar */
.mp-toolbar { padding:13px 24px; background:#f8fafc; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
.mp-search-wrap { position:relative; flex:1; min-width:220px; }
.mp-search-wrap svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; }
.mp-search { width:100%; padding:8px 12px 8px 36px; border:1.5px solid #e2e8f0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; color:#1e293b; background:#fff; outline:none; transition:border-color .18s,box-shadow .18s; }
.mp-search:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.mp-search::placeholder { color:#cbd5e1; }
.mp-filter { height:38px; padding:0 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; color:#475569; background:#fff; outline:none; cursor:pointer; }
.mp-filter:focus { border-color:#3b82f6; }

/* Table */
.mp-table-wrap { overflow-x:auto; }
.mp-table { width:100%; border-collapse:collapse; font-size:13px; }
.mp-table thead th { padding:10px 16px; text-align:left; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#94a3b8; background:#f8fafc; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
.mp-table tbody tr { border-bottom:1px solid #f8fafc; transition:background .14s; }
.mp-table tbody tr:hover { background:#f8fafc; }
.mp-table tbody tr:last-child { border-bottom:none; }
.mp-table tbody td { padding:13px 16px; color:#334155; vertical-align:middle; }
.t-permit-num { font-family:'Outfit',sans-serif; font-weight:700; color:#0f172a; font-size:13px; }
.t-bold { font-weight:600; color:#1e293b; }
.t-sub  { font-size:11.5px; color:#94a3b8; margin-top:2px; }

/* Expiry badge */
.mp-expiry { display:inline-flex; flex-direction:column; }
.mp-expiry-date { font-size:12.5px; color:#475569; font-weight:500; }
.mp-expiry-days { display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:20px; font-size:11px; font-weight:700; margin-top:3px; width:fit-content; }
.exp-ok      { background:#dcfce7; color:#15803d; }
.exp-warn    { background:#fef3c7; color:#b45309; }
.exp-expired { background:#fee2e2; color:#dc2626; }

/* Pills */
.mp-pill { display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:20px; font-size:11.5px; font-weight:700; white-space:nowrap; }
.pill-verified  { background:#dcfce7; color:#15803d; }
.pill-pending   { background:#fef3c7; color:#b45309; }
.pill-rejected  { background:#fee2e2; color:#dc2626; }
.pill-renewal   { background:#dbeafe; color:#1d4ed8; }

/* Type badge */
.mp-type { display:inline-flex; align-items:center; gap:5px; font-size:12px; color:#475569; font-weight:500; }

/* Document link */
.mp-doc-link { display:inline-flex; align-items:center; gap:5px; color:#3b82f6; font-size:12.5px; font-weight:600; text-decoration:none; }
.mp-doc-link:hover { text-decoration:underline; }
.mp-doc-none { color:#cbd5e1; font-size:12.5px; }

/* Action group */
.mp-actions { display:flex; align-items:center; gap:6px; }
.mp-icon-btn { width:30px; height:30px; display:flex; align-items:center; justify-content:center; border-radius:8px; border:1px solid #e2e8f0; background:#fff; cursor:pointer; transition:all .18s; color:#64748b; text-decoration:none; }
.mp-icon-btn:hover { border-color:#3b82f6; color:#3b82f6; background:#eff6ff; }
.mp-icon-btn.yellow:hover { border-color:#f59e0b; color:#d97706; background:#fffbeb; }
.mp-icon-btn.red:hover    { border-color:#ef4444; color:#dc2626; background:#fff1f2; }

/* Empty */
.mp-empty { padding:56px 24px; text-align:center; }
.mp-empty svg { margin:0 auto 14px; color:#cbd5e1; }
.mp-empty h3 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; color:#334155; margin-bottom:5px; }
.mp-empty p  { font-size:13px; color:#94a3b8; }

/* Modal overlay */
.mp-modal-overlay { position:fixed; inset:0; background:rgba(15,23,42,.6); backdrop-filter:blur(4px); z-index:999; display:none; align-items:flex-start; justify-content:center; padding:20px 16px; overflow-y:auto; }
.mp-modal-overlay.open { display:flex; }
.mp-modal-box { background:#fff; border-radius:16px; width:100%; max-width:640px; max-height:none; overflow:hidden; display:flex; flex-direction:column; box-shadow:0 30px 80px rgba(0,0,0,.22); animation:mpIn .22s ease; margin:auto; }
@keyframes mpIn { from{transform:translateY(10px) scale(.97);opacity:0;} to{transform:translateY(0) scale(1);opacity:1;} }
.mp-modal-head { background:linear-gradient(135deg,#059669,#0d9488); padding:20px 24px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
.mp-modal-head h3 { font-family:'Outfit',sans-serif; font-size:17px; font-weight:700; color:#fff; margin:0; }
.mp-modal-head p  { font-size:12px; color:rgba(255,255,255,.75); margin:2px 0 0; }
.mp-modal-x { background:none; border:none; color:rgba(255,255,255,.8); cursor:pointer; padding:4px; border-radius:6px; }
.mp-modal-x:hover { background:rgba(255,255,255,.15); color:#fff; }
.mp-modal-body { padding:24px; overflow-y:visible; flex:1; }
.mp-modal-footer { padding:16px 24px; border-top:1px solid #f1f5f9; background:#f8fafc; display:flex; justify-content:flex-end; gap:10px; flex-shrink:0; }

/* Modal form fields */
.mp-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.mp-field  { margin-bottom:16px; }
.mp-field:last-child { margin-bottom:0; }
.mp-label  { display:block; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#64748b; margin-bottom:6px; }
.mp-label .req { color:#ef4444; }
.mp-input, .mp-select, .mp-textarea {
    width:100%; height:42px; padding:0 13px;
    border:1.5px solid #e2e8f0; border-radius:9px;
    font-family:'DM Sans',sans-serif; font-size:13.5px; color:#1e293b;
    background:#f8fafc; outline:none;
    transition:border-color .18s,box-shadow .18s,background .18s;
}
.mp-input:focus,.mp-select:focus,.mp-textarea:focus { border-color:#059669; box-shadow:0 0 0 3px rgba(5,150,105,.1); background:#fff; }
.mp-input::placeholder { color:#cbd5e1; }
.mp-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 13px center; background-color:#f8fafc; padding-right:36px; }
.mp-textarea { height:auto; padding:11px 13px; resize:vertical; min-height:72px; }
.mp-hint { font-size:11.5px; color:#94a3b8; margin-top:4px; }

/* File zone */
.mp-file-zone { border:2px dashed #e2e8f0; border-radius:11px; padding:18px; text-align:center; cursor:pointer; transition:all .18s; background:#f8fafc; position:relative; }
.mp-file-zone:hover { border-color:#6ee7b7; background:#f0fdf4; }
.mp-file-zone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.mp-file-icon { width:38px; height:38px; background:#dcfce7; border-radius:10px; display:flex; align-items:center; justify-content:center; margin:0 auto 8px; }
.mp-file-title { font-size:13px; font-weight:600; color:#1e293b; margin-bottom:2px; }
.mp-file-sub   { font-size:12px; color:#94a3b8; }

/* Fee wrap */
.mp-fee-wrap { position:relative; }
.mp-fee-pfx  { position:absolute; left:13px; top:50%; transform:translateY(-50%); font-size:13.5px; font-weight:700; color:#94a3b8; pointer-events:none; }
.mp-fee-input { padding-left:28px !important; }

/* Section divider inside modal */
.mp-modal-section { font-family:'Outfit',sans-serif; font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; margin:20px 0 14px; padding-bottom:8px; border-bottom:1px solid #f1f5f9; }
.mp-modal-section:first-child { margin-top:0; }

/* Animations */
@keyframes mpFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.mp-a  { animation:mpFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s} .d4{animation-delay:.15s}

/* Responsive */
@media(max-width:900px)  { .mp-stats{grid-template-columns:repeat(2,1fr);} }
@media(max-width:700px)  { .mp-stats{grid-template-columns:1fr 1fr;} .mp-grid-2{grid-template-columns:1fr;} .mp-body{padding:18px 14px 40px;} .mp-header{padding:14px 18px;} }
</style>

<div class="mp-wrap">

    {{-- Header --}}
    <div class="mp-header">
        <div class="mp-header-left">
            <h1>Permit Document Management</h1>
            <p>Upload and track official government permits for compliance monitoring</p>
        </div>
        <div class="mp-header-right">
            <button type="button" onclick="openUploadModal()" class="mp-btn mp-btn-primary">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                Upload Permit
            </button>
        </div>
    </div>

    <div class="mp-body">

        {{-- Alerts --}}
        @if(session('success'))
        <div class="mp-alert alert-success mp-a d1">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mp-alert alert-error mp-a d1">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Stats --}}
        @php
            $totalPermits   = $permits->count();
            $verified       = $permits->where('compliance_status', 'compliant')->count();
            $expiringSoon   = $permits->filter(fn($p) => \Carbon\Carbon::parse($p->expiry_date ?? $p->end_date)->diffInDays(now(), false) < 0 && \Carbon\Carbon::parse($p->expiry_date ?? $p->end_date)->diffInDays(now(), false) > -30)->count();
            $expired        = $permits->filter(fn($p) => \Carbon\Carbon::parse($p->expiry_date ?? $p->end_date)->isPast())->count();
        @endphp
        <div class="mp-stats mp-a d1">
            <div class="mp-stat s-blue">
                <div class="mp-stat-label">Total Permits</div>
                <div class="mp-stat-value">{{ $totalPermits }}</div>
                <div class="mp-stat-sub">All uploaded</div>
            </div>
            <div class="mp-stat s-green">
                <div class="mp-stat-label">Verified</div>
                <div class="mp-stat-value">{{ $verified }}</div>
                <div class="mp-stat-sub">Compliant</div>
            </div>
            <div class="mp-stat s-yellow">
                <div class="mp-stat-label">Expiring Soon</div>
                <div class="mp-stat-value">{{ $expiringSoon }}</div>
                <div class="mp-stat-sub">Within 30 days</div>
            </div>
            <div class="mp-stat s-red">
                <div class="mp-stat-label">Expired</div>
                <div class="mp-stat-value">{{ $expired }}</div>
                <div class="mp-stat-sub">Needs renewal</div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="mp-card mp-a d2">
            <div class="mp-card-head">
                <div class="mp-card-head-left">
                    <h2>Uploaded Government Permits</h2>
                    <p>Scanned copies from LGU, DPWH, LTO, DENR, DOLE, and other agencies</p>
                </div>
            </div>

            {{-- Toolbar --}}
            <div class="mp-toolbar">
                <div class="mp-search-wrap">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" class="mp-search" id="permitSearch" placeholder="Search permit #, agency, project…" onkeyup="filterTable(this.value)">
                </div>
                <select class="mp-filter" id="statusFilter" onchange="filterTable()">
                    <option value="">All Statuses</option>
                    <option value="compliant">✅ Verified</option>
                    <option value="pending">⏳ Pending</option>
                    <option value="non_compliant">❌ Non-Compliant</option>
                    <option value="under_renewal">🔄 Under Renewal</option>
                </select>
                <select class="mp-filter" id="typeFilter" onchange="filterTable()">
                    <option value="">All Types</option>
                    <option value="construction">Construction</option>
                    <option value="oversize_vehicle">Oversize Vehicle</option>
                    <option value="tollway_pass">Tollway Pass</option>
                    <option value="roadworthiness">Roadworthiness</option>
                    <option value="environmental">Environmental</option>
                    <option value="crane_operation">Crane Operation</option>
                    <option value="fire_safety">Fire Safety</option>
                    <option value="electrical">Electrical</option>
                    <option value="occupancy">Occupancy</option>
                </select>
            </div>

            {{-- Table --}}
            <div class="mp-table-wrap">
                <table class="mp-table" id="permitsTable">
                    <thead>
                        <tr>
                            <th>Permit #</th>
                            <th>Issuing Agency</th>
                            <th>Type</th>
                            <th>Project / Site</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th>Document</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permits as $permit)
                        @php
                            $permitNum   = $permit->permit_number   ?? $permit->contract_number ?? 'N/A';
                            $agency      = $permit->issuing_authority ?? $permit->company_name  ?? 'N/A';
                            $office      = $permit->issuing_office   ?? '';
                            $type        = $permit->permit_type      ?? $permit->contract_type  ?? '';
                            $project     = $permit->project_name     ?? '—';
                            $issueDate   = $permit->issue_date       ?? $permit->start_date;
                            $expiryDate  = $permit->expiry_date      ?? $permit->end_date;
                            $status      = $permit->compliance_status ?? $permit->status ?? 'pending';
                            $docPath     = $permit->document_path    ?? $permit->permit_document ?? null;
                            $permitId    = $permit->id               ?? $permit->contract_id;

                            $expiry    = \Carbon\Carbon::parse($expiryDate);
                            $daysLeft  = (int) now()->diffInDays($expiry, false);

                            $typeLabels = [
                                'construction'     => '🏗️ Construction Permit',
                                'oversize_vehicle' => '🚛 Oversize Vehicle',
                                'tollway_pass'     => '🛣️ Tollway Pass',
                                'roadworthiness'   => '📋 Roadworthiness Cert.',
                                'environmental'    => '🌱 Environmental Cert.',
                                'crane_operation'  => '🏗️ Crane Operation',
                                'fire_safety'      => '🔥 Fire Safety Cert.',
                                'electrical'       => '⚡ Electrical Permit',
                                'occupancy'        => '🏢 Certificate of Occupancy',
                                'other'            => '📄 Other',
                            ];
                        @endphp
                        <tr class="permit-row"
                            data-search="{{ strtolower($permitNum . ' ' . $agency . ' ' . $project . ' ' . $type) }}"
                            data-status="{{ $status }}"
                            data-type="{{ $type }}">

                            <td><span class="t-permit-num">{{ $permitNum }}</span></td>

                            <td>
                                <div class="t-bold">{{ $agency }}</div>
                                @if($office)
                                <div class="t-sub">{{ $office }}</div>
                                @endif
                            </td>

                            <td>
                                <span class="mp-type">{{ $typeLabels[$type] ?? ucfirst(str_replace('_', ' ', $type)) }}</span>
                            </td>

                            <td>
                                <div class="t-bold" style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $project }}</div>
                            </td>

                            <td>
                                <div class="mp-expiry">
                                    <span class="mp-expiry-date">
                                        {{ \Carbon\Carbon::parse($issueDate)->format('M d, Y') }} –
                                        {{ $expiry->format('M d, Y') }}
                                    </span>
                                    @if($daysLeft > 30)
                                        <span class="mp-expiry-days exp-ok">✓ {{ $daysLeft }}d left</span>
                                    @elseif($daysLeft > 0)
                                        <span class="mp-expiry-days exp-warn">⚠ {{ $daysLeft }}d left</span>
                                    @else
                                        <span class="mp-expiry-days exp-expired">✕ Expired {{ abs($daysLeft) }}d ago</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                @if($status == 'compliant' || $status == 'approved')
                                    <span class="mp-pill pill-verified">✅ Verified</span>
                                @elseif($status == 'pending')
                                    <span class="mp-pill pill-pending">⏳ Pending</span>
                                @elseif($status == 'non_compliant' || $status == 'rejected')
                                    <span class="mp-pill pill-rejected">❌ Non-Compliant</span>
                                @elseif($status == 'under_renewal')
                                    <span class="mp-pill pill-renewal">🔄 Under Renewal</span>
                                @else
                                    <span class="mp-pill pill-pending">⏳ {{ ucfirst($status) }}</span>
                                @endif
                            </td>

                            <td>
                                @if($docPath)
                                    <a href="{{ asset('storage/' . $docPath) }}" target="_blank" class="mp-doc-link">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        View
                                    </a>
                                @else
                                    <span class="mp-doc-none">No file</span>
                                @endif
                            </td>

                            <td>
                                <div class="mp-actions">
                                    {{-- View --}}
                                    <a href="{{ route('permits.view', $permitId) }}" class="mp-icon-btn" title="View Details">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    {{-- Edit (only if pending or non-compliant) --}}
                                    @if(in_array($status, ['pending', 'non_compliant', 'under_renewal']))
                                    <a href="{{ route('permits.edit', $permitId) }}" class="mp-icon-btn yellow" title="Edit Permit">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="mp-empty">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <h3>No permits uploaded yet</h3>
                                    <p>Click "Upload Permit" to add official government permits for compliance tracking.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- ════════════ UPLOAD PERMIT MODAL ════════════ --}}
<div class="mp-modal-overlay" id="uploadModal">
    <div class="mp-modal-box">
        <div class="mp-modal-head">
            <div>
                <h3>Upload Government Permit</h3>
                <p>Register and attach scanned copy for compliance tracking</p>
            </div>
            <button class="mp-modal-x" onclick="closeUploadModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('permits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mp-modal-body">

                {{-- 1. Identification --}}
                <div class="mp-modal-section">Permit Identification</div>
                <div class="mp-grid-2">
                    <div class="mp-field">
                        <label class="mp-label">Permit Number <span class="req">*</span></label>
                        <input type="text" name="permit_number" class="mp-input" placeholder="e.g. CP-2024-001234" required>
                    </div>
                    <div class="mp-field">
                        <label class="mp-label">Issuing Agency <span class="req">*</span></label>
                        <select name="issuing_authority" class="mp-select" required>
                            <option value="">Select Agency</option>
                            <option value="LGU">LGU – Local Government Unit</option>
                            <option value="DPWH">DPWH – Public Works & Highways</option>
                            <option value="LTO">LTO – Land Transportation Office</option>
                            <option value="DENR">DENR – Environment & Natural Resources</option>
                            <option value="DOLE">DOLE – Labor and Employment</option>
                            <option value="SLLEX">SLEx / NLEX Tollway Authority</option>
                            <option value="BFP">BFP – Bureau of Fire Protection</option>
                            <option value="OTHER">Other Agency</option>
                        </select>
                    </div>
                </div>
                <div class="mp-field">
                    <label class="mp-label">Specific Office / Branch</label>
                    <input type="text" name="issuing_office" class="mp-input" placeholder="e.g. Makati City Engineering Office">
                </div>

                {{-- 2. Type --}}
                <div class="mp-modal-section">Permit Type</div>
                <div class="mp-field">
                    <label class="mp-label">Permit Type <span class="req">*</span></label>
                    <select name="permit_type" class="mp-select" required>
                        <option value="">Select Permit Type</option>
                        <option value="construction">🏗️ Construction Permit (LGU)</option>
                        <option value="oversize_vehicle">🚛 Oversize Vehicle Permit (DPWH)</option>
                        <option value="tollway_pass">🛣️ SLEx / NLEX Special Pass</option>
                        <option value="roadworthiness">📋 Roadworthiness Certificate (LTO)</option>
                        <option value="environmental">🌱 Environmental Certificate (DENR)</option>
                        <option value="crane_operation">🏗️ Crane Operation Permit (DOLE)</option>
                        <option value="fire_safety">🔥 Fire Safety Certificate (BFP)</option>
                        <option value="electrical">⚡ Electrical Permit (LGU)</option>
                        <option value="occupancy">🏢 Certificate of Occupancy (LGU)</option>
                        <option value="other">📄 Other Permit</option>
                    </select>
                </div>

                {{-- 3. Project & Site --}}
                <div class="mp-modal-section">Project & Equipment</div>
                <div class="mp-field">
                    <label class="mp-label">Project / Site Name <span class="req">*</span></label>
                    <input type="text" name="project_name" class="mp-input" placeholder="e.g. BGC Tower 4 Construction" required>
                </div>
                <div class="mp-field">
                    <label class="mp-label">Site Address <span class="req">*</span></label>
                    <textarea name="site_address" class="mp-textarea" placeholder="Full address of the worksite or deployment area" required></textarea>
                </div>
                <div class="mp-grid-2">
                    <div class="mp-field">
                        <label class="mp-label">Assigned Equipment</label>
                        <input type="text" name="equipment_assigned" class="mp-input" placeholder="e.g. TC-001, MC-003">
                        <p class="mp-hint">Units covered by this permit</p>
                    </div>
                    <div class="mp-field">
                        <label class="mp-label">Permit Fee Paid</label>
                        <div class="mp-fee-wrap">
                            <span class="mp-fee-pfx">₱</span>
                            <input type="number" name="permit_fee" step="0.01" min="0" class="mp-input mp-fee-input" placeholder="0.00">
                        </div>
                    </div>
                </div>

                {{-- 4. Validity --}}
                <div class="mp-modal-section">Validity Period</div>
                <div class="mp-grid-2">
                    <div class="mp-field">
                        <label class="mp-label">Issue Date <span class="req">*</span></label>
                        <input type="date" name="issue_date" class="mp-input" required>
                    </div>
                    <div class="mp-field">
                        <label class="mp-label">Expiry Date <span class="req">*</span></label>
                        <input type="date" name="expiry_date" class="mp-input" required>
                    </div>
                </div>
                <div class="mp-field">
                    <label class="mp-label">Renewal Alert Lead Time</label>
                    <select name="renewal_lead_days" class="mp-select">
                        <option value="30">30 days before expiry</option>
                        <option value="45">45 days before expiry</option>
                        <option value="60">60 days before expiry</option>
                        <option value="90">90 days before expiry</option>
                    </select>
                </div>

                {{-- 5. Document --}}
                <div class="mp-modal-section">Document Upload</div>
                <div class="mp-field">
                    <div class="mp-file-zone">
                        <input type="file" name="permit_document" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="mp-file-icon">
                            <svg width="18" height="18" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <div class="mp-file-title">Drop file or click to browse</div>
                        <div class="mp-file-sub" id="uploadFileSub">PDF, JPG, JPEG, PNG · Max 10MB</div>
                    </div>
                </div>

                {{-- 6. Notes --}}
                <div class="mp-modal-section">Notes & Compliance</div>
                <div class="mp-field">
                    <label class="mp-label">Permit Conditions / Remarks</label>
                    <textarea name="notes" class="mp-textarea" placeholder="e.g. Valid only for daytime operations. Must post permit on-site."></textarea>
                </div>
                <div class="mp-field" style="margin-bottom:0;">
                    <label class="mp-label">Compliance Status</label>
                    <select name="compliance_status" class="mp-select">
                        <option value="pending">⏳ Pending – Awaiting verification</option>
                        <option value="compliant">✅ Compliant – All requirements met</option>
                        <option value="non_compliant">❌ Non-Compliant – Action required</option>
                        <option value="under_renewal">🔄 Under Renewal – In process</option>
                    </select>
                </div>

            </div>

            <div class="mp-modal-footer">
                <button type="button" onclick="closeUploadModal()" class="mp-btn mp-btn-ghost">Cancel</button>
                <button type="submit" class="mp-btn mp-btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    Upload Permit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal
function openUploadModal()  { document.getElementById('uploadModal').classList.add('open'); }
function closeUploadModal() { document.getElementById('uploadModal').classList.remove('open'); }
document.getElementById('uploadModal').addEventListener('click', e => {
    if (e.target === document.getElementById('uploadModal')) closeUploadModal();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeUploadModal(); });

// File label feedback
document.querySelector('#uploadModal input[type="file"]').addEventListener('change', function() {
    const sub = document.getElementById('uploadFileSub');
    if (this.files[0]) {
        sub.textContent = this.files[0].name + ' · ' + (this.files[0].size/1024/1024).toFixed(2) + ' MB';
        sub.style.color = '#059669';
    }
});

// Table filter
function filterTable(searchVal) {
    const q      = (searchVal ?? document.getElementById('permitSearch').value).toLowerCase();
    const status = document.getElementById('statusFilter').value;
    const type   = document.getElementById('typeFilter').value;
    document.querySelectorAll('.permit-row').forEach(row => {
        const matchQ = !q      || row.dataset.search.includes(q);
        const matchS = !status || row.dataset.status === status;
        const matchT = !type   || row.dataset.type   === type;
        row.style.display = (matchQ && matchS && matchT) ? '' : 'none';
    });
}
</script>

@endsection