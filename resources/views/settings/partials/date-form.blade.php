<form action="{{ route('settings.date.update') }}" method="POST" role="form" class="py-3">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="date_format" class="form-label">@lang('Date Format')</label>
            <select name="date_format" id="date_format" class=" form-select">
                <option value="d.m.Y" @selected($dateFormat == 'd.m.Y')>{{ now()->format('d.m.Y') }}</option>
                <option value="d/m/Y" @selected($dateFormat == 'd/m/Y')>{{ now()->format('d/m/Y') }}</option>
                <option value="d F Y" @selected($dateFormat == 'd F Y')>{{ now()->format('d F Y') }}</option>
                <option value="d M Y" @selected($dateFormat == 'd M Y')>{{ now()->format('d M Y') }}</option>
                <option value="d-m-Y" @selected($dateFormat == 'd-m-Y')>{{ now()->format('d-m-Y') }}</option>
                <option value="m/d/Y" @selected($dateFormat == 'm/d/Y')>{{ now()->format('m/d/Y') }}</option>
                <option value="Y-m-d" @selected($dateFormat == 'Y-m-d')>{{ now()->format('Y-m-d') }}</option>
                <option value="Y/m/d" @selected($dateFormat == 'Y/m/d')>{{ now()->format('Y/m/d') }}</option>
            </select>
            @error('date_format')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="time_format" class="form-label">@lang('Time Format')</label>
            <select name="time_format" id="time_format" class=" form-select">
                <option value="H:i" @selected($timeFormat == 'H:i')>{{ now()->format('H:i') }}</option>
                <option value="H:i:s" @selected($timeFormat == 'H:i:s')>{{ now()->format('H:i:s') }}</option>
                <option value="h:i A" @selected($timeFormat == 'h:i A')>{{ now()->format('h:i A') }}</option>
                <option value="h:i:s A" @selected($timeFormat == 'h:i:s A')>{{ now()->format('h:i:s A') }}</option>
            </select>
            @error('time_format')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-12 mb-3">
            <label for="timezone" class="form-label">@lang('Timezone') {{ $timezone }}</label>
            <select name="timezone" id="timezone" class=" form-select">
                @foreach ($timezones as $key => $value)
                    <option value="{{ $key }}" @selected($timezone == $key)>{{ $value }}</option>
                @endforeach
            </select>
            @error('timezone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary px-4">
            @lang('Save Settings')
        </button>
    </div>
</form>
