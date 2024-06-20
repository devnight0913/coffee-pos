<form action="{{ route('settings.currency.update') }}" method="POST" role="form" class="py-3">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="currency_symbol" class="form-label">@lang('Currency Symbol')</label>
            <input type="text" name="currency_symbol"
                class="form-control @error('currency_symbol') is-invalid @enderror" id="currency_symbol"
                value="{{ old('currency_symbol', $currencySymbol) }}">
            @error('currency_symbol')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="currency_position" class="form-label">@lang('Currency Position')</label>
            <select name="currency_position" id="currency_position" class=" form-select">
                <option value=""></option>
                <option value="before" @selected(old('currency_position') == 'before' || $currencyPosition == 'before')>@lang('Before the amount')</option>
                <option value="after" @selected(old('currency_position') == 'after' || $currencyPosition == 'after')>@lang('After the amount')</option>
            </select>
            @error('currency_position')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="currency_thousand_separator" class="form-label">@lang('Currency Thousand Separator')</label>
            <input type="text" name="currency_thousand_separator"
                class="form-control @error('currency_thousand_separator') is-invalid @enderror"
                id="currency_thousand_separator"
                value="{{ old('currency_thousand_separator', $currencyThousandSeparator) }}">
            @error('currency_thousand_separator')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="currency_decimal_separator" class="form-label">@lang('Currency Decimal Separator')</label>
            <input type="text" name="currency_decimal_separator"
                class="form-control @error('currency_decimal_separator') is-invalid @enderror"
                id="currency_decimal_separator"
                value="{{ old('currency_decimal_separator', $currencyDecimalSeparator) }}">
            @error('currency_decimal_separator')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>


    <div class="mb-3">
        <label for="currency_precision" class="form-label">@lang('Currency Precision')</label>
        <select name="currency_precision" id="currency_precision" class=" form-select">
            <option value="0" @selected(old('currency_precision') == 0 || $currencyPrecision == 0)>
                0 @lang('numbers after the decimal')
            </option>
            <option value="1" @selected(old('currency_precision') == 1 || $currencyPrecision == 1)>
                1 @lang('numbers after the decimal')
            </option>
            <option value="2" @selected(old('currency_precision') == 2 || $currencyPrecision == 2)>
                2 @lang('numbers after the decimal')
            </option>
            <option value="3" @selected(old('currency_precision') == 3 || $currencyPrecision == 3)>
                3 @lang('numbers after the decimal')
            </option>
            <option value="4" @selected(old('currency_precision') == 4 || $currencyPrecision == 4)>
                4 @lang('numbers after the decimal')
            </option>
            <option value="5" @selected(old('currency_precision') == 5 || $currencyPrecision == 5)>
                5 @lang('numbers after the decimal')
            </option>
        </select>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input cursor-pointer" type="checkbox" value="" id="trailingZerosCheck"
            name="trailing_zeros" @checked($trailing_zeros)>
        <label class="form-check-label cursor-pointer" for="trailingZerosCheck">
            @lang('Show trailing zeros')
        </label>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary px-4">
            @lang('Save Settings')
        </button>
    </div>
</form>
