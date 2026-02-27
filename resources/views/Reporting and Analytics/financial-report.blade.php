@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.ah-wrap * { box-sizing: border-box; }
.ah-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.ah-header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 20px 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
.ah-header-left h1 { font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.03em; margin: 0; }
.ah-header-left p { font-size: 13px; color: #94a3b8; margin: 3px 0 0; }
.ah-header-right { display: flex; gap: 10px; }

/* Buttons */
.ah-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; border: none; border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.18s; text-decoration: none; white-space: nowrap; }
.ah-btn-danger  { background: #dc2626; color: #fff; }
.ah-btn-danger:hover  { background: #b91c1c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220,38,38,0.28); }
.ah-btn-purple  { background: #7c3aed; color: #fff; }
.ah-btn-purple:hover  { background: #6d28d9; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(124,58,237,0.28); }

/* Body */
.ah-body { max-width: 1400px; margin: 0 auto; padding: 28px 32px 60px; }

/* Nav */
.ah-nav { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 32px; }
.ah-nav-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 13px; padding: 18px 14px; text-align: center; cursor: pointer; transition: all 0.2s; text-decoration: none; display: block; }
.ah-nav-card:hover { border-color: #c7d2fe; box-shadow: 0 6px 20px rgba(0,0,0,0.07); transform: translateY(-2px); }
.ah-nav-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 11px; }
.ah-nav-card span { font-size: 13px; font-weight: 600; color: #1e293b; }

/* Section card */
.ah-section { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
.ah-section-head { padding: 20px 28px; border-bottom: 1px solid #f1f5f9; }
.ah-section-head h2 { font-family: 'Outfit', sans-serif; font-size: 17px; font-weight: 700; margin: 0 0 3px; display: flex; align-items: center; gap: 9px; }
.ah-section-head p { font-size: 12.5px; margin: 0; }
.head-blue   { background: #eff6ff; } .head-blue   h2 { color: #1e40af; } .head-blue   p { color: #3b82f6; }
.head-yellow { background: #fffbeb; } .head-yellow h2 { color: #92400e; } .head-yellow p { color: #d97706; }
.head-purple { background: #f5f3ff; } .head-purple h2 { color: #4c1d95; } .head-purple p { color: #7c3aed; }
.ah-section-body { padding: 26px 28px; }

/* Stats */
.ah-stat-grid { display: grid; gap: 16px; margin-bottom: 24px; }
.g3 { grid-template-columns: repeat(3,1fr); }
.g4 { grid-template-columns: repeat(4,1fr); }
.ah-stat { background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 12px; padding: 16px 18px; position: relative; overflow: hidden; }
.ah-stat::before { content:''; position:absolute; left:0; top:0; bottom:0; width:3px; border-radius:3px 0 0 3px; }
.s-blue::before   { background:#3b82f6; }
.s-green::before  { background:#10b981; }
.s-slate::before  { background:#64748b; }
.s-red::before    { background:#ef4444; }
.s-yellow::before { background:#f59e0b; }
.s-purple::before { background:#8b5cf6; }
.ah-stat-label { font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px; }
.ah-stat-value { font-family:'Outfit',sans-serif; font-size:22px; font-weight:800; color:#0f172a; line-height:1; }
.v-red    { color:#dc2626!important; }
.v-orange { color:#ea580c!important; }
.v-yellow { color:#d97706!important; }
.v-green  { color:#059669!important; }

/* Subsection title */
.ah-sub { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin:0 0 14px; }

/* Eq grid */
.ah-eq-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; margin-bottom:24px; }
.ah-eq-card { background:#eff6ff; border:1px solid #dbeafe; border-radius:11px; padding:14px 16px; }
.ah-eq-label { font-size:12px; color:#64748b; font-weight:500; margin-bottom:4px; }
.ah-eq-val { font-family:'Outfit',sans-serif; font-size:18px; font-weight:700; color:#1e40af; }

/* Tables */
.ah-table-wrap { overflow-x:auto; border:1px solid #f1f5f9; border-radius:11px; margin-bottom:22px; }
.ah-table { width:100%; border-collapse:collapse; font-size:13px; }
.ah-table thead th { padding:10px 16px; text-align:left; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#94a3b8; background:#f8fafc; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
.ah-table tbody tr { border-bottom:1px solid #f8fafc; transition:background .14s; }
.ah-table tbody tr:hover { background:#f8fafc; }
.ah-table tbody tr:last-child { border-bottom:none; }
.ah-table tbody td { padding:11px 16px; color:#334155; vertical-align:middle; }
.t-id   { font-family:'Outfit',sans-serif; font-weight:700; color:#0f172a; }
.t-bold { font-weight:600; color:#0f172a; }

/* Pills */
.ah-pill { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:700; }
.pill-green  { background:#dcfce7; color:#15803d; }
.pill-red    { background:#fee2e2; color:#dc2626; }
.pill-yellow { background:#fef3c7; color:#b45309; }

/* Risk cards */
.ah-risk-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:24px; }
.ah-risk-card { border-radius:12px; padding:16px; }
.risk-red    { background:#fff1f2; border:1px solid #fecaca; }
.risk-yellow { background:#fffbeb; border:1px solid #fde68a; }
.risk-green  { background:#f0fdf4; border:1px solid #bbf7d0; }
.ah-risk-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
.ah-risk-badge { font-size:12px; font-weight:700; }
.risk-red    .ah-risk-badge { color:#dc2626; }
.risk-yellow .ah-risk-badge { color:#b45309; }
.risk-green  .ah-risk-badge { color:#15803d; }
.ah-risk-num { font-family:'Outfit',sans-serif; font-size:26px; font-weight:800; }
.risk-red    .ah-risk-num { color:#dc2626; }
.risk-yellow .ah-risk-num { color:#d97706; }
.risk-green  .ah-risk-num { color:#15803d; }
.ah-risk-bar { background:#e2e8f0; border-radius:20px; height:6px; overflow:hidden; }
.ah-risk-fill { height:100%; border-radius:20px; }
.risk-red    .ah-risk-fill { background:#ef4444; }
.risk-yellow .ah-risk-fill { background:#f59e0b; }
.risk-green  .ah-risk-fill { background:#10b981; }

/* Bar charts */
.ah-chart-box { background:#f8fafc; border:1px solid #f1f5f9; border-radius:12px; padding:20px; margin-bottom:22px; }
.ah-chart-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:22px; }
.ah-bar-row { display:flex; align-items:center; gap:10px; margin-bottom:10px; }
.ah-bar-row:last-child { margin-bottom:0; }
.ah-bar-label { font-size:12px; color:#64748b; width:36px; flex-shrink:0; }
.ah-bar-track { flex:1; background:#e2e8f0; border-radius:20px; height:8px; overflow:hidden; }
.ah-bar-fill  { height:100%; border-radius:20px; }
.ah-bar-num   { font-size:11.5px; color:#64748b; width:54px; text-align:right; flex-shrink:0; }

/* PM bars */
.ah-pm-row { margin-bottom:14px; }
.ah-pm-row:last-child { margin-bottom:0; }
.ah-pm-head { display:flex; justify-content:space-between; font-size:13px; margin-bottom:5px; color:#334155; font-weight:500; }
.ah-pm-track { background:#e2e8f0; border-radius:20px; height:10px; overflow:hidden; }
.ah-pm-fill  { height:100%; border-radius:20px; }

/* Predictive bars */
.ah-pred-row { margin-bottom:14px; }
.ah-pred-row:last-child { margin-bottom:0; }
.ah-pred-head { display:flex; justify-content:space-between; font-size:13px; margin-bottom:5px; color:#334155; font-weight:500; }
.ah-pred-track { background:#fee2e2; border-radius:20px; height:10px; overflow:hidden; }
.ah-pred-fill  { background:#ef4444; height:100%; border-radius:20px; }

/* AI box */
.ah-ai-box { border-radius:11px; padding:14px 18px; margin-bottom:22px; font-size:13px; line-height:1.6; font-weight:500; }
.ai-blue   { background:#eff6ff; border:1px solid #bfdbfe; color:#1d4ed8; }
.ai-yellow { background:#fffbeb; border:1px solid #fde68a; color:#92400e; }
.ai-purple { background:#f5f3ff; border:1px solid #ddd6fe; color:#4c1d95; }

/* Method icon */
.ah-method { display:inline-flex; align-items:center; gap:5px; font-size:12.5px; color:#475569; }

/* Risk dot */
.ah-dot { width:8px; height:8px; border-radius:50%; display:inline-block; }
.d-red    { background:#ef4444; }
.d-yellow { background:#f59e0b; }
.d-green  { background:#10b981; }

/* Action row */
.ah-action-row { margin-top:20px; padding-top:20px; border-top:1px solid #f1f5f9; }

/* Confidential */
.conf-cell { position:relative; display:inline-flex; align-items:center; }
.conf-blur { filter:blur(8px); user-select:none; pointer-events:none; transition:filter .3s; }
.conf-btn  { position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); background:#0f172a; color:#fbbf24; border:none; padding:3px 9px; border-radius:6px; font-family:'DM Sans',sans-serif; font-size:11px; font-weight:700; cursor:pointer; white-space:nowrap; box-shadow:0 2px 8px rgba(0,0,0,.3); display:flex; align-items:center; gap:4px; }
.conf-btn.gone { display:none; }

/* Password modal */
.ah-modal-bg { position:fixed; inset:0; background:rgba(15,23,42,.6); backdrop-filter:blur(4px); z-index:1000; display:none; align-items:center; justify-content:center; padding:16px; }
.ah-modal-bg.open { display:flex; }
.ah-modal-box { background:#fff; border-radius:16px; width:100%; max-width:440px; box-shadow:0 30px 80px rgba(0,0,0,.22); animation:ahIn .22s ease; overflow:hidden; }
@keyframes ahIn { from{transform:translateY(10px) scale(.97);opacity:0;} to{transform:translateY(0) scale(1);opacity:1;} }
.ah-modal-hd { background:linear-gradient(135deg,#0f172a,#1e293b); padding:20px 24px; display:flex; align-items:center; justify-content:space-between; }
.ah-modal-hd h3 { font-family:'Outfit',sans-serif; font-size:17px; font-weight:700; color:#fff; margin:0; }
.ah-modal-x { background:none; border:none; color:rgba(255,255,255,.7); cursor:pointer; padding:4px; border-radius:6px; }
.ah-modal-x:hover { background:rgba(255,255,255,.12); color:#fff; }
.ah-modal-bd { padding:24px; }
.ah-modal-icon { width:48px; height:48px; background:#fef3c7; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:14px; }
.ah-modal-bd p { font-size:13.5px; color:#64748b; margin-bottom:16px; line-height:1.5; }
.ah-pwd-in { width:100%; height:44px; padding:0 14px; border:1.5px solid #e2e8f0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1e293b; background:#f8fafc; outline:none; margin-bottom:10px; transition:border-color .18s,box-shadow .18s; }
.ah-pwd-in:focus { border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,.12); background:#fff; }
.ah-modal-err { font-size:12.5px; color:#dc2626; display:none; margin-bottom:10px; }
.ah-modal-err.show { display:block; }
.ah-modal-acts { display:flex; gap:10px; }
.ah-btn-verify { flex:1; height:42px; background:#1e40af; color:#fff; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:700; cursor:pointer; }
.ah-btn-verify:hover { background:#1d3a9e; }
.ah-btn-cancel { height:42px; padding:0 18px; background:#f1f5f9; color:#64748b; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:600; cursor:pointer; }
.ah-btn-cancel:hover { background:#e2e8f0; }

/* Forward modal */
.ah-fwd-bg { position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:1000; display:none; align-items:center; justify-content:center; padding:16px; }
.ah-fwd-bg.open { display:flex; }
.ah-fwd-box { background:#fff; border-radius:14px; width:95%; max-width:820px; height:90vh; overflow:hidden; box-shadow:0 30px 80px rgba(0,0,0,.2); }

/* Anim */
@keyframes ahFU { from{opacity:0;transform:translateY(14px);} to{opacity:1;transform:translateY(0);} }
.ah-a  { animation:ahFU .4s ease both; }
.d1{animation-delay:.04s} .d2{animation-delay:.09s} .d3{animation-delay:.14s} .d4{animation-delay:.19s}

/* Responsive */
@media(max-width:1100px){ .ah-chart-grid{grid-template-columns:1fr;} }
@media(max-width:900px) { .g4{grid-template-columns:repeat(2,1fr);} .ah-risk-grid{grid-template-columns:1fr;} }
@media(max-width:700px) { .ah-nav{grid-template-columns:repeat(2,1fr);} .g3{grid-template-columns:1fr;} .g4{grid-template-columns:1fr;} .ah-eq-grid{grid-template-columns:1fr;} .ah-body{padding:20px 16px 40px;} .ah-header{padding:16px 18px;} }
</style>

<div class="ah-wrap">

    {{-- Header --}}
    <div class="ah-header">
        <div class="ah-header-left">
            <h1>Reporting & Analytics Hub</h1>
            <p>Centralized intelligence from all business units</p>
        </div>
        <div class="ah-header-right">
            <a href="{{ route('financial-report.export.pdf') }}" target="_blank" class="ah-btn ah-btn-danger">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export PDF
            </a>
        </div>
    </div>

    <div class="ah-body">

        {{-- Nav --}}
        <div class="ah-nav ah-a d1">
            <a href="#financial" class="ah-nav-card">
                <div class="ah-nav-icon" style="background:#dbeafe;">
                    <svg width="22" height="22" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span>Financial Intelligence</span>
            </a>
            <a href="#maintenance" class="ah-nav-card">
                <div class="ah-nav-icon" style="background:#fef3c7;">
                    <svg width="22" height="22" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span>Maintenance Reports</span>
            </a>
            <a href="#projects" class="ah-nav-card">
                <div class="ah-nav-icon" style="background:#dcfce7;">
                    <svg width="22" height="22" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span>Project Status</span>
            </a>
            <a href="#compliance" class="ah-nav-card">
                <div class="ah-nav-icon" style="background:#fee2e2;">
                    <svg width="22" height="22" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <span>Regulatory Compliance</span>
            </a>
        </div>

        {{-- ═══ FINANCIAL INTELLIGENCE ═══ --}}
        <div id="financial" class="ah-section ah-a d2">
            <div class="ah-section-head head-blue">
                <h2>
                    <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Financial Intelligence
                </h2>
                <p>Revenue analytics from Payment Management system</p>
            </div>
            <div class="ah-section-body">

                <div class="ah-stat-grid g3">
                    <div class="ah-stat s-green">
                        <div class="ah-stat-label">Total Revenue</div>
                        <div class="ah-stat-value">
                            <span class="conf-cell">
                                <span class="conf-blur">₱{{ number_format($totalRevenue, 2) }}</span>
                                <button class="conf-btn" onclick="openPwdModal(event)">🔒 Unlock</button>
                            </span>
                        </div>
                    </div>
                    <div class="ah-stat s-blue">
                        <div class="ah-stat-label">Collection Rate</div>
                        <div class="ah-stat-value">{{ $collectionRatePercent }}%</div>
                    </div>
                    <div class="ah-stat s-slate">
                        <div class="ah-stat-label">Active Contracts</div>
                        <div class="ah-stat-value">{{ $invoiceDetails->count() }}</div>
                    </div>
                </div>

                <p class="ah-sub">Revenue by Equipment Type</p>
                <div class="ah-eq-grid">
                    @foreach($revenueBreakdown as $breakdown)
                    <div class="ah-eq-card">
                        <div class="ah-eq-label">{{ ucfirst(str_replace('_', ' ', $breakdown->equipment_type)) }}</div>
                        <div class="ah-eq-val">
                            <span class="conf-cell">
                                <span class="conf-blur">₱{{ number_format($breakdown->total, 2) }}</span>
                                <button class="conf-btn" onclick="openPwdModal(event)">🔒 Unlock</button>
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <p class="ah-sub">Invoice Summary</p>
                <div class="ah-table-wrap">
                    <table class="ah-table">
                        <thead><tr><th>Invoice</th><th>Client</th><th>Equipment</th><th>Hours</th><th>Amount</th></tr></thead>
                        <tbody>
                            @foreach($invoiceDetails as $invoice)
                            <tr>
                                <td><span class="t-id">INV-{{ str_pad($invoice->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                                <td class="t-bold">{{ $invoice->client_name }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $invoice->equipment_type)) }}</td>
                                <td>{{ $invoice->hours_used }}</td>
                                <td><span class="conf-cell"><span class="conf-blur t-bold">₱{{ number_format($invoice->total_amount, 2) }}</span><button class="conf-btn" onclick="openPwdModal(event)">🔒 Unlock</button></span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="ah-ai-box ai-blue">🤖 <strong>AI Insight:</strong> Total revenue is calculated as the sum of all billed hours × hourly rates from paid invoices.</div>

                <div class="ah-chart-grid">
                    <div class="ah-chart-box">
                        <p class="ah-sub" style="margin-bottom:16px;">Revenue Trend</p>
                        @php $months=['Jan','Feb','Mar','Apr','May','Jun']; $maxRev=max($revenueData); @endphp
                        @for($i=0;$i<count($months);$i++)
                        <div class="ah-bar-row">
                            <span class="ah-bar-label">{{ $months[$i] }}</span>
                            <div class="ah-bar-track"><div class="ah-bar-fill" style="width:{{ $maxRev>0?($revenueData[$i]/$maxRev)*100:0 }}%;background:#10b981;"></div></div>
                            <span class="ah-bar-num">₱{{ number_format($revenueData[$i]/1000,0) }}K</span>
                        </div>
                        @endfor
                    </div>
                    <div class="ah-chart-box">
                        <p class="ah-sub" style="margin-bottom:16px;">Payment Methods</p>
                        @foreach($paymentMethods as $method)
                        @php $pmC=['blue'=>'#3b82f6','green'=>'#10b981','amber'=>'#f59e0b','gray'=>'#64748b','red'=>'#ef4444','purple'=>'#8b5cf6']; $c=$pmC[$method['color']]??'#3b82f6'; @endphp
                        <div class="ah-pm-row">
                            <div class="ah-pm-head"><span>{{ $method['name'] }}</span><span style="font-weight:700;">{{ $method['percentage'] }}%</span></div>
                            <div class="ah-pm-track"><div class="ah-pm-fill" style="width:{{ $method['percentage'] }}%;background:{{ $c }};"></div></div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <p class="ah-sub">Transaction Details</p>
                <div class="ah-table-wrap">
                    <table class="ah-table">
                        <thead><tr><th>Date</th><th>Client</th><th>Invoice</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($invoiceDetails as $invoice)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') }}</td>
                                <td class="t-bold">{{ $invoice->client_name }}</td>
                                <td><span class="t-id">INV-{{ str_pad($invoice->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                                <td><span class="conf-cell"><span class="conf-blur t-bold">₱{{ number_format($invoice->total_amount, 2) }}</span><button class="conf-btn" onclick="openPwdModal(event)">🔒 Unlock</button></span></td>
                                <td><span class="ah-method"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Bank Transfer</span></td>
                                <td><span class="ah-pill pill-green">Completed</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="ah-action-row">
                    <button type="button" onclick="openForwardModal('Financial Intelligence Report','Financial')" class="ah-btn ah-btn-purple">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Forward Financial Report
                    </button>
                </div>
            </div>
        </div>

        {{-- ═══ MAINTENANCE REPORTS ═══ --}}
        <div id="maintenance" class="ah-section ah-a d3">
            <div class="ah-section-head head-yellow">
                <h2>
                    <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Maintenance Reports
                </h2>
                <p>Equipment maintenance status from Maintenance Scheduling system</p>
            </div>
            <div class="ah-section-body">

                <div class="ah-stat-grid g4">
                    <div class="ah-stat s-green"><div class="ah-stat-label">Completed This Month</div><div class="ah-stat-value">{{ $completedThisMonth }}</div></div>
                    <div class="ah-stat s-yellow"><div class="ah-stat-label">Pending Maintenance</div><div class="ah-stat-value">{{ $pendingCount }}</div></div>
                    <div class="ah-stat s-red"><div class="ah-stat-label">Overdue Schedules</div><div class="ah-stat-value">{{ $overdueCount }}</div></div>
                    <div class="ah-stat s-red"><div class="ah-stat-label">High Risk Equipment</div><div class="ah-stat-value">{{ $highRiskCount }}</div></div>
                </div>

                <p class="ah-sub">AI Risk Distribution</p>
                @php $totalR = $highRiskCount + $mediumRiskCount + $lowRiskCount; @endphp
                <div class="ah-risk-grid">
                    <div class="ah-risk-card risk-red">
                        <div class="ah-risk-head"><span class="ah-risk-badge">High Risk ≥ 80%</span><span class="ah-risk-num">{{ $highRiskCount }}</span></div>
                        <div class="ah-risk-bar"><div class="ah-risk-fill" style="width:{{ $totalR>0?($highRiskCount/$totalR)*100:0 }}%;"></div></div>
                    </div>
                    <div class="ah-risk-card risk-yellow">
                        <div class="ah-risk-head"><span class="ah-risk-badge">Medium Risk 60–79%</span><span class="ah-risk-num">{{ $mediumRiskCount }}</span></div>
                        <div class="ah-risk-bar"><div class="ah-risk-fill" style="width:{{ $totalR>0?($mediumRiskCount/$totalR)*100:0 }}%;"></div></div>
                    </div>
                    <div class="ah-risk-card risk-green">
                        <div class="ah-risk-head"><span class="ah-risk-badge">Low Risk &lt; 60%</span><span class="ah-risk-num">{{ $lowRiskCount }}</span></div>
                        <div class="ah-risk-bar"><div class="ah-risk-fill" style="width:{{ $totalR>0?($lowRiskCount/$totalR)*100:0 }}%;"></div></div>
                    </div>
                </div>

                <p class="ah-sub">Recent Maintenance Activity</p>
                <div class="ah-table-wrap">
                    <table class="ah-table">
                        <thead><tr><th>Equipment</th><th>Type</th><th>Scheduled Date</th><th>Status</th><th>AI Risk</th></tr></thead>
                        <tbody>
                            @forelse($recentMaintenance as $schedule)
                            <tr>
                                <td class="t-bold">{{ $schedule->equipment_name }}</td>
                                <td>{{ $schedule->maintenanceType->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('M d, Y') }}</td>
                                <td>
                                    @if($schedule->status == 'completed')
                                        <span class="ah-pill pill-green">Completed</span>
                                    @elseif($schedule->status == 'pending' && \Carbon\Carbon::parse($schedule->scheduled_date)->isPast())
                                        <span class="ah-pill pill-red">Overdue</span>
                                    @else
                                        <span class="ah-pill pill-yellow">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($schedule->ai_risk_score > 0)
                                    <div style="display:flex;align-items:center;gap:7px;">
                                        <span style="font-weight:700;font-size:13px;">{{ number_format($schedule->ai_risk_score*100,0) }}%</span>
                                        @if($schedule->ai_risk_score >= 0.8)
                                            <span class="ah-dot d-red" title="High Risk"></span>
                                        @elseif($schedule->ai_risk_score >= 0.6)
                                            <span class="ah-dot d-yellow" title="Medium Risk"></span>
                                        @else
                                            <span class="ah-dot d-green" title="Low Risk"></span>
                                        @endif
                                    </div>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12.5px;">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" style="text-align:center;padding:48px 16px;color:#94a3b8;font-size:13px;">No maintenance records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="ah-ai-box ai-yellow">🤖 <strong>AI Insight:</strong> Our predictive maintenance system analyzes equipment history and usage patterns to identify high-risk equipment requiring immediate attention.</div>

                <div class="ah-chart-box">
                    <p class="ah-sub" style="margin-bottom:16px;">Maintenance Completion Trend</p>
                    @php $mMonths=['Jan','Feb','Mar','Apr','May','Jun']; $maxM=max($maintenanceData); @endphp
                    @for($i=0;$i<count($mMonths);$i++)
                    <div class="ah-bar-row">
                        <span class="ah-bar-label">{{ $mMonths[$i] }}</span>
                        <div class="ah-bar-track"><div class="ah-bar-fill" style="width:{{ $maxM>0?($maintenanceData[$i]/$maxM)*100:0 }}%;background:#3b82f6;"></div></div>
                        <span class="ah-bar-num" style="width:28px;">{{ $maintenanceData[$i] }}</span>
                    </div>
                    @endfor
                </div>

                <div class="ah-action-row">
                    <button type="button" onclick="openForwardModal('Maintenance Compliance Report','Maintenance')" class="ah-btn ah-btn-purple">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Forward Maintenance Report
                    </button>
                </div>
            </div>
        </div>

        {{-- ═══ AI PREDICTIVE ANALYTICS ═══ --}}
        <div class="ah-section ah-a d4">
            <div class="ah-section-head head-purple">
                <h2>
                    <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    AI-Powered Predictive Analytics
                </h2>
                <p>Machine learning insights for proactive maintenance management</p>
            </div>
            <div class="ah-section-body">

                <div class="ah-stat-grid g4">
                    <div class="ah-stat s-red"><div class="ah-stat-label">High Risk Equipment</div><div class="ah-stat-value v-red">{{ $aiInsights['high_risk_equipment'] }}</div></div>
                    <div class="ah-stat s-yellow"><div class="ah-stat-label">At-Risk Percentage</div><div class="ah-stat-value v-orange">{{ $aiInsights['risk_percentage'] }}%</div></div>
                    <div class="ah-stat s-yellow"><div class="ah-stat-label">Predicted Failures (30d)</div><div class="ah-stat-value v-yellow">{{ $aiPredictions['upcoming_failures_30days'] }}</div></div>
                    <div class="ah-stat s-green"><div class="ah-stat-label">Cost Savings</div><div class="ah-stat-value v-green">₱{{ number_format($aiPredictions['maintenance_cost_savings'],0) }}</div></div>
                </div>

                <div class="ah-ai-box ai-purple">🤖 <strong>AI Recommendation:</strong> {{ $aiInsights['recommendation'] }}</div>

                <div class="ah-chart-box">
                    <p class="ah-sub" style="margin-bottom:16px;">Predictive Maintenance Timeline</p>
                    @php $weeks=['Week 1','Week 2','Week 3','Week 4']; $maxP=max($predictiveData); @endphp
                    @for($i=0;$i<count($weeks);$i++)
                    <div class="ah-pred-row">
                        <div class="ah-pred-head"><span>{{ $weeks[$i] }}</span><span style="font-weight:700;">{{ $predictiveData[$i] }} failures</span></div>
                        <div class="ah-pred-track"><div class="ah-pred-fill" style="width:{{ $maxP>0?($predictiveData[$i]/$maxP)*100:0 }}%;"></div></div>
                    </div>
                    @endfor
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Password Modal --}}
<div class="ah-modal-bg" id="ahPwdModal">
    <div class="ah-modal-box">
        <div class="ah-modal-hd">
            <h3>Security Verification</h3>
            <button class="ah-modal-x" onclick="closePwdModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="ah-modal-bd">
            <div class="ah-modal-icon">
                <svg width="24" height="24" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <p>Enter your administrator password to reveal all confidential financial data.</p>
            <input type="password" id="ahPwdIn" class="ah-pwd-in" placeholder="Enter password" autocomplete="off">
            <div class="ah-modal-err" id="ahPwdErr">Incorrect password. Please try again.</div>
            <div class="ah-modal-acts">
                <button class="ah-btn-verify" onclick="verifyPwd()">Verify Access</button>
                <button class="ah-btn-cancel" onclick="closePwdModal()">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- Forward Modal --}}
<div class="ah-fwd-bg" id="forwardModal">
    <div class="ah-fwd-box">
        <iframe src="{{ url('forward-files') }}" frameborder="0" style="width:100%;height:100%;border:none;"></iframe>
    </div>
</div>

<script>
const AH_PWD = 'admin123';

function openPwdModal(e){ e.preventDefault(); e.stopPropagation(); showPwdModal(); }
function showPwdModal(){
    document.getElementById('ahPwdModal').classList.add('open');
    document.getElementById('ahPwdErr').classList.remove('show');
    document.getElementById('ahPwdIn').value = '';
    setTimeout(()=>document.getElementById('ahPwdIn').focus(), 50);
}
function closePwdModal(){ document.getElementById('ahPwdModal').classList.remove('open'); }
document.getElementById('ahPwdModal').addEventListener('click', e=>{ if(e.target===document.getElementById('ahPwdModal')) closePwdModal(); });
document.getElementById('ahPwdIn').addEventListener('keydown', e=>{ if(e.key==='Enter') verifyPwd(); });

function verifyPwd(){
    if(document.getElementById('ahPwdIn').value === AH_PWD){
        closePwdModal();
        document.querySelectorAll('.conf-blur').forEach(el=>el.classList.remove('conf-blur'));
        document.querySelectorAll('.conf-btn').forEach(el=>el.classList.add('gone'));
    } else {
        document.getElementById('ahPwdErr').classList.add('show');
        document.getElementById('ahPwdIn').value = '';
        document.getElementById('ahPwdIn').focus();
    }
}

function openForwardModal(type, cat){
    localStorage.setItem('forwardDocumentType', type);
    localStorage.setItem('forwardCategory', cat);
    document.getElementById('forwardModal').classList.add('open');
}
function closeForwardModal(){ document.getElementById('forwardModal').classList.remove('open'); }
document.getElementById('forwardModal').addEventListener('click', e=>{ if(e.target===document.getElementById('forwardModal')) closeForwardModal(); });
document.addEventListener('keydown', e=>{ if(e.key==='Escape'){ closePwdModal(); closeForwardModal(); } });
</script>

@endsection