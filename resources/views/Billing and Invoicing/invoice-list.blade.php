@extends('layouts.app')
@section('content')

{{-- ════════════════════════════════════════════
    BILLING & INVOICING — REDESIGNED CONTENT ONLY
    Fonts, styles, and layout redesigned.
    All Laravel/Blade directives preserved exactly.
    FIX: Added ?? 0 / ?? [] fallbacks throughout to
         prevent "Undefined array key" errors.
════════════════════════════════════════════ --}}

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
    /* ── Reset & Base ── */
    .bi-wrap * { box-sizing: border-box; }
    .bi-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; }

    /* ── Alerts ── */
    .bi-alert { display:flex; align-items:center; gap:10px; padding:14px 18px; border-radius:10px; margin-bottom:20px; font-size:13.5px; font-weight:500; }
    .bi-alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
    .bi-alert-error   { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }
    .bi-alert svg { flex-shrink:0; }

    /* ── Page Header ── */
    .bi-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px; }
    .bi-header-left h1 { font-family:'Outfit',sans-serif; font-size:23px; font-weight:700; color:#0f172a; letter-spacing:-0.02em; }
    .bi-header-left p  { font-size:13px; color:#94a3b8; margin-top:3px; }
    .bi-header-right   { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }

    .bi-count-badge {
        display:inline-flex; align-items:center; gap:6px;
        padding:6px 14px; background:#eff6ff; border:1px solid #bfdbfe;
        border-radius:20px; color:#1d4ed8; font-size:12.5px; font-weight:600;
    }

    .bi-btn {
        display:inline-flex; align-items:center; gap:7px; padding:9px 18px;
        border:none; border-radius:9px; font-family:'DM Sans',sans-serif;
        font-size:13px; font-weight:600; cursor:pointer; transition:all 0.18s; white-space:nowrap;
    }
    .bi-btn-primary { background:#1e40af; color:#fff; }
    .bi-btn-primary:hover { background:#1d3a9e; transform:translateY(-1px); box-shadow:0 4px 12px rgba(30,64,175,0.3); }
    .bi-btn-purple { background:#7c3aed; color:#fff; }
    .bi-btn-purple:hover { background:#6d28d9; transform:translateY(-1px); box-shadow:0 4px 12px rgba(124,58,237,0.3); }
    .bi-btn-ghost { background:#f1f5f9; color:#475569; }
    .bi-btn-ghost:hover { background:#e2e8f0; }
    .bi-btn-success { background:#059669; color:#fff; }
    .bi-btn-success:hover { background:#047857; }

    /* ── Section Card ── */
    .bi-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; margin-bottom:22px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
    .bi-card-header { padding:18px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
    .bi-card-header-left h2 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
    .bi-card-header-left p  { font-size:12px; color:#94a3b8; margin-top:3px; }

    /* ── AI Analytics Grid ── */
    .bi-ai-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; padding:22px 24px; }
    .bi-ai-card {
        border:1px solid #e2e8f0; border-radius:12px; padding:18px; cursor:pointer;
        transition:all 0.2s; position:relative; overflow:hidden;
    }
    .bi-ai-card:hover { border-color:#c7d2e6; box-shadow:0 6px 20px rgba(0,0,0,0.08); transform:translateY(-2px); }
    .bi-ai-card::before {
        content:''; position:absolute; top:0; left:0; right:0; height:3px;
        opacity:0; transition:opacity 0.2s;
    }
    .bi-ai-card:hover::before { opacity:1; }
    .ai-green::before  { background:linear-gradient(90deg,#10b981,#34d399); }
    .ai-red::before    { background:linear-gradient(90deg,#ef4444,#f87171); }
    .ai-blue::before   { background:linear-gradient(90deg,#3b82f6,#60a5fa); }
    .ai-purple::before { background:linear-gradient(90deg,#8b5cf6,#a78bfa); }

    .bi-ai-icon { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-bottom:12px; }
    .bi-ai-title { font-size:13px; font-weight:600; color:#1e293b; margin-bottom:8px; }
    .bi-ai-main  { font-family:'Outfit',sans-serif; font-size:18px; font-weight:700; line-height:1.2; margin-bottom:3px; }
    .bi-ai-sub   { font-size:11.5px; color:#94a3b8; }

    /* ── Risk Table (inside AI card) ── */
    .bi-risk-table-wrap { padding:0 24px 22px; }
    .bi-risk-label { font-size:12px; font-weight:700; color:#94a3b8; letter-spacing:0.06em; text-transform:uppercase; margin-bottom:12px; display:flex; align-items:center; gap:7px; }
    .bi-risk-label span { display:inline-block; width:7px; height:7px; background:#ef4444; border-radius:50%; }

    .bi-risk-table { width:100%; border-collapse:collapse; font-size:13px; }
    .bi-risk-table thead th { padding:9px 14px; text-align:left; font-size:11px; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:#94a3b8; background:#f8fafc; border-bottom:1px solid #f1f5f9; }
    .bi-risk-table thead th:first-child { border-radius:8px 0 0 0; }
    .bi-risk-table thead th:last-child  { border-radius:0 8px 0 0; }
    .bi-risk-table tbody tr { border-bottom:1px solid #f8fafc; transition:background 0.15s; }
    .bi-risk-table tbody tr:hover { background:#f8fafc; }
    .bi-risk-table tbody tr:last-child { border-bottom:none; }
    .bi-risk-table tbody td { padding:10px 14px; color:#334155; }
    .bi-rate-bad  { font-weight:700; color:#dc2626; }
    .bi-send-btn  { color:#3b82f6; font-weight:600; font-size:12.5px; background:none; border:none; cursor:pointer; padding:3px 0; }
    .bi-send-btn:hover { text-decoration:underline; }

    /* ── Invoices Table Section ── */
    .bi-table-toolbar { padding:14px 24px; background:#f8fafc; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
    .bi-search-wrap { position:relative; }
    .bi-search-wrap svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; }
    .bi-search { padding:8px 12px 8px 36px; border:1.5px solid #e2e8f0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; color:#1e293b; background:#fff; outline:none; transition:border-color 0.18s, box-shadow 0.18s; width:280px; }
    .bi-search:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,0.1); }
    .bi-search::placeholder { color:#cbd5e1; }

    .bi-table-wrap { overflow-x:auto; }
    .bi-table { width:100%; border-collapse:collapse; font-size:13px; }
    .bi-table thead th {
        padding:11px 16px; text-align:left; font-size:11px; font-weight:600;
        letter-spacing:0.06em; text-transform:uppercase; color:#94a3b8;
        background:#f8fafc; border-bottom:1px solid #f1f5f9; white-space:nowrap;
    }
    .bi-table tbody tr { border-bottom:1px solid #f8fafc; transition:background 0.15s; }
    .bi-table tbody tr:hover { background:#f8fafc; }
    .bi-table tbody tr:last-child { border-bottom:none; }
    .bi-table tbody td { padding:12px 16px; color:#334155; vertical-align:middle; }

    .bi-table-checkbox { width:16px; height:16px; accent-color:#3b82f6; cursor:pointer; border-radius:4px; }

    .bi-ref { font-family:'Outfit',sans-serif; font-weight:600; color:#0f172a; font-size:13px; }
    .bi-client { font-weight:500; color:#1e293b; }
    .bi-equip-name { font-weight:500; color:#1e293b; }
    .bi-equip-id   { font-size:11px; color:#94a3b8; margin-top:2px; }
    .bi-period { font-size:12.5px; color:#475569; line-height:1.5; }
    .bi-amount { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; }

    /* Status Pills */
    .bi-pill { display:inline-flex; align-items:center; padding:3px 11px; border-radius:20px; font-size:11.5px; font-weight:700; white-space:nowrap; }
    .pill-issued  { background:#fef3c7; color:#b45309; }
    .pill-paid    { background:#dcfce7; color:#15803d; }
    .pill-overdue { background:#fee2e2; color:#dc2626; }
    .pill-default { background:#f1f5f9; color:#475569; }
    .pill-review  { background:#fee2e2; color:#dc2626; }
    .pill-ok      { background:#dcfce7; color:#15803d; }

    /* Action icons */
    .bi-action-group { display:flex; align-items:center; gap:6px; }
    .bi-icon-btn {
        width:32px; height:32px; display:flex; align-items:center; justify-content:center;
        border-radius:8px; border:1px solid #e2e8f0; background:#fff;
        cursor:pointer; transition:all 0.18s; color:#64748b; text-decoration:none;
    }
    .bi-icon-btn:hover { border-color:#3b82f6; color:#3b82f6; background:#eff6ff; }
    .bi-icon-btn.green:hover { border-color:#10b981; color:#10b981; background:#f0fdf4; }

    /* Empty state */
    .bi-empty { padding:56px 24px; text-align:center; }
    .bi-empty svg { margin:0 auto 14px; color:#cbd5e1; }
    .bi-empty h3 { font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; color:#334155; margin-bottom:5px; }
    .bi-empty p  { font-size:13px; color:#94a3b8; }

    /* Confidential blur */
    .conf-wrap { position:relative; display:inline-flex; align-items:center; }
    .conf-val   { transition:filter 0.3s; display:inline-block; }
    .conf-val.blurred { filter:blur(8px); user-select:none; pointer-events:none; }
    .conf-unlock {
        position:absolute; left:50%; top:50%; transform:translate(-50%,-50%);
        background:#0f172a; color:#fbbf24; border:none; padding:3px 9px;
        border-radius:6px; font-family:'DM Sans',sans-serif; font-size:11px;
        font-weight:700; cursor:pointer; white-space:nowrap;
        box-shadow:0 2px 8px rgba(0,0,0,0.3); display:flex; align-items:center; gap:4px;
    }
    .conf-unlock.hidden { display:none; }

    /* ── Modals ── */
    .bi-modal-overlay {
        position:fixed; inset:0; background:rgba(15,23,42,0.6); backdrop-filter:blur(4px);
        z-index:999; display:none; align-items:center; justify-content:center; padding:16px;
    }
    .bi-modal-overlay.open { display:flex; }
    .bi-modal-box {
        background:#fff; border-radius:16px; width:100%; max-width:480px;
        box-shadow:0 30px 80px rgba(0,0,0,0.2); animation:biModalIn 0.25s ease; overflow:hidden;
    }
    .bi-modal-box-lg { max-width:860px; }
    @keyframes biModalIn {
        from { transform:translateY(12px) scale(0.97); opacity:0; }
        to   { transform:translateY(0) scale(1); opacity:1; }
    }
    .bi-modal-head {
        padding:18px 24px; display:flex; align-items:center; justify-content:space-between;
    }
    .bi-modal-head h3 { font-family:'Outfit',sans-serif; font-size:17px; font-weight:700; color:#fff; }
    .bi-modal-head p  { font-size:12px; color:rgba(255,255,255,0.7); margin-top:2px; }
    .bi-modal-close { color:rgba(255,255,255,0.8); background:none; border:none; cursor:pointer; padding:4px; border-radius:6px; transition:background 0.15s; }
    .bi-modal-close:hover { background:rgba(255,255,255,0.15); color:#fff; }
    .bi-modal-body { padding:24px; overflow-y:auto; max-height:72vh; }

    .bi-modal-icon-ring { width:52px; height:52px; border-radius:13px; display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
    .bi-modal-title { font-family:'Outfit',sans-serif; font-size:18px; font-weight:700; color:#0f172a; margin-bottom:5px; }
    .bi-modal-desc  { font-size:13.5px; color:#64748b; margin-bottom:20px; line-height:1.5; }

    .bi-form-label { display:block; font-size:11.5px; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; color:#64748b; margin-bottom:6px; }
    .bi-form-input, .bi-form-select {
        width:100%; height:42px; padding:0 13px; border:1.5px solid #e2e8f0;
        border-radius:9px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1e293b;
        background:#f8fafc; outline:none; transition:border-color 0.18s, box-shadow 0.18s; margin-bottom:16px;
    }
    .bi-form-input:focus, .bi-form-select:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,0.1); background:#fff; }
    .bi-form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

    .bi-preview-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:18px; margin-bottom:18px; }
    .bi-preview-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:14px; }
    .bi-preview-label { font-size:11px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:3px; }
    .bi-preview-val   { font-size:13.5px; font-weight:500; color:#1e293b; }
    .bi-preview-sub   { font-size:12px; color:#64748b; }
    .bi-totals { border-top:1px solid #e2e8f0; padding-top:12px; margin-top:2px; }
    .bi-total-row { display:flex; justify-content:space-between; font-size:13px; color:#475569; margin-bottom:6px; }
    .bi-total-final { display:flex; justify-content:space-between; padding-top:10px; border-top:1px solid #e2e8f0; }
    .bi-total-final span:first-child { font-family:'Outfit',sans-serif; font-size:15px; font-weight:700; color:#0f172a; }
    .bi-total-final span:last-child  { font-family:'Outfit',sans-serif; font-size:18px; font-weight:800; color:#059669; }

    .bi-modal-footer { display:flex; justify-content:flex-end; gap:10px; padding:16px 24px; border-top:1px solid #f1f5f9; background:#f8fafc; }

    .bi-modal-error { font-size:12.5px; color:#dc2626; display:none; margin-bottom:10px; }
    .bi-modal-error.show { display:block; }
    .bi-pwd-input {
        width:100%; height:42px; padding:0 13px; border:1.5px solid #e2e8f0; border-radius:9px;
        font-family:'DM Sans',sans-serif; font-size:14px; color:#1e293b; background:#f8fafc;
        outline:none; transition:border-color 0.18s, box-shadow 0.18s; margin-bottom:10px;
    }
    .bi-pwd-input:focus { border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.12); background:#fff; }
    .bi-modal-actions { display:flex; gap:10px; margin-top:4px; }
    .bi-btn-verify { flex:1; height:42px; background:#0f172a; color:#fff; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:700; cursor:pointer; transition:background 0.18s; }
    .bi-btn-verify:hover { background:#1e293b; }
    .bi-btn-cancel-sm { height:42px; padding:0 18px; background:#f1f5f9; color:#64748b; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:600; cursor:pointer; }
    .bi-btn-cancel-sm:hover { background:#e2e8f0; }

    /* Forecast modals */
    .bi-section-title { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin-bottom:12px; }
    .bi-client-list { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    .bi-client-item { display:flex; justify-content:space-between; align-items:center; font-size:13px; padding:8px 0; border-bottom:1px solid #f1f5f9; }
    .bi-client-item:last-child { border-bottom:none; }
    .bi-client-name   { color:#334155; font-weight:500; }
    .bi-client-amount { font-weight:700; color:#0f172a; }

    .bi-eq-item { margin-bottom:10px; }
    .bi-eq-row  { display:flex; justify-content:space-between; font-size:12.5px; color:#64748b; margin-bottom:4px; }
    .bi-progress { width:100%; background:#f1f5f9; border-radius:20px; height:7px; overflow:hidden; }
    .bi-progress-bar { height:100%; border-radius:20px; transition:width 0.6s ease; }

    .bi-ai-note { background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:14px 16px; margin-top:16px; }
    .bi-ai-note h4 { font-size:13px; font-weight:700; color:#1d4ed8; margin-bottom:5px; }
    .bi-ai-note p  { font-size:12.5px; color:#1e40af; line-height:1.5; }

    .bi-late-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .bi-late-card { background:#fff5f5; border:1px solid #fecaca; border-radius:10px; padding:14px; }
    .bi-late-card h4 { font-weight:700; color:#dc2626; font-size:13px; margin-bottom:6px; }
    .bi-late-card p  { font-size:12.5px; color:#64748b; line-height:1.6; }

    .bi-eq-perf-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
    .bi-eq-perf-card { background:#eff6ff; border-radius:10px; padding:14px; }
    .bi-eq-perf-card h4 { font-weight:700; color:#1d4ed8; font-size:13px; margin-bottom:6px; }
    .bi-eq-perf-card p  { font-size:12px; color:#64748b; line-height:1.6; }

    .bi-eff-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .bi-eff-card { background:#f8fafc; border-radius:10px; padding:14px; }
    .bi-eff-card h4 { font-weight:700; color:#1e293b; font-size:13px; margin-bottom:4px; }
    .bi-eff-card p  { font-size:12px; color:#64748b; }

    /* ── Animations ── */
    @keyframes biFadeUp { from{opacity:0;transform:translateY(12px);}  to{opacity:1;transform:translateY(0);} }
    .bi-anim  { animation: biFadeUp 0.4s ease both; }
    .bi-d1 { animation-delay:.04s } .bi-d2 { animation-delay:.08s }
    .bi-d3 { animation-delay:.12s } .bi-d4 { animation-delay:.16s }
    .bi-d5 { animation-delay:.20s } .bi-d6 { animation-delay:.24s }

    /* ── Responsive ── */
    @media(max-width:1100px) { .bi-ai-grid{grid-template-columns:repeat(2,1fr);} }
    @media(max-width:700px)  { .bi-ai-grid{grid-template-columns:1fr;} .bi-form-row{grid-template-columns:1fr;} .bi-late-grid,.bi-eq-perf-grid,.bi-eff-grid{grid-template-columns:1fr;} }
</style>

<div class="bi-wrap" style="padding:0 24px 40px; max-width:1400px; margin:0 auto;">

    {{-- ── Session Alerts ── --}}
    @if(session('success'))
    <div class="bi-alert bi-alert-success bi-anim">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bi-alert bi-alert-error bi-anim">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Page Header ── --}}
    <div class="bi-header bi-anim bi-d1">
        <div class="bi-header-left">
            <h1>Billing & Invoicing</h1>
            <p>Auto-generated invoices with AI-powered intelligent billing</p>
        </div>
        <div class="bi-header-right">
            @php $invoiceCount = isset($invoices) ? $invoices->count() : 0; @endphp
            <div class="bi-count-badge">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                {{ $invoiceCount }} Total Invoices
            </div>
            <form action="{{ route('billing.invoices.scan') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="bi-btn bi-btn-purple">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    Scan for Duplicates
                </button>
            </form>
            <button type="button" onclick="openGenerateModal()" class="bi-btn bi-btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Generate Invoice
            </button>
        </div>
    </div>

    {{-- ── AI Analytics Card ── --}}
    <div class="bi-card bi-anim bi-d2">
        <div class="bi-card-header">
            <div class="bi-card-header-left">
                <h2>
                    <svg width="17" height="17" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    AI-Powered Billing Analytics
                </h2>
                <p>Real-time analysis of billing data with predictive insights</p>
            </div>
        </div>

        <div class="bi-ai-grid">
            {{-- Revenue Forecast --}}
            <div class="bi-ai-card ai-green" onclick="showRevenueBreakdown()">
                <div class="bi-ai-icon" style="background:#dcfce7;">
                    <svg width="18" height="18" fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <div class="bi-ai-title">Revenue Forecast</div>
                {{-- FIX: ?? 0 --}}
                <div class="bi-ai-main" style="color:#059669;">₱{{ number_format($aiAnalytics['revenue_forecast_30days'] ?? 0, 2) }}</div>
                <div class="bi-ai-sub">Next 30 days · Based on historical data</div>
            </div>

            {{-- Late Paying Clients --}}
            <div class="bi-ai-card ai-red" onclick="showLatePayingClients()">
                <div class="bi-ai-icon" style="background:#fee2e2;">
                    <svg width="18" height="18" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="bi-ai-title">Late Paying Clients</div>
                {{-- FIX: ?? [] --}}
                <div class="bi-ai-main" style="color:#dc2626;">{{ count($aiAnalytics['late_paying_clients'] ?? []) }} clients</div>
                {{-- FIX: ?? 0 --}}
                <div class="bi-ai-sub">Payment rate &lt; 80% · {{ $aiAnalytics['total_analyzed_invoices'] ?? 0 }} invoices analyzed</div>
            </div>

            {{-- Equipment Performance --}}
            <div class="bi-ai-card ai-blue" onclick="showEquipmentPerformance()">
                <div class="bi-ai-icon" style="background:#dbeafe;">
                    <svg width="18" height="18" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div class="bi-ai-title">Equipment Performance</div>
                <div class="bi-ai-main" style="color:#1d4ed8; font-size:15px;">
                    {{-- FIX: ?? [] --}}
                    @if(count($aiAnalytics['equipment_revenue_analysis'] ?? []) > 0)
                        {{-- FIX: ?? '' --}}
                        {{ ucfirst(str_replace('_', ' ', $aiAnalytics['equipment_revenue_analysis'][0]['equipment_type'] ?? '')) }}
                    @else N/A @endif
                </div>
                <div class="bi-ai-sub">Top revenue performer</div>
            </div>

            {{-- Billing Efficiency --}}
            <div class="bi-ai-card ai-purple" onclick="showBillingEfficiency()">
                <div class="bi-ai-icon" style="background:#ede9fe;">
                    <svg width="18" height="18" fill="none" stroke="#8b5cf6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="bi-ai-title">Billing Efficiency</div>
                {{-- FIX: ?? 0 --}}
                <div class="bi-ai-main" style="color:#7c3aed;">{{ $aiAnalytics['average_billing_cycle_days'] ?? 0 }} days</div>
                <div class="bi-ai-sub">Avg. collection time · Industry avg: 45 days</div>
            </div>
        </div>

        {{-- Risk Table --}}
        {{-- FIX: ?? [] --}}
        @if(count($aiAnalytics['late_paying_clients'] ?? []) > 0)
        <div class="bi-risk-table-wrap">
            <div class="bi-risk-label">
                <span></span>High-Risk Clients Requiring Follow-up
            </div>
            <table class="bi-risk-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Payment Rate</th>
                        <th>Total Invoices</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aiAnalytics['late_paying_clients'] as $client)
                    <tr>
                        {{-- FIX: ?? fallbacks on all client keys --}}
                        <td style="font-weight:500; color:#1e293b;">{{ $client['client'] ?? 'N/A' }}</td>
                        <td class="bi-rate-bad">{{ $client['payment_rate'] ?? 0 }}%</td>
                        <td style="color:#64748b;">{{ $client['total_invoices'] ?? 0 }}</td>
                        <td><button class="bi-send-btn" onclick="sendReminder('{{ $client['client'] ?? '' }}')">Send Reminder →</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- ── Invoices Table Card ── --}}
    <div class="bi-card bi-anim bi-d3">
        <div class="bi-card-header">
            <div class="bi-card-header-left">
                <h2>
                    <svg width="17" height="17" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Auto-Generated Invoices
                </h2>
                <p>Invoices automatically generated from completed job orders</p>
            </div>
            <button type="button" onclick="openBulkForwardModal()" class="bi-btn bi-btn-purple" id="bulkForwardBtn" style="display:none;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Forward Selected to Financials
            </button>
        </div>

        {{-- Search Toolbar --}}
        <div class="bi-table-toolbar">
            <div class="bi-search-wrap">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                <input type="text" class="bi-search" id="globalSearch" placeholder="Search by Ref #, Client, Equipment, or Amount…" onkeyup="globalSearch(this.value)">
            </div>
            <span style="font-size:12px; color:#94a3b8;">Showing all records</span>
        </div>

        <div class="bi-table-wrap">
            <form id="bulkForwardForm" method="POST" action="{{ route('billing.invoices.bulk-forward') }}">
                @csrf
                <input type="hidden" name="invoice_ids_json" id="selectedInvoiceIds">
            </form>

            <table class="bi-table" id="invoicesTable">
                <thead>
                    <tr>
                        <th style="width:40px;"><input type="checkbox" id="selectAll" class="bi-table-checkbox"></th>
                        <th>Ref #</th>
                        <th>Job Order</th>
                        <th>Client</th>
                        <th>Equipment</th>
                        <th>Period</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>AI Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $invoices = $invoices ?? collect(); @endphp
                    @forelse($invoices as $invoice)
                    <tr class="invoice-row"
                        data-client="{{ strtolower($invoice->client_name ?? '') }}"
                        data-equipment="{{ strtolower($invoice->equipment_type ?? '') }}"
                        data-status="{{ strtolower($invoice->status ?? '') }}"
                        data-ref="{{ strtolower($invoice->invoice_uid ?? '') }}"
                        data-amount="{{ str_replace(['₱', ','], '', number_format($invoice->total_amount ?? 0, 2)) }}"
                        data-date="{{ \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') }}">

                        <td>
                            @if(in_array(strtolower($invoice->status), ['issued', 'billed']))
                            <input type="checkbox" name="invoice_ids[]" value="{{ $invoice->id }}" class="invoice-checkbox bi-table-checkbox">
                            @endif
                        </td>

                        <td><span class="bi-ref">{{ $invoice->invoice_uid ?? 'N/A' }}</span></td>

                        <td style="color:#64748b; font-size:12.5px;">
                            @if($invoice->job_order_id ?? null)
                                JO-{{ str_pad($invoice->job_order_id, 4, '0', STR_PAD_LEFT) }}
                            @else N/A @endif
                        </td>

                        <td><span class="bi-client">{{ $invoice->client_name ?? 'Unknown Client' }}</span></td>

                        <td>
                            @if($invoice->equipment_type)
                            @php
                            $equipmentDisplay = [
                                'tower_crane' => 'Tower Crane','mobile_crane' => 'Mobile Crane',
                                'rough_terrain_crane' => 'Rough Terrain Crane','crawler_crane' => 'Crawler Crane',
                                'dump_truck' => 'Dump Truck','concrete_mixer' => 'Concrete Mixer',
                                'flatbed_truck' => 'Flatbed Truck','tanker_truck' => 'Tanker Truck'
                            ];
                            @endphp
                            <div class="bi-equip-name">{{ $equipmentDisplay[$invoice->equipment_type] ?? ucfirst(str_replace('_', ' ', $invoice->equipment_type)) }}</div>
                            @else <span style="color:#cbd5e1;">N/A</span> @endif
                            <div class="bi-equip-id">{{ $invoice->equipment_id ?? 'No ID' }}</div>
                        </td>

                        <td>
                            @if($invoice->billing_period_start && $invoice->billing_period_end)
                            <div class="bi-period">
                                {{ \Carbon\Carbon::parse($invoice->billing_period_start)->format('M d') }} –
                                {{ \Carbon\Carbon::parse($invoice->billing_period_end)->format('M d, Y') }}
                            </div>
                            @else <span style="color:#cbd5e1;">N/A</span> @endif
                        </td>

                        <td>
                            <div class="conf-wrap">
                                <span class="conf-val bi-amount blurred">₱{{ number_format($invoice->total_amount ?? 0, 2) }}</span>
                                <button class="conf-unlock" onclick="openPwdModal(event)">🔒 Unlock</button>
                            </div>
                        </td>

                        <td>
                            @php $status = $invoice->status ?? 'unknown'; @endphp
                            @if($status == 'billed' || $status == 'issued')
                                <span class="bi-pill pill-issued">Issued</span>
                            @elseif($status == 'paid')
                                <span class="bi-pill pill-paid">Paid</span>
                            @elseif($status == 'overdue')
                                <span class="bi-pill pill-overdue">Overdue</span>
                            @else
                                <span class="bi-pill pill-default">{{ ucfirst($status) }}</span>
                            @endif
                        </td>

                        <td>
                            @if($invoice->ai_duplicate_flag ?? false)
                                <span class="bi-pill pill-review">⚠ Review</span>
                            @else
                                <span class="bi-pill pill-ok">✓ Verified</span>
                            @endif
                        </td>

                        <td>
                            <div class="bi-action-group">
                                <a href="{{ route('billing.invoices.show', $invoice->id) }}" class="bi-icon-btn" title="View Invoice">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if(isset($invoice->id))
                                <a href="#" onclick="downloadProtectedPdf({{ $invoice->id }})" class="bi-icon-btn green" title="Download PDF">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="bi-empty">
                                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <h3>No invoices generated yet</h3>
                                <p>Invoices will be auto-generated when job orders are completed.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ════════════════ MODALS ════════════════ --}}

{{-- Generate Invoice Modal --}}
<div class="bi-modal-overlay" id="generateModal">
    <div class="bi-modal-box">
        <div class="bi-modal-head" style="background:linear-gradient(135deg,#1e40af,#4338ca);">
            <div>
                <h3>Generate Demo Invoice</h3>
                <p>Professional invoice for equipment rental</p>
            </div>
            <button class="bi-modal-close" onclick="closeGenerateModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="bi-modal-body">
            <form action="{{ route('billing.invoices.demo-store') }}" method="POST" id="generateForm">
                @csrf
                <label class="bi-form-label">Client Name</label>
                <input type="text" name="client_name" value="ABC Construction" class="bi-form-input" required>

                <label class="bi-form-label">Equipment Type</label>
                <select name="equipment_type" class="bi-form-select" required>
                    <option value="mobile_crane">Mobile Crane (50T)</option>
                    <option value="tower_crane">Tower Crane (20T)</option>
                    <option value="dump_truck">Dump Truck (10T)</option>
                    <option value="concrete_mixer">Concrete Mixer Truck</option>
                </select>

                <div class="bi-form-row">
                    <div>
                        <label class="bi-form-label">Hours Used</label>
                        <input type="number" name="hours_used" value="8" min="1" step="0.5" class="bi-form-input" required>
                    </div>
                    <div style="display:flex;flex-direction:column;justify-content:flex-end;padding-bottom:16px;">
                        <div style="font-size:12.5px;color:#64748b;line-height:1.8;">
                            Hourly Rate: <strong style="color:#1d4ed8;">₱2,500.00</strong><br>
                            Estimated: <strong style="color:#059669;">₱20,000.00</strong>
                        </div>
                    </div>
                </div>

                <div class="bi-preview-box">
                    <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:12px;">Invoice Preview</div>
                    <div class="bi-preview-grid">
                        <div>
                            <div class="bi-preview-label">Bill To</div>
                            <div class="bi-preview-val">ABC Construction</div>
                            <div class="bi-preview-sub">123 Construction Ave, Manila</div>
                        </div>
                        <div>
                            <div class="bi-preview-label">Equipment</div>
                            <div class="bi-preview-val">Mobile Crane (50T)</div>
                            <div class="bi-preview-sub">8 hrs · ₱2,500/hr</div>
                        </div>
                    </div>
                    <div class="bi-totals">
                        <div class="bi-total-row"><span>Subtotal</span><span>₱20,000.00</span></div>
                        <div class="bi-total-row"><span>VAT (12%)</span><span>₱2,400.00</span></div>
                        <div class="bi-total-final"><span>Total Amount</span><span>₱22,400.00</span></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="bi-modal-footer">
            <button type="button" onclick="closeGenerateModal()" class="bi-btn bi-btn-ghost">Cancel</button>
            <button type="submit" form="generateForm" class="bi-btn bi-btn-success">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Generate Invoice
            </button>
        </div>
    </div>
</div>

{{-- Password Modal --}}
<div class="bi-modal-overlay" id="pwdModal">
    <div class="bi-modal-box" style="max-width:420px;">
        <div class="bi-modal-body">
            <div class="bi-modal-icon-ring" style="background:#fef3c7;">
                <svg width="24" height="24" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div class="bi-modal-title">Security Verification</div>
            <div class="bi-modal-desc">Enter your administrator password to reveal all confidential invoice amounts.</div>
            <input type="password" id="pwdInput" class="bi-pwd-input" placeholder="Enter password" autocomplete="off">
            <div class="bi-modal-error" id="pwdError">Incorrect password. Please try again.</div>
            <div class="bi-modal-actions">
                <button class="bi-btn-verify" onclick="verifyPwd()">Verify Access</button>
                <button class="bi-btn-cancel-sm" onclick="closePwdModal()">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- Revenue Forecast Modal --}}
<div class="bi-modal-overlay" id="revenueBreakdownModal">
    <div class="bi-modal-box bi-modal-box-lg">
        <div class="bi-modal-head" style="background:linear-gradient(135deg,#059669,#10b981);">
            <h3>Revenue Forecast Breakdown</h3>
            <button class="bi-modal-close" onclick="closeModal('revenueBreakdownModal')">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="bi-modal-body">
            <div class="bi-section-title">Top Contributing Clients</div>
            <div class="bi-client-list">
                @foreach($aiAnalytics['top_clients'] ?? [] as $client)
                <div class="bi-client-item">
                    {{-- FIX: ?? fallbacks on name, revenue, percent --}}
                    <span class="bi-client-name">{{ $client['name'] ?? 'N/A' }}</span>
                    <span class="bi-client-amount">₱{{ number_format($client['revenue'] ?? 0, 2) }} <span style="color:#94a3b8;font-weight:400;">({{ $client['percent'] ?? 0 }}%)</span></span>
                </div>
                @endforeach
            </div>
            <div class="bi-section-title">Equipment Revenue Share</div>
            @foreach($aiAnalytics['equipment_revenue_analysis'] ?? [] as $eq)
            {{-- FIX: store percent in variable with ?? 0 fallback --}}
            @php $eqPercent = $eq['percent'] ?? 0; @endphp
            <div class="bi-eq-item">
                <div class="bi-eq-row">
                    <span>{{ ucfirst(str_replace('_', ' ', $eq['equipment_type'] ?? '')) }}</span>
                    <span style="font-weight:600;">{{ $eqPercent }}%</span>
                </div>
                <div class="bi-progress"><div class="bi-progress-bar" style="width:{{ $eqPercent }}%; background:#10b981;"></div></div>
            </div>
            @endforeach
            <div class="bi-ai-note" style="margin-top:20px;">
                <h4>🤖 AI Forecast Logic</h4>
                <p>Revenue forecast is based on: (1) historical billing patterns (last 6 months), (2) confirmed upcoming job orders, (3) seasonal demand trends for crane & truck rental.</p>
            </div>
        </div>
    </div>
</div>

{{-- Late Paying Clients Modal --}}
<div class="bi-modal-overlay" id="latePayingClientsModal">
    <div class="bi-modal-box bi-modal-box-lg">
        <div class="bi-modal-head" style="background:linear-gradient(135deg,#dc2626,#ef4444);">
            <h3>Late Paying Clients Analysis</h3>
            <button class="bi-modal-close" onclick="closeModal('latePayingClientsModal')">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="bi-modal-body">
            <p style="font-size:13.5px;color:#64748b;margin-bottom:18px;">These clients have a payment rate below 80% — flagged by AI even if not yet overdue.</p>
            <div class="bi-late-grid">
                @foreach($aiAnalytics['late_paying_clients'] ?? [] as $client)
                <div class="bi-late-card">
                    {{-- FIX: ?? fallbacks on all keys --}}
                    <h4>{{ $client['client'] ?? 'N/A' }}</h4>
                    <p>Payment rate: <strong style="color:#dc2626;">{{ $client['payment_rate'] ?? 0 }}%</strong><br>Total invoices: {{ $client['total_invoices'] ?? 0 }}</p>
                    <button class="bi-send-btn" style="margin-top:8px;" onclick="sendReminder('{{ $client['client'] ?? '' }}')">Send Reminder →</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Equipment Performance Modal --}}
<div class="bi-modal-overlay" id="equipmentPerformanceModal">
    <div class="bi-modal-box bi-modal-box-lg">
        <div class="bi-modal-head" style="background:linear-gradient(135deg,#1d4ed8,#4338ca);">
            <h3>Equipment Performance Insights</h3>
            <button class="bi-modal-close" onclick="closeModal('equipmentPerformanceModal')">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="bi-modal-body">
            <div class="bi-eq-perf-grid">
                @foreach($aiAnalytics['equipment_revenue_analysis'] ?? [] as $eq)
                {{-- FIX: store percent in variable with ?? 0 fallback --}}
                @php $eqPercent = $eq['percent'] ?? 0; @endphp
                <div class="bi-eq-perf-card">
                    <h4>{{ ucfirst(str_replace('_', ' ', $eq['equipment_type'] ?? '')) }}</h4>
                    {{-- FIX: ?? 0 on revenue, $eqPercent on percent --}}
                    <p>Revenue: ₱{{ number_format($eq['revenue'] ?? 0, 2) }}<br>Share: {{ $eqPercent }}%</p>
                    <div class="bi-progress" style="margin-top:10px;"><div class="bi-progress-bar" style="width:{{ $eqPercent }}%; background:#3b82f6;"></div></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Billing Efficiency Modal --}}
<div class="bi-modal-overlay" id="billingEfficiencyModal">
    <div class="bi-modal-box bi-modal-box-lg">
        <div class="bi-modal-head" style="background:linear-gradient(135deg,#7c3aed,#6d28d9);">
            <h3>Billing Efficiency Report</h3>
            <button class="bi-modal-close" onclick="closeModal('billingEfficiencyModal')">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="bi-modal-body">
            {{-- FIX: store days and width in safe @php block --}}
            @php
                $cycDays  = $aiAnalytics['average_billing_cycle_days'] ?? 0;
                $effWidth = $cycDays > 0 ? min(100, ($cycDays / 45) * 100) : 0;
            @endphp
            <div class="bi-eff-grid">
                <div class="bi-eff-card">
                    <h4>Avg. Collection Time: {{ $cycDays }} days</h4>
                    <p style="margin-bottom:10px;">Industry average: 45 days</p>
                    <div class="bi-progress"><div class="bi-progress-bar" style="width:{{ $effWidth }}%; background:#8b5cf6;"></div></div>
                </div>
                <div class="bi-eff-card">
                    <h4>Top Performing Equipment</h4>
                    <p>
                        {{-- FIX: ?? [] and ?? '' --}}
                        @if(count($aiAnalytics['equipment_revenue_analysis'] ?? []) > 0)
                            {{ ucfirst(str_replace('_', ' ', $aiAnalytics['equipment_revenue_analysis'][0]['equipment_type'] ?? '')) }}
                        @else N/A @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ── Confidential / Password ──
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

// ── Generate Modal ──
function openGenerateModal()  { document.getElementById('generateModal').classList.add('open'); }
function closeGenerateModal() { document.getElementById('generateModal').classList.remove('open'); }
document.getElementById('generateModal').addEventListener('click', e => { if(e.target===document.getElementById('generateModal')) closeGenerateModal(); });

// ── Analytics Modals ──
function showRevenueBreakdown()   { document.getElementById('revenueBreakdownModal').classList.add('open'); }
function showLatePayingClients()  { document.getElementById('latePayingClientsModal').classList.add('open'); }
function showEquipmentPerformance(){ document.getElementById('equipmentPerformanceModal').classList.add('open'); }
function showBillingEfficiency()  { document.getElementById('billingEfficiencyModal').classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
['revenueBreakdownModal','latePayingClientsModal','equipmentPerformanceModal','billingEfficiencyModal'].forEach(id => {
    document.getElementById(id).addEventListener('click', e => { if(e.target===document.getElementById(id)) closeModal(id); });
});

// ── Search ──
function globalSearch(val) {
    const v = val.toLowerCase();
    document.querySelectorAll('.invoice-row').forEach(row => {
        const match = ['data-ref','data-client','data-equipment','data-amount'].some(attr => (row.getAttribute(attr)||'').includes(v));
        row.style.display = match ? '' : 'none';
    });
}

// ── Checkboxes ──
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.invoice-checkbox').forEach(cb => cb.checked = this.checked);
    updateBulkBtn();
});
document.addEventListener('change', e => { if(e.target.classList.contains('invoice-checkbox')) updateBulkBtn(); });
function updateBulkBtn() {
    const n = document.querySelectorAll('.invoice-checkbox:checked').length;
    document.getElementById('bulkForwardBtn').style.display = n > 0 ? 'inline-flex' : 'none';
}

// ── Bulk Forward ──
function openBulkForwardModal() {
    const ids = Array.from(document.querySelectorAll('.invoice-checkbox:checked')).map(c => c.value);
    if(!ids.length) { alert('Please select at least one invoice.'); return; }
    if(confirm(`Forward ${ids.length} invoice(s) to Financials System?`)) {
        document.getElementById('selectedInvoiceIds').value = JSON.stringify(ids);
        document.getElementById('bulkForwardForm').submit();
    }
}

// ── Download PDF ──
function downloadProtectedPdf(id) {
    alert('🔒 PDF Password: [client_name][invoice_id]\nExample: abcconstruction60\n\nClick OK to download.');
    window.location.href = '{{ route("billing.invoices.pdf", ":id") }}'.replace(':id', id);
}

// ── Send Reminder ──
function sendReminder(name) { alert(`✓ Reminder sent to "${name}"!`); }
</script>

@endsection