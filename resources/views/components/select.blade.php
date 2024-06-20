@props(['label', 'name', 'value' => '', 'formText' => null, 'searchable' => false])

@php($id = uniqid())

<div class="mb-3">
    @if ($label)
        <x-label for="select-{{ $id }}" value="{{ $label }}" />
    @endif
    <select class="form-select @error($name) is-invalid @enderror" id="select-{{ $id }}"
        name="{{ $name }}">
        {{ $slot }}
    </select>
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
@if ($searchable)
    @push('script')
        <script>
            $(document).ready(function() {
                $('#select-{{ $id }}').select2({
                    theme: "bootstrap-5",
                    dropdownAutoWidth: true,
                    lang: "{{ $settings->lang }}",
                    dir: "{{ $settings->dir }}"
                });
            });
        </script>
    @endpush
@endif
