@extends('layouts.print')
@section('title', $expense->number)

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
    <div class="mb-3 text-uppercase text-center fw-bold h3">Expense</div>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>Expense №</td>
                <td>{{ $expense->number }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>{{ $expense->date_view }}</td>
            </tr>
            <tr>
                <td>Payment Mode</td>
                <td>{{ $expense->mode ?? '-' }}</td>
            </tr>
            @if ($expense->reason)
                <tr>
                    <td>Reason</td>
                    <td>{{ $expense->reason }}</td>
                </tr>
            @endif
            @if ($expense->comments)
                <tr>
                    <td>Comments</td>
                    <td>{{ $expense->comments }}</td>
                </tr>
            @endif
            <tr class="fw-bold">
                <td>Amount</td>
                <td>{{ $expense->amount_view }}</td>
            </tr>
        </tbody>
    </table>

@endsection
