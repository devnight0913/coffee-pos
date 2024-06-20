@extends('layouts.app')
@section('title', 'Confirm Password')

@section('content')
    <div class="container vh-100">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 col-sm-12">
                @include('layouts.alerts')
                <div class="card w-100">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="bi bi-shield-lock fs-1"></i>
                        </div>
                        <div class="card-title mb-sm-3 text-center">
                            This is a secure area. Please, confirm your password before continuing
                        </div>
                        <form action="{{ route('password.confirm') }}" method="POST" role="form">
                            @csrf

                            <input type="text" name="uri" value="{{ Request::get('uri') }}" class="d-none">

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    autocomplete="off" autofocus>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
