@extends('layouts.app')
@section('title', __('Account Statement'))

@section('content')
    @include('customers.partials.info')
    @include('customers.statements.cards')

    <div class="card border-0 rounded-3 shadow-sm w-100">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="card-title h5 flex-grow-1">@lang('Account Statement')</div>
                <div>
                    @include('customers.statements.filter-modal')
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Ref. №')</th>
                            <th>@lang('Description')</th>
                            <th>@lang('Debit')</th>
                            <th>@lang('Credit')</th>
                            <th>@lang('Balance')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($statements as $statement)
                            <tr>
                                <td>{{ $statement->date }} </td>
                                <td>{{ $statement->reference_number }} </td>
                                <td>{{ $statement->description }} </td>
                                <td>{{ $statement->debit_view }} </td>
                                <td>{{ $statement->credit_view }} </td>
                                <td>{{ $statement->balance_view }} </td>
                                <td class="align-middle">
                                    <a class="btn btn-outline-primary btn-sm" target="_blank"
                                        href="{{ route('customers.statements.print', [$customer, $statement]) }}">
                                        @lang('Print')
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($statements->isEmpty())
                    <x-no-data />
                @endif
            </div>
            <div class="">
                {{ $statements->links() }}
            </div>
        </div>
    </div>



@endsection
