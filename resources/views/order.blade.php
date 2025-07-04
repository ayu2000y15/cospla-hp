@extends('layouts.app')

@section('title', 'ORDER - コスプラットフォーム株式会社')

@section('content')
    <main class="pt-16">
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            DRESS ORDER
        </h1>
        <div class="container px-4 mx-auto max-w-6xl">
            <div class="p-8 my-16 bg-white/60 text-purple-900 rounded-3xl">
                <section class="order-page">
                    <div class="p-6 bg-gradient-to-r from-blue-100 to-blue-200">
                        <h2 class="text-3xl font-bold text-center text-blue-800 drop-shadow-sm">オーダーメイド衣装製作</h2>
                    </div>
                    <div class="p-8 text-center">
                        <p class="mb-6 leading-relaxed text-gray-600">
                            コスプレやアイドルの衣装、カフェの制服など<br>お客様のご要望に合わせたオーダーメイドの衣装を製作いたします。</p>
                        <a href="{{ route('contact') }}"
                            class="inline-block px-6 py-3 font-semibold text-white transition-transform duration-300 bg-blue-500 rounded-full shadow-md hover:bg-blue-600 hover:scale-105">
                            制作に関するご相談はこちら
                        </a>
                    </div>
                    <div class="grid grid-cols-1 gap-8 mt-8 sm:grid-cols-2 md:grid-cols-3">
                        @foreach($cosplayImg1 as $img)
                            <div class="overflow-hidden rounded-lg shadow-lg">
                                <img src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt="{{ $img->ALT }}"
                                    class="object-cover w-full h-72">
                            </div>
                        @endforeach
                    </div>

                </section>
            </div>
        </div>
    </main>
@endsection