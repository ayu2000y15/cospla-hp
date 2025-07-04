@extends('layouts.app')

@section('title', 'お問い合わせ内容確認 - コスプラットフォーム株式会社')

@section('content')
    <main>
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            お問い合わせ内容確認
        </h1>
        <div class="container px-4 mx-auto max-w-6xl">
            <div class="p-8 my-16 bg-white/60 text-purple-900 rounded-3xl">

                <h2 class="text-center text-2xl font-bold mb-6">入力内容をご確認ください</h2>
                @if (session('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <form class="max-w-2xl mx-auto" action="{{ route('contact.send') }}" method="POST"
                    onsubmit="return checkSubmit();">
                    @csrf
                    <input type="hidden" name="CONTACT_CATEGORY_ID" value="{{ $contactCategory['CONTACT_CATEGORY_ID'] }}">
                    <input type="hidden" name="CONTACT_CATEGORY_NAME"
                        value="{{ $contactCategory['CONTACT_CATEGORY_NAME'] }}">

                    @foreach(['NAME', 'MAIL', 'TEL', 'AGE', 'SUBJECT', 'CONTENT'] as $field)
                        <input type="hidden" name="{{ $field }}" value="{{ $contact[$field] }}">
                    @endforeach

                    <div class="pb-2 mb-4 border-b border-gray-300">
                        <label class="block mb-2 text-sm font-bold">問い合わせ項目</label>
                        <p class="ml-12 text-xl text-black">{{ $contactCategory['CONTACT_CATEGORY_NAME'] }}</p>
                    </div>
                    <div class="pb-2 mb-4 border-b border-gray-300">
                        <label class="block mb-2 text-sm font-bold">氏名</label>
                        <p class="ml-12 text-xl text-black">{{ $contact['NAME'] }}</p>
                    </div>
                    <div class="pb-2 mb-4 border-b border-gray-300">
                        <label class="block mb-2 text-sm font-bold">年齢</label>
                        <p class="ml-12 text-xl text-black">{{ $contact['AGE'] ?: '未入力' }}</p>
                    </div>
                    <div class="pb-2 mb-4 border-b border-gray-300">
                        <label class="block mb-2 text-sm font-bold">メールアドレス</label>
                        <p class="ml-12 text-xl text-black">{{ $contact['MAIL'] }}</p>
                    </div>
                    <div class="pb-2 mb-4 border-b border-gray-300">
                        <label class="block mb-2 text-sm font-bold">電話番号</label>
                        <p class="ml-12 text-xl text-black">{{ $contact['TEL'] ?: '未入力' }}</p>
                    </div>
                    <div class="pb-2 mb-4 border-b border-gray-300">
                        <label class="block mb-2 text-sm font-bold">件名</label>
                        <p class="ml-12 text-xl text-black">{{ $contact['SUBJECT'] }}</p>
                    </div>
                    <div class="pb-2 mb-4 border-b border-gray-300">
                        <label class="block mb-2 text-sm font-bold">質問内容 または 自己PR等</label>
                        <p class="ml-12 text-xl text-left text-black">{!! nl2br(e($contact['CONTENT'])) !!}</p>
                    </div>
                    <div class="flex items-center mt-5">
                        <label class="flex items-center text-base">
                            <input type="checkbox" name="privacy_policy" required class="mr-2.5">
                            <a href="{{ route('privacy-policy') }}" target="_blank" rel="noopener"
                                class="text-blue-500 underline">プライバシーポリシー</a>に同意する
                        </label>
                    </div>
                    <div class="flex justify-center gap-4 mt-6">
                        <button type="button"
                            class="px-8 py-2 text-base bg-white border-2 border-purple-700 rounded-full cursor-pointer text-purple-700 transition-colors hover:bg-purple-700 hover:text-white"
                            onclick="history.back();">修正する</button>
                        <button type="submit"
                            class="px-8 py-2 text-base bg-white border-2 border-purple-700 rounded-full cursor-pointer text-purple-700 transition-colors hover:bg-purple-700 hover:text-white">送信する</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection