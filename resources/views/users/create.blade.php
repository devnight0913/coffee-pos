@extends('layouts.app')
@section('title', __('Create') . ' ' . __('User'))

@section('content')

    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="h4 mb-0 flex-grow-1">@lang('Create') @lang('User')</div>
        <x-back-btn href="{{ route('users.index') }}" />
    </div>
    <div class="card w-100">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST" role="form">
                @csrf

                <div class="mb-3">
                    <label for="role" class="form-label">@lang('Role')*</label>
                    <select name="role" id="role" class=" form-select">
                        <option value="admin">@lang('Admin')</option>
                        <option value="cashier" selected>@lang('Cashier')</option>
                    </select>
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="name" class="form-label">@lang('Name')*</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">@lang('Username')*</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                            id="username" value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class=" form-text">@lang('Used for login')</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">@lang('Email')</label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">@lang('Phone Number')</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                        id="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">@lang('Password')</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        id="password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>

@endsection
