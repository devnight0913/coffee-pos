<!DOCTYPE html>
<html lang="{{ $settings->lang }}" dir="{{ $settings->dir }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="theme-color" content="#000000"/>
    <title>@yield('title', config('app.name'))</title>
    <link rel="preload" href="{{ $cssUrl }}" as="style" />
    <link rel="stylesheet" href="{{ $cssUrl }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('WMKTech.ico') }}">
    <link rel="manifest" href="/manifest.json">
    @include('layouts.lang-tag')
    @stack('style')
    @stack('head')
</head>

<body class="x-body">
    <div class="h-100" id="app">
        @auth
            <div class="x-sidebar border-end bg-white">
                @include('layouts.sidebar-items')
            </div>
            <div class="x-container">
                @include('layouts.navbar')
                <div class="x-container-secondary p-3">
                    @include('layouts.alerts')
                    @yield('content')
                </div>
            </div>
        @else
            @yield('content')
        @endauth
    </div>
</body>

</html>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/vfs_fonts.js') }}"></script>
<script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            // Registration was successful
            console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            // registration failed :(
            console.log('Laravel PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>
@stack('script')
