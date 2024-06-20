<form
    action="{{ isset($payment) ? route('customers.payments.update', [$customer, $payment]) : route('customers.payments.store', $customer) }}"
    method="POST" enctype="multipart/form-data" role="form">
    @csrf
    @isset($payment)
        @method('PUT')
    @endisset
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="date" class="form-label">@lang('Date')</label>
            <input type="date" name="date"
                class="form-control form-control-lg @error('date') is-invalid @enderror"
                value="{{ old('date', isset($payment) ? $payment->date : now()->format('Y-m-d')) }}">
            @error('date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="mode" class="form-label">@lang('Payment Mode')</label>
            <select name="mode" id="mode" class=" form-select form-select-lg">
                @isset($payment)
                    <option value="" @if (is_null($payment->mode)) selected @endif></option>
                    @foreach ($modes as $mode)
                        <option value="{{ $mode }}" @if ($payment->mode == $mode) selected @endif>
                            {{ $mode }}
                        </option>
                    @endforeach
                @else
                    <option value="" selected></option>
                    @foreach ($modes as $mode)
                        <option value="{{ $mode }}">{{ $mode }}</option>
                    @endforeach
                @endisset
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
            class="form-control input-number form-control-lg @error('amount') is-invalid @enderror @if ($settings->dir == 'rtl') text-start @endif"
            dir="ltr" id="amount" value="{{ old('amount', isset($payment) ? $payment->amount : '') }}">
        @error('amount')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="comments" class="form-label">@lang('Comments')</label>
        <textarea name="comments" class="form-control @error('comments') is-invalid @enderror" id="comments" rows="3">{{ old('comments', isset($payment) ? $payment->comments : '') }}</textarea>
        @error('comments')
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
