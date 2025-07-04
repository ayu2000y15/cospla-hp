@extends('layouts.app')

@section('title', 'WORKS - コスプラットフォーム株式会社')

@push('scripts')
    {{-- Alpine.jsは重複して読み込まないように、レイアウトファイルで一度だけ読み込むのが理想です --}}
    {{--
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
@endpush

@section('content')
    <main class="pt-16">
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ $topImg ? asset($topImg->FILE_PATH . $topImg->FILE_NAME) : '' }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            COSTUME WORKS
        </h1>

        <div class="container px-4 mx-auto max-w-6xl">
            <div class="p-8 my-16 bg-white/60 text-purple-900 rounded-3xl">
                <section class="order-page space-y-12">
                    {{-- 静的コンテンツ - カードデザインを削除 --}}
                    <div class="text-center space-y-6">
                        <h2 class="text-3xl font-bold text-purple-800 drop-shadow-sm">オーダーメイド衣装制作</h2>
                        <p class="text-lg leading-relaxed text-gray-700 max-w-3xl mx-auto">
                            コスプレやアイドルの衣装、カフェの制服など<br>お客様のご要望に合わせたオーダーメイドの衣装を制作いたします。
                        </p>
                        <a href="{{ route('contact') }}"
                            class="inline-block px-8 py-3 font-semibold text-white transition-transform duration-300 bg-purple-500 rounded-full shadow-md hover:bg-purple-600 hover:scale-105">
                            制作に関するご相談はこちら
                        </a>
                    </div>

                    {{-- 動的に表示されるグループ一覧 --}}
                    @forelse($clients as $client)
                        <div class="pt-8 border-t border-purple-200">
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-bold text-purple-800 drop-shadow-sm mb-3">{{ $client->client_name }}
                                </h3>
                                @if($client->description)
                                    <p class="text-gray-600 leading-relaxed">{!! nl2br(e($client->description)) !!}</p>
                                @endif
                            </div>

                            {{-- SNSアイコンを中央に配置 --}}
                            <div class="flex justify-center items-center gap-4 mb-6">
                                @if($client->homepage_url)
                                    <a href="{{ $client->homepage_url }}" target="_blank" rel="noopener" aria-label="ホームページ"
                                        class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                                        <svg class="w-5 h-5 text-gray-700 transition-colors duration-300 group-hover:text-white"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.72"></path>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.72-1.72"></path>
                                        </svg>
                                    </a>
                                @endif
                                @if($client->sns_x)
                                    <a href="{{ $client->sns_x }}" aria-label="X (Twitter)" target="_blank" rel="noopener"
                                        class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                                        <svg class="w-5 h-5 text-gray-700 transition-colors duration-300 group-hover:text-white"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                            <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                                        </svg>
                                    </a>
                                @endif
                                @if($client->sns_instagram)
                                    <a href="{{ $client->sns_instagram }}" aria-label="Instagram" target="_blank" rel="noopener"
                                        class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                                        <svg class="w-5 h-5 text-gray-700 transition-colors duration-300 group-hover:text-white"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                                        </svg>
                                    </a>
                                @endif
                                @if($client->sns_tiktok)
                                    <a href="{{ $client->sns_tiktok }}" aria-label="TikTok" target="_blank" rel="noopener"
                                        class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                                        <svg class="w-5 h-5 text-gray-700 transition-colors duration-300 group-hover:text-white"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            {{-- 画像スライダー --}}
                            @if($client->images->isNotEmpty())
                                <div class="relative max-w-3xl mx-auto" x-data="{
                                                                                                                 activeSlide: 0,
                                                                                                                 slideCount: {{ $client->images->count() }},
                                                                                                                 interval: null,
                                                                                                                 startAutoSlide() {
                                                                                                                     if (this.slideCount > 1) {
                                                                                                                         this.interval = setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slideCount }, 5000);
                                                                                                                     }
                                                                                                                 },
                                                                                                                 stopAutoSlide() {
                                                                                                                     clearInterval(this.interval);
                                                                                                                 },
                                                                                                                 restartAutoSlide() {
                                                                                                                     this.stopAutoSlide();
                                                                                                                     this.startAutoSlide();
                                                                                                                 }
                                                                                                             }"
                                    x-init="startAutoSlide()">

                                    <div class="relative w-full overflow-hidden bg-transparent rounded-xl ">
                                        <div class="w-full aspect-[4/3]">
                                            @foreach($client->images as $index => $image)
                                                <div x-show="activeSlide === {{ $index }}" class="absolute inset-0 w-full h-full"
                                                    x-cloak>
                                                    <img src="{{ asset($image->file_path . $image->file_name) }}"
                                                        alt="{{ $image->alt_text }}" class="object-contain w-full h-full">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    @if($client->images->count() > 1)
                                        <button @click="activeSlide = (activeSlide - 1 + slideCount) % slideCount; restartAutoSlide();"
                                            class="absolute top-1/2 left-3 transform -translate-y-1/2 bg-purple-600 bg-opacity-80 text-white rounded-full p-3 hover:bg-opacity-100 transition-all duration-300 z-10 shadow-lg"
                                            aria-label="前の画像へ">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <button @click="activeSlide = (activeSlide + 1) % slideCount; restartAutoSlide();"
                                            class="absolute top-1/2 right-3 transform -translate-y-1/2 bg-purple-600 bg-opacity-80 text-white rounded-full p-3 hover:bg-opacity-100 transition-all duration-300 z-10 shadow-lg"
                                            aria-label="次の画像へ">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>

                                        {{-- インジケーター --}}
                                        <div class="flex justify-center mt-4 space-x-2">
                                            @foreach($client->images as $index => $image)
                                                <button @click="activeSlide = {{ $index }}; restartAutoSlide();"
                                                    class="w-3 h-3 rounded-full transition-all duration-300"
                                                    :class="activeSlide === {{ $index }} ? 'bg-purple-600' : 'bg-purple-300 hover:bg-purple-400'"
                                                    aria-label="画像{{ $index + 1 }}を表示">
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">現在、公開中の制作実績はありません。</p>
                        </div>
                    @endforelse
                </section>
            </div>
        </div>
    </main>
@endsection