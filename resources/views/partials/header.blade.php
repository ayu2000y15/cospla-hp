<header class="fixed top-0 left-0 right-0 z-50 h-16 bg-white shadow-md bg-opacity-90" id="header">
    <div class="container grid h-full grid-cols-3 px-4 mx-auto">

        {{-- 1. 左列: ロゴ --}}
        <div class="flex items-center justify-start">
            <a href="{{ route('home') }}" class="logo">
                @if($logoImg)
                    <img src="{{ asset($logoImg->FILE_PATH . $logoImg->FILE_NAME) }}" alt="{{ $logoImg->ALT }}"
                        class="h-10 w-auto">
                @else
                    <span class="text-xl font-bold">COSPLATFORM</span>
                @endif
            </a>
        </div>

        {{-- 2. 中央列: PCではナビゲーション / スマホではSNSアイコン --}}
        <div class="flex items-center justify-center">
            {{-- PC用ナビゲーション --}}
            <nav class="items-center justify-center hidden md:flex md:gap-6">
                <a href="{{ route('home') }}" class="font-bold text-gray-600 hover:text-pink-500">TOP</a>
                <a href="{{ route('about') }}" class="font-bold text-gray-600 hover:text-pink-500">ABOUT</a>
                <a href="{{ route('talent') }}" class="font-bold text-gray-600 hover:text-pink-500">TALENT</a>
                <a href="{{ route('news.index') }}" class="font-bold text-gray-600 hover:text-pink-500">NEWS</a>
                <a href="{{ route('works') }}" class="font-bold text-gray-600 hover:text-pink-500">WORKS</a>
                <a href="{{ route('contact') }}" class="font-bold text-gray-600 hover:text-pink-500">CONTACT</a>
            </nav>
            {{-- スマホ用SNSアイコン --}}
            <div class="flex gap-4 md:hidden">
                <a href="{{ $sns->SNS_1 }}" aria-label="X (Twitter)" target="_blank" rel="noopener"
                    class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-gray-700 transition-colors duration-300">
                        <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                    </svg>
                </a>
                <a href="{{ $sns->SNS_2 }}" aria-label="Instagram" target="_blank" rel="noopener"
                    class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-gray-700 transition-colors duration-300">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                    </svg>
                </a>
                <a href="{{ $sns->SNS_3 }}" aria-label="TikTok" target="_blank" rel="noopener"
                    class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-gray-700 transition-colors duration-300">
                        <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                    </svg>
                </a>
            </div>
        </div>

        {{-- 3. 右列: PC用SNSアイコン / スマホ用ハンバーガーメニュー --}}
        <div class="flex items-center justify-end">
            <div class="flex gap-4 hidden md:flex">
                <a href="{{ $sns->SNS_1 }}" aria-label="X (Twitter)" target="_blank" rel="noopener"
                    class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-gray-700 transition-colors duration-300">
                        <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                    </svg>
                </a>
                <a href="{{ $sns->SNS_2 }}" aria-label="Instagram" target="_blank" rel="noopener"
                    class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-gray-700 transition-colors duration-300">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                    </svg>
                </a>
                <a href="{{ $sns->SNS_3 }}" aria-label="TikTok" target="_blank" rel="noopener"
                    class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-gray-700 transition-colors duration-300">
                        <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                    </svg>
                </a>
            </div>
            <div class="md:hidden">
                <button class="menu-toggle" aria-label="メニューを開く" aria-expanded="false">
                    <span class="block w-6 h-0.5 my-1 transition-transform duration-300 bg-gray-700"></span>
                    <span class="block w-6 h-0.5 my-1 transition-transform duration-300 bg-gray-700"></span>
                    <span class="block w-6 h-0.5 my-1 transition-transform duration-300 bg-gray-700"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Navigation (Dropdown) --}}
    <nav id="main-nav-mobile" class="absolute top-16 left-0 z-40 flex-col w-full bg-white shadow-lg md:hidden"
        style="display: none;">
        <a href="{{ route('home') }}" class="block px-4 py-3 font-bold text-gray-600 hover:bg-gray-100">TOP</a>
        <a href="{{ route('about') }}" class="block px-4 py-3 font-bold text-gray-600 hover:bg-gray-100">ABOUT</a>
        <a href="{{ route('talent') }}" class="block px-4 py-3 font-bold text-gray-600 hover:bg-gray-100">TALENT</a>
        <a href="{{ route('news.index') }}" class="block px-4 py-3 font-bold text-gray-600 hover:bg-gray-100">NEWS</a>
        <a href="{{ route('works') }}" class="block px-4 py-3 font-bold text-gray-600 hover:bg-gray-100">WORKS</a>
        <a href="{{ route('contact') }}" class="block px-4 py-3 font-bold text-gray-600 hover:bg-gray-100">CONTACT</a>
    </nav>
</header>