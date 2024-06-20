@extends('layouts.app')
@section('title', __('Change Password'))

@section('content')
    <x-page-title>@lang('Change Password')</x-page-title>
    <x-page-subtitle>@lang('Make sure your account uses a long, random password to stay secure.')</x-page-subtitle>
    <x-card>
        <form action="{{ route('password.update') }}" method="POST" role="form">
            @csrf
            @method('PUT')
            <x-input type="password" label="Current Password" name="current_password" />
            <x-input type="password" label="New Password" name="new_password" />
            <x-input type="password" label="Confirm New Password" name="new_password_confirmation" />
            <x-save-btn>@lang('Save')</x-save-btn>
        </form>
    </x-card>

@endsection
