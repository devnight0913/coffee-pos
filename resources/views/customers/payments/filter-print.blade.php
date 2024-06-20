@extends('layouts.print')
@section('title', 'Account Statement')

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
    <div class="mb-3 text-uppercase text-center fw-bold h3">PAYMENTS</div>

    <table class="table table-bordered">
        <tr>
            <td>Received from</td>
            <td class="fw-bold">
                <div>{{ $customer->print_name }}</div>
                <div>{{ $customer->contact }}</div>
            </td>
        </tr>
        <tr>
            <td>From Date</td>
            <td class="fw-bold">{{ $fromDate }}</td>
        </tr>
        <tr>
            <td>To Date</td>
            <td class="fw-bold">{{ $toDate }}</td>
        </tr>
        <tr>
            <td>@lang('Total')</td>
            <td class="fw-bold">{{ $payments_sum }}</td>
        </tr>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="fw-bold text-decoration-none">@lang('Date')</th>
                <th class="fw-bold text-decoration-none">@lang('Number')</th>
                <th class="fw-bold text-decoration-none">@lang('Amount')</th>
                <th class="fw-bold text-decoration-none">@lang('Payment Mode')</th>
                <th class="fw-bold text-decoration-none">@lang('Comments')</th>
            </tr>
        </thead>
        <tbody class="border-top-0">
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->date_view }} </td>
                    <td class="fw-bold">{{ $payment->number }} </td>
                    <td>{{ $payment->amount_view }} </td>
                    <td>{{ $payment->mode ?? '-' }} </td>
                    <td>{{ $payment->comments }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
