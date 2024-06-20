<div class="row">
    <div class="col-md-12 mb-2 text-muted small">@lang('Other Info')</div>
    <div class="col-md-12 mb-3">
        <label for="tax_identification_number" class="form-label">@lang('Tax ID Number')</label>
        <input type="text" name="tax_identification_number"
            class="form-control @error('tax_identification_number') is-invalid @enderror" id="tax_identification_number"
            value="{{ old('tax_identification_number', isset($customer) ? $customer->tax_identification_number : '') }}">
        @error('tax_identification_number')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label for="notes" class="form-label">@lang('Notes')</label>
        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', isset($customer) ? $customer->notes : '') }}</textarea>

        @error('notes')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
