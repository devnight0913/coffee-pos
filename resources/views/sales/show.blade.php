@extends('layouts.app')
@section('title', 'Sales')

@section('content')


    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="mb-0 flex-grow-1">
            <div class="mb-0 h4"> <span class="fw-bold" dir="ltr">№{{ $serial_number }}</span></div>
        </div>
        <x-back-btn href="{{ route('sales.index') }}" />
    </div>
    <x-card>
        <button class="btn btn-primary mb-3 px-4" onclick="printDiv('printableArea')">
            <x-heroicon-o-printer class="hero-icon-sm me-1" /> @lang('Print')
        </button>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>@lang('Report') №</td>
                    <td>{{ $serial_number }}</td>
                </tr>
                <tr>
                    <td>@lang('Date')</td>
                    <td>{{ $date }}</td>
                </tr>
                <tr>
                    <td>@lang('Expenses')</td>
                    <td>{{ currency_format($expenses) }}</td>
                </tr>
                <tr>
                    <td>@lang('Payments')</td>
                    <td>{{ currency_format($payments) }}</td>
                </tr>
                <tr>
                    <td>@lang('Total Sales')</td>
                    <td>{{ currency_format($total_sales) }}</td>
                </tr>
            </tbody>
        </table>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class=" fw-bold text-decoration-none">@lang('Item')</th>
                    <th class="text-center fw-bold text-decoration-none">@lang('Quantity Sold')</th>
                    <th class="text-center fw-bold text-decoration-none">@lang('Total')</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @foreach ($sales as $sale)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                {{ $sale->recipe->name }}
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            {{ $sale->qty }}
                        </td>
                        <td class="align-middle text-center">
                            {{ currency_format($sale->total) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>



    </x-card>

    <div id="printableArea" class="d-none">
        <div style="padding: 0.5rem !important;" dir="ltr" lang="{{ $settings->lang }}">
            <div class="d-flex align-items-center mb-5">
                <div class="flex-grow-1">
                   <div class="flex-grow-1 h1 fw-bold mb-0">
            {{ $settings->storeName }}
        </div>
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
            <div class="mb-3 text-uppercase text-center fw-bold h4">Sale Report</div>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>@lang('Report') №</td>
                        <td>{{ $serial_number }}</td>
                    </tr>
                    <tr>
                        <td>@lang('Date')</td>
                        <td>{{ $date }}</td>
                    </tr>
                    <tr>
                        <td>@lang('Expenses')</td>
                        <td>{{ currency_format($expenses) }}</td>
                    </tr>
                    <tr>
                        <td>@lang('Payments')</td>
                        <td>{{ currency_format($payments) }}</td>
                    </tr>
                    <tr>
                        <td>@lang('Total Sales')</td>
                        <td>{{ currency_format($total_sales) }}</td>
                    </tr>
                </tbody>
            </table>


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class=" fw-bold text-decoration-none">@lang('Item')</th>
                        <th class="text-center fw-bold text-decoration-none">@lang('Quantity Sold')</th>
                        <th class="text-center fw-bold text-decoration-none">@lang('Total')</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @foreach ($sales as $sale)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{ $sale->recipe->name }}
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                {{ $sale->qty }}
                            </td>
                            <td class="align-middle text-center">
                                {{ currency_format($sale->total) }}
                            </td>
                        </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
