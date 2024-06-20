@extends('layouts.print')
@section('title', __('Stats'))

@section('content')
    <div class="d-flex align-items-center mb-5">
           <div class="flex-grow-1 h1 fw-bold mb-0">
            {{ $settings->storeName }}
        </div>

        <div>
            @if ($settings->storeAddress)
                <div> {{ $settings->storeAddress }}</div>
            @endif
            @if ($settings->storePhone)
                <div> {{ $settings->storePhone }}</div>
            @endif
            @if ($settings->storeWebsite)
                <div> {{ $settings->storeWebsite }}</div>
            @endif
            @if ($settings->storeEmail)
                <div> {{ $settings->storeEmail }}</div>
            @endif
        </div>
    </div>
    <div class="mb-3 text-uppercase text-center fw-bold h4">STATS</div>

    <div class="table-responsive mb-3">
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

    <div class="card-title h5">@lang('Today') ({{ date('j F') }})</div>
    <div class=" table-responsive mb-3">
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

    <div class="row">
        <div class="col-md-6 mb-3">
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
        <div class="col-md-6 mb-3">
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
@endsection
