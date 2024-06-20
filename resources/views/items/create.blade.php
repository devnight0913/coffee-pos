@extends('layouts.app')
@section('title', __('Create') . ' ' . __('Item'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="flex-grow-1">
            <x-page-title>@lang('New Item')</x-page-title>
        </div>
        <x-back-btn href="{{ route('items.index') }}" />
    </div>
    @include('items.partials.form')
@endsection
