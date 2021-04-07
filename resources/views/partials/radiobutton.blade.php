@php
    $radioValues = array_map('trim', explode(',', $attribute->label_value));
    $value = count($attribute->surveySubmissions) > 0  ? $attribute->surveySubmissions->first()->pivot->value : '';
@endphp
<div class="form-group">
    <label for="{{ $attribute->label }}" class="col-md-4 control-label">{{ $attribute->label }}</label>
        @foreach($radioValues as $radioValue)
        <div class="col-md-2">
            <input
                type="radio"
                name="{{ $attribute->label . '_' . $attribute->id }}"
                value="{{ $radioValue }}"
                {{ $value == $radioValue ? 'checked=checked' : '' }}>
            {{ $radioValue }}
        </div>
        @endforeach
</div>
