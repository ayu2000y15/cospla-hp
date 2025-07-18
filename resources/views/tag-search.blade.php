@extends('layouts.app')

@section('title', '#' . $tag->TAG_NAME . ' の検索結果 - コスプラットフォーム株式会社')

@section('content')
    <main class="pt-16">
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ $topImg ? asset($topImg->FILE_PATH . $topImg->FILE_NAME) : '' }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            #{{ $tag->TAG_NAME }}
        </h1>

        <div class="container px-4 mx-auto max-w-6xl">
            <div x-data="{ activeTab: 'talent' }" class="p-8 my-16 bg-white/60 text-purple-900 rounded-3xl">

                {{-- Tab Navigation --}}
                <div class="border-b border-gray-300 flex justify-center">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click.prevent="activeTab = 'talent'"
                            :class="{ 'border-purple-500 text-purple-600': activeTab === 'talent', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'talent' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg">
                            タレント ({{ $talents->count() }})
                        </button>
                        <button @click.prevent="activeTab = 'news'"
                            :class="{ 'border-purple-500 text-purple-600': activeTab === 'news', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'news' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg">
                            お知らせ ({{ $news->count() }})
                        </button>
                    </nav>
                </div>

                {{-- Tab Content --}}
                <div class="mt-8">
                    {{-- Talents Tab --}}
                    <div x-show="activeTab === 'talent'" x-cloak>
                        @if($talents->isNotEmpty())
                            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                                @foreach($talents as $talent)
                                    <div class="flex flex-col items-center mb-4 text-center">
                                        <form action="{{ route('talent.show') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $talent->TALENT_ID }}">
                                            <div class="relative w-full mb-4" style="padding-top: 133.33%;">
                                                <div class="absolute inset-0">
                                                    @php
                                                        $image1 = $talent->images()->where('VIEW_FLG', '01')->first();
                                                    @endphp
                                                    <img class="absolute inset-0 object-cover w-full h-full p-2.5 rounded-2xl"
                                                        style="background: linear-gradient(to right, #ffd1dc, #e6e6fa);"
                                                        src="{{ $image1 ? asset($image1->FILE_PATH . $image1->FILE_NAME) : '' }}"
                                                        alt="{{ $image1 ? $image1->COMMENT : '' }}">
                                                    <button type="submit"
                                                        class="absolute inset-0 w-full h-full bg-transparent border-none cursor-pointer"></button>
                                                </div>
                                            </div>
                                        </form>
                                        <h2 class="text-xl font-semibold break-words md:text-2xl">{{ $talent->LAYER_NAME }}</h2>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500">このタグを持つタレントは見つかりませんでした。</p>
                        @endif
                    </div>

                    {{-- News Tab --}}
                    <div x-show="activeTab === 'news'" x-cloak>
                        <div class="space-y-4">
                            @forelse($news as $item)
                                @php
                                    $firstMedia = $item->images->first();
                                    $hasVideo = $firstMedia && in_array(strtolower(pathinfo($firstMedia->FILE_NAME, PATHINFO_EXTENSION)), ['mp4', 'mov', 'webm']);
                                @endphp
                                <a href="{{ route('news.show', $item->NEWS_ID) }}"
                                    class="block no-underline group text-inherit @if($hasVideo) video-thumbnail-container @endif">
                                    <div
                                        class="flex flex-col md:flex-row items-start gap-4 p-4 transition duration-300 ease-in-out bg-white bg-opacity-70 border-l-4 border-transparent rounded-lg shadow-sm group-hover:shadow-md group-hover:border-pink-400 group-hover:bg-opacity-100">

                                        {{-- サムネイル領域（常に表示し、レイアウトを固定） --}}
                                        <div
                                            class="relative w-full md:w-48 h-32 flex-shrink-0 rounded-md overflow-hidden bg-gray-200">
                                            @if($firstMedia)
                                                @if($hasVideo)
                                                    {{-- 動画の場合 --}}
                                                    <video src="{{ asset($firstMedia->FILE_PATH . $firstMedia->FILE_NAME) }}#t=0.1"
                                                        class="object-cover w-full h-full" muted playsinline preload="metadata"></video>
                                                    {{-- 再生アイコンのオーバーレイ --}}
                                                    <div
                                                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-25 pointer-events-none transition-opacity duration-300 group-hover:opacity-0">
                                                        <svg class="w-8 h-8 text-white drop-shadow" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                @else
                                                    {{-- 画像の場合 --}}
                                                    <img src="{{ asset($firstMedia->FILE_PATH . $firstMedia->FILE_NAME) }}"
                                                        alt="{{ $item->TITLE }}" class="object-cover w-full h-full">
                                                @endif
                                            @else
                                                {{-- メディアがない場合のプレースホルダー --}}
                                                <div class="flex items-center justify-center w-full h-full bg-white">
                                                    <img src="{{ asset($previewImg->FILE_PATH . $previewImg->FILE_NAME) }}" alt="ロゴ"
                                                        class="object-contain w-full h-20">
                                                </div>
                                            @endif
                                        </div>

                                        {{-- テキストコンテンツ --}}
                                        <div class="flex-grow">
                                            <p class="m-0 text-sm font-medium text-gray-500">
                                                <time datetime="{{ \Carbon\Carbon::parse($item->POST_DATE)->format('Y-m-d') }}">
                                                    {{ \Carbon\Carbon::parse($item->POST_DATE)->format('Y/m/d') }}
                                                </time>
                                            </p>
                                            <p class="mt-1 font-semibold text-gray-800">
                                                {{ $item->TITLE }}
                                            </p>
                                            @if($item->tags->isNotEmpty())
                                                <div class="flex flex-wrap items-center gap-2 mt-2">
                                                    @foreach($item->tags as $tag)
                                                        <span class="px-2 py-1 text-xs font-medium text-white rounded-full"
                                                            style="background-color: {{ $tag->TAG_COLOR }};">
                                                            {{ $tag->TAG_NAME }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="w-6 h-6 text-pink-400 transition-transform duration-300 ease-in-out shrink-0 group-hover:translate-x-1">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </div>
                                </a>
                            @empty
                                <p class="text-center text-gray-500">このタグを持つお知らせは見つかりませんでした。</p>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const videoContainers = document.querySelectorAll('.video-thumbnail-container');

            videoContainers.forEach(container => {
                const video = container.querySelector('video');
                if (video) {
                    container.addEventListener('mouseenter', () => {
                        video.play();
                    });
                    container.addEventListener('mouseleave', () => {
                        video.pause();
                        video.currentTime = 0;
                    });
                }
            });
        });
    </script>
@endpush