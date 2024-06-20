@extends('layouts.app')
@section('title', __('Settings'))

@section('content')

    <x-page-title>@lang('Settings')</x-page-title>
    <x-page-subtitle>@lang('Configure the general settings of the application.')</x-page-subtitle>
    <x-card>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="identification-tab" data-bs-toggle="tab"
                    data-bs-target="#identification-tab-pane" type="button" role="tab"
                    aria-controls="identification-tab-pane" aria-selected="true">
                    @lang('Identification')
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pos-tab" data-bs-toggle="tab" data-bs-target="#pos-tab-pane" type="button"
                    role="tab" aria-controls="pos-tab-pane" aria-selected="false">@lang('POS')</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="currency-tab" data-bs-toggle="tab" data-bs-target="#currency-tab-pane"
                    type="button" role="tab" aria-controls="currency-tab-pane"
                    aria-selected="false">@lang('Currency')</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="date-tab" data-bs-toggle="tab" data-bs-target="#date-tab-pane" type="button"
                    role="tab" aria-controls="date-tab-pane" aria-selected="false">@lang('Date')</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="exchange-rate-tab" data-bs-toggle="tab"
                    data-bs-target="#exchange-rate-tab-pane" type="button" role="tab"
                    aria-controls="exchange-rate-tab-pane" aria-selected="false">@lang('Exchange Rate')</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="backup-tab" data-bs-toggle="tab" data-bs-target="#backup-tab-pane"
                    type="button" role="tab" aria-controls="backup-tab-pane"
                    aria-selected="false">@lang('Backup')</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="identification-tab-pane" role="tabpanel"
                aria-labelledby="identification-tab" tabindex="0">
                @include('settings.partials.identification-form')
            </div>
            <div class="tab-pane fade" id="pos-tab-pane" role="tabpanel" aria-labelledby="pos-tab" tabindex="0">
                @include('settings.partials.pos-form')
            </div>
            <div class="tab-pane fade" id="currency-tab-pane" role="tabpanel" aria-labelledby="currency-tab" tabindex="0">
                @include('settings.partials.currency-form')
            </div>
            <div class="tab-pane fade" id="date-tab-pane" role="tabpanel" aria-labelledby="date-tab" tabindex="0">
                @include('settings.partials.date-form')
            </div>
            <div class="tab-pane fade" id="exchange-rate-tab-pane" role="tabpanel" aria-labelledby="exchange-rate-tab"
                tabindex="0">
                {{-- <div class="py-3">
                        <div class="mb-2">@lang('When you make the exchange rate value more than 1, the feature will be automatically applied')</div>
                        <div>@lang('You must specify the price of the item in the currency used below')</div>
                    </div> --}}
                @include('settings.partials.exchange-rate-form')
            </div>
            <div class="tab-pane fade" id="backup-tab-pane" role="tabpanel" aria-labelledby="backup-tab" tabindex="0">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('database.download') }}" class="btn btn-primary px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="hero-icon-sm me-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                            @lang('Download Backup')
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </x-card>


@endsection
