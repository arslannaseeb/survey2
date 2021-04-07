@php
    $dropdownValues = array_map('trim', explode(',', $attribute->label_value));
    $value = count($attribute->surveySubmissions) > 0  ? $attribute->surveySubmissions->first()->pivot->value : '';
@endphp
<div class="form-group">
    <label for="{{ $attribute->label }}" class="col-md-4 control-label">{{ $attribute->label }}</label>

    <div class="col-md-6">
        <select name="{{ $attribute->label . '_' . $attribute->id }}" class="form-control">
            <option value="">Select a value</option>
            @foreach ($dropdownValues as $dropdownValue)
                <option value="{{ $dropdownValue }}" {{ $value == $dropdownValue ? 'selected' : '' }}>{{  ucwords($dropdownValue) }}</option>
            @endforeach
        </select>
    </div>
</div>
