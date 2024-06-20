<form action="{{ route('settings.pos.update') }}" method="POST" role="form" class="py-3">
    @csrf
    @method('PUT')
    <div class="form-check mb-3 user-select-none">
        <input class="form-check-input cursor-pointer" type="checkbox" name="enableTakeoutAndDelivery" value=""
            id="enableTakeoutAndDelivery" @checked($enableTakeoutAndDelivery)>
        <label class="form-check-label" for="enableTakeoutAndDelivery">
            @lang('Enable takeout and delivery feature')
        </label>
    </div>
    <div class="form-check mb-3 user-select-none">
        <input class="form-check-input cursor-pointer" type="checkbox" name="enableCashDrawer" value=""
            id="enableCashDrawer" @checked($enableCashDrawer)>
        <label class="form-check-label" for="enableCashDrawer">
            @lang('Enable cash drawer feature')
        </label>
    </div>

    

    <div class="mb-3">
        <label for="tax_rate" class="form-label">@lang('Default VAT') (%)</label>
        <input type="text" name="tax_rate"
            class="form-control input-number @error('tax_rate') is-invalid @enderror @if ($settings->dir == 'rtl') text-start @endif"
            dir="ltr" id="tax_rate" value="{{ old('tax_rate', $taxRate) }}">
        @error('tax_rate')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="vat_type" class="form-label">@lang('VAT Type')</label>
        <select name="vat_type" id="vat_type" class="form-select">
            <option value="exclude" @selected($vatType == 'exclude')>@lang('Exclude')</option>
            <option value="add" @selected($vatType == 'add')>@lang('Add')</option>
        </select>
        @error('vat_type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="delivery_charge" class="form-label">
            @lang('Default Delivery Charge Value') ({{ $currencySymbol }})
        </label>
        <input type="text" name="delivery_charge"
            class="form-control input-number @error('delivery_charge') is-invalid @enderror @if ($settings->dir == 'rtl') text-start @endif"
            dir="ltr" id="delivery_charge" value="{{ old('delivery_charge', $deliveryCharge) }}">
        @error('delivery_charge')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="discount" class="form-label">
            @lang('Default Discount Value') ({{ $currencySymbol }})
        </label>
        <input type="text" name="discount"
            class="form-control input-number @error('discount') is-invalid @enderror @if ($settings->dir == 'rtl') text-start @endif"
            dir="ltr" id="discount" value="{{ old('discount', $discount) }}">
        @error('discount')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-check mb-3 user-select-none">
        <input class="form-check-input cursor-pointer" type="checkbox" name="newItemAudio" value="" id="newItemAudio"
            @checked($newItemAudio)>
        <label class="form-check-label" for="newItemAudio">
            @lang('New Item Audio')
        </label>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary px-4">
            @lang('Save Settings')
        </button>
    </div>
</form>
