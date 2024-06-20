<div class="row">
    <div class="col-md-12 mb-2 text-muted small">@lang('Company Info')</div>
    <div class="col-md-12 mb-3">
        <label for="company_name" class="form-label">@lang('Company') @lang('Name')</label>
        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror"
            id="company_name" value="{{ old('company_name', isset($customer) ? $customer->company_name : '') }}">
        @error('company_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label for="company_street_address" class="form-label">@lang('Company') @lang('Address')</label>
        <input type="text" name="company_street_address"
            class="form-control @error('company_street_address') is-invalid @enderror" id="company_street_address"
            value="{{ old('company_street_address', isset($customer) ? $customer->company_street_address : '') }}">
        @error('company_street_address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="company_city" class="form-label">@lang('Company') @lang('City')</label>
        <input type="text" name="company_city" class="form-control @error('company_city') is-invalid @enderror"
            id="company_city" value="{{ old('company_city', isset($customer) ? $customer->company_city : '') }}">
        @error('company_city')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="company_state" class="form-label">@lang('Company') @lang('State')</label>
        <input type="text" name="company_state" class="form-control @error('company_state') is-invalid @enderror"
            id="company_state" value="{{ old('company_state', isset($customer) ? $customer->company_state : '') }}">
        @error('company_state')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        @include('customers.partials.company-country')
    </div>

    <div class="col-md-6 mb-3">
        <label for="company_zip_code" class="form-label">@lang('Company') @lang('Zip Code') </label>
        <input type="text" name="company_zip_code"
            class="form-control @error('company_zip_code') is-invalid @enderror" id="company_zip_code"
            value="{{ old('company_zip_code', isset($customer) ? $customer->company_zip_code : '') }}">
        @error('company_zip_code')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
