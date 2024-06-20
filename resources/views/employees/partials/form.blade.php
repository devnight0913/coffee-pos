<form action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}" method="POST"
    enctype="multipart/form-data" role="form">
    @csrf
    @isset($employee)
        @method('PUT')
    @endisset

    <div class="mb-3">
        <label for="name" class="form-label">@lang('Employee Name')</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name', isset($employee) ? $employee->name : '') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <x-number-input label="Price" name="price"
        value="{{ old('price', isset($employee) ? $employee->price : '') }}" />

    <div class="col-md-6 mb-3">
        <label for="date" class="form-label">@lang('Date')</label>
        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
            value="{{ old('date', now()->format('Y-m-d')) }}">
        @error('date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <x-save-btn>
            @lang(isset($employee) ? 'Update Employee' : 'Save Employee')
        </x-save-btn>
    </div>
</form>
