@props(['label', 'name', 'value' => '', 'formText' => null])

@php($id = uniqid())
<div class="mb-3">
    <x-label for="{{ $id }}" value="{{ $label }}" />
    <input type="text" id="{{ $id }}" name="{{ $name }}"
        class="form-control input-number focus-select-text @if ($settings->dir == 'rtl') text-start @endif @error($name) is-invalid @enderror"
        autocomplete="off" value="{{ $value }}" placeholder="0" dir="ltr">
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
