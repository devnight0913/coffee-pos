@extends('layouts.print')
@section('title', $payment->number)

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
    <div class="mb-3 text-uppercase text-center fw-bold h3">PAYMENT RECEIPT</div>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>Receipt №</td>
                <td>{{ $payment->number }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>{{ $payment->date_view }}</td>
            </tr>
            <tr>
                <td>Received from</td>
                <td>
                    <div>{{ $customer->print_name }}</div>
                    <div>{{ $customer->contact }}</div>
                </td>
            </tr>
            @if ($payment->comments)
                <tr>
                    <td>Comments</td>
                    <td>{{ $payment->comments }}</td>
                </tr>
            @endif
            <tr>
                <td>Payment Mode</td>
                <td>{{ $payment->mode ?? '-' }}</td>
            </tr>
            <tr class="fw-bold">
                <td>Amount</td>
                <td>{{ $payment->amount_view }}</td>
            </tr>
        </tbody>
    </table>

@endsection
