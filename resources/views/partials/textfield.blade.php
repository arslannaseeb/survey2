<div class="form-group">
    <label for="{{ $attribute->label }}" class="col-md-4 control-label">{{ $attribute->label }}</label>

    <div class="col-md-6">
        <input
               type="text"
               class="form-control"
               maxlength="150"
               name="{{ $attribute->label . '_' . $attribute->id }}"
               value="{{ count($attribute->surveySubmissions) > 0  ? $attribute->surveySubmissions->first()->pivot->value : '' }}">
    </div>
</div>
