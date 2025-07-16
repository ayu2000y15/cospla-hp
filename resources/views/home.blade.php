@extends('layouts.app')

@section('title', 'TOP - コスプラットフォーム株式会社')

@section('content')
    <main class="pt-16">
        <div id="back" class="bg-white">
            <section class="relative w-full pt-[56.25%]">
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden slideshow-container">
                    {{-- 各スライドに `slide` クラスを追加 --}}
                    @foreach($slides as $index => $slide)
                        <div
                            class="absolute top-0 left-0 w-full h-full duration-700 ease-in-out transition-opacity slide @if($index > 0) hidden opacity-0 @else block opacity-100 @endif">
                            <div class="w-full h-full">
                                <img src="{{ asset($slide->FILE_PATH . $slide->FILE_NAME) }}" alt="{{ $slide->ALT }}"
                                    class="object-cover w-full h-full">
                            </div>
                        </div>
                    @endforeach
                    {{-- 操作ボタン --}}
                    <a class="absolute p-4 text-lg font-bold text-white -translate-y-1/2 bg-black bg-opacity-30 rounded-r-md cursor-pointer select-none prev top-1/2 hover:bg-opacity-80 transition-colors"
                        onclick="plusSlides(-1)">&#10094;</a>
                    <a class="absolute p-4 text-lg font-bold text-white -translate-y-1/2 bg-black bg-opacity-30 rounded-l-md cursor-pointer select-none next top-1/2 right-0 hover:bg-opacity-80 transition-colors"
                        onclick="plusSlides(1)">&#10095;</a>
                </div>
                {{-- インジケーター --}}
                <div class="absolute text-center -translate-x-1/2 bottom-5 left-1/2 dot-container">
                    @for($i = 0; $i < $slidesCnt; $i++)
                        <span
                            class="inline-block w-4 h-4 mx-1 bg-gray-400 rounded-full cursor-pointer dot transition-colors @if($i == 0) active @endif"
                            onclick="currentSlide({{ $i + 1 }})"></span>
                    @endfor
                </div>
            </section>

            <section class="relative w-full pt-[56.25%]">
                @foreach($topImg as $img)
                    <img src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt="{{ $img->ALT }}"
                        class="absolute top-0 left-0 object-cover w-full h-full">
                @endforeach
            </section>

            <section id="talent" class="max-w-6xl px-4 py-8 mx-auto my-0 text-center text-blue-400 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-3xl font-bold">TALENT</h2>

                {{-- レスポンシブ対応のレイアウトに変更 --}}
                <div class="flex flex-col items-center md:flex-row md:items-stretch">

                    {{-- タレント一覧グリッド --}}
                    <div class="w-full md:flex-grow md:mr-8">
                        <div class="grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-4">
                            @foreach($talent as $t)
                                <div class="flex flex-col items-center text-center">
                                    {{-- フォームでラップしてクリックで遷移可能にする --}}
                                    <form action="{{ route('talent.show') }}" method="POST" class="w-full">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $t->TALENT_ID }}">
                                        {{-- ボタン化してフォームを送信 --}}
                                        <button type="submit"
                                            class="p-0 text-left bg-transparent border-none cursor-pointer group">
                                            <div class="overflow-hidden rounded-lg">
                                                <img style="background: linear-gradient(180deg, rgba(255, 255, 255, 1), rgba(216, 236, 255, 1) 100%, rgba(149, 233, 243, 1));"
                                                    class="w-full h-auto object-cover mb-2 rounded-lg p-2.5 max-w-[180px] sm:max-w-none sm:w-48 sm:h-60 transition-transform duration-300 ease-in-out group-hover:scale-105"
                                                    src="{{ asset($t->FILE_PATH . $t->FILE_NAME) }}" alt="タレント {{ $t->ALT }}">
                                            </div>
                                            <p class="mt-1 text-center font-semibold">{{ $t->LAYER_NAME }}</p>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- 矢印ボタン (スマホでは下に、PCでは右に表示) --}}
                    <div class="flex items-center justify-center w-full mt-8 md:w-auto md:mt-0 md:ml-auto">
                        <a href="{{ route('talent') }}"
                            class="flex items-center justify-center w-16 h-16 bg-pink-500 rounded-full shadow-md transition-transform duration-300 ease-in-out hover:bg-pink-600 hover:scale-110"
                            aria-label="タレント一覧をもっと見る">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="w-8 h-8 text-white">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
        </div>
        <div class="container max-w-6xl px-4 mx-auto my-16 sm:px-6 lg:px-8">
            {{-- NEWSの見出しを白文字に変更 --}}
            <h2 class="mb-4 text-4xl font-bold text-center text-white text-shadow-md">NEWS</h2>
            <section id="news" class="p-6 bg-white bg-opacity-75 md:p-8 rounded-2xl shadow-lg">
                <div class="space-y-4">
                    @forelse($newsTitle->slice(0, 5) as $item)
                        <a href="{{ route('news.show', $item->NEWS_ID) }}" class="block no-underline group text-inherit">
                            <div
                                class="flex items-start gap-4 p-4 transition duration-300 ease-in-out bg-white bg-opacity-50 border-l-4 border-transparent rounded-lg shadow-sm group-hover:shadow-md group-hover:border-pink-400 group-hover:bg-opacity-100">

                                @php $firstMedia = $item->images->first(); @endphp

                                {{-- サムネイル領域（常に表示し、レイアウトを固定） --}}
                                <div class="relative w-24 h-16 md:w-32 md:h-20 flex-shrink-0 rounded-md overflow-hidden bg-gray-200">
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

                                <div class="flex-grow">
                                    <p class="m-0 text-sm font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->POST_DATE)->format('Y/m/d') }}
                                    </p>
                                    <p class="m-0 mt-1 font-semibold text-gray-800">{{ $item->TITLE }}</p>
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
                        <p class="p-4 text-center text-gray-500">新しいニュースはありません。</p>
                    @endforelse
                </div>
                @if(count($newsTitle) > 5)
                    <div class="flex justify-center mt-6">
                        <a href="{{ route('news.index') }}"
                            class="px-6 py-2 text-white bg-pink-500 rounded-full shadow-md hover:bg-pink-600 transition-colors font-semibold">
                            もっと見る
                        </a>
                    </div>
                @endif
            </section>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        /* JavaScriptで操作するためのアクティブクラス */
        .dot.active {
            background-color: #717171;
        }

        .text-shadow-md {
            text-shadow: 2px 2px 4px rgb(0 0 0 / 0.5);
        }
    </style>
@endpush
