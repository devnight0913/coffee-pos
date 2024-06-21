@extends('layouts.app')
@section('title', $order->number)

@section('content')

    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">
            <div class="h4 mb-0">{{ $order->number }}</div>
            <div class="text-muted mb-0 small text-start" dir="ltr">
                {{ $order->created_at }}
            </div>
        </div>
        @can_edit
        <x-back-btn href="{{ route('orders.index') }}" />
        @endcan_edit
    </div>

    <div class="mb-3">
        <a class="btn btn-primary" href=" {{ route('orders.edit', $order) }}">
            <span class=" d-flex align-items-center">
                <x-heroicon-o-pencil-square class="hero-icon-sm me-1" /> @lang('Edit')
            </span>
        </a>
        <a class="btn btn-primary" target="_blank" href=" {{ route('orders.print', $order) }}">
            <span class=" d-flex align-items-center">
                <x-heroicon-o-printer class="hero-icon-sm me-1" /> @lang('Print Receipt')
            </span>
        </a>
    </div>
    @if ($order->remarks)
        <x-card class="mb-3">
            <div class="fw-bold">@lang('Notes')</div>
            <div> {{ $order->remarks }}</div>
        </x-card>
    @endif


    @if ($order->has_customer)
        <x-card class="mb-3">
            <div class="card-title h4">@lang('Customer')</div>
            <table class="table table-bordered table-hover mb-0">
                <tbody>
                    <tr>
                        <td width="50%">@lang('Name')</td>
                        <td width="50%">
                            <a href="{{ route('customers.show', $order->customer) }}" class="text-decoration-none fw-bold">
                                <div> {{ $order->customer->name }} @if ($order->customer->company_name)
                                        - {{ $order->customer->company_name }}
                                    @endif
                                </div>
                                <div class="small text-muted"> acct. {{ $order->customer->number }}</div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">@lang('Email')</td>
                        <td width="50%">{{ $order->customer->email }}</td>
                    </tr>
                    <tr>
                        <td width="50%">@lang('Mobile')</td>
                        <td width="50%">{{ $order->customer->mobile }}</td>
                    </tr>
                    <tr>
                        <td width="50%">@lang('Telephone')</td>
                        <td width="50%">{{ $order->customer->telephone }}</td>
                    </tr>
                    <tr>
                        <td width="50%">@lang('Address')</td>
                        <td width="50%">{{ $order->customer->full_address }}</td>
                    </tr>
                </tbody>
            </table>
        </x-card>
    @endif
    <x-card class="mb-3">
            <div class="card-title h4">@lang('Payment')</div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-hover mb-0">
                        <tbody>
                            <tr>
                                <td width="50%">@lang('Subtotal')</td>
                                <td width="50%">{{ $order->subtotal_view }}</td>
                            </tr>
                            <tr>
                                <td width="50%">@lang('Delivery Charge')</td>
                                <td width="50%">{{ $order->delivery_charge_view }}</td>
                            </tr>
                            <tr>
                                <td width="50%">@lang('Discount')</td>
                                <td width="50%">{{ $order->discount_view }}</td>
                            </tr>
                            @if ($order->tax_rate > 0)
                                @if ($order->vat_type == 'add')
                                    <tr>
                                        <td width="50%">@lang('VAT') {{ $order->tax_rate }}%</td>
                                        <td width="50%">{{ $order->total_tax_view }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td width="50%">@lang('VAT') {{ $order->tax_rate }}%</td>
                                        <td width="50%">{{ $order->vat_view }}</td>
                                    </tr>
                                    <tr>
                                        <td width="50%">@lang('Tax Amount')</td>
                                        <td width="50%">{{ $order->tax_amount_view }}</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td width="50%">@lang('VAT') {{ $order->tax_rate }}%</td>
                                    <td width="50%">-</td>
                                </tr>
                            @endif
                            <tr class="fw-bold">
                                <td width="50%">@lang('Total')</td>
                                <td width="50%">
                                    <div>{{ $order->total_view }}</div>
                                    <div>{{ $order->receipt_exchange_rate }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered table-hover mb-0">
                        <tbody>
                            <tr>
                                <td width="50%">@lang('Paid')</td>
                                <td width="50%">${{ $order->tender_amount }}</td>
                            </tr>
                            <tr>
                                <td width="50%">@lang('State')</td>
                                <td width="50%">
                                    @if( $order->paid )
                                        <div>@lang('Paid')</div>
                                    @else
                                        <div>@lang('Unpaid')</div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">@lang('Change')</td>
                                <td width="50%">${{ $order->change }}</td>
                            </tr>
                            {{-- <tr>
                                <td width="50%">@lang('Owe')</td>
                                <td width="50%">{{ $order->owe_view }}</td>
                            </tr> --}}
                            {{-- @can_edit
                            <tr>
                                <td width="50%">@lang('Cost')</td>
                                <td width="50%">{{ $order->cost_view }}</td>
                            </tr>
                            <tr class=" alert-success">
                                <td width="50%">@lang('Profit')</td>
                                <td width="50%">{{ $order->profit_view }}</td>
                            </tr>
                            @endcan_edit --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </x-card>



    <x-card>
        <x-table>
            <x-thead>
                <x-th>@lang('ITEM NAME')</x-th>
                <x-th>@lang('QUANTITY')</x-th>
                <x-th>@lang('PRICE')</x-th>
                <x-th>@lang('TOTAL')</x-th>
            </x-thead>
            <tbody class="border-top-0">
                @foreach ($order->order_details as $detail)
                    <tr>
                        <x-td>{{ $detail->item->name }}</x-td>
                        <x-td>{{ $detail->quantity }}</x-td>
                        <x-td>{{ $detail->view_price }}</x-td>
                        <x-td>{{ $detail->view_total }}</x-td>
                    </tr>
                @endforeach
            </tbody>
        </x-table>
    </x-card>

@endsection
