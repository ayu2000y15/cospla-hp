<header class="header" id="header">
    <div class="header-container">
        <a href="{{ route('home') }}" class="logo">
            @if($logoImg)
            <img src="{{ asset($logoImg->FILE_PATH . $logoImg->FILE_NAME) }}" alt="{{ $logoImg->ALT }}">
            @else
            COSPLATFORM
            @endif
        </a>
        <button class="menu-toggle" aria-label="メニューを開く" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="main-nav">
            <a href="{{ route('admin') }}">管理画面TOP</a>
            <a href="{{ route('home') }}">hpのTOPに戻る</a>
        </nav>
        <div class="social-icons">

        </div>
    </div>
</header>