@extends('layouts.app')

@section('title', 'CONTACT - コスプラットフォーム株式会社')

@section('content')
    <main>
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            CONTACT
        </h1>
        <div class="container px-4 mx-auto max-w-6xl">
            <div class="p-8 my-16 bg-white/60 text-purple-900 rounded-3xl">
                <h2 class="text-center text-2xl font-bold mb-6">お問い合わせフォーム</h2>
                <form class="max-w-2xl mx-auto flex flex-col gap-6" action="{{ route('contact.confirm') }}" method="POST">
                    @if (session('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @csrf
                    <div class="flex flex-col">
                        <label for="CONTACT_CATEGORY_ID" class="mb-2 font-bold">問い合わせ項目</label>
                        <select name="CONTACT_CATEGORY_ID" id="CONTACT_CATEGORY_ID" required
                            class="p-3 border border-gray-300 rounded-md text-base">
                            @foreach ($contactCategories as $select)
                                <option value="{{ $select['CONTACT_CATEGORY_ID'] }}">
                                    {{ $select['CONTACT_CATEGORY_NAME'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="name" class="mb-2 font-bold">氏名<span class="ml-2 text-pink-500">必須</span></label>
                        <input type="text" id="name" name="NAME" placeholder="山田太郎" required
                            class="p-3 border border-gray-300 rounded-md text-base" />
                    </div>
                    <div class="flex flex-col">
                        <label for="age" class="mb-2 font-bold">年齢</label>
                        <input type="text" id="age" name="AGE" placeholder="25"
                            class="p-3 border border-gray-300 rounded-md text-base" />
                    </div>
                    <div class="flex flex-col">
                        <label for="email" class="mb-2 font-bold">メールアドレス<span class="ml-2 text-pink-500">必須</span></label>
                        <input type="email" id="email" name="MAIL" placeholder="example@gmail.com" required
                            class="p-3 border border-gray-300 rounded-md text-base" />
                    </div>
                    <div class="flex flex-col">
                        <label for="tel" class="mb-2 font-bold">電話番号</label>
                        <input type="tel" id="tel" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" name="TEL"
                            placeholder="080-1234-5678" class="p-3 border border-gray-300 rounded-md text-base" />
                    </div>
                    <div class="flex flex-col">
                        <label for="subject" class="mb-2 font-bold">件名<span class="ml-2 text-pink-500">必須</span></label>
                        <input type="text" id="subject" name="SUBJECT" placeholder="例、衣装制作について" required
                            class="p-3 border border-gray-300 rounded-md text-base" />
                    </div>
                    <div class="flex flex-col">
                        <label for="content" class="mb-2 font-bold">質問内容 または 自己PR等<span
                                class="ml-2 text-pink-500">必須</span></label>
                        ※タレント応募の場合、SNSアカウントがあればこちらに記載してください
                        <textarea id="content" name="CONTENT" rows="5" placeholder="問い合わせ内容をここに記載してください" required
                            class="p-3 border border-gray-300 rounded-md text-base"></textarea>
                    </div>
                    <button type="submit"
                        class="px-8 py-2 text-base bg-white border-2 border-purple-700 rounded-full cursor-pointer text-purple-700 transition-colors hover:bg-purple-700 hover:text-white">お問い合わせ内容の確認へ</button>
                </form>
            </div>
        </div>
    </main>
@endsection