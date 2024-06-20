@php
    $statuses = ['Single', 'Married', 'Separated', 'Widow'];
@endphp

<label for="civil_status" class="form-label">@lang('Civil Status')</label>
<select class="form-select @error('civil_status') is-invalid @enderror" id="civil_status" name="civil_status">
    @isset($customer)
        <option value="" @if (is_null($customer->status)) selected @endif></option>
        @foreach ($statuses as $status)
            <option value="{{ $status }}" @if ($customer->civil_status == $status) selected @endif>
                {{ $status }}
            </option>
        @endforeach
    @else
        <option value="" selected></option>
        @foreach ($statuses as $status)
            <option value="{{ $status }}">{{ $status }}</option>
        @endforeach
    @endisset
</select>
@error('civil_status')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
