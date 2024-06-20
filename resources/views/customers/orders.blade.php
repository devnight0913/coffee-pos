@extends('layouts.app')
@section('title', $customer->name)

@section('content')

    @include('customers.partials.info')

    @if (!$orders->isEmpty())
    @can_edit
        <div class="card w-100 mb-3">
            <div class="card-body">
                <div class=" table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>@lang('Invoices'):</td>
                            <td>{{ $totalOrders }}</td>
                        </tr>
                        <tr>
                            <td>@lang('Cost'):</td>
                            <td>{{ $totalCost }}</td>
                        </tr>
                        <tr>
                            <td>@lang('Sales'):</td>
                            <td>{{ $totalSold }}</td>
                        </tr>
                        <tr class=" alert-success">
                            <td>@lang('Profit'):</td>
                            <td>{{ $totalProfit }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @endcan_edit
        <div class="row">
            <div class="col-md-6">
                @include('orders.analytics.total-sales', ['cardTitle' => __('Sales')])
            </div>
            <div class="col-md-6">
                @include('orders.analytics.total-orders', ['cardTitle' => __('Invoices')])
            </div>
        </div>
    @endif
    <div class="card w-100">
        <div class="card-body">
            @if ($orders->isEmpty())
                <x-no-data />
            @else
                @include('orders.table')
            @endif
            <div>
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>

@endsection
