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
                                <a href="{{ route('news.show', $item->NEWS_ID) }}"
                                    class="block no-underline group text-inherit">
                                    <div
                                        class="flex items-center justify-between p-4 transition duration-300 ease-in-out bg-white bg-opacity-70 border-l-4 border-transparent rounded-lg shadow-sm group-hover:shadow-md group-hover:border-pink-400 group-hover:bg-opacity-100">
                                        <div class="flex flex-col md:flex-row md:items-center md:gap-6">
                                            <p class="m-0 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                <time datetime="{{ \Carbon\Carbon::parse($item->POST_DATE)->format('Y-m-d') }}">
                                                    {{ \Carbon\Carbon::parse($item->POST_DATE)->format('Y年n月j日') }}
                                                </time>
                                            </p>
                                            <p class="mt-1 font-semibold text-gray-800 md:mt-0">
                                                {{ $item->TITLE }}
                                            </p>
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