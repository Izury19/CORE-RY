@extends('layouts.app')

@section('content')

{{-- ════════════════════════════════════════
    RECORD & PAYMENT MANAGEMENT — REDESIGNED
    All Laravel/Blade directives preserved.
════════════════════════════════════════ --}}

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
    .rp-wrap * { box-sizing: border-box; }
    .rp-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; }

    /* ── Page Header ── */
    .rp-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px; }
    .rp-header-left h1 { font-family:'Outfit',sans-serif; font-size:23px; font-weight:700; color:#0f172a; letter-spacing:-0.02em; }
    .rp-header-left p  { font-size:13px; color:#94a3b8; margin-top:3px; }
    .rp-header-right   { display:flex; align-items:center; gap:10px; }

    .rp-count-badge {
        display:inline-flex; align-items:center; gap:6px; padding:6px 14px;
        background:#f0fdf4; border:1px solid #bbf7d0; border-radius:20px;
        color:#15803d; font-size:12.5px; font-weight:600;
    }

    .rp-btn {
        display:inline-flex; align-items:center; gap:7px; padding:9px 18px;
        border:none; border-radius:9px; font-family:'DM Sans',sans-serif;
        font-size:13px; font-weight:600; cursor:pointer; transition:all 0.18s; white-space:nowrap;
    }
    .rp-btn-primary { background:#1e40af; color:#fff; }
    .rp-btn-primary:hover { background:#1d3a9e; transform:translateY(-1px); box-shadow:0 4px 12px rgba(30,64,175,0.3); }
    .rp-btn-ghost  { background:#f1f5f9; color:#475569; }
    .rp-btn-ghost:hover { background:#e2e8f0; }
    .rp-btn-success { background:#059669; color:#fff; }
    .rp-btn-success:hover { background:#047857; }

    /* ── Summary Cards ── */
    .rp-summary-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:22px; }
    .rp-summary-card {
        background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:22px;
        display:flex; align-items:center; justify-content:space-between;
        box-shadow:0 1px 4px rgba(0,0,0,0.04); position:relative; overflow:hidden;
        transition:box-shadow 0.2s;
    }
    .rp-summary-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.08); }
    .rp-summary-card-accent {
        position:absolute; top:0; left:0; bottom:0; width:4px; border-radius:14px 0 0 14px;
    }
    .rp-summary-label { font-size:12px; font-weight:600; color:#94a3b8; letter-spacing:0.03em; margin-bottom:6px; text-transform:uppercase; }
    .rp-summary-value { font-family:'Outfit',sans-serif; font-size:28px; font-weight:700; color:#0f172a; letter-spacing:-0.03em; line-height:1; }
    .rp-summary-sub   { font-size:12px; color:#94a3b8; margin-top:5px; }
    .rp-summary-icon  { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

    /* ── Filters Bar ── */
    .rp-filter-bar {
        background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:16px 20px;
        margin-bottom:22px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;
        box-shadow:0 1px 4px rgba(0,0,0,0.04);
    }
    .rp-filter-search { position:relative; flex:1; min-width:200px; }
    .rp-filter-search svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; }
    .rp-input {
        height:38px; padding:0 12px; border:1.5px solid #e2e8f0; border-radius:9px;
        font-family:'DM Sans',sans-serif; font-size:13px; color:#1e293b; background:#f8fafc;
        outline:none; transition:border-color 0.18s, box-shadow 0.18s; width:100%;
    }
    .rp-input:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,0.1); background:#fff; }
    .rp-input::placeholder { color:#cbd5e1; }
    .rp-search-input { padding-left:36px; }
    .rp-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; padding-right:30px; }

    /* ── Table Card ── */
    .rp-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; margin-bottom:22px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
    .rp-card-header { padding:18px 24px; border-bottom:1px solid #f1f5f9; }
    .rp-card-header h2 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
    .rp-card-header p  { font-size:12px; color:#94a3b8; margin-top:3px; }

    .rp-table-wrap { overflow-x:auto; }
    .rp-table { width:100%; border-collapse:collapse; font-size:13px; }
    .rp-table thead th {
        padding:11px 16px; text-align:left; font-size:11px; font-weight:600;
        letter-spacing:0.06em; text-transform:uppercase; color:#94a3b8;
        background:#f8fafc; border-bottom:1px solid #f1f5f9; white-space:nowrap;
    }
    .rp-table tbody tr { border-bottom:1px solid #f8fafc; transition:background 0.15s; }
    .rp-table tbody tr:hover { background:#f8fafc; }
    .rp-table tbody tr:last-child { border-bottom:none; }
    .rp-table tbody td { padding:13px 16px; color:#334155; vertical-align:middle; }

    .rp-inv-id { font-family:'Outfit',sans-serif; font-weight:600; color:#0f172a; font-size:13px; }
    .rp-client  { font-weight:500; color:#1e293b; }
    .rp-amount  { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; }
    .rp-ref     { font-size:12.5px; color:#64748b; font-family:'DM Sans',sans-serif; }

    /* Payment method badges */
    .rp-method { display:inline-flex; align-items:center; gap:5px; font-size:12.5px; font-weight:600; }
    .rp-method-bank  { color:#1d4ed8; }
    .rp-method-gcash { color:#059669; }
    .rp-method-cash  { color:#b45309; }
    .rp-method-check { color:#475569; }
    .rp-method-none  { color:#94a3b8; font-weight:400; font-style:italic; }

    /* Status Pills */
    .rp-pill { display:inline-flex; align-items:center; padding:3px 11px; border-radius:20px; font-size:11.5px; font-weight:700; white-space:nowrap; }
    .pill-pending   { background:#fef3c7; color:#b45309; }
    .pill-complete  { background:#dcfce7; color:#15803d; }

    /* Confidential blur */
    .conf-wrap   { position:relative; display:inline-flex; align-items:center; }
    .conf-val    { transition:filter 0.3s; display:inline-block; }
    .conf-val.blurred { filter:blur(8px); user-select:none; pointer-events:none; }
    .conf-unlock {
        position:absolute; left:50%; top:50%; transform:translate(-50%,-50%);
        background:#0f172a; color:#fbbf24; border:none; padding:3px 9px; border-radius:6px;
        font-family:'DM Sans',sans-serif; font-size:11px; font-weight:700; cursor:pointer;
        white-space:nowrap; box-shadow:0 2px 8px rgba(0,0,0,0.3);
        display:flex; align-items:center; gap:4px;
    }
    .conf-unlock.hidden { display:none; }

    /* Empty state */
    .rp-empty { padding:56px 24px; text-align:center; }
    .rp-empty svg { margin:0 auto 14px; color:#cbd5e1; }
    .rp-empty h3 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; color:#334155; margin-bottom:5px; }
    .rp-empty p  { font-size:13px; color:#94a3b8; }

    /* ── Pagination ── */
    .rp-pagination {
        padding:14px 24px; border-top:1px solid #f1f5f9;
        display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;
    }
    .rp-pagination-info { font-size:13px; color:#64748b; display:flex; align-items:center; gap:10px; }
    .rp-per-page-select {
        height:32px; padding:0 10px; border:1.5px solid #e2e8f0; border-radius:8px;
        font-family:'DM Sans',sans-serif; font-size:13px; color:#1e293b; background:#f8fafc;
        outline:none; cursor:pointer;
    }
    .rp-page-btns { display:flex; align-items:center; gap:4px; }
    .rp-page-btn {
        width:34px; height:34px; display:flex; align-items:center; justify-content:center;
        border:1.5px solid #e2e8f0; border-radius:8px; background:#fff; color:#64748b;
        font-size:13px; font-weight:600; cursor:pointer; transition:all 0.15s;
        font-family:'DM Sans',sans-serif;
    }
    .rp-page-btn:hover:not(:disabled) { border-color:#3b82f6; color:#3b82f6; background:#eff6ff; }
    .rp-page-btn:disabled { opacity:0.35; cursor:not-allowed; }

    /* ── Modals ── */
    .rp-modal-overlay {
        position:fixed; inset:0; background:rgba(15,23,42,0.6); backdrop-filter:blur(4px);
        z-index:999; display:none; align-items:center; justify-content:center; padding:16px;
    }
    .rp-modal-overlay.open { display:flex; }
    .rp-modal-box {
        background:#fff; border-radius:16px; width:100%; max-width:480px;
        box-shadow:0 30px 80px rgba(0,0,0,0.2); animation:rpModalIn 0.25s ease; overflow:hidden;
    }
    @keyframes rpModalIn {
        from { transform:translateY(12px) scale(0.97); opacity:0; }
        to   { transform:translateY(0) scale(1); opacity:1; }
    }
    .rp-modal-head { padding:20px 24px; display:flex; align-items:center; justify-content:space-between; }
    .rp-modal-head h3 { font-family:'Outfit',sans-serif; font-size:17px; font-weight:700; color:#fff; }
    .rp-modal-head p  { font-size:12px; color:rgba(255,255,255,0.7); margin-top:2px; }
    .rp-modal-close { background:none; border:none; cursor:pointer; color:rgba(255,255,255,0.8); padding:4px; border-radius:6px; transition:background 0.15s; }
    .rp-modal-close:hover { background:rgba(255,255,255,0.15); color:#fff; }
    .rp-modal-body { padding:24px; }
    .rp-modal-footer { display:flex; justify-content:flex-end; gap:10px; padding:16px 24px; border-top:1px solid #f1f5f9; background:#f8fafc; }

    .rp-form-label { display:block; font-size:11.5px; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; color:#64748b; margin-bottom:6px; }
    .rp-form-input, .rp-form-select {
        width:100%; height:42px; padding:0 13px; border:1.5px solid #e2e8f0; border-radius:9px;
        font-family:'DM Sans',sans-serif; font-size:14px; color:#1e293b; background:#f8fafc;
        outline:none; transition:border-color 0.18s, box-shadow 0.18s; margin-bottom:16px;
    }
    .rp-form-input:focus, .rp-form-select:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,0.1); background:#fff; }
    .rp-form-input.readonly { background:#f1f5f9; color:#64748b; cursor:not-allowed; font-weight:600; color:#0f172a; }
    .rp-form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .rp-form-select-wrap { position:relative; margin-bottom:16px; }
    .rp-form-select-wrap select { margin-bottom:0; }
    .rp-form-select-wrap::after {
        content:''; position:absolute; right:12px; top:50%; transform:translateY(-50%);
        border:5px solid transparent; border-top-color:#94a3b8; pointer-events:none;
    }

    /* Password modal specifics */
    .rp-modal-box-sm { max-width:400px; }
    .rp-modal-icon-ring { width:52px; height:52px; background:#fef3c7; border-radius:13px; display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
    .rp-modal-title { font-family:'Outfit',sans-serif; font-size:18px; font-weight:700; color:#0f172a; margin-bottom:6px; }
    .rp-modal-desc  { font-size:13.5px; color:#64748b; margin-bottom:20px; line-height:1.5; }
    .rp-pwd-input {
        width:100%; height:42px; padding:0 13px; border:1.5px solid #e2e8f0; border-radius:9px;
        font-family:'DM Sans',sans-serif; font-size:14px; color:#1e293b; background:#f8fafc;
        outline:none; transition:border-color 0.18s, box-shadow 0.18s; margin-bottom:10px;
    }
    .rp-pwd-input:focus { border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.12); background:#fff; }
    .rp-modal-error { font-size:12.5px; color:#dc2626; display:none; margin-bottom:10px; }
    .rp-modal-error.show { display:block; }
    .rp-modal-actions { display:flex; gap:10px; margin-top:4px; }
    .rp-btn-verify { flex:1; height:42px; background:#0f172a; color:#fff; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:700; cursor:pointer; }
    .rp-btn-verify:hover { background:#1e293b; }
    .rp-btn-cancel { height:42px; padding:0 18px; background:#f1f5f9; color:#64748b; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:600; cursor:pointer; }
    .rp-btn-cancel:hover { background:#e2e8f0; }

    /* ── Animations ── */
    @keyframes rpFadeUp { from{opacity:0;transform:translateY(12px);}  to{opacity:1;transform:translateY(0);} }
    .rp-anim  { animation: rpFadeUp 0.4s ease both; }
    .rp-d1 { animation-delay:.04s } .rp-d2 { animation-delay:.08s }
    .rp-d3 { animation-delay:.12s } .rp-d4 { animation-delay:.16s }

    /* ── Responsive ── */
    @media(max-width:768px) { .rp-summary-grid{grid-template-columns:1fr;} .rp-form-row{grid-template-columns:1fr;} }
    @media(max-width:560px) { .rp-header{flex-direction:column; align-items:flex-start;} }
</style>

<div class="rp-wrap" style="padding:0 24px 40px; max-width:1400px; margin:0 auto;">

    {{-- ── Page Header ── --}}
    <div class="rp-header rp-anim rp-d1">
        <div class="rp-header-left">
            <h1>Record & Payment Management</h1>
            <p>Central hub for issued bills and payment tracking</p>
        </div>
        <div class="rp-header-right">
            @php $paymentCount = isset($total) ? $total : 0; @endphp
            <div class="rp-count-badge">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                {{ $paymentCount }} Transactions
            </div>
            <button type="button" onclick="openRecordModal()" class="rp-btn rp-btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Record Payment
            </button>
        </div>
    </div>

    {{-- ── Summary Cards ── --}}
    <div class="rp-summary-grid rp-anim rp-d2">
        {{-- Total Revenue --}}
        <div class="rp-summary-card">
            <div class="rp-summary-card-accent" style="background:linear-gradient(180deg,#10b981,#059669);"></div>
            <div style="padding-left:8px;">
                <div class="rp-summary-label">Total Revenue Received</div>
                <div class="rp-summary-value">
                    <span class="conf-wrap">
                        <span class="conf-val blurred">₱{{ number_format($totalReceived ?? 0, 2) }}</span>
                        <button class="conf-unlock" onclick="openPwdModal(event)">🔒 Unlock</button>
                    </span>
                </div>
                <div class="rp-summary-sub">From crane and truck rental services</div>
            </div>
            <div class="rp-summary-icon" style="background:#dcfce7;">
                <svg width="22" height="22" fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        {{-- Collection Rate --}}
        <div class="rp-summary-card">
            <div class="rp-summary-card-accent" style="background:linear-gradient(180deg,#3b82f6,#1d4ed8);"></div>
            <div style="padding-left:8px;">
                <div class="rp-summary-label">Payment Collection Rate</div>
                <div class="rp-summary-value">{{ $collectionRate ?? 0 }}%</div>
                <div class="rp-summary-sub">Of issued bills collected</div>
            </div>
            <div class="rp-summary-icon" style="background:#dbeafe;">
                <svg width="22" height="22" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
    </div>

    {{-- ── Filter Bar ── --}}
    <div class="rp-filter-bar rp-anim rp-d3">
        <form id="filterForm" method="GET" style="display:contents;">
            <div class="rp-filter-search">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by client, invoice ID…"
                       class="rp-input rp-search-input"
                       onkeyup="applyFilters()">
            </div>
            <div style="flex-shrink:0;">
                <select name="status" class="rp-input rp-select" style="width:160px;" onchange="applyFilters()">
                    <option value="">All Status</option>
                    <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div style="flex-shrink:0; display:flex; align-items:center; gap:8px;">
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       class="rp-input" style="width:150px;" onchange="applyFilters()">
                <span style="color:#94a3b8; font-size:12px;">to</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                       class="rp-input" style="width:150px;" onchange="applyFilters()">
            </div>
        </form>
    </div>

    {{-- ── Payments Table ── --}}
    <div class="rp-card rp-anim rp-d4">
        <div class="rp-card-header">
            <h2>
                <svg width="17" height="17" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Issued Bills & Payment Status
            </h2>
            <p>All invoices sent from Billing & Invoicing Module with payment status</p>
        </div>

        <div class="rp-table-wrap">
            <table class="rp-table">
                <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Client</th>
                        <th>Equipment</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Reference No.</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td><span class="rp-inv-id">{{ $payment->invoice_uid ?? 'INV-' . str_pad($payment->invoice_id, 3, '0', STR_PAD_LEFT) }}</span></td>

                        <td><span class="rp-client">{{ $payment->client_name }}</span></td>

                        <td>
                            @if($payment->equipment_type)
                                @php
                                    $equipmentDisplay = [
                                        'tower_crane'          => 'Tower Crane',
                                        'mobile_crane'         => 'Mobile Crane',
                                        'rough_terrain_crane'  => 'Rough Terrain Crane',
                                        'crawler_crane'        => 'Crawler Crane',
                                        'dump_truck'           => 'Dump Truck',
                                        'concrete_mixer'       => 'Concrete Mixer',
                                        'flatbed_truck'        => 'Flatbed Truck',
                                        'tanker_truck'         => 'Tanker Truck'
                                    ];
                                @endphp
                                <span style="font-size:13px; color:#475569;">{{ $equipmentDisplay[$payment->equipment_type] ?? ucfirst(str_replace('_', ' ', $payment->equipment_type)) }}</span>
                            @else
                                <span style="color:#cbd5e1;">N/A</span>
                            @endif
                        </td>

                        <td>
                            <div class="conf-wrap">
                                <span class="conf-val rp-amount blurred">
                                    @if($payment->payment_status === null)
                                        ₱{{ number_format($payment->total_amount, 2) }}
                                    @else
                                        ₱{{ number_format($payment->amount_paid, 2) }}
                                    @endif
                                </span>
                                <button class="conf-unlock" onclick="openPwdModal(event)">🔒 Unlock</button>
                            </div>
                        </td>

                        <td>
                            @if($payment->payment_status === null)
                                <span class="rp-method rp-method-none">Not paid yet</span>
                            @elseif($payment->payment_method == 'bank')
                                <span class="rp-method rp-method-bank">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    Bank Transfer
                                </span>
                            @elseif($payment->payment_method == 'check')
                                <span class="rp-method rp-method-check">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Check
                                </span>
                            @elseif($payment->payment_method == 'gcash')
                                <span class="rp-method rp-method-gcash">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    GCash
                                </span>
                            @elseif($payment->payment_method == 'cash')
                                <span class="rp-method rp-method-cash">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Cash
                                </span>
                            @else
                                <span class="rp-method rp-method-none">Not paid yet</span>
                            @endif
                        </td>

                        <td><span class="rp-ref">{{ $payment->reference_number ?? '—' }}</span></td>

                        <td style="font-size:12.5px; color:#64748b;">
                            @if($payment->payment_date)
                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>

                        <td>
                            @if($payment->payment_status === null)
                                <span class="rp-pill pill-pending">Pending</span>
                            @else
                                <span class="rp-pill pill-complete">Completed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="rp-empty">
                                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                <h3>No issued bills yet</h3>
                                <p>Issued bills will be automatically synced from Billing & Invoicing Module</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="rp-pagination">
            <div class="rp-pagination-info">
                <span>Rows per page:</span>
                <select id="itemsPerPage" class="rp-per-page-select" onchange="changeItemsPerPage()">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span style="color:#94a3b8;">
                    {{ ($page - 1) * $perPage + 1 }}–{{ min($page * $perPage, $total) }} of {{ $total }} records
                </span>
            </div>
            <div class="rp-page-btns">
                <button class="rp-page-btn" onclick="goToPage(1)" {{ $page <= 1 ? 'disabled' : '' }} title="First page">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7M18 19l-7-7 7-7"/></svg>
                </button>
                <button class="rp-page-btn" onclick="goToPage({{ $page - 1 }})" {{ $page <= 1 ? 'disabled' : '' }} title="Previous">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <span style="padding:0 10px; font-size:13px; color:#64748b; font-weight:500;">{{ $page }} / {{ ceil($total / $perPage) }}</span>
                <button class="rp-page-btn" onclick="goToPage({{ $page + 1 }})" {{ $page * $perPage >= $total ? 'disabled' : '' }} title="Next">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
                <button class="rp-page-btn" onclick="goToPage({{ ceil($total / $perPage) }})" {{ $page * $perPage >= $total ? 'disabled' : '' }} title="Last page">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M6 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>

</div>

{{-- ════════════ MODALS ════════════ --}}

{{-- Record Payment Modal --}}
<div class="rp-modal-overlay" id="recordModal">
    <div class="rp-modal-box">
        <div class="rp-modal-head" style="background:linear-gradient(135deg,#1e40af,#4338ca);">
            <div>
                <h3>Record Client Payment</h3>
                <p>Link payment to an issued invoice</p>
            </div>
            <button class="rp-modal-close" onclick="closeRecordModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="rp-modal-body">
            <form action="{{ route('record.store') }}" method="POST" id="recordForm">
                @csrf

                <label class="rp-form-label">Select Invoice</label>
                <div class="rp-form-select-wrap">
                    <select name="invoice_id" required class="rp-form-select" id="invoiceSelect">
                        <option value="">Choose an unpaid invoice…</option>
                        @foreach(($unpaidInvoices ?? collect()) as $invoice)
                            <option value="{{ $invoice->id }}" data-amount="{{ $invoice->total_amount }}">
                                {{ $invoice->invoice_uid ?? 'INV-' . str_pad($invoice->id, 3, '0', STR_PAD_LEFT) }}
                                — {{ $invoice->client_name }}
                                (₱{{ number_format($invoice->total_amount, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="rp-form-row">
                    <div>
                        <label class="rp-form-label">Payment Mode</label>
                        <div class="rp-form-select-wrap">
                            <select name="payment_mode" required class="rp-form-select">
                                <option value="">Select method</option>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="gcash">GCash</option>
                                <option value="check">Check</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="rp-form-label">Amount</label>
                        <input type="number" name="amount_paid" step="0.01" min="0" readonly
                               id="paymentAmount" placeholder="Auto-filled"
                               class="rp-form-input readonly">
                    </div>
                </div>

                <label class="rp-form-label">Reference Number</label>
                <input type="text" name="reference_number" required
                       placeholder="OR #, Check #, or Transaction ID"
                       class="rp-form-input">
            </form>
        </div>
        <div class="rp-modal-footer">
            <button type="button" onclick="closeRecordModal()" class="rp-btn rp-btn-ghost">Cancel</button>
            <button type="submit" form="recordForm" class="rp-btn rp-btn-success">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Record Payment
            </button>
        </div>
    </div>
</div>

{{-- Password Modal --}}
<div class="rp-modal-overlay" id="pwdModal">
    <div class="rp-modal-box rp-modal-box-sm">
        <div class="rp-modal-body">
            <div class="rp-modal-icon-ring">
                <svg width="24" height="24" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div class="rp-modal-title">Security Verification</div>
            <div class="rp-modal-desc">Enter your administrator password to reveal confidential payment amounts.</div>
            <input type="password" id="pwdInput" class="rp-pwd-input" placeholder="Enter password" autocomplete="off">
            <div class="rp-modal-error" id="pwdError">Incorrect password. Please try again.</div>
            <div class="rp-modal-actions">
                <button class="rp-btn-verify" onclick="verifyPwd()">Verify Access</button>
                <button class="rp-btn-cancel" onclick="closePwdModal()">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
// ── Password ──
const CORRECT_PWD = 'admin123';
function openPwdModal(e) { e.preventDefault(); e.stopPropagation(); showPwdModal(); }
function showPwdModal() {
    document.getElementById('pwdModal').classList.add('open');
    document.getElementById('pwdError').classList.remove('show');
    document.getElementById('pwdInput').value = '';
    setTimeout(() => document.getElementById('pwdInput').focus(), 50);
}
function closePwdModal() { document.getElementById('pwdModal').classList.remove('open'); }
document.getElementById('pwdModal').addEventListener('click', e => { if(e.target===document.getElementById('pwdModal')) closePwdModal(); });
document.getElementById('pwdInput').addEventListener('keydown', e => { if(e.key==='Enter') verifyPwd(); });
function verifyPwd() {
    if(document.getElementById('pwdInput').value === CORRECT_PWD) {
        closePwdModal();
        document.querySelectorAll('.conf-val').forEach(el => el.classList.remove('blurred'));
        document.querySelectorAll('.conf-unlock').forEach(el => el.classList.add('hidden'));
    } else {
        document.getElementById('pwdError').classList.add('show');
        document.getElementById('pwdInput').value = '';
        document.getElementById('pwdInput').focus();
    }
}

// ── Record Payment Modal ──
function openRecordModal()  { document.getElementById('recordModal').classList.add('open'); }
function closeRecordModal() { document.getElementById('recordModal').classList.remove('open'); }
document.getElementById('recordModal').addEventListener('click', e => { if(e.target===document.getElementById('recordModal')) closeRecordModal(); });

// Auto-fill amount from invoice selection
document.getElementById('invoiceSelect').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    document.getElementById('paymentAmount').value = opt.getAttribute('data-amount') || '';
});

// ── Filters ──
function applyFilters() { document.getElementById('filterForm').submit(); }

// ── Pagination ──
function goToPage(page) {
    const url = new URL(window.location);
    url.searchParams.set('page', page);
    window.location.href = url.toString();
}
function changeItemsPerPage() {
    const url = new URL(window.location);
    url.searchParams.set('page', 1);
    url.searchParams.set('per_page', document.getElementById('itemsPerPage').value);
    window.location.href = url.toString();
}
</script>

@endsection