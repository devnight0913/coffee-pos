@extends('layouts.app')
@section('title', __('Create') . ' ' . __('Expenses'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Create') @lang('Expenses') </div>
        <x-back-btn href="{{ route('expenses.index') }}" />
    </div>
    <div class="card w-100">
        <div class="card-body">
            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data" role="form">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">@lang('Date')</label>
                        <input type="date" name="date"
                            class="form-control form-control-lg @error('date') is-invalid @enderror"
                            value="{{ old('date', now()->format('Y-m-d')) }}">
                        @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="mode" class="form-label">@lang('Payment Mode')</label>
                        <select name="mode" id="mode" class=" form-select form-select-lg">
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

                <div class="mb-3">
                    <label for="amount" class="form-label">@lang('Amount') ({{ $currency }})</label>
                    <input type="text" name="amount"
                        class="form-control form-control-lg input-number @error('amount') is-invalid @enderror @if ($settings->dir == 'rtl') text-start @endif"
                        dir="ltr" id="amount" value="{{ old('amount') }}">
                    @error('amount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">@lang('Reason')</label>
                    <textarea name="reason" id="reason" class="form-control form-control-lg" dir="auto" lang="{{ $settings->lang }}">{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comments" class="form-label">@lang('Comments')</label>
                    <textarea name="comments" id="comments" class="form-control form-control-lg" dir="auto"
                        lang="{{ $settings->lang }}">{{ old('comments') }}</textarea>
                    @error('comments')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
        
                <div class="mb-5">
                    <label for="receipt" class="form-label">@lang('Receipt')</label>
                    <input class="form-control @error('receipt') is-invalid @enderror" name="receipt" type="file"
                        id="receipt-input" accept="image/*,.doc,.docx,.pdf,.csv,.xlsx,.xls">
                    @error('receipt')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" type="submit">
                        @lang('Save')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
