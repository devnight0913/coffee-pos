@extends('layouts.app')
@section('title', __('Customer Payments'))

@section('content')

    @include('customers.partials.info')
    <div class="card w-100">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <div class="h4 mb-0 flex-grow-1">@lang('Payments')</div>
                <a href="{{ route('customers.payments.create', $customer) }}"
                    class="btn btn-primary me-2">@lang('Create Payment')</a>
                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="hero-icon-sm me-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                    </svg>
                    @lang('Filter')
                </button>
                <div class="modal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="filterModalLabel">@lang('Paymetns Filter')</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('customers.payments.filter', $customer) }}" method="GET"
                                role="form">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">@lang('From Date')</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date">
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">@lang('To Date')</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary w-100">@lang('Use Filter')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('customers.payments.index', $customer) }}" role="form">
                <div class="input-group">
                    <input type="search" name="search_query" value="{{ Request::get('search_query') }}"
                        class="form-control" placeholder="@lang('Search...')" autocomplete="off">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">@lang('Search')</button>
                </div>
                <div class="form-text">@lang('You can also use a scanner')</div>
            </form>
            <div class=" table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Number')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Payment Mode')</th>
                            <th>@lang('Comments')</th>
                            {{-- <th>@lang('Time')</th> --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->date_view }} </td>
                                <td>{{ $payment->number }} </td>
                                <td>{{ $payment->amount_view }} </td>
                                <td>{{ $payment->mode ?? '-' }} </td>
                                <td>{{ $payment->comments }} </td>
                                {{-- <td>{{ $payment->time_view }} </td> --}}

                                <td class="align-middle">
                                    <div class="dropdown d-flex">
                                        <button class="btn btn-link me-auto text-black p-0" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <x-heroicon-o-ellipsis-horizontal class="hero-icon" />
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end animate slideIn shadow-sm"
                                            aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" target="_blank"
                                                    href="{{ route('customers.payments.print', [$customer, $payment]) }}">
                                                    @lang('Print')
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('customers.payments.edit', [$customer, $payment]) }}">
                                                    @lang('Edit')
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <form
                                                        action="{{ route('customers.payments.destroy', [$customer, $payment]) }}"
                                                        method="POST" id="form-{{ $payment->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger"
                                                            onclick="submitDeleteForm('{{ $payment->id }}')">
                                                            @lang('Delete')
                                                        </button>
                                                    </form>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($payments->isEmpty())
                    <x-no-data />
                @endif
            </div>
            <div class="">
                {{ $payments->withQueryString()->links() }}
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
