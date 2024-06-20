<div class="row">
    <div class="col-md-12 mb-2 text-muted small">@lang('Contact Info')</div>
    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">@lang('Email')</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
            value="{{ old('email', isset($customer) ? $customer->email : '') }}">
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="mobile" class="form-label">@lang('Mobile Number')</label>
        <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile"
            value="{{ old('mobile', isset($customer) ? $customer->mobile : '') }}">
        @error('mobile')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="telephone" class="form-label">@lang('Telephone Number')</label>
        <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
            id="telephone" value="{{ old('telephone', isset($customer) ? $customer->telephone : '') }}">
        @error('telephone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="fax" class="form-label">@lang('Fax')</label>
        <input type="text" name="fax" class="form-control @error('fax') is-invalid @enderror" id="fax"
            value="{{ old('fax', isset($customer) ? $customer->fax : '') }}">
        @error('fax')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

</div>
