@extends('layouts.app')
@section('title', __('Edit') . ' ' . __('Employee'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Edit') @lang('Employee')</div>
        <x-back-btn href="{{ route('employees.index') }}" />
    </div>
    <div class="card w-100">
        <div class="card-body">
            @include('employees.partials.form')
        </div>
    </div>
@endsection
