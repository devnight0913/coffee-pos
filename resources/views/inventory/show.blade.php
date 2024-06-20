@extends('layouts.app')
@section('title', __('Inventory'))

@section('content')

    <div class="d-flex align-items-center mb-3">
        <x-page-title>@lang('Inventories')</x-page-title>
        <div class="h4 mb-0 ms-auto"> {{ $date }}</div>
    </div>

    <div class="card w-100 mb-3">
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>@lang('Total Invoices')</td>
                        <td> {{ $count }}</td>
                    </tr>
                    <tr>
                        <td>@lang('Total Customers')</td>
                        <td> {{ $customer_count }}</td>
                    </tr>
                    <tr>
                        <td>@lang('Total Cash Sales')</td>
                        <td> {{ currency_format($amount) }}</td>
                    </tr>
                </table>
            </div>
           <h5 class="card-title">@lang('Invoices')</h5>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Invoice Number')</th>
                            <th>@lang('Customer Name')</th>
                            <th>@lang('Customer Phone Number')</th>
                            <th>@lang('Cash Sales')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($todayInvoices as $todayInvoice)
                            <tr>
                                <td><div>{{ $date }}</div></td>
                                <td class="align-middle">{{ $todayInvoice->number }}</td>
                                <td class="align-middle">{{ $todayInvoice->name }}</td>
                                <td class="align-middle">{{ $todayInvoice->mobile }}</td>
                                <td class="align-middle">{{ $todayInvoice->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($todayInvoices->isEmpty())
                    <x-no-data />
                @endif
            </div>
            <form action="{{ route('inventory.close') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <button class="btn btn-primary btn-lg px-4" type="submit">
                        @lang('End Of Day')
                    </button>
                </div>
            </form>
        </div>
    </div>
     <div class="card w-100">
        <div class="card-body">
            <h5 class="card-title">@lang('Archive')</h5>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Invoices Count')</th>
                            <th>@lang('Customers Count')</th>
                            <th>@lang('Cash Sales')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventoryHistories as $inventoryHistory)
                            <tr>
                                <td>
                                    <div>{{ $inventoryHistory->start_date }}</div>
                                    <div>{{ $inventoryHistory->end_date }}</div>
                                </td>
                                <td class="align-middle">{{ $inventoryHistory->invoices }}</td>
                                <td class="align-middle">{{ $inventoryHistory->customers }}</td>
                                <td class="align-middle">{{ currency_format($inventoryHistory->cash_sales) }}</td>
                               <td>
                                    <a href="{{ route('inventory.print', $inventoryHistory) }}" class="btn btn-link"
                                        target="_blank">
                                        @lang('Print')
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($inventoryHistories->isEmpty())
                    <x-no-data />
                @endif
            </div>
        </div>
    </div>



@endsection
