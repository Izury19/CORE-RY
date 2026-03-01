@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
.mc-wrap * { box-sizing: border-box; }
.mc-wrap { font-family: 'DM Sans', sans-serif; color: #1e293b; background: #f8fafc; min-height: 100vh; }

/* Header */
.mc-header { background:#fff; border-bottom:1px solid #e2e8f0; padding:18px 32px; display:flex; align-items:center; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.mc-back { width:36px; height:36px; border-radius:9px; border:1.5px solid #e2e8f0; background:#f8fafc; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#64748b; text-decoration:none; transition:all .18s; flex-shrink:0; }
.mc-back:hover { border-color:#3b82f6; color:#3b82f6; background:#eff6ff; }
.mc-header-text h1 { font-family:'Outfit',sans-serif; font-size:20px; font-weight:800; color:#0f172a; letter-spacing:-0.02em; margin:0; }
.mc-header-text p  { font-size:13px; color:#94a3b8; margin:2px 0 0; }

/* Body */
.mc-body { max-width:860px; margin:0 auto; padding:28px 24px 60px; }

/* Error alert */
.mc-alert { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:14px 18px; border-radius:10px; margin-bottom:22px; font-size:13.5px; }
.mc-alert ul { margin:6px 0 0; padding-left:18px; }
.mc-alert li { margin-bottom:2px; }

/* Card */
.mc-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; margin-bottom:16px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.mc-card-head { padding:16px 24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
.mc-card-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.mc-card-head h2 { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin:0; }
.mc-card-head p  { font-size:12px; color:#94a3b8; margin:2px 0 0; }
.mc-card-body { padding:22px 24px; }

/* Grid */
.mc-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.mc-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; }

/* Fields */
.mc-field { margin-bottom:16px; }
.mc-field:last-child { margin-bottom:0; }
.mc-label { display:block; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#64748b; margin-bottom:6px; }
.mc-label .req { color:#ef4444; }
.mc-input, .mc-select, .mc-textarea {
    width:100%; height:42px; padding:0 13px;
    border:1.5px solid #e2e8f0; border-radius:9px;
    font-family:'DM Sans',sans-serif; font-size:13.5px; color:#1e293b;
    background:#f8fafc; outline:none;
    transition:border-color .18s, box-shadow .18s, background .18s;
}
.mc-input:focus, .mc-select:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); background:#fff; }
.mc-input::placeholder { color:#cbd5e1; }
.mc-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 13px center; background-color:#f8fafc; padding-right:36px; }
.mc-hint { font-size:11.5px; color:#94a3b8; margin-top:4px; }

/* Equipment preview */
.mc-equip-preview { display:none; margin-top:10px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:13px 16px; align-items:center; gap:12px; }
.mc-equip-preview.show { display:flex; }
.mc-equip-preview-icon { width:38px; height:38px; background:#dcfce7; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.mc-equip-preview-name { font-family:'Outfit',sans-serif; font-size:14px; font-weight:700; color:#0f172a; margin-bottom:2px; }
.mc-equip-preview-plate { font-size:12px; color:#16a34a; font-weight:500; }

/* Priority radio cards */
.mc-priority-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; }
.mc-priority-radio { display:none; }
.mc-priority-label {
    display:flex; flex-direction:column; align-items:center; gap:5px;
    padding:12px 8px; border:1.5px solid #e2e8f0; border-radius:10px;
    cursor:pointer; transition:all .18s; background:#f8fafc; text-align:center;
}
.mc-priority-label:hover { border-color:#93c5fd; background:#eff6ff; }
.mc-priority-radio:checked + .mc-priority-label { box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.mc-priority-radio[value="low"]:checked     + .mc-priority-label { border-color:#10b981; background:#f0fdf4; }
.mc-priority-radio[value="medium"]:checked  + .mc-priority-label { border-color:#f59e0b; background:#fffbeb; }
.mc-priority-radio[value="high"]:checked    + .mc-priority-label { border-color:#f97316; background:#fff7ed; }
.mc-priority-radio[value="critical"]:checked + .mc-priority-label { border-color:#ef4444; background:#fff1f2; }
.mc-priority-dot { width:10px; height:10px; border-radius:50%; }
.dot-low      { background:#10b981; }
.dot-medium   { background:#f59e0b; }
.dot-high     { background:#f97316; }
.dot-critical { background:#ef4444; }
.mc-priority-name { font-size:12px; font-weight:700; color:#1e293b; }

/* Checkbox toggle */
.mc-checkbox-row { display:flex; align-items:center; gap:10px; padding:14px 16px; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; cursor:pointer; transition:all .18s; }
.mc-checkbox-row:hover { border-color:#93c5fd; background:#eff6ff; }
.mc-checkbox-row input[type="checkbox"] { width:18px; height:18px; accent-color:#3b82f6; cursor:pointer; flex-shrink:0; }
.mc-checkbox-row label { font-size:13.5px; font-weight:600; color:#1e293b; cursor:pointer; margin:0; }
.mc-checkbox-row p { font-size:12px; color:#94a3b8; margin:0; }

/* Recurrence panel */
.mc-recurrence { background:#eff6ff; border:1px solid #bfdbfe; border-radius:11px; padding:18px; margin-top:14px; display:none; }
.mc-recurrence.show { display:block; }
.mc-recurrence-title { font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:#1d4ed8; margin-bottom:14px; display:flex; align-items:center; gap:7px; }

/* Add equipment mini card */
.mc-add-equip { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:18px 20px; margin-bottom:16px; }
.mc-add-equip-title { font-family:'Outfit',sans-serif; font-size:13px; font-weight:700; color:#15803d; margin-bottom:14px; display:flex; align-items:center; gap:7px; }

/* Footer */
.mc-footer { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:18px 24px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.mc-footer-hint { font-size:12px; color:#94a3b8; display:flex; align-items:center; gap:6px; }
.mc-footer-actions { display:flex; gap:10px; }
.mc-btn { display:inline-flex; align-items:center; gap:7px; padding:10px 20px; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all .18s; text-decoration:none; }
.mc-btn-primary { background:#3b82f6; color:#fff; }
.mc-btn-primary:hover { background:#2563eb; transform:translateY(-1px); box-shadow:0 4px 12px rgba(59,130,246,.28); }
.mc-btn-ghost { background:#f1f5f9; color:#64748b; }
.mc-btn-ghost:hover { background:#e2e8f0; }

/* Animations */
@keyframes mcFU { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
.mc-a  { animation:mcFU .35s ease both; }
.d1{animation-delay:.03s} .d2{animation-delay:.07s} .d3{animation-delay:.11s}
.d4{animation-delay:.15s} .d5{animation-delay:.19s} .d6{animation-delay:.23s}

/* Responsive */
@media(max-width:700px) {
    .mc-grid-2 { grid-template-columns:1fr; }
    .mc-grid-3 { grid-template-columns:1fr; }
    .mc-priority-grid { grid-template-columns:repeat(2,1fr); }
    .mc-body { padding:18px 14px 40px; }
    .mc-header { padding:14px 18px; }
    .mc-footer { flex-direction:column; gap:12px; }
    .mc-footer-actions { width:100%; }
    .mc-btn { flex:1; justify-content:center; }
}
</style>

<div class="mc-wrap">

    {{-- Header --}}
    <div class="mc-header">
        <a href="{{ route('maintenance.index') }}" class="mc-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div class="mc-header-text">
            <h1>Add Maintenance Schedule</h1>
            <p>Create a new scheduled maintenance entry for an equipment unit</p>
        </div>
    </div>

    <div class="mc-body">

        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="mc-alert mc-a d1">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ── ADD EQUIPMENT (quick form) ── --}}
        <div class="mc-add-equip mc-a d1">
            <div class="mc-add-equip-title">
                <svg width="15" height="15" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Don't see your equipment? Add it here first
            </div>
            <form action="{{ route('equipment.store') }}" method="POST">
                @csrf
                <div class="mc-grid-3">
                    <div class="mc-field">
                        <label class="mc-label">Equipment Name</label>
                        <input type="text" name="name" class="mc-input" placeholder="e.g. Liebherr LTM 1200">
                    </div>
                    <div class="mc-field">
                        <label class="mc-label">Plate Number</label>
                        <input type="text" name="plate_number" class="mc-input" placeholder="e.g. ABC-123">
                    </div>
                    <div class="mc-field" style="display:flex; align-items:flex-end;">
                        <button type="submit" class="mc-btn mc-btn-primary" style="width:100%; justify-content:center;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Add Equipment
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ── MAIN SCHEDULE FORM ── --}}
        <form action="{{ route('maintenance.store') }}" method="POST">
            @csrf

            {{-- SECTION 1: Equipment --}}
            <div class="mc-card mc-a d2">
                <div class="mc-card-head">
                    <div class="mc-card-icon" style="background:#dbeafe;">
                        <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2>Equipment Selection</h2>
                        <p>Choose the unit that requires maintenance</p>
                    </div>
                </div>
                <div class="mc-card-body">
                    <div class="mc-field">
                        <label class="mc-label" for="equipment_name">Equipment Unit <span class="req">*</span></label>
                        <select id="equipment_name" name="equipment_name" class="mc-select" required onchange="updateEquipmentPreview()">
                            <option value="">Select available equipment…</option>
                            @foreach($availableEquipment as $equipment)
                                <option value="{{ $equipment->name }}"
                                        data-plate="{{ $equipment->plate_number }}"
                                        {{ old('equipment_name') == $equipment->name ? 'selected' : '' }}>
                                    {{ $equipment->name }} — {{ $equipment->plate_number }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Equipment preview --}}
                        <div class="mc-equip-preview" id="equipPreview">
                            <div class="mc-equip-preview-icon">
                                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <div class="mc-equip-preview-name" id="previewName">—</div>
                                <div class="mc-equip-preview-plate" id="previewPlate">—</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Schedule Details --}}
            <div class="mc-card mc-a d3">
                <div class="mc-card-head">
                    <div class="mc-card-icon" style="background:#dcfce7;">
                        <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h2>Schedule Details</h2>
                        <p>Maintenance type, date, and priority level</p>
                    </div>
                </div>
                <div class="mc-card-body">
                    <div class="mc-grid-2">
                        <div class="mc-field">
                            <label class="mc-label" for="maintenance_type_id">Maintenance Type <span class="req">*</span></label>
                            <select id="maintenance_type_id" name="maintenance_type_id" class="mc-select" required>
                                <option value="">Select maintenance type…</option>
                                @foreach($maintenanceTypes as $type)
                                    <option value="{{ $type->maintenance_types_id }}"
                                            {{ old('maintenance_type_id') == $type->maintenance_types_id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mc-field">
                            <label class="mc-label" for="scheduled_date">Scheduled Date <span class="req">*</span></label>
                            <input type="date" id="scheduled_date" name="scheduled_date"
                                   class="mc-input"
                                   value="{{ old('scheduled_date') }}"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                        </div>
                    </div>

                    <div class="mc-field" style="margin-bottom:0;">
                        <label class="mc-label">Priority Level <span class="req">*</span></label>
                        <div class="mc-priority-grid">
                            @foreach(['low'=>'Low','medium'=>'Medium','high'=>'High','critical'=>'Critical'] as $val => $label)
                            <div>
                                <input type="radio" name="priority" id="priority_{{ $val }}" value="{{ $val }}"
                                       class="mc-priority-radio"
                                       {{ old('priority','medium') == $val ? 'checked' : '' }}>
                                <label for="priority_{{ $val }}" class="mc-priority-label">
                                    <span class="mc-priority-dot dot-{{ $val }}"></span>
                                    <span class="mc-priority-name">{{ $label }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: Recurrence --}}
            <div class="mc-card mc-a d4">
                <div class="mc-card-head">
                    <div class="mc-card-icon" style="background:#fef3c7;">
                        <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <div>
                        <h2>Recurring Schedule</h2>
                        <p>Automatically repeat this maintenance on a set interval</p>
                    </div>
                </div>
                <div class="mc-card-body">
                    <div class="mc-checkbox-row" onclick="toggleRecurrence()" id="recurringToggle">
                        <input type="checkbox" id="is_recurring" name="is_recurring" value="1"
                               {{ old('is_recurring') ? 'checked' : '' }}
                               onclick="event.stopPropagation(); toggleRecurrence()">
                        <div>
                            <label for="is_recurring">Set as Recurring Maintenance</label>
                            <p>Schedule will automatically repeat based on the interval you set</p>
                        </div>
                    </div>

                    <div class="mc-recurrence {{ old('is_recurring') ? 'show' : '' }}" id="recurrencePanel">
                        <div class="mc-recurrence-title">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Recurrence Settings
                        </div>
                        <div class="mc-grid-2">
                            <div class="mc-field">
                                <label class="mc-label" for="recurrence_type">Repeat Every</label>
                                <select id="recurrence_type" name="recurrence_type" class="mc-select">
                                    <option value="daily"   {{ old('recurrence_type')=='daily'   ?'selected':'' }}>Daily</option>
                                    <option value="weekly"  {{ old('recurrence_type')=='weekly'  ?'selected':'' }}>Weekly</option>
                                    <option value="monthly" {{ old('recurrence_type','monthly')=='monthly' ?'selected':'' }}>Monthly</option>
                                    <option value="yearly"  {{ old('recurrence_type')=='yearly'  ?'selected':'' }}>Yearly</option>
                                </select>
                            </div>
                            <div class="mc-field">
                                <label class="mc-label" for="recurrence_frequency">Frequency</label>
                                <input type="number" id="recurrence_frequency" name="recurrence_frequency"
                                       class="mc-input"
                                       value="{{ old('recurrence_frequency', 1) }}"
                                       min="1" max="365"
                                       placeholder="1">
                                <p class="mc-hint">e.g. 2 = every 2 months</p>
                            </div>
                        </div>
                        <div class="mc-field" style="margin-bottom:0;">
                            <label class="mc-label" for="recurrence_end_date">End Date <span style="color:#94a3b8;font-weight:400;text-transform:none;font-size:11px;">(optional — leave blank to repeat indefinitely)</span></label>
                            <input type="date" id="recurrence_end_date" name="recurrence_end_date"
                                   class="mc-input"
                                   value="{{ old('recurrence_end_date') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="mc-footer mc-a d5">
                <div class="mc-footer-hint">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    All schedules are logged in the maintenance audit trail
                </div>
                <div class="mc-footer-actions">
                    <a href="{{ route('maintenance.index') }}" class="mc-btn mc-btn-ghost">Cancel</a>
                    <button type="submit" class="mc-btn mc-btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Create Schedule
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
// Equipment preview
function updateEquipmentPreview() {
    const select = document.getElementById('equipment_name');
    const preview = document.getElementById('equipPreview');
    const nameEl  = document.getElementById('previewName');
    const plateEl = document.getElementById('previewPlate');
    const opt = select.options[select.selectedIndex];

    if (select.value) {
        nameEl.textContent  = select.value;
        plateEl.textContent = 'Plate: ' + (opt.getAttribute('data-plate') || 'N/A');
        preview.classList.add('show');
    } else {
        preview.classList.remove('show');
    }
}

// Recurrence toggle
function toggleRecurrence() {
    const cb    = document.getElementById('is_recurring');
    const panel = document.getElementById('recurrencePanel');
    panel.classList.toggle('show', cb.checked);
}

document.addEventListener('DOMContentLoaded', function() {
    updateEquipmentPreview();
    // Ensure panel state matches checkbox on load (for old() values)
    const cb = document.getElementById('is_recurring');
    document.getElementById('recurrencePanel').classList.toggle('show', cb.checked);
});
</script>

@endsection