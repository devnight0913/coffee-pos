@props(['label', 'name', 'value' => ''])

@php($id = uniqid())
<div class="mb-3">
    <x-label for="{{ $id }}" value="{{ $label }}" />
    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control @error($name) is-invalid @enderror">{{ $value }}</textarea>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
