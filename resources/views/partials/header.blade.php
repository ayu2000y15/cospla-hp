<header class="header" id="header">
    <div class="header-container">
        <a href="{{ route('home') }}" class="logo">
            @if($logoImg)
                <img src="{{ $logoImg->FILE_PATH . $logoImg->FILE_NAME }}" alt="{{ $logoImg->ALT }}">
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
            <a href="{{ route('home') }}">TOP</a>
            <a href="{{ route('about') }}">ABOUT</a>
            <a href="{{ route('talent') }}">TALENT</a>
            <a href="{{ route('cosplay') }}">COSPLAY</a>
            <a href="{{ route('contact') }}">CONTACT</a>
        </nav>
        <div class="social-icons">
            <a href="#" aria-label="X (Twitter)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                    <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                </svg>
            </a>
            <a href="#" aria-label="Instagram">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                </svg>
            </a>
            <a href="#" aria-label="TikTok">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                </svg>
            </a>
        </div>
    </div>
</header>