@extends('layouts.app')
@section('title', __('Supplier'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Supplier')</div>
        <x-back-btn href="{{ route('suppliers.index') }}" />
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tr>
                    <td>@lang('Name')</td>
                    <td class="fw-bold">{{ $supplier->name }}</td>
                </tr>
                <tr>
                    <td>@lang('Address')</td>
                    <td class="fw-bold">{{ $supplier->address }}</td>
                </tr>
                <tr>
                    <td>@lang('Phone')</td>
                    <td class="fw-bold">{{ $supplier->phone }}</td>
                </tr>
                <tr>
                    <td>@lang('Email')</td>
                    <td class="fw-bold">{{ $supplier->email }}</td>
                </tr>
                <tr>
                    <td>@lang('Notes')</td>
                    <td class="fw-bold">{{ $supplier->notes }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
