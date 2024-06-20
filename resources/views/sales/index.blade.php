@extends('layouts.app')
@section('title', __('Sales Report'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">
            @lang('Sales Report')
        </div>
        <x-back-btn href="{{ route('orders.index') }}" />
    </div>


    <x-card>

        <div class="mb-3">
            <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#filterModal">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="hero-icon-sm me-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
                @lang('Filter')
            </button>
        </div>

        @if ($sales->isEmpty())
            <x-no-data />
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="sales-table">
                    <thead>
                        <tr>
                            <th>@lang('Serial Number')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Items Sold')</th>
                            <th>@lang('Total Sales')</th>
                            {{-- <th>@lang('Total Profit')</th> --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @for ($i = 0; $i < $sales->count(); $i++)
                            <tr class="clickable-cell"
                                onclick="window.location='{{ route('sales.show', [$sales[$i]->date]) }}?ts={{ $sales[$i]->total - $salesOrder[$i]->sum_discount }}';">
                                <td class="align-middle py-3 text-start" lang="en" dir="auto">
                                    {{ Carbon\Carbon::parse($sales[$i]->date)->format('ymd') }}
                                </td>
                                <td class="align-middle py-3 text-start" lang="en" dir="auto">
                                    {{ Carbon\Carbon::parse($sales[$i]->date)->format('d F Y') }}
                                </td>
                                <td class="align-middle py-3">{{ $sales[$i]->total_sold }}</td>

                                <td class="align-middle py-3">
                                    {{ currency_format($sales[$i]->total - $salesOrder[$i]->sum_discount) }}
                                </td>
                                {{-- <td class="align-middle py-3">
                                        {{ currency_format($sales[$i]->total - $salesOrder[$i]->sum_discount - $sales[$i]->total_cost) }}
                                    </td> --}}
                                <td class=" align-middle">
                                    @if ($settings->dir == 'ltr')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" style="width:1.2rem;height:1.2rem;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" style="width:1.2rem;height:1.2rem;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 19.5L8.25 12l7.5-7.5" />
                                        </svg>
                                    @endif
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div>
                {{ $sales->links() }}
            </div>
        @endif
    </x-card>


    <div class="modal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="filterModalLabel">@lang('Filter')</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('sales.filter') }}" method="GET" role="form">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">@lang('From Date')</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">@lang('To Date')</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">@lang('Use Filter')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
