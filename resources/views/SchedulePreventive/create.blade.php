@extends('layouts.app')

@section('content')
<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    overflow: hidden;
}
.form-header {
    background: #f8fafc;
    padding: 24px;
    border-bottom: 1px solid #e2e8f0;
}
.form-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.form-body {
    padding: 24px;
}
.form-group {
    margin-bottom: 1.5rem;
}
.form-label {
    display: block;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}
.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: border-color 0.2s ease;
}
.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Equipment select styling */
.equipment-select {
    position: relative;
}
.equipment-select select {
    appearance: none;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 9l4-4 4 4m0 6l-4 4-4-4' /%3E%3C/svg%3E") no-repeat right 0.5rem center/1rem;
    padding-right: 2rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.checkbox-group input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}
.recurrence-section {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 8px;
    margin-top: 1rem;
    border-left: 3px solid #3b82f6;
}
.submit-button {
    background: #3b82f6;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background 0.2s ease;
}
.submit-button:hover {
    background: #2563eb;
}
.cancel-link {
    display: inline-block;
    color: #64748b;
    text-decoration: none;
    margin-left: 1rem;
    font-weight: 500;
}
.cancel-link:hover {
    color: #334155;
}

/* Equipment preview container */
.equipment-preview {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 0.5rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}
.equipment-preview img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}
.equipment-preview .equipment-info {
    flex: 1;
}
.equipment-preview h4 {
    font-size: 0.875rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    color: #1e293b;
}
.equipment-preview p {
    font-size: 0.75rem;
    color: #64748b;
    margin: 0;
}

/* Add Equipment Form */
.add-equipment-section {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border-left: 3px solid #10b981;
}
</style>

<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add New Maintenance Schedule
        </h1>
    </div>
    
    <div class="form-body">
        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
                <strong>Error:</strong>
                <ul style="margin: 0.5rem 0 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ADD NEW EQUIPMENT SECTION -->
        <div class="add-equipment-section">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Add New Equipment</h3>
            <form action="{{ route('equipment.store') }}" method="POST" class="form-row">
                @csrf
                <div class="form-group">
                    <label class="form-label">Equipment Name</label>
                    <input type="text" 
                           name="name" 
                           required 
                           class="form-control"
                           placeholder="e.g., Liebherr LTM 11200 Crane">
                </div>
                <div class="form-group">
                    <label class="form-label">Plate Number</label>
                    <input type="text" 
                           name="plate_number" 
                           required 
                           class="form-control"
                           placeholder="e.g., ABC-123">
                </div>
                <div class="form-group" style="display: flex; align-items: flex-end;">
                    <button type="submit" 
                            class="submit-button"
                            style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        + Add Equipment
                    </button>
                </div>
            </form>
        </div>

        <!-- MAINTENANCE SCHEDULE FORM -->
        <form action="{{ route('maintenance.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="equipment_name">Equipment Name *</label>
                <div class="equipment-select">
                    <select id="equipment_name" name="equipment_name" class="form-control" required onchange="updateEquipmentPreview()">
                        <option value="">Select Available Equipment</option>
                        @foreach($availableEquipment as $equipment)
                            <option value="{{ $equipment->name }}" 
                                    data-image="{{ asset('images/' . strtolower(str_replace(' ', '-', $equipment->name)) . '.jpg') }}"
                                    data-plate="{{ $equipment->plate_number }}"
                                    {{ old('equipment_name') == $equipment->name ? 'selected' : '' }}>
                                {{ $equipment->name }} ({{ $equipment->plate_number }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Equipment Preview -->
                <div id="equipmentPreview" class="equipment-preview" style="display: none;">
                    <img id="equipmentImage" src="" alt="Equipment Image">
                    <div class="equipment-info">
                        <h4 id="equipmentTitle"></h4>
                        <p id="equipmentDescription"></p>
                        <p id="equipmentPlate" style="font-size: 0.75rem; color: #64748b; margin: 0;"></p>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="maintenance_type_id">Maintenance Type *</label>
                    <select id="maintenance_type_id" 
                            name="maintenance_type_id" 
                            class="form-control"
                            required>
                        <option value="">Select Maintenance Type</option>
                        @foreach($maintenanceTypes as $type)
                            <option value="{{ $type->maintenance_types_id }}" 
                                    {{ old('maintenance_type_id') == $type->maintenance_types_id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="scheduled_date">Scheduled Date *</label>
                    <input type="date" 
                           id="scheduled_date" 
                           name="scheduled_date" 
                           class="form-control"
                           value="{{ old('scheduled_date') }}"
                           min="{{ date('Y-m-d') }}"
                           required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="priority">Priority *</label>
                    <select id="priority" 
                            name="priority" 
                            class="form-control"
                            required>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" 
                           id="is_recurring" 
                           name="is_recurring" 
                           value="1"
                           {{ old('is_recurring') ? 'checked' : '' }}>
                    <label for="is_recurring" style="font-weight: normal; color: #475569;">
                        Set as Recurring Maintenance
                    </label>
                </div>
            </div>

            <div id="recurrence-section" class="recurrence-section" style="display: none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="recurrence_type">Recurrence Type</label>
                        <select id="recurrence_type" 
                                name="recurrence_type" 
                                class="form-control">
                            <option value="daily" {{ old('recurrence_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ old('recurrence_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('recurrence_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('recurrence_type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="recurrence_frequency">Frequency</label>
                        <input type="number" 
                               id="recurrence_frequency" 
                               name="recurrence_frequency" 
                               class="form-control"
                               value="{{ old('recurrence_frequency', 1) }}"
                               min="1"
                               max="365">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="recurrence_end_date">End Date (Optional)</label>
                    <input type="date" 
                           id="recurrence_end_date" 
                           name="recurrence_end_date" 
                           class="form-control"
                           value="{{ old('recurrence_end_date') }}">
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="submit-button">
                    Create Schedule
                </button>
                <a href="{{ route('maintenance.index') }}" class="cancel-link">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Equipment descriptions
const equipmentDescriptions = {
    'Liebherr LTM 11200 Crane': 'World\'s strongest telescopic crane with 1200-ton capacity',
    'Tadano TG-500E Mobile Crane': 'All-terrain mobile crane with excellent maneuverability',
    'Kobelco CK-500G Tower Crane': 'Heavy-duty tower crane for high-rise construction',
    'Zoomlion ZTC250': 'Rough terrain crane with 25-ton lifting capacity',
    'Manitowoc MLC300': 'Compact crawler crane ideal for confined spaces'
};

function updateEquipmentPreview() {
    const select = document.getElementById('equipment_name');
    const preview = document.getElementById('equipmentPreview');
    const image = document.getElementById('equipmentImage');
    const title = document.getElementById('equipmentTitle');
    const description = document.getElementById('equipmentDescription');
    const plate = document.getElementById('equipmentPlate');
    
    const selectedOption = select.options[select.selectedIndex];
    const selectedValue = select.value;
    const imageUrl = selectedOption.getAttribute('data-image');
    const plateNumber = selectedOption.getAttribute('data-plate');
    
    if (selectedValue && imageUrl) {
        image.src = imageUrl;
        title.textContent = selectedValue;
        description.textContent = equipmentDescriptions[selectedValue] || 'Professional heavy equipment';
        plate.textContent = plateNumber ? 'Plate: ' + plateNumber : '';
        preview.style.display = 'flex';
    } else {
        preview.style.display = 'none';
    }
}

// Initialize preview if there's old data
document.addEventListener('DOMContentLoaded', function() {
    const recurringCheckbox = document.getElementById('is_recurring');
    const recurrenceSection = document.getElementById('recurrence-section');
    
    if (recurringCheckbox.checked) {
        recurrenceSection.style.display = 'block';
    }
    
    recurringCheckbox.addEventListener('change', function() {
        recurrenceSection.style.display = this.checked ? 'block' : 'none';
    });
    
    // Initialize equipment preview
    updateEquipmentPreview();
});
</script>
@endsection