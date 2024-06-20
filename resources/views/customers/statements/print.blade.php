@extends('layouts.print')
@section('title', $statement->id)

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
        <tbody>
            <tr>
                <td>Ref. №</td>
                <td>{{ $statement->reference_number }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>{{ $statement->date }}</td>
            </tr>
            <tr>
                <td>To</td>
                <td>
                    <div>{{ $customer->name }}</div>
                    @if ($customer->mobile)
                        <div class="text-muted small"> {{ $customer->mobile }}</div>
                    @endif
                    @if ($customer->telephone)
                        <div class="text-muted small"> {{ $customer->telephone }}</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Credit</td>
                <td>{{ $statement->credit_view }}</td>
            </tr>
            <tr>
                <td>Debit</td>
                <td>{{ $statement->debit_view }}</td>
            </tr>
            <tr>
                <td>Balance</td>
                <td>{{ $statement->balance_view }}</td>
            </tr>
            @if ($statement->description)
                <tr>
                    <td>Description</td>
                    <td>{{ $statement->description }}</td>
                </tr>
            @endif
        </tbody>
    </table>

@endsection
