@extends('layouts.app')
@section('title', __('Create') . ' ' . __('Customer'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Create') @lang('Customer')</div>
        <x-back-btn href="{{ route('customers.index') }}" />
    </div>
    <div class="card w-100">
        <div class="card-body">
            @include('customers.partials.form')
        </div>
    </div>
@endsection
