<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="コスプラットフォーム株式会社はタレントマネジメント、衣装販売、レンタル、製作を行っています。" />
    <meta name="google-site-verification" content="LoQ0AmXHnOUbDWgeVG6_3pQ3IrjdvqnRjp4zD7RP7NM" />
    <title>@yield('title', 'COSPLATFORM')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- style.cssはTailwindに移行したため不要であれば削除 --}}
    {{--
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    @stack('styles')
</head>
{{-- 多くのページで共通の背景画像が指定されているため、ここで動的に設定 --}}

<body @if(isset($backImg)) style="background-image: url('{{ asset($backImg->FILE_PATH . $backImg->FILE_NAME) }}')"
    @endif class="font-noto-sans text-gray-800 bg-white bg-cover bg-center bg-fixed min-h-screen">
    @include('partials.header')

    <main> {{-- ヘッダーの高さ分paddingを追加 --}}
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>

</html>