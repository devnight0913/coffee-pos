@props(['label', 'name', 'value' => '', 'type' => 'text', 'formText' => null, 'id'])

@php($currentId = $id ?? uniqid())
<div class="mb-3">
    <x-label for="{{ $currentId }}" value="{{ $label }}" />
    <input type="{{ $type }}" id="{{ $currentId }}" name="{{ $name }}" value="{{ $value }}"
        class="form-control @error($name) is-invalid @enderror">
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @else
        @if ($formText)
            <x-form-text>@lang($formText)</x-form-text>
        @endif
    @enderror
</div>
