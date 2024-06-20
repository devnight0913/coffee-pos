@extends('layouts.app')
@section('title', __('expenses'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('expenses Archive')</div>
        <x-back-btn href="{{ route('expenses.index') }}" />
    </div>
    <div class="card w-100">
        <div class="card-body">
            <form action="{{ route('expenses.archive') }}" role="form" class="mb-3">
                <div class="input-group">
                    <input type="search" name="search_query" value="{{ Request::get('search_query') }}" class="form-control"
                        placeholder="@lang('Search...')" autocomplete="off">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">@lang('Search')</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Number')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Reason')</th>
                            <th>@lang('Comments')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($expenses as $expense)
                            <tr>
                                <td class="align-middle">
                                    {{ $expense->number }}
                                </td>
                                <td class="align-middle">
                                    {{ $expense->date }}
                                </td>
                                <td class="align-middle" lang="en">
                                    {{ $expense->amount_view }}
                                </td>
                                <td class="align-middle">
                                    {{ $expense->reason ?? '-' }}
                                </td>
                                <td class="align-middle">
                                    {{ $expense->comments ?? '-' }}
                                </td>
                                <td class="align-middle">
                                    @can_delete
                                    <div class="dropdown d-flex">
                                        <button class="btn btn-link me-auto text-black p-0" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <x-heroicon-o-ellipsis-horizontal class="hero-icon" />
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end animate slideIn shadow-sm"
                                            aria-labelledby="dropdownMenuButton1">

                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                                        id="form-{{ $expense->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger"
                                                            onclick="submitDeleteForm('{{ $expense->id }}')">
                                                            @lang('Delete')
                                                        </button>
                                                    </form>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                    @endcan_delete
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($expenses->isEmpty())
                    <x-no-data />
                @endif
            </div>
            <div>
                {{ $expenses->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function submitDeleteForm(id) {
            const form = document.querySelector(`#form-${id}`);
            Swal.fire(swalConfig()).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    topbar.hide();
                }
            });
        }
    </script>
@endpush
