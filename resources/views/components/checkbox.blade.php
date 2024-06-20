@props(['label', 'name', 'checked' => false])

@php($id = uniqid())

<div class="form-check mb-3">
    <input class="form-check-input cursor-pointer" type="checkbox" value="" name="{{ $name }}"
        id="{{ $id }}" @checked($checked)>
    <label class="form-check-label" for="{{ $id }}">
        @lang($label)
    </label>
</div>
