<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=SEO コスプラットフォーム株式会社はタレントマネジメント、衣装販売、レンタル、製作を行っています。 />
    <title>@yield('title', 'COSPLATFORM')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
