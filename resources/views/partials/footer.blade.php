<footer class="py-8 text-white bg-gray-800">
    <div class="container px-6 mx-auto">
        <div class="flex flex-col items-center justify-between mb-8 text-center md:flex-row md:text-left">

            {{-- 1. ロゴ --}}
            <div class="flex items-center footer-logo">
                @if($logoImg)
                    <img src="{{ asset($logoImg->FILE_PATH . $logoImg->FILE_NAME) }}" alt="{{ $logoImg->ALT }}"
                        class="w-10 h-10 mr-4">
                @else
                    <span class="text-xl font-semibold">COSPLATFORM</span>
                @endif
            </div>

            {{-- 2. ナビゲーションリンク --}}
            <nav class="flex flex-wrap justify-center gap-4 my-6 md:my-0 md:gap-6">
                <a href="{{ route('home') }}" class="text-gray-300 no-underline transition hover:text-pink-400">TOP</a>
                <a href="{{ route('about') }}"
                    class="text-gray-300 no-underline transition hover:text-pink-400">ABOUT</a>
                <a href="{{ route('talent') }}"
                    class="text-gray-300 no-underline transition hover:text-pink-400">TALENT</a>
                <a href="{{ route('news.index') }}"
                    class="text-gray-300 no-underline transition hover:text-pink-400">NEWS</a>
                <a href="{{ route('order') }}"
                    class="text-gray-300 no-underline transition hover:text-pink-400">ORDER</a>
                <a href="{{ route('contact') }}"
                    class="text-gray-300 no-underline transition hover:text-pink-400">CONTACT</a>
            </nav>

            {{-- 3. SNSアイコン (ヘッダーと同じデザインに修正) --}}
            <div class="flex gap-4 footer-social">
                <a href="{{ $sns->SNS_1 }}" aria-label="X (Twitter)" target="_blank" rel="noopener"
                    class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-gray-700 rounded-full hover:bg-pink-400 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-white transition-colors duration-300">
                        <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                    </svg>
                </a>
                <a href="{{ $sns->SNS_2 }}" aria-label="Instagram" target="_blank" rel="noopener"
                    class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-gray-700 rounded-full hover:bg-pink-400 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-white transition-colors duration-300">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                    </svg>
                </a>
                <a href="{{ $sns->SNS_3 }}" aria-label="TikTok" target="_blank" rel="noopener"
                    class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-gray-700 rounded-full hover:bg-pink-400 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-white transition-colors duration-300">
                        <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                    </svg>
                </a>
            </div>
        </div>

        {{-- コピーライトとプライバシーポリシー --}}
        <div class="pt-6 mt-6 text-center border-t border-gray-700">
            <p class="mb-2 text-sm text-gray-400">&copy; {{ date('Y') }} COSPLATFORM. All rights reserved.</p>
            <a href="{{ route('privacy-policy') }}" target="_blank" rel="noopener"
                class="text-sm text-gray-400 no-underline transition hover:text-white hover:underline">プライバシーポリシー</a>
        </div>
    </div>
</footer>