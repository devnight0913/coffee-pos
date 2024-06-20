<form action="{{ route('settings.exchange-rate.update') }}" method="POST" role="form" class="py-3">
    @csrf
    @method('PUT')
    <div class="form-check mb-3 user-select-none">
        <input class="form-check-input cursor-pointer" type="checkbox" value="" id="enableExchangeRateForItemsCheck"
            name="enableExchangeRateForItems" @checked($enableExchangeRateForItems)>
        <label class="form-check-label" for="enableExchangeRateForItemsCheck">
            @lang('Enable exchange rate for items')
        </label>
    </div>

    <div class="mb-3">
        <label for="exchange_rate_currency_symbol" class="form-label">@lang('Currency')</label>
        <input type="text" name="exchange_rate_currency_symbol"
            class="form-control @error('exchange_rate_currency_symbol') is-invalid @enderror"
            id="exchange_rate_currency_symbol"
            value="{{ old('exchange_rate_currency_symbol', $exchangeRateCurrencySymbol) }}">
        @error('exchange_rate_currency_symbol')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exchange_rate_value" class="form-label">@lang('Exchange Rate')</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">1 {{ $currencySymbol }} = </span>
            <input type="text" name="exchange_rate_value"
            class="form-control input-number @error('exchange_rate_value') is-invalid @enderror @if ($settings->dir == 'rtl') text-start @endif"
            dir="ltr" id="exchange_rate_value" value="{{ old('exchange_rate_value', $exchangeRateValue) }}">
        </div>
        @error('exchange_rate_value')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-check mb-3 user-select-none">
        <input class="form-check-input cursor-pointer" type="checkbox" value=""
            id="showExchangeRateOnReceiptCheck" name="showExchangeRateOnReceipt" @checked($showExchangeRateOnReceipt)>
        <label class="form-check-label" for="showExchangeRateOnReceiptCheck">
            @lang('Show Exchange Rate On Receipt')
        </label>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary px-4">
            @lang('Save Settings')
        </button>
    </div>
</form>
