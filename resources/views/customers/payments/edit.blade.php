@extends('layouts.app')
@section('title', __('Edit Payments'))

@section('content')
    @include('customers.partials.info')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title h4">
                @lang('Edit Payment')
            </div>
            @include('customers.payments.partials.form')
        </div>
    </div>
@endsection
