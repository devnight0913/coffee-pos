@props(['label', 'name', 'value' => '', 'formText' => null])

@php($id = uniqid())
<div class="mb-3">
    <x-label for="{{ $id }}" value="{{ $label }}" />
    <div class="input-group border rounded-1 @error($name) border-danger @enderror">
        <span class="input-group-text bg-white border-0 pe-1 text-muted"
            id="{{ $id }}">{{ $settings->productCurrency }}</span>
        @if (Auth::user()->is_cashier)
            <input type="text" id="{{ $id }}" name="{{ $name }}" disabled
                class="form-control input-number ps-1 focus-select-text border-0 @if ($settings->dir == 'rtl') text-start @endif @error($name) is-invalid @enderror"
                autocomplete="off" value="{{ $value }}" data-type="currency" placeholder="0.00" dir="ltr">
        @else
            <input type="text" id="{{ $id }}" name="{{ $name }}"
                    class="form-control input-number ps-1 focus-select-text border-0 @if ($settings->dir == 'rtl') text-start @endif @error($name) is-invalid @enderror"
                    autocomplete="off" value="{{ $value }}" data-type="currency" placeholder="0.00" dir="ltr">
        @endif
    </div>
    @error($name)
        <div class="text-danger small mt-1" role="alert">
            {{ $message }}
        </div>
    @else
        @if ($formText)
            <x-form-text>@lang($formText)</x-form-text>
        @endif
    @enderror
</div>
