@extends('layouts.print')

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
   
    <table class="table table-bordered table-hover mb-0">
        <tbody>
            <tr>
                <td width="50%">@lang('Name')</td>
                <td width="50%">{{ $customer->name }}</td>
            </tr>
            <tr>
                <td width="50%">@lang('Email')</td>
                <td width="50%">{{ $customer->email }}</td>
            </tr>
            <tr>
                <td width="50%">@lang('Mobile')</td>
                <td width="50%">{{ $customer->mobile }}</td>
            </tr>
            <tr>
                <td width="50%">@lang('Telephone')</td>
                <td width="50%">{{ $customer->telephone }}</td>
            </tr>
            <tr>
                <td width="50%">@lang('Fax')</td>
                <td width="50%">{{ $customer->fax }}</td>
            </tr>
            <tr>
                <td width="50%">@lang('Notes')</td>
                <td width="50%">{{ $customer->notes }}</td>
            </tr>
            <tr>
                <td width="50%">@lang('Address')</td>
                <td width="50%">{{ $customer->full_address }}</td>
            </tr>
            <tr>
                <td width="50%">@lang('Company')</td>
                <td width="50%">{{ $customer->company_name }}</td>
            </tr>
            <tr>
                <td width="50%">@lang('Company Address')</td>
                <td width="50%">{{ $customer->company_address }}</td>
            </tr>
            <tr class=" bg-body">
                <td width="50%">@lang('Total Orders')</td>
                <td width="50%">{{ $customer->total_orders }}</td>
            </tr>
            <tr class=" bg-body">
                <td width="50%">@lang('Purchase Amount')</td>
                <td width="50%">{{ $customer->purchase_amount }}</td>
            </tr>
            <tr class=" bg-body">
                <td width="50%">@lang('Total Owe')</td>
                <td width="50%">{{ $customer->owed_amount }}</td>
            </tr>
            <tr class=" bg-body">
                <td width="50%">@lang('Number of Payments')</td>
                <td width="50%">{{ $customer->total_payments }}</td>
            </tr>
            <tr class=" bg-body">
                <td width="50%">@lang('Total Payments')</td>
                <td width="50%">{{ $customer->payment_amount }}</td>
            </tr>
        </tbody>
    </table>

@endsection
