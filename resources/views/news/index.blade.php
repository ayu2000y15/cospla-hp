@extends('layouts.app')

@section('title', 'NEWS - コスプラットフォーム株式会社')

@section('content')
    <main class="pt-16">
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ $topImg->FILE_PATH . $topImg->FILE_NAME }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            NEWS
        </h1>
        <div class="container px-4 mx-auto max-w-6xl">
            <div class="p-8 my-16 bg-white/60 text-purple-900 rounded-3xl">

                <div class="space-y-4">
                    @forelse($newsItems as $item)
                        <a href="{{ route('news.show', $item->NEWS_ID) }}" class="block no-underline group text-inherit">
                            <div
                                class="flex flex-col md:flex-row items-start gap-4 p-4 transition duration-300 ease-in-out bg-white bg-opacity-70 border-l-4 border-transparent rounded-lg shadow-sm group-hover:shadow-md group-hover:border-pink-400 group-hover:bg-opacity-100">

                                @php $firstMedia = $item->images->first(); @endphp

                                {{-- サムネイル領域（常に表示し、レイアウトを固定） --}}
                                <div class="relative w-full md:w-48 h-32 flex-shrink-0 rounded-md overflow-hidden bg-gray-200">
                                    @if($firstMedia)
                                        @php
                                            $isVideo = in_array(strtolower(pathinfo($firstMedia->FILE_NAME, PATHINFO_EXTENSION)), ['mp4', 'mov', 'webm']);
                                        @endphp
                                        @if($isVideo)
                                            {{-- 動画の場合 --}}
                                            <video src="{{ asset($firstMedia->FILE_PATH . $firstMedia->FILE_NAME) }}#t=0.1"
                                                class="object-cover w-full h-full" muted loop playsinline preload="metadata"></video>
                                            {{-- 再生アイコンのオーバーレイ --}}
                                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-25 pointer-events-none">
                                                <svg class="w-8 h-8 text-white drop-shadow" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
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
                                            <img src="{{ asset($previewImg->FILE_PATH . $previewImg->FILE_NAME) }}"
                                                alt="ロゴ" class="object-contain w-full h-20">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="w-6 h-6 text-pink-400 transition-transform duration-300 ease-in-out shrink-0 group-hover:translate-x-1">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                    @empty
                        <p class="p-4 text-center text-gray-500">お知らせはまだありません。</p>
                    @endforelse
                </div>

            </div>
        </div>
    </main>
@endsection
