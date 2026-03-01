@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.pv-wrap * { box-sizing: border-box; }
.pv-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.pv-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.pv-back { width:36px; height:36px; border-radius:9px; border:1.5px solid #e2e8f0; background:#f8fafc; display:flex; align-items:center; justify-content:center; color:#64748b; text-decoration:none; transition:all .18s; flex-shrink:0; }
.pv-back:hover { border-color:#059669; color:#059669; background:#ecfdf5; }
.pv-header-text h1 { font-family:'Outfit',sans-serif; font-size:20px; font-weight:800; color:#0f172a; letter-spacing:-0.02em; margin:0; }
.pv-header-text p  { font-size:13px; color:#94a3b8; margin:2px 0 0; }

/* Buttons */
.pv-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all .18s; text-decoration:none; }
.pv-btn-yellow { background:#f59e0b; color:#fff; }
.pv-btn-yellow:hover { background:#d97706; transform:translateY(-1px); box-shadow:0 4px 12px rgba(245,158,11,.3); }
.pv-btn-ghost  { background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; }
.pv-btn-ghost:hover { background:#e2e8f0; }

/* Body */
.pv-body { max-width:900px; margin:0 auto; padding:28px 24px 60px; }

/* Status Banner */
.pv-status-banner { border-radius:12px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; gap:12px; }
.sb-pending  { background:#fefce8; border:1px solid #fde68a; color:#92400e; }
.sb-approved { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; }
.sb-rejected { background:#fff1f2; border:1px solid #fecaca; color:#dc2626; }
.pv-status-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.si-pending  { background:#fef3c7; }
.si-approved { background:#dcfce7; }
.si-rejected { background:#fee2e2; }
.pv-status-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; opacity:.7; margin-bottom:2px; }
.pv-status-val   { font-size:15px; font-weight:800; }

/* Main doc card */
.pv-doc { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:16px; }

/* Green header strip */
.pv-doc-strip { background:linear-gradient(135deg,#059669,#10b981); padding:24px 28px; display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; }
.pv-doc-strip-left { display:flex; align-items:center; gap:14px; }
.pv-doc-strip-icon { width:44px; height:44px; background:rgba(255,255,255,0.15); border-radius:11px; display:flex; align-items:center; justify-content:center; }
.pv-doc-strip-title { font-family:'Outfit',sans-serif; font-size:20px; font-weight:800; color:#fff; letter-spacing:-0.02em; }
.pv-doc-strip-sub   { font-size:12px; color:rgba(255,255,255,.65); margin-top:2px; }
.pv-doc-strip-right { text-align:right; }
.pv-doc-strip-type  { display:inline-flex; padding:3px 12px; border-radius:20px; font-size:12px; font-weight:700; background:rgba(255,255,255,0.18); color:#fff; margin-bottom:6px; }
.pv-doc-strip-dates { font-size:12px; color:rgba(255,255,255,.65); }

/* Expiry alert strip */
.pv-expiry-strip { display:flex; align-items:center; gap:10px; padding:11px 24px; font-size:12.5px; font-weight:600; border-bottom:1px solid #f1f5f9; }
.es-ok      { background:#f0fdf4; color:#15803d; }
.es-soon    { background:#fffbeb; color:#b45309; }
.es-expired { background:#fff1f2; color:#dc2626; }

/* Info grid */
.pv-parties { display:grid; grid-template-columns:1fr 1px 1fr; background:#f8fafc; border-bottom:1px solid #f1f5f9; }
.pv-party { padding:18px 24px; }
.pv-party-divider { background:#f1f5f9; }
.pv-party-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; margin-bottom:7px; display:flex; align-items:center; gap:5px; }
.pv-party-name  { font-family:'Outfit',sans-serif; font-size:16px; font-weight:800; color:#0f172a; margin-bottom:4px; }
.pv-party-sub   { font-size:12px; color:#64748b; line-height:1.6; }

/* Details */
.pv-details { padding:22px 28px; }
.pv-details-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:22px; }
.pv-detail-label { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; margin-bottom:5px; }
.pv-detail-value { font-size:14px; font-weight:600; color:#1e293b; }
.pv-detail-value.mono { font-family:'Outfit',sans-serif; }

/* Document section */
.pv-rule { border:none; border-top:1px solid #f1f5f9; margin:0 0 20px; }
.pv-doc-section-label { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; margin-bottom:10px; }
.pv-doc-link { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:10px; font-size:13px; font-weight:600; color:#065f46; text-decoration:none; transition:all .18s; }
.pv-doc-link:hover { background:#dcfce7; transform:translateY(-1px); box-shadow:0 3px 8px rgba(5,150,105,.15); }
.pv-no-doc { display:flex; align-items:center; gap:8px; padding:12px 16px; background:#f8fafc; border:1.5px dashed #e2e8f0; border-radius:10px; font-size:13px; color:#94a3b8; font-weight:500; }

/* Footer */
.pv-footer { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:16px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.pv-footer-meta { font-size:12px; color:#94a3b8; display:flex; align-items:center; gap:6px; }
.pv-footer-actions { display:flex; gap:10px; }

/* Animations */
@keyframes pvFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.pv-a { animation:pvFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s} .d4{animation-delay:.15s}

@media(max-width:700px) {
    .pv-parties { grid-template-columns:1fr; }
    .pv-party-divider { display:none; }
    .pv-details-grid { grid-template-columns:1fr 1fr; }
    .pv-body { padding:18px 14px 40px; }
    .pv-header { padding:14px 18px; }
    .pv-doc-strip { padding:18px 20px; }
    .pv-footer { flex-direction:column; align-items:flex-start; }
    .pv-footer-actions { width:100%; }
    .pv-btn { flex:1; justify-content:center; }
}
@media(max-width:500px) { .pv-details-grid { grid-template-columns:1fr; } }
</style>

<div class="pv-wrap">

    {{-- Header --}}
    <div class="pv-header">
        <a href="{{ route('manage-permits') }}" class="pv-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div class="pv-header-text">
            <h1>Permit Details</h1>
            <p>{{ $permit->contract_number }} · Government permit information and compliance status</p>
        </div>
    </div>

    <div class="pv-body">

        {{-- Status Banner --}}
        @php
            $s = $permit->status;
            $sbClass = $s === 'approved' ? 'sb-approved' : ($s === 'rejected' ? 'sb-rejected' : 'sb-pending');
            $siClass = $s === 'approved' ? 'si-approved' : ($s === 'rejected' ? 'si-rejected' : 'si-pending');

            $expiry   = \Carbon\Carbon::parse($permit->end_date);
            $daysLeft = (int) now()->diffInDays($expiry, false);
            $esClass  = $daysLeft < 0 ? 'es-expired' : ($daysLeft <= 30 ? 'es-soon' : 'es-ok');
            $esMsg    = $daysLeft < 0
                ? '❌ This permit has expired ' . abs($daysLeft) . ' day(s) ago'
                : ($daysLeft <= 30
                    ? '⚠️ Expiring soon — ' . $daysLeft . ' day(s) remaining'
                    : '✅ Valid — ' . $daysLeft . ' day(s) remaining');
        @endphp

        <div class="pv-status-banner {{ $sbClass }} pv-a d1">
            <div class="pv-status-icon {{ $siClass }}">
                @if($s === 'approved')
                    <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @elseif($s === 'rejected')
                    <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @else
                    <svg width="18" height="18" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </div>
            <div>
                <div class="pv-status-label">Compliance Status</div>
                <div class="pv-status-val">
                    @if($s === 'approved') ✅ Verified — Permit is active and compliant
                    @elseif($s === 'rejected') ❌ Rejected — Permit did not pass compliance review
                    @else ⏳ Pending Review — Awaiting compliance verification
                    @endif
                </div>
            </div>
        </div>

        {{-- Document Card --}}
        <div class="pv-doc pv-a d2">

            {{-- Green header strip --}}
            <div class="pv-doc-strip">
                <div class="pv-doc-strip-left">
                    <div class="pv-doc-strip-icon">
                        <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <div class="pv-doc-strip-title">{{ $permit->contract_number }}</div>
                        <div class="pv-doc-strip-sub">Cali Heavy Equipment Inc. · Permit & Compliance</div>
                    </div>
                </div>
                <div class="pv-doc-strip-right">
                    <div class="pv-doc-strip-type">{{ ucfirst(str_replace('_',' ',$permit->contract_type ?? '')) }}</div>
                    <div class="pv-doc-strip-dates">
                        {{ \Carbon\Carbon::parse($permit->start_date)->format('M d, Y') }}
                        &nbsp;→&nbsp;
                        {{ \Carbon\Carbon::parse($permit->end_date)->format('M d, Y') }}
                    </div>
                </div>
            </div>

            {{-- Expiry strip --}}
            <div class="pv-expiry-strip {{ $esClass }}">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $esMsg }}
            </div>

            {{-- Parties --}}
            <div class="pv-parties">
                <div class="pv-party">
                    <div class="pv-party-label">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                        Issuing Authority
                    </div>
                    <div class="pv-party-name">{{ $permit->company_name }}</div>
                    <div class="pv-party-sub">Government Regulatory Body</div>
                </div>
                <div class="pv-party-divider"></div>
                <div class="pv-party">
                    <div class="pv-party-label">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Validity Period
                    </div>
                    <div class="pv-party-name" style="font-size:15px;">
                        {{ \Carbon\Carbon::parse($permit->start_date)->format('M d, Y') }}
                        <span style="color:#94a3b8;font-weight:400;font-size:13px;"> to </span>
                        {{ \Carbon\Carbon::parse($permit->end_date)->format('M d, Y') }}
                    </div>
                    <div class="pv-party-sub">
                        {{ \Carbon\Carbon::parse($permit->start_date)->diffInDays(\Carbon\Carbon::parse($permit->end_date)) }} day(s) total validity
                    </div>
                </div>
            </div>

            {{-- Detail fields --}}
            <div class="pv-details">
                <div class="pv-details-grid">
                    <div>
                        <div class="pv-detail-label">Permit Number</div>
                        <div class="pv-detail-value mono">{{ $permit->contract_number }}</div>
                    </div>
                    <div>
                        <div class="pv-detail-label">Permit Type</div>
                        <div class="pv-detail-value">{{ ucfirst(str_replace('_',' ',$permit->contract_type ?? 'N/A')) }}</div>
                    </div>
                    <div>
                        <div class="pv-detail-label">Issue Date</div>
                        <div class="pv-detail-value mono">{{ \Carbon\Carbon::parse($permit->start_date)->format('F d, Y') }}</div>
                    </div>
                    <div>
                        <div class="pv-detail-label">Expiry Date</div>
                        <div class="pv-detail-value mono">{{ \Carbon\Carbon::parse($permit->end_date)->format('F d, Y') }}</div>
                    </div>
                    <div>
                        <div class="pv-detail-label">Days Remaining</div>
                        <div class="pv-detail-value mono" style="color:{{ $daysLeft < 0 ? '#dc2626' : ($daysLeft <= 30 ? '#d97706' : '#15803d') }};">
                            {{ $daysLeft < 0 ? 'Expired' : $daysLeft . ' day(s)' }}
                        </div>
                    </div>
                    <div>
                        <div class="pv-detail-label">Issuing Authority</div>
                        <div class="pv-detail-value">{{ $permit->company_name }}</div>
                    </div>
                </div>

                <hr class="pv-rule">

                {{-- Document --}}
                <div class="pv-doc-section-label">Official Permit Document</div>
                @if($permit->document_path)
                    <a href="{{ asset('storage/' . $permit->document_path) }}" target="_blank" class="pv-doc-link">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        View Official Document
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                @else
                    <div class="pv-no-doc">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        No document uploaded for this permit
                    </div>
                @endif
            </div>
        </div>

        {{-- Footer --}}
        <div class="pv-footer pv-a d3">
            <div class="pv-footer-meta">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Managed by the Compliance & Permit Module
            </div>
            <div class="pv-footer-actions">
                <a href="{{ route('manage-permits') }}" class="pv-btn pv-btn-ghost">← Back to List</a>
                @if($permit->status == 'pending')
                <a href="{{ route('permits.edit', $permit->contract_id) }}" class="pv-btn pv-btn-yellow">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Permit
                </a>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection