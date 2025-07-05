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
                                class="flex items-center justify-between p-4 transition duration-300 ease-in-out bg-white bg-opacity-70 border-l-4 border-transparent rounded-lg shadow-sm group-hover:shadow-md group-hover:border-pink-400 group-hover:bg-opacity-100">
                                <div class="flex-grow">
                                    {{-- ★★★ 変更箇所 ★★★ --}}
                                    <div class="flex flex-col md:flex-row md:items-start md:gap-x-4">
                                        {{-- 投稿日 --}}
                                        <p class="m-0 text-sm font-medium text-gray-500 whitespace-nowrap shrink-0">
                                            <time datetime="{{ \Carbon\Carbon::parse($item->POST_DATE)->format('Y-m-d') }}">
                                                {{ \Carbon\Carbon::parse($item->POST_DATE)->format('Y年n月j日') }}
                                            </time>
                                        </p>
                                        {{-- タイトルとタグをまとめるコンテナ --}}
                                        <div class="flex flex-col">
                                            <p class="mt-1 font-semibold text-gray-800 md:mt-0">
                                                {{ $item->TITLE }}
                                            </p>
                                            {{-- タグ表示部分 --}}
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
                                    </div>
                                    {{-- ★★★ ここまで ★★★ --}}
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