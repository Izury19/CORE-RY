@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.ce-wrap * { box-sizing: border-box; }
.ce-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.ce-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.ce-back { width:36px; height:36px; border-radius:9px; border:1.5px solid #e2e8f0; background:#f8fafc; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b; text-decoration:none; transition:all .18s; flex-shrink:0; }
.ce-back:hover { border-color:#4f46e5; color:#4f46e5; background:#eef2ff; }
.ce-header-text h1 { font-family:'Outfit',sans-serif; font-size:20px; font-weight:800; color:#0f172a; letter-spacing:-0.02em; margin:0; }
.ce-header-text p  { font-size:13px; color:#94a3b8; margin:2px 0 0; }

/* Body */
.ce-body { max-width:860px; margin:0 auto; padding:28px 24px 60px; }

/* Info banner */
.ce-info-banner { background:#fffbeb; border:1px solid #fde68a; border-radius:11px; padding:12px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-size:13px; font-weight:500; color:#92400e; }

/* Card */
.ce-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; margin-bottom:16px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.ce-card-head { padding:16px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
.ce-card-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.ce-card-head h2 { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin:0; }
.ce-card-head p  { font-size:12px; color:#94a3b8; margin:2px 0 0; }
.ce-card-body { padding:22px 24px; }

/* Grid */
.ce-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

/* Fields */
.ce-field { margin-bottom:16px; }
.ce-field:last-child { margin-bottom:0; }
.ce-label { display:block; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#64748b; margin-bottom:6px; }
.ce-label .req { color:#ef4444; }
.ce-input, .ce-select, .ce-textarea {
    width:100%; height:42px; padding:0 13px;
    border:1.5px solid #e2e8f0; border-radius:9px;
    font-family:'DM Sans',sans-serif; font-size:13.5px; color:#1e293b;
    background:#f8fafc; outline:none;
    transition:border-color .18s, box-shadow .18s, background .18s;
}
.ce-input:focus, .ce-select:focus, .ce-textarea:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); background:#fff; }
.ce-input::placeholder { color:#cbd5e1; }
.ce-input.readonly { background:#f1f5f9; color:#94a3b8; cursor:not-allowed; border-style:dashed; }
.ce-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 13px center; background-color:#f8fafc; padding-right:36px; }
.ce-textarea { height:auto; padding:11px 13px; resize:vertical; min-height:100px; }
.ce-hint { font-size:11.5px; color:#94a3b8; margin-top:4px; display:flex; align-items:center; gap:4px; }

/* Amount prefix */
.ce-amount-wrap { position:relative; }
.ce-amount-pfx  { position:absolute; left:13px; top:50%; transform:translateY(-50%); font-size:13.5px; font-weight:700; color:#94a3b8; pointer-events:none; }
.ce-amount-input { padding-left:26px !important; }

/* Readonly badge */
.ce-readonly-badge { display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:20px; background:#f1f5f9; color:#94a3b8; font-size:11px; font-weight:700; margin-left:8px; text-transform:none; letter-spacing:0; }

/* Footer */
.ce-footer { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:16px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.ce-footer-hint { font-size:12px; color:#94a3b8; display:flex; align-items:center; gap:6px; }
.ce-footer-actions { display:flex; gap:10px; }
.ce-btn { display:inline-flex; align-items:center; gap:7px; padding:10px 20px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all .18s; text-decoration:none; }
.ce-btn-primary { background:#4f46e5; color:#fff; }
.ce-btn-primary:hover { background:#4338ca; transform:translateY(-1px); box-shadow:0 4px 12px rgba(79,70,229,.28); }
.ce-btn-ghost { background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; }
.ce-btn-ghost:hover { background:#e2e8f0; }

/* Animations */
@keyframes ceFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.ce-a { animation:ceFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s}
.d4{animation-delay:.15s} .d5{animation-delay:.19s}

@media(max-width:700px) {
    .ce-grid-2 { grid-template-columns:1fr; }
    .ce-body { padding:18px 14px 40px; }
    .ce-header { padding:14px 18px; }
    .ce-footer { flex-direction:column; }
    .ce-footer-actions { width:100%; }
    .ce-btn { flex:1; justify-content:center; }
}
</style>

<div class="ce-wrap">

    {{-- Header --}}
    <div class="ce-header">
        <a href="{{ route('contract.management') }}" class="ce-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div class="ce-header-text">
            <h1>Edit Contract</h1>
            <p>{{ $contract->contract_number }} · Update details before legal review</p>
        </div>
    </div>

    <div class="ce-body">

        {{-- Warning banner --}}
        <div class="ce-info-banner ce-a d1">
            <svg width="16" height="16" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.195 3 1.732 3z"/></svg>
            This contract is <strong>Pending Review</strong>. Changes will be resubmitted to Legal Management for re-approval.
        </div>

        <form action="{{ route('contracts.update', $contract->contract_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- SECTION 1: Contract Identity --}}
            <div class="ce-card ce-a d2">
                <div class="ce-card-head">
                    <div class="ce-card-icon" style="background:#eef2ff;">
                        <svg width="16" height="16" fill="none" stroke="#4f46e5" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h2>Contract Identity</h2>
                        <p>Type and reference number</p>
                    </div>
                </div>
                <div class="ce-card-body">
                    <div class="ce-grid-2">
                        <div class="ce-field">
                            <label class="ce-label">Contract Type <span class="req">*</span></label>
                            <select name="contract_type" class="ce-select" required>
                                <option value="">Select type…</option>
                                <option value="rental"      {{ $contract->contract_type == 'rental'      ? 'selected' : '' }}>Rental</option>
                                <option value="service"     {{ $contract->contract_type == 'service'     ? 'selected' : '' }}>Service</option>
                                <option value="procurement" {{ $contract->contract_type == 'procurement' ? 'selected' : '' }}>Procurement</option>
                                <option value="maintenance" {{ $contract->contract_type == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </div>
                        <div class="ce-field">
                            <label class="ce-label">Contract Number <span class="ce-readonly-badge">🔒 Read-only</span></label>
                            <input type="text" class="ce-input readonly" value="{{ $contract->contract_number }}" readonly>
                            <p class="ce-hint">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Contract number cannot be changed after creation
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Counterparty --}}
            <div class="ce-card ce-a d3">
                <div class="ce-card-head">
                    <div class="ce-card-icon" style="background:#dbeafe;">
                        <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h2>Counterparty</h2>
                        <p>Client or vendor contact details</p>
                    </div>
                </div>
                <div class="ce-card-body">
                    <div class="ce-field">
                        <label class="ce-label">Company / Individual <span class="req">*</span></label>
                        <input type="text" name="counterparty" class="ce-input"
                               value="{{ $contract->company_name }}" required>
                    </div>
                    <div class="ce-grid-2">
                        <div class="ce-field">
                            <label class="ce-label">Contact Email</label>
                            <input type="email" name="contact_email" class="ce-input"
                                   value="{{ $contract->client_email }}" placeholder="contact@company.com">
                        </div>
                        <div class="ce-field">
                            <label class="ce-label">Contact Number</label>
                            <input type="text" name="contact_number" class="ce-input"
                                   value="{{ $contract->client_number }}" placeholder="+63 9XX XXX XXXX">
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: Validity & Financials --}}
            <div class="ce-card ce-a d4">
                <div class="ce-card-head">
                    <div class="ce-card-icon" style="background:#dcfce7;">
                        <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h2>Validity & Financials</h2>
                        <p>Contract period, amount, and payment terms</p>
                    </div>
                </div>
                <div class="ce-card-body">
                    <div class="ce-grid-2">
                        <div class="ce-field">
                            <label class="ce-label">Effective Date <span class="req">*</span></label>
                            <input type="date" name="effective_date" class="ce-input"
                                   value="{{ $contract->start_date }}" required>
                        </div>
                        <div class="ce-field">
                            <label class="ce-label">Expiration Date <span class="req">*</span></label>
                            <input type="date" name="expiration_date" class="ce-input"
                                   value="{{ $contract->end_date }}" required>
                        </div>
                    </div>
                    <div class="ce-grid-2">
                        <div class="ce-field">
                            <label class="ce-label">Total Amount (₱) <span class="req">*</span></label>
                            <div class="ce-amount-wrap">
                                <span class="ce-amount-pfx">₱</span>
                                <input type="number" name="total_amount" step="0.01" min="0"
                                       class="ce-input ce-amount-input"
                                       value="{{ $contract->total_amount ?? 0 }}" required>
                            </div>
                        </div>
                        <div class="ce-field">
                            <label class="ce-label">Payment Terms</label>
                            <select name="payment_terms" class="ce-select">
                                <option value="net_30"       {{ ($contract->payment_type ?? '') == 'net_30'       ? 'selected' : '' }}>Net 30 Days</option>
                                <option value="net_60"       {{ ($contract->payment_type ?? '') == 'net_60'       ? 'selected' : '' }}>Net 60 Days</option>
                                <option value="upon_delivery"{{ ($contract->payment_type ?? '') == 'upon_delivery'? 'selected' : '' }}>Upon Delivery</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 4: Equipment & Scope --}}
            <div class="ce-card ce-a d5">
                <div class="ce-card-head">
                    <div class="ce-card-icon" style="background:#fef3c7;">
                        <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2>Equipment & Scope of Work</h2>
                        <p>Equipment type and contract details</p>
                    </div>
                </div>
                <div class="ce-card-body">
                    <div class="ce-field">
                        <label class="ce-label">Equipment Type (if applicable)</label>
                        <select name="equipment_type" class="ce-select">
                            <option value="">Select equipment…</option>
                            <option value="tower_crane"    {{ $contract->equipment_type == 'tower_crane'    ? 'selected' : '' }}>🏗️ Tower Crane</option>
                            <option value="mobile_crane"   {{ $contract->equipment_type == 'mobile_crane'   ? 'selected' : '' }}>🚛 Mobile Crane</option>
                            <option value="dump_truck"     {{ $contract->equipment_type == 'dump_truck'     ? 'selected' : '' }}>🚚 Dump Truck</option>
                            <option value="concrete_mixer" {{ $contract->equipment_type == 'concrete_mixer' ? 'selected' : '' }}>🔩 Concrete Mixer</option>
                        </select>
                    </div>
                    <div class="ce-field" style="margin-bottom:0;">
                        <label class="ce-label">Contract Details / Scope of Work</label>
                        <textarea name="contract_details" class="ce-textarea">{{ $contract->contract_details }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="ce-footer">
                <div class="ce-footer-hint">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Changes will be resubmitted to Legal Management for re-approval
                </div>
                <div class="ce-footer-actions">
                    <a href="{{ route('contract.management') }}" class="ce-btn ce-btn-ghost">Cancel</a>
                    <button type="submit" class="ce-btn ce-btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Update Contract
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection