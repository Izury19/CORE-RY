@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.cm-wrap * { box-sizing: border-box; }
.cm-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.cm-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.cm-header-left h1 { font-family:'Outfit',sans-serif; font-size:22px; font-weight:800; color:#0f172a; letter-spacing:-0.03em; margin:0; }
.cm-header-left p  { font-size:13px; color:#94a3b8; margin:3px 0 0; }
.cm-header-right   { display:flex; gap:10px; }

/* Buttons */
.cm-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.18s; text-decoration:none; white-space:nowrap; }
.cm-btn-primary { background:#4f46e5; color:#fff; }
.cm-btn-primary:hover { background:#4338ca; transform:translateY(-1px); box-shadow:0 4px 12px rgba(79,70,229,0.3); }
.cm-btn-ghost   { background:#f1f5f9; color:#475569; }
.cm-btn-ghost:hover { background:#e2e8f0; }

/* Body */
.cm-body { max-width:1400px; margin:0 auto; padding:28px 32px 60px; }

/* Alerts */
.cm-alert { display:flex; align-items:center; gap:10px; padding:13px 18px; border-radius:10px; margin-bottom:18px; font-size:13.5px; font-weight:500; }
.alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
.alert-error   { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }
.alert-info    { background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; }

/* Stats */
.cm-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:24px; }
.cm-stat { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.04); transition:all .18s; }
.cm-stat:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,0.08); }
.cm-stat::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; border-radius:4px 0 0 4px; }
.s-blue::before   { background:#3b82f6; }
.s-yellow::before { background:#f59e0b; }
.s-green::before  { background:#10b981; }
.cm-stat-inner { display:flex; align-items:flex-start; gap:14px; }
.cm-stat-icon { width:44px; height:44px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.icon-blue   { background:#dbeafe; }
.icon-yellow { background:#fef3c7; }
.icon-green  { background:#dcfce7; }
.cm-stat-label { font-size:11.5px; font-weight:600; color:#64748b; margin-bottom:5px; }
.cm-stat-value { font-family:'Outfit',sans-serif; font-size:30px; font-weight:800; color:#0f172a; line-height:1; margin-bottom:4px; }
.cm-stat-sub   { font-size:11.5px; font-weight:600; }
.sub-blue   { color:#3b82f6; }
.sub-yellow { color:#f59e0b; }
.sub-green  { color:#10b981; }

/* Main card */
.cm-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.cm-card-head { padding:18px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
.cm-card-head-left h2 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:700; color:#0f172a; margin:0; }
.cm-card-head-left p  { font-size:12px; color:#94a3b8; margin:3px 0 0; }

/* Toolbar */
.cm-toolbar { padding:13px 24px; background:#f8fafc; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.cm-search-wrap { position:relative; flex:1; min-width:220px; }
.cm-search-wrap svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; }
.cm-search { width:100%; padding:9px 12px 9px 36px; border:1.5px solid #e2e8f0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; color:#1e293b; background:#fff; outline:none; transition:border-color .18s,box-shadow .18s; }
.cm-search:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); }
.cm-search::placeholder { color:#cbd5e1; }
.cm-filter { height:40px; padding:0 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; color:#475569; background:#fff; outline:none; cursor:pointer; }
.cm-filter:focus { border-color:#4f46e5; }

/* Table */
.cm-table-wrap { overflow-x:auto; }
.cm-table { width:100%; border-collapse:collapse; font-size:13px; }
.cm-table thead th { padding:11px 16px; text-align:left; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#94a3b8; background:#f8fafc; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
.cm-table tbody tr { border-bottom:1px solid #f8fafc; transition:background .14s; }
.cm-table tbody tr:hover { background:#f8fafc; }
.cm-table tbody tr:last-child { border-bottom:none; }
.cm-table tbody td { padding:13px 16px; color:#334155; vertical-align:middle; }
.t-contract-num { font-family:'Outfit',sans-serif; font-weight:700; color:#0f172a; font-size:13px; }
.t-bold { font-weight:600; color:#1e293b; }
.t-sub  { font-size:11.5px; color:#94a3b8; margin-top:2px; }
.t-amount { font-family:'Outfit',sans-serif; font-weight:700; color:#0f172a; font-size:13.5px; }

/* Status pills */
.cm-pill { display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:20px; font-size:11.5px; font-weight:700; white-space:nowrap; }
.pill-pending  { background:#fef3c7; color:#b45309; }
.pill-approved { background:#dcfce7; color:#15803d; }
.pill-rejected { background:#fee2e2; color:#dc2626; }

/* Action buttons */
.cm-actions { display:flex; align-items:center; gap:6px; }
.cm-icon-btn { height:30px; display:inline-flex; align-items:center; gap:5px; padding:0 10px; border-radius:8px; border:1px solid #e2e8f0; background:#fff; cursor:pointer; transition:all .18s; color:#64748b; text-decoration:none; font-size:12px; font-weight:600; white-space:nowrap; }
.cm-icon-btn:hover       { border-color:#3b82f6; color:#3b82f6; background:#eff6ff; }
.cm-icon-btn.yellow:hover { border-color:#f59e0b; color:#d97706; background:#fffbeb; }
.cm-icon-btn.gray:hover   { border-color:#94a3b8; color:#475569; background:#f1f5f9; }

/* Empty */
.cm-empty { padding:56px 24px; text-align:center; }
.cm-empty svg { margin:0 auto 14px; color:#cbd5e1; }
.cm-empty h3 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; color:#334155; margin-bottom:5px; }
.cm-empty p  { font-size:13px; color:#94a3b8; }

/* Pagination */
.cm-pagination { padding:16px 24px; border-top:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.cm-pagination-info { font-size:13px; color:#64748b; }

/* Modal overlay */
.cm-modal-overlay { position:fixed; inset:0; background:rgba(15,23,42,.6); backdrop-filter:blur(4px); z-index:999; display:none; align-items:flex-start; justify-content:center; padding:20px 16px; overflow-y:auto; }
.cm-modal-overlay.open { display:flex; }
.cm-modal-box { background:#fff; border-radius:16px; width:100%; max-width:620px; overflow:hidden; display:flex; flex-direction:column; box-shadow:0 30px 80px rgba(0,0,0,.22); animation:cmIn .22s ease; margin:auto; }
@keyframes cmIn { from{transform:translateY(10px) scale(.97);opacity:0;} to{transform:translateY(0) scale(1);opacity:1;} }
.cm-modal-head { background:linear-gradient(135deg,#4f46e5,#7c3aed); padding:20px 24px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
.cm-modal-head h3 { font-family:'Outfit',sans-serif; font-size:17px; font-weight:700; color:#fff; margin:0; }
.cm-modal-head p  { font-size:12px; color:rgba(255,255,255,.75); margin:2px 0 0; }
.cm-modal-x { background:none; border:none; color:rgba(255,255,255,.8); cursor:pointer; padding:4px; border-radius:6px; }
.cm-modal-x:hover { background:rgba(255,255,255,.15); color:#fff; }
.cm-modal-body { padding:24px; overflow-y:visible; flex:1; }
.cm-modal-footer { padding:16px 24px; border-top:1px solid #f1f5f9; background:#f8fafc; display:flex; justify-content:flex-end; gap:10px; flex-shrink:0; }

/* Modal section headers */
.cm-modal-section { font-family:'Outfit',sans-serif; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; margin:20px 0 12px; padding-bottom:8px; border-bottom:1px solid #f1f5f9; }
.cm-modal-section:first-child { margin-top:0; }

/* Form fields */
.cm-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.cm-field  { margin-bottom:14px; }
.cm-field:last-child { margin-bottom:0; }
.cm-label  { display:block; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#64748b; margin-bottom:6px; }
.cm-label .req { color:#ef4444; }
.cm-input, .cm-select, .cm-textarea {
    width:100%; height:42px; padding:0 13px;
    border:1.5px solid #e2e8f0; border-radius:9px;
    font-family:'DM Sans',sans-serif; font-size:13.5px; color:#1e293b;
    background:#f8fafc; outline:none;
    transition:border-color .18s,box-shadow .18s,background .18s;
}
.cm-input:focus,.cm-select:focus,.cm-textarea:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); background:#fff; }
.cm-input::placeholder { color:#cbd5e1; }
.cm-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 13px center; background-color:#f8fafc; padding-right:36px; }
.cm-textarea { height:auto; padding:11px 13px; resize:vertical; min-height:80px; }

/* Amount prefix */
.cm-amount-wrap { position:relative; }
.cm-amount-pfx  { position:absolute; left:13px; top:50%; transform:translateY(-50%); font-size:13.5px; font-weight:700; color:#94a3b8; pointer-events:none; }
.cm-amount-input { padding-left:26px !important; }

/* File zone */
.cm-file-zone { border:2px dashed #e2e8f0; border-radius:11px; padding:16px; text-align:center; cursor:pointer; transition:all .18s; background:#f8fafc; position:relative; }
.cm-file-zone:hover { border-color:#a5b4fc; background:#eef2ff; }
.cm-file-zone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.cm-file-title { font-size:13px; font-weight:600; color:#1e293b; margin-bottom:2px; }
.cm-file-sub   { font-size:12px; color:#94a3b8; }

/* Animations */
@keyframes cmFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.cm-a  { animation:cmFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s}

@media(max-width:900px)  { .cm-stats{grid-template-columns:1fr 1fr 1fr;} }
@media(max-width:700px)  { .cm-stats{grid-template-columns:1fr;} .cm-body{padding:18px 14px 40px;} .cm-header{padding:14px 18px;} .cm-grid-2{grid-template-columns:1fr;} }
</style>

<div class="cm-wrap">

    {{-- Header --}}
    <div class="cm-header">
        <div class="cm-header-left">
            <h1>Contract Management</h1>
            <p>Create and manage legal contracts — submitted automatically to Legal Management for approval</p>
        </div>
        <div class="cm-header-right">
            <button type="button" onclick="openCreateModal()" class="cm-btn cm-btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Create Contract
            </button>
        </div>
    </div>

    <div class="cm-body">

        {{-- Alerts --}}
        @if(session('success'))
        <div class="cm-alert alert-success cm-a d1">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="cm-alert alert-error cm-a d1">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif
        @if(session('info'))
        <div class="cm-alert alert-info cm-a d1">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('info') }}
        </div>
        @endif

        {{-- Stats --}}
        <div class="cm-stats cm-a d1">
            <div class="cm-stat s-blue">
                <div class="cm-stat-inner">
                    <div class="cm-stat-icon icon-blue">
                        <svg width="20" height="20" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <div class="cm-stat-label">Total Contracts</div>
                        <div class="cm-stat-value">{{ $contracts->count() }}</div>
                        <div class="cm-stat-sub sub-blue">All contracts</div>
                    </div>
                </div>
            </div>
            <div class="cm-stat s-yellow">
                <div class="cm-stat-inner">
                    <div class="cm-stat-icon icon-yellow">
                        <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="cm-stat-label">Pending Review</div>
                        <div class="cm-stat-value">{{ $contracts->where('status','pending')->count() }}</div>
                        <div class="cm-stat-sub sub-yellow">Awaiting legal</div>
                    </div>
                </div>
            </div>
            <div class="cm-stat s-green">
                <div class="cm-stat-inner">
                    <div class="cm-stat-icon icon-green">
                        <svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="cm-stat-label">Approved</div>
                        <div class="cm-stat-value">{{ $contracts->where('status','approved')->count() }}</div>
                        <div class="cm-stat-sub sub-green">Ready for execution</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="cm-card cm-a d2">
            <div class="cm-card-head">
                <div class="cm-card-head-left">
                    <h2>Submitted Contracts</h2>
                    <p>Contracts sent to Legal Management for review and approval</p>
                </div>
            </div>

            {{-- Toolbar --}}
            <div class="cm-toolbar">
                <form method="GET" class="cm-search-wrap" id="searchForm">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" name="search" class="cm-search"
                           placeholder="Search contract #, client, or type…"
                           value="{{ request('search') }}"
                           onchange="document.getElementById('searchForm').submit()">
                    <input type="hidden" name="status"     value="{{ request('status') }}">
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    <input type="hidden" name="end_date"   value="{{ request('end_date') }}">
                </form>
                <form method="GET" id="filterForm">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="status" class="cm-filter" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Statuses</option>
                        <option value="pending"  {{ request('status')=='pending'  ?'selected':'' }}>⏳ Pending</option>
                        <option value="approved" {{ request('status')=='approved' ?'selected':'' }}>✅ Approved</option>
                        <option value="rejected" {{ request('status')=='rejected' ?'selected':'' }}>❌ Rejected</option>
                    </select>
                </form>
                <input type="date" name="start_date" class="cm-filter" value="{{ request('start_date') }}"
                       title="From date" onchange="document.getElementById('filterForm').submit()">
                <input type="date" name="end_date" class="cm-filter" value="{{ request('end_date') }}"
                       title="To date" onchange="document.getElementById('filterForm').submit()">
            </div>

            {{-- Table --}}
            <div class="cm-table-wrap">
                <table class="cm-table">
                    <thead>
                        <tr>
                            <th>Contract #</th>
                            <th>Type</th>
                            <th>Counterparty</th>
                            <th>Validity</th>
                            <th>Amount</th>
                            <th>Legal Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contracts as $contract)
                        <tr>
                            <td><span class="t-contract-num">{{ $contract->contract_number }}</span></td>

                            <td>
                                <div class="t-bold">{{ ucfirst(str_replace('_',' ',$contract->contract_type)) }}</div>
                            </td>

                            <td>
                                <div class="t-bold">{{ $contract->company_name }}</div>
                            </td>

                            <td>
                                <div style="font-size:12.5px;color:#475569;font-weight:500;">
                                    {{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }}
                                </div>
                                <div class="t-sub">→ {{ \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') }}</div>
                            </td>

                            <td>
                                <span class="t-amount">₱{{ number_format($contract->total_amount ?? 0, 2) }}</span>
                            </td>

                            <td>
                                @if($contract->status == 'pending')
                                    <span class="cm-pill pill-pending">⏳ Pending Review</span>
                                @elseif($contract->status == 'approved')
                                    <span class="cm-pill pill-approved">✅ Approved</span>
                                @else
                                    <span class="cm-pill pill-rejected">❌ Rejected</span>
                                @endif
                            </td>

                            <td>
                                <div class="cm-actions">
                                    <a href="{{ route('contracts.view', $contract->contract_id) }}" class="cm-icon-btn" title="View">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                    @if($contract->status == 'pending')
                                    <a href="{{ route('contracts.edit', $contract->contract_id) }}" class="cm-icon-btn yellow" title="Edit">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    @else
                                    <form action="{{ route('contracts.refresh-status', $contract->contract_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="cm-icon-btn gray" title="Refresh Status">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Refresh
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="cm-empty">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <h3>No contracts submitted yet</h3>
                                    <p>Click "Create Contract" to submit a new contract for legal review.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($contracts->hasPages())
            <div class="cm-pagination">
                <div class="cm-pagination-info">
                    Showing {{ $contracts->firstItem() }}–{{ $contracts->lastItem() }} of {{ $contracts->total() }} contracts
                </div>
                <div>{{ $contracts->links() }}</div>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- ════════════ CREATE CONTRACT MODAL ════════════ --}}
<div class="cm-modal-overlay" id="createModal">
    <div class="cm-modal-box">
        <div class="cm-modal-head">
            <div>
                <h3>Submit New Contract</h3>
                <p>Will be sent to Legal Management Module for approval</p>
            </div>
            <button class="cm-modal-x" onclick="closeCreateModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="cm-modal-body">

                {{-- Contract Identity --}}
                <div class="cm-modal-section">Contract Identity</div>
                <div class="cm-grid-2">
                    <div class="cm-field">
                        <label class="cm-label">Contract Type <span class="req">*</span></label>
                        <select name="contract_type" class="cm-select" required>
                            <option value="">Select type…</option>
                            <option value="rental">Rental</option>
                            <option value="service">Service</option>
                            <option value="procurement">Procurement</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="cm-field">
                        <label class="cm-label">Contract Number <span class="req">*</span></label>
                        <input type="text" name="contract_number" class="cm-input" placeholder="e.g. CT-2026-001" required>
                    </div>
                </div>

                {{-- Counterparty --}}
                <div class="cm-modal-section">Counterparty</div>
                <div class="cm-field">
                    <label class="cm-label">Company / Individual <span class="req">*</span></label>
                    <input type="text" name="counterparty" class="cm-input" placeholder="Client or vendor name" required>
                </div>
                <div class="cm-grid-2">
                    <div class="cm-field">
                        <label class="cm-label">Contact Email</label>
                        <input type="email" name="contact_email" class="cm-input" placeholder="contact@company.com">
                    </div>
                    <div class="cm-field">
                        <label class="cm-label">Contact Number</label>
                        <input type="text" name="contact_number" class="cm-input" placeholder="+63 9XX XXX XXXX">
                    </div>
                </div>

                {{-- Validity & Financials --}}
                <div class="cm-modal-section">Validity & Financials</div>
                <div class="cm-grid-2">
                    <div class="cm-field">
                        <label class="cm-label">Effective Date <span class="req">*</span></label>
                        <input type="date" name="effective_date" class="cm-input" required>
                    </div>
                    <div class="cm-field">
                        <label class="cm-label">Expiration Date <span class="req">*</span></label>
                        <input type="date" name="expiration_date" class="cm-input" required>
                    </div>
                </div>
                <div class="cm-grid-2">
                    <div class="cm-field">
                        <label class="cm-label">Total Amount (₱) <span class="req">*</span></label>
                        <div class="cm-amount-wrap">
                            <span class="cm-amount-pfx">₱</span>
                            <input type="number" name="total_amount" step="0.01" min="0" class="cm-input cm-amount-input" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="cm-field">
                        <label class="cm-label">Payment Terms</label>
                        <select name="payment_type" class="cm-select">
                            <option value="net_30">Net 30 Days</option>
                            <option value="net_60">Net 60 Days</option>
                            <option value="upon_delivery">Upon Delivery</option>
                        </select>
                    </div>
                </div>

                {{-- Equipment & Scope --}}
                <div class="cm-modal-section">Equipment & Scope</div>
                <div class="cm-field">
                    <label class="cm-label">Equipment Type (if applicable)</label>
                    <select name="equipment_type" class="cm-select">
                        <option value="">Select equipment…</option>
                        <option value="tower_crane">🏗️ Tower Crane</option>
                        <option value="mobile_crane">🚛 Mobile Crane</option>
                        <option value="dump_truck">🚚 Dump Truck</option>
                        <option value="concrete_mixer">🔩 Concrete Mixer</option>
                    </select>
                </div>
                <div class="cm-field">
                    <label class="cm-label">Contract Details / Scope of Work</label>
                    <textarea name="contract_details" class="cm-textarea" placeholder="Describe scope of work, deliverables, and terms…"></textarea>
                </div>

                {{-- Documents --}}
                <div class="cm-modal-section">Supporting Documents</div>
                <div class="cm-field" style="margin-bottom:0;">
                    <div class="cm-file-zone">
                        <input type="file" name="documents[]" accept=".pdf,.doc,.docx" multiple>
                        <div style="margin-bottom:6px;">
                            <svg width="28" height="28" fill="none" stroke="#4f46e5" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 6px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <div class="cm-file-title">Drop files or click to browse</div>
                        <div class="cm-file-sub">PDF, DOC, DOCX · SOW, specs, or supporting documents</div>
                    </div>
                </div>

            </div>

            <div class="cm-modal-footer">
                <button type="button" onclick="closeCreateModal()" class="cm-btn cm-btn-ghost">Cancel</button>
                <button type="submit" class="cm-btn cm-btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Submit for Legal Review
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateModal()  { document.getElementById('createModal').classList.add('open'); }
function closeCreateModal() { document.getElementById('createModal').classList.remove('open'); }
document.getElementById('createModal').addEventListener('click', e => {
    if (e.target === document.getElementById('createModal')) closeCreateModal();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeCreateModal(); });
</script>

@endsection