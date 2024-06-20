{{-- <div class="d-flex flex-column">
    <div class="overflow-x-auto">
        <div class="d-inline-block" style="min-width: 100%;">
            <div class="position-relative overflow-hidden rounded-3 border bg-white shadow-sm">
           
            </div>
        </div>
    </div>
</div> --}}
@props(['id'])

@php($currentId = $id ?? uniqid())

<div class=" table-responsive">
    <table class="table table-hover table-striped mb-0 align-middle w-100" style="min-width: 100%;"
        id="{{ $currentId }}">
        {{ $slot }}
    </table>
</div>
