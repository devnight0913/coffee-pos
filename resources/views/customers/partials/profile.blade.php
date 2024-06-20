<div class="row">
    <div class="col-md-12 mb-2 text-muted small">@lang('Profile')</div>
    <div class="col-md-12 mb-3">
        <label for="name" class="form-label">@lang('Name')*</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name', isset($customer) ? $customer->name : '') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="birthday" class="form-label">@lang('Birthday')</label>
        <input type="date" name="birthday" class="form-control @error('birthday') is-invalid @enderror"
            id="birthday" value="{{ old('birthday', isset($customer) ? $customer->birthday : '') }}">
        @error('birthday')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <div class="col-md-6 mb-3">
        <label for="gender" class="form-label">@lang('Gender')</label>
        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
            @isset($customer)
                <option value="" @if (is_null($customer->gender)) selected @endif></option>
                <option value="male" @if ($customer->is_male) selected @endif>@lang('Male')</option>
                <option value="female" @if (!$customer->is_female) selected @endif>@lang('Female')</option>
            @else
                <option value="" selected></option>
                <option value="male">@lang('Male')</option>
                <option value="female">@lang('Female')</option>
            @endisset
        </select>
        @error('gender')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        @include('customers.partials.civil-status')
    </div>

    <div class="col-md-6 mb-3">
        @include('customers.partials.nationality')
    </div>

</div>
