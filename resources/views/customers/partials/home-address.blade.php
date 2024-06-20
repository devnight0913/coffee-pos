<div class="row">
    <div class="col-md-12 mb-2 text-muted small">@lang('Address')</div>

    <div class="col-md-12 mb-3">
        <label for="city" class="form-label">@lang('City')</label>
        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="city"
            value="{{ old('city', isset($customer) ? $customer->city : '') }}">
        @error('city')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="street_address" class="form-label">@lang('Street')</label>
        <input type="text" name="street_address" class="form-control @error('street_address') is-invalid @enderror"
            id="street_address" value="{{ old('street_address', isset($customer) ? $customer->street_address : '') }}">
        @error('street_address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="building" class="form-label">@lang('Building')</label>
        <input type="text" name="building" class="form-control @error('building') is-invalid @enderror"
            id="building" value="{{ old('building', isset($customer) ? $customer->building : '') }}">
        @error('building')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="floor" class="form-label">@lang('Floor')</label>
        <input type="text" name="floor" class="form-control @error('floor') is-invalid @enderror" id="floor"
            value="{{ old('floor', isset($customer) ? $customer->floor : '') }}">
        @error('floor')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="apartment" class="form-label">@lang('Apartment')</label>
        <input type="text" name="apartment" class="form-control @error('apartment') is-invalid @enderror" id="apartment"
            value="{{ old('apartment', isset($customer) ? $customer->apartment : '') }}">
        @error('apartment')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="state" class="form-label">@lang('State')</label>
        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" id="state"
            value="{{ old('state', isset($customer) ? $customer->state : '') }}">
        @error('state')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        @include('customers.partials.home-address-country')
    </div>

    <div class="col-md-6 mb-3">
        <label for="zip_code" class="form-label">@lang('Zip Code')</label>
        <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror"
            id="zip_code" value="{{ old('zip_code', isset($customer) ? $customer->zip_code : '') }}">
        @error('zip_code')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
