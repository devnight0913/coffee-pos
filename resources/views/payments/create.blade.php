@extends('layouts.app')
@section('title', __('Create Payments'))

@section('content')

    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Create') @lang('Payment') </div>
        <x-back-btn href="{{ route('payments.index') }}" />
    </div>

    <x-card>

        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" role="form">
            @csrf

            <div class="mb-3">
                <label for="customer" class="form-label">@lang('Customer')</label>
                <select name="customer" id="customer" class=" form-select @error('customer') is-invalid @enderror">
                    <option value="" selected></option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->number }}</option>
                    @endforeach
                </select>
                @error('customer')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="employee" class="form-label">@lang('Employee')</label>
                <select name="employee" id="employee" class=" form-select @error('employee') is-invalid @enderror">
                    <option value="" selected></option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->price }}</option>
                    @endforeach
                </select>
                @error('employee')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="row">
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
                <div class="col-md-6 mb-3">
                    <label for="mode" class="form-label">@lang('Payment Mode')</label>
                    <select name="mode" id="mode" class=" form-select">
                        <option value="" selected></option>
                        @foreach ($modes as $mode)
                            <option value="{{ $mode }}">{{ $mode }}</option>
                        @endforeach
                    </select>
                    @error('mode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <x-currency-input label="Amount" name="amount" value="{{ old('amount') }}" />

            <div class="mb-3">
                <label for="comments" class="form-label">@lang('Comments')</label>
                <textarea name="comments" class="form-control @error('comments') is-invalid @enderror" id="comments" rows="3">{{ old('comments') }}</textarea>
                @error('comments')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <button class="btn btn-primary" type="submit">
                    @lang('Save')
                </button>
            </div>
        </form>

    </x-card>

@endsection
