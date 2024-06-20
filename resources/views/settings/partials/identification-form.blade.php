<form action="{{ route('settings.identification.update') }}" method="POST" role="form" class="py-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="store_name" class="form-label">@lang('Store Name')</label>
        <input type="text" name="store_name" class="form-control @error('store_name') is-invalid @enderror"
            id="store_name" value="{{ old('store_name', $storeName) }}">
        @error('store_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-text">@lang('This will be shown on the receipt')</div>
    </div>
    <div class="mb-3">
        <label for="store_address" class="form-label">@lang('Store Address')</label>
        <input type="text" name="store_address" class="form-control @error('store_address') is-invalid @enderror"
            id="store_address" value="{{ old('store_address', $storeAddress) }}">
        @error('store_address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-text">@lang('This will be shown on the receipt')</div>
    </div>

    <div class="mb-3">
        <label for="store_phone" class="form-label">@lang('Store Phone')</label>
        <input type="text" name="store_phone" class="form-control @error('store_phone') is-invalid @enderror"
            id="store_phone" value="{{ old('store_phone', $storePhone) }}">
        @error('store_phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-text">@lang('This will be shown on the receipt')</div>
    </div>

    <div class="mb-3">
        <label for="store_website" class="form-label">@lang('Store Website')</label>
        <input type="text" name="store_website" class="form-control @error('store_website') is-invalid @enderror"
            id="store_website" value="{{ old('store_website', $storeWebsite) }}">
        @error('store_website')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-text">@lang('This will be shown on the receipt')</div>
    </div>

    <div class="mb-3">
        <label for="store_email" class="form-label">@lang('Store Email')</label>
        <input type="text" name="store_email" class="form-control @error('store_email') is-invalid @enderror"
            id="store_email" value="{{ old('store_email', $storeEmail) }}">
        @error('store_email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-text">@lang('This will be shown on the receipt')</div>
    </div>
    <div class="mb-3">
        <label for="store_additional_info" class="form-label">@lang('Store Additional Info')</label>
        <textarea name="store_additional_info" class="form-control @error('store_additional_info') is-invalid @enderror"
            id="store_additional_info">{{ old('store_additional_info', $storeAdditionalInfo) }}</textarea>
        @error('store_additional_info')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-text">@lang('This will be shown on the receipt')</div>
    </div>

    <div class="mb-3">
        <label for="logo" class="form-label">@lang('SVG Logo')</label>
        <textarea name="logo" class="form-control @error('logo') is-invalid @enderror"
            id="logo">{{ old('logo', $settings->logo) }}</textarea>
        @error('logo')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-text">@lang('This will be shown on the receipt')</div>
    </div>

    <div class="mb-3">
        <label for="lang" class="form-label">@lang('Language')</label>
        <select name="lang" id="lang" class="form-select">
            <option value="en" @selected($language == 'en')>English</option>
            <option value="ar" @selected($language == 'ar')>العربية</option>
        </select>
        @error('lang')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary px-4">@lang('Save Settings')</button>
</form>
