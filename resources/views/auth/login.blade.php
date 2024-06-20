@extends('layouts.app')
@push('head')
    <style>
        body {
            width: 100%;
            min-height: 100vh;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-image: url(/images/webp/bg-system.webp);
        }
    </style>
@endpush
@section('content')
    <div class="container vh-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-12 col-xs-12">
                @include('layouts.alerts')

                <x-card class="border-primary" style="background-color: rgba(255, 255, 255, .6);">
                    <div class="text-center h1 fw-bold">{{ config('app.name') }}</div>
                    <h5 class="card-title text-center text-primary fw-bold">@lang('Log in to the system')</h5>
                    <form action="{{ route('login.attempt') }}" method="POST" role="form">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">@lang('Username')</label>
                            <input type="text" name="username"
                                class="form-control form-control-lg @error('username') is-invalid @enderror" id="username">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">@lang('Password')</label>
                            <input type="password" name="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror" id="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            @lang('Login')
                        </button>
                    </form>
                </x-card>
                <div class="text-center py-2">
                    <span class="text-muted">
                        {{ config('app.name') }} © {{ date('Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
