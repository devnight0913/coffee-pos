@extends('layouts.app')
@section('title', __('Recipe'))

@section('content')

    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="flex-grow-1">
            <x-page-title>@lang('recipe')</x-page-title>
        </div>
        <a href="{{ route('recipe.create') }}"
            class="btn btn-primary btn-ic @if (!Auth::user()->can_create) disabled @endif">
            <x-heroicon-o-plus class="hero-icon-sm me-2 text-white" />
            @lang('Add Recipe')
        </a>
    </div>
    <x-card>
        <x-table id="recipe-table">
            <x-thead>
                <tr>
                    <!-- <x-th>@lang('Category Name')</x-th> -->
                    <x-th>@lang('Recipe Name')</x-th>
                    <x-th>@lang('Cost')</x-th>
                    <x-th>@lang('Price')</x-th>
                    <x-th>@lang('Description')</x-th>
                    <x-th>@lang('status.text')</x-th>
                    <x-th></x-th>
                </tr>
            </x-thead>
        </x-table>
    </x-card>
@endsection
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            let dataTable = $('#recipe-table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: '{{ asset("datatables/i18n/{$settings->lang}.json") }}',
                },
                ajax: {
                    url: "{{ route('api.recipe.index') }}",
                    dataSrc: 'data'
                },
                columns: [{
                        data: "name",
                        render: function(data, type, row) {
                            return '<div class=" d-flex align-items-center">' +
                                `<div class="fw-bold">${ row.name}</div>` +
                                `</div>`
                        }
                    },
                    {
                        data: 'cost'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: 'description',
                        orderable: false
                    },
                    {
                        data: "is_active",
                        render: function(data, type, row) {
                            return `<span class="badge rounded-0 text-uppercase text-xs fw-normal ${row.status_badge_bg_color}">${row.status}</span>`
                        }
                    },
                    {
                        orderable: false,
                        data: function(data, type, dataToSet) {
                            var editUrl = "{{ route('recipe.edit', ':id') }}";
                            var deleteUrl = "{{ route('recipe.destroy', ':id') }}";
                            editUrl = editUrl.replace(':id', data.id);
                            deleteUrl = deleteUrl.replace(':id', data.id);
                            return `<div class="dropdown d-flex">` +
                                `<button class="btn btn-link  text-black p-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">` +
                                `<x-heroicon-o-ellipsis-horizontal class="hero-icon" />` +
                                `</button>` +
                                `<x-dropdown-menu class="dropdown-menu-end" aria-labelledby="dropdownMenuButton1">` +
                                `<x-dropdown-item href="${editUrl}">` +
                                `<x-heroicon-o-pencil class="hero-icon-sm me-2 text-gray-400" />` +
                                `@lang('Edit')` +
                                `</x-dropdown-item>` +
                                `<x-dropdown-item href="#">` +
                                `<form action="${deleteUrl}" method="POST" id="form-${data.id}">` +
                                `@csrf` +
                                `@method('DELETE')` +
                                `<button type="button" class="btn btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger align-items-center btn-sm" onclick="submitDeleteForm('${data.id}')">` +
                                `<x-heroicon-o-trash class="hero-icon-sm me-2 text-gray-400" />` +
                                `@lang('Delete')` +
                                `</button>` +
                                `</form>` +
                                `</x-dropdown-item>` +
                                `</x-dropdown-menu>` +
                                `</div>`

                        }
                    },

                ]
            });
        });

        function submitDeleteForm(id) {
            const form = document.querySelector(`#form-${id}`);
            Swal.fire(swalConfig()).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    topbar.hide();
                }
            });
        }
    </script>
@endpush
