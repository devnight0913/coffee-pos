@extends('layouts.app')
@section('title', $purchase->number)

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Purchase') №{{ $purchase->number }}</div>
        <x-back-btn href="{{ route('purchases.index') }}" />
    </div>


    <div class="card mb-3">
        <div class="card-body">
            <div class="mb-3">
                @can_edit
                <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-outline-primary px-4">
                    @lang('Edit')
                </a>
                @endcan_edit
                <a href="{{ route('purchases.print', $purchase) }}" class="btn btn-outline-primary px-4" target="_blank">
                    @lang('Print')
                </a>
            </div>
            <div class=" table-responsive mb-0">
                <table class="table table-bordered mb-1">
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
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class=" table-responsive mb-0">
                <table class="table table-bordered mb-1">
                    <thead>
                        <tr>
                            <th class=" text-center text-decoration-none fw-bold">@lang('Item')</th>
                            <th class=" text-center text-decoration-none fw-bold">@lang('Quantity')</th>
                            <th class=" text-center text-decoration-none fw-bold">@lang('Cost')</th>
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
            </div>
        </div>
    </div>
@endsection
