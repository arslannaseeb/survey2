<div class="form-group">
    <label for="{{ $attribute->label }}" class="col-md-4 control-label">{{ $attribute->label }}</label>
    <div class="col-md-6">
        <textarea class="form-control" maxlength="500" rows="5" cols="50" name="{{ $attribute->label . '_' . $attribute->id }}"> {{ count($attribute->surveySubmissions) > 0  ? trim($attribute->surveySubmissions->first()->pivot->value) : ''}}</textarea>
    </div>
</div>
