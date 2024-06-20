@extends('layouts.app')
@section('title', __('Purchases'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Purchases')</div>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary px-4">
            @lang('Create')
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Number')</th>
                            <th>@lang('Ref. №')</th>
                            <th>@lang('Supplier')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $purchase)
                            <tr>
                                <td class="align-middle">{{ $purchase->date_view }}</td>
                                <td class="align-middle fw-bold">{{ $purchase->number }}</td>
                                <td class="align-middle">{{ $purchase->reference_number }}</td>
                                <td class="align-middle">{{ $purchase->supplier ? $purchase->supplier->name : '-' }}</td>
                                <td class="align-middle">
                                    <div class="dropdown d-flex">
                                        <button class="btn btn-link me-auto text-black p-0" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <x-heroicon-o-ellipsis-horizontal class="hero-icon" />
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end animate slideIn shadow-sm"
                                            aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('purchases.show', $purchase) }}">
                                                    @lang('Show')
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('purchases.print', $purchase) }}"
                                                    target="_blank">
                                                    @lang('Print')
                                                </a>
                                            </li>
                                            @can_edit
                                            <li>
                                                <a class="dropdown-item" href="{{ route('purchases.edit', $purchase) }}">
                                                    @lang('Edit')
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <form action="{{ route('purchases.destroy', $purchase) }}"
                                                        method="POST" id="form-{{ $purchase->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger"
                                                            onclick="submitDeleteForm('{{ $purchase->id }}')">
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
                @if ($purchases->isEmpty())
                    <x-no-data />
                @endif
            </div>
            <div class="">
                {{ $purchases->withQueryString()->links() }}
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
