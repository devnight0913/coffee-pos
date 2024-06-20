<form action="{{ isset($supplier) ? route('suppliers.update', $supplier) : route('suppliers.store') }}" method="POST"
    enctype="multipart/form-data" role="form">
    @csrf
    @isset($supplier)
        @method('PUT')
    @endisset

    <div class="mb-3">
        <label for="name" class="form-label">@lang('Name')</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name', isset($supplier) ? $supplier->name : '') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">@lang('Address')</label>
        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address"
            value="{{ old('address', isset($supplier) ? $supplier->address : '') }}">
        @error('address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">@lang('Phone Number')</label>
        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
            value="{{ old('phone', isset($supplier) ? $supplier->phone : '') }}">
        @error('phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">@lang('Email')</label>
        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
            value="{{ old('email', isset($supplier) ? $supplier->email : '') }}">
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="notes" class="form-label">@lang('Notes')</label>
        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="notes" rows="3">{{ old('notes', isset($supplier) ? $supplier->notes : null) }}</textarea>
        @error('notes')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button class="btn btn-primary btn-lg px-4" type="submit">
        @lang('Save')
    </button>
</form>
