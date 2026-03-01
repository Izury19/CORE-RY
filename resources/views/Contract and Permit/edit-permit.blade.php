@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.pe-wrap * { box-sizing: border-box; }
.pe-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.pe-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.pe-back { width:36px; height:36px; border-radius:9px; border:1.5px solid #e2e8f0; background:#f8fafc; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b; text-decoration:none; transition:all .18s; flex-shrink:0; }
.pe-back:hover { border-color:#059669; color:#059669; background:#ecfdf5; }
.pe-header-text h1 { font-family:'Outfit',sans-serif; font-size:20px; font-weight:800; color:#0f172a; letter-spacing:-0.02em; margin:0; }
.pe-header-text p  { font-size:13px; color:#94a3b8; margin:2px 0 0; }

/* Body */
.pe-body { max-width:860px; margin:0 auto; padding:28px 24px 60px; }

/* Info banner */
.pe-info-banner { background:#ecfdf5; border:1px solid #a7f3d0; border-radius:11px; padding:12px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-size:13px; font-weight:500; color:#065f46; }

/* Current permit banner */
.pe-current-banner { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px 20px; margin-bottom:20px; display:flex; align-items:center; gap:16px; box-shadow:0 1px 3px rgba(0,0,0,0.04); }
.pe-current-icon { width:42px; height:42px; border-radius:11px; background:#dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.pe-current-label { font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#94a3b8; margin-bottom:3px; }
.pe-current-name  { font-family:'Outfit',sans-serif; font-size:16px; font-weight:800; color:#0f172a; }
.pe-current-meta  { display:flex; gap:10px; margin-top:5px; flex-wrap:wrap; }
.pe-tag { display:inline-flex; align-items:center; gap:4px; padding:2px 9px; border-radius:20px; font-size:11.5px; font-weight:600; }
.tag-green  { background:#dcfce7; color:#15803d; }
.tag-blue   { background:#dbeafe; color:#1d4ed8; }
.tag-yellow { background:#fef3c7; color:#b45309; }
.tag-red    { background:#fee2e2; color:#dc2626; }

/* Card */
.pe-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; margin-bottom:16px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.pe-card-head { padding:16px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
.pe-card-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.pe-card-head h2 { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin:0; }
.pe-card-head p  { font-size:12px; color:#94a3b8; margin:2px 0 0; }
.pe-card-body { padding:22px 24px; }

/* Grid */
.pe-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

/* Fields */
.pe-field { margin-bottom:16px; }
.pe-field:last-child { margin-bottom:0; }
.pe-label { display:block; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#64748b; margin-bottom:6px; }
.pe-label .req { color:#ef4444; }
.pe-input, .pe-select, .pe-textarea {
    width:100%; height:42px; padding:0 13px;
    border:1.5px solid #e2e8f0; border-radius:9px;
    font-family:'DM Sans',sans-serif; font-size:13.5px; color:#1e293b;
    background:#f8fafc; outline:none;
    transition:border-color .18s, box-shadow .18s, background .18s;
}
.pe-input:focus, .pe-select:focus, .pe-textarea:focus { border-color:#059669; box-shadow:0 0 0 3px rgba(5,150,105,.1); background:#fff; }
.pe-input::placeholder { color:#cbd5e1; }
.pe-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 13px center; background-color:#f8fafc; padding-right:36px; }
.pe-textarea { height:auto; padding:11px 13px; resize:vertical; min-height:80px; }
.pe-hint { font-size:11.5px; color:#94a3b8; margin-top:4px; display:flex; align-items:center; gap:4px; }

/* File zone */
.pe-file-zone { border:2px dashed #d1fae5; border-radius:11px; padding:18px; text-align:center; cursor:pointer; transition:all .18s; background:#f0fdf4; position:relative; }
.pe-file-zone:hover { border-color:#6ee7b7; background:#ecfdf5; }
.pe-file-zone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.pe-file-title { font-size:13px; font-weight:600; color:#1e293b; margin-bottom:2px; }
.pe-file-sub   { font-size:12px; color:#94a3b8; }
.pe-current-doc { display:inline-flex; align-items:center; gap:7px; padding:8px 14px; background:#f0fdf4; border:1px solid #a7f3d0; border-radius:9px; font-size:12.5px; font-weight:600; color:#065f46; text-decoration:none; transition:all .18s; margin-bottom:12px; }
.pe-current-doc:hover { background:#dcfce7; }

/* Footer */
.pe-footer { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:16px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.pe-footer-hint { font-size:12px; color:#94a3b8; display:flex; align-items:center; gap:6px; }
.pe-footer-actions { display:flex; gap:10px; }
.pe-btn { display:inline-flex; align-items:center; gap:7px; padding:10px 20px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all .18s; text-decoration:none; }
.pe-btn-primary { background:#059669; color:#fff; }
.pe-btn-primary:hover { background:#047857; transform:translateY(-1px); box-shadow:0 4px 12px rgba(5,150,105,.28); }
.pe-btn-ghost { background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; }
.pe-btn-ghost:hover { background:#e2e8f0; }

/* Animations */
@keyframes peFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.pe-a { animation:peFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s}
.d4{animation-delay:.15s} .d5{animation-delay:.19s}

@media(max-width:700px) {
    .pe-grid-2 { grid-template-columns:1fr; }
    .pe-body { padding:18px 14px 40px; }
    .pe-header { padding:14px 18px; }
    .pe-footer { flex-direction:column; }
    .pe-footer-actions { width:100%; }
    .pe-btn { flex:1; justify-content:center; }
    .pe-current-banner { flex-direction:column; align-items:flex-start; }
}
</style>

<div class="pe-wrap">

    {{-- Header --}}
    <div class="pe-header">
        <a href="{{ route('manage-permits') }}" class="pe-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div class="pe-header-text">
            <h1>Edit Permit</h1>
            <p>{{ $permit->contract_number }} · Update details before compliance verification</p>
        </div>
    </div>

    <div class="pe-body">

        {{-- Info banner --}}
        <div class="pe-info-banner pe-a d1">
            <svg width="16" height="16" fill="none" stroke="#065f46" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Changes to this permit will require re-verification by the <strong>Compliance Team</strong>.
        </div>

        {{-- Currently Editing Banner --}}
        @php
            $permitStatus = $permit->compliance_status ?? $permit->status ?? 'pending';
            $statusTag = match($permitStatus) {
                'verified', 'approved' => 'tag-green',
                'expired'              => 'tag-red',
                'non_compliant'        => 'tag-red',
                'under_renewal'        => 'tag-yellow',
                default                => 'tag-yellow',
            };
        @endphp
        <div class="pe-current-banner pe-a d1">
            <div class="pe-current-icon">
                <svg width="20" height="20" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <div class="pe-current-label">Currently Editing</div>
                <div class="pe-current-name">{{ $permit->contract_number }}</div>
                <div class="pe-current-meta">
                    <span class="pe-tag tag-blue">{{ ucfirst(str_replace('_',' ',$permit->contract_type ?? '')) }}</span>
                    <span class="pe-tag {{ $statusTag }}">{{ ucfirst(str_replace('_',' ',$permitStatus)) }}</span>
                    @if(($permit->end_date ?? $permit->expiry_date ?? null))
                    <span class="pe-tag tag-blue">Expires {{ \Carbon\Carbon::parse($permit->end_date ?? $permit->expiry_date)->format('M d, Y') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <form action="{{ route('permits.update', $permit->contract_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- SECTION 1: Permit Identity --}}
            <div class="pe-card pe-a d2">
                <div class="pe-card-head">
                    <div class="pe-card-icon" style="background:#dcfce7;">
                        <svg width="16" height="16" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6m0-6l6 6m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h2>Permit Identity</h2>
                        <p>Permit number, type, and issuing authority</p>
                    </div>
                </div>
                <div class="pe-card-body">
                    <div class="pe-grid-2">
                        <div class="pe-field">
                            <label class="pe-label">Permit Number <span class="req">*</span></label>
                            <input type="text" name="permit_number" class="pe-input"
                                   value="{{ $permit->contract_number }}" required>
                        </div>
                        <div class="pe-field">
                            <label class="pe-label">Issuing Authority <span class="req">*</span></label>
                            <input type="text" name="issuing_authority" class="pe-input"
                                   value="{{ $permit->company_name }}" required placeholder="e.g. LGU, DPWH, LTO">
                        </div>
                    </div>
                    <div class="pe-field" style="margin-bottom:0;">
                        <label class="pe-label">Permit Type <span class="req">*</span></label>
                        <select name="permit_type" class="pe-select" required>
                            <option value="">Select permit type…</option>
                            <option value="construction"    {{ $permit->contract_type == 'construction'    ? 'selected' : '' }}>🏗️ LGU Construction Permit</option>
                            <option value="oversize_vehicle"{{ $permit->contract_type == 'oversize_vehicle'? 'selected' : '' }}>🚛 DPWH Oversize Vehicle Permit</option>
                            <option value="tollway_pass"    {{ $permit->contract_type == 'tollway_pass'    ? 'selected' : '' }}>🛣️ SLEx/NLEX Special Pass</option>
                            <option value="roadworthiness"  {{ $permit->contract_type == 'roadworthiness'  ? 'selected' : '' }}>📋 LTO Roadworthiness Certificate</option>
                            <option value="environmental"   {{ $permit->contract_type == 'environmental'   ? 'selected' : '' }}>🌱 DENR Environmental Certificate</option>
                            <option value="crane_operation" {{ $permit->contract_type == 'crane_operation' ? 'selected' : '' }}>🏗️ Crane Operation Permit</option>
                            <option value="fire_safety"     {{ $permit->contract_type == 'fire_safety'     ? 'selected' : '' }}>🔥 BFP Fire Safety Certificate</option>
                            <option value="electrical"      {{ $permit->contract_type == 'electrical'      ? 'selected' : '' }}>⚡ Electrical Permit</option>
                            <option value="occupancy"       {{ $permit->contract_type == 'occupancy'       ? 'selected' : '' }}>🏢 Occupancy Permit</option>
                            <option value="other"           {{ $permit->contract_type == 'other'           ? 'selected' : '' }}>📄 Other</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Validity Dates --}}
            <div class="pe-card pe-a d3">
                <div class="pe-card-head">
                    <div class="pe-card-icon" style="background:#dbeafe;">
                        <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h2>Validity Period</h2>
                        <p>Issue and expiry dates for this permit</p>
                    </div>
                </div>
                <div class="pe-card-body">
                    <div class="pe-grid-2">
                        <div class="pe-field" style="margin-bottom:0;">
                            <label class="pe-label">Issue Date <span class="req">*</span></label>
                            <input type="date" name="issue_date" class="pe-input"
                                   value="{{ $permit->start_date }}" required>
                        </div>
                        <div class="pe-field" style="margin-bottom:0;">
                            <label class="pe-label">Expiry Date <span class="req">*</span></label>
                            <input type="date" name="expiry_date" class="pe-input"
                                   value="{{ $permit->end_date }}" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: Document Upload --}}
            <div class="pe-card pe-a d4">
                <div class="pe-card-head">
                    <div class="pe-card-icon" style="background:#fef3c7;">
                        <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    </div>
                    <div>
                        <h2>Permit Document</h2>
                        <p>Upload updated scanned copy if needed</p>
                    </div>
                </div>
                <div class="pe-card-body">
                    @if($permit->document_path ?? false)
                    <a href="{{ asset('storage/' . $permit->document_path) }}" target="_blank" class="pe-current-doc">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        View Current Document
                    </a>
                    @endif
                    <div class="pe-file-zone">
                        <input type="file" name="permit_document" accept=".pdf,.jpg,.jpeg,.png">
                        <svg width="28" height="28" fill="none" stroke="#059669" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <div class="pe-file-title">Drop file or click to browse</div>
                        <div class="pe-file-sub">PDF, JPG, JPEG, PNG · Scanned permit document</div>
                    </div>
                    <p class="pe-hint" style="margin-top:8px;">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Leave blank to keep the existing document
                    </p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="pe-footer">
                <div class="pe-footer-hint">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Changes will be flagged for compliance re-verification
                </div>
                <div class="pe-footer-actions">
                    <a href="{{ route('manage-permits') }}" class="pe-btn pe-btn-ghost">Cancel</a>
                    <button type="submit" class="pe-btn pe-btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Update Permit
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection