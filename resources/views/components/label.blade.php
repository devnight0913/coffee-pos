@props(['value', 'for'])
<label for="{{ $for }}" class="form-label">@lang($value ?? '')</label>
