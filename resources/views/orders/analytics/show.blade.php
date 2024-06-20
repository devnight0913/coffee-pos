@extends('layouts.app')
@section('title', __('Analytics'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="flex-grow-1">
            <x-page-title>@lang('Analytics')</x-page-title>
        </div>
        <x-back-btn href="{{ route('orders.index') }}" />
    </div>


    <div class="row">
        <div class="col-md-6">
            @include('orders.analytics.total-sales', ['cardTitle' => __('Sales in the last 12 months')])
        </div>
        <div class="col-md-6">
            @include('orders.analytics.total-orders', [
                'cardTitle' => __('Invoices in the last 12 months'),
            ])
        </div>
        <div class="col-md-6">
            @include('orders.analytics.total-profit')
        </div>
        <div class="col-md-6">
            @include('orders.analytics.total-cost')
        </div>
    </div>
@endsection
