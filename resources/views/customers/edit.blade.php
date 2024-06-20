@extends('layouts.app')
@section('title', __('Edit') . ' ' . __('Customer'))

@section('content')
    @include('customers.partials.info')

    <div class="card w-100">
        <div class="card-body">
            @include('customers.partials.form')
        </div>
    </div>
@endsection
