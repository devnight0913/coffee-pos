<!DOCTYPE html>
<html lang="{{ $settings->lang }}" dir="{{ $settings->dir }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preload" href="{{ $cssUrl }}" as="style" />
    <link rel="stylesheet" href="{{ $cssUrl }}">
    @stack('style')
    @stack('head')
</head>

<body>
    <div class="container-fluid py-2">
        @yield('content')
    </div>
</body>

</html>
@stack('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    });
</script>
