@extends('layouts.app')
@section('title', config('app.name'))

@section('content')
    <div class="row">
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/cashier.webp') }}" height="100" class="mb-3" alt="cashier">
                    <h3>@lang('Point Of Sale')</h3>
                    <a href="{{ route('pos.show') }}" class=" stretched-link"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/inbox.webp') }}" height="100" class="mb-3" alt="inbox">
                    <h3>@lang('Invoices')</h3>
                    <a href="{{ Auth::user()->is_cashier ? '#' : route('orders.index') }}"
                        class="stretched-link @if (Auth::user()->is_cashier) cursor-not-allowed @endif"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/chart.webp') }}" height="100" class="mb-3" alt="chart">
                    <h3>@lang('Reports')</h3>
                    <a href="{{ Auth::user()->is_cashier ? '#' : route('orders.analytics') }}"
                        class=" stretched-link @if (Auth::user()->is_cashier) cursor-not-allowed @endif"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/square.webp') }}" height="100" class="mb-3" alt="square">

                    <h3>@lang('Recipe')</h3>
                    <a href="{{ route('recipe.index') }}" class="stretched-link"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/shops.webp') }}" height="100" class="mb-3" alt="shops">
                    <h3>@lang('Suppliers')</h3>
                    <a href="{{ route('suppliers.index') }}" class=" stretched-link"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/square.webp') }}" height="100" class="mb-3" alt="square">

                    <h3>@lang('Categories')</h3>
                    <a href="{{ route('categories.index') }}" class="stretched-link"></a>
                </div>
            </x-card>
        </div>
        <!-- <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/inventory.jfif') }}" height="100" class="mb-3" alt="box">
                    <h3>@lang('Inventories')</h3>
                    <a href="{{ route('inventory.index') }}" class="stretched-link"></a>
                </div>
            </x-card>
        </div> -->
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/box.webp') }}" height="100" class="mb-3" alt="box">
                    <h3>@lang('Items')</h3>
                    <a href="{{ route('items.index') }}" class="stretched-link"></a>
                </div>
            </x-card> 
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/group.webp') }}" height="100" class="mb-3" alt="group">
                    <h3>@lang('Customers')</h3>
                    <a href="{{ route('customers.index') }}" class="stretched-link"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/group.webp') }}" height="100" class="mb-3" alt="group">
                    <h3>@lang('Employees')</h3>
                    <a href="{{ route('employees.index') }}" class="stretched-link"></a>
                </div>
            </x-card>
        </div>
        
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/credit-card.webp') }}" height="100" class="mb-3" alt="card">
                    <h3>@lang('Payments')</h3>
                    <a href="{{ route('payments.index') }}" class=" stretched-link"></a>
                </div>
            </x-card>
        </div>

        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/calculator.webp') }}" height="100" class="mb-3" alt="calculator">
                    <h3>@lang('Expenses')</h3>
                    <a href="{{ route('expenses.index') }}" class=" stretched-link"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/shopping-bag.webp') }}" height="100" class="mb-3" alt="bag">
                    <h3>@lang('Purchases')</h3>
                    <a href="{{ route('purchases.index') }}" class=" stretched-link"></a>
                </div>
            </x-card>
        </div>

        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/gear.webp') }}" height="100" class="mb-3" alt="gear">
                    <h3>@lang('Settings')</h3>
                    <a href="{{ Auth::user()->is_cashier ? '#' : route('settings.show') }}"
                        class=" stretched-link @if (Auth::user()->is_cashier) cursor-not-allowed @endif"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/profile.webp') }}" height="100" class="mb-3" alt="profile">
                    <h3>@lang('User Manager')</h3>
                    <a href="{{ Auth::user()->is_cashier ? '#' : route('users.index') }}"
                        class="stretched-link @if (Auth::user()->is_cashier) cursor-not-allowed @endif"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/user1.webp') }}" height="100" class="mb-3" alt="user">
                    <h3>@lang('Profile')</h3>
                    <a href="{{ route('profile.show') }}" class=" stretched-link"></a>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/lock.webp') }}" height="100" class="mb-3" alt="user">
                    <h3>@lang('Security')</h3>
                    <a href="{{ route('password.show') }}" class=" stretched-link"></a>
                </div>
            </x-card>
        </div>
        {{-- <div class="col-md-4 mb-3 d-flex align-items-stretch">
           <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/info.webp') }}" height="100" class="mb-3" alt="info">
                    <h3>@lang('About')</h3>
                    <a href="{{ route('about') }}" class=" stretched-link"></a>
                </div>
            </div>
        </div> --}}
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <x-card class="clickable-cell">
                <div class="text-center">
                    <img src="{{ asset('images/webp/logout.webp') }}" height="100" class="mb-3" alt="logout">
                    <h3>@lang('Logout')</h3>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();"
                        class=" stretched-link"></a>
                    <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
            </x-card>
        </div>
    </div>
@endsection
