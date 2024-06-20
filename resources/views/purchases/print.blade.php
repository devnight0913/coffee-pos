@extends('layouts.print')
@section('title', $purchase->number)
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
    <div class="mb-3 text-uppercase text-center fw-bold h3">PURCHASE </div>
    <table class="table table-bordered mb-3">
        <tbody>
            <tr>
                <td>@lang('Purchase №')</td>
                <td class="fw-bold">{{ $purchase->number }}</td>
            </tr>
            <tr>
                <td>@lang('Reference Number')</td>
                <td class="fw-bold">{{ $purchase->reference_number }}</td>
            </tr>
            <tr>
                <td>@lang('Date')</td>
                <td class="fw-bold">{{ $purchase->date_view }}</td>
            </tr>
            <tr>
                <td>@lang('Supplier')</td>
                <td class="fw-bold">{{ $purchase->supplier->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>@lang('Notes')</td>
                <td class="fw-bold">{{ $purchase->notes }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered mb-1">
        <thead>
            <tr>
                <th class=" text-center text-decoration-none fw-bold">@lang('Item')</th>
                <th class=" text-center text-decoration-none fw-bold">@lang('Quantity')</th>
                <th class=" text-center text-decoration-none fw-bold">@lang('Unit Cost')</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($purchase->purchase_details as $detail)
                <tr>
                    <td>{{ $detail->item->name }}</td>
                    <td class="text-center">{{ $detail->view_quantity }}</td>
                    <td class="text-center">{{ currency_format($detail->cost) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
