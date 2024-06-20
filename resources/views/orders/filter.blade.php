@extends('layouts.app')
@section('title', 'Filter')

@section('content')

    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="mb-0 flex-grow-1 ">
            <span class="text-muted"> @lang('Invoices')</span> <span class="fw-bold"> {{ $fromDate }}</span> <span
                class="text-muted">@lang('to')</span> <span class="fw-bold">{{ $toDate }}</span>
        </div>
        <x-back-btn href="{{ route('orders.index') }}" />
    </div>

    @if (!$orders->isEmpty())
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
                <div class="text-center">
                    <div class="mb-2">@lang('Nothing to show, try changing the filter.')</div>
                    @include('orders.filter-button')
                </div>
            @else
                @include('orders.table')
            @endif
            <div>
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>

    @include('orders.search-modal')
@endsection
