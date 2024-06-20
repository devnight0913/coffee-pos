@extends('layouts.app')
@section('title', __('Suppliers'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Suppliers')</div>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary px-4">
            @lang('Create')
        </a>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="d-flex">
                <div class=" flex-grow-1">
                    <form action="{{ route('suppliers.index') }}" role="form" class="mb-3">
                        <input type="search" name="search_query" value="{{ Request::get('search_query') }}"
                            class="form-control w-auto" placeholder="@lang('Search...')" autocomplete="off">
                    </form>
                </div>
            </div>

            <div class=" table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Address')</th>
                            <th>@lang('Phone Number')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($suppliers as $supplier)
                            <tr>

                                <td class="align-middle">{{ $supplier->name }} </td>
                                <td class="align-middle">{{ $supplier->address ?? '-' }} </td>
                                <td class="align-middle">{{ $supplier->phone ?? '-' }} </td>

                                <td class="align-middle">
                                    <div class="dropdown d-flex">
                                        <button class="btn btn-link me-auto text-black p-0" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <x-heroicon-o-ellipsis-horizontal class="hero-icon" />
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end animate slideIn shadow-sm"
                                            aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('suppliers.show', [$supplier]) }}">
                                                    @lang('Show')
                                                </a>
                                            </li>
                                            @can_edit
                                            <li>
                                                <a class="dropdown-item" href="{{ route('suppliers.edit', [$supplier]) }}">
                                                    @lang('Edit')
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <form action="{{ route('suppliers.destroy', [$supplier]) }}"
                                                        method="POST" id="form-{{ $supplier->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger"
                                                            onclick="submitDeleteForm('{{ $supplier->id }}')">
                                                            @lang('Delete')
                                                        </button>
                                                    </form>
                                                </a>
                                            </li>
                                            @endcan_edit
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($suppliers->isEmpty())
                    <x-no-data />
                @endif
            </div>
            <div class="">
                {{ $suppliers->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
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
