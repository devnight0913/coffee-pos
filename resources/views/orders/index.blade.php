@extends('layouts.app')
@section('title', __('Invoices'))

@section('content')
    <div class="mb-3 h4">
        @lang('Invoices')
    </div>

    <div class="row">
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clickable-cell border-0 rounded-3 shadow-sm">
                <div class="card-body text-center">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" style="width: 7rem;height:7rem;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>

                    <h3>@lang('Stats')</h3>
                    <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#statesModal"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clickable-cell border-0 rounded-3 shadow-sm">
                <div class="card-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" style="width: 7rem;height:7rem;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>


                    <h3>@lang('Analytics')</h3>
                    <a href="{{ route('orders.analytics') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clickable-cell border-0 rounded-3 shadow-sm">
                <div class="card-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" style="width: 7rem;height:7rem;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <h3>@lang('Sales')</h3>
                    <a href="{{ route('sales.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>



    <div class="modal" id="statesModal" tabindex="-1" aria-labelledby="statesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="statesModalLabel">
                        <span class="me-2"> @lang('Stats')</span>
                        <a  href="{{route('orders.print.stats')}}" class="btn btn-primary btn-sm" target="_blank">
                            <i class="bi bi-printer me-2"></i> @lang('Print')
                        </a>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card w-100 mb-3">
                        <div class="card-body">
                            <div class=" table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <td>@lang('Invoices')</td>
                                        <td>{{ $totalOrders }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Cost')</td>
                                        <td>{{ $totalCost }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Sales')</td>
                                        <td>{{ $totalSold }}</td>
                                    </tr>
                                    <tr class=" alert-success">
                                        <td>@lang('Profit')</td>
                                        <td>{{ $totalProfit }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card w-100 mb-3">
                        <div class="card-body">
                            <div class="card-title h5">@lang('Today') ({{ date('j F') }})</div>
                            <div class=" table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <td>@lang('Invoices')</td>
                                        <td>{{ $totalOrdersToday }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Cost')</td>
                                        <td>{{ $totalCostToday }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Sales')</td>
                                        <td>{{ $totalSoldToday }}</td>
                                    </tr>
                                    <tr class=" alert-success">
                                        <td>@lang('Profit')</td>
                                        <td>{{ $totalProfitToday }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card w-100 mb-3">
                                <div class="card-body">
                                    <div class="card-title h5">@lang('This Month') ({{ date('F') }})</div>
                                    <div class=" table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <tr>
                                                <td>@lang('Invoices')</td>
                                                <td>{{ $totalOrdersThisMonth }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Cost')</td>
                                                <td>{{ $totalCostThisMonth }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Sales')</td>
                                                <td>{{ $totalSoldThisMonth }}</td>
                                            </tr>
                                            <tr class=" alert-success">
                                                <td>@lang('Profit')</td>
                                                <td>{{ $totalProfitThisMonth }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card w-100 mb-3">
                                <div class="card-body">
                                    <div class="card-title h5">@lang('This Year') ({{ date('Y') }})</div>
                                    <div class=" table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <tr>
                                                <td>@lang('Invoices')</td>
                                                <td>{{ $totalOrdersThisYear }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Cost')</td>
                                                <td>{{ $totalCostThisYear }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Sales')</td>
                                                <td>{{ $totalSoldThisYear }}</td>
                                            </tr>
                                            <tr class=" alert-success">
                                                <td>@lang('Profit')</td>
                                                <td>{{ $totalProfitThisYear }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="card w-100">
        <div class="card-body">
            <div class="d-flex align-items-baseline mb-3">
                <!-- <div class="flex-grow-1 pe-4">
                    <form action="{{ route('orders.index') }}" role="form">
                        <div class="input-group">
                            <input type="search" name="search_query" value="{{ Request::get('search_query') }}"
                                class="form-control" placeholder="@lang('Search by invoice number or customer name...')" autocomplete="off">
                            <button class="btn btn-outline-primary" type="submit"
                                id="button-addon2">@lang('Search')</button>
                        </div>
                        <div class="form-text">@lang('You can also use a scanner')</div>
                    </form>
                </div> -->
                @include('orders.filter-button')
            </div>

            <x-table id="orders-table">
                <x-thead>
                    <tr>
                        <x-th style="text-align: left;">@lang('Invoice Number')</x-th>
                        <x-th>@lang('Customer')</x-th>
                        <x-th>@lang('Discount')</x-th>
                        <x-th>@lang('Delivery Charge')</x-th>
                        <x-th>@lang('Subtotal')</x-th>
                        <x-th>@lang('Total')</x-th>
                        <x-th>@lang('Paid')</x-th>
                        <x-th>@lang('State')</x-th>
                        <x-th>@lang('Owe')</x-th>
                        <x-th>@lang('Date')</x-th>
                        <x-th>@lang('Author')</x-th>
                        <x-th></x-th>
                    </tr>
                </x-thead>
            </x-table>
            
        </div>
    </div>

    @include('orders.search-modal')
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            console.log("HELLO");
            let dataTable = $('#orders-table').DataTable({
                "order": [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                language: {
                    url: '{{ asset("datatables/i18n/{$settings->lang}.json") }}',
                },
                ajax: {
                    url: "{{ route('api.orders.index') }}",
                    dataSrc: 'data'
                },
                columns: [{
                        data: "number",
                        sortOrder: "DSC",
                        render: function(data, type, row) {
                            var showUrl = "{{ route('orders.show', ':id') }}";
                            showUrl = showUrl.replace(':id', row.id);
                            return `<a href="${showUrl}" class="text-decoration-none">
                                ${row.number}
                            </a>`;
                        }
                    }, 
                    {
                        orderable: false,
                        data: "customer_name"
                    },
                    {
                        data: "discount"
                    },
                    {
                        orderable: false,
                        data: "delivery_charge"
                    },
                    {
                        orderable: false,
                        data: "subtotal"
                    },
                    {
                        orderable: false,
                        data: "total"
                    },
                    {
                        orderable: false,
                        data: "tender_amount"
                    },
                    
                    {
                        orderable: false,
                        data: "is_paid",
                        render: function(data, type, row) {
                            if(row.is_paid === 0) {
                                return `<div>Unpaid</div>`;
                            } 
                            return `<div>Paid</div>`;
                        }
                    },
                    
                    {
                        orderable: false,
                        data: "owe"
                    },
                    
                    {
                        orderable: false,
                        data: "created_at"
                    },
                    {
                        orderable: false,
                        data: "author_name"
                    },
                    {
                        orderable: false,
                        data: function(data, type, dataToSet) {
                            var showUrl = "{{ route('orders.show', ':id') }}";
                            var editUrl = "{{ route('orders.edit', ':id') }}";
                            var deleteUrl = "{{ route('orders.destroy', ':id') }}";
                            var printUrl = "{{ route('orders.print', ':id') }}";
                            showUrl = showUrl.replace(':id', data.id);
                            editUrl = editUrl.replace(':id', data.id);
                            deleteUrl = deleteUrl.replace(':id', data.id);
                            printUrl = printUrl.replace(':id', data.id);
                            return `<div class="dropdown d-flex">
                                <button class="btn btn-link ms-auto text-black p-0" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" data-bs-boundary="window" aria-expanded="false">
                                    <x-heroicon-o-ellipsis-horizontal class="hero-icon" />
                                </button>
                                <x-dropdown-menu class="dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                    @can_edit
                                    <x-dropdown-item href="${showUrl}">
                                        <x-heroicon-o-eye class="hero-icon-sm me-2 text-gray-400" /> @lang('View')
                                    </x-dropdown-item>
                                    <li>
                                        <hr class="dropdown-divider m-0">
                                    </li>
                                    @endcan_edit
                                    @can_edit

                                    <x-dropdown-item href="${editUrl}">
                                        <x-heroicon-o-pencil class="hero-icon-sm me-2 text-gray-400" /> @lang('Edit')
                                    </x-dropdown-item>

                                    @endcan_edit
                                    <li>
                                        <hr class="dropdown-divider m-0">
                                    </li>

                                    <x-dropdown-item href="${printUrl}" target="_blank">
                                        <x-heroicon-o-printer class="hero-icon-sm me-2 text-gray-400" /> @lang('Print Receipt')
                                    </x-dropdown-item>

                                    <li>
                                        <hr class="dropdown-divider m-0">
                                    </li>

                                    @can_delete
                                    <x-dropdown-item href="#">
                                        <form action="${deleteUrl}" method="POST"
                                            id="form-${data.id}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger d-flex align-items-center"
                                                onclick="submitDeleteForm('${data.id}')">
                                                <x-heroicon-o-trash class="hero-icon-sm me-2 text-gray-400" />
                                                @lang('Delete')
                                            </button>
                                        </form>
                                    </x-dropdown-item>
                                    @endcan_delete
                                </x-dropdown-menu>
                            </div>`;
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

