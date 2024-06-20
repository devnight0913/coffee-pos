@extends('layouts.app')
@section('title', 'Profile')

@section('content')


    <x-page-title>@lang('Profile Info')</x-page-title>
    <x-page-subtitle>@lang('Update your profile information')</x-page-subtitle>
    <x-card>
        <form action="{{ route('profile.update') }}" method="POST" role="form">
            @csrf
            @method('PUT')
            <x-input label="Name" name="name" value="{{ old('name', $user->name) }}" />
            <x-input label="Username" name="username" value="{{ old('username', $user->username) }}" />
            <x-input label="Phone Number" name="phone" value="{{ old('phone', $user->phone) }}" />
            <x-input label="Email" name="email" value="{{ old('email', $user->email) }}" />

            <x-save-btn>@lang('Save')</x-save-btn>
        </form>
    </x-card>

@endsection
