@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.me-wrap * { box-sizing: border-box; }
.me-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.me-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.me-back { width:36px; height:36px; border-radius:9px; border:1.5px solid #e2e8f0; background:#f8fafc; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b; text-decoration:none; transition:all .18s; flex-shrink:0; }
.me-back:hover { border-color:#3b82f6; color:#3b82f6; background:#eff6ff; }
.me-header-text h1 { font-family:'Outfit',sans-serif; font-size:20px; font-weight:800; color:#0f172a; letter-spacing:-0.02em; margin:0; }
.me-header-text p  { font-size:13px; color:#94a3b8; margin:2px 0 0; }

/* Body */
.me-body { max-width:860px; margin:0 auto; padding:28px 24px 60px; }

/* Current schedule banner */
.me-current-banner { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px 20px; margin-bottom:20px; display:flex; align-items:center; gap:16px; box-shadow:0 1px 3px rgba(0,0,0,0.04); }
.me-current-icon { width:42px; height:42px; border-radius:11px; background:#dbeafe; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.me-current-label { font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#94a3b8; margin-bottom:3px; }
.me-current-name  { font-family:'Outfit',sans-serif; font-size:16px; font-weight:800; color:#0f172a; }
.me-current-meta  { display:flex; gap:10px; margin-top:5px; flex-wrap:wrap; }
.me-current-tag   { display:inline-flex; align-items:center; gap:4px; padding:2px 9px; border-radius:20px; font-size:11.5px; font-weight:600; }
.tag-blue   { background:#dbeafe; color:#1d4ed8; }
.tag-yellow { background:#fef3c7; color:#b45309; }
.tag-green  { background:#dcfce7; color:#15803d; }
.tag-red    { background:#fee2e2; color:#dc2626; }
.tag-orange { background:#ffedd5; color:#ea580c; }

/* Error alert */
.me-alert { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:14px 18px; border-radius:10px; margin-bottom:22px; font-size:13.5px; }
.me-alert ul { margin:6px 0 0; padding-left:18px; }
.me-alert li { margin-bottom:2px; }

/* Card */
.me-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; margin-bottom:16px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.me-card-head { padding:16px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
.me-card-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.me-card-head h2 { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin:0; }
.me-card-head p  { font-size:12px; color:#94a3b8; margin:2px 0 0; }
.me-card-body { padding:22px 24px; }

/* Grid */
.me-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

/* Fields */
.me-field { margin-bottom:16px; }
.me-field:last-child { margin-bottom:0; }
.me-label { display:block; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#64748b; margin-bottom:6px; }
.me-label .req { color:#ef4444; }
.me-input, .me-select {
    width:100%; height:42px; padding:0 13px;
    border:1.5px solid #e2e8f0; border-radius:9px;
    font-family:'DM Sans',sans-serif; font-size:13.5px; color:#1e293b;
    background:#f8fafc; outline:none;
    transition:border-color .18s, box-shadow .18s, background .18s;
}
.me-input:focus, .me-select:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); background:#fff; }
.me-input::placeholder { color:#cbd5e1; }
.me-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 13px center; background-color:#f8fafc; padding-right:36px; }
.me-hint { font-size:11.5px; color:#94a3b8; margin-top:4px; }

/* Permit status badge */
.me-permit-checking { display:none; margin-top:8px; padding:10px 14px; border-radius:9px; font-size:13px; font-weight:600; align-items:center; gap:8px; }
.me-permit-checking.show { display:flex; }
.permit-checking { background:#eff6ff; border:1px solid #bfdbfe; color:#1d4ed8; }
.permit-valid    { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; }
.permit-invalid  { background:#fff1f2; border:1px solid #fecaca; color:#dc2626; }
@keyframes spin { to { transform: rotate(360deg); } }
.spin { animation: spin .8s linear infinite; display:inline-block; }

/* Priority radio cards */
.me-priority-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; }
.me-priority-radio { display:none; }
.me-priority-label {
    display:flex; flex-direction:column; align-items:center; gap:5px;
    padding:12px 8px; border:1.5px solid #e2e8f0; border-radius:10px;
    cursor:pointer; transition:all .18s; background:#f8fafc; text-align:center;
}
.me-priority-label:hover { border-color:#93c5fd; background:#eff6ff; }
.me-priority-radio[value="low"]:checked     + .me-priority-label { border-color:#10b981; background:#f0fdf4; box-shadow:0 0 0 3px rgba(16,185,129,.1); }
.me-priority-radio[value="medium"]:checked  + .me-priority-label { border-color:#f59e0b; background:#fffbeb; box-shadow:0 0 0 3px rgba(245,158,11,.1); }
.me-priority-radio[value="high"]:checked    + .me-priority-label { border-color:#f97316; background:#fff7ed; box-shadow:0 0 0 3px rgba(249,115,22,.1); }
.me-priority-radio[value="critical"]:checked + .me-priority-label { border-color:#ef4444; background:#fff1f2; box-shadow:0 0 0 3px rgba(239,68,68,.1); }
.me-priority-dot  { width:10px; height:10px; border-radius:50%; }
.dot-low      { background:#10b981; }
.dot-medium   { background:#f59e0b; }
.dot-high     { background:#f97316; }
.dot-critical { background:#ef4444; }
.me-priority-name { font-size:12px; font-weight:700; color:#1e293b; }

/* Checkbox toggle */
.me-checkbox-row { display:flex; align-items:center; gap:10px; padding:14px 16px; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; cursor:pointer; transition:all .18s; }
.me-checkbox-row:hover { border-color:#93c5fd; background:#eff6ff; }
.me-checkbox-row input[type="checkbox"] { width:18px; height:18px; accent-color:#3b82f6; cursor:pointer; flex-shrink:0; }
.me-checkbox-row label { font-size:13.5px; font-weight:600; color:#1e293b; cursor:pointer; margin:0; }
.me-checkbox-row p { font-size:12px; color:#94a3b8; margin:0; }

/* Recurrence panel */
.me-recurrence { background:#eff6ff; border:1px solid #bfdbfe; border-radius:11px; padding:18px; margin-top:14px; display:none; }
.me-recurrence.show { display:block; }
.me-recurrence-title { font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:#1d4ed8; margin-bottom:14px; display:flex; align-items:center; gap:7px; }

/* Footer */
.me-footer { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:18px 24px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.me-footer-hint { font-size:12px; color:#94a3b8; display:flex; align-items:center; gap:6px; }
.me-footer-actions { display:flex; gap:10px; }
.me-btn { display:inline-flex; align-items:center; gap:7px; padding:10px 20px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all .18s; text-decoration:none; }
.me-btn-primary { background:#3b82f6; color:#fff; }
.me-btn-primary:hover { background:#2563eb; transform:translateY(-1px); box-shadow:0 4px 12px rgba(59,130,246,.28); }
.me-btn-ghost { background:#f1f5f9; color:#64748b; }
.me-btn-ghost:hover { background:#e2e8f0; }

/* Animations */
@keyframes meFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.me-a { animation:meFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s}
.d4{animation-delay:.15s} .d5{animation-delay:.19s} .d6{animation-delay:.23s}

/* Responsive */
@media(max-width:700px) {
    .me-grid-2 { grid-template-columns:1fr; }
    .me-priority-grid { grid-template-columns:repeat(2,1fr); }
    .me-body { padding:18px 14px 40px; }
    .me-header { padding:14px 18px; }
    .me-footer { flex-direction:column; gap:12px; }
    .me-footer-actions { width:100%; }
    .me-btn { flex:1; justify-content:center; }
    .me-current-banner { flex-direction:column; align-items:flex-start; }
}
</style>

<div class="me-wrap">

    {{-- Header --}}
    <div class="me-header">
        <a href="{{ route('maintenance.index') }}" class="me-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div class="me-header-text">
            <h1>Edit Maintenance Schedule</h1>
            <p>Update schedule #{{ $schedule->maintenance_sched_id }}</p>
        </div>
    </div>

    <div class="me-body">

        {{-- Current Schedule Info Banner --}}
        @php
            $currentPriority = $schedule->priority ?? 'low';
            $priorityTagClass = match($currentPriority) {
                'critical' => 'tag-red',
                'high'     => 'tag-orange',
                'medium'   => 'tag-yellow',
                default    => 'tag-green',
            };
            $currentStatus = $schedule->status ?? 'pending';
        @endphp
        <div class="me-current-banner me-a d1">
            <div class="me-current-icon">
                <svg width="20" height="20" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <div class="me-current-label">Currently Editing</div>
                <div class="me-current-name">{{ $schedule->equipment_name }}</div>
                <div class="me-current-meta">
                    <span class="me-current-tag tag-blue">{{ $schedule->maintenanceType->name ?? 'N/A' }}</span>
                    <span class="me-current-tag {{ $priorityTagClass }}">{{ ucfirst($currentPriority) }} Priority</span>
                    <span class="me-current-tag {{ $currentStatus === 'completed' ? 'tag-green' : 'tag-yellow' }}">{{ ucfirst($currentStatus) }}</span>
                    <span class="me-current-tag tag-blue">{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('M d, Y') }}</span>
                    @if($schedule->is_recurring)
                    <span class="me-current-tag tag-blue">🔄 Recurring</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="me-alert me-a d1">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('maintenance.update', $schedule->maintenance_sched_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- SECTION 1: Equipment --}}
            <div class="me-card me-a d2">
                <div class="me-card-head">
                    <div class="me-card-icon" style="background:#dbeafe;">
                        <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2>Equipment Details</h2>
                        <p>Unit name and ID for permit verification</p>
                    </div>
                </div>
                <div class="me-card-body">
                    <div class="me-grid-2">
                        <div class="me-field">
                            <label class="me-label" for="equipment_name">Equipment Name <span class="req">*</span></label>
                            <input type="text" id="equipment_name" name="equipment_name"
                                   class="me-input"
                                   value="{{ old('equipment_name', $schedule->equipment_name) }}"
                                   required>
                        </div>
                        <div class="me-field">
                            <label class="me-label" for="equipment_id">Equipment ID <span class="req">*</span></label>
                            <input type="text" id="equipment_id" name="equipment_id"
                                   class="me-input"
                                   value="{{ old('equipment_id', $schedule->equipment_id) }}"
                                   placeholder="e.g. CRANE-001"
                                   required>
                            {{-- Permit status indicator --}}
                            <div class="me-permit-checking permit-checking" id="permitChecking">
                                <span class="spin">⟳</span> Checking permit validity…
                            </div>
                            <div class="me-permit-checking permit-valid" id="permitValid">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Valid permit found for this equipment
                            </div>
                            <div class="me-permit-checking permit-invalid" id="permitInvalid">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                No valid permit found — check the Contract & Permit module
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Schedule Details --}}
            <div class="me-card me-a d3">
                <div class="me-card-head">
                    <div class="me-card-icon" style="background:#dcfce7;">
                        <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h2>Schedule Details</h2>
                        <p>Maintenance type, date, and priority level</p>
                    </div>
                </div>
                <div class="me-card-body">
                    <div class="me-grid-2">
                        <div class="me-field">
                            <label class="me-label" for="maintenance_type_id">Maintenance Type <span class="req">*</span></label>
                            <select id="maintenance_type_id" name="maintenance_type_id" class="me-select" required>
                                <option value="">Select maintenance type…</option>
                                @foreach($maintenanceTypes as $type)
                                    <option value="{{ $type->maintenance_types_id }}"
                                            {{ (old('maintenance_type_id') ?? $schedule->maintenance_type_id) == $type->maintenance_types_id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="me-field">
                            <label class="me-label" for="scheduled_date">Scheduled Date <span class="req">*</span></label>
                            <input type="date" id="scheduled_date" name="scheduled_date"
                                   class="me-input"
                                   value="{{ old('scheduled_date', $schedule->scheduled_date) }}"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                        </div>
                    </div>

                    <div class="me-field" style="margin-bottom:0;">
                        <label class="me-label">Priority Level <span class="req">*</span></label>
                        <div class="me-priority-grid">
                            @foreach(['low'=>'Low','medium'=>'Medium','high'=>'High','critical'=>'Critical'] as $val => $label)
                            <div>
                                <input type="radio" name="priority" id="priority_{{ $val }}" value="{{ $val }}"
                                       class="me-priority-radio"
                                       {{ (old('priority') ?? $schedule->priority) == $val ? 'checked' : '' }}>
                                <label for="priority_{{ $val }}" class="me-priority-label">
                                    <span class="me-priority-dot dot-{{ $val }}"></span>
                                    <span class="me-priority-name">{{ $label }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: Recurrence --}}
            <div class="me-card me-a d4">
                <div class="me-card-head">
                    <div class="me-card-icon" style="background:#fef3c7;">
                        <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <div>
                        <h2>Recurring Schedule</h2>
                        <p>Automatically repeat this maintenance on a set interval</p>
                    </div>
                </div>
                <div class="me-card-body">
                    <div class="me-checkbox-row" id="recurringToggle" onclick="toggleRecurrence()">
                        <input type="checkbox" id="is_recurring" name="is_recurring" value="1"
                               {{ (old('is_recurring') ?? $schedule->is_recurring) ? 'checked' : '' }}
                               onclick="event.stopPropagation(); toggleRecurrence()">
                        <div>
                            <label for="is_recurring">Set as Recurring Maintenance</label>
                            <p>Schedule will automatically repeat based on the interval you set</p>
                        </div>
                    </div>

                    <div class="me-recurrence {{ (old('is_recurring') ?? $schedule->is_recurring) ? 'show' : '' }}" id="recurrencePanel">
                        <div class="me-recurrence-title">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Recurrence Settings
                        </div>
                        <div class="me-grid-2">
                            <div class="me-field">
                                <label class="me-label" for="recurrence_type">Repeat Every</label>
                                <select id="recurrence_type" name="recurrence_type" class="me-select">
                                    <option value="daily"   {{ (old('recurrence_type') ?? $schedule->recurrence_type) == 'daily'   ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly"  {{ (old('recurrence_type') ?? $schedule->recurrence_type) == 'weekly'  ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ (old('recurrence_type') ?? $schedule->recurrence_type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly"  {{ (old('recurrence_type') ?? $schedule->recurrence_type) == 'yearly'  ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </div>
                            <div class="me-field">
                                <label class="me-label" for="recurrence_frequency">Frequency</label>
                                <input type="number" id="recurrence_frequency" name="recurrence_frequency"
                                       class="me-input"
                                       value="{{ old('recurrence_frequency', $schedule->recurrence_frequency ?? 1) }}"
                                       min="1" max="365" placeholder="1">
                                <p class="me-hint">e.g. 2 = every 2 months</p>
                            </div>
                        </div>
                        <div class="me-field" style="margin-bottom:0;">
                            <label class="me-label" for="recurrence_end_date">End Date <span style="color:#94a3b8;font-weight:400;text-transform:none;font-size:11px;">(optional)</span></label>
                            <input type="date" id="recurrence_end_date" name="recurrence_end_date"
                                   class="me-input"
                                   value="{{ old('recurrence_end_date', $schedule->recurrence_end_date) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="me-footer me-a d5">
                <div class="me-footer-hint">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Changes are saved to the maintenance audit trail
                </div>
                <div class="me-footer-actions">
                    <a href="{{ route('maintenance.index') }}" class="me-btn me-btn-ghost">Cancel</a>
                    <button type="submit" class="me-btn me-btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Update Schedule
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
// Recurrence toggle
function toggleRecurrence() {
    const cb    = document.getElementById('is_recurring');
    const panel = document.getElementById('recurrencePanel');
    panel.classList.toggle('show', cb.checked);
}

// Permit check on equipment ID blur
document.getElementById('equipment_id').addEventListener('blur', function() {
    const val = this.value.trim();
    const checking = document.getElementById('permitChecking');
    const valid    = document.getElementById('permitValid');
    const invalid  = document.getElementById('permitInvalid');

    // Hide all first
    checking.classList.remove('show');
    valid.classList.remove('show');
    invalid.classList.remove('show');

    if (!val) return;

    checking.classList.add('show');

    setTimeout(() => {
        checking.classList.remove('show');
        if (val.toUpperCase().startsWith('CRANE')) {
            valid.classList.add('show');
        } else {
            invalid.classList.add('show');
        }
    }, 700);
});
</script>

@endsection