@php
$checkboxValues = array_map('trim', explode(',', $attribute->label_value));
$values = count($attribute->surveySubmissions) > 0  ? array_map('trim', explode(',', $attribute->surveySubmissions->first()->pivot->value)) : [];
@endphp
<div class="form-group">
    <label for="{{ $attribute->label }}" class="col-md-4 control-label">{{ $attribute->label }}</label>
    @foreach($checkboxValues as $checkboxValue)
        <div class="col-md-2">
            <input
                    type="checkbox"
                    name="{{ $attribute->label . '_' . $attribute->id }}[]"
                    value="{{ $checkboxValue }}"
                    {{ in_array($checkboxValue, $values) ? 'checked=checked' : '' }}>
            {{ $checkboxValue }}
        </div>
    @endforeach
</div>
