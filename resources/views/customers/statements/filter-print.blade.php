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
    <div class="mb-3 text-uppercase text-center fw-bold h3">Account Statement</div>
    <table class="table table-bordered">
        <tr>
            <td>From Date</td>
            <td class="fw-bold">{{ $fromDate }}</td>

            <td>Account №</td>
            <td class="fw-bold">{{ $customer->number }}</td>

            <td>Currency</td>
            <td class="fw-bold">{{ $settings->currencyName }}</td>
        </tr>
        <tr>
            <td>To Date</td>
            <td class="fw-bold">{{ $toDate }}</td>

            <td>Description</td>
            <td class="fw-bold">
                {{ $customer->name }}
                @if ($customer->company_name)
                    - {{ $customer->company_name }}
                @endif
            </td>

            <td colspan="2">{{ $date }}</td>
        </tr>
        <tr>
            <td>Balance From</td>
            <td class="fw-bold">{{ $fromDate }}</td>

            <td>Address</td>
            <td class="fw-bold">{{ $customer->print_address }}</td>

            <td colspan="2">{{ $time }}</td>

        </tr>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="fw-bold text-decoration-none">@lang('Date')</th>
                <th class="fw-bold text-decoration-none">@lang('Ref. №')</th>
                <th class="fw-bold text-decoration-none">@lang('Description')</th>
                <th class="fw-bold text-decoration-none">@lang('Debit')</th>
                <th class="fw-bold text-decoration-none">@lang('Credit')</th>
                <th class="fw-bold text-decoration-none">@lang('Balance')</th>
            </tr>
        </thead>
        <tbody class="border-top-0 ">
            @foreach ($statements as $statement)
                <tr>
                    <td>{{ $statement->date }} </td>
                    <td>{{ $statement->reference_number }} </td>
                    <td>{{ $statement->description }} </td>
                    <td>{{ $statement->debit_view }} </td>
                    <td>{{ $statement->credit_view }} </td>
                    <td>{{ $statement->balance_view }} </td>
                </tr>
            @endforeach
            <tr class="fw-bold">
                <td colspan="3" class="text-center fw-normal">
                    {{ $balance_sum_raw }}
                </td>
                <td>{{ $debit_sum }} </td>
                <td>{{ $credit_sum }} </td>
                <td>{{ $balance_sum }} </td>
            </tr>
        </tbody>
    </table>

@endsection
