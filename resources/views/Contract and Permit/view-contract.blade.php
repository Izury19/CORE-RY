@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.cv-wrap * { box-sizing: border-box; }
.cv-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.cv-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.cv-back { width:36px; height:36px; border-radius:9px; border:1.5px solid #e2e8f0; background:#f8fafc; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b; text-decoration:none; transition:all .18s; flex-shrink:0; }
.cv-back:hover { border-color:#4f46e5; color:#4f46e5; background:#eef2ff; }
.cv-header-text h1 { font-family:'Outfit',sans-serif; font-size:20px; font-weight:800; color:#0f172a; letter-spacing:-0.02em; margin:0; }
.cv-header-text p  { font-size:13px; color:#94a3b8; margin:2px 0 0; }
.cv-header-right { margin-left:auto; display:flex; gap:10px; }

/* Buttons */
.cv-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all .18s; text-decoration:none; }
.cv-btn-primary { background:#4f46e5; color:#fff; }
.cv-btn-primary:hover { background:#4338ca; transform:translateY(-1px); box-shadow:0 4px 12px rgba(79,70,229,.3); }
.cv-btn-yellow { background:#f59e0b; color:#fff; }
.cv-btn-yellow:hover { background:#d97706; transform:translateY(-1px); box-shadow:0 4px 12px rgba(245,158,11,.3); }
.cv-btn-ghost  { background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; }
.cv-btn-ghost:hover { background:#e2e8f0; }

/* Body */
.cv-body { max-width:900px; margin:0 auto; padding:28px 24px 60px; }

/* Status banner */
.cv-status-banner { border-radius:12px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; gap:12px; font-size:13.5px; font-weight:600; }
.sb-pending  { background:#fefce8; border:1px solid #fde68a; color:#92400e; }
.sb-approved { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; }
.sb-rejected { background:#fff1f2; border:1px solid #fecaca; color:#dc2626; }
.cv-status-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.si-pending  { background:#fef3c7; }
.si-approved { background:#dcfce7; }
.si-rejected { background:#fee2e2; }
.cv-status-text { flex:1; }
.cv-status-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; opacity:.7; margin-bottom:2px; }
.cv-status-val   { font-size:15px; font-weight:800; }

/* Document card */
.cv-doc { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:16px; }

/* Doc header strip */
.cv-doc-strip { background:linear-gradient(135deg,#4f46e5,#7c3aed); padding:24px 28px; display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; }
.cv-doc-strip-left { display:flex; align-items:center; gap:14px; }
.cv-doc-strip-icon { width:44px; height:44px; background:rgba(255,255,255,0.15); border-radius:11px; display:flex; align-items:center; justify-content:center; }
.cv-doc-strip-title { font-family:'Outfit',sans-serif; font-size:20px; font-weight:800; color:#fff; letter-spacing:-0.02em; }
.cv-doc-strip-sub   { font-size:12px; color:rgba(255,255,255,.65); margin-top:2px; }
.cv-doc-strip-right { text-align:right; }
.cv-doc-strip-type  { display:inline-flex; padding:3px 12px; border-radius:20px; font-size:12px; font-weight:700; background:rgba(255,255,255,0.18); color:#fff; margin-bottom:6px; }
.cv-doc-strip-date  { font-size:12px; color:rgba(255,255,255,.6); }

/* Parties strip */
.cv-parties { display:grid; grid-template-columns:1fr 1px 1fr; background:#f8fafc; border-bottom:1px solid #f1f5f9; }
.cv-party { padding:18px 24px; }
.cv-party-divider { background:#f1f5f9; }
.cv-party-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; margin-bottom:7px; display:flex; align-items:center; gap:5px; }
.cv-party-name  { font-family:'Outfit',sans-serif; font-size:16px; font-weight:800; color:#0f172a; margin-bottom:4px; }
.cv-party-sub   { font-size:12px; color:#64748b; line-height:1.6; }

/* Details grid */
.cv-details { padding:24px 28px; }
.cv-details-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:24px; }
.cv-detail-item {}
.cv-detail-label { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; margin-bottom:5px; }
.cv-detail-value { font-size:14px; font-weight:600; color:#1e293b; line-height:1.4; }
.cv-detail-value.mono { font-family:'Outfit',sans-serif; }
.cv-detail-value.amount { font-family:'Outfit',sans-serif; font-size:18px; font-weight:800; color:#0f172a; }

/* Divider */
.cv-rule { border:none; border-top:1px solid #f1f5f9; margin:0 0 22px; }

/* Scope box */
.cv-scope { background:#f8fafc; border:1px solid #f1f5f9; border-radius:11px; padding:16px 18px; }
.cv-scope-label { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; margin-bottom:10px; }
.cv-scope-text  { font-size:13.5px; color:#334155; line-height:1.7; white-space:pre-wrap; }

/* Footer actions */
.cv-footer { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:16px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.cv-footer-meta { font-size:12px; color:#94a3b8; display:flex; align-items:center; gap:6px; }
.cv-footer-actions { display:flex; gap:10px; }

/* Animations */
@keyframes cvFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.cv-a { animation:cvFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s} .d4{animation-delay:.15s}

@media(max-width:700px) {
    .cv-parties { grid-template-columns:1fr; }
    .cv-party-divider { display:none; }
    .cv-details-grid { grid-template-columns:1fr 1fr; }
    .cv-body { padding:18px 14px 40px; }
    .cv-header { padding:14px 18px; }
    .cv-doc-strip { padding:18px 20px; border-radius:12px 12px 0 0; }
    .cv-footer { flex-direction:column; align-items:flex-start; }
    .cv-footer-actions { width:100%; }
    .cv-btn { flex:1; justify-content:center; }
}
@media(max-width:500px) { .cv-details-grid { grid-template-columns:1fr; } }
</style>

<div class="cv-wrap">

    {{-- Header --}}
    <div class="cv-header">
        <a href="{{ route('contract.management') }}" class="cv-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div class="cv-header-text">
            <h1>Contract Details</h1>
            <p>{{ $contract->contract_number }}</p>
        </div>
    </div>

    <div class="cv-body">

        {{-- Status Banner --}}
        @php
            $s = $contract->status;
            $sbClass = $s === 'approved' ? 'sb-approved' : ($s === 'rejected' ? 'sb-rejected' : 'sb-pending');
            $siClass = $s === 'approved' ? 'si-approved' : ($s === 'rejected' ? 'si-rejected' : 'si-pending');
        @endphp
        <div class="cv-status-banner {{ $sbClass }} cv-a d1">
            <div class="cv-status-icon {{ $siClass }}">
                @if($s === 'approved')
                    <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @elseif($s === 'rejected')
                    <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @else
                    <svg width="18" height="18" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </div>
            <div class="cv-status-text">
                <div class="cv-status-label">Legal Status</div>
                <div class="cv-status-val">
                    @if($s === 'approved') ✅ Approved — Ready for execution
                    @elseif($s === 'rejected') ❌ Rejected — Contract did not pass legal review
                    @else ⏳ Pending Review — Awaiting legal approval
                    @endif
                </div>
            </div>
        </div>

        {{-- Contract Document Card --}}
        <div class="cv-doc cv-a d2">

            {{-- Indigo header strip --}}
            <div class="cv-doc-strip">
                <div class="cv-doc-strip-left">
                    <div class="cv-doc-strip-icon">
                        <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <div class="cv-doc-strip-title">{{ $contract->contract_number }}</div>
                        <div class="cv-doc-strip-sub">Cali Heavy Equipment Inc. · Contract Management</div>
                    </div>
                </div>
                <div class="cv-doc-strip-right">
                    <div class="cv-doc-strip-type">{{ ucfirst(str_replace('_',' ',$contract->contract_type)) }}</div>
                    <div class="cv-doc-strip-date">
                        {{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }}
                        &nbsp;→&nbsp;
                        {{ \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') }}
                    </div>
                </div>
            </div>

            {{-- Parties --}}
            <div class="cv-parties">
                <div class="cv-party">
                    <div class="cv-party-label">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Counterparty
                    </div>
                    <div class="cv-party-name">{{ $contract->company_name }}</div>
                    <div class="cv-party-sub">
                        @if($contract->client_email ?? false)📧 {{ $contract->client_email }}<br>@endif
                        @if($contract->client_number ?? false)📞 {{ $contract->client_number }}@endif
                    </div>
                </div>
                <div class="cv-party-divider"></div>
                <div class="cv-party">
                    <div class="cv-party-label">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Financials
                    </div>
                    <div class="cv-party-name" style="font-size:22px;">₱{{ number_format($contract->total_amount ?? 0, 2) }}</div>
                    <div class="cv-party-sub">
                        Payment: {{ $contract->payment_type ?? 'N/A' }}<br>
                        @if($contract->equipment_type ?? false)Equipment: {{ ucfirst(str_replace('_',' ',$contract->equipment_type)) }}@endif
                    </div>
                </div>
            </div>

            {{-- Detail fields --}}
            <div class="cv-details">
                <div class="cv-details-grid">
                    <div class="cv-detail-item">
                        <div class="cv-detail-label">Contract Number</div>
                        <div class="cv-detail-value mono">{{ $contract->contract_number }}</div>
                    </div>
                    <div class="cv-detail-item">
                        <div class="cv-detail-label">Contract Type</div>
                        <div class="cv-detail-value">{{ ucfirst(str_replace('_',' ',$contract->contract_type)) }}</div>
                    </div>
                    <div class="cv-detail-item">
                        <div class="cv-detail-label">Payment Terms</div>
                        <div class="cv-detail-value">{{ $contract->payment_type ?? 'N/A' }}</div>
                    </div>
                    <div class="cv-detail-item">
                        <div class="cv-detail-label">Effective Date</div>
                        <div class="cv-detail-value mono">{{ \Carbon\Carbon::parse($contract->start_date)->format('F d, Y') }}</div>
                    </div>
                    <div class="cv-detail-item">
                        <div class="cv-detail-label">Expiration Date</div>
                        <div class="cv-detail-value mono">{{ \Carbon\Carbon::parse($contract->end_date)->format('F d, Y') }}</div>
                    </div>
                    <div class="cv-detail-item">
                        <div class="cv-detail-label">Equipment Type</div>
                        <div class="cv-detail-value">{{ $contract->equipment_type ? ucfirst(str_replace('_',' ',$contract->equipment_type)) : 'N/A' }}</div>
                    </div>
                </div>

                <hr class="cv-rule">

                {{-- Scope --}}
                <div class="cv-scope">
                    <div class="cv-scope-label">Contract Details / Scope of Work</div>
                    <div class="cv-scope-text">{{ $contract->contract_details ?? 'No details provided.' }}</div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="cv-footer cv-a d3">
            <div class="cv-footer-meta">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Contract managed by Legal Management Module
            </div>
            <div class="cv-footer-actions">
                <a href="{{ route('contract.management') }}" class="cv-btn cv-btn-ghost">← Back to List</a>
                @if($contract->status == 'pending')
                <a href="{{ route('contracts.edit', $contract->contract_id) }}" class="cv-btn cv-btn-yellow">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Contract
                </a>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection