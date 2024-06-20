@extends('layouts.app')
@section('title', __('Create') . ' ' . __('Recipe'))

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="flex-grow-1">
            <x-page-title>@lang('New Recipe')</x-page-title>
        </div>
        <x-back-btn href="{{ route('recipe.index') }}" />
    </div>
    <div id="recipe-create" data-settings="{{ json_encode($settings) }}"></div>
@endsection