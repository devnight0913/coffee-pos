@extends('layouts.print')
@section('title', 'EXPENSES')

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
    <div class="mb-3 text-uppercase text-center fw-bold h3">EXPENSES</div>

    <table class="table table-bordered">
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
            <td class="fw-bold">{{ $expenses_sum }}</td>
        </tr>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="fw-bold text-decoration-none">@lang('Date')</th>
                <th class="fw-bold text-decoration-none">@lang('Number')</th>
                <th class="fw-bold text-decoration-none">@lang('Amount')</th>
                <th class="fw-bold text-decoration-none">@lang('Payment Mode')</th>
                <th class="fw-bold text-decoration-none">@lang('Reason')</th>
                <th class="fw-bold text-decoration-none">@lang('Comments')</th>
            </tr>
        </thead>
        <tbody class="border-top-0">
            @foreach ($expenses as $expense)
                <tr>
                    <td class="align-middle">
                        {{ $expense->date_view }}
                    </td>
                    <td class="align-middle fw-bold">
                        {{ $expense->number }}
                    </td>
                    <td class="align-middle">
                        {{ $expense->amount_view }}
                    </td>
                    <td class="align-middle" lang="en">
                        {{ $expense->mode }}
                    </td>
                    <td class="align-middle">
                        {{ $expense->reason ?? '-' }}
                    </td>
                    <td class="align-middle">
                        {{ $expense->comments ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
