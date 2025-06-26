<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COSPLATFORM')</title>
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    @stack('styles')
</head>

<body>
    @include('partials.admin-header')

    @yield('content')

    <script src="{{ asset('js/admin-script.js') }}"></script>
    @stack('scripts')
</body>

</html>