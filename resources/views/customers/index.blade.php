@extends('layouts.app')
@section('title', __('Customers'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Customers')</div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">@lang('Create')</a>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('customers.index') }}" role="form">
                    <input type="search" name="search_query" value="{{ Request::get('search_query') }}"
                        class="form-control w-auto" placeholder="@lang('Search...')" autocomplete="off">
                </form>
            </div>
            <div class=" table-responsive">
                <table class="table table-hover table-striped table-hover-x">
                    <thead>
                        <tr>
                            <th>@lang('Account Number')</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Mobile')</th>
                            <th class="text-center">@lang('Invoices')</th>
                            <th class="text-center">@lang('Balance')</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($customers as $customer)
                            <tr onclick="window.location='{{ route('customers.show', $customer) }}';">
                                <td class="align-middle fw-bold py-3">{{ $customer->number }} </td>
                                <td class="align-middle fw-bold">{{ $customer->name }} </td>
                                <td class="align-middle text-start" dir="auto" lang="en">
                                    {{ $customer->email ?? '-' }}</td>
                                <td class="align-middle text-start" dir="auto" lang="en">
                                    {{ $customer->mobile ?? '-' }}
                                </td>
                                <td class="align-middle text-center">{{ $customer->total_orders }}</td>
                                <td class="align-middle text-center">{{ $customer->balance }}</td>
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
                        @endforeach
                    </tbody>
                </table>
                @if ($customers->isEmpty())
                    <x-no-data />
                @endif
            </div>
            <div class="">
                {{ $customers->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
