@extends('layouts.app')
@section('title', __('Drawer'))

@section('content')

    <div class="d-flex align-items-center mb-3">
        <x-page-title>@lang('Drawer')</x-page-title>
        <div class="h4 mb-0 ms-auto"> {{ $date }}</div>
    </div>

    <div class="card w-100 mb-3">
        <div class="card-body">
            <div id="starting-cash-input" data-value="{{ $startingCash }}" data-direction="{{ $settings->dir }}"
                data-currency="{{ $currency }}"></div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>@lang('Total Invoices')</td>
                        <td> {{ $count }}</td>
                    </tr>
                    {{-- <tr>
                        <td>@lang('Total Payouts')</td>
                        <td> {{ currency_format($payouts) }}</td>
                    </tr> --}}
                    <tr>
                        <td>@lang('Total Cash Sales')</td>
                        <td> {{ currency_format($amount) }}</td>
                    </tr>
                </table>
            </div>
            <form action="{{ route('drawer.close') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="in_drawer_cash" class="form-label">@lang('In drawer cash') ({{ $currency }})</label>
                    <input type="text" name="in_drawer_cash"
                        class="form-control form-control-lg input-number @error('in_drawer_cash') is-invalid @enderror @if ($settings->dir == 'rtl') text-start @endif"
                        dir="ltr" id="in_drawer_cash" value="{{ old('in_drawer_cash') }}">
                    @error('in_drawer_cash')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary btn-lg px-4" type="submit">
                        @lang('End Of Day')
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <h5 class="card-title">@lang('Archive')</h5>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Starting cash')</th>
                            <th>@lang('Cash Sales')</th>
                            <th>@lang('Payouts')</th>
                            <th>@lang('Amount expected in drawer')</th>
                            <th>@lang('Actual amount in drawer')</th>
                            <th>@lang('Difference')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($drawerHistories as $drawerHistory)
                            <tr>
                                <td>
                                    <div>{{ $drawerHistory->start_date }}</div>
                                    <div>{{ $drawerHistory->end_date }}</div>
                                </td>
                                <td class="align-middle">{{ currency_format($drawerHistory->starting_cash) }}</td>
                                <td class="align-middle">{{ currency_format($drawerHistory->cash_sales) }}</td>
                                <td class="align-middle">{{ currency_format($drawerHistory->paid_out) }}</td>
                                <td class="align-middle">{{ currency_format($drawerHistory->expected) }}</td>
                                <td class="align-middle">{{ currency_format($drawerHistory->actual) }}</td>
                                <td class="@if ($drawerHistory->difference > 0) text-danger @endif @if ($settings->dir == 'rtl') text-start @endif align-middle"
                                    dir="ltr">{{ $drawerHistory->difference_view }}</td>
                                <td>
                                    <a href="{{ route('drawer.print', $drawerHistory) }}" class="btn btn-link"
                                        target="_blank">
                                        @lang('Print')
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($drawerHistories->isEmpty())
                    <x-no-data />
                @endif
            </div>
            <div>
                {{ $drawerHistories->withQueryString()->links() }}
            </div>
        </div>
    </div>



@endsection
