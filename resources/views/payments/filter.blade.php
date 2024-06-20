@extends('layouts.app')
@section('title', __('Payments'))

@section('content')
    <div class="card border-0 rounded-3 shadow-sm w-100">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div class="flex-grow-1">
                    <div class="card-title h5 mb-0">@lang('Payments')</div>
                </div>
                <div>
                    <a href="{{ route('payments.filter.print') }}?start_date={{ $startDate }}&end_date={{ $endDate }}"
                        class="btn btn-primary px-4" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="hero-icon-sm me-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        @lang('Print')
                    </a>
                    <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal"
                        data-bs-target="#filterModal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="hero-icon-sm me-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                        </svg>
                        @lang('Filter')
                    </button>
                    <div class="modal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="filterModalLabel">@lang('Paymetns Filter')</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('payments.filter') }}" method="GET" role="form">
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

            </div>
            <table class="table table-bordered">
                <tr>
                    <td>@lang('From Date')</td>
                    <td class="fw-bold">{{ $fromDate }}</td>
                </tr>
                <tr>
                    <td>@lang('To Date')</td>
                    <td class="fw-bold">{{ $toDate }}</td>
                </tr>
                <tr>
                    <td>@lang('Total')</td>
                    <td class="fw-bold">{{ $payments_sum }}</td>
                </tr>
            </table>
            <div class=" table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Number')</th>
                            <th>@lang('Customer')</th>
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
                                <td class="fw-bold">{{ $payment->number }} </td>
                                <td>
                                    <a href="{{ route('customers.show', $payment->customer) }}"
                                        class=" text-decoration-none  fw-bold">
                                        {{ $payment->customer->name }}
                                    </a>
                                </td>
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
                                                    href="{{ route('customers.payments.print', [$payment->customer, $payment]) }}">
                                                    @lang('Print')
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('customers.payments.edit', [$payment->customer, $payment]) }}">
                                                    @lang('Edit')
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <form
                                                        action="{{ route('customers.payments.destroy', [$payment->customer, $payment]) }}"
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
            <div>
                {{ $payments->withQueryString()->links() }}
            </div>
        </div>
    </div>


@endsection
