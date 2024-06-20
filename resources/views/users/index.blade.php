@extends('layouts.app')
@section('title', __('Users'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Users')</div>
        <a href="{{ route('users.create') }}" class="btn btn-primary @if (!Auth::user()->can_create) disabled @endif">@lang('Create')</a>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('users.index') }}" role="form">
                    <input type="search" name="search_query" value="{{ Request::get('search_query') }}"
                        class="form-control w-auto" placeholder="@lang('Search...')" autocomplete="off">
                </form>
            </div>
            <div class=" table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Role')</th>
                            <th>@lang('Username')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Phone Number')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($users as $user)
                            <tr>
                                <td class="align-middle fw-bold">{{ $user->name }} </td>
                                <td class="align-middle">{{ __($user->role) }} </td>
                                <td class="align-middle">{{ $user->username }}</td>
                                <td class="align-middle">{{ $user->email }}</td>
                                <td class="align-middle">{{ $user->phone }}</td>
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
                                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                            id="form-{{ $user->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger"
                                                                onclick="submitDeleteForm('{{ $user->id }}')">
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
            </div>
            <div class="">
                {{ $users->withQueryString()->links() }}
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
